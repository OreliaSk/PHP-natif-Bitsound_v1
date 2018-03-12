<?php // on inclue le fichier de config
require_once('../includes/config.php');

// si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard administrateur - Ajouter un artiste</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	<script>
	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	</script>
</head>
<body>

<div class="menu-admin" id="wrapper">

	<?php include('menu-header.php');?>

	<h2 class="pb-3 pt-2 text-center">Ajouter un artiste</h2>

	<?php

	if(isset($_POST['submit'])){

		$_POST = array_map('stripslashes', $_POST);

		extract($_POST);

		if($pseudo ==''){
			$error[] = 'Veuillez entrer un pseudo';
		}

		if($content ==''){
			$error[] = 'Veuillez entrer la biographie de l\'artiste';
		}

		if($website ==''){
			$error[] = 'Veuillez entrer l\'adresse web de l\'artiste';
		}

		if($picture == ''){
			$error[] = 'Veuillez télécharger une photo de l\'artiste';
		}


		if(!isset($error)){

			try {

				// on insère dans la bdd
				$stmt = $db->prepare(
					'INSERT INTO blog_artists (pseudo, first_name, last_name,description,content,genre,picture,website,video) 
					VALUES (:pseudo, :first_name, :last_name, :description, :content, :genre, :picture, :website, :video )'
				) ;
				$stmt->execute(array(
					':pseudo' => $pseudo,
					':first_name' => $first_name,
					':last_name' => $last_name,
					':description' => $description,
					':content' => $content,
					':genre' => $genre,
					':picture' => $picture,
					':website' => $website, 
					':video' => $video
				));

				// redirection sur la page d'index
				header('Location: artists.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	// vérification des erreurs
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="alert alert-danger" role="alert">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' class="pb-5">
		<div class="form-group col">
			<p class="font-weight-bold"><label>Pseudo</label><br />
			<input type='text' class="form-control" name='pseudo' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['pseudo']);}?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Prénom</label><br />
			<input type='text' class="form-control" name='first_name' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['first_name']);}?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Nom</label><br />
			<input type='text' class="form-control" name='last_name' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['last_name']);}?>'></p>
		</div>

		<div class="form-group">
			<p class="font-weight-bold"><label>Description</label><br />
			<textarea class="form-control" name='description' cols='60' rows='10'><?php if(isset($error)){ echo htmlspecialchars($_POST['description']);}?></textarea></p>
		</div>
		
		<div class="form-group">
			<p class="font-weight-bold"><label>Biographie</label><br />
			<textarea class="form-control" name='content' cols='60' rows='10'><?php if(isset($error)){ echo htmlspecialchars($_POST['content']);}?></textarea></p>
		</div>	

		<div class="form-group">
			<p class="font-weight-bold"><label>Genre</label><br />
			<input type='text' class="form-control" name='genre' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['genre']);}?>'></p>
		</div>	

		<div class="form-group">
			<p class="font-weight-bold"><label>Photo</label><br />
			<input type='text' class="form-control" name='picture' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['picture']);}?>'></p>
		</div>	

		<div class="form-group">
			<p class="font-weight-bold"><label>Lien web</label><br />
			<input type='text' class="form-control" name='website' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['website']);}?>'></p>
		</div>	

		<div class="form-group">
			<p class="font-weight-bold"><label>Vidéo</label><br />
			<input type='text' class="form-control" name='video' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['video']);}?>'></p>
		</div>

		<button class="btn btn-custom btn-add d-block mx-auto" type='submit' name='submit'>Ajouter un artiste</button>

	</form>
	<?php include('menu-footer.php');?>
</div>
