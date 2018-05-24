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
    ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>M2L: Accueil</title>
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="web-gallery/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="web-gallery/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" href="web-gallery/css/style.css"/>
		<link rel="icon" type="image/png" href="web-gallery/img/favicon.ico" />

    </head>
	<body>
	<?php
	echo '<body onLoad="document.location=\'#about\';">';
	$requete201 = ("SELECT * FROM maintenance WHERE id = 1");
$maintenance = $mysqli->query($requete201);
$maintenance = mysqli_fetch_assoc($maintenance);
if($maintenance['statut_site'] == 0){
header('location: ./maintenance.php');
}
	?>
		<header id="header" class="transparent-nav">
			<div class="container">
				<div class="navbar-header">
					<?php
					if ($_SESSION['pseudo'] != NULL){
					echo '<div class="navbar-brand2">';
					echo ('<p class="lead white-text">Vous êtes connecté en tant que: <b><u>'.$_SESSION['pseudo'].'</b></u></p>'); 
					} else {
					?>
					<div class="navbar-brand">
					<a class="logo" href="index.php">
							<img src="./web-gallery/img/logo-alt.png" alt="logo">
						</a>
					<?php }
					?>
					</div>
					<button class="navbar-toggle">
						<span></span>
					</button>
				</div>
				<nav id="nav">
					<ul class="main-menu nav navbar-nav navbar-right">
					<li><a href="index.php#about">Formations</a></li>
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
			<div class="bg-image bg-parallax overlay" style="background-image:url(./web-gallery/img/formations.jpg)"></div>
			<div class="home-wrapper">
				<div class="container">
					<div class="row">
						<center>
							<?php 
							if ($_SESSION['pseudo'] != NULL){
							echo '<center><a href="index.php"><img src="./web-gallery/img/logo.png"></a></center>';
							} 
							?>
							<h1 class="white-text">Bienvenue sur le site de la maison des ligues !</h1>
							<p class="lead white-text">Sur ce site, vous pourriez trouver une formation qui vous intéresse.</p>							
							<?php
							if ($_SESSION['pseudo'] == NULL){
							echo '
					<hr>
					<h4 class="white-text"><u>Connectez-vous dès maintenant</u></h4>
					</hr>
					<form action="index.php" method="post"> 
					<input type="text" name="pseudo" placeholder="Identifiant..."/> 
					<input type="password" name="mdp" placeholder="Mot de passe..." /> <br><br>
					<input type="submit" name="connexion" value="Connexion" class="main-button"> </form>';
							}
							?>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div id="about" class="section">
			<?php
			$requete200 = ("SELECT * FROM maintenance WHERE id = 1");
$maintenance = $mysqli->query($requete200);
$maintenance = mysqli_fetch_assoc($maintenance);
if($maintenance['statut_site'] == 0){
header('location: ./maintenance.php');
}
			
