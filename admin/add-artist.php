<?php // on inclue le fichier de config
require_once('../includes/config.php');

// si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Ajouter un artiste</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
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

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">Blog Admin Index</a></p>

	<h2>Ajouter un artiste</h2>

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
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Pseudo</label><br />
		<input type='text' name='pseudo' value='<?php if(isset($error)){ echo $_POST['pseudo'];}?>'></p>

		<p><label>Prénom</label><br />
		<input type='text' name='first_name' value='<?php if(isset($error)){ echo $_POST['first_name'];}?>'></p>

		<p><label>Nom</label><br />
		<input type='text' name='last_name' value='<?php if(isset($error)){ echo $_POST['last_name'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='description' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['description'];}?></textarea></p>

		<p><label>Biographie</label><br />
		<textarea name='content' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['content'];}?></textarea></p>

		<p><label>Genre</label><br />
		<input type='text' name='genre' value='<?php if(isset($error)){ echo $_POST['genre'];}?>'></p>

		<p><label>Photo</label><br />
		<input type='text' name='picture' value='<?php if(isset($error)){ echo $_POST['picture'];}?>'></p>

		<p><label>Lien web</label><br />
		<input type='text' name='website' value='<?php if(isset($error)){ echo $_POST['website'];}?>'></p>

		<p><label>Vidéo</label><br />
		<input type='text' name='video' value='<?php if(isset($error)){ echo $_POST['video'];}?>'></p>
		
		<p><input type='submit' name='submit' value='Ajouter un utilisateur'></p>

	</form>

</div>
