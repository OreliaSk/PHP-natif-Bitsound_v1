<?php
// On inclu le fichier config
require_once('../includes/config.php');

// Si l'admin est déjà connectée, il est envoyé sur le dashboard (admin.index.php) sinon redirigé vers la page de connexion
if( $user->is_logged_in() ){ header('Location: index.php'); } 
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion administrateur</title>
  <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div class="login container-fluid pt-5" id="login">

	<?php

	// A l'envoi du formulaire d'authentification
	if(isset($_POST['submit'])){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($user->login($username,$password)){ 

			// Redirection sur la page admin.index.php
			header('Location: index.php');
			exit;
		

		} else {
			$message = '<p class="alert alert-danger" role="alert">Pseudo ou mot de passe invalide</p>';
		}

	}// fin if submit

	?>

	<!--<form class="admin-connection" action="" method="post">
		<?php if(isset($message)){ echo $message; } ?>
		<p>
			<label>Pseudo</label>
			<input type="text" name="username" value=""  />
		</p>
		<p>
			<label>Mot de passe</label>
			<input type="password" name="password" value=""  />
		</p>
		<p>
			<label></label>
			<input type="submit" name="submit" value="Connexion"  />
		</p>
	</form>-->

	<form class="admin-connection mx-auto p-3" action="" method="post">
		<?php if(isset($message)){ echo $message; } ?>
		<div class="form-group" >
			<label for="pseudo">Pseudo</label>
			<input type="text" class="form-control" id="pseudo" name="username">
		</div>
		<div class="form-group">
			<label for="password">Mot de passe</label>
			<input type="password" class="form-control" id="password" name="password">
		</div>
		<button type="submit" class="btn btn-custom d-block mx-auto" name="submit">Connexion</button>
	</form>

</div>
</body>
</html>
