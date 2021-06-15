<?php	
/*
function getFields ()
{
$aFields = array (
	"IdFilm" => array ("libelle" => "n° du film", "format" => "text"),
	"Titre_original" => array ("libelle" => "Titre original", "format" => "text"),
	"Titre" => array ("libelle" => "Titre", "format" => "text"),
	"Realisateur" => array ("libelle" => "Réalisateur", "format" => "text"),
	"Prix" => array ("libelle" => "Prix", "format" => "textarea"),
	"Annee" => array ("libelle" => "Année", "format" => "text"),
	"Duree" => array ("libelle" => "Durée", "format" => "text"),
	"Langue" => array ("libelle" => "Langue", "format" => "text"),
	"Visa" => array ("libelle" => "Visa", "format" => "text"),
	"Version" => array ("libelle" => "Version", "format" => "text"),
	"f35mm" => array ("libelle" => "35 mm", "format" => "text"),
	"Format" => array ("libelle" => "Format", "format" => "text"),
	"FormatSon" => array ("libelle" => "Format du son", "format" => "text"),
	"Scenario" => array ("libelle" => "Scénario", "format" => "text"),
	"Photographie" => array ("libelle" => "Photographie", "format" => "text"),
	"Montage" => array ("libelle" => "Montage", "format" => "text"),
	"Musique" => array ("libelle" => "Musique", "format" => "text"),
	"Son" => array ("libelle" => "Son", "format" => "text"),
	"Decors" => array ("libelle" => "Décors", "format" => "text"),
	"Costumes" => array ("libelle" => "Costumes", "format" => "text"),
	"Interpretation" => array ("libelle" => "Interprétation", "format" => "text"),
	"Production" => array ("libelle" => "Production", "format" => "text"),
	"Affiche" => array ("libelle" => "Affiche", "format" => "text"),
	"Nb_Photos" => array ("libelle" => "Nb Photos", "format" => "text"),
	"Photos" => array ("libelle" => "Photos", "format" => "text"),
	"Synopsis" => array ("libelle" => "Synopsis", "format" => "textarea"),
	"Critiques" => array ("libelle" => "Critiques", "format" => "textarea"),
	"Interviews" => array ("libelle" => "Interviews", "format" => "textarea"),
	"Biographie" => array ("libelle" => "Biographie", "format" => "textarea"),
	"Filmographie" => array ("libelle" => "Filmographie", "format" => "textarea"));
	return $aFields;
}
*/
class XmlFilmParser {
	var $xmldoc;
	var $xmlfile;
	var $xmlurl = "";
	var $xmltext = "";
	var $domparser = "domit";
	var $saxparser = "saxy";
	var $extension = "xml";
	
	function XmlFilmParser () {
		$this->xmlfile = "valid_Films.xml";
	}
	
	
	function parse() {
		//change this to the domit path
		// require_once('domit_1_1/xml_domit_parser.php');
		// $this->xmldoc = new DOMIT_Document();

		// Optimisation : plus rapide en "lite"
		require_once('domit_1_1/xml_domit_lite_include.php');
		$this->xmldoc = new DOMIT_Lite_Document();
		$this->xmldoc->expandEmptyElementTags(true);
		// $this->xmldoc->setNamespaceAwareness(true);
		
		// Optimisation : plus rapide
		$parseSAXY = false;
		$success = $this->xmldoc->loadXML($this->xmlfile, $parseSAXY);

		if ($success) {
			// $this->updateParseFilms();
			return true;
		}
		else {
			echo "<br /><br />Parsing error: xml document may be invalid or malformed.\n";
			return false;
		}
	} //parse

	function saveFilmArray ($xFilm, $aFilm)
	{	
		foreach ($aFilm as $prop => $val)
		{
			$n =& $xFilm->getElementsByPath($prop, 1);
			if ($n == null) {
				echo "Erreur : le champ " . $prop . " n'existe pas !";
			} else {
				$n->firstChild->nodeValue = $val;
			}
		}
		$this->save("new_" . $this->xmlfile);
	}

