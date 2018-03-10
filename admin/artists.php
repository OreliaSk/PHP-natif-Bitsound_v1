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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard administrateur - Artistes</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

	<div  class="menu-admin" id="wrapper">

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>User '.$_GET['action'].'.</h3>'; 
	} 
	?>
	<?php include('menu-header.php');?>

	<table class="mt-4 mb-4 content-admin">

	<tr>
		<th>Nom d'artiste</th>
		<th>Desciption</th>
		<th>Genre musical</th>
		<th>Avatar</th>
		<th>Opération</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT artistId, pseudo, description, genre, picture FROM blog_artists ORDER BY pseudo');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['pseudo'].'</td>';
				echo '<td>'.substr($row['description'], 0, 80).' ...</td>';
				echo '<td>'.substr($row['genre'], 0, 50).' ...</td>';
				echo '<td>'.$row['picture'].'</td>';
				?>

				<td>
					<a href="edit-artist.php?id=<?php echo $row['artistId'];?>">Editer</a>
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
	<a class="btn btn-custom btn-add" href='add-artist.php'>Ajouter un artiste</a>

</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
