<?php require('includes/config.php'); ?>
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
    <title>Artistes</title>
</head>
<body>

	<div id="wrapper">
		<?php include('navbar.php');?>

		<h1>Artistes</h1>
		<hr />

		<?php
			try {

				$stmt = $db->query('SELECT artistId, pseudo, description, content, genre, picture, website, video, created_at FROM blog_artists ORDER BY artistId DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h2><a href="viewartist.php?id='.$row['artistId'].'">'.$row['pseudo'].'</a></h2>';
						echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['created_at'])).'</p>';
						echo '<p>'.$row['description'].'</p>';
						echo '<p>'.$row['content'].'</p>';
						echo '<p>'.$row['genre'].'</p>';
						echo '<p>'.$row['picture'].'</p>';
						echo '<p>'.$row['website'].'</p>';
						echo '<p>'.$row['video'].'</p>';				
						echo '<p><a href="viewartist.php?id='.$row['artistId'].'">Read More</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>

</body>
</html>


