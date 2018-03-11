<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

// Si l'article à afficher n'existe pas, on redirige vers l'index
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('partials/head.php');?>
    <title>Article - <?php echo $row['postTitle'];?></title>
</head>
<body>

	<div class="container-fluid wrapper-post" id="wrapper">
		<div class="container artist-detail">
			<?php include('partials/navbar.php'); ?>
			<h1 class="text-center"><?php echo $row['postTitle'];?></h1>
			<hr />

			<!-- Affichage d'un seul article (détail) -->
			<?php	
				echo '<div>';
					echo '<p class="text-center">
						<img class="admin-avatar" src="img/admin/user.png" alt="admin-avatar" />
						Admin 
						<img class="admin-crown" src="img/admin/crown.png" alt="crown-admin"/>
						 | '.date('j M Y', strtotime($row['postDate'])).
						'</p>';
					echo '<p>'.$row['postCont'].'</p>';				
				echo '</div>';
			?>
		</div>
	</div>
	<footer>
		<div>Icons made by <a href="https://www.flaticon.com/authors/picol" title="Picol">Picol</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
	</footer>

	<?php include('partials/scripts.php'); ?>
</body>
</html>