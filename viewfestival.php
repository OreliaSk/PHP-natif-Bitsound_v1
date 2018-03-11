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
    <?php include('partials/head.php'); ?>
    <title>Festival - <?php echo $row['title'];?></title>
</head>
<body>

	<div class="container-fluid wrapper-festival" id="wrapper">
		<div class="container festival-detail">
			<?php include('partials/navbar.php'); ?>
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
	<?php include('partials/scripts.php'); ?>
</body>
</html>