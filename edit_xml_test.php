<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Test &eacute;dition Acadra</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php
	$bUseRte = false;
	$bUseFck = false;
	$bUseMce = true;

	if ($bUseFck) {
		include("FCKeditor/fckeditor.php") ;
	}
	function writeRteField_Text ($rteName, $text)
	{
		echo (
		'<textarea name="' .$rteName . '" cols="80" rows="10">' . $text . '</textarea>');
	}
?>

<!-- Pour tous les éditeurs -->
<script language="javascript" type="text/javascript">
<!--
function Show(id)
{
	var div_visu = "div_visu_" + id;
	var div_edit = "div_edit_" + id;

	document.getElementById(div_edit).style.display	= '' ;
	document.getElementById(div_visu).style.display	= 'none' ;
}

function Hide(id)
{
	var div_visu = "div_visu_" + id;
	var div_edit = "div_edit_" + id;

	document.getElementById(div_edit).style.display	= 'none' ;
	document.getElementById(div_visu).style.display	= '' ;
}

function afficher_div (nom,profondeur)
{
	var zone = document.getElementById(nom);
	if (!zone)
		return(false);
	// alert ("Ok !")
	zone.style.visibility="visible";
	zone.style.display="block";
	if (profondeur!=null)
		zone.style.zIndex=profondeur;
	
	return(true);
}

function cacher_div (nom)
{
	var zone = document.getElementById(nom);
	if (!zone)
		return(false);
	
	// alert ("Ok !")
	zone.style.visibility="hidden";
	zone.style.display="none";

	return(true);
}

//-->
</script>

<?php if ($bUseMce) { ?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
<!--
	// strikethrough,
	//  "justifyleft,justifycenter,justifyright, justifyfull,separator," +
	tinyMCE.init({
		mode : "textareas",
		language : "fr",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,forecolor,backcolor,separator," +
								  "bullist,numlist,undo,redo,link,unlink,separator,cleanup,removeformat",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		save_callback : "EditeFin"
	});
	/* 
	debug : true
	theme : "simple"
	*/
	
	function Edite (id)
	{
		Show (id);
	}
	
	function EditeFin (id, content)
	{
		Hide (id);
		var node = document.getElementById("visu_" + id);
		node.innerHTML = content;
	}
	
//-->
</script>
<!-- /tinyMCE -->
<?php } ?>

<?php if ($bUseFck) { 
	function createEditor ($name, $value)
	{
		$oFCKeditor = new FCKeditor($name) ;
		$sBasePath = dirname ($_SERVER['PHP_SELF']) . '/FCKeditor/';
		$oFCKeditor->BasePath = $sBasePath;
		
		// $oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->ToolbarSet = 'Firefox';
		$oFCKeditor->EnableSafari = true;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Value = $value;
		$oFCKeditor->Create() ;	
	}
?>
<script language="javascript" type="text/javascript">
<!--
// FCKeditor_OnComplete is a special function that is called when an editor
// instance is loaded ad available to the API. It must be named exactly in
// this way.
/*
function FCKeditor_OnComplete( editorInstance )
{
	// Show the editor name and description in the browser status bar.
	document.getElementById('eMessage').innerHTML = 'Instance "' + editorInstance.Name + '" loaded - ' + editorInstance.Description ;

	// Show this sample buttons.
	document.getElementById('eButtons').style.visibility = '' ;
}
*/

var idEdit = 0;

function Edite (id)
{
	Show (id);
	
	// This is a hack for Gecko... it stops editing when the editor is hidden.
	if ( !document.all )
	{
		var sEdit = "edit_" + id;
		var oEditor = FCKeditorAPI.GetInstance(sEdit) ;
		if (  oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
			oEditor.MakeEditable() ;
	}
	// afficher_div (sDiv);
/*
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;
	
	if (oEditor.IsDirty ())
	{
		GetContents(idEdit);
		oEditor.ResetIsDirty ();
	}
	idEdit = id;
	var fld = document.getElementById(id);	
	// Set the editor contents (replace the actual one).

	var node = document.getElementById("visu_" + id);	
	// node.innerHTML = fld.value;
	oEditor.SetHTML(node.innerHTML) ;
	// oEditor.SetHTML(fld.value) ;
*/	
}

function EditeFin (id)
{
	Hide (id);

	// var sDiv = "div_edit_" + id;
	// cacher_div (sDiv);
	var sEdit = "edit_" + id;
	var oEditor = FCKeditorAPI.GetInstance(sEdit) ;
	
	// alert (oEditor.GetXHTML( true ));
	var node = document.getElementById("visu_" + id);
	node.innerHTML = oEditor.GetXHTML( false ) ;
	// node.innerHTML = oEditor.GetXHTML( true ) ;
/*
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;
	
	if (oEditor.IsDirty ())
	{
		GetContents(idEdit);
		oEditor.ResetIsDirty ();
	}
	idEdit = id;
	var fld = document.getElementById(id);	
	// Set the editor contents (replace the actual one).

	var node = document.getElementById("visu_" + id);	
	// node.innerHTML = fld.value;
	oEditor.SetHTML(node.innerHTML) ;
	// oEditor.SetHTML(fld.value) ;
*/	
}


function SetContents(id)
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;
	
	if (oEditor.IsDirty ())
	{
		GetContents(idEdit);
		oEditor.ResetIsDirty ();
	}
	idEdit = id;
	var fld = document.getElementById(id);	
	// Set the editor contents (replace the actual one).

	var node = document.getElementById("visu_" + id);	
	// node.innerHTML = fld.value;
	oEditor.SetHTML(node.innerHTML) ;
	// oEditor.SetHTML(fld.value) ;
	
}

function GetContents(id)
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;

	var fld = document.getElementById(id);
	fld.value = oEditor.GetXHTML( true ) ;

//	var node = document.getElementById("visu_" + id);
//	node.innerHTML = fld.value;
	
/*
	var test = document.getElementById("test_Html");
	alert (test.firstChild.data);
	alert (test.firstChild.nodeValue);

	node.firstChild.data = "Grand prix <strong>Annecy</strong> 1990";// oEditor.GetXHTML( true ) ;
	node.firstChild.nodeValue = test.firstChild.nodeValue;
	var noeud_texte = document.createTextNode(fld.value);
	document.getElementById("visu_" + id).replaceChild(noeud_texte, document.getElementById("visu_" + id).firstChild);
	var noeud_texte = document.createTextNode(fld.value);
	document.getElementById("visu_" + id).replaceChild(noeud_texte, document.getElementById("visu_" + id).firstChild);
	alert ("visu_" + id);
	fld = document.getElementById("visu_" + id);
	alert (fld.name);
	alert (fld.data);
	alert (fld.texte);
	alert (fld.nodeValue);
	fld.data = oEditor.GetXHTML( true ) ;
*/
	// Get the editor contents in XHTML.
	// alert( oEditor.GetXHTML( true ) ) ;		// "true" means you want it formatted.

	oEditor.ResetIsDirty ();
}
//-->
</script>
<?php } ?>