	function save($newxmlfile) {
		// $bSaveWithNormalization = true;
		// Ne modifie pas le codage caractère dans un doc
		// xml version='1.0' encoding='ISO-8859-15'
		
		// Par contre saveXML double les & en &amp; !!

		$bSaveWithNormalization = true;
		$success = $this->xmldoc->saveXML($newxmlfile, $bSaveWithNormalization);
		// $success = $this->xmldoc->saveXML("new_".$this->xmlfile, $bSaveWithNormalization);
		// $this->saveText ();
		return $success;
	} // save
	
	function saveValid() {
		$bSaveWithNormalization = true;
		$success = $this->xmldoc->saveXML("valid_".$this->xmlfile, $bSaveWithNormalization);
		return $success;
	} // saveValid
	
	function saveText () {
		$filename = "Film_test.txt";
		$fp = fopen ($filename, "w");
		$xFilms = $this->xmldoc;

		if ($xFilms->documentElement->hasChildNodes()) {
		
			$nbFilms =& $xFilms->documentElement->childCount;
			$n_films =& $xFilms->documentElement->childNodes;

			for ($i = 0; $i < $nbFilms; $i++) { 
				$xFilm =& $n_films[$i];
				
				if ($xFilm->hasChildNodes()) {
					$nbFld =& $xFilm->childCount;
					$nodes =& $xFilm->childNodes;
					for ($j = 0; $j < $nbFld; $j++) { 
						$node =& $nodes[$j];
						// $node->firstChild->nodeValue = addslashes (htmlentities ($node->firstChild->nodeValue, ENT_QUOTES));
						// $node->firstChild->nodeValue = addslashes (htmlspecialchars ($node->firstChild->nodeValue, ENT_QUOTES));
						// $node->firstChild->nodeValue = addslashes ($node->firstChild->nodeValue);
						$prop = $node->nodeName;
						$val = $node->firstChild->nodeValue;
						fwrite ($fp, $prop . "||||" . $val . "\r\n");
					}
				}
			}
		}
		fclose ($fp);
	}

	function affiche () {
		$xFilms = $this->xmldoc;

		if ($xFilms->documentElement->hasChildNodes()) {
		
			$nbFilms =& $xFilms->documentElement->childCount;
			$n_films =& $xFilms->documentElement->childNodes;

			for ($i = 0; $i < $nbFilms; $i++) { 
				echo "<h1>Film : n° " . $i . "</h1><br/>";
				$xFilm =& $n_films[$i];
				
				// $xFilm->firstChild->nodeValue;
				if ($xFilm->hasChildNodes()) {
					$nbFld =& $xFilm->childCount;
					$nodes =& $xFilm->childNodes;
					for ($j = 0; $j < $nbFld; $j++) { 
						$node =& $nodes[$j];
						// $node->firstChild->nodeValue = addslashes (htmlentities ($node->firstChild->nodeValue, ENT_QUOTES));
						// $node->firstChild->nodeValue = addslashes (htmlspecialchars ($node->firstChild->nodeValue, ENT_QUOTES));
						// $node->firstChild->nodeValue = addslashes ($node->firstChild->nodeValue);
						echo $node->nodeName . " -> " . $node->firstChild->nodeValue . "<br/>";
					}
				}
			}
		}
		// $this->save ();
	}
	function makeValid () {
		$xFilms = $this->xmldoc;

		if ($xFilms->documentElement->hasChildNodes()) {
		
			$nbFilms =& $xFilms->documentElement->childCount;
			$n_films =& $xFilms->documentElement->childNodes;

			for ($i = 0; $i < $nbFilms; $i++) { 
				// echo "Film : n° " . $i . "<br/>";
				$xFilm =& $n_films[$i];
				
				// $xFilm->firstChild->nodeValue;
				if ($xFilm->hasChildNodes()) {
					$nbFld =& $xFilm->childCount;
					$nodes =& $xFilm->childNodes;
					for ($j = 0; $j < $nbFld; $j++) { 
						$node =& $nodes[$j];
						// $node->firstChild->nodeValue = addslashes (htmlentities ($node->firstChild->nodeValue, ENT_QUOTES));
						// $node->firstChild->nodeValue = addslashes (htmlspecialchars ($node->firstChild->nodeValue, ENT_QUOTES));
						$node->firstChild->nodeValue = htmlspecialchars ($node->firstChild->nodeValue, ENT_QUOTES);
						$node->firstChild->nodeValue = nl2br ($node->firstChild->nodeValue);
						// $node->firstChild->nodeValue = addslashes ($node->firstChild->nodeValue);
						// echo "Valeur : " . $node->nodeName . " -> " . $node->firstChild->nodeValue . "<br/>";
					}
				}
			}
		}
		// $this->save ();
	}
/*
		echo "Id : [" . $id . "]\n<br />";
		echo "Test : " . $nodes[0] . "\n<br />";
		echo "Test : " . $nodes[0]->toString . "\n<br />";
		echo "Test : " . $nodes[0]->nodeValue . "\n<br />";
		echo "Test : " . $nodes->item[0] . "\n<br />";
		echo "Test : " . $nodes->item[0]->toString . "\n<br />";
		echo "Test : " . $nodes->item[0]->nodeValue . "\n<br />";
		for ($i = 0; $i < $total; $i++) {
								
			$node =& $nodes->item($i);
			echo "Id : [" . $node->toString() . "]\n<br />";
			$sId = $node->toString();
			echo ("Node is : " . $node->toNormalizedString(true) . "\n<br />");
			$pnode = $node->parentNode;
			echo ("Parent node is : " . $pnode->toNormalizedString(true) . "\n<br />");
			$xId =& $node->firstChild;
			echo ("Value is : " . $xId->nodeValue . "\n<br />");
			
			// echo "Id : " . $node->nodeValue . "\n<br />";
			// echo "Id : " . $node->getData() . "\n<br />";
			if ($sId == $id)
				return $node;
		}		
*/

