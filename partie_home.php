<?php
    session_start();
    include_once "./data/MyPDO.projet-php-dictature.include.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Interactive Space Story</title>
	</head>

	<body>
		<h1>BIENVENUE SUR NOTRE SITE</h1>
		<div id="screen">
				<div id="main-text">Que souhaitez-vous faire ?</div>
				<button class="button" id="button-start" type="button">Me réveiller</button>
				<button class="button" id="button-profile" type="button">Consulter mon profil</button>
		</div>
	</body>

	<script src="./js/partie_home_form.js"></script>
</html>