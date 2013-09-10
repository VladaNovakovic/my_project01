<?php
	require "../path.php";
	
	require "$TRAZI_FILE$MASTER";
	

	echo top("Articles");
	
	
	$dozvola=false;
	if(isset($_SESSION['level']) && $_SESSION['level']>=5)
	{
		$dozvola=true;
	}
	
	
	echo page_top();
	echo ispis_clanci();
	echo bottom();
	
	
		
	
	
	
	function page_top()
	{
		//$dozvola=true;
		$clanci=<<<CLANAK
		
		<style>
			div.inline_left { float:left; }
			div.inline_right { float:right; }
			.clearBoth { clear:both; }
			.vest
			{
				background-color: SlateGray ;
				width: 500px;
				margin-left: auto;
				margin-right: auto;
				margin-top: 10px;
				margin-bottom: 10px;
				border: 2px solid yellow;
				
			}
			
			.zaglavlje
			{
				padding-left: 20px;
				border-bottom: 1px solid yellow;
				color: yellow;
			}
			.controlDugme
			{
				padding-left: 5px;
				padding-right: 5px;
				background-color: yellow;
				border: 1px solid black;
				margin: 2px 5px 2px 5px ;
				max-width: 100px;
			}
			.controlDugme a
			{
				color: blue;
				text-decoration: none;
				
			}
			.control
			{
				border-top: 1px solid yellow;
				background-color: rgba(200,200,200,0.3);
			}
			.opis
			{
				color: yellow;
				margin-left: 10px;
				text-decoration: none;
			}
			.divLink
			{
				text-decoration: none;
			}
			.vreme
			{
				padding-left: 10px;
				padding-right: 10px;
			}
			
		</style>
CLANAK;
		
		global $dozvola;
		//echo $dozvola;
		
		//global $CLANAK_OBRADA_LINK;
		global $CLANAK_OBRADA;
		global $TRAZI_LINK;
		$kontrola="";

		//if(isset($_SESSION['level']) && $_SESSION['level']>=5)
		if($dozvola)
		{
		$kontrola=<<<KONTROLA
		
				<center><div id="unosKomentara" class="controlDugme">
					<a href="$TRAZI_LINK$CLANAK_OBRADA?akcija=novi_clanak"><div>Novi clanak</div></a></div></center>
KONTROLA;
		}

		return $clanci.$kontrola;
	
	}

	function ispis_clanci()
	{
		
		$clanci="";
		$kontrola="";
		
		//include "clanakDAO.php";
		//global $CLANAK_FUNKCIJE;
		//require "../path.php";
		//echo $CLANAK_FUNKCIJE;
		
		//global $CLANAK_FUNKCIJE_FILE;
		global $TRAZI_FILE;
		global $TRAZI_LINK;
		global $KORISNIK_PROFIL;
		global $CLANAK_FUNKCIJE;
		require "$TRAZI_FILE$CLANAK_FUNKCIJE";
		//require "clanakDAO.php";
		
		$q=listajClanke();
		if(!$q) 
		{
			return "Nema clanaka!";
		}
		while ($red=$q->fetch_object())
		{
			
			$naslov=$red->naslov;
			$vreme=$red->vreme;
			$opis=$red->opis;
			$autor=$red->autor;
			$autor_id=$red->autor_id;
			$id=$red->id_clanak;
			
			$privremeni=<<<CLANAK
			
			<div class="vest">
			<a class="divLink" href="$TRAZI_LINK$CLANAK_PRIKAZ?clanak=$id">
				<div class="zaglavlje">
					<div class="inline_left"><p class="naslov">$naslov</p></div>
					<div class="inline_right"><p class="vreme">$vreme</p></div>
					<br class="clearBoth"/>
				</div>
				<div class="opis">
					<p>$opis</p>
				</div>
			</a>
				<div class="inline_right" ><a class="link" href="$TRAZI_LINK$KORISNIK_PROFIL?id=$autor_id">$autor</a></div>
				<br class="clearBoth"/>
CLANAK;
			
			global $dozvola;
			if($dozvola)
			{
				$kontrola=<<<KONTROLA
				<div class="control">
						<div class="inline_right"><a class="link" href="$TRAZI_LINK$CLANAK_OBRADA?akcija=brisanje&id_clanak=$id">Brisi</a></div>
						<div class="inline_right"><a class="link" href="$TRAZI_LINK$CLANAK_OBRADA?akcija=izmena_forma&id_clanak=$id">Izmeni</a></div>
						<br class="clearBoth"/>
						
					</div>
KONTROLA;
			$privremeni=$privremeni.$kontrola;
			}
			$clanci=$clanci.$privremeni."</div>";
		}
		return $clanci;
	}
	
	
	
	
?>