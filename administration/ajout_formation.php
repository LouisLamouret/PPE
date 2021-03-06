<?php
include "../includes/MySQL.php";
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
  if($_SESSION['pseudo'] != "admin") {
header('location: ../index.php');
}

if(isset($_POST['_inscription'])){


    if(empty($_POST['newlibelle'])) {
                 echo '<script>
   		alert("Le champ libellé est vide.");
</script>';
		$failure = true;
    } else {
    
        if(empty($_POST['newiddomaine'])) {
        echo '<script>
   		alert("Le champ domaine de la formation est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['newpers'])) {
         echo '<script>
   		alert("Le champ nombre personne minimum est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['newtarif'])) {
                     echo '<script>
   		alert("Le champ tarif est vide.");
</script>';
		$failure = true;
        } else {
        
         if(empty($_POST['newdescription'])) {
                     echo '<script>
   		alert("Le champ description est vide.");
</script>';
		$failure = true;
        } else {

	      		if($failure == false){
 						
 					$a = $_POST['newlibelle'];
					$b = $_POST['newiddomaine'];
					$c = $_POST['newpers'];
					$d = $_POST['newtarif'];
					$e = $_POST['newdescription'];
					
$requete15 = ("INSERT INTO formation(id_formation, libelle_formation, description_formation, nb_pers_mini_formation, tarif_formation, domaine_id_domaine) VALUES('', '". $a ."', '". $e ."', '". $c ."', '". $d ."', '". $b ."')") or die(mysql_error());
$resultat15 = $mysqli->query($requete15);

      
          mysqli_free_result($resultat15);
              			echo '<script>alert("Formation ajoutée avec succès.");</script>';
						echo '<script type=text/javascript>document.location.replace("liste_formations.php")</script>';
																}
															}
														}
													}
												}
											}
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
                <li class="active" class="toggleSubMenu">
                    <a href="#">
                        <i class="ti-book"></i>
                        <p>GESTION FORMATIONS
</p>
                    </a>
                        <ul class="active"class="subMenu">
							<li><a href="liste_formations.php">Liste des formations</a></li>
							<li class="active"><a href="ajout_formation.php">Ajout d'une formation</a></li>
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
                                <li>
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
                    <a class="navbar-brand" href="ajout_formation.php">Ajout d'une formation</a>
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
				<div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Ajouter une formation</h4>
                            </div>
                            <div class="content">
                                <form method="POST" action="">
                                    <div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Libellé</label>
                                                <input type="text" class="form-control border-input" name="newlibelle" placeholder="Libellé">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Domaine de la formation</label>
												<select name="newiddomaine" class="form-control border-input">
												<?php $resultat=$mysqli->query("SELECT id_domaine AS id1, libelle_domaine FROM domaine");
												while ($ligne =$resultat->fetch_assoc()) {
												echo "<option value=\"".$ligne['id1']."\">".$ligne['libelle_domaine'].'</option>';
												} 
												?>
												</select>                                                    
											 </div>
                                        </div>
                                 	</div>
                                            <div class="row">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nb de pers minimum</label>
                                                <input type="text" class="form-control border-input" name="newpers" placeholder="Nombre de personne minimum">
                                            </div>
                                        </div>
                                    
                                          	<div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tarif</label>
                                                <input type="text" class="form-control border-input" name="newtarif" placeholder="Tarif">
                                            </div>
                                        </div>
                                    </div>
                                           <div class="col-md-20">
                                            <div class="form-group">
                                                <label>Description</label>
                    								<textarea rows="3" class="form-control border-input" name="newdescription" placeholder="Description"></textarea>
                                            </div>
                                        </div>


                                   
                                    <div class="text-center">
                                        <input type="submit" name="_inscription" value="Ajouter une nouvelle formation" class="btn btn-info btn-fill btn-wd">
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
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
