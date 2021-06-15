<?php

/*************************************************************
 * Déboggage
 * Ecrit les informations dans un fichier texte
 ************************************************************/
function write_log ($text)
{
	// $b_trace = false;
	$b_trace = true;
	
	if ($b_trace)
	{
		$trace_log = "debug.log";
		error_log($text . "\r\n", 3, $trace_log);
	}
}

/*************************************************************
 * Classe Film
 * Stocke les informations des fichiers film
 ************************************************************/
class Film {
   var $IdFilm;
   var $Titre_original;
   var $Titre;
   
   var $Realisateur;
   var $Biographie;
   var $Filmographie;
   
   var $Annee;
   var $Duree;
   var $Affiche;
   var $Langue;
   var $Visa;
   var $Version;
   var $f35mm;
   var $Format;
   var $FormatSon;
   var $Scenario;
   var $Photographie;
   var $Montage;
   var $Musique;
   var $Son;
   var $Decors;
   var $Costumes;
   var $Interpretation;
   var $Production;

   var $Prix;   
   var $Synopsis;
   var $Critiques;
   var $Interviews;
   
   var $Nb_Photos;
   var $Photos;
   // var $Activation;
   
   function writeXML($fp)
   {
		foreach (get_object_vars($this) as $prop => $val) {
			if ($prop != "0")
				// fwrite ($fp, "\t<" . $prop . ">" . htmlspecialchars ($val) . "</" . $prop . ">\r\n");
				fwrite ($fp, "\t<" . $prop . ">" . $val . "</" . $prop . ">\r\n");
			}
/*
       foreach ($aa as $k=>$v) 
           // fwrite ($fp, "<" . $$this->$k . ">" . $aa[$k] . "</" . $$this->$k . ">");
		   fwrite ($fp, "\t<" . $this->$k . ">" . $aa[$k] . "</" . $this->$k . ">\r\n");
*/
   }
    
   function writeListXML($fp)
   {
   		$props = array ('IdFilm', 'Titre', 'Titre_original', 'Realisateur', 'Annee');
		foreach ($props as $prop) {
			$val = $this->$prop;
				fwrite ($fp, "\t\t<" . $prop . ">" . $val . "</" . $prop . ">\r\n");
		}
   }
    
   function writeTxtFromXML($fp)
   {
		foreach (get_object_vars($this) as $prop => $val)
		{
			if ($prop != "0")
			{
				// fwrite ($fp, "\t<" . $prop . ">" . htmlspecialchars ($val) . "</" . $prop . ">\r\n");
				$html = htmlentities ($val, ENT_QUOTES);
				$html = ereg_replace("[\r\n]", "<br/>", $html);
				fwrite ($fp, $prop . "||||" . $html . "\r\n");
			}
		}
   }
	function writeTxt($fp)
	{
		foreach (get_object_vars($this) as $prop => $val)
		{
			if ($prop != "0")
				// fwrite ($fp, "\t<" . $prop . ">" . htmlspecialchars ($val) . "</" . $prop . ">\r\n");
				// if ($prop != "Filmographie")
				// $val = htmlentities ($val, ENT_QUOTES);
				// fwrite ($fp, $prop . "||||" . $val . "\r\n");
				// Sur Free
				fwrite ($fp, $prop . "||||" . stripslashes ($val) . "\r\n");
		}
	}
	function Film ($aa = array()) { 
		foreach ($aa as $k=>$v) 
		{
			$this->$k = $aa[$k]; 
		}
	} 
} 

