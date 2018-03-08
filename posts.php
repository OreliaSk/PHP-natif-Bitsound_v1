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
    <title>Articles</title>
</head>
<body>

	<div id="wrapper">
		<?php include('navbar.php');?>
		<div class="articles-list" style="border: 2px solid red; padding-top: 25vh;">
			<h1>Articles</h1>
			<hr />

			<?php
				try {

					$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
					while($row = $stmt->fetch()){
						
						echo '<div>';
							echo '<h2><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h2>';
							echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
							echo '<p>'.$row['postDesc'].'</p>';				
							echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';				
						echo '</div>';

					}

				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>


