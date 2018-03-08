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
		<div class="articles-list container">
			<h1>Articles</h1>
			<hr />

			<?php
				try {

					$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
					while($row = $stmt->fetch()){
						
						echo '<div>';
							echo '<div class="row single-article">';
								echo '<div class="col-md-5" style="background:url(img/actu/fakear2.jpg); background-size: 100%;"></div>';
								echo '<div class="col-md-6 pl-5">';
									echo '<h2><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h2>';
									echo '<p>Posté le '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
									echo '<p class="border-content">'.$row['postDesc'].'</p>';				
									echo '<p><a href="viewpost.php?id='.$row['postID'].'">Lire la suite</a></p>';				
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}

				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>
			<nav aria-label="Page navigation example text-center">
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#">Previous</a></li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">Next</a></li>
				</ul>
				</nav>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>