function getFields ()
{
	$aFields = array (
		array ("field" => "IdFilm", "libelle" => "n° du film", "format" => "text"),
		array ("field" => "Titre_original", "libelle" => "Titre original", "format" => "text"),
		array ("field" => "Titre", "libelle" => "Titre", "format" => "text"),
		array ("field" => "Realisateur", "libelle" => "Réalisateur", "format" => "text"),
		array ("field" => "Prix", "libelle" => "Prix", "format" => "textarea"),
		array ("field" => "Annee", "libelle" => "Année", "format" => "text"),
		array ("field" => "Duree", "libelle" => "Durée", "format" => "text"),
		array ("field" => "Langue", "libelle" => "Langue", "format" => "text"),
		array ("field" => "Visa", "libelle" => "Visa", "format" => "text"),
		array ("field" => "Version", "libelle" => "Version", "format" => "text"),
		array ("field" => "f35mm", "libelle" => "35 mm", "format" => "text"),
		array ("field" => "Format", "libelle" => "Format", "format" => "text"),
		array ("field" => "FormatSon", "libelle" => "Format du son", "format" => "text"),
		array ("field" => "Scenario", "libelle" => "Scénario", "format" => "text"),
		array ("field" => "Photographie", "libelle" => "Photographie", "format" => "text"),
		array ("field" => "Montage", "libelle" => "Montage", "format" => "text"),
		array ("field" => "Musique", "libelle" => "Musique", "format" => "text"),
		array ("field" => "Son", "libelle" => "Son", "format" => "text"),
		array ("field" => "Decors", "libelle" => "Décors", "format" => "text"),
		array ("field" => "Costumes", "libelle" => "Costumes", "format" => "text"),
		array ("field" => "Interpretation", "libelle" => "Interprétation", "format" => "text"),
		array ("field" => "Production", "libelle" => "Production", "format" => "text"),
		array ("field" => "Affiche", "libelle" => "Affiche", "format" => "text"),
		array ("field" => "Nb_Photos", "libelle" => "Nb Photos", "format" => "text"),
		array ("field" => "Photos", "libelle" => "Photos", "format" => "text"),
		array ("field" => "Synopsis", "libelle" => "Synopsis", "format" => "textarea"),
		array ("field" => "Critiques", "libelle" => "Critiques", "format" => "textarea"),
		array ("field" => "Interviews", "libelle" => "Interviews", "format" => "textarea"),
		array ("field" => "Biographie", "libelle" => "Biographie", "format" => "textarea"),
		array ("field" => "Filmographie", "libelle" => "Filmographie", "format" => "textarea"));
		// array ("field" => "Activation", "libelle" => "Activation", "format" => "checkbox"));
	return $aFields;
}

/*************************************************************
 * Classe Film_Collection
 * Stocke les informations des fichiers film
 ************************************************************/
class Film_Collection {
	// Fichier XML des films
	var $filename;
	var $aFilms;
	var $nbFilms;
	// Objet Film en cours d'utilisation
	var $oFilm;
	// Index du film en cours d'utilisation
	var $IdFilm;
	var $filmProps;
	
	function Film_Collection () { 
		$this->filename = "film_list.xml";
		$this->filmProps = array ('IdFilm', 'Titre', 'Titre_original', 'Realisateur', 'Annee'); // , 'Activation' 
	}

	// Lecture et écriture de la liste des films
	// sous forme de fichier xml ISO-8859-1
	function readFilms () { 
		$data = implode("",file($this->filename)); 
		$films = xml2arrayLast ($data);
		
		$this->aFilms = $films['Film'];
		/*
		echo "<pre>";
		echo "Titre : " . $this->aFilms[27]['Titre'];
		echo "</pre>";
		*/
		$this->nbFilms = count ($this->aFilms);
		return $this->aFilms;
	} 

	function saveFilms () { 
		$this->nbFilms = count ($this->aFilms);
		
		$fp = fopen ($this->filename, "w");
		fwrite ($fp, "<?xml version='1.0' encoding='ISO-8859-1'?>\r\n");
		fwrite ($fp, "<Films>\r\n");
		
		for ($i=0; $i < $this->nbFilms; $i++) 
		{		
			// echo "<pre>";
			// print_r ($this->aFilms[$i]);
			// echo "</pre>";	
			fwrite ($fp, "\t<Film>\r\n");
			$props = array ('IdFilm', 'Titre', 'Titre_original', 'Realisateur', 'Annee', 'Activation');
			foreach ($props as $prop) {
				if (isset ($this->aFilms[$i][$prop]))
					$val = $this->aFilms[$i][$prop];
				else
					$val = "";
				fwrite ($fp, "\t\t<" . $prop . ">" . $val . "</" . $prop . ">\r\n");
			}
			fwrite ($fp, "\t</Film>\r\n");
		}
		fwrite ($fp, "</Films>\r\n");
		fclose ($fp);
	} 

	function getActiveFilms () {
		for ($i=0; $i < $this->nbFilms; $i++) 
		{
			if ($this->aFilms[$i]['Activation'])
				$aActiveFilms[] = $this->aFilms[$i];
		}
		return $aActiveFilms;
	} 

