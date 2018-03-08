<?php // On inclu fichier config
require_once('../includes/config.php');

// Si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Editer un festival</title>
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
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Editer un festival</h2>


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
			echo $error.'<br />';
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

	<form action='' method='post'>
		<input type='hidden' name='festivalId' value='<?php echo $row['festivalId'];?>'>

		<p><label>title</label><br />
		<input type='text' name='title' value='<?php echo $row['title'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='description' cols='60' rows='10'><?php echo $row['description'];?></textarea></p>

		<p><label>Biographie</label><br />
		<textarea name='content' cols='60' rows='10'><?php echo $row['content'];?></textarea></p>

		<p><input type='submit' name='submit' value='Mettre à jour'></p>

	</form>

</div>

</body>
</html>	
