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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="menu-admin" id="wrapper">

	<?php include('menu-header.php');?>

	<h2 class="pb-3 pt-2 text-center">Ajouter un administrateur</h2>

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
			echo '<p class="alert alert-danger" role="alert">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' class="pb-5">

		<div class="form-group col">
			<p class="font-weight-bold"><label>Pseudo</label><br />
			<input type='text' class="form-control" name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Mot de passe</label><br />
			<input type='password' class="form-control" name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Confirmez le mot de passe</label><br />
			<input type='password' class="form-control" name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Email</label><br />
			<input type='text' class="form-control" name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
		</div>	

		<button class="btn btn-custom btn-add d-block mx-auto" type='submit' name='submit'>Ajouter un administrateur</button>

	</form>
	<?php include('menu-footer.php');?>
</div>
