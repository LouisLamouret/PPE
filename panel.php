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
                    $_SESSION['pseudo'] = $Pseudo;
echo '<script LANGUAGE="JavaScript">
document.location.href="index.php"
</script>';
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
		<title>M2L: Pannel personnel</title>
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
					<?php
					if ($_SESSION['pseudo'] != NULL){
					echo '<div class="navbar-brand2">';
					echo ('<p class="lead white-text">Vous êtes connecté en tant que: <b><u>'.$_SESSION['pseudo'].'</b></u></p>'); 
					} else {
						echo '<div class="navbar-brand1">';
echo '<script LANGUAGE="JavaScript">
document.location.href="index.php"
</script>'; }
					echo '</div>';

					?>
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
										if($_SESSION['pseudo'] == "admin"){
					echo '<li><a href="./administration">Administration</a></li>'; 
					}
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
			<div class="bg-image bg-parallax overlay" style="background-image:url(./web-gallery/img/panel.jpg)"></div>
			<div class="home-wrapper">
						<div class=container>
 				<div class=row>
				<a href="index.php"><img src="./web-gallery/img/logo.png"></a>
				<h2 class="white-text"><u>Vos informations personnelles</u></h2>
 
 <div class="div1" id="divgauche">
 <h3 class="white-text"><u>Association:</u></h3>
 <?php
				$resultat=$mysqli->query("select nom_association, icom_association, identifiant_association, mdp_association
				FROM association
				WHERE identifiant_association='".$_SESSION['pseudo']."'");
				while ($ligne1 =$resultat->fetch_assoc()) {
				echo "<p class='lead white-text'>Association: ".$ligne1['nom_association']."</p>
				<p class='lead white-text'>Icom: ".$ligne1['icom_association']."</p>
				<p class='lead white-text'>Identifiant: ".$ligne1['identifiant_association']."</p>
				<p class='lead white-text'>Mot de passe: ".$ligne1['mdp_association'].'</p>';
				}
				?>
 </div> 
<div class="div1" id="divdroite">
<h3 class="white-text"><u>Interlocuteur:</u></h3>

<?php
				$resultat1=$mysqli->query("select concat(nom_interlocuteur, ' ',prenom_interlocuteur) AS app, courriel_interlocuteur, tel_interlocuteur, fax_interlocuteur
				FROM interlocuteur, association
				WHERE interlocuteur.id_interlocuteur = association.interlocuteur_id_interlocuteur
				AND association.identifiant_association='".$_SESSION['pseudo']."'");
				while ($ligne2 =$resultat1->fetch_assoc()) {
				echo "<p class='lead white-text'>Nom/prénom: ".$ligne2['app']."</p>
				<p class='lead white-text'>Courriel: ".$ligne2['courriel_interlocuteur']."</p>
				<p class='lead white-text'>Téléphone: ".$ligne2['tel_interlocuteur']."</p>
				<p class='lead white-text'>Fax: ".$ligne2['fax_interlocuteur'].'</p>';
				}
				?>
</div><br/>
								<h2 class="white-text"><u>Veuillez sélectionner une option ci-dessous</u></h2>

 				<li><a href="resume.php" title="Modifier une séance" class="lead white-text">Résumé d'une réservation</a></li>
 				<li><a href="delete.php" title="Supprimer une séance" class="lead white-text">Annuler une réservation</a></li>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
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
										if($_SESSION['pseudo'] == "admin"){
					echo '<li><a href="./administration">Administration</a></li>'; 
					}
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
