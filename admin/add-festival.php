<?php // on inclue le fichier de config
require_once('../includes/config.php');

// si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Ajouter un festival</title>
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

	<h2>Ajouter un festival</h2>

	<?php

	if(isset($_POST['submit'])){

		$_POST = array_map('stripslashes', $_POST);

		extract($_POST);

		if($title ==''){
			$error[] = 'Veuillez le titre du festival';
		}

		if($description ==''){
			$error[] = 'Veuillez entrer une description du festival';
		}

		if($content ==''){
			$error[] = 'Veuillez entrer la biographie de l\'artiste';
		}


		if(!isset($error)){

			try {

				// on insère dans la bdd
				$stmt = $db->prepare(
					'INSERT INTO blog_festivals (title, description, content) 
					VALUES (:title, :description, :content)'
				) ;
				$stmt->execute(array(
					':title' => $title,
					':description' => $description,
					':content' => $content
				));

				// redirection sur la page d'index
				header('Location: festivals.php?action=added');
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

		<p><label>Nom du festival</label><br />
		<input type='text' name='title' value='<?php if(isset($error)){ echo $_POST['title'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='description' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['description'];}?></textarea></p>

		<p><label>Contenu du festival</label><br />
		<textarea name='content' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['content'];}?></textarea></p>
		
		<p><input type='submit' name='submit' value='Ajouter un festival'></p>

	</form>

</div>
