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
    <meta charset="utf-8">
    <meta name="description" content="blog about electro music">
	<meta name="keywords" content="blog electro music">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<![endif]-->
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/main.css">
    <title>Article - <?php echo $row['postTitle'];?></title>
</head>
<body>

	<div class="container-fluid wrapper-post" id="wrapper">
		<div class="container artist-detail">
			<?php include('navbar.php'); ?>
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

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>