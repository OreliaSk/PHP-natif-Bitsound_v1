<?php // on inclue le fichier de config
require_once('../includes/config.php');

// si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard administrateur - Ajouter un utilisateur</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">User Admin Index</a></p>

	<h2>Ajouter un utilisateur</h2>

	<?php

	if(isset($_POST['submit'])){

		extract($_POST);

		if($username ==''){
			$error[] = 'Veuillez entrer un nom';
		}

		if($password ==''){
			$error[] = 'Veuillez entrer un mot de passe.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Veuillez confirmer le mot de passe';
		}

		if($password != $passwordConfirm){
			$error[] = 'Les mots de passe de correspondent pas';
		}

		if($email ==''){
			$error[] = 'Veuillez entrer une adresse mail';
		}

		if(!isset($error)){

			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

			try {

				// on insère dans la bdd
				$stmt = $db->prepare('INSERT INTO blog_members (username,password,email) VALUES (:username, :password, :email)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $hashedpassword,
					':email' => $email
				));

				// redirection sur la page d'index
				header('Location: users.php?action=added');
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
		<input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>

		<p><label>Mot de passe</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

		<p><label>Confirmez le mot de passe</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
		
		<p><input type='submit' name='submit' value='Ajouter un utilisateur'></p>

	</form>

</div>
