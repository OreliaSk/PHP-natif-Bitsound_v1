<?php require('includes/config.php');?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<?php include('partials/head.php');?>
    <title>Bitsound.</title>
</head>
<body>

	<div id="container-fluid home">
		<?php include('partials/navbar.php');?>
		
		<?php
		$pseudo = '';
		$email = '';
		$content ='';

		// Si le formulaire a été envoyé
		if(isset($_POST['submit'])){
			$_POST = array_map( 'stripslashes', $_POST );

			// Collect des datas
			extract($_POST);

			// Validation basique
			if($pseudo ==''){
				$error[] = 'Veuillez entrer un nom';
			}

			if($email ==''){
				$error[] = 'Veuillez remplir votre email';
			}

			if($content ==''){
				$error[] = 'Veuillez écrire un message';
			}

			if(!isset($error)){
				try {

					// Insertion dans bdd
					$stmt = $db->prepare('INSERT INTO blog_messages (pseudo, email, content,created_at) VALUES (:pseudo, :email, :content, :created_at)') ;
					$stmt->execute(array(
						':pseudo' => $pseudo,
						':email' => $email,
						':content' => $content,
						':created_at' => date('Y-m-d H:i:s')
					));

					// Redirection par la page d'index 
					header('Location: index.php?action=added');
					exit;

				} catch(PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
		?>

		<div class="container menu">
			<div class="row">
				<div class="col-md-4 articles">
					<div class="mx-auto menu-link">
						<span>01</span>
						<img class="line-menu d-block" src="img/home/forms/substract.svg" alt="line" />
						<a href="posts.php">Articles</a>
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
								$stmt = $db->query('SELECT postId, title, description, created_at FROM blog_posts ORDER BY postId DESC');
								$row = $stmt->fetch();

								echo '<div>';
									echo '<h2><a href="viewpost.php?id='.$row['postId'].'">'.$row['title'].'</a></h2>';
									echo '<p>Posté le '.date('j M Y', strtotime($row['created_at'])).'</p>';
									echo '<p>'.$row['description'].'</p>';
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
			
			<form action="" class="pt-5" method="post">
				<div class="container contact">
					<!-- Vérification des erreurs -->
					<?php 
						if(isset($error)){
							foreach($error as $error){
								echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
							}
						}
					?>
					<div class="row justify-content-center">
						<div class="col-md-4 pt-3">
							<input type="text" name='pseudo' placeholder="Votre nom"><br />
							<input type="text" name='email' placeholder="Votre email">
						</div>
						<div class="col-md-4">
							<textarea name="content" cols="40" rows="5" placeholder="Votre message"></textarea>
						</div>
					</div>
					<button class="d-block mx-auto m-4 px-2" type='submit' name="submit">Envoyer</button>
				</div>
			</form>

			<div class="mt-5 copyright">
				© 2018 by BITSOUND. Proudly created by 
				<a href="https://oreliask.github.io/MDBootstrap-Landing-page/index.html" target="_blank">Orélia Sokambi</a>
				<div>
					Icons made by 
					<a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from 
					<a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by 
					<a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
				</div>
			</div>
		</footer>


	</div>
	<?php include('partials/scripts.php'); ?>
</body>
</html>

