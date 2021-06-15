<?php
	include ("header.inc.php");
	
	$aAd = readAdmin ();

/*
	echo "<pre>";
	print_r ($_POST);
	print_r ($_GET);
	echo "</pre>";
*/
	if (isset($_POST["nom"])) {
		$nom = $_POST["nom"];
	}
	if (isset($_POST["mdp"])) {
		$mdp = $_POST["mdp"];
	}
	
	
	// Traitement des mises à jour
	if (isset($_POST["Selection"]))
	{
		$cmdAdmin = $_POST["Selection"];
		
		// "Mettre à jour..."
		switch($cmdAdmin)
		{
			case "Valider":
				$aId = null;
				foreach ($selFilm as $f)
					$aId[] = $f;
				saveLastFilms ($aId);
				break;
		}
	}

	if (isset($_POST["cmdAdmin"])) {
		$cmdAdmin = $_POST["cmdAdmin"];
		switch($cmdAdmin)
		{
			case "Supprimer ce film":
				$IdFilm = $_POST['IdFilm'];
				$oFilms->deleteFilm ($IdFilm);
				$aFilms = $oFilms->deleteFilmFromList ($IdFilm);
				$oFilms->saveFilms ();
				$oFilms->IdFilm = 0;				
				$_SESSION['oFilms'] = $oFilms;
				break;
		}
	}
	if (isset($_POST["Supprimer"]))
	{
		$ar = $_POST["Supprimer"];
		$no = array_keys($ar);
		$no = $no[0];

		unset ($aAd[$no]);
		$aAd = array_values ($aAd);
		saveAdmin ($aAd);
	}
	if (isset($_POST["Modifier"]))
	{
		$ar = $_POST["Modifier"];
		$no = array_keys($ar);
		$no = $no[0];

		$aAd[$no] = array ($nom[$no], $mdp[$no]);
		saveAdmin ($aAd);
	}
	if (isset($_POST["Ajouter"]))
	{
		$no = count ($aAd);
		$aAd[] = array ($nom[$no], $mdp[$no]);
		saveAdmin ($aAd);
	}
?>
<style type="text/css">
<!--
/*
form {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
*/
/*
input, select {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	border:1px solid #0066CC;
	background-color:#DDDDDD;
}
.frmLink a{
	font-family: Arial, Helvetica, sans-serif;
	padding:1px 10px;
	border:1px solid #000000;
	background-color:#DDDDDD;
	color:#0066CC;
	text-decoration:none;
}
.frmLink a:hover {
	background-color:#CCCCCC;
	color:#0066CC; 
}
*/
-->
</style>
	<div id="left">
	<a href="index.php?cmd=deconnect"><img src="images/ange_acadra.jpg" width="80" border="0" /></a>
	</div>
	<div id="center">
		<h3>Gestion du site - Options g&eacute;n&eacute;rales</h3>
		<?php 
		if (!$Admin) {
    		echo "<p>Veuillez vous identifier <a href='admin.php'>ici</a> pour continuer<br/>";
			exit;
		}
		else
    		echo "<p>{$_SERVER['PHP_AUTH_USER']} est connecté en mode d'administration.";
		
		// $aAd = readAdmin ();
		$aId = GetLastFilms ();

		?>
		<p class="frmLink"><a href="index.php?cmd=deconnect">Déconnection</a></p>
	</div>
	
	<div style="clear:both"></div>
	<div style="margin-left:80px">

	    <h5>Administrateurs</h5>
		<p>Voici les administrateurs du site déjà enregistrés.</p>
		<form name="admins" target="_self" id="update" method="post" action="admin.php" >
		<table width="80%"  border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td>Nom</td>
				<td>Mot de passe</td>
			</tr>
			<?php for ($i=0; $i<count($aAd); $i++) { // foreach ($aAd as $ad) { ?>		
			<tr>
<!-- 				
					<td><input name="aAd[0][]" value="<?php echo $ad[0] ?>" type="text" id="nom"></td>
					<td><input name="ad[1][]" value="<?php echo $ad[1] ?>" type="text" id="mdp"></td>
					<td><input name="aAd[<?php echo $i ?>][0]" value="<?php echo $aAd[$i][0] ?>" type="text" id="nom"></td>
					<td><input name="aAd[<?php echo $i ?>][1]" value="<?php echo $aAd[$i][1] ?>" type="password" id="mdp"></td>
 -->				
					<td><input name="nom[<?php echo $i ?>]" value="<?php echo $aAd[$i][0] ?>" type="text" id="nom"></td>
					<td><input name="mdp[<?php echo $i ?>]" value="<?php echo $aAd[$i][1] ?>" type="password" id="mdp"></td>
<!-- 
					<td class="frmLink"><a href=<?php echo $currentPage ?>?cmdAdmin=Modifier&no=<?php echo $i ?>>Modifier</a></td>
					<td class="frmLink"><a href=<?php echo $currentPage ?>?cmdAdmin=Supprimer&no=<?php echo $i ?>>Supprimer</a></td>
 					<td><input type="submit" name="Bouton[Modifier][]" value="Modifier"></td>
					<td><input type="submit" name="Bouton[Supprimer][]" value="Supprimer"></td>
 -->
 					<td><input type="submit" name="Modifier[<?php echo $i ?>]" value="Modifier"></td>
					<td><input type="submit" name="Supprimer[<?php echo $i ?>]" value="Supprimer"></td>
			<tr>
			<?php } ?>
			<tr>
				<td><input name="nom[]" type="text" id="nom"></td>
				<td><input name="mdp[]" type="password" id="mdp"></td>