<style type="text/css">
<!--
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
input, textarea {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	border:1px solid #0066CC;
	background-color:#DDDDDD;
}
.Style2 {font-size: 10px}
.editzone {
	background-color:#FFFFFF;
	margin:20px;
	padding:10px;
	border:1px dashed #FF6600;
}
-->
</style>

<?php	
	require_once('film_xml_fct.php');
	$films_xml = new XmlFilmParser();
	$films_xml->xmlfile = "new_test_Films.xml";
	$success = $films_xml->parse ();

	$idfilm = 1;
	// Champ Synopsis
	$idField = 21;
	// Champ Biographie
	// $idField = 23;
	
	if (isset($_POST['Action']))
	{

		/*
		echo "<pre>";
		// print_r ($_SESSION);
		print_r ($_POST);
		echo "</pre>";
		*/
		
		$cmdAction = $_POST["Action"];
		
		// "Mettre à jour..."
		switch($cmdAction)
		{
			case "Choisir":
				if (isset($_POST['idfilm'])) {
					$idfilm = $_POST['idfilm'];
				}
				break;
				
			case "Sauvegarder...":
				$idfilm = $_POST['aNewFilm']['IdFilm'];
				$film_xml =& $films_xml->getFilmById ($idfilm);
				// echo "Film n°" . $idfilm . "<br/>";
				
				$nb =& $film_xml->childCount;
				$nodes =& $film_xml->childNodes;

				$node =& $nodes[$idField];
				if ($bUseFck)
					$node->firstChild->nodeValue = $_POST["edit_" . $node->nodeName];
				if ($bUseMce)
					$node->firstChild->nodeValue = $_POST[$node->nodeName];
				
				// echo "Valeur : " . $node->nodeName . " -> " . $node->firstChild->nodeValue . "<br/>";
				// $aFields = getFields ();
				/*
				for ($i = 0; $i < $nb; $i++) { 
					$node =& $nodes[$i];
					$node->firstChild->nodeValue = $_POST['aNewFilm'][$node->nodeName];
					// echo "Valeur : " . $node->nodeName . " -> " . $node->firstChild->nodeValue . "<br/>";
				}
				*/
				// Sauvegarde
				$films_xml->save ("new_test_Films.xml");
				break;
		}
	}
	
	$film_xml =& $films_xml->getFilmById ($idfilm);
	$titres = $films_xml->getFilmsTitle ();