	function getFilmCount () {
		$xFilms = $this->xmldoc;
		$nb = 0;
		if ($xFilms->documentElement->hasChildNodes())		
			$nb = $xFilms->documentElement->childCount;
		return nb;
	}
	
	function getFilmArrayById ($id)
	{
		$xFilms = $this->xmldoc;
		$nodes = $xFilms->getElementsByTagName ("IdFilm");
		$total = $nodes->getLength();					

		for ($i = 0; $i < $total; $i++) {								
			$xFilm =& $nodes->item($i);
			$iid = $xFilm->firstChild->nodeValue;
			if ($iid == $id)
				break;
		}
		
		$nbFld =& $xFilm->childCount;
		$nodes =& $xFilm->childNodes;
		for ($j = 0; $j < $nbFld; $j++) { 
			$node =& $nodes[$j];			
			$aFilms[$node->nodeName] = $node->firstChild->nodeValue;
		}
		return $aFilms;
	}

	function getFilmArray ($xFilm)
	{
		if ($xFilm->hasChildNodes()) {
			$nbFld =& $xFilm->childCount;
			$nodes =& $xFilm->childNodes;
			for ($j = 0; $j < $nbFld; $j++) { 
				$node =& $nodes[$j];			
				$aFilms[$node->nodeName] = $node->firstChild->nodeValue;
			}
		}
		return $aFilms;
	}

	function getFilmById ($id) {
		$xFilms = $this->xmldoc;
		$nodes = $xFilms->getElementsByTagName ("IdFilm");
		$total = $nodes->getLength();					

		for ($i = 0; $i < $total; $i++) {								
			$node =& $nodes->item($i);
			$iid = $node->firstChild->nodeValue;
			if ($iid == $id)
				return $node->parentNode;
		}		
		return (null);
	}
	
	function getFilmsTitleEx () {
		$xFilms = $this->xmldoc;
		$nodes = $xFilms->getElementsByTagName ("Titre");
		$total = $nodes->getLength();					
		
		for ($i = 0; $i < $total; $i++) {
			$node =& $nodes->item($i);
			$pnode =& $node->parentNode;
			$id = $this->getField($pnode, 'IdFilm');
			/*
			$id = $this->getField($pnode, 'IdFilm');
			$title = $this->getField($pnode, 'Titre');
			$Titles[] = array ($id, $title);
			*/
			$titles[] = array ('Titre' => $node->firstChild->nodeValue, 'IdFilm' => $id);
			// $Titles[] = $node->firstChild->nodeValue;
		}
		return ($titles);
	}
	
