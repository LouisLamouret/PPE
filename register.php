<?php
include "./includes/MySQL.php";
session_start();
if(isset($_POST['connexion'])) {
    if(empty($_POST['pseudo'])) {
        echo '<script>
   		alert("Le champ pseudo est vide.");
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

 	 						if(isset($_POST['_inscription'])){
 	 						
 	 	$tmp=$mysqli->query("SELECT id_association FROM association WHERE identifiant_association='".$_POST['_login']."' LIMIT 1") or die(mysql_error());
 	 	$tmp=mysqli_num_rows($tmp);

    if(empty($_POST['_association'])) {
                 echo '<script>
   		alert("Le champ nom association est vide.");
</script>';
		$failure = true;
    } else {
    
        if(empty($_POST['_icom'])) {
        echo '<script>
   		alert("Le champ icom est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['_nom'])) {
         echo '<script>
   		alert("Le champ nom est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['_prenom'])) {
                     echo '<script>
   		alert("Le champ prénom est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['_fax'])) {
                     echo '<script>
   		alert("Le champ fax est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['_telephone'])) {
                     echo '<script>
   		alert("Le champ téléphone est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['_courriel'])) {
                     echo '<script>
   		alert("Le champ courriel est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['_login'])) {
                     echo '<script>
   		alert("Le champ login est vide.");
</script>';
		$failure = true;
        } else {
		
        if($tmp > 0){
		echo '<script>
   		alert("Votre pseudo est déjà utilisé.");
</script>';		$failure = true;
		} else {
        
         if(empty($_POST['_pass'])) {
                     echo '<script>
   		alert("Le champ mot de passe est vide.");
</script>';
		$failure = true;
		} else {
		
		if(empty($_POST['conditions'])) {
                     echo '<script>
   		alert("Vous devez accepter les CGU.");
</script>';
		$failure = true;
		} else {
	      	 
	      	 	if(strlen($_POST['_telephone']) < 10){
		echo '<script>
   		alert("Votre numéro de téléphone doit faire 10 caractères.");
</script>';
		$failure = true;
	      	 } else {
	      	 	if(strlen($_POST['_telephone']) > 10){
		echo '<script>
   		alert("Votre numéro de téléphone doit faire 10 caractères.");
</script>';
		$failure = true;
	      	 } else {
	      	 
	      	 	if(strlen($_POST['_fax']) < 10){
		echo '<script>
   		alert("Votre numéro de fax doit faire 10 caractères.");
</script>';
		$failure = true;
	      	 } else {
	      	 
	      	 	if(strlen($_POST['_fax']) > 10){
		echo '<script>
   		alert("Votre numéro de fax doit faire 10 caractères.");
</script>';
		$failure = true;
	      	 } else {
	      	 
	      		if($failure == false){
 						
 							$a = $_POST['_association'];
					$b = $_POST['_icom'];
					$c = $_POST['_nom'];
					$d = $_POST['_telephone'];
					$e = $_POST['_prenom'];
					$f = $_POST['_fax'];
					$g = $_POST['_courriel'];
					$h = $_POST['_login'];
					$i = $_POST['_pass'];
					$j = $_POST['conditions'];
					
$requete1 = ("INSERT INTO interlocuteur(id_interlocuteur, nom_interlocuteur, prenom_interlocuteur, courriel_interlocuteur, tel_interlocuteur, fax_interlocuteur) VALUES('', '". $c ."', '". $e ."', '". $g ."', '". $d ."', '". $f ."')")  or die(mysql_error());
$resultat1 = $mysqli->query($requete1);
$requete = ("INSERT INTO association(id_association, nom_association, icom_association, identifiant_association, mdp_association, interlocuteur_id_interlocuteur) VALUES('', '". $a ."', '". $b ."', '". $h ."', '". $i ."', ".$mysqli->insert_id.")") or die(mysql_error());
$resultat = $mysqli->query($requete);

      
          mysqli_free_result($resultat);
        	mysqli_free_result($resultat1);
    
        	 			$_SESSION['pseudo'] = $_POST['_login'];
						echo '<script type=text/javascript>document.location.replace("index.php")</script>';
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
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
		<title>M2L: Inscription</title>
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
			<div class="bg-image bg-parallax overlay" style="background-image:url(./web-gallery/img/register.jpg)"></div>
									<div class="home-wrapper">
				<div class="container">
					<div class="row">
					<?php
					if ($_SESSION['pseudo'] != NULL){
					echo '<script LANGUAGE="JavaScript">document.location.href="./index.php"</script>';

					} else {

					echo '<center><br><h1 class="white-text">Création de votre panel personnel</h1>
					<form action="register.php" method="post"> 
					<input type="text" name="_association" placeholder="Nom association..."/>
					<input type="text" name="_icom" placeholder="Numéro Icom..."/> <br><br>
					<center><p class="lead white-text"><u>L\'interlocuteur de votre association</u></p></center>
					<input type="text" name="_nom" placeholder="Nom..." />
					<input type="text" name="_telephone" placeholder="Téléphone..."/> <br><br>
					<input type="text" name="_prenom" placeholder="Prénom..." /> 
					<input type="text" name="_fax" placeholder="Fax..."/> <br><br>
					<input type="text" name="_courriel" placeholder="Courriel..." /> <br><br>
					<center><p class="lead white-text"><i><u>*Une association ne peut pas s\'inscrire plusieurs fois</u></i></p></center>
					<input type="text" name="_login" placeholder="Identifiant..."/> 
					<input type="password" name="_pass" placeholder="Mot de passe..." /> <br><br>
					<input type="checkbox" id="_cgu" name="conditions" value="conditionssite">
   					<label for="cgu">J\'accepte les CGU.</label><br><br>
					<input type="submit" name="_inscription" value="Inscription" class="main-button"> <br><br>
					<a href="./login.php">J\'ai déjà un compte.</a>
</form>';
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
