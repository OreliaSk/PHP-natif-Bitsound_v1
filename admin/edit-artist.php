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
	<title>Dashboard administrateur - Editer un artiste</title>
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

	<h2 class="pb-3 pt-2 text-center">Editer un artiste</h2>

	<?php

	// A l'envoi du formulaire
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		// collecte des données
		extract($_POST);

		// validation basique
		if($artistID ==''){
			$error[] = 'Cet artiste n\'a pas d\'id valide !';
		}

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

				// mise à jour dans bdd
				$stmt = $db->prepare(
					'UPDATE blog_artists 
					SET 
					pseudo = :pseudo, 
					first_name = :first_name, 
					last_name = :last_name, 
					description = :description, 
					content = :content, 
					genre = :genre, 
					picture = :picture, 
					website = :website, 
					video = :video
					WHERE 
					artistID = :artistID') ;
				$stmt->execute(array(
					':pseudo' => $pseudo,
					':first_name' => $first_name,
					':last_name' => $last_name,
					':description' => $description,
					':content' => $content,
					':genre' => $genre,
					':picture' => $picture,
					':website' => $website,
					':video' => $video,
					':artistID' => $artistID
				));

				// On redirige sur la page index
				header('Location: artists.php?action=updated');
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
				SELECT artistID, 
				pseudo, 
				first_name, 
				last_name, 
				description, 
				content, 
				genre, 
				picture, 
				website, 
				video 
				FROM blog_artists 
				WHERE artistID = :artistID'
			) ;
			$stmt->execute(array(':artistID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post' class="pb-5">
		<input type='hidden' name='artistID' value='<?php echo $row['artistID'];?>'>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Pseudo</label><br />
			<input type='text' class="form-control" name='pseudo' value='<?php echo $row['pseudo'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Prénom</label><br />
			<input type='text' class="form-control" name='first_name' value='<?php echo $row['first_name'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Nom</label><br />
			<input type='text' class="form-control" name='last_name' value='<?php echo $row['last_name'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Description</label><br />
			<textarea class="form-control" name='description' cols='60' rows='10'><?php echo $row['description'];?></textarea></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Biographie</label><br />
			<textarea class="form-control" name='content' cols='60' rows='10'><?php echo $row['content'];?></textarea></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Genre</label><br />
			<input type='text' class="form-control" name='genre' value='<?php echo $row['genre'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Photo</label><br />
			<input type='text' class="form-control" name='picture' value='<?php echo $row['picture'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Sites internet</label><br />
			<input type='text' class="form-control" name='website' value='<?php echo $row['website'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Vidéo</label><br />
			<input type='text' class="form-control" name='video' value='<?php echo $row['video'];?>'></p>
		</div>

		<button class="btn btn-custom btn-add d-block mx-auto" type='submit' name='submit' >Mettre à jour</button>

	</form>
	<?php include('menu-footer.php');?>
</div>

</body>
</html>	
