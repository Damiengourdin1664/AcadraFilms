<?php
	include ("header.inc.php");
	$oFilms->oFilm = $oFilms->readFilm ($IdFilm);
	$aFilm = $oFilms->oFilm;
?>


<!--	Menu boutons de gauche --> 
<!--	
	<div id="left">
		<ul class="menu">
		<li><a href="#Photos">Photos</a></li>
		<li><a href="#Fiche technique">Fiche technique</a></li>
		<li><a href="#Critiques">Critiques</a></li>
		<li><a href="#Filmographie">Filmographie</a></li>
		<li><a href="#Biographie">Biographie</a></li>
		<li><a href="#Interviews">Interviews</a></li>
	    </ul>
		
		<img src="images/images3.jpg" width="78" height="121" />
	</div>
-->
	<div id="left">
		<div id="menu">
		<dl id="gallery">
			<dt>Le Film</dt>
			<dd><a href="#Photos" title="Photos">Photos</a></dd>
			<dd><a href="#Fiche technique" title="Fiche technique">Fiche technique</a></dd>
			<?php if (!is_null ($aFilm->Critiques) && strlen($aFilm->Critiques)>0 ) { ?>
			<dd><a href="#Critiques" title="Critiques">Critiques</a></dd>
			<?php } ?>
			<dd style="padding:8px ">La r&eacute;alisation</dd>
			<?php if (!is_null ($aFilm->Biographie) && strlen($aFilm->Biographie)>0 ) { ?>
			<dd><a href="#Biographie" title="Biographie">Biographie</a></dd>
			<?php } ?>
			<?php if (!is_null ($aFilm->Filmographie) && strlen($aFilm->Filmographie)>0 ) { ?>
			<dd><a href="#Filmographie" title="Filmographie">Filmographie</a></dd>
			<?php } ?>
			<?php if (!is_null ($aFilm->Interviews) && strlen($aFilm->Interviews)>0 ) { ?>
			<dd><a href="#Interviews" title="Interviews">Interviews</a></dd>
			<?php } ?>
		</dl>
		</div>
	</div>
<!--	
	<div id="left">
		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				<h1>Fiche technique</h1>
				<?php // printFicheTechnique($aFilm); ?>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>
	</div>
 -->
	<div id="center">
	
		<?php 
			// printNavigation ($aFilms, $IdFilm);
		?>
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
					<p align="center">un film de <span style="font-size: 1.1em; font-weight: bold"><?php echo $aFilm->Realisateur ?></span></p>
					</td>
					
                 </tr>
              </table>
			  </p>
					
			  <?php if (!is_null ($aFilm->Prix) && strlen($aFilm->Prix)>0 ) { ?>
              <p><img src="images/etoile_4.gif" width="52" height="13" /></p>
			  <p><strong><?php echo nl2br ($aFilm->Prix) ?></strong></p>
			  <?php } ?>
			  <p><?php echo $aFilm->Synopsis ?></p>
			  <p></p>
 			</div>
			
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>

		</div>

<!--	Division boîte ombrée --> 
<!--	
			
		<div class="out narrow">
		  <div class="in ltin tpin">
		  	<div class="affiche">
			<img src="images/affiche%2040X60.jpg" name="Affiche" width="132" height="189" border="1" id="Affiche" />
			</div>
			<p align="center" class="Style1">Titre_original</p>
			<p align="center">(Titre)</p>
		  	<p align="center">un film de <span class="Style2">Ralisateur</span></p>
		  </div>
		</div>
Division boîte ombrée --> 

<!--	Division boîte ombrée --> 
 
		<?php if (count ($photoFiles) > 0) { ?>
		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				<h1><a href="#top"><img src="images/reftop.gif" width="11" height="11" border="0" /></a>&nbsp;<a id="Photos">Photos</a></h1>
				<?php printPhotoTable ($aFilm, $photoFiles) ?>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>
		<?php } ?>

		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				<h1><a href="#top"><img src="images/reftop.gif" width="11" height="11" border="0" /></a>&nbsp;
					<a id="Fiche technique">Fiche technique</a></h1>
				<?php printFicheTechnique($aFilm); ?>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>

		<?php if (!is_null ($aFilm->Critiques) && strlen($aFilm->Critiques)>0 ) { ?>
		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				<h1><a href="#top"><img src="images/reftop.gif" width="11" height="11" border="0" /></a>&nbsp;
					<a id="Critiques">Critiques</a></h1>
				<p><?php echo nl2br ($aFilm->Critiques) ?></p>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>
		<?php } ?>

		<?php if (!is_null ($aFilm->Biographie) || !is_null ($aFilm->Filmographie) ) { ?>
		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				<h1><a href="#top"><img src="images/reftop.gif" width="11" height="11" border="0" /></a>&nbsp;
					La r&eacute;alisation, <?php echo $aFilm->Realisateur ?></h1>
				<!-- <p><img align="left" src="photos/real_29_Giancarlo%20Bocchi%20-%20film%20director.jpg" width="102" height="74" /></p> -->
				<?php printReal ($IdFilm) ?>
				<?php if (!is_null ($aFilm->Biographie) && strlen($aFilm->Biographie)>0 ) { ?>
					<p style="font-weight:bold; text-decoration:underline"><a id="Biographie">Biographie</a></p>
					<p><?php echo nl2br ($aFilm->Biographie) ?></p>
					<div style="clear:both"></div>
				<?php } ?>
				<?php if (!is_null ($aFilm->Filmographie) && strlen($aFilm->Filmographie)>0 ) { ?>
					<p style="font-weight:bold; text-decoration:underline"><a id="Filmographie">Filmographie</a></p>
					<table align="center" bgcolor="#ffffff" cellpadding="10" cellspacing="5" width="90%">
					<tr>
					<td align="right" width="80px"><img src="images/bande_02.gif" width="78" height="121"/></td>
					<td valign="top"><p style="background-color:#EFFECE; border:1px solid #FFD37D; font-size:1.1em" ><i><?php echo nl2br ($aFilm->Filmographie) // #E1FCAE?></i></p></td>
					</tr>
					</table>
					<p>&nbsp;</p>
				<?php } ?>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>
		<?php } ?>
		
		<?php if (!is_null ($aFilm->Interviews) && strlen($aFilm->Interviews)>0 ) { ?>
		<div id="xsnazzy">
			<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
			<div class="xboxcontent">
				<h1><a href="#top"><img src="images/reftop.gif" width="11" height="11" border="0" /></a>&nbsp;
					<a id="Interviews">Interviews</a></h1>
				<!-- <p><img align="left" src="photos/real_29_Giancarlo%20Bocchi%20-%20film%20director.jpg" width="102" height="74" /></p> -->
				<p><?php echo nl2br ($aFilm->Interviews) ?></p>
			</div>
			<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
		</div>
		<?php } ?>

<!-- <?php printNavigation ($aFilms, $IdFilm); 	?>  -->
	
	</div>
<?php
	include ("footer.inc.php");
?>
