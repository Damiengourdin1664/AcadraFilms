<?php
require_once ("films_fct.php");
session_start(); 
$_SESSION['Admin'] = FALSE;

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
{
	$admins = readAdmin ();
	$nom = $_SERVER['PHP_AUTH_USER'];
	$pw = $_SERVER['PHP_AUTH_PW'];

	foreach ($admins as $ad)
	{
		if (($ad[0] == $nom) && ($ad[1] == $pw))
		{
			$_SESSION['Admin'] = TRUE;
			break;
		}
	}
/*
    echo "<pre>";
	print_r ($admins);
    echo "</pre>";
	
			echo "\n auth = TRUE";
		print_r ($ad);
		echo "\n".$ad[0];
		echo "\n".$ad[1];
		echo "\n".$nom;
		echo "\n".$pw;
		
		if ($ad[0] == $nom)
			echo "\nnom Ok !\n";
		if ($ad[1] == $pw)
			echo "\npw Ok !\n";
	if (!$auth)
	{
		unset ($_SERVER['PHP_AUTH_USER']);
		unset ($_SERVER['PHP_AUTH_PW']);
	}
    echo "<pre>";
	print_r ($aAdmin);
    echo "</pre>";
	
    echo "Ancien : {$_REQUEST['OldAuth']}";
    echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\">\n";
    echo "<input type=\"hidden\" name=\"SeenBefore\" value=\"1\">\n";
    echo "<input type=\"hidden\" name=\"OldAuth\" value=\"{$_SERVER['PHP_AUTH_USER']}\">\n";
    echo "<input type=\"submit\" value=\"Identification\">\n";
    echo "</form></p>\n";
*/
}

if (!$_SESSION['Admin'])
{
	authenticate();
}
?>
<?php

function authenticate() {
    header('WWW-Authenticate: Basic realm="Gestion de site Acadra"');
    header('HTTP/1.0 401 Unauthorized');
	include ('index.php');
	exit;
//    echo "Vous devez entrer un identifiant et un mot de passe valide pour accéder à la gestion du site.\n";
//    exit;
}
?>

