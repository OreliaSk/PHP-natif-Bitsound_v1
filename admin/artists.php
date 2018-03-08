<?php
// on inclu la config
require_once('../includes/config.php');

// Si pas connecté, renvoi vers page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

// Message de ajouter/éditer
if(isset($_GET['delartist'])){ 

	// Récupération edit/add pages
	if(isset($_GET['delartist'])){

		$stmt = $db->prepare('DELETE FROM blog_artists WHERE artistId = :artistId') ;
		$stmt->execute(array(':artistId' => $_GET['delartist']));

		header('Location: artists.php?action=deleted');
		exit;
	}
} 

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Artistes</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  // Fonction javascript pour pop-up confirmation suppression
  function delartist(id, pseudo)
  {
	  if (confirm("Etes-vous sûr(e) de vouloir supprimer l'artiste '" + pseudo + "'"))
	  {
	  	window.location.href = 'artists.php?delartist=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>User '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>

	<tr>
		<th>Pseudo</th>
		<th>Prénom</th>
		<th>Nom</th>
		<th>Desciption</th>
		<th>Biographie</th>
		<th>Genre musical</th>
		<th>Photographies</th>
		<th>Lien Soundcloud</th>
		<th>Vidéos</th>
		<th>Opération</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT artistId, pseudo, first_name, last_name, description, content, genre, picture, website, video FROM blog_artists ORDER BY pseudo');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['pseudo'].'</td>';
				echo '<td>'.$row['first_name'].'</td>';
				echo '<td>'.$row['last_name'].'</td>';
				echo '<td>'.substr($row['description'], 0, 100).' ...</td>';
				echo '<td>'.substr($row['content'], 0, 100).' ...</td>';
				echo '<td>'.$row['genre'].'</td>';
				echo '<td>'.$row['picture'].'</td>';
				echo '<td><a href="'.$row['website'].'">'.$row['website'].'<a></td>';
				echo '<td><a href="'.$row['video'].'">'.$row['video'].'<a></td>';
				?>

				<td>
					<a href="edit-artist.php?id=<?php echo $row['artistId'];?>">Editer</a> |
					<a href="javascript:delartist('<?php echo $row['artistId'];?>','<?php echo $row['pseudo'];?>')">Supprimer</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-artist.php'>Ajouter un artiste</a></p>

</div>

</body>
</html>