	function getFilmsResume () {
		$xFilms = $this->xmldoc;
		$nodes =& $xFilms->getElementsByTagName ("Films");
		$total = $nodes->getLength();					
		
		for ($i = 0; $i < $total; $i++) {
			$node =& $nodes->item($i);

			$n =& $node->getElementsByPath("IdFilm", 1);			
			$id = $n->firstChild->nodeValue;

			$n =& $node->getElementsByPath("Titre", 1);
			$titre = $n->firstChild->nodeValue;

			$n =& $node->getElementsByPath("Titre_original", 1);
			$Titre_original = $n->firstChild->nodeValue;

			$n =& $node->getElementsByPath("Realisateur", 1);
			$Realisateur = $n->firstChild->nodeValue;

			$n =& $node->getElementsByPath("Annee", 1);
			$Annee = $n->firstChild->nodeValue;

			$titles[] = array ('IdFilm' => $id, 'Titre' => $titre, 'Titre_original' => $Titre_original, 'Realisateur' => $Realisateur, 'Annee' => $Annee);
		}
		return ($titles);
	}
	
	function getFilmsTitle () {
		$xFilms = $this->xmldoc;
		$nodes =& $xFilms->getElementsByTagName ("Films");
		$total = $nodes->getLength();					
		
		for ($i = 0; $i < $total; $i++) {
			$node =& $nodes->item($i);

			$n_ids =& $node->getElementsByTagName("IdFilm");			
			$n_id =& $n_ids->item(0);
			$id = $n_id->firstChild->nodeValue;

			$n_titres =& $node->getElementsByTagName("Titre");
			$n_titre =& $n_titres->item(0);
			$titre = $n_titre->firstChild->nodeValue;

			/*
			echo ("id : " .  $id . "\n<br />");
			echo ("titre : " .  $titre . "\n<br />");

			$id = $this->getField($pnode, 'IdFilm');
			$title = $this->getField($pnode, 'Titre');
			$Titles[] = array ($id, $title);
			*/
			// $Titles[] = $node->firstChild->nodeValue;
			$titles[] = array ('Titre' => $titre, 'IdFilm' => $id);
		}
		return ($titles);
	}
	
	function getFilmField ($node, $fldName) {
		$elmt =& $node->getElementsByPath($fldName, 1);
		$val =& $elmt->firstChild->nodeValue;
		return ($val);
	}
	
	function getFieldNode($node, $fldName) {
		$elmt =& $node->getElementsByTagName ($fldName);
		return ($elmt);
	}
	
	function getField($node, $fldName) {
		$elmt =& $node->getElementsByTagName ($fldName);
		echo ("Elmt : " .  $elmt->toNormalizedString(true) . "\n<br />");
		$val = $elmt->firstChild->nodeValue;
		echo ("Val : " .  $val->toNormalizedString(true) . "\n<br />");
		return ($val);
	}
	
