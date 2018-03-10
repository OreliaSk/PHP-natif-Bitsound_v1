<?php // On inclu fichier config
require_once('../includes/config.php');

// Si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>Dashboard administrateur - Editer un festival</title>
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

	<h2 class="pb-3 pt-2 text-center">Editer un festival</h2>


	<?php

	// A l'envoi du formulaire
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		// collecte des données
		extract($_POST);

		// validation basique
		if($festivalId ==''){
			$error[] = 'Ce festival n\'a pas d\'id valide !';
		}

		if($title ==''){
			$error[] = 'Veuillez entrer le nom du festival';
		}

		if($description ==''){
			$error[] = 'Veuillez entrer la description de du festival';
		}

		if($content ==''){
			$error[] = 'Veuillez entrer le détail du festival';
		}

		if(!isset($error)){

			try {

				// mise à jour dans bdd
				$stmt = $db->prepare(
					'UPDATE blog_festivals 
					SET 
					title = :title, 
					description = :description, 
					content = :content 
					WHERE 
					festivalId = :festivalId') ;
				$stmt->execute(array(
					':title' => $title,
					':description' => $description,
					':content' => $content,
					':festivalId' => $festivalId
				));

				// On redirige sur la page index
				header('Location: festivals.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
	}

	?>


	<?php
	// Vérification des erreurs 
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="alert alert-danger" role="alert">'.$error.'<p>';
		}
	}

	try {

		$stmt = $db->prepare('
			SELECT festivalId, 
			title, 
			description, 
			content
			FROM blog_festivals 
			WHERE festivalId = :festivalId'
		) ;
		$stmt->execute(array(':festivalId' => $_GET['id']));
		$row = $stmt->fetch(); 

	} catch(PDOException $e) {
		echo $e->getMessage();
	}

	?>

	<form action='' method='post' class="pb-5">
		<input type='hidden' name='festivalId' value='<?php echo $row['festivalId'];?>'>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Titre du festival</label><br />
			<input type='text' class="form-control" name='title' value='<?php echo $row['title'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Description</label><br />
			<textarea class="form-control" name='description' cols='60' rows='10'><?php echo $row['description'];?></textarea></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Contenu</label><br />
			<textarea class="form-control" name='content' cols='60' rows='10'><?php echo $row['content'];?></textarea></p>
		</div>

		<button class="btn btn-custom btn-add d-block mx-auto" type='submit' name='submit'>Mettre à jour</button>

	</form>
	<?php include('menu-footer.php');?>
</div>

</body>
</html>	