<!-- 				
				<td class="frmLink"><a href=<?php echo $currentPage ?>?cmdAdmin=Ajouter&no=<?php echo $i ?>>Ajouter</a></td>
 -->				
				<td><input type="submit" name="Ajouter" value="Ajouter"></td>
				<td></td>
			<tr>
		</table>
		</form>
		
		<p>&nbsp;</p>
	    <h5>Films à l'affiche</h5>
		<?php
		$options = "";
		$nbFilms = count ($aFilms);
		for ($i=0; $i < $nbFilms; $i++) {
			$aFilm = new Film($aFilms[$i]);
			$options .= '<option value="'. $aFilm->IdFilm .'">' . $aFilm->Titre . '</option>' . "\n";
		}			
		$nFilms[] = getFilmById($aFilms, $aId[0]);
		$nFilms[] = getFilmById($aFilms, $aId[1]);
		$nFilms[] = getFilmById($aFilms, $aId[2]);
		?>
		
  <!--
		<h1>Bienvenu sur le site d'Acadra. </h1>
	    <h2>Bienvenu sur le site d'Acadra. </h2>
	    <h3>Bienvenu sur le site d'Acadra. </h3>
	-->	    
	<p>Choisir les trois num&eacute;ros des affiches en page d'accueil.</p>
	<form name="film_index" target="_self" id="update" method="post" action="admin.php" >
		<table width="80%"  border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td>Film n&deg;1 </td>
			<td>Film n&deg;2</td>
			<td>Film n&deg;3</td>
		</tr>
		<tr>
			<?php for ($i=0; $i < 3; $i++) { ?>
				<td>
				<select style="width:150px" size="5" name="selFilm[]">
				<?php 				
				$old = '<option value="'. $nFilms[$i]->IdFilm .'">' . $nFilms[$i]->Titre . '</option>';
				$new = '<option selected value="'. $nFilms[$i]->IdFilm .'">' . $nFilms[$i]->Titre . '</option>';
				$option = str_replace ($old, $new, $options);
				echo $option;
				?>
				</select>
				</td>
			<?php } ?>
		</tr>
		</table>
    <p>
		<input type="submit" name="Selection" value="Valider">
    </p>
	</form>

	<p>&nbsp;</p>
	<h5>Liste des films</h5>

	<form action="admin_film.php" method="post" name="frmChoix" id="frmChoix">
		<table width="70%"  border="0" cellspacing="2" cellpadding="2">
			<tr>
			  <td width="70%">Modification de la fiche du film :</td> 
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td><?php 
				echo "<select name=\"IdFilm\" size=\"1\">\n";		
				echo $options;
				echo "</select>\n";	
				?>
			  </td>
			  <td><input type="submit" name="cmdAdmin" value="Modifier ce film"></td> 
			</tr>
		</table>
	</form>

	<p>&nbsp;</p>
	<h5>Ajouter - supprimer un film</h5>
	<form action="admin_film.php" method="post" name="frmChoix" id="frmChoix">		
		<table width="70%"  border="0" cellspacing="2" cellpadding="2">
			<tr>
			  <td width="70%">Création d'un film :</td> 
			  <td><input type="submit" name="cmdAdmin" value="Ajouter un film"></td>
			</tr>
		</table>
	</form>
	
	<form action="admin.php" method="post" name="frmChoix" id="frmChoix">		
		<table width="70%"  border="0" cellspacing="2" cellpadding="2">
			<tr>
			  <td width="70%">Suppression d'un film :</td> 
			  <td>&nbsp;</td> 
			</tr>
			<tr>
			  <td><?php 
				echo "<select name=\"IdFilm\" size=\"1\">\n";		
				echo $options;
				echo "</select>\n";	
				?>
			  </td>
			  <td><input type="submit" name="cmdAdmin" value="Supprimer ce film"></td>
			</tr>
		</table>
	</form>
	
	<?php if (false) { ?>

	<p>ou cliquez sur une affiche ou un titre pour modifier la fiche complète d'un film.</p>
	<table width="90%" bgcolor="#bbbbbb" cellpadding="10" cellspacing="1" style="border: 2px solid #E1FCAE">
	<?php 
	$nbFilms = count ($aFilms);
	for ($i=0; $i < $nbFilms; $i+=2) {
	?>
		<tr bgcolor= "#dddddd">
	<?php 
		for ($j=0; $j < 2; $j++) {
			if ($i+$j < $nbFilms) {
				$aFilm = new Film($aFilms[$i + $j]);		
			?>
			<td width="10%"><a href="admin_film.php?IdFilm=<?php echo $aFilm->IdFilm; ?>"><img class="cadre" style="float:left; margin:0 10px 0 0" src=<?php echo getAffiche ($aFilm->IdFilm) ?> alt="<?php echo $aFilm->Titre; ?>" height="50"/></a></td>
			<td width="40%"><p class="mylink"><a href="admin_film.php?IdFilm=<?php echo $aFilm->IdFilm; ?>"><?php echo $aFilm->Titre; ?></a><br>
			Film n° <?php echo $aFilm->IdFilm; ?><br>
			(<?php echo $aFilm->Titre_original; ?>)<br>
			de <?php echo $aFilm->Realisateur; ?>
			</td>
			<?php } ?>
		<?php } ?>
		</tr>
	<?php } ?>
	</table>

	<?php } ?>

	    <p>&nbsp;</p>
<?php
	include ("footer.inc.php");
?>