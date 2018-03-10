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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>Dashboard administrateur - Festivals</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

	<div class="menu-admin" id="wrapper">

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>User '.$_GET['action'].'.</h3>'; 
	} 
	?>
	<?php include('menu-header.php');?>

	<table class="mt-4 mb-4 content-admin">
	<tr>
		<th>Nom du festival</th>
		<th>Description</th>
		<th>Date</th>
		<th>Opération</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT festivalId, title, description, created_at FROM blog_festivals ORDER BY title');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.substr($row['title'], 0, 70).' ...</td>';
				echo '<td>'.substr($row['description'], 0, 70).' ...</td>';
				echo '<td>'.$row['created_at'].'</td>';
				?>

				<td>
					<a href="edit-festival.php?id=<?php echo $row['festivalId'];?>">Editer</a>
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
	<a class="btn btn-custom btn-add" href='add-festival.php'>Ajouter un festival</a>
	<?php include('menu-footer.php');?>

</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
