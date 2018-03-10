<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT festivalId, title, content, created_at FROM blog_festivals WHERE festivalId = :festivalId');
$stmt->execute(array(':festivalId' => $_GET['id']));
$row = $stmt->fetch();

// Si l'article à afficher n'existe pas, on redirige vers l'index
if($row['festivalId'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="blog about electro music">
	<meta name="keywords" content="blog electro music">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<![endif]-->
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/main.css">
    <title>Festival - <?php echo $row['title'];?></title>
</head>
<body>

	<div class="container-fluid wrapper-festival" id="wrapper">
		<div class="container festival-detail">
			<?php include('navbar.php'); ?>
			<h1 class="text-center"><?php echo $row['title'];?></h1>
			<hr />

			<!-- Affichage d'un seul festival (détail) -->
			<?php	
				echo '<div>';
					echo '<p class="text-center">
						<img class="admin-avatar" src="img/admin/user.png" alt="admin-avatar" />
						Admin 
						<img class="admin-crown" src="img/admin/crown.png" alt="crown-admin"/>
						 | '.date('j M Y', strtotime($row['created_at'])).
						'</p>';
					echo '<p>'.$row['content'].'</p>';				
				echo '</div>';
			?>

	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/rotating.js"></script>
</body>
</html>