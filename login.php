<?php
include "./includes/MySQL.php";
session_start();
if(isset($_POST['connexion'])) {
    if(empty($_POST['pseudo'])) {
        echo '<script>
   		alert("Le champ identifiant est vide.");
</script>';
    } else {
        if(empty($_POST['mdp'])) {
              echo '<script>
   		alert("Le champ mot de passe est vide.");
</script>';
        } else {
            $Pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES, "ISO-8859-1"); 
            $MotDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "ISO-8859-1");
            if($mysqli!=null){
                $Requete = mysqli_query($mysqli,"SELECT * FROM association WHERE identifiant_association = '".$Pseudo."' AND mdp_association = '".$MotDePasse."'");
                if(mysqli_num_rows($Requete) == 0) {
                  echo '<script>
   		alert("Identifiant ou mot de passe incorrect.");
</script>';
                } else {
		 if ($_GET['id'] != NULL && $_GET['date'] != NULL){
            $_SESSION['pseudo'] = $Pseudo;
    echo '<script LANGUAGE="JavaScript">document.location.href="index.php?id='.$_GET['id'].'&page=2&date='.$_GET['date'].'"</script>';
    
} else {
        $_SESSION['pseudo'] = $Pseudo;
echo '<script LANGUAGE="JavaScript">
document.location.href="index.php"
</script>';
    
               		}
        	   	}
      		}
    	}
	}
}

$requete200 = ("SELECT * FROM maintenance WHERE id = 1");
$maintenance = $mysqli->query($requete200);
$maintenance = mysqli_fetch_assoc($maintenance);
if($maintenance['statut_site'] == 0){
header('location: ./maintenance.php');
}


    ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>M2L: Connexion</title>
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="web-gallery/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="web-gallery/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" href="web-gallery/css/style.css"/>
				<link rel="icon" type="image/png" href="web-gallery/img/favicon.ico" />

    </head>
	<body>
		<header id="header" class="transparent-nav">
			<div class="container">
				<div class="navbar-header">
					<div class="navbar-brand">
						<a class="logo" href="index.php">
							<img src="./web-gallery/img/logo-alt.png" alt="logo">
						</a>
					</div>
					<button class="navbar-toggle">
						<span></span>
					</button>
				</div>
				<nav id="nav">
					<ul class="main-menu nav navbar-nav navbar-right">
					<li><a href="index.php">Formations</a></li>
					<?php
					if ($_SESSION['pseudo'] != NULL){
					echo '<li><a href="panel.php">Panel personnel</a></li>';
					echo '<li><a href="logout.php">Déconnexion</a></li>'; 
					} else {
					echo '<li><a href="register.php">Inscription</a></li>';
					}
					?>
					</ul>
				</nav>
			</div>
		</header>
		<div id="home" class="hero-area">
			<div class="bg-image bg-parallax overlay" style="background-image:url(./web-gallery/img/login.jpg)"></div>
									<div class="home-wrapper">
				<div class="container">
					<div class="row">
					<?php
					if ($_SESSION['pseudo'] != NULL){
					echo '<script LANGUAGE="JavaScript">document.location.href="./index.php"</script>';
					} else {
					
					$c = $_GET['id'];	
					$d = $_GET['date'];
						
					if ($_GET['id'] == NULL && $_GET['date'] == NULL) {
					echo '<center><h1 class="white-text">Connexion sur votre panel personnel</h1>
					<p class="lead white-text">Veuillez saisir votre identifiant et votre mot de passe</p></center>';
					echo' <form action="login.php" method="post"> 
					<input type="text" name="pseudo" placeholder="Identifiant..."/> <br><br>
					<input type="password" name="mdp" placeholder="Mot de passe..." /> <br> <br>
					<center><input type="submit" name="connexion" value="Connexion" class="main-button"></center> </br>
					<a href="./register.php">Vous n\'êtes pas encore inscrit ?</a>
					</form>';
					} else {
					echo '<center><h1 class="white-text">Connexion sur votre panel personnel</h1>
					<p class="lead white-text">Veuillez saisir votre identifiant et votre mot de passe pour continuer l\'inscription à votre formation</p></center>';
					echo ' <form action="login.php?id='.$c.'&date='.$d.'"" method="post"> 
					<input type="text" name="pseudo" placeholder="Identifiant..."/> <br><br>
					<input type="password" name="mdp" placeholder="Mot de passe..." /> <br> <br>
					<center><input type="submit" name="connexion" value="Connexion" class="main-button"></center> </br>
					<a href="./register.php">Vous n\'êtes pas encore inscrit ?</a>';
					 }
					 }
					?>
 </div> </div> </div> </div> </div>
		<footer id="footer" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="footer-logo">
							<a class="logo" href="index.php">
								<img src="./web-gallery/img/logo.png" alt="logo">
							</a>
						</div>
					</div>
					<div class="col-md-6">
						<ul class="footer-nav">
					<li><a href="index.php">Formations</a></li>
					<?php
					if ($_SESSION['pseudo'] != NULL){
					echo '<li><a href="panel.php">Panel personnel</a></li>'; 
					echo '<li><a href="logout.php">Déconnexion</a></li>';
					} else {
					echo '<li><a href="register.php">Inscription</a></li>';
					}
					?>
						</ul>
					</div>
				</div>
						<div id="bottom-footer" class="row">
						<div class="footer-copyright">
						<center>&copy; 2018 - Maison des ligues</center>
						</div>
					</div>
		</footer>
		<div id='preloader'><div class='preloader'></div></div>
		<script type="text/javascript" src="web-gallery/js/jquery.min.js"></script>
		<script type="text/javascript" src="web-gallery/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="web-gallery/js/main.js"></script>

	</body>
</html>
