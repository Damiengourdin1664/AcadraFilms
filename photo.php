<?php
	include ("header.inc.php");
	
	if (!isset($_GET['nom']))
	{
		// echo "\n<br> ** IdFilm not set ! ** \n<br>";
		$erreur = "Photo introuvable !";
	}
	else $nom = $_GET['nom'];
?>

<?php if (isset ($nom)) { ?>
	<br>
	<table align="center" width="50%" border="0" cellpadding="0" cellspacing="5">
      <tr bgcolor="#eeeeee">
        <td style=" margin:10px; padding:3px; border:1px solid #cccccc;" >
		<h3 style="margin:2px; "><?php echo $aFilm->Titre ?></h3>
		<h4 style="margin:2px; ">(<?php echo $aFilm->Titre_original ?>)</h4>
		<p style="margin:5px; ">un film de <span style="font-size: 1.1em; font-weight: bold"><?php echo $aFilm->Realisateur ?></span></p>
		</td>
      </tr>
      <tr>
        <td><img src="<?php echo $nom ?>" style="padding: 2px; background-color:#eeeeee; border: 1px solid #999999;" /></td>
      </tr>
	</table>		
	<br>
	<p align="center"><span class="mylink"><a href="javascript:history.back()">Retour au film</a></span></p>
    <?php } ?>
	
<?php
	include ("footer.inc.php");
?>