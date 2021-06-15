<?php
	// require_once ("auth.php");
	include ("header.inc.php");

	$oFilms->oFilm = $oFilms->readFilm ($IdFilm);
	$aFilm = $oFilms->oFilm;

	$bUseRte = false;
	$edit_mode = "edit";
	$bSave = false;
/*
	echo "<pre>";
 	print_r ($_GET);
 	print_r ($_POST);
	echo "</pre>";
*/
 	if (isset($_POST["cmdAdmin"]))
	{
		$cmdAdmin = $_POST["cmdAdmin"];

		// "Mettre à jour..."
		switch($cmdAdmin)
		{
			case "Sauvegarder la fiche...":
				$edit_mode = $_POST["edit_mode"];
				if ($edit_mode == "edit") {
					// echo "Mise à jour";
					// print_r ($_POST);
					// print_r ($aNewFilm);
					// print_r ($aFilm);
					// $aFilm = new Film($aNewFilm);
					
					$IdFilm = $aNewFilm['IdFilm'];
					$aFilm = new Film ($aNewFilm);
					$oFilms->saveFilm ($aFilm);
					$aFilms = $oFilms->updateFilmList ($aFilm);
					$oFilms->saveFilms ();

					$oFilms->IdFilm = $IdFilm;
					$_SESSION['oFilms'] = $oFilms;
					$bSave = true;
				}
				if ($edit_mode == "add") {
					$IdFilm = $aNewFilm['IdFilm'];
					$aFilm = new Film ($aNewFilm);
					$oFilms->saveFilm ($aFilm);
					$aFilms = $oFilms->addToFilmList ($aFilm);
					$oFilms->saveFilms ();
					$_SESSION['oFilms'] = $oFilms;

					$oFilms->IdFilm = $IdFilm;
					$bSave = true;
				}
				break;

			case "Modifier ce film":
				$edit_mode = "edit";
				if (isset($_POST['IdFilm']))
				{
					$IdFilm = $_POST['IdFilm'];
					$oFilms->IdFilm = $IdFilm;
					$oFilms->oFilm = $oFilms->readFilm ($IdFilm);
					$aFilm = $oFilms->oFilm;
				}
				break;

			case "Ajouter un film":
				$edit_mode = "add";
				// echo "Ajouter un film";
				$aFilm = $oFilms->createFilm ();
				$IdFilm = $aFilm->IdFilm;
				$oFilms->IdFilm = $IdFilm;
				// print_r ($aFilm);
				break;
		}
	}
	
	function getValidHtml ($text)
	{
		$html = htmlentities ($text, ENT_QUOTES);
		$new = ereg_replace("[\r\n]", "<br/>", $html);
		// echo $new;
		$new = '<font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . $new . '</font>';
		return $new;
	}
	function initRteField ()
	{
		echo ('<script language="JavaScript" type="text/javascript">
		<!--
		//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML)
		initRTE("rte/images/", "rte/", "", true);
		//-->
		</script>
		<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>');
	}
	function writeRteField_Text ($rteName, $text)
	{
		echo (
		'<textarea name="' .$rteName . '" cols="80" rows="10">' . $text . '</textarea>');
	}

	function writeRteField ($rteName, $text)
	{
		echo (
		'<script language="JavaScript" type="text/javascript">
		<!--
		//Usage: writeRichText(fieldname, html, width, height, buttons, readOnly)
		writeRichText(\'' . $rteName .'\', \'' .  $text . '\', 350, 150, true, false);
		//-->
		</script>');
		// substr nl2br  htmlentities
	}

	function writeRteField_ONE ($rteName, $text)
	{
		// echo nl2br ($text);
		// return;
		// $new = str_replace("\r\n", "<br/>", $html);
		$html = htmlentities ($text, ENT_QUOTES);
		$new = ereg_replace("[\r\n]", "<br/>", $html);
		// echo $new;
		$new = '<font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . $new . '</font>';
		echo (
		'<script language="JavaScript" type="text/javascript">
		<!--
		//Usage: writeRichText(fieldname, html, width, height, buttons, readOnly)
		writeRichText(\'' . $rteName .'\', \'' .  $new . '\', 400, 200, true, false);
		//-->
		</script>');
		// substr nl2br  htmlentities
	}
?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	// strikethrough,
	//  "justifyleft,justifycenter,justifyright, justifyfull,separator," +
	tinyMCE.init({
		mode : "textareas",
		language : "fr",
		theme : "advanced",
		force_br_newlines : true,
		theme_advanced_buttons1 : "bold,italic,underline,separator,forecolor,backcolor,separator," +
								  "bullist,numlist,undo,redo,link,unlink,separator,cleanup,removeformat",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left"
	});
	/* 
	debug : true
	theme : "simple"
	*/
</script>
<!-- /tinyMCE -->

<?php if ($bUseRte) { ?>
<script language="JavaScript" type="text/javascript" src="rte/html2xhtml.js"></script>
<!-- To decrease bandwidth, use richtext_compressed.js instead of richtext.js //-->
<script language="JavaScript" type="text/javascript" src="rte/richtext_compressed.js"></script>
<?php } ?>

<style type="text/css">
<!--
/*
form {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
*/
/*
input, textarea {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	border:1px solid #0066CC;
	background-color:#DDDDDD;
}
*/

-->
</style>

	<div id="left">
	<img src="images/ange_acadra.jpg" width="80" />
	</div>
	<div id="center">
		<?php if ($edit_mode == "edit") { ?>
		<h3>Gestion du site - Modification de la fiche</h3>
		<?php } ?>
		<?php if ($edit_mode == "add") { ?>
		<h3>Gestion du site - Ajout d'une fiche</h3>
		<?php } ?>
		<?php if ($edit_mode == "edit" && $bSave) {
			echo "<p style=\"color:#CC0000\">Les modifications ont été sauvegardées</p>";
		} ?>
		<?php if ($edit_mode == "add" && $bSave) {
			echo "<p style=\"color:#CC0000\">Le film a été ajouté</p>";
			$edit_mode = "edit";
		} ?>
		<?php 
		if (!$Admin) {
    		echo "<p>Veuillez vous identifier <a href='admin.php'>ici</a> pour continuer<br/>";
			exit;
		}
		else
    		echo "<p>{$_SERVER['PHP_AUTH_USER']} est connecté en mode d'administration.<br/>";			
		?>
	</div>
	<?php 
	if ($bUseRte) initRteField ();
	?>
	
	<div style="clear:both"></div>


<!-- 
	<?php printAffiche ($IdFilm) ?>
	<div style="margin:20px 100px">
	
        <div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">				
				<p>
				<table width="99%" border="0"  cellpadding="10" cellspacing="0">
                  <tr>
                    <td width="25%">
					<?php printAffiche ($IdFilm) ?>
					</td>
                    <td width="75%">
					<h2 align="center"><strong><?php echo $aFilm->Titre ?></strong></h2>
					<h3 align="center">(<?php echo $aFilm->Titre_original ?>)</h3>
					<p align="center">un film de <span style="font-size: 1.1em; font-weight: bold"><?php echo $aFilm->Realisateur ?></span></p>					</td>
					
                 </tr>
              </table>
			  </p>
					
 			</div>
			
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>

		</div>
	
	</div>

 -->	
 	<div style="margin:20px">

	<?php 
		/*
		$nbFilms = count ($aFilms);			
		$fp = fopen ("Test_1.xml", "w");
		fwrite ($fp, "<?xml version='1.0' encoding='ISO-8859-15'?>\r\n");
		fwrite ($fp, "<Film>\r\n");
		for ($i=0; $i < 1; $i++) {
			
			$aFilm = new Film($aFilms[$i]);
			$aFilm->writeXML($fp, $aFilms[$i]);
			
		}
		fwrite ($fp, "</Film>\r\n");
		fclose ($fp);
		*/
	?>

<form action="admin_film.php" method="POST" name="update" target="_self" id="update" onSubmit="return submitForm();">
<?php if ($bUseRte) { ?>
	<script language="JavaScript" type="text/javascript">
	<!--
	function submitForm() {
		//make sure hidden and iframe values are in sync before submitting form
		//to sync only 1 rte, use updateRTE(rte)
		//to sync all rtes, use updateRTEs
		updateRTEs();
		
		//change the following line to true to submit form
		return true;
		// return false;
	}
	//-->
	</script>
<?php } else { ?>
	<script language="JavaScript" type="text/javascript">
	<!--
	//>
	function submitForm() {
		return true;
	}
	//-->
	</script>
<?php }?>

<!-- 	
	<th colspan="2" bgcolor="#666666"><h5 style="background-color:#eeeeee">Fiche complète</h5></th>
	 bordercolordark="#FFFFFF" bordercolorlight="#FF9900" 
	 bordercolor="#FF9933" 
 -->
<table width="90%" align="center" border="0" cellpadding="5" cellspacing="0">
	<tr>
	<th colspan="2"><h5>Fiche complète</h5></th>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>
	<p><input name="cmdAdmin" type="submit" value="Sauvegarder la fiche..." /></p>
	</td>
	</tr>
<!-- 
	<tr>
    <td align="right" valign="top">IdFilm</td>
    <td width="300"><?php echo $aFilm->IdFilm; ?><input name="aNewFilm[IdFilm]" type="hidden" value="<?php echo $aFilm->IdFilm; ?>" /></td>
	</tr>
 -->
	<?php 
	$aFields = getFields ();
	$nbFields = count ($aFields);
	foreach ($aFields as $fld) {	
	?>
	<tr>
    <td align="right" valign="top"><span style="font-size:1em"><u><?php echo $fld['libelle'] ?> :</u></span></td>
	<?php if ($fld['format'] == "text") { ?>
	<?php if ($fld['field'] == "IdFilm") { ?>
    <td><input name="aNewFilm[<?php echo $fld['field']; ?>]" type="text" value="<?php echo $aFilm->$fld['field']; ?>" size="70" readonly/></td>
	<?php } else { ?>	
    <td><input name="aNewFilm[<?php echo $fld['field']; ?>]" type="text" value="<?php echo $aFilm->$fld['field']; ?>" size="70" /></td>
	<?php }?>
	<?php }?>
	<?php if ($fld['format'] == "textarea") { ?>
    <td>
		<?php 
			$post = "aNewFilm[".$fld['field']."]";
			writeRteField_Text ($post, $aFilm->$fld['field']);
		?>
	</td>
	<?php } ?>
	</tr>
	<?php } ?>
	<tr>
	<td>&nbsp;</td>
	<td>
	<input name="IdFilm" type="hidden" value="<?php echo $IdFilm ?>" />
	<input name="edit_mode" type="hidden" value="<?php echo $edit_mode ?>" />
	<p><input name="cmdAdmin" type="submit" value="Sauvegarder la fiche..." /></p>
	</td>
	</tr>
</table>
</form>
    <p>&nbsp;</p>
<?php
	include ("footer.inc.php");
?>