	// Lecture et écriture de d'objet film
	// sous forme de fichier texte

	// Sauve un film (reçu sous forme de tableau)
	function saveFilmAr ($aFilmArray)
	{
		$aFilm = new Film($aFilmArray);
		$filename = sprintf ("data/Film_%02d.txt", $aFilm->IdFilm);
		$fp = fopen ($filename, "w");
		$aFilm->writeTxt($fp);		
		fclose ($fp);
	}
	
	// Sauve un film (reçu directement sous forme d'objet)
	function saveFilm ($oFilm)
	{
		$filename = sprintf ("data/Film_%02d.txt", $oFilm->IdFilm);
		$fp = fopen ($filename, "w");
		$oFilm->writeTxt($fp);
		fclose ($fp);
	}
	
	// Charge un film (retourné sous forme d'objet)
	function readFilm ($IdFilm)
	{
		$filename = sprintf ("data/Film_%02d.txt", $IdFilm);
	
		$lines = file ($filename);
		foreach ($lines as $line)
		{
			$aElmt = explode ("||||", trim ($line));
			if (count ($aElmt) > 1)
				$aFilm[$aElmt[0]] = html_entity_decode($aElmt[1]);
			else
				$aFilm[$aElmt[0]] = null;
		}
		$aFilm = new Film($aFilm);
		return $aFilm;
	}

	// Sélectionne le film courant
	function setCurrentFilm ($IdFilm)
	{
		$this->IdFilm = $IdFilm;
	}
	
	// Retourne l'index d'un film par son Id
	function getFilmIndexById ($id)
	{
		for ($i=0; $i < $this->nbFilms; $i++) {
			if ($this->aFilms[$i]['IdFilm'] == $id) {
				return $i;
				break;
			}
		}
		return null;
	}
	
	// Retourne un objet film par son Id
	function getFilmById ($IdFilm)
	{
		foreach ($this->aFilms as $f) {
			if ($f['IdFilm'] == $IdFilm) {
				$aFilm = new Film($f);
				break;
			}
		}
		if (is_null ($aFilm))
			echo "Non trouvé !<br>";
		else
			return $aFilm;
	}
	
	// Création et suppresion de film
	function createFilm ()
	{
		$this->nbFilms = count ($this->aFilms);

		// Calcul l'Id du nouveau film
		// => Id du dernier film du fichier XML + 1
		$IdFilm = $this->aFilms[$this->nbFilms-1]['IdFilm'] + 1;
		// Crée un objet classe Film
		$oFilm = new Film();
		$oFilm->IdFilm = $IdFilm;
		return $oFilm;
		// $arFilm = get_object_vars($oFilm);
		// return $arFilm;
		// $aFilms[] = $arFilm;
	}
	
	function deleteFilm ($IdFilm)
	{
		$filename = sprintf ("data/Film_%02d.txt", $IdFilm);
		unlink ($filename);
	}
	
	// Ajout, mise à jour et suppresion de la liste des films
	// Mettre à jour la session 'oFilms' après ces modifications
	function addToFilmList ($oFilm)
	{
		foreach ($this->filmProps as $prop)
			$aFilm[$prop] = $oFilm->$prop;
		// Rajoute un champ Activation dans le XML
		$aFilm['Activation'] = 0;
		
		$this->aFilms[] = $aFilm;
		$this->nbFilms ++;
		return $this->aFilms;
	}
	function updateFilmList ($oFilm)
	{
		$no = $this->getFilmIndexById ($oFilm->IdFilm);
		
		if (!is_null($no)) 
		{
			foreach ($this->filmProps as $prop)
				$this->aFilms[$no][$prop] = $oFilm->$prop;
		}
		return $this->aFilms;
	}
	function deleteFilmFromList ($IdFilm)
	{
		$no = $this->getFilmIndexById ($IdFilm);
		
		if (!is_null($no)) 
		{
			unset ($this->aFilms[$no]);
			$this->aFilms = array_values ($this->aFilms);
		}
		$this->nbFilms --;
		return $this->aFilms;
	}

	
}
function xml2arrayLast($data)
{
	//mvo voncken@mailandnews.com
	//original ripped from  on the php-manual:gdemartini@bol.com.br    
	//to be used for data retrieval(result-structure is Data oriented)
	
	$p = xml_parser_create("ISO-8859-1");
	xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($p, XML_OPTION_SKIP_WHITE, 0);
	xml_parse_into_struct($p, $data, $vals, $index);
	xml_parser_free($p);
	$tree = array();
	$i = 0;
	//array_push($tree, array('tag' => $vals[$i]['tag'], 'attributes'=> $vals[$i]['attributes'], 'children' => ));
	$tree = GetChildren($vals, $i);
	return $tree;
}
	
