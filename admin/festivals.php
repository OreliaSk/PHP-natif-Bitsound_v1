<?php
// on inclu la config
require_once('../includes/config.php');

// Si pas connecté, renvoi vers page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

// Message de ajouter/éditer
if(isset($_GET['delfestival'])){ 

	// Récupération edit/add pages
	if(isset($_GET['delfestival'])){

		$stmt = $db->prepare('DELETE FROM blog_festivals WHERE festivalId = :festivalId') ;
		$stmt->execute(array(':festivalId' => $_GET['delfestival']));

		header('Location: festivals.php?action=deleted');
		exit;
	}
} 

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Festivals</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  // Fonction javascript pour pop-up confirmation suppression
  function delfestival(id, pseudo)
  {
	  if (confirm("Etes-vous sûr(e) de vouloir supprimer le festival '" + pseudo + "'"))
	  {
	  	window.location.href = 'festivals.php?delfestival=' + id;
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
		<th>Nom du festival</th>
		<th>Description</th>
		<th>Contenu</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT festivalId, title, description, content FROM blog_festivals ORDER BY title');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['title'].'</td>';
				echo '<td>'.substr($row['description'], 0, 100).' ...</td>';
				echo '<td>'.substr($row['content'], 0, 100).' ...</td>';
				?>

				<td>
					<a href="edit-festival.php?id=<?php echo $row['festivalId'];?>">Editer</a> |
					<a href="javascript:delfestival('<?php echo $row['festivalId'];?>','<?php echo $row['title'];?>')">Supprimer</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-festival.php'>Ajouter un festival</a></p>

</div>

</body>
</html>