if ($_GET['page'] == NULL){
echo '<center><h1><u>Catalogue des formations</u></h1></center>';

	echo '<div class="div2">';
		echo '<h3>Veuillez choisir un domaine d\'activité</h3>';

echo '<center><form name="requete" method="POST" action="index.php">';
    
echo ('<select name="_choix">');

$resultat=$mysqli->query("SELECT id_domaine AS id1, libelle_domaine
FROM domaine");

while ($ligne =$resultat->fetch_assoc()) {

echo "<option value=\"".$ligne['id1']."\">".$ligne['libelle_domaine'].'</option>';

}

echo ('</select>
<br><br>

     <input type="submit" name="valider" value="Lancer la recherche par domaine" class="main-button"/>
     
    </form></center>');
    
if(isset($_POST['valider'])){

$choix =$_POST['_choix'];

$requete ="SELECT id_formation, libelle_formation
FROM formation
WHERE domaine_id_domaine=". $choix .";";
$resultat1 = $mysqli->query($requete); 
while ($ligne1 =$resultat1->fetch_assoc()) {
echo '<p><li><a href="index.php?id='.$ligne1["id_formation"].'&page=1">'.$ligne1["libelle_formation"].'</a></li></p>';

	}
}

	echo '</div>';
	echo '<div class="div3">';
	echo '<h3>Les 10 prochaines formations...</h3>';

				$resultat2=$mysqli->query("SELECT DISTINCT formation.id_formation, formation.libelle_formation
FROM formation, session_formation_has_formation, session_formation
WHERE formation.id_formation = session_formation_has_formation.formation_id_formation
AND session_formation_has_formation.session_formation_id_session = session_formation.id_session
AND session_formation.date_debut_session IS NOT NULL
ORDER BY session_formation.date_debut_session DESC LIMIT 10");
				echo '<ul class="liste">';
				while ($ligne2 =$resultat2->fetch_assoc()) {
				echo ' 
                  <li><a href="index.php?id='.$ligne2["id_formation"].'&page=1">'.$ligne2["libelle_formation"].'</a><br></li>
              ';
              
					}
				echo "</ul>";
			} 
			
			if ($_GET['page'] == 1){
			echo '<body onLoad="document.location=\'#about\';">';
				echo '<h1><u>Étape 1/4</u></h1>';

							$resultat3=$mysqli->query("select libelle_formation
				FROM formation
				WHERE id_formation='".$_GET['id']."'");
				while ($ligne3 =$resultat3->fetch_assoc()) {
				echo "<h2><u>Vous avez choisi comme formation:</u></h2><h4>".$ligne3['libelle_formation'].'</h4>';
				}
				
				echo '<h2><u>Descriptif de la formation</u></h2>';
				
				$resultat4=$mysqli->query("select description_formation
				FROM formation
				WHERE id_formation='".$_GET['id']."'");
				while ($ligne4 =$resultat4->fetch_assoc()) {
				echo "<h4>".$ligne4['description_formation'].'</h4>';
				}
				
				if ($_POST['_dates'] == NULL){
				echo '<h2><u>Date(s) disponible(s)</u></h2>';

				$resultat5=$mysqli->query("SELECT distinct date_debut_session, id_session
				FROM formation, session_formation, session_formation_has_formation
				WHERE session_formation.id_session = session_formation_has_formation.session_formation_id_session
				AND session_formation_has_formation.formation_id_formation = formation.id_formation
				AND formation.id_formation='".$_GET['id']."'");
				$row = mysqli_num_rows($resultat5);
				if($row < 1) {
				echo '<h4>Il n\'y a pas de date(s) disponible(s).</h4><br>';
				$resultat14=$mysqli->query("select nb_pers_mini_formation
				FROM formation
				WHERE id_formation='".$_GET['id']."'");
				while ($ligne14 =$resultat14->fetch_assoc()) {
				echo "<h4><i><u>*Nombre de participants minimum:</i></u> ".$ligne14['nb_pers_mini_formation'].'</h4>';
				}

				echo '<a class="main-button" id="retour" href="index.php">Retour</a>';
				echo '<a name="_bouton1" id="continuer" class="main-button" href="index.php?id='.$_GET['id'].'&page=1#">Indisponible</a>';

				} 
				
				echo '<form id="valider1" method="POST" action="index.php?id='.$_GET['id'].'&page=1">';		
				while ($ligne5 =$resultat5->fetch_assoc()) {
				    echo '
				    <input type="radio" id="choix1" name="_dates" onchange="this.form.submit();" value="'.$ligne5["id_session"].'">
   					 <label for="choix1"><h4>'.$ligne5["date_debut_session"].'</h4></label><br>';
   					}
				echo '</form>';
	
				}
				if($row >= 1) {

				echo '<a class="main-button" id="retour" href="index.php">Retour</a>';
				echo '<a name="_bouton2" id="continuer" class="main-button" href="index.php?id='.$_GET['id'].'&page=2&date='.$_POST['_dates'].'">Continuer</a>';
				} else {

				}
					
			if ($_POST['_dates'] != NULL){

				echo '<h2><u>Date choisie</u></h2>';
				$resultat10=$mysqli->query("SELECT date_debut_session FROM session_formation WHERE id_session='".$_POST['_dates']."'");
				while ($ligne10 =$resultat10->fetch_assoc()) {
				echo "<h4>Vous avez séléctionné: ".$ligne10['date_debut_session'].'</h4>';
				}
				$resultat6=$mysqli->query("select nb_pers_mini_formation
				FROM formation
				WHERE id_formation='".$_GET['id']."'");
				while ($ligne6 =$resultat6->fetch_assoc()) {
				echo "<h4><i><u>*Nombre de participants minimum:</i></u> ".$ligne6['nb_pers_mini_formation'].'</h4>';
				}
				
				
				echo '<a class="main-button" id="retour" href="index.php?id='.$_GET['id'].'&page=1">Retour</a>';
				echo '<a name="_bouton3" id="continuer" class="main-button" href="index.php?id='.$_GET['id'].'&page=2&date='.$_POST['_dates'].'">Continuer</a>';
				}
				}
				
				if ($_GET['page'] == 2) {
                                echo '<body onLoad="document.location=\'#about\';">';
                                $a = $_GET['date'];
                                $b = $_GET['id'];
                                if ($a == NULL){
                                        echo '<script>alert("Merci de choisir une date pour continuer.");</script>';
                                        echo '<script LANGUAGE="JavaScript">document.location.href="index.php?id='.$_GET['id'].'&page=1"</script>';
                                } else {
                                
                                					if($_SESSION['pseudo'] == NULL){
				echo '<script LANGUAGE="JavaScript">document.location.href="login.php?id='.$_GET['id'].'&date='.$_GET['date'].'"</script>';
					} else {

                if(isset($_POST['_inscription_stagiaire'])){
						
										$n1 = $_POST['nom1'];
                                        $p1 = $_POST['prenom1'];
                                        $s1 = $_POST['statut1'];
                                        $f1 = $_POST['fonction1'];
                                        $r1 = $_POST['repas1'];
                                        $n2 = $_POST['nom2'];
                                        $p2 = $_POST['prenom2'];
                                        $s2 = $_POST['statut2'];
                                        $f2 = $_POST['fonction2'];
                                        $r2 = $_POST['repas2'];
                                        $n3 = $_POST['nom3'];
                                        $p3 = $_POST['prenom3'];
                                        $s3 = $_POST['statut3'];
                                        $f3 = $_POST['fonction3'];
                                        $r3 = $_POST['repas3'];
                                        $n4 = $_POST['nom4'];
                                        $p4 = $_POST['prenom4'];
                                        $s4 = $_POST['statut4'];
                                        $f4 = $_POST['fonction4'];
                                        $r4 = $_POST['repas4'];
                                        $n5 = $_POST['nom5'];
                                        $p5 = $_POST['prenom5'];
                                        $s5 = $_POST['statut5'];
                                        $f5 = $_POST['fonction5'];
                                        $r5 = $_POST['repas5'];
										$valeur = "";
												
                        $failure1 = false;
                        $failure2 = false;
                        $failure3 = false;
                        $failure4 = false;
                        $failure5 = false;

			if(($n1==NULL) && ($p1==NULL) && ($f1==NULL)) {
                        $failure1 = true;
                } 
             if(($n2==NULL) && ($p2==NULL) && ($f2==NULL)) {
                        $failure2 = true;
                } 

             if(($n3==NULL) && ($p3==NULL) && ($f3==NULL)) {
                        $failure3 = true;
                 }
             if(($n4==NULL) && ($p4==NULL) && ($f4==NULL)) {
                        $failure4 = true;
                } 
             if(($n5==NULL) && ($p5==NULL) && ($f5==NULL)) {
                        $failure5 = true;
				}
                      

        if(($failure1 == true) && ($failure2 == true) && ($failure3 == true) && ($failure4 == true) && ($failure5 == true)){
        echo '<script>alert("Merci de compléter le tableau.");</script>';
        } else {
			if(($failure1 == false) && ($failure2 == true) && ($failure3 == true) && ($failure4 == true) && ($failure5 == true) && ($n1!=NULL) && ($p1!=NULL) && ($f1!=NULL)){
				
				$resultat99=$mysqli->query("SELECT DISTINCT association.interlocuteur_id_interlocuteur
                                        FROM association
                                        WHERE association.identifiant_association = '".$_SESSION['pseudo']."'");
                                        while ($ligne99 =$resultat99->fetch_assoc()) {
										$requete98 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n1."', '".$p1."', '".$s1."', '".$f1."', '".$r1."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat98 = $mysqli->query($requete98);
                                        }
				$valeur = 1;			
				echo '<script type=text/javascript>document.location.replace("index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$n1.'&var2='.$p1.'&var3='.$s1.'&var4='.$f1.'&var5='.$r1.'&valeur='.$valeur.'")</script>';
			}
			if(($failure1 == false) && ($failure2 == true) && ($failure3 == true) && ($failure4 == true) && ($failure5 == true) && (($n1==NULL) || ($p1==NULL) || ($f1==NULL))){
				echo '<script>alert("Il manque un ou plusieurs élément(s) dans le tableau.");</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == true) && ($failure4 == true) && ($failure5 == true) && ($n1!=NULL) && ($p1!=NULL) && ($f1!=NULL) && ($n2!=NULL) && ($p2!=NULL) && ($f2!=NULL)){
				
				$resultat99=$mysqli->query("SELECT DISTINCT association.interlocuteur_id_interlocuteur
                                        FROM association
                                        WHERE association.identifiant_association = '".$_SESSION['pseudo']."'");
                                        while ($ligne99 =$resultat99->fetch_assoc()) {
										$requete98 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n1."', '".$p1."', '".$s1."', '".$f1."', '".$r1."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat98 = $mysqli->query($requete98);
										$requete97 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n2."', '".$p2."', '".$s2."', '".$f2."', '".$r2."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat97 = $mysqli->query($requete97);
                                        }
				$valeur = 2;
				echo '<script type=text/javascript>document.location.replace("index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$n1.'&var2='.$p1.'&var3='.$s1.'&var4='.$f1.'&var5='.$r2.'&var6='.$n2.'&var7='.$p2.'&var8='.$s2.'&var9='.$f2.'&var10='.$r2.'&valeur='.$valeur.'")</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == true) && ($failure4 == true) && ($failure5 == true) && (($n1==NULL) || ($p1==NULL) || ($f1==NULL) || ($n2==NULL) || ($p2==NULL) || ($f2==NULL))){
				echo '<script>alert("Il manque un ou plusieurs élément(s) dans le tableau.");</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == false) && ($failure4 == true) && ($failure5 == true) && ($n1!=NULL) && ($p1!=NULL) && ($f1!=NULL) && ($n2!=NULL) && ($p2!=NULL) && ($f2!=NULL) && ($n3!=NULL) && ($p3!=NULL) && ($f3!=NULL)){
				
				$resultat99=$mysqli->query("SELECT DISTINCT association.interlocuteur_id_interlocuteur
                                        FROM association
                                        WHERE association.identifiant_association = '".$_SESSION['pseudo']."'");
                                        while ($ligne99 =$resultat99->fetch_assoc()) {
										$requete98 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n1."', '".$p1."', '".$s1."', '".$f1."', '".$r1."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat98 = $mysqli->query($requete98);
										$requete97 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n2."', '".$p2."', '".$s2."', '".$f2."', '".$r2."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat97 = $mysqli->query($requete97);
										$requete96 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n3."', '".$p3."', '".$s3."', '".$f3."', '".$r3."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat96 = $mysqli->query($requete96);
                                        }
				$valeur = 3;
				echo '<script type=text/javascript>document.location.replace("index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$n1.'&var2='.$p1.'&var3='.$s1.'&var4='.$f1.'&var5='.$r1.'&var6='.$n2.'&var7='.$p2.'&var8='.$s2.'&var9='.$f2.'&var10='.$r2.'&var11='.$n3.'&var12='.$p3.'&var13='.$s3.'&var14='.$f3.'&var15='.$r3.'&valeur='.$valeur.'")</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == false) && ($failure4 == true) && ($failure5 == true) && (($n1==NULL) || ($p1==NULL) || ($f1==NULL) || ($n2==NULL) || ($p2==NULL) || ($f2==NULL) || ($n3==NULL) || ($p3==NULL) || ($f3==NULL))){
				echo '<script>alert("Il manque un ou plusieurs élément(s) dans le tableau.");</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == false) && ($failure4 == false) && ($failure5 == true) && ($n1!=NULL) && ($p1!=NULL) && ($f1!=NULL) && ($n2!=NULL) && ($p2!=NULL) && ($f2!=NULL) && ($n3!=NULL) && ($p3!=NULL) && ($f3!=NULL) && ($n4!=NULL) && ($p4!=NULL) && ($f4!=NULL)){
				
				$resultat99=$mysqli->query("SELECT DISTINCT association.interlocuteur_id_interlocuteur
                                        FROM association
                                        WHERE association.identifiant_association = '".$_SESSION['pseudo']."'");
                                        while ($ligne99 =$resultat99->fetch_assoc()) {
										$requete98 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n1."', '".$p1."', '".$s1."', '".$f1."', '".$r1."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat98 = $mysqli->query($requete98);
										$requete97 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n2."', '".$p2."', '".$s2."', '".$f2."', '".$r2."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat97 = $mysqli->query($requete97);
										$requete96 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n3."', '".$p3."', '".$s3."', '".$f3."', '".$r3."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat96 = $mysqli->query($requete96);
										$requete95 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n4."', '".$p4."', '".$s4."', '".$f4."', '".$r4."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat95 = $mysqli->query($requete95);
                                        }
				$valeur = 4;
				echo '<script type=text/javascript>document.location.replace("index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$n1.'&var2='.$p1.'&var3='.$s1.'&var4='.$f1.'&var5='.$r1.'&var6='.$n2.'&var7='.$p2.'&var8='.$s2.'&var9='.$f2.'&var10='.$r2.'&var11='.$n3.'&var12='.$p3.'&var13='.$s3.'&var14='.$f3.'&var15='.$r3.'&var16='.$n4.'&var17='.$p4.'&var18='.$s4.'&var19='.$f4.'&var20='.$r4.'&valeur='.$valeur.'")</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == false) && ($failure4 == false) && ($failure5 == true) && (($n1==NULL) || ($p1==NULL) || ($f1==NULL) || ($n2==NULL) || ($p2==NULL) || ($f2==NULL) || ($n3==NULL) || ($p3==NULL) || ($f3==NULL) || ($n4==NULL) || ($p4==NULL) || ($f4==NULL))){
				echo '<script>alert("Il manque un ou plusieurs élément(s) dans le tableau.");</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == false) && ($failure4 == false) && ($failure5 == false) && ($n1!=NULL) && ($p1!=NULL) && ($f1!=NULL) && ($n2!=NULL) && ($p2!=NULL) && ($f2!=NULL) && ($n3!=NULL) && ($p3!=NULL) && ($f3!=NULL) && ($n4!=NULL) && ($p4!=NULL) && ($f4!=NULL) && ($n5!=NULL) && ($p5!=NULL) && ($f5!=NULL)){
				
				$resultat99=$mysqli->query("SELECT DISTINCT association.interlocuteur_id_interlocuteur
                                        FROM association
                                        WHERE association.identifiant_association = '".$_SESSION['pseudo']."'");
                                        while ($ligne99 =$resultat99->fetch_assoc()) {
										$requete98 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n1."', '".$p1."', '".$s1."', '".$f1."', '".$r1."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat98 = $mysqli->query($requete98);
										$requete97 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n2."', '".$p2."', '".$s2."', '".$f2."', '".$r2."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat97 = $mysqli->query($requete97);
										$requete96 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n3."', '".$p3."', '".$s3."', '".$f3."', '".$r3."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat96 = $mysqli->query($requete96);
										$requete95 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n4."', '".$p4."', '".$s4."', '".$f4."', '".$r4."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat95 = $mysqli->query($requete95);
										$requete94 = ("INSERT INTO stagiaire(id_stagiaire, nom_stagiaire, prenom_stagiaire, statut_stagiaire, fonction_stagiaire, repas_stagiaire, interlocuteur_id_interlocuteur) VALUES('',  '".$n5."', '".$p5."', '".$s5."', '".$f5."', '".$r5."', '".$ligne99['interlocuteur_id_interlocuteur']."')")  or die(mysql_error());
                                        $resultat94 = $mysqli->query($requete94);
                                        }
				$valeur = 5;
				echo '<script type=text/javascript>document.location.replace("index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$n1.'&var2='.$p1.'&var3='.$s1.'&var4='.$f1.'&var5='.$r1.'&var6='.$n2.'&var7='.$p2.'&var8='.$s2.'&var9='.$f2.'&var10='.$r2.'&var11='.$n3.'&var12='.$p3.'&var13='.$s3.'&var14='.$f3.'&var15='.$r3.'&var16='.$n4.'&var17='.$p4.'&var18='.$s4.'&var19='.$f4.'&var20='.$r4.'&var21='.$n5.'&var22='.$p5.'&var23='.$s5.'&var24='.$f5.'&var25='.$r5.'&valeur='.$valeur.'")</script>';
			}
			if(($failure1 == false) && ($failure2 == false) && ($failure3 == false) && ($failure4 == false) && ($failure5 == false) && (($n1==NULL) || ($p1==NULL) || ($f1==NULL) || ($n2==NULL) || ($p2==NULL) || ($f2==NULL) || ($n3==NULL) || ($p3==NULL) || ($f3==NULL) || ($n4==NULL) || ($p4==NULL) || ($f4==NULL) || ($n5==NULL) || ($p5==NULL) || ($f5==NULL))){
				echo '<script>alert("Il manque un ou plusieurs élément(s) dans le tableau.");</script>';
			}
			
			}
                                                        
                                                
                                        
                                
                        }
                }
                                echo '<h1><u>Étape 2/4</u></h1>';
                                echo '<h2><u>Le(s) stagiaire(s) par ordre de priorité</u></h2>';

                                echo '<style>
.tableau_stagiaire {
  width:1000px;
  height:200px;
  text-align:center;
  border-collapse: separate;
  border-spacing: 0px;
  border: 1px solid black;
}
.tableau_stagiaire th, .tableau_stagiaire td {
  text-align:center;

  border: 1px solid black;
}
</style>
<form action="" name="tab_stagiaire" id="tab_stagiaire" method="post">
<center>
<h4><table class="tableau_stagiaire">
<tr><th></th><th><u>Nom</u></th><th><u>Prénom</u></th><th><u>Statut (Bénévole ou salarié)</u></th><th><u>Fonction</u></th><th><u>Repas* (Oui ou non)</u></th></tr>
<tr><td></td><td><input type="text" name="nom1"/></td><td><input type="text" name="prenom1"/></td><td><SELECT name="statut1" size="1"><OPTION>B<OPTION>S</SELECT></td><td><input type="text" name="fonction1"/></td><td><SELECT name="repas1" size="1"><OPTION>O<OPTION>N</SELECT></td></tr>
<tr><td><input type="checkbox" name="user2" onclick="colorer(2)"/></td><td><input type="text" name="nom2" id="nom2" disabled/></td><td><input type="text" name="prenom2" id="prenom2" disabled/></td><td><SELECT name="statut2" size="1"><OPTION>B<OPTION>S</SELECT></td><td><input type="text" name="fonction2" id="fonction2" disabled/></td><td><SELECT name="repas2" size="1"><OPTION>O<OPTION>N</SELECT></td></tr>
<tr><td><input type="checkbox" name="user3" onclick="colorer(3)"/></td><td><input type="text" name="nom3" id="nom3" disabled/></td><td><input type="text" name="prenom3" id="prenom3" disabled/></td><td><SELECT name="statut3" size="1"><OPTION>B<OPTION>S</SELECT></td><td><input type="text" name="fonction3" id="fonction3" disabled/></td><td><SELECT name="repas3" size="1"><OPTION>O<OPTION>N</SELECT></td></tr>
<tr><td><input type="checkbox" name="user4" onclick="colorer(4)"/></td><td><input type="text" name="nom4" id="nom4" disabled/></td><td><input type="text" name="prenom4" id="prenom4" disabled/></td><td><SELECT name="statut4" size="1"><OPTION>B<OPTION>S</SELECT></td><td><input type="text" name="fonction4" id="fonction4" disabled/></td><td><SELECT name="repas4" size="1"><OPTION>O<OPTION>N</SELECT></td></tr>
<tr><td><input type="checkbox" name="user5" onclick="colorer(5)"/></td><td><input type="text" name="nom5" id="nom5" disabled/></td><td><input type="text" name="prenom5" id="prenom5" disabled/></td><td><SELECT name="statut5" size="1"><OPTION>B<OPTION>S</SELECT></td><td><input type="text" name="fonction5" id="fonction5" disabled/></td><td><SELECT name="repas5" size="1"><OPTION>O<OPTION>N</SELECT></td></tr>
</table></h4></center>';
						echo '<script type="text/javascript">
						function colorer(num){
							var nom=document.getElementById("nom"+num);
							var prenom=document.getElementById("prenom"+num); 
							var fonction=document.getElementById("fonction"+num);
							nom.disabled = false;
							prenom.disabled = false;
							fonction.disabled = false;
						}
						function verifier(formulaire){
							if(formulaire.tab_stagiaire.nom2 ==""){
								alert("saisir le nom")
							}
							if(formulaire.tab_stagiaire.prenom2 ==""){
								alert("saisir le prenom")
							}
							if(formulaire.tab_stagiaire.fonction2 ==""){
								alert("saisir la fonction")
							}
						}</script>';
						
                        echo '<h2><u>Documents à envoyer suite à cette inscription</u></h2>';

echo'<h4><p>Un chèque de caution de 50€ libellé à l’ordre du CROSL (ce chèque vous sera rendu à l’issue de votre participation effective au stage).</p>
<p>Un chèque pour paiement de la formation pour les nom cotisants auprès d’Uniformation au titre du plan et de la professionnalisation libellé au nom de l’organisme de formation.</p></h4>';

                                        echo '<a class="main-button" id="retour" href="index.php?id='.$_GET['id'].'&page=1">Retour</a>';
                                        echo '<input type="submit" name="_inscription_stagiaire" value="Continuer" class="main-button" id="continuer">';
                                        echo '</form>';
                                }
				}
				if ($_GET['page'] == 3) {
				if($_SESSION['pseudo'] == NULL){
				echo '<script LANGUAGE="JavaScript">document.location.href="login.php?id='.$_GET['id'].'&date='.$_GET['date'].'"</script>';
				} else {
				echo '<body onLoad="document.location=\'#about\';">';
				$d= $_GET['date'];
				$valeur = $_GET['valeur']; 
				if($_POST['suggestion'] == NULL){
				$failure = true;
   				}  else { 
    			if($failure == false){
					$resultat19=$mysqli->query("SELECT distinct suggestions.interlocuteur_id_interlocuteur
					FROM association, interlocuteur, suggestions
					WHERE association.interlocuteur_id_interlocuteur = interlocuteur.id_interlocuteur
					AND interlocuteur.id_interlocuteur = suggestions.interlocuteur_id_interlocuteur
					AND association.identifiant_association = '".$_SESSION['pseudo']."'");
					while ($ligne19 =$resultat19->fetch_assoc()) {
					$requete18 = ("INSERT INTO suggestions(id_suggestion, description_suggestion, interlocuteur_id_interlocuteur) VALUES('', '". str_replace("'","\'",$_POST['suggestion']) ."', '" .$ligne19['interlocuteur_id_interlocuteur']. "')")  or die(mysql_error());
					$resultat18 = $mysqli->query($requete18);
					mysqli_free_result($resultat18);
					}
				}
			}
					$a = $_GET['date'];
					echo '<h1><u>Étape 3/4</u></h1>';

					echo' <h2>Le public concerné par les formations</h2>
					<p><h4>Les actions sont accessibles en priorité aux salariés. Puis aux dirigeants bénévoles de toutes les associations sportives lorraines dans la limite des places disponibles.</h4></p>

					<h2>Les associations bénéficiaires adhérentes intégralement à Uniformation sont prioritaires</h2>
					<h4><b>Le règlement des frais de formation</b>
					<p>Les formations sont gratuites pour les associations qui versent la totalité de leurs contributions conventionnelles à Uniformation soit 1,67% de la masse salariale brute (1,62 % au titre de la formation professionnelle continue + 0,05 % au titre de l’aide au paritarisme).
					Uniformation règle directement les frais à l’organisme de formation.</p></h4>

					<h4>Les associations bénéficiaires non adhérentes intégralement à Uniformation.</h2>
					<h3><b>Le règlement des frais de formation</b>
					<p>Un chèque indiciel libellé au nom de l’organisme de formation sera à envoyer au CROSL à l’inscription.
					La recherche de financements du coût pédagogique est à votre charge.</p></h4>

					<h2>Prise en charge des frais de repas et de transport pour tous les participants d’associations sportives.</h2>
					<h4><p>Les plateaux repars proposés pour les formations en journée sont pris en charge par le CROSL.
					Pour les frais de transport, un formulaire vous sera remis par le CROSL durant la formation.
					Le remboursement se fera à l’association sur présentation d’un RIB.
					(transport entre le siège de l’association et le lieu de formation).</p></h4><br>';
					
					if ($_SESSION['pseudo'] != NULL) {
					if($_POST['suggestion'] != NULL){
					echo '<h4><u>Merci d\'avoir envoyé votre suggestion!</u></h4>';
					} else {
						if ($valeur==1){
							
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
					echo '<h3><u>Suggestions de formations que vous souhaiteriez voir proposés dans la prochaine offre:</u></h3>';
					echo '<form id="testsugg" onchange="submit();" name ="testsug" method="POST" action="index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&valeur='.$valeur.'">
					<textarea name="suggestion" id="sugge" placeholder="Suggestion(s)..."></textarea> <br><br>
					</form>';
						}
						if ($valeur==2){
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
					echo '<h3><u>Suggestions de formations que vous souhaiteriez voir proposés dans la prochaine offre:</u></h3>';
					echo '<form id="testsugg" onchange="submit();" name ="testsug" method="POST" action="index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&valeur='.$valeur.'">
					<textarea name="suggestion" id="sugge" placeholder="Suggestion(s)..."></textarea> <br><br>
					</form>';
						}
						if ($valeur==3){
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
					echo '<h3><u>Suggestions de formations que vous souhaiteriez voir proposés dans la prochaine offre:</u></h3>';
					echo '<form id="testsugg" onchange="submit();" name ="testsug" method="POST" action="index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var14='.$v15.'&valeur='.$valeur.'">
					<textarea name="suggestion" id="sugge" placeholder="Suggestion(s)..."></textarea> <br><br>
					</form>';
						}
						if ($valeur==4){
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
											$v16 = $_GET['var16'];
											$v17 = $_GET['var17'];
											$v18 = $_GET['var18'];
											$v19 = $_GET['var19'];
											$v20 = $_GET['var20'];
					echo '<h3><u>Suggestions de formations que vous souhaiteriez voir proposés dans la prochaine offre:</u></h3>';
					echo '<form id="testsugg" onchange="submit();" name ="testsug" method="POST" action="index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var14='.$v15.'&var16='.$v16.'&var17='.$v17.'&var18='.$v18.'&var19='.$v19.'&var20='.$v20.'&valeur='.$valeur.'">
					<textarea name="suggestion" id="sugge" placeholder="Suggestion(s)..."></textarea> <br><br>
					</form>';
						}
						if ($valeur==5){
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
											$v16 = $_GET['var16'];
											$v17 = $_GET['var17'];
											$v18 = $_GET['var18'];
											$v19 = $_GET['var19'];
											$v20 = $_GET['var20'];
											$v21 = $_GET['var21'];
											$v22 = $_GET['var22'];
											$v23 = $_GET['var23'];
											$v24 = $_GET['var24'];
											$v25 = $_GET['var25'];
					echo '<h3><u>Suggestions de formations que vous souhaiteriez voir proposés dans la prochaine offre:</u></h3>';
					echo '<form id="testsugg" onchange="submit();" name ="testsug" method="POST" action="index.php?id='.$_GET['id'].'&page=3&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var15='.$v15.'&var16='.$v16.'&var17='.$v17.'&var18='.$v18.'&var19='.$v19.'&var20='.$v20.'&var21='.$v21.'&var22='.$v22.'&var23='.$v23.'&var24='.$v24.'&var25='.$v25.'&valeur='.$valeur.'">
					<textarea name="suggestion" id="sugge" placeholder="Suggestion(s)..."></textarea> <br><br>
					</form>';
						}
					}
					}					
    				echo '
    				<script type="text/javascript">

  					function checkForm()
  					{
    				var form;
    				form = document.getElementById(\'valider\');
    				if(!form._cgu.checked) {
      					alert("Merci d\'accepter les conditions pour continuer.");
      					form._cgu.focus();
      					return false;
    				}
    				return true;
  					}

					</script>
					<form id="valider"> 
					<input type="checkbox" id="_cgu" name="conditions" value="conditionssite">
   					<label for="_cgu">J\'accepte les conditions ci-dessus.</label></form>';
					
										if($valeur==1) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];	
                                        echo '<a type="submit" name="_inscription" id="continuer" class="main-button" onclick="return checkForm();" href="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&valeur='.$valeur.'">Continuer</a>';
                                        }
                                        if($valeur==2) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
                                        echo '<a type="submit" name="_inscription" id="continuer" class="main-button" onclick="return checkForm();" href="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&valeur='.$valeur.'">Continuer</a>';
                                        }
                                        if($valeur==3) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
                                        echo '<a type="submit" name="_inscription" id="continuer" class="main-button" onclick="return checkForm();" href="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var14='.$v15.'&valeur='.$valeur.'">Continuer</a>';
                                        }
                                        if($valeur==4) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
											$v16 = $_GET['var16'];
											$v17 = $_GET['var17'];
											$v18 = $_GET['var18'];
											$v19 = $_GET['var19'];
											$v20 = $_GET['var20'];
                                        echo '<a type="submit" name="_inscription" id="continuer" class="main-button" onclick="return checkForm();" href="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var14='.$v15.'&var16='.$v16.'&var17='.$v17.'&var18='.$v18.'&var19='.$v19.'&var20='.$v20.'&valeur='.$valeur.'">Continuer</a>';
                                        }
                                        if($valeur==5) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
											$v16 = $_GET['var16'];
											$v17 = $_GET['var17'];
											$v18 = $_GET['var18'];
											$v19 = $_GET['var19'];
											$v20 = $_GET['var20'];
											$v21 = $_GET['var21'];
											$v22 = $_GET['var22'];
											$v23 = $_GET['var23'];
											$v24 = $_GET['var24'];
											$v25 = $_GET['var25'];
                                        echo '<a type="submit" name="_inscription" id="continuer" class="main-button" onclick="return checkForm();" href="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var15='.$v15.'&var16='.$v16.'&var17='.$v17.'&var18='.$v18.'&var19='.$v19.'&var20='.$v20.'&var21='.$v21.'&var22='.$v22.'&var23='.$v23.'&var24='.$v24.'&var25='.$v25.'&valeur='.$valeur.'">Continuer</a>';
										}

		}	
	}
				
				if ($_GET['page'] == 4) {
				if($_SESSION['pseudo'] == NULL){
				echo '<script LANGUAGE="JavaScript">document.location.href="login.php?id='.$_GET['id'].'&date='.$_GET['date'].'"</script>';
				} else {
				echo '<body onLoad="document.location=\'#about\';">';
				echo '<h1><u>Étape 4/4</u></h1>';
				$a = $_GET['date'];
				$valeur = $_GET['valeur'];
				
				echo '<h2><u>Résumé de votre réservation:</u></h2>';
				$resultat7=$mysqli->query("select libelle_formation
				FROM formation
				WHERE id_formation='".$_GET['id']."'");
				while ($ligne7 =$resultat7->fetch_assoc()) {
				echo "<h4>Formation: ".$ligne7['libelle_formation'].'</h4>';
				}	
				
				$resultat15=$mysqli->query("select date_debut_session
				FROM session_formation
				WHERE id_session='".$_GET['date']."'");
				while ($ligne15 =$resultat15->fetch_assoc()) {
				echo "<h4>Date et heure: ".$ligne15['date_debut_session'].'</h4>';
					}
					if($valeur==1) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
										echo '<h3>Premier stagiaire</h3>';
										echo '<h4>nom : '.$v1.'<br>prenom : '.$v2.'<br>statut : '.$v3.'<br>fonction : '.$v4.'<br>repas : '.$v5.'</h4>';
										//executer requete id stagiaire
										if(isset($_POST['insc'])){
										$vdate = $_GET['date'];
										$vid = $_GET['id'];
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v1."' AND stagiaire.prenom_stagiaire = '".$v2."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										echo '<script>alert("L\' utilisateur est bien ajouté");</script>';
										echo '<script type=text/javascript>document.location.replace("index.php")</script>';
										
										}
										
										
										echo '<form action="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&valeur='.$valeur.'" method="post">';
                                        echo '<input type="submit" id="continuer" class="main-button" name="insc" value="S\'inscrire">';
										echo '</form>';
										
                                        }
                                        if($valeur==2) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
                                        echo '<h3>Premier stagiaire</h3>';
										echo '<h4>nom : '.$v1.'<br>prenom : '.$v2.'<br>statut : '.$v3.'<br>fonction : '.$v4.'<br>repas : '.$v5.'</h4>';
										echo '<h3><br>Deuxième stagiaire</h3>';
										echo '<h4>nom : '.$v6.'<br>prenom : '.$v7.'<br>statut : '.$v8.'<br>fonction : '.$v9.'<br>repas : '.$v10.'</h4>';
										
										//executer requete id stagiaire
										if(isset($_POST['insc'])){
										$vdate = $_GET['date'];
										$vid = $_GET['id'];
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v1."' AND stagiaire.prenom_stagiaire = '".$v2."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 2eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v6."' AND stagiaire.prenom_stagiaire = '".$v7."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										echo '<script>alert("Les utilisateurs sont bien ajoutés");</script>';
										echo '<script type=text/javascript>document.location.replace("index.php")</script>';
										}
										
										
										
										echo '<form action="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&valeur='.$valeur.'" method="post">';
                                        echo '<input type="submit" id="continuer" class="main-button" name="insc" value="S\'inscrire">';
										echo '</form>';
                                        }
                                        if($valeur==3) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
                                        echo '<h3>Premier stagiaire</h3>';
										echo '<h4>nom : '.$v1.'<br>prenom : '.$v2.'<br>statut : '.$v3.'<br>fonction : '.$v4.'<br>repas : '.$v5.'</h4>';
										echo '<h3><br>Deuxième stagiaire</h3>';
										echo '<h4>nom : '.$v6.'<br>prenom : '.$v7.'<br>statut : '.$v8.'<br>fonction : '.$v9.'<br>repas : '.$v10.'</h4>';
										echo '<h3><br>Troisième stagiaire</h3>';
										echo '<h4>nom : '.$v11.'<br>prenom : '.$v12.'<br>statut : '.$v13.'<br>fonction : '.$v14.'<br>repas : '.$v15.'</h4>';
										
										//executer requete id stagiaire
										if(isset($_POST['insc'])){
										$vdate = $_GET['date'];
										$vid = $_GET['id'];
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v1."' AND stagiaire.prenom_stagiaire = '".$v2."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 2eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v6."' AND stagiaire.prenom_stagiaire = '".$v7."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 3eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v11."' AND stagiaire.prenom_stagiaire = '".$v12."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										echo '<script>alert("Les utilisateurs sont bien ajoutés");</script>';
										echo '<script type=text/javascript>document.location.replace("index.php")</script>';
										}
										
										
										
										echo '<form action="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var15='.$v15.'&valeur='.$valeur.'" method="post">';
                                        echo '<input type="submit" id="continuer" class="main-button" name="insc" value="S\'inscrire">';
										echo '</form>';
                                        }
                                        if($valeur==4) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
											$v16 = $_GET['var16'];
											$v17 = $_GET['var17'];
											$v18 = $_GET['var18'];
											$v19 = $_GET['var19'];
											$v20 = $_GET['var20'];
                                        echo '<h3>Premier stagiaire</h3>';
										echo '<h4>nom : '.$v1.'<br>prenom : '.$v2.'<br>statut : '.$v3.'<br>fonction : '.$v4.'<br>repas : '.$v5.'</h4>';
										echo '<h3><br>Deuxième stagiaire</h3>';
										echo '<h4>nom : '.$v6.'<br>prenom : '.$v7.'<br>statut : '.$v8.'<br>fonction : '.$v9.'<br>repas : '.$v10.'</h4>';
										echo '<h3><br>Troisième stagiaire</h3>';
										echo '<h4>nom : '.$v11.'<br>prenom : '.$v12.'<br>statut : '.$v13.'<br>fonction : '.$v14.'<br>repas : '.$v15.'</h4>';
										echo '<h3><br>Quatrième stagiaire</h3>';
										echo '<h4>nom : '.$v16.'<br>prenom : '.$v17.'<br>statut : '.$v18.'<br>fonction : '.$v19.'<br>repas : '.$v20.'</h4>';
										
										//executer requete id stagiaire
										if(isset($_POST['insc'])){
										$vdate = $_GET['date'];
										$vid = $_GET['id'];
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v1."' AND stagiaire.prenom_stagiaire = '".$v2."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 2eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v6."' AND stagiaire.prenom_stagiaire = '".$v7."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 3eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v11."' AND stagiaire.prenom_stagiaire = '".$v12."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 4eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v16."' AND stagiaire.prenom_stagiaire = '".$v17."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										echo '<script>alert("Les utilisateurs sont bien ajoutés");</script>';
										echo '<script type=text/javascript>document.location.replace("index.php")</script>';
										}
										
										
										
										echo '<form action="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var15='.$v15.'&var16='.$v16.'&var17='.$v17.'&var18='.$v18.'&var19='.$v19.'&var20='.$v20.'&valeur='.$valeur.'" method="post">';
                                        echo '<input type="submit" id="continuer" class="main-button" name="insc" value="S\'inscrire">';
										echo '</form>';
                                        }
                                        if($valeur==5) {
											$v1 = $_GET['var1'];
											$v2 = $_GET['var2'];
											$v3 = $_GET['var3'];
											$v4 = $_GET['var4'];
											$v5 = $_GET['var5'];
											$v6 = $_GET['var6'];
											$v7 = $_GET['var7'];
											$v8 = $_GET['var8'];
											$v9 = $_GET['var9'];
											$v10 = $_GET['var10'];
											$v11 = $_GET['var11'];
											$v12 = $_GET['var12'];
											$v13 = $_GET['var13'];
											$v14 = $_GET['var14'];
											$v15 = $_GET['var15'];
											$v16 = $_GET['var16'];
											$v17 = $_GET['var17'];
											$v18 = $_GET['var18'];
											$v19 = $_GET['var19'];
											$v20 = $_GET['var20'];
											$v21 = $_GET['var21'];
											$v22 = $_GET['var22'];
											$v23 = $_GET['var23'];
											$v24 = $_GET['var24'];
											$v25 = $_GET['var25'];
                                        echo '<h3>Premier stagiaire</h3>';
										echo '<h4>nom : '.$v1.'<br>prenom : '.$v2.'<br>statut : '.$v3.'<br>fonction : '.$v4.'<br>repas : '.$v5.'</h4>';
										echo '<h3><br>Deuxième stagiaire</h3>';
										echo '<h4>nom : '.$v6.'<br>prenom : '.$v7.'<br>statut : '.$v8.'<br>fonction : '.$v9.'<br>repas : '.$v10.'</h4>';
										echo '<h3><br>Troisième stagiaire</h3>';
										echo '<h4>nom : '.$v11.'<br>prenom : '.$v12.'<br>statut : '.$v13.'<br>fonction : '.$v14.'<br>repas : '.$v15.'</h4>';
										echo '<h3><br>Quatrième stagiaire</h3>';
										echo '<h4>nom : '.$v16.'<br>prenom : '.$v17.'<br>statut : '.$v18.'<br>fonction : '.$v19.'<br>repas : '.$v20.'</h4>';
										echo '<h3><br>Cinquième stagiaire</h3>';
										echo '<h4>nom : '.$v21.'<br>prenom : '.$v22.'<br>statut : '.$v23.'<br>fonction : '.$v24.'<br>repas : '.$v25.'</h4>';
										
										//executer requete id stagiaire
										if(isset($_POST['insc'])){
										$vdate = $_GET['date'];
										$vid = $_GET['id'];
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v1."' AND stagiaire.prenom_stagiaire = '".$v2."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 2eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v6."' AND stagiaire.prenom_stagiaire = '".$v7."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 3eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v11."' AND stagiaire.prenom_stagiaire = '".$v12."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 4eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v16."' AND stagiaire.prenom_stagiaire = '".$v17."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										// 5eme
										$resultat50 = $mysqli->query("SELECT stagiaire.id_stagiaire FROM stagiaire WHERE stagiaire.nom_stagiaire ='".$v21."' AND stagiaire.prenom_stagiaire = '".$v22."'");
										$row10 = $resultat50->fetch_row();
										$requete51 = ("INSERT INTO session_formation_has_formation(session_formation_id_session, formation_id_formation, formateurs_id, stagiaire_id_stagiaire) VALUES('".$vdate."', '".$vid."', NULL, '".$row10[0]."')")  or die(mysql_error());
										$resultat51 = $mysqli->query($requete51);
										echo '<script>alert("Les utilisateurs sont bien ajoutés");</script>';
										echo '<script type=text/javascript>document.location.replace("index.php")</script>';
										}
										
										
										
										echo '<form action="index.php?id='.$_GET['id'].'&page=4&date='.$a.'&var1='.$v1.'&var2='.$v2.'&var3='.$v3.'&var4='.$v4.'&var5='.$v5.'&var6='.$v6.'&var7='.$v7.'&var8='.$v8.'&var9='.$v9.'&var10='.$v10.'&var11='.$v11.'&var12='.$v12.'&var13='.$v13.'&var14='.$v14.'&var15='.$v15.'&var16='.$v16.'&var17='.$v17.'&var18='.$v18.'&var19='.$v19.'&var20='.$v20.'&var21='.$v21.'&var22='.$v22.'&var23='.$v23.'&var24='.$v24.'&var25='.$v25.'&valeur='.$valeur.'" method="post">';
                                        echo '<input type="submit" id="continuer" class="main-button" name="insc" value="S\'inscrire">';
										echo '</form>';
										}
				}	
			}		
				?> 
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
					<li><a href="index.php#about">Formations</a></li>
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