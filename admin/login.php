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
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="login">

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
			$message = '<p class="error">Pseudo ou mot de passe invalide</p>';
		}

	}// fin if submit

	if(isset($message)){ echo $message; }
	?>

	<form action="" method="post">
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
	</form>

</div>
</body>
</html>