	function updateParseFilms () {
		echo "<br />updateParseFilms : <br />\n";
		$xFilms = $this->xmldoc;

		$xFilm =& $this->getFilmById ("29");
		// Fonctionne aussi !
		// $xFilm =& $this->getFilmById (29);
		if ($xFilm != null)
			echo ("Film cherché : \n<br />" . 
				$xFilm->toNormalizedString(true) . "\n<br />");
		else
			echo ("Film introuvable...\n<br />");
		
		// Récupère le premier child (film)
		if ($xFilms->documentElement->hasChildNodes()) {
		
			$xFilm1 =& $xFilms->documentElement->firstChild;
			
			/*	
			echo ("The contents of the firstChild : \n<br />" . 
						$xFilm1->toNormalizedString(true));						
			$xFilm2 =& $xFilm1->nextSibling;
			
			//echo out the node to browser
			echo ("The contents of the next sibling are: \n<br />" . 
						$xFilm2->toNormalizedString(true));
			*/
			if ($xFilm1->hasChildNodes()) {
	
				$value = $this->getField ($xFilm1, "Titre");
				if ($value != null)
				{
					echo "<pre>";
					echo $value;
					// print_r ($value);
					echo "</pre>";
					echo "Element : " . $value->toString() . "\n<br />";
					
					//get total number of nodes in the list
					$total = $value->getLength();					
					//loop through node list 
					for ($i = 0; $i < $total; $i++) {					
						//get current node on list
						$currNode =& $value->item($i);
						echo "Element : " . $currNode . "\n<br />";
						echo "Element : " . $currNode->toString() . "\n<br />";
					}
					// echo "Element : " . $value->getData() . "\n<br />";
					// echo "Element : " . $value->nodeValue() . "\n<br />";					
				}

				$numChildren =& $xFilm1->childCount;
				$xDatas =& $xFilm1->childNodes;
				//iterate through the collection
				for ($i = 0; $i < $numChildren; $i++) {			
					//get a reference to the i childNode
					$currentNode =& $xDatas[$i];			
					//echo out the node to browser
					echo ("Node $i contents are: \n<br />" . 
						$currentNode->toNormalizedString(true) . "\n<br />");
						
				}
			}
			else
				echo "xFilm1 n'a pas d'enfants...";

			
			$xData =& $xFilm1->firstChild;
			echo "Node name: " . $xData->nodeName;
			echo "\n<br />";
			
			//echo out node type
			echo "Node type: " . $xData->nodeType;
			echo "\n<br />";
			
			//echo out node value
			echo "Node value: " . $xData->nodeValue;
			echo "\n<br />";
			
			//echo out the node to browser
			echo ("The contents of the first child node are: \n<br />" . // $xData->nodeValue);
						$xData->toNormalizedString(true));
		}
		return;

		
		if ($xFilms->documentElement->hasChildNodes()) {
			//get a reference to the childNodes collection of the document element
			$myChildNodes =& $xFilms->documentElement->childNodes;
			
			//get the total number of childNodes for the document element
			$numChildren =& $xFilms->documentElement->childCount;
			
			//iterate through the collection
			for ($i = 0; $i < $numChildren; $i++) {			
				//get a reference to the i childNode
				$currentNode =& $myChildNodes[$i];			
				//echo out the node to browser
				echo ("Node $i contents are: \n<br />" . 
					$currentNode->toNormalizedString(true) . "\n<br />\n<br />");
			}
		}		
		return;
		//use getElementsByTagName to gather all elements named "cd"
		$matchingNodes =& $xFilms->getElementsByTagName("Films");
		
		//if any matching nodes are found, echo to browser
		if ($matchingNodes != null) {
			echo $matchingNodes->toNormalizedString(true);
		}
		
		//use getElementsByPath to retrieve the first cd element in cdlibrary
		$myElement =& $this->xmldoc->getElementsByPath("/Films", 1);		
		//echo to browser
		if ($myElement != null) {
			echo $myElement->toNormalizedString(true);
		}
		
		//find all text nodes in cdlibrary
		$myTextNodeList =& $this->xmldoc->getNodesByNodeType(DOMIT_TEXT_NODE, $this->xmldoc);		
		//echo to browser
		echo $myTextNodeList->toNormalizedString(true);	
	} // updateParseFilms
	
	function getFiles($extension) {
		$arFiles = array();
		
		if ($handle = opendir('.')) {
			while (false !== ($file = readdir($handle))) {			 
				if ($file != "." && $file != "..") { 
					if ($extension == $this->getExtension($file)) {
						$arFiles[] = $file; 
					}					
				}
			}
		}	
		closedir($handle);
		return $arFiles;
	} //getFiles	
	
	function getExtension($filename) {
		$extension = "";
		$dotPos = strpos($filename, "."); 
		
		if ($dotPos !== false) {
			$extension = substr($filename, ($dotPos + 1));
		}		
		return $extension;
	} //getExtension



} //test_domit

?>