function GetChildren($vals, &$i) 
{       
	$children = array();
	if (isset ($vals[$i]['value'])) 
	// if ($vals[$i]['value'])
	array_push($children, $vals[$i]['value']);
	
	$j = 0; 
	$prevtag = "";
	while (++$i < count($vals)) // so pra nao botar while true ;-)
	{      
		switch ($vals[$i]['type'])
		{       
			case 'cdata':
				// Ne rentre pas les cData !
				// array_push($children, $vals[$i]['value']);
				break;
			case 'complete': 
				if (is_string ($vals[$i]['tag']) && isset ($vals[$i]['value']))
				   $children[$vals[$i]['tag']] = $vals[$i]['value']; 
				break;
			case 'open':                                           
				//restartindex on unique tag-name
				$j++;
				if ($prevtag <> $vals[$i]['tag']) {
				$j = 0; 
				$prevtag = $vals[$i]['tag'];
				}             
				$children[$vals[$i]['tag']][$j] = GetChildren($vals,$i);
				break;
			case 'close':           
				return $children;
		}
	}    
}

// Exporte un tableau de films
function exportFilmsXML ($aFilms)
{
	$nbFilms = count ($aFilms);
	
	for ($i=0; $i < $nbFilms; $i++) 
	{		
		$aFilm = new Film($aFilms[$i]);
		$filename = sprintf ("data/Film_%02d.xml", $aFilm->IdFilm);
		$fp = fopen ($filename, "w");
		fwrite ($fp, "<?xml version='1.0' encoding='ISO-8859-15'?>\r\n");
		fwrite ($fp, "<Film>\r\n");
		$aFilm->writeXML($fp);		
		fwrite ($fp, "</Film>\r\n");
		fclose ($fp);
	}

}

function createNewFilm ($aFilms)
{
	$nbFilms = count ($aFilms);

	// Calcul l'Id du nouveau film
	$IdFilm = $aFilms[$nbFilms-1]['IdFilm'] + 1;
	// Crée un objet classe Film
	$oFilm = new Film();
	$oFilm->IdFilm = $IdFilm;
	return $oFilm;
	// $arFilm = get_object_vars($oFilm);
	// return $arFilm;
	// $aFilms[] = $arFilm;
	
}

function exportFilmsListXML ($aFilms)
{
	$nbFilms = count ($aFilms);
	
	$filename = "film_list.xml";
	$fp = fopen ($filename, "w");
	fwrite ($fp, "<?xml version='1.0' encoding='ISO-8859-1'?>\r\n");
	fwrite ($fp, "<Films>\r\n");
	
	for ($i=0; $i < $nbFilms; $i++) 
	{
		$aFilm = new Film($aFilms[$i]);
		fwrite ($fp, "\t<Film>\r\n");
		$aFilm->writeListXML($fp);		
		fwrite ($fp, "\t</Film>\r\n");
	}
	fwrite ($fp, "</Films>\r\n");
	fclose ($fp);
}

// Exporte un objet de classe Film
function exportFilmXML ($aFilmArray)
{
	$aFilm = new Film($aFilmArray);
	$filename = sprintf ("data/Film_%02d.xml", $aFilm->IdFilm);
	$fp = fopen ($filename, "w");
	fwrite ($fp, "<?xml version='1.0' encoding='ISO-8859-15'?>\r\n");
	fwrite ($fp, "<Film>\r\n");
	$aFilm->writeXML($fp);
	fwrite ($fp, "</Film>\r\n");
	fclose ($fp);
}

function exportFilmsTxt ($aFilms)
{
	$nbFilms = count ($aFilms);
	
	for ($i=0; $i < $nbFilms; $i++) 
	{		
		$aFilm = new Film($aFilms[$i]);
		$filename = sprintf ("data/Film_%02d.txt", $aFilm->IdFilm);
		$fp = fopen ($filename, "w");
		$aFilm->writeTxtFromXML($fp);		
		fclose ($fp);
	}
}

