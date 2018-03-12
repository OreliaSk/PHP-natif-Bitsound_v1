<?php // On inclu fichier config
require_once('../includes/config.php');

$stmt = $db->prepare('SELECT messageId, pseudo, email, content, created_at FROM blog_messages WHERE messageId = :messageId');
$stmt->execute(array(':messageId' => $_GET['id']));
$row = $stmt->fetch(); 

// Si pas connecté, on redirige vers la page de login
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>Dashboard administrateur - Message visiteur</title>
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="menu-admin" id="wrapper">

	<?php include('menu-header.php');?>

	<h2 class="pb-3 pt-2 text-center">Message de <?php echo $row['pseudo']; ?></h2>

	
    <?php
    // Affichage d'un seul message (détail)
    echo '<div class="container">';
            echo '<p class="border p-2"><span class="font-weight-bold">Message de : </span>'.$row['pseudo'].'<br>
            <span class="font-weight-bold">Envoyé le : </span>'.date('j M Y', strtotime($row['created_at'])).'</p>';
            echo '<p class="border p-2"><span class="font-weight-bold">Contenu du message : </span><br>'.$row['content'].'</p>';
    echo '</div>';
	?>
    <a href="messages.php" class="btn btn-add">Retourner sur la liste des messages</a>
	<?php include('menu-footer.php');?>
</div>

</body>
</html>	
