<?php
include "./includes/MySQL.php";

$requete200 = ("SELECT * FROM maintenance WHERE id = 1");
$maintenance = $mysqli->query($requete200);
$maintenance = mysqli_fetch_assoc($maintenance);
if($maintenance['statut_site'] == 1){
header('location: ./index.php');
}
?>

<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>M2L: Maintenance</title>
	
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<link rel="stylesheet" href="web-gallery/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" href="web-gallery/css/style.css"/>
		<link rel="icon" type="image/png" href="web-gallery/img/favicon.ico" />

<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

</head>
<body>

<article>
    <h1>
                    :) Oops!</h1>
                <h2>
                    La M2L est temporairement hors ligne pour maintenance</h2>
                <h1>
                    Nous revenons très vite !</h1>
                <div>
                    <p>
                        Désolé pour le dérangement mais nous effectuons une maintenance pour le moment.
                        Nous serons de retour en ligne prochainement.</p>
                    <p>
                        — La maison des ligues</p>
        
        <a href="index.php" style="margin-top: 10px;" class="btn btn-danger"><span class="glyphicon glyphicon-home">
                    </span> Cliquez ici pour essayer de retourner sur l'accueil </a>
    </div>
</article>
<br><br><br><br><br><br><br>

        <a href="./administration/login.php" style="margin-top: 10px;" class="btn btn-link"><u>Accès administrateur</u></a>
</body>	
		<div id='preloader'><div class='preloader'></div></div>
		<script type="text/javascript" src="web-gallery/js/jquery.min.js"></script>
		<script type="text/javascript" src="web-gallery/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="web-gallery/js/main.js"></script>	
</html>