function addToFilmList ($aFilms, $aNew)
{
	$props = array ('IdFilm', 'Titre', 'Titre_original', 'Realisateur', 'Annee');
	foreach ($props as $prop)
		$aFilm[$prop] = $aNew[$prop];

	$aFilms[] = $aFilm;
	return $aFilms;
}

function addFilmListById ($aFilms, $aNew)
{
	$props = array ('IdFilm', 'Titre', 'Titre_original', 'Realisateur', 'Annee');
	foreach ($props as $prop)
		$aFilm[$prop] = $aNew[$prop];

	$aFilms[] = $aFilm;
	return $aFilms;
}

function saveFilmList ($aFilms)
{
	$nbFilms = count ($aFilms);
	
	$filename = "film_list.xml";
	$fp = fopen ($filename, "w");
	fwrite ($fp, "<?xml version='1.0' encoding='ISO-8859-1'?>\r\n");
	fwrite ($fp, "<Films>\r\n");
	
	for ($i=0; $i < $nbFilms; $i++) 
	{
		fwrite ($fp, "\t<Film>\r\n");
   		$props = array ('IdFilm', 'Titre', 'Titre_original', 'Realisateur', 'Annee');
		foreach ($props as $prop) {
			$val = $aFilms[$i][$prop];
			fwrite ($fp, "\t\t<" . $prop . ">" . $val . "</" . $prop . ">\r\n");
		}
		fwrite ($fp, "\t</Film>\r\n");
	}
	fwrite ($fp, "</Films>\r\n");
	fclose ($fp);
}

// function exportFilmTxt ($aFilmArray)
function saveFilm ($aFilmArray)
{
	$aFilm = new Film($aFilmArray);
	$filename = sprintf ("data/Film_%02d.txt", $aFilm->IdFilm);
	$fp = fopen ($filename, "w");
	$aFilm->writeTxt($fp);		
	fclose ($fp);
}

function readFilm ($IdFilm)
{
	$filename = sprintf ("data/Film_%02d.txt", $IdFilm);

/*
	ini_set ('auto_detect_line_endings ', FALSE);
	$lines = file ($filename); 
	
	// Loop through our array, show html source as html source; and line numbers too. 
	foreach ($lines as $line_num => $line) { 
	   echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n"; 
	}
	
	$fp = fopen ($filename, "r");	
	while ($fp && !feof ($fp)) {
		$sLine = fgets($fp);
		$aLine = explode ("||||", $sLine);
		
		print_r ($aLine);
		$aFilm[$aLine[0]] = $aLine[1];
	}
	fclose ($fp);
*/	
/*
	$sFile = file_get_contents ($filename);
	$aLines = explode ("\r\n", $sFile);
	
	foreach ($aLines as  $line)
	{ 
		$aElmt = explode ("||||", $line);
		if (count ($aElmt) > 1)
			$aFilm[$aElmt[0]] = html_entity_decode($aElmt[1]);
		else
			$aFilm[$aElmt[0]] = "";
	}
*/
	$lines = file ($filename);
	foreach ($lines as $line)
	{
		$aElmt = explode ("||||", trim ($line));
		if (count ($aElmt) > 1)
			$aFilm[$aElmt[0]] = html_entity_decode($aElmt[1]);
		else
			$aFilm[$aElmt[0]] = null;
	}
	$aFilm = new Film($aFilm);
	return $aFilm;
}

function getFilmFromId ($aFilms, $IdFilm)
{
	$aFilm = new Film($aFilms[$IdFilm-1]);
	return $aFilm;
}

function searchFilmOfId ($aFilms, $IdFilm)
{
	// echo "Recherche de film ".$IdFilm."<br>\n";
	foreach ($aFilms as $f) {
		// echo "<".$f['IdFilm']. "> (".gettype ($f['IdFilm']). ") - <" . $IdFilm. "> (".gettype ($IdFilm).")<br>\n";
		if ($f['IdFilm'] == $IdFilm)
		{
			$aFilm = new Film($f);
			break;
		}
	}
	if (is_null ($aFilm))
		echo "Non trouvé !<br>";
	else
		return $aFilm;
}

