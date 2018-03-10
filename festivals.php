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
    <title>Festivals</title>
</head>
<body>

	<div id="wrapper">
		<?php include('navbar.php');?>
		<div class="festivals-list container">
		<h1>Festivals</h1>
		<hr />

		<?php
			try {

				$stmt = $db->query('SELECT festivalId, title, description, created_at FROM blog_festivals ORDER BY festivalId DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<div class="row single-festival">';
							echo '<div class="col-md-5" style="background:url(img/actu/fakear2.jpg); background-size: 100%;"></div>';
							echo '<div class="col-md-6 pl-5">';
								echo '<h2><a href="viewfestival.php?id='.$row['festivalId'].'">'.$row['title'].'</a></h2>';
								echo '<p>Posté le '.date('jS M Y H:i:s', strtotime($row['created_at'])).'</p>';
								echo '<p>'.$row['description'].'</p>';				
								echo '<p><a href="viewfestival.php?id='.$row['festivalId'].'">Read More</a></p>';				
							echo '</div>';
						echo '</div>';
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item"><a class="page-link" href="#">Previous</a></li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">Next</a></li>
			</ul>
		</nav>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>


