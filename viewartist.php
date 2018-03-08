<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT artistId, pseudo, description, content, genre, picture, website, video, created_at FROM blog_artists WHERE artistId = :artistId');
$stmt->execute(array(':artistId' => $_GET['id']));
$row = $stmt->fetch();

// Si l'article à afficher n'existe pas, on redirige vers l'index
if($row['artistId'] == ''){
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
    <title>Artiste - <?php echo $row['pseudo'];?></title>
</head>
<body>

	<div id="wrapper">
		<?php include('navbar.php'); ?>
		<h1>Festival</h1>
		<hr />
		<p><a href="./">Blog Index</a></p>

		<!-- Affichage d'un seul artiste (détail) -->
		<?php	
			echo '<div>';
				echo '<h2>'.$row['pseudo'].'</h2>';
				echo '<p>Posted on '.date('j M Y', strtotime($row['created_at'])).'</p>';
				echo '<p>'.$row['description'].'</p>';
				echo '<p>'.$row['content'].'</p>';	
				echo '<p>'.$row['genre'].'</p>';
				echo '<p>'.$row['picture'].'</p>';
				echo '<p>'.$row['website'].'</p>';
				echo '<p>'.$row['video'].'</p>';			
			echo '</div>';
		?>

	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>