function getFilmById ($aFilms, $IdFilm)
{
	// echo "Recherche de film ".$IdFilm."<br>\n";
	foreach ($aFilms as $f) {
		// echo "<".$f['IdFilm']. "> (".gettype ($f['IdFilm']). ") - <" . $IdFilm. "> (".gettype ($IdFilm).")<br>\n";
		if ($f['IdFilm'] == $IdFilm)
		{
			$aFilm = new Film($f);
			break;
		}
	}
	if (is_null ($aFilm))
		echo "Non trouvé !<br>";
	else
		return $aFilm;
}

function readAdmin () 
{
	$filename = "admin.txt";
	$lines = file ($filename);
	foreach ($lines as $line)
		$aAs[] = explode ("|", trim ($line));
	
	return $aAs;
}
function saveAdmin ($aAd) 
{
	$filename = "admin.txt";
	$fp = fopen ($filename, "w");
	foreach ($aAd as $ad)
	{
		$sAd = implode ("|", $ad);
		$sAd .= "\r\n";
		fwrite ($fp, $sAd);
	}
	fclose ($fp);
}

function GetLastFilms () 
{
	$filename = "index.txt";
    $sId = file_get_contents ($filename);
	$aId = explode ("|", $sId);
	
	return $aId;	
}

function saveLastFilms ($aId) 
{
	$filename = "index.txt";
	$sId = implode ("|", $aId);
	$fp = fopen ($filename, "w");
	fwrite ($fp, $sId);
	fclose ($fp);
}

/*
function cmp($a, $b, $key)
{
	if (!(isset($a['$key']))) return (-1);
	if (!(isset($b['$key']))) return 1;
	if ($a['$key']>$b['$key']) return 1;
	if ($a['$key']<$b['$key']) return -1;
	if ($a['$key']==$b['$key']) return 0;
}
*/
function multi_sort($array, $key)
{
	/*
	if (!(isset($a['$key'])) return -1;
	if (!isset($b['$key']) return 1;
	($a['$key']>$b['$key'])?1:(($a['$key']==$b['$key'])?0:-1)
	if (!(isset(\$a['$key']))) return -1;
	if (!(isset(\$b['$key']))) return 1;
	if (\$a['$key']>\$b['$key']) return 1;
	if (\$a['$key']<\$b['$key']) return -1;
	if (\$a['$key']==\$b['$key']) return 0;";
	*/
	/*
	$cmp_val = "((\$a['$key']>\$b['$key'])?1:((\$a['$key']==\$b['$key'])?0:-1))";
	$cmp=create_function('$a, $b', "return $cmp_val;");
	$cmp_fct = "
		if (!(isset(\$a['$key']))) return -1;
		if (!(isset(\$b['$key']))) return 1;
		if (\$a['$key']>\$b['$key']) return 1;
		if (\$a['$key']<\$b['$key']) return -1;
		if (\$a['$key']==\$b['$key']) return 0;";
	*/
	$cmp_fct = "
		if (!(isset(\$a['$key']))) return -1;
		if (!(isset(\$b['$key']))) return 1;
		return ((\$a['$key']>\$b['$key'])?1:((\$a['$key']==\$b['$key'])?0:-1));";	

	$cmp=create_function('$a, $b', $cmp_fct);
	usort($array, $cmp);
	return $array;
}
/*
require ("FilmsCSS_fct.php");
$currentPage = $_SERVER["PHP_SELF"];
$filename = "Export_170306.xml";

$data = implode("",file($filename)); 
$array = xml2arrayLast ($data);

if (isset($_GET['order']))
{
	switch ($_GET['order'])
	{
		case 1:
			$order = "Titre";
			break;
		case 2:
			$order = "Titre_original";
			break;
		case 3:
			$order = "Realisateur";
			break;
		case 4:
			$order = "Annee";
			break;
	}
}
else $order = "Annee";

$aF = $array['Films'];
$aFilms = multi_sort($aF, $order);

if ($order == "Annee")
	$aFilms = array_reverse($aFilms);

// uasort ($aFilms, "cmpAnnee");
// $aFilm = new Film($aFilms[$IdFilm-1]); 
// $photoFiles = getPhotoArray($IdFilm, 1);
*/
/*
echo "<pre>";
print_r ($aF[0]);
print_r ($aFilms[0]);
echo "</pre>";
*/




