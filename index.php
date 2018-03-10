<?php require('includes/config.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="blog about electro music">
	<meta name="keywords" content="blog electro music">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<![endif]-->
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/main.css">
    <title>Bitsound.</title>
</head>
<body>

	<div id="container-fluid home">

		<nav class="navbar fixed-top navbar-expand-lg navbar-dark px-5">
			<div id="rotating-item-wrapper">
				<img class="rotating-item" src="img/home/navbar/tt.png" alt="signature" />
				<img class="rotating-item" src="img/home/navbar/ss.png" alt="signature" />
				<img class="rotating-item" src="img/home/navbar/cc.png" alt="signature" />
			</div>
		  <a class="navbar-brand" href="index.php">BITSOUND.</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		    <div class="navbar-nav ml-auto">
		      <a class="nav-item nav-link nav-site active mx-1" href="index.php">Accueil<span class="sr-only">(current)</span></a>
		      <a class="nav-item nav-link mx-1" href="posts.php">Articles</a>
		      <a class="nav-item nav-link mx-1" href="artists.php">Artistes</a>
		      <a class="nav-item nav-link mx-1" href="festivals.php">Festivals</a>
		    </div>
		  </div>
		</nav>

		<div class="container menu">
			<div class="row">
				<div class="col-md-4 articles">
					<div class="mx-auto menu-link">
						<span>01</span>
						<img class="line-menu d-block" src="img/home/forms/substract.svg" alt="line" />
						<a href="articles.php">Articles</a>
					</div>
				</div>
				<div class="col-md-4 artists">
					<div class="mx-auto menu-link">
						<span>02</span>
						<img class="line-menu d-block" src="img/home/forms/substract.svg" alt="line" />
						<a href="artists.php">Artistes</a>
					</div>
				</div>
				<div class="col-md-4 festivals">
					<div class="mx-auto menu-link">
						<span>03</span>
						<img class="line-menu d-block" src="img/home/forms/substract.svg" alt="line" />
						<a href="festivals.php">Festivals</a>
					</div>
				</div>
			</div>
		</div>

		<div class="container latest-news">
			<h2 class="text-center pb-4">Les dernières actualités</h2>
			<div class="latest-artist mt-5 mb-5">
				<div class="row">
					<div class="col-sm-4 offset-md-2" style="background:url(img/actu/fakear2.jpg); background-size: 100%;">
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
									echo '<div class="border-content mb-1"></div>';
									echo '<p class="comments"><a href="viewartist.php?id='.$row['artistId'].'">Laisser un commentaire</a></p>';			
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
									echo '<div class="border-content mb-1"></div>';	
									echo '<p class="comments"><a href="viewpost.php?id='.$row['postId'].'">Laisser un commentaire</a></p>';			
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
					<div class="col-sm-4 offset-md-2" style="background:url(img/actu/festiv.jpg); background-size: 100%;">
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
									echo '<div class="border-content mb-1"></div>';
									echo '<p class="comments"><a href="viewfestival.php?id='.$row['festivalId'].'">Laisser un commentaire</a></p>';			
								echo '</div>';

							}catch(PDOException $e){
								echo $e->getMessage();
							}
							
						?>
					</div>
				</div>
			</div>
		</div>
		
		<footer class="home-footer container text-center pt-5">
			<h4 class="pb-4">Contacter l'un de nos administrateurs</h4>
			
			<form action="" class="pt-5">
				<div class="container contact">
					<div class="row justify-content-center">
						<div class="col-md-4 pt-3">
							<input type="text" placeholder="Votre nom"><br />
							<input type="text" placeholder="Votre email">
						</div>
						<div class="col-md-4">
							<textarea name="" id="" cols="40" rows="5" placeholder="Votre message"></textarea>
						</div>
					</div>
					<button class="d-block mx-auto m-4 px-2">Envoyer</button>
				</div>
			</form>

			<p class="mt-5 copyright">© 2018 by BITSOUND. Proudly created with <a href="">Orélia Sokambi</a></p>
			<div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
		</footer>


	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>

