<?php //include config
require_once('../includes/config.php');

// Si pas de login, on redirige sur la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Ajouter un article</title>
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

	<h2>Ajouter un article</h2>

	<?php

	// Si le formulaire a été envoyé
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		// Collect des datas
		extract($_POST);

		// Validation basique
		if($postTitle ==''){
			$error[] = 'Veuillez entrer un titre';
		}

		if($postDesc ==''){
			$error[] = 'Veuillez remplir la description';
		}

		if($postCont ==''){
			$error[] = 'Veuillez remplir le contenu de l\'article';
		}

		if(!isset($error)){

			try {

				// Insertion dans bdd
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate) VALUES (:postTitle, :postDesc, :postCont, :postDate)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s')
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
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Titre</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Contenu</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Envoyer'></p>

	</form>

</div>