function printAffiche($id) { 
	$ssdir = "photos/";
		
	$filename = sprintf ("affiche_%02d.jpg", $id);
	$filename_tn = sprintf ("affiche_%02d_tn.jpg", $id);
	$bLink = file_exists($ssdir.$filename);
	if ($bLink)
		$alt = "Grande taille";
	else
		$alt = "Grande taille non disponible !";
	if (file_exists($ssdir.$filename_tn))
	{
		$size = GetImageSize($ssdir.$filename_tn);
		if ($bLink)
			print '<a href="photo.php?IdFilm='.$id.'&&nom='.$ssdir.$filename.'">';
			
		print '<img class="cadre" src="'.$ssdir.$filename_tn.'" alt="' .$alt . '" width="'.$size[0].'" height="'.$size[1].'" />';
		if ($bLink)
			print '</a>';
	} 
	else 
	{
		print '<img src="'.$ssdir.'affiche_00_tn.jpg" alt= width="132" height="189"/>';
	}	
	print "\n";
}

function printReal($id) { 
	$ssdir = "photos/";
		
	$filename_tn = sprintf ("real_%02d_01.jpg", $id);
	
	if (file_exists($ssdir.$filename_tn))
	{
		$size = GetImageSize($ssdir.$filename_tn);
		
		// print '<a href="'.$ssdir.$filename.'">';
		// print '<img src="'.$ssdir.$filename_tn.'" alt="Réalisateur" width="'.$size[0].'" height="'.$size[1].'" />';
		print '<div class="ph_real">';
		if ($size[0] > 100) 
			print '<img src="'.$ssdir.$filename_tn.'" alt="Réalisateur" width="100" />';
		else
			print '<img src="'.$ssdir.$filename_tn.'" alt="Réalisateur" width="'.$size[0].'"/>';
		print '</div>';
		// print '</a>';
	} 
	print "\n";
}


function getAffiche($id) { 
	$format = "photos/affiche_%02d_tn.jpg";
	$filename = sprintf ($format, $id);
	if (file_exists($filename)) {
	    // print "Le fichier $filename existe<br>";
		return $filename; 
	} else {
    	// print "Le fichier $filename n'existe pas<br>";
		return ("photos/affiche_00_tn.jpg");
	}
}
function getPhotoArray($id, $no) { 
	$ssdir = "photos";
	
	// Ouvre un dossier bien connu, et liste tous les fichiers
	/*
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				print "fichier : $file : type: " . filetype($dir . $file) . "<br>\n";
			}
		closedir($dh);
		}
	}
	*/
	// $format = "images/photo_%02d_%02d_tn.jpg";
	$d = dir($ssdir);
	// echo "Handle: ".$d->handle."<br>\n";
	// echo "Path: ".$d->path."<br>\n";
	$pattern = '/\.jpg$/';
	$pattern = sprintf ("/photo_%02d_..\.jpg/", $id);
	$tn = sprintf ("/photo_%02d_..\.jpg/", $id);
	// echo "Pattern: ".$pattern."<br>\n";
	while (false !== ($entry = $d->read())) {
		if (preg_match($pattern, $entry))
			$files[] = $entry;
			// array ("photo" => $entry, "tn" => ;
	}
	$d->close();
	
	if (isset ($files) && count ($files) > 0) {
	/*	
	foreach($files as $file)
			echo $file."<br>\n";
	*/
		return $files;
	}
/*	
if (is_file($file) && preg_match('/\.txt$/', $file)) {
echo "$file\n";
	foreach (glob("images\*.jpg") as $filename) { 
	   echo "$filename size " . filesize($filename) . "<br>\n"; 
} 
*/

}

