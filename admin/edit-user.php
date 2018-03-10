<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>Dashboard administrateur - Editer un utilisateur</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="menu-admin" id="wrapper">

	<?php include('menu-header.php');?>

	<h2 class="pb-3 pt-2 text-center">Editer un utilisateur</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($username ==''){
			$error[] = 'Veuillez entrer un pseudo';
		}

		if( strlen($password) > 0){

			if($password ==''){
				$error[] = 'Veuillez entrer le mot de passe';
			}

			if($passwordConfirm ==''){
				$error[] = 'Veuillez confirmer le mot de passe';
			}

			if($password != $passwordConfirm){
				$error[] = 'Les mots de passe ne correspondent pas';
			}

		}
		

		if($email ==''){
			$error[] = 'Veuillez entrer une adresse mail';
		}

		if(!isset($error)){

			try {

				if(isset($password)){

					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

					//update into database
					$stmt = $db->prepare('UPDATE blog_members SET username = :username, password = :password, email = :email WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':password' => $hashedpassword,
						':email' => $email,
						':memberID' => $memberID
					));


				} else {

					//update database
					$stmt = $db->prepare('UPDATE blog_members SET username = :username, email = :email WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':email' => $email,
						':memberID' => $memberID
					));

				}
				

				//redirect to index page
				header('Location: users.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="alert alert-danger" role="alert">'.$error.'<p>';
		}
	}

		try {

			$stmt = $db->prepare('SELECT memberID, username, email FROM blog_members WHERE memberID = :memberID') ;
			$stmt->execute(array(':memberID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post' class="pb-5">
		<input type='hidden' class="form-control" name='memberID' value='<?php echo $row['memberID'];?>'>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Pseudo</label><br />
			<input type='text' class="form-control" name='username' value='<?php echo $row['username'];?>'></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Nouveau mot de passe</label><br />
			<input type='password' class="form-control" name='password' value=''></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Confirmer le mot de passe</label><br />
			<input type='password' class="form-control" name='passwordConfirm' value=''></p>
		</div>

		<div class="form-group col">
			<p class="font-weight-bold"><label>Email</label><br />
			<input type='text' class="form-control" name='email' value='<?php echo $row['email'];?>'></p>
		</div>

		<button class="btn btn-custom btn-add d-block mx-auto" type='submit' name='submit'>Mettre à jour</button>

	</form>
	<?php include('menu-footer.php');?>
</div>

</body>
</html>	
