<?php
// on inclu le fichier de config
require_once('../includes/config.php');

// si l'admin n'est pas déjà connecté, renvoi vers page connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

// Affichage message des pages edit/add
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard administrateur</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<script language="JavaScript" type="text/javascript">
  // Fonction javascript pour pop-up confirmation suppression
  function delpost(id, title)
  {
	  if (confirm("Êtes-vous sûr(e) de vouloir supprimmer l'article '" + title + "' ?"))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div  class="menu-admin" id="wrapper">

		<?php 
			// Message ajout/édit
			if(isset($_GET['action'])){ 
				echo '<h3>Post '.$_GET['action'].'.</h3>'; 
			} 
		?>
		<?php include('menu-header.php');?>

		<table>
			<tr>
				<th>Titre</th>
				<th>Date</th>
				<th>Opération</th>
			</tr>
			<?php
				try {
					$stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postID DESC');
					while($row = $stmt->fetch()){
						
						echo '<tr>';
						echo '<td>'.$row['postTitle'].'</td>';
						echo '<td>'.date('j M Y', strtotime($row['postDate'])).'</td>';
						?>

						<td>
							<a href="edit-post.php?id=<?php echo $row['postID'];?>">Editer</a> | 
							<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Supprimer</a>
						</td>
						
						<?php 
						echo '</tr>';
					}

				} catch(PDOException $e) {
					echo $e->getMessage();
				}
			?>
		</table>
		<button class="btn btn-custom">
			<a href='add-post.php'>Ajouter un article</a>
		</button>
		<?php include('menu-footer.php');?>

</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
