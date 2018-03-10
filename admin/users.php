<?php
// on inclu la config
require_once('../includes/config.php');

// Si pas connecté, renvoi vers page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

// Message de ajouter/éditer
if(isset($_GET['deluser'])){ 

	// Si l'id de l'utilisateur == 1 -> on ignore
	if($_GET['deluser'] !='1'){

		$stmt = $db->prepare('DELETE FROM blog_members WHERE memberID = :memberID') ;
		$stmt->execute(array(':memberID' => $_GET['deluser']));

		header('Location: users.php?action=deleted');
		exit;

	}
} 

?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard administrateur - Administrateurs</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script language="JavaScript" type="text/javascript">
	function deluser(id, title)
	{
		if (confirm("Are you sure you want to delete '" + title + "'"))
		{
		window.location.href = 'users.php?deluser=' + id;
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
		<th>Pseudo</th>
		<th>Email</th>
		<th>Opération</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT memberID, username, email FROM blog_members ORDER BY username');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				?>

				<td>
					<a href="edit-user.php?id=<?php echo $row['memberID'];?>">Editer</a> 
					<?php if($row['memberID'] != 1){?>
					<a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Supprimer</a>
					<?php } ?>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>
	<a class="btn btn-custom btn-add" href='add-user.php'>Ajouter un administrateur</a>

	<?php include('menu-footer.php');?>


</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
