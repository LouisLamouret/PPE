<?php
include "../includes/MySQL.php";
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
   		alert("Pseudo ou mot de passe incorrect.");
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
  if($_SESSION['pseudo'] != "admin") {
header('location: ../index.php');
} else {
$requete = ("SELECT * FROM maintenance WHERE id = 1");
$maintenance = $mysqli->query($requete);
$maintenance = mysqli_fetch_assoc($maintenance);
}
    ?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>M2L: Administration</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="assets/css/preloader.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="./index.php" class="simple-text">
                    Maison des ligues
                </a>
            </div>

           <ul class="nav">
					<li>
                    <a href="index.php">
                        <i class="ti-home"></i>
                        <p>Accueil</p>
                    </a>
                </li>
					<li>
                    <a href="associations.php">
                        <i class="ti-bookmark"></i>
                        <p>Associations</p>
                    </a>
                </li>
				<li>
                    <a href="interlocuteurs.php">
                        <i class="ti-user"></i>
                        <p>Interlocuteurs</p>
                    </a>
                </li>
                                                	 <li>
                    <a href="stagiaires.php">
                        <i class="ti-id-badge"></i>
                        <p>Stagiaires</p>
                    </a>
                </li>
                <li class="toggleSubMenu">
                    <a href="#">
                        <i class="ti-book"></i>
                        <p>GESTION FORMATIONS
                                                <b class="caret"></b>                        
</p>
                    </a>
                        <ul class="subMenu">
							<li><a href="liste_formations.php">Liste des formations</a></li>
							<li><a href="ajout_formation.php">Ajout d'une formation</a></li>
							<li><a href="exam_formations.php">Examiner les formations</a></li>

   						</ul>
                </li>
				<li class="toggleSubMenu">
				
                    <a href="#">
                        <i class="ti-server"></i>
                        <p>GESTION DOMAINES
                                                <b class="caret"></b>                        
</p>
                    </a>
                        <ul class="subMenu">
							<li><a href="liste_domaines.php">Liste des domaines</a></li>
							<li><a href="ajout_domaine.php">Ajout d'un domaine</a></li>
   						</ul>
                </li>
                                				<li class="toggleSubMenu">
				
                    <a href="#">
                        <i class="ti-time"></i>
                        <p>GESTION SESSIONS
                                                <b class="caret"></b>                        

                        </p>
                    </a>
                        <ul class="subMenu">
							<li><a href="liste_sessions.php">Liste des sessions</a></li>
							<li><a href="ajout_session.php">Ajout d'une session</a></li>
   						</ul>
                </li>
                                      <li>
                    <a href="suggestions.php">
                        <i class="ti-comment-alt"></i>
                        <p>Suggestions</p>
                    </a>
                </li>
                <li class="active">
                    <a href="maintenance.php">
                        <i class="ti-pulse"></i>
                        <p>Maintenance</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="./maintenance.php">Maintenance</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                    <li>
                            <a href="../logout.php">
								<i class="ti-close"></i>
								<p>Déconnexion</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Modifier le statut du site</h4>
                            </div>
                       			 <div class="content table-responsive table-full-width">
  							<?php
  							if($maintenance['statut_site'] == 1){
  							echo '<center>Le site est actuellement <b>en ligne</b>.</center>';
  							} else {
  							echo '<center>Le site est actuellement <b>hors ligne</b>.</center>';	
  							}
  							
  							 echo '</br>';
  							 echo '<center><p>Veuillez cliquer sur le bouton ci-dessous pour changer l\'état du site.</p></center>';
  							if($maintenance['statut_site'] == 1){
  							 echo '<center><a href="?do=offline" class="btn btn-round btn-fill btn-default">Mettre le site en maintenance</a></center>';
  							} else {
  							 echo '<center><a href="?do=online" class="btn btn-info btn-fill">Mettre le site en ligne</a></center>';
  							}
  							 	$do = ($_GET['do']);
								if($do == "online") {								
								$requete = ("UPDATE maintenance SET statut_site = 1 WHERE id = 1");
								$resultat = $mysqli->query($requete);
								echo '<script>alert("Le site est maintenant en ligne.");</script>';
 								echo '<script LANGUAGE="JavaScript">document.location.href="./maintenance.php"</script>';
								} else {
								if($do == "offline") {								
								$requete1 = ("UPDATE maintenance SET statut_site = 0 WHERE id = 1");
								$resultat1 = $mysqli->query($requete1);
								echo '<script>alert("Le site est maintenant en maintenance.");</script>';
								header("./maintenance.php");
								}
							}
						?>
                            </div>
                        </div>
                    </div>
	            </div>
       		 </div>
       		        		 </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="../index.php">
                                Retour sur le site
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; 2018 - Maison des ligues
                </div>
            </div>
        </footer>

    </div>
</div>

</body>
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap-checkbox-radio.js"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
	<script src="assets/js/paper-dashboard.js"></script>
	<div id='preloader'><div class='preloader'></div></div>
	<script type="text/javascript" src="../web-gallery/js/jquery.min.js"></script>
	<script type="text/javascript" src="../web-gallery/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../web-gallery/js/main.js"></script>
	<script type="text/javascript">
$(document).ready( function () {
    // On cache les sous-menus :
    $(".nav ul.subMenu").hide();
    // On sélectionne tous les items de liste portant la classe "toggleSubMenu"

    // et on remplace l'élément span qu'ils contiennent par un lien :
    $(".nav li.toggleSubMenu span").each( function () {
        // On stocke le contenu du span :
        var TexteSpan = $(this).text();
        $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ;
    } ) ;

    // On modifie l'évènement "click" sur les liens dans les items de liste
    // qui portent la classe "toggleSubMenu" :
    $(".nav li.toggleSubMenu > a").click( function () {
        // Si le sous-menu était déjà ouvert, on le referme :
        if ($(this).next("ul.subMenu:visible").length != 0) {
            $(this).next("ul.subMenu").slideUp("normal");
        }
        // Si le sous-menu est caché, on ferme les autres et on l'affiche :
        else {
            $(".nav ul.subMenu").slideUp("normal");
            $(this).next("ul.subMenu").slideDown("normal");
        }
        // On empêche le navigateur de suivre le lien :
        return false;
    });    


} ) ;
</script> 
</html>
