<?php //include config
require_once('../includes/config.php');

// Si pas de login, on redirige sur la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard administrateur - Ajouter un article</title>
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

	<h2 class="pb-3 pt-2 text-center">Ajouter un article</h2>

	<?php

	// Si le formulaire a été envoyé
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		// Collect des datas
		extract($_POST);

		// Validation basique
		if($title ==''){
			$error[] = 'Veuillez entrer un titre';
		}

		if($description ==''){
			$error[] = 'Veuillez remplir la description';
		}

		if($content ==''){
			$error[] = 'Veuillez remplir le contenu de l\'article';
		}

		if(!isset($error)){

			try {

				// Insertion dans bdd
				$stmt = $db->prepare('INSERT INTO blog_posts (title,description,content,created_at) VALUES (:title, :description, :content, :created_at)') ;
				$stmt->execute(array(
					':title' => $title,
					':description' => $description,
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

	// Vérification des erreurs
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="alert alert-danger" role="alert">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' class="pb-5">

		<div class="form-group col">
			<p><label>Titre</label><br />
			<input type='text' class="form-control" name='title' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['title']);}?>'></p>
		</div>

		<div class="form-group col">
			<p><label>Description</label><br />
			<textarea class="form-control" name='description' cols='60' rows='10'><?php if(isset($error)){ echo htmlspecialchars($_POST['description']);}?></textarea></p>
		</div>

		<div class="form-group col">
			<p><label>Contenu</label><br />
			<textarea class="form-control" name='content' cols='60' rows='10'><?php if(isset($error)){ echo htmlspecialchars($_POST['content']);}?></textarea></p>
		</div>

		<button class="btn btn-custom btn-add d-block mx-auto" type='submit' name='submit' >Envoyer</button>

	</form>
	<?php include('menu-footer.php');?>
</div>
