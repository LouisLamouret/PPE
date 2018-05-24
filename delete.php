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
		<title>M2L: Annuler une réservation</title>
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
				<div class="container">
					<div class="row">
				<a href="index.php"><img src="./web-gallery/img/logo.png"></a>
				<h2 class="white-text"><u>Annuler une réservation</u></h2>	
				<h3 class="white-text"><u>Veuillez séléctionner une réservation à supprimer</u></h3>
				<?php

echo '<center><form name="requete" method="POST" action="delete.php">';
    
echo ('<select name="_choix">');

$resultat=$mysqli->query("SELECT concat(stagiaire.nom_stagiaire, ' ',stagiaire.prenom_stagiaire, ' - ',session_formation.date_debut_session, ' - ',formation.libelle_formation) AS test, session_formation_has_formation.session_formation_id_session AS id1
FROM stagiaire, interlocuteur, session_formation_has_formation, session_formation, formation, association
WHERE stagiaire.interlocuteur_id_interlocuteur = interlocuteur.id_interlocuteur
AND stagiaire.id_stagiaire = session_formation_has_formation.stagiaire_id_stagiaire
AND session_formation_has_formation.session_formation_id_session = session_formation.id_session
AND session_formation_has_formation.formation_id_formation = formation.id_formation
AND interlocuteur.id_interlocuteur = association.interlocuteur_id_interlocuteur
AND formation.room_id is null
AND association.identifiant_association='".$_SESSION['pseudo']."'");

while ($ligne1 =$resultat->fetch_assoc()) {

echo "<option value=\"".$ligne1['id1']."\">".$ligne1['test'].'</option>';

}

echo ('</select>
<br><br>

     <input type="submit" name="valider" value="Annuler la réservation" class="main-button"/>
     
    </form></center>');
    
if(isset($_POST['valider'])){

$choix =$_POST['_choix'];

$requete = "DELETE from session_formation_has_formation WHERE session_formation_id_session=". $choix .";";

$resultat = $mysqli->query($requete); 

}

?>
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
