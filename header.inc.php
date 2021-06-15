<?php
$_VERSION = 2;

require_once ("films_fct.php");
session_start ();


write_log("Entrée dans header_inc");
write_log("----------------------");
/*
$trace_log = "debug.log";
write_log("\tpage en cours : ". $_SERVER["PHP_SELF"]);
if (! isset($_SESSION['Admin']))
	write_log("\tsession admin : non crée");
else
{ 
	if (!$_SESSION['Admin'])
		write_log("\tsession admin : non valide");
	else
		write_log("\tsession admin : OK !");
}
if (isset($Admin))
	write_log("\tmode admin : ". $Admin);
*/

function controlAdmin () 
{
	$Admin = false;

	write_log("    Entrée ControlAdmin");
	if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
	{
		$admins = readAdmin ();
		$nom = $_SERVER['PHP_AUTH_USER'];
		$pw = $_SERVER['PHP_AUTH_PW'];
		write_log("    ControlAdmin : $nom, $pw");
	
		foreach ($admins as $ad)
		{
			if (($ad[0] == $nom) && ($ad[1] == $pw))
			{
				$Admin = true;
				write_log("    ControlAdmin True !");
				break;
			}
		}
	}
	return $Admin;
}

/*
	Connection Administrative
	Vérification des identifiants, login et mot de passe.
*/
// Non connecté mais a entré l'authentication
if (! isset($_SESSION['Admin']) || !$_SESSION['Admin']) {
	if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
	{
		$Admin = controlAdmin ();
		if (!$Admin)
		{
			write_log("    raté...");
			// echo 'Texte utilisé si le visiteur utilise le bouton d\'annulation';
			$_SESSION['Admin'] = false;
			$Admin = false;
			// exit;
		}
		else {
			write_log("    réussi !");
			// echo "<p>Bonjour, {$_SERVER['PHP_AUTH_USER']}.</p>";
			// echo "<p>Votre mot de passe est {$_SERVER['PHP_AUTH_PW']}.</p>";
			$_SESSION['Admin'] = true;
			$Admin = true;
		}
	}
}
if (isset($_GET['cmd'])) {
	write_log("  cmd...");
	if ($_GET['cmd'] == "connect")
	{
	write_log("  connect...");
	if (! isset($_SESSION['Admin']) || !$_SESSION['Admin']) {
		write_log("  Authenticate...");
		// Recharge la feuille en demandant une authentication
		header('WWW-Authenticate: Basic realm="Gestion de site Acadra"');
		header('HTTP/1.0 401 Unauthorized');
	}
	else
	{
		write_log("    Session à true !");
		$_SESSION['Admin'] = true;
		$Admin = true;
	}
	}
	
	// Ne peut effacer le logon / pw de l'ancien admin
	// Why ?
	if ($_GET['cmd'] == "deconnect")
	{
	write_log("  deconnect...");
		$_SESSION['Admin'] = false;
		$Admin = false;
		// Détruit toutes les variables de session
		$_SESSION = array();
		unset ($_SESSION['Admin']);
		$_SERVER['PHP_AUTH_USER'] = "";
		$_SERVER['PHP_AUTH_PW'] = "";
		unset ($_SERVER['PHP_AUTH_USER']);
		unset ($_SERVER['PHP_AUTH_PW']);
		session_unset();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy ();
    	header('HTTP/1.0 401 Unauthorized');
	}
}
/*
if (isset($_GET['Admin'])) {
	if (! isset($_SESSION['Admin']))
	{
		require_once ("auth.php");
	}
	$Admin = $_SESSION['Admin'];
}
if ($_SESSION['Admin'])	
	echo "Admin = " . $_SESSION['Admin'];
else
	echo "Not admin = " . $_SESSION['Admin'];
*/
/*
if (! isset($_SESSION['Admin'])) {
	$Admin = false;
}
	if ($_POST['Admin'] == "Auth" && )

if (! isset($_SESSION['Admin'])) {
	$Admin = false;
}
else  {
	session_start ();
	$Admin = $_SESSION['Admin'];
}
*/

	// if (!session_is_registered("aFilms"))// !isset($_SESSION[$aFilms])) // || !
	if (isset($_SESSION['oFilms'])) 
	{
		$oFilms = $_SESSION['oFilms'];
		$aFilms = $oFilms->aFilms;
		/*
		echo "<pre>";
		print_r ($oFilms);
		echo "</pre>";
		*/
	}
	else 
	{
		$oFilms = new Film_Collection();
		$aFilms = $oFilms->readFilms ();
		
		$_SESSION['oFilms'] = $oFilms;
		/*
		echo "Session not set !<br>";
		echo "<pre>";
		print_r($oFilms);
		echo "</pre>";
		*/
	}

// On doit toujours avoir un IdFilm valide sauf 
// si l'on se trouve sur la page d'accueil 
$IdFilm = 0;
if (isset($_GET['IdFilm']))
	$IdFilm = $_GET['IdFilm'];
	
if ($IdFilm == 0)
	if (isset($_POST['IdFilm']))
		$IdFilm = $_POST['IdFilm'];

if ($IdFilm == 0)
	$IdFilm = $oFilms->IdFilm;
	
/*
if (isset($_POST["cmdAdmin"]) && $_POST["cmdAdmin"] == "Sauvegarder la fiche...")
{}
else
*/
{
	// $aFilm = readFilm ($IdFilm);
	if ($IdFilm != 0) {
	// if ($oFilms->IdFilm != $IdFilm)
	{
		$oFilms->IdFilm = $IdFilm;
		// $oFilms->oFilm = $oFilms->readFilm ($IdFilm);
	}
	// $aFilm = $oFilms->oFilm;
	}
}

$photoFiles = getPhotoArray($IdFilm, 1);
$currentPage = $_SERVER["PHP_SELF"];
$currentFile = basename($currentPage);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Acadra distribution</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="main.css" rel="stylesheet" type="text/css" />
<link href="vert.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- <img style="position:absolute; left:0; top:0; z-index:2 " src="affiche_tete_mini.gif" width="200" height="160" /> -->
<div id="global">

	<a id="top"></a>
	<div id="header">
<!-- 	  <img style="position:absolute; left:1; top:1;" src="affiche_tete_mini_2.gif" height="98" />
 -->
<!-- 	  
		<div align="left">
		<img class="logo" src="acadra50.jpg" width="213" height="70"/>
	  	</div>
 -->	
 	</div>
 	
	<div id="subheader">
		<?php if (isset ($Admin) && $Admin) { ?>
			<div class="adminmenuhead">
			<a href="admin.php">Admin</a>
			<?php if ($currentFile=="admin_film.php") { ?>
			<a href="film.php?IdFilm=<?php echo $IdFilm ?>">Fiche</a>
			<?php } ?>
			<?php if ($currentFile=="film.php") { ?>
			<a href="admin_film.php?IdFilm=<?php echo $IdFilm ?>">Modifier</a>
			<?php } ?>
			</div>
		<?php } ?>
		<div class="menuhead">
		<a href="index.php">Accueil</a>
		<a href="catalogue.php">Catalogue</a>
		<a href="contact.php">Contact</a>
		</div>
	</div>
	
	<div id="content">
