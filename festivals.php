<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('partials/head.php');?>
    <title>Festivals</title>
</head>
<body>

	<div id="wrapper">
		<?php include('partials/navbar.php');?>
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
	</div>

	<?php include('partials/scripts.php'); ?>
</body>
</html>


