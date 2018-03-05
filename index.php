<?php require('includes/config.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bitsound.</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="container-fluid">

		<nav class="navbar fixed-top navbar-expand-lg navbar-dark px-5">
			<div id="rotating-item-wrapper">
			<img class="rotating-item" src="img/home/navbar/tt.png" alt="signature" />
			<img class="rotating-item" src="img/home/navbar/ss.png" alt="signature" />
			<img class="rotating-item" src="img/home/navbar/cc.png" alt="signature" />
			</div>
		  <a class="navbar-brand" href="#">BITSOUND.</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		    <div class="navbar-nav ml-auto">
		      <a class="nav-item nav-link nav-site active mx-1" href="#">Accueil<span class="sr-only">(current)</span></a>
		      <a class="nav-item nav-link mx-1" href="posts.php">Articles</a>
		      <a class="nav-item nav-link mx-1" href="artists.php">Artistes</a>
		      <a class="nav-item nav-link mx-1" href="festivals.php">Festivals</a>
		    </div>
		  </div>
		</nav>

		<div class="container menu">
			<div class="row">
				<div class="col-md-4 articles" style="background: url(img/home/hands-light.jpg); background-size: 100%; height: 100vh">
					<div class="mx-auto">
						<p>01</p>
						<p></p>
						<a href="articles.php">Articles</a>
					</div>
				</div>
				<div class="col-md-4 artists" style="background: url(img/home/face.jpg); background-size: 100%; height: 100vh">
					<div class="mx-auto">
						<p>02</p>
						<p></p>
						<a href="artists.php">Artistes</a>
					</div>
				</div>
				<div class="col-md-4 festivals" style="background: url(img/home/firework.jpg); background-size: 100%; height: 100vh">
					<div class="mx-auto">
						<p>03</p>
						<p></p>
						<a href="festivals.php">Festivals</a>
					</div>
				</div>
			</div>
		</div>

		<div class="container latest-news">
			<h2 class="text-center">Les dernières actualités</h2>
			<hr>

			<div class="latest-artist mt-5 mb-5">
				<div class="row">
					<div class="col-sm-4 offset-md-2" style="background:url(img/actu/fakear2.jpg); background-size: 100%;h">
					</div>
					<div class="col-sm-4 infos pl-5 text-justify">
						<?php	
							try{
								$stmt = $db->query('SELECT artistId, pseudo, description, created_at FROM blog_artists ORDER BY artistId DESC');
								$row = $stmt->fetch();

								echo '<div>';
									echo '<h3><a href="viewartist.php?id='.$row['artistId'].'">'.$row['pseudo'].'</a></h3>';
									echo '<p>Posté le '.date('j M Y', strtotime($row['created_at'])).'</p>';
									echo '<p>'.$row['description'].'</p>';	
									echo '<hr />';
									echo '<p><a href="viewartist.php?id='.$row['artistId'].'">Laisser un commentaire</a></p>';			
								echo '</div>';

							}catch(PDOException $e){
								echo $e->getMessage();
							}
							
						?>
					</div>
				</div>
			</div>

			<div class="latest-article mt-5 mb-5">
				<div class="row">
					<div class="col-sm-4 offset-md-2" style="background:url(img/actu/son.jpg); background-size: 100%;h">
					</div>
					<div class="col-sm-4 infos pl-5 text-justify">
						<?php	
							try{
								$stmt = $db->query('SELECT postId, postTitle, postDesc, postDate FROM blog_posts ORDER BY postId DESC');
								$row = $stmt->fetch();

								echo '<div>';
									echo '<h2><a href="viewpost.php?id='.$row['postId'].'">'.$row['postTitle'].'</a></h2>';
									echo '<p>Posté le '.date('j M Y', strtotime($row['postDate'])).'</p>';
									echo '<p>'.$row['postDesc'].'</p>';	
									echo '<hr />';
									echo '<p><a href="viewpost.php?id='.$row['postId'].'">Laisser un commentaire</a></p>';			
								echo '</div>';

							}catch(PDOException $e){
								echo $e->getMessage();
							}
							
						?>
					</div>
				</div>
			</div>

			<div class="latest-festival mt-5 mb-5">
				<div class="row">
					<div class="col-sm-4 offset-md-2" style="background:url(img/actu/festiv.jpg); background-size: 100%;h">
					</div>
					<div class="col-sm-4 infos pl-5 text-justify">
						<?php	
							try{
								$stmt = $db->query('SELECT festivalId, title, description, created_at FROM blog_festivals ORDER BY festivalId DESC');
								$row = $stmt->fetch();

								echo '<div>';
									echo '<h2><a href="viewfestival.php?id='.$row['festivalId'].'">'.$row['title'].'</a></h2>';
									echo '<p>Posté le '.date('j M Y', strtotime($row['created_at'])).'</p>';
									echo '<p>'.$row['description'].'</p>';	
									echo '<p><a href="viewfestival.php?id='.$row['festivalId'].'">Laisser un commentaire</a></p>';			
								echo '</div>';

							}catch(PDOException $e){
								echo $e->getMessage();
							}
							
						?>
					</div>
				</div>
			</div>
		</div>
		
		<footer class="home-footer container">
			<h4>Contacter l'un de nos administrateur</h4>
			<form action="">
				<div class="container">
					<div class="row">
						<div>
							<input type="text" placeholder="Votre nom"><br />
							<input type="text" placeholder="Votre email">
						</div>
						<textarea name="" id="" cols="30" rows="5" placeholder="Votre message"></textarea>
					</div>
					<button>Envoyer</button>
				</div>
			</form>
			<p>© 2018 by BITSOUND. Proudly created with <a href="">Orélia Sokambi</a></p>
		</footer>


	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>


