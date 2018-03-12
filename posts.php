<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('partials/head.php');?>
    <title>Articles</title>
</head>
<body>

	<div id="wrapper">
		<?php include('partials/navbar.php');?>
		<div class="articles-list container">
			<div class="bloc-img"> 
				<h1>Articles</h1>
			</div>
			<hr />

			<?php
				try {

					$stmt = $db->query('SELECT postID, title, description, created_at FROM blog_posts ORDER BY postID DESC');
					while($row = $stmt->fetch()){
						
						echo '<div>';
							echo '<div class="row single-article">';
								echo '<div class="col-md-5" style="background:url(img/actu/fakear2.jpg); background-size: 100%;"></div>';
								echo '<div class="col-md-6 pl-5">';
									echo '<h2><a href="viewpost.php?id='.$row['postID'].'">'.$row['title'].'</a></h2>';
									echo '<p>Posté le '.date('jS M Y H:i:s', strtotime($row['created_at'])).'</p>';
									echo '<p class="border-content">'.$row['description'].'</p>';				
									echo '<p><a href="viewpost.php?id='.$row['postID'].'">Lire la suite</a></p>';				
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}

				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>
		</div>
	</div>

	<?php include('partials/scripts.php'); ?>
</body>
</html>


