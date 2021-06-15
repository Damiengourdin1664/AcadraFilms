<?php
	include ("header.inc.php");

	if (isset($_GET['order']))
	{
		switch ($_GET['order'])
		{
			case 1:
				$order = "Annee";
				break;
			case 2:
				$order = "Titre";
				break;
			case 3:
				$order = "Realisateur";
				break;
		}
	}
	else $order = "Annee";

	if ($_VERSION == 3)
	{
		$aFilms = $films->getFilmsResume ();
	}
	// echo "Ordre : par " .$order ."<br>";
	$aFilms = multi_sort($aFilms, $order);

	
	if ($order == "Annee")
		$aFilms = array_reverse($aFilms);

?>
	<div id="left">
		<div id="menu">
		<dl id="gallery">
			<dt>Trier...</dt>
			<dd><a href="<?php echo $currentPage ?>?order=1" title="Tri par année">...par année</a></dd>
			<dd><a href="<?php echo $currentPage ?>?order=2" title="Tri par titre">...par titre</a></dd>
			<dd><a href="<?php echo $currentPage ?>?order=3" title="Tri par r&eacute;alisateur ">...par r&eacute;alisateur</a></dd>
		</dl>
		</div>
	</div>

	<div id="center">
	<h1>Voici le catalogue de tous nos films</h1>

	
<!-- 	<table width="100%" bgColor="#ffffff" align="center" cellpadding="10" cellspacing="10" style="border: 1px solid #999">
 -->	
	<table width="100%" bgColor="#FFFFFF" align="center" cellpadding="10" cellspacing="2" style="border: 2px solid #E1FCAE">
	  <?php 
		$nbFilms = count ($aFilms);
		for ($i=0; $i < $nbFilms; $i+=2) {
			$aFilm = new Film($aFilms[$i]);
			if ($i%4) { ?>
	  			<tr bgcolor= "#cccccc"><!-- "#E1FCAE"-->
	  <?php } else { ?>
	  			<tr bgcolor= "#eeeeee"><!-- "#FFD37D" -->
	  <?php } ?>
		<td width="50%" align="left">
		<a href="film.php?IdFilm=<?php echo $aFilm->IdFilm; ?>"><img class="cadre" style="float:left; margin:0 10px 0 0" src=<?php echo getAffiche ($aFilm->IdFilm) ?> alt="<?php echo $aFilm->Titre; ?>" height="90"/></a>
		<p class="mylink"><a href="film.php?IdFilm=<?php echo $aFilm->IdFilm; ?>"><?php echo $aFilm->Titre; ?></a><br>
		(<?php echo $aFilm->Titre_original; ?>)</p>
		<p>de <?php echo $aFilm->Realisateur; ?><br>
		Ann&eacute;e&nbsp;<?php echo $aFilm->Annee; ?></p>
		</td>
	  <?php if ($i+1 < $nbFilms) {
			$aFilm2 = new Film($aFilms[$i+1]);
	    ?>
		<td width="50%" align="left">
		<a href="film.php?IdFilm=<?php echo $aFilm2->IdFilm; ?>"><img class="cadre" style="float:left; margin:0 10px 0 0" src=<?php echo getAffiche ($aFilm2->IdFilm) ?> alt="<?php echo $aFilm2->Titre; ?>" height="90"/></a>
		<p class="mylink"><a href="film.php?IdFilm=<?php echo $aFilm2->IdFilm; ?>"><?php echo $aFilm2->Titre; ?></a><br>
		(<?php echo $aFilm2->Titre_original; ?>)</p>
		<p>de <?php echo $aFilm2->Realisateur; ?><br>
		Ann&eacute;e&nbsp;<?php echo $aFilm2->Annee; ?></p>
	  <?php } ?>
		</td>
		</tr>
	  <?php } ?>
  </table>

	</div>

	<p>&nbsp;</p>
<?php
	include ("footer.inc.php");
?>
