<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('partials/head.php');?>
    <title>Artistes</title>
</head>
<body>

	<div id="wrapper">
		<?php include('partials/navbar.php');?>
		<div class="artists-list container">
		<h1>Artistes</h1>
		<hr />

		<?php
			try {

				$stmt = $db->query('SELECT artistId, pseudo, genre, description, created_at FROM blog_artists ORDER BY artistId DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<div class="row single-artist">';
							echo '<div class="col-md-5" style="background:url(img/actu/fakear2.jpg); background-size: 100%;"></div>';
							echo '<div class="col-md-6 pl-5">';
								echo '<h2><a href="viewartist.php?id='.$row['artistId'].'">'.$row['pseudo'].'</a></h2>';
								echo '<p>Posté le '.date('jS M Y H:i:s', strtotime($row['created_at'])).'</p>';
								echo '<p>'.$row['genre'].'</p>';
								echo '<p>'.$row['description'].'</p>';				
								echo '<p><a href="viewartist.php?id='.$row['artistId'].'">Read More</a></p>';				
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


