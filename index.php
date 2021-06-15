<?php
	include ("header.inc.php");
	
	$aId = GetLastFilms ();
	if ($_VERSION == 2) 
	{
		$nFilms[] = getFilmById($aFilms, $aId[0]);
		$nFilms[] = getFilmById($aFilms, $aId[1]);
		$nFilms[] = getFilmById($aFilms, $aId[2]);
	}
	if ($_VERSION == 3) 
	{
		$film1 =& $films->getFilmById ($aId[0]);
		$film2 =& $films->getFilmById ($aId[1]);
		$film3 =& $films->getFilmById ($aId[2]);
		$aFilm1 = $films->getFilmArray ($film1);
		$aFilm2 = $films->getFilmArray ($film2);
		$aFilm3 = $films->getFilmArray ($film3);
		$nFilms[] = new Film ($aFilm1);
		$nFilms[] = new Film ($aFilm2);
		$nFilms[] = new Film ($aFilm3);
	}
	/*
	// $id = $films_xml->getField ($film1, 'IdFilm');
	// $elmt =& $film1->getElementsByPath("IdFilm", 1);
	// $val = $films->getFilmField ($film1, 'IdFilm');
	// $aFilm1 = $films->getFilmArray ($film1);
	// $val =& $film1->getElementsByPath("IdFilm")->firstChild;
	// echo ("Val : " .  $val . "\n<br />");

	echo "<pre>";
	print_r ($nFilms[0]);
	echo "</pre>";
	*/
?>
<style type="text/css">
<!--
.auteur {
	font-style:italic;
	color:#666666;
}
-->
</style>



	<div id="left">
	  <a href="index.php?cmd=connect"><img src="images/ange_acadra.jpg" width="120" border="0" /></a>
	</div>
	<div id="center">
	<!--
		<h1>Bienvenu sur le site d'Acadra. </h1>
	    <h2>Bienvenu sur le site d'Acadra. </h2>
	    <h3>Bienvenu sur le site d'Acadra. </h3>
	-->	    

		<?php if (isset($Admin) && $Admin) { ?>
			<h3>Gestion du site</h3>
		    <p><?php echo $_SERVER['PHP_AUTH_USER'] ?> est connecté en mode d'administration.<br/>
		<?php } else { ?>
			<h1>Bienvenue sur le site d'Acadra !</h1>
			<p>Vous trouverez ici l'ensemble des films italiens que nous distribuons.</p>
		<?php } ?>
	
	</div>
	<div style="clear:both"></div>

	<div style="margin:20px 80px">
	<p>&nbsp;</p>
		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				
				<h1>Fiches de nos derniers films</h1>
	<p>&nbsp;</p>