/*
	// test la modification / sauvegarde en direct !	
	// $film_xml->childNodes[1]->firstChild->nodeValue .= " del Norte";	

	$nodes =& $film_xml->childNodes;
	$node =& $nodes[1];
	$node->firstChild->nodeValue .= " del Norte";
	$films_xml->save ();
*/
/*
	if ($success) {
		//use getElementsByTagName to gather all elements named "cd"
		$matchingNodes =& $films_xml->xmldoc->getElementsByTagName("Titre");
		
		//if any matching nodes are found, echo to browser
		if ($matchingNodes != null) {
			echo $matchingNodes->toNormalizedString(true);
		}
	}	
*/
	
	/*
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

	if ($film_xml != null)
		echo ("Film cherché : \n<br />" . 
			$film_xml->toNormalizedString(true) . "\n<br />");
	else
		echo ("Film introuvable...\n<br />");
	*/
?>

</head>

<body>
<h3>Test des fonctions d'édition et de sauvegarde</h3>
<p>Choisir un un film, modifier, sauver puis vérifier les donn&eacute;es</p>
<form action="" method="post" name="frmChoix" id="frmChoix">
  <table width="70%"  border="0" cellspacing="0" cellpadding="2">
    <tr>
	  <td>Choisir un film :
    <?php 
	echo "<select name=\"idfilm\" size=\"1\">\n";		
	$total = count($titres);
	
	for ($i = 0; $i < $total; $i++) {		
		echo "<option value=\"" . $titres[$i]['IdFilm'] . "\"" . 
			(($idfilm == $titres[$i]['IdFilm']) ? "selected" : "") .
			">" .  $titres[$i]['Titre'] . "</option>\n";
	}	
	echo "</select>\n";	
	?>	<input type="submit" name="Action" value="Choisir"></td>
	  <td></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>

<hr>

<div style="background-color:#EEEEEE; margin:20px; padding:10px; border:1px solid #CCCCCC ">

	<?php 
		$node =& $film_xml->childNodes[1];
		$val = $node->firstChild->nodeValue;
	?>
<h2>Film : <?php echo $val; ?></h2>
<form action="" method="post" name="frmEdit" id="frmEdit">
	<?php 
		$node =& $film_xml->childNodes[0];
		$fld = $node->nodeName;
		$val = $node->firstChild->nodeValue;
	?>
	<p><?php echo $fld ?> :
	<input name="aNewFilm[<?php echo $fld; ?>]" type="text" value="<?php echo $val; ?>" />
	</p>
	<?php 
		$node =& $film_xml->childNodes[$idField];
		$fld = $node->nodeName;
		$val = $node->firstChild->nodeValue;
	?>
	<input type="submit" name="Action" value="Sauvegarder...">
	<h3>Test du champ éditable <?php echo $fld ?> :</h3>
	<div id="div_visu_<?php echo $fld; ?>" class="editzone" > <?php //  visibility:hidden;?>
		<input type="button" value="Modifier >>" onclick="Edite('<?php echo $fld; ?>');">
		<p id="visu_<?php echo $fld; ?>"><?php echo $val; ?></p>
	</div>
	<div id="div_edit_<?php echo $fld; ?>" class="editzone" style="display:none;" > <?php //  style="display:none; visibility:hidden;"?>
		<?php if ($bUseMce) { ?>
			<input type="button" value="<< Fermer" onclick="tinyMCE.triggerSave();">
			<br/>
			<br/>
			<textarea name="<?php echo $fld; ?>" style="width:100%" cols="200" rows="15"><?php echo $val; ?></textarea>
		<?php } ?>
		<?php if ($bUseFck) { ?>
			<input type="button" value="<< Fermer" onclick="EditeFin('<?php echo $fld; ?>');">
			<br/>
			<br/>
			<?php createEditor("edit_" . $fld, $val); 
		} ?>
		<br/>
<p><strong>Pour modifier rapidement :</strong></p>
<table width="30%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="Style2">Entr&eacute;e</span></td>
    <td><span class="Style2">Saut de paragraphe </span></td>
  </tr>
  <tr>
    <td><span class="Style2">Shift + Entr&eacute;e</span></td>
    <td><span class="Style2">Saut de ligne</span></td>
  </tr>
  <tr>
    <td><span class="Style2">Ctrl + b</span></td>
    <td><span class="Style2">Sélection en gras</span></td>
  </tr>
  <tr>
    <td><span class="Style2">Ctrl + i</span></td>
    <td><span class="Style2">Sélection en italique</span></td>
  </tr>
  <tr>
    <td><span class="Style2">Ctrl + u</span></td>
    <td><span class="Style2">Sélection soulign&eacute;e</span></td>
  </tr>
</table>
		<br/>
		<br/>
	</div>
</form>

</div>
		
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>

  
</p>
</body>
</html>
