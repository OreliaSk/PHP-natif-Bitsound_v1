<?php
// on inclu la config
require_once('../includes/config.php');

// Si pas connecté, renvoi vers page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

// Message de ajouter/éditer
if(isset($_GET['delmessage'])){ 

	// Récupération edit/add pages
	if(isset($_GET['delmessage'])){

		$stmt = $db->prepare('DELETE FROM blog_messages WHERE messageId = :messageId') ;
		$stmt->execute(array(':messageId' => $_GET['delmessage']));

		header('Location: messages.php?action=deleted');
		exit;
	}
} 

?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>Dashboard administrateur - Messages visiteurs</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script language="JavaScript" type="text/javascript">
	// Fonction javascript pour pop-up confirmation suppression
	function delmessage(id, pseudo)
	{
		if (confirm("Etes-vous sûr(e) de vouloir supprimer le message de '" + pseudo + "'"))
		{
			window.location.href = 'messages.php?delmessage=' + id;
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
		<th>Pseudo</th>
		<th>Email</th>
		<th>Message</th>
		<th>Date</th>
		<th>Opération</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT messageId, pseudo, email, content, created_at FROM blog_messages ORDER BY created_at');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['pseudo'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				echo '<td>'.substr($row['content'], 0, 60).' ...</td>';
				echo '<td>'.$row['created_at'].'</td>';
				?>

				<td>
					<a href="read-message.php?id=<?php echo $row['messageId'];?>">Lire le message</a>
					<a href="javascript:delmessage('<?php echo $row['messageId'];?>','<?php echo $row['pseudo'];?>')">Supprimer</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>
	<?php include('menu-footer.php');?>

</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