<!--     	
<h2 align="center">Voici les fiches concernant nos derniers films</h2>
 -->
  <table width="99%"  border="0" align="center" cellpadding="5" cellspacing="0">
    <td width="33%"><div align="center"><a href="film.php?IdFilm=<?php echo $nFilms[0]->IdFilm ?>"><img class="cadre" src="<?php echo getAffiche ($nFilms[0]->IdFilm) ?>" alt="<?php echo $nFilms[0]->Titre ?>" height="189" /></a></div></td>
    <td width="33%"><div align="center"><a href="film.php?IdFilm=<?php echo $nFilms[1]->IdFilm ?>"><img class="cadre" src="<?php echo getAffiche ($nFilms[1]->IdFilm) ?>" alt="<?php echo $nFilms[1]->Titre ?>" height="189" /></a></div></td>
    <td width="33%"><div align="center"><a href="film.php?IdFilm=<?php echo $nFilms[2]->IdFilm ?>"><img class="cadre" src="<?php echo getAffiche ($nFilms[2]->IdFilm) ?>" alt="<?php echo $nFilms[2]->Titre ?>" height="189" /></a></div></td>
  </tr>
  <tr>
    <td><div align="center"><span class="mylink"><a href="film.php?IdFilm=<?php echo $nFilms[0]->IdFilm ?>"><?php echo $nFilms[0]->Titre ?></a></span><br>de <?php echo $nFilms[0]->Realisateur ?></div></td>
    <td><div align="center"><span class="mylink"><a href="film.php?IdFilm=<?php echo $nFilms[1]->IdFilm ?>"><?php echo $nFilms[1]->Titre ?></a></span><br>de <?php echo $nFilms[1]->Realisateur ?></div></td>
    <td><div align="center"><span class="mylink"><a href="film.php?IdFilm=<?php echo $nFilms[2]->IdFilm ?>"><?php echo $nFilms[2]->Titre ?></a></span><br>de <?php echo $nFilms[2]->Realisateur ?></div></td>
  </tr>
  </table>
	<p>&nbsp;</p>
  
 			</div>
			
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>

		</div>

	<p>&nbsp;</p>

		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
    	<h1>Prochaines projections de presse</h1>

	    <table style="margin:10px;" width="80%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td><a href="film.php?IdFilm=30"><img class="cadre" src="photos/affiche_30_tn.jpg" alt="Un silence particulier" height="80"/></a></td>
            <td><p><span class="mylink"><a href="film.php?IdFilm=30">Un silence particulier</a></span> de Stefano Rulli<br>
  (t&eacute;l&eacute;charger ici le dossier au format Adobe pdf 524 ko <a href="docs/presse silenzio particolare.pdf"><img src="images/pdf.gif" width="16" height="16" border="0"></a> )</p>
              <p> Mardi 4 juillet 15h30<br>
  Mercredi 5 juillet à 13h</p></td>
          </tr>
          <tr>
            <td><a href="film.php?IdFilm=29"><img class="cadre" src="photos/affiche_29_tn.jpg" alt="Pas de probl&egrave;mes" height="80"/></a></td>
            <td><p><span class="mylink"><a href="film.php?IdFilm=29">Pas de probl&egrave;mes </a></span> de Giancarlo Bocchi<br>
  (t&eacute;l&eacute;charger ici le dossier au format Adobe pdf 561 ko <a href="docs/presse nema problema.pdf"><img src="images/pdf.gif" width="16" height="16" border="0"></a> )</p>
              <p>Mercredi 5 juillet à 10h<br>
  Mercredi 5 juillet à 15h30</p></td>
          </tr>
        </table>
	    <p>au</p>
<blockquote style="padding: 0px; margin:5px 150px 5px 40px; border:1px solid #aaaaaa; background-color:#eeeeee">
		<p><strong>Club-Marbeuf</strong><br>
			38, rue Marbeuf<br>
       	75008 Paris</p>
          <p>M&eacute;tro<br>
          Franklin D.Roosevelt ou George V</p>
        <p>Parkings<br>
          Pierre Charron, François 1er,
          Rond-point des Champs Elys&eacute;es</p>
          </blockquote>
			<p>Une avant premi&egrave;re de ces films aura lieu le 18 juillet 2006 au </p>
            <blockquote style="padding: 0px; margin:5px 150px 5px 40px; border:1px solid #aaaaaa; background-color:#eeeeee">
		<p><strong>Cin&eacute;ma Latina</strong><br>
			20, rue du Temple<br>
			75004 Parris</p>
          <p><strong>En pr&eacute;sence des &nbsp;r&eacute;alisateurs</strong></p>
            </blockquote>
			<p><strong>Merci de confirmer votre présence</strong> au 04 50 33 44 26 ou à <a href="mailto:acadra@annecycinemaitalien.com">acadra@annecycinemaitalien.com</a></p>
			<p><strong>Pour toute demande de rendez-vous et d'interview,</strong> merci d'appeler Sonia au 04 50 33 44 26</p>
			<p class="auteur">Par Sonia Todeschini, le 16 juin 2006</p>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>
	</div>
<?php
	include ("footer.inc.php");
?>