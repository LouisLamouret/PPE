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
document.location.href="./index.php"
</script>';
                }
            }
        }
    }
 }

$requete201 = ("SELECT * FROM maintenance WHERE id = 1");
$maintenance = $mysqli->query($requete201);
$maintenance = mysqli_fetch_assoc($maintenance);
    if($_SESSION['pseudo'] == "admin") {
    header('location: ./index.php');
    }
    if($maintenance['statut_site'] == 1){
    header('location: ../index.php');

    }

    ?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>M2L: Connexion à l'administration</title>

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
                <a href="./login.php" class="simple-text">
                    Maison des ligues
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="login.php">
                        <i class="ti-user"></i>
                        <p>Connexion</p>
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
                    <a class="navbar-brand" href="login.php">Connexion à l'administration</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                    <?php if($_SESSION['pseudo'] == "admin") {
?>
                    <li>
                            <a href="../logout.php">
								<i class="ti-close"></i>
								<p>Déconnexion</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        
                
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <div class="card">
                        <br>
        			<form action="./login.php" method="post">
        			<div class="col-md-4">
					<input type="text" name="pseudo" class="form-control border-input" placeholder="Identifiant..."/>
					</div>
					<div class="col-md-4">
					<input type="password" name="mdp" class="form-control border-input" placeholder="Mot de passe..." /> 
					</div>
					<div class="col-md-30">
					<center><input type="submit" name="connexion" class="btn btn-info btn-fill btn-wd" value="Connexion" class="main-button"></center>
					</div>
					</form>
					                        <br>

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

</html>
