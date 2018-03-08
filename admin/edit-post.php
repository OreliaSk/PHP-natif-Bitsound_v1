<?php // On inclu fichier config
require_once('../includes/config.php');

// Si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Editer un article</title>
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

	<h2>Editer un article</h2>


	<?php

	// si le formulaire a bien été rempli :
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		// collecte des données
		extract($_POST);

		// validation basique
		if($postID ==''){
			$error[] = 'Cet article n\'a pas d\'id valide !';
		}

		if($postTitle ==''){
			$error[] = 'Veuillez entrer un titre';
		}

		if($postDesc ==''){
			$error[] = 'Veuillez remplir la description.';
		}

		if($postCont ==''){
			$error[] = 'Veuillez remplir le contenu de l\'article';
		}

		if(!isset($error)){

			try {

				// mise à jour dans bdd
				$stmt = $db->prepare(
					'UPDATE blog_posts 
					SET 
					postTitle = :postTitle, 
					postDesc = :postDesc, 
					postCont = :postCont 
					WHERE 
					postID = :postID') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postID' => $postID
				));

				// On redirige sur la page index
				header('Location: index.php?action=updated');
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

			$stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont FROM blog_posts WHERE postID = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>

		<p><label>Titre</label><br />
		<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php echo $row['postDesc'];?></textarea></p>

		<p><label>Contenu de l'article</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>

		<p><input type='submit' name='submit' value='Mettre à jour'></p>

	</form>

</div>

</body>
</html>	