function printPhotoTable ($aFilm, $files)
{
	$ssdir = "photos/";
	// border="1" 
	print '<table width="100%" cellpadding="4" cellspacing="4" bordercolor="#CCCCCC" bgcolor="#FFFFFF">';
	print "\n";
	print "<tr>\n";

	$nb = count ($files);
	$nbCol = 4;
	$nbCaseLeft = $nbCol - ($nb % $nbCol);
	for ($i=0; $i<$nb; $i++)
	{
		$photo = $files[$i];
		$len = strlen ($photo);
		$tn = substr($files[$i], 0, $len-4)."_tn".".jpg";
		if ($i>0 && !($i % $nbCol))
	  		print "</tr>\n<tr>\n";
		print '<td width="25%" height="110"><div align="center">';
		// lienwidth="110" 
		print '<a href="photo.php?IdFilm='.$aFilm->IdFilm.'&&nom='.$ssdir.$photo.'">';
		// source
		print '<img class="cadre" src="';
		print $ssdir.$tn;
		$size = GetImageSize($ssdir.$tn);  
		print '" width="'.$size[0].'" height="'.$size[1].'" />';
		// lien
		print '</a>';
		print '</div></td>';		
		print "\n";
	}
	for ($i=0; $i<$nbCaseLeft; $i++)
	{
		print '<td width="25%"></td>';
	}
	print "</tr>\n</table>\n";			 
}

function getPhoto($id, $no) { 
	$ssdir = "photos";
	$format = $ssdir."/photo_%02d_%02d_tn.jpg";
	$filename = sprintf ($format, $id, $no);
	if (file_exists($filename)) {
	    // print "Le fichier $filename existe<br>";
		return $filename; 
	} else {
    	// print "Le fichier $filename n'existe pas<br>";
		return ("images/photo_00_tn.jpg");
	}
}


/*
	Fonctions d'affichage
*/	   



function printNavigation ($aFilms, $IdFilm)
{
$currentPage = $_SERVER["PHP_SELF"];
?>
<table  style="border:1px solid #000" bgcolor="#dddddd" width="80%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<td width="50%" height="29">
  	<?php if ($IdFilm > 1) { ?>
		<a href="<?php echo $currentPage ?>?IdFilm=<?php echo $IdFilm-1 ?>">Pr&eacute;c&eacute;dent</a>
  	<?php } ?>
	</td>
	<td width="50%">
  	<?php if ($IdFilm < count($aFilms)) { ?>
		<div align="right"><a href="<?php echo $currentPage ?>?IdFilm=<?php echo $IdFilm+1 ?>">Suivant</a></div>
  	<?php } ?>
	</td>
  </tr>
</table>
<?php 
}

function printFicheTechnique ($aFilm)
{

/*
  <tr>
    <td><strong>35 mm</strong></td>
    <td><?php echo $aFilm->f35mm ?></td>
  </tr>
*/  

?>
<div id="fiche">
<table width="100%">
  <tr>
    <td width="30%"><strong>Ann&eacute;e</strong></td>
    <td width="70%"><?php echo $aFilm->Annee ?></td>
  </tr>
  <tr>
    <td><strong>Dur&eacute;e</strong></td>
    <td><?php echo $aFilm->Duree ."'" ?></td>
  </tr>
  <tr>
    <td><strong>Langue</strong></td>
    <td><?php echo $aFilm->Langue .", ". $aFilm->Version ?></td>
  </tr>
  <tr>
    <td><strong>Visa</td>
    <td><?php echo $aFilm->Visa ?></td>
  </tr>
  <tr>
    <td><strong>Format</strong></td>
    <td><?php echo $aFilm->f35mm . ", " . $aFilm->Format ?></td>
  </tr>
  <tr>
    <td><strong>Sc&eacute;nario</strong></td>
    <td><?php echo $aFilm->Scenario ?></td>
  </tr>
  <tr>
    <td><strong>Photographie</strong></td>
    <td><?php echo $aFilm->Photographie ?></td>
  </tr>
  <tr>
    <td><strong>Montage</strong></td>
    <td><?php echo $aFilm->Montage ?></td>
  </tr>
  <tr>
    <td><strong>Son</strong></td>
    <td><?php echo $aFilm->Son ?></td>
  </tr>
  <tr>
    <td><strong>Musique</strong></td>
    <td><?php echo $aFilm->Musique ?></td>
  </tr>
  <tr>
    <td><strong>D&eacute;cors</strong></td>
    <td><?php echo $aFilm->Decors ?></td>
  </tr>
  <tr>
    <td><strong>Costumes</strong></td>
    <td><?php echo $aFilm->Costumes ?></td>
  </tr>
  <tr>
    <td><strong>Interpr&egrave;tes</strong></td>
    <td><?php echo $aFilm->Interpretation ?></td>
  </tr>
  <tr>
    <td><strong>Production</strong></td>
    <td><?php echo $aFilm->Production ?></td>
  </tr>
</table>
</div>
<?php
}
?>
