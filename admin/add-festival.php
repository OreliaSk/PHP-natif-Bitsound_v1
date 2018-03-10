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

	<h2 class="pb-3 pt-2 text-center">Ajouter un festival</h2>

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
			echo '<p class="alert alert-danger" role="alert">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' class="pb-5">
		<div class="form-group col">
			<p class="font-weight-bold"><label>Nom du festival</label><br />
			<input type='text' class="form-control" name='title' value='<?php if(isset($error)){ echo $_POST['title'];}?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Description</label><br />
			<textarea class="form-control" name='description' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['description'];}?></textarea></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Contenu du festival</label><br />
			<textarea class="form-control" name='content' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['content'];}?></textarea></p>
		</div>

		<button class="btn btn-custom btn-add" type='submit' name='submit' >Ajouter un festival</button>

	</form>
	<?php include('menu-footer.php');?>

</div>
