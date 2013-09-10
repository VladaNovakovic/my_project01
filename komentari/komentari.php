<?php

	require "../path.php";
	
	function pisiKomentare($id)
	{
		return omotac($id).komentari($id);
	}
	
	function omotac($id_clanak)
	{
		
		
		$komentari=<<<KOMENTAR
		
		<style>
			.komentari
			{
				background-color: rgba(255,255,0,0.5);
				font-family: vedrana, arial;
				margin-left: auto;
				margin-right: auto;
				border:2px solid black;
				width:650px;
			}
			.komentari h1
			{
				border-bottom:1px solid black;
				font-size:medium;
				margin:0px;
			}
			.komentar
			{
				background-color:green;
				font-family: vedrana, arial;
				width: 610px;
				border:2px solid black;
				margin-top: 10px;
				margin-bottom: 10px;
				margin-left: auto;
				margin-right: auto;
			}
			.zaglavlje
			{
				background: rgba(0, 255, 255, .3);
				border-bottom:1px solid black;
			}
			.komentar p
			{
				margin:10px;
			}
			.autor
			{
				
				text-weight: bold;
			}
			.datum
			{
				text-weight: bold;
				
			}
			.sadrzaj p
			{
				color: yellow;
			}
			.control
			{
				background-color: rgba(255,255,0,0.5);
				border-top:1px solid black;
				
			}
			.control a
			{
				
				margin-right:10px;
				
				padding-left: 5px;
				padding-right: 5px;
				
				
			}
			#unosKomentara
			{
				margin-left: auto;
				margin-right: auto;
			}
			.link
			{
				color: red;
				text-decoration:none;
			}
			.link:hover
			{
				text-decoration:underline;
			}
			div.inline_left { float:left; }
			div.inline_right { float:right; }
			.clearBoth { clear:both; }
		</style>
		
		<div id="komentari" class="komentari">
				<center><h1>Komentari</h1>
				
KOMENTAR;
				if(isset($_SESSION['level']))
				{
					$komentari=$komentari.komentariForma($id_clanak);
				}

		return $komentari;
	
	}
	
	function komentariForma($id_clanak)
	{
		global $TRAZI_LINK;
		global $KOMENTARI_OBRADA;
		
		$id_autor = $_SESSION['user_id'];
		$autor = $_SESSION['username'];
		
		$forma=<<<FORMA
		<!-- unos komentara -->
				
				<div id="unosKomentara">
					<form method="post" action="$TRAZI_LINK$KOMENTARI_OBRADA?akcija=unos&id_clanak=$id_clanak">
						<input type="hidden" name="id_autor" value=$id_autor>
						<input type="hidden" name="autor" value=$autor>
						<table>
							<tr><td>Komentar : </td></tr>
							<tr><td><textarea name="sadrzaj" rows="5" cols="40"></textarea></td></tr>
							<tr><td><center><input type="submit" name="unos" value="Ubaci" /></center></td></tr>
						</table>
					</form>
				</div></center>
FORMA;
		return $forma;
	}

	function komentari($id_clanak)
	{
		
		$komentari="";
		//include "komentariDAO.php";
		
		global $TRAZI_FILE;
		global $KOMENTARI_FUNKCIJE;
		global $TRAZI_LINK;
		global $KOMENTARI_OBRADA;
		require "$TRAZI_FILE$KOMENTARI_FUNKCIJE";
		
		//$dozvola=true;
		$kontrola="";
		
		
		$q=prikazKomentara($id_clanak);
		if(!$q) 
		{
			return "Nema komentara!";
		}
		while ($red=$q->fetch_object())
		{
			$id_autor=$red->autor_id;
			$autor=$red->Autor;
			//$vreme=$red->Vreme;
			$tekst=$red->Sadrzaj;
			$id=$red->id_comment;
			
			$datetime = strtotime($red->Vreme);
			
			//zeljeni format za prikaz
			$vreme = date("d.m.Y H:i ", $datetime);
			
			
			global $KORISNIK_PRIKAZ;
			$privremeni=<<<KOMENTARI
			
			<div class="komentar">
				<div class="zaglavlje">
					<div class="inline_left"><p><a class="link" href="$TRAZI_LINK$KORISNIK_PROFIL?id=$id_autor">$autor</a></p></div>
					<div class="inline_right"><p class="datum">$vreme</p></div>
					<br class="clearBoth"/>
				</div>
				<div class=sadrzaj>
					<p>$tekst</p>
				</div>
KOMENTARI;
			if(isset($_SESSION['level']) && $_SESSION['level']>=5)
			{
				$kontrola=<<<KONTROLA
				<div class="control">
						<div class="inline_right"><a class="link" href="$TRAZI_LINK$KOMENTARI_OBRADA?akcija=brisanje&id_comment=$id">Brisi</a></div>
						<div class="inline_right"><a class="link" href="$TRAZI_LINK$KOMENTARI_OBRADA?akcija=izmena_forma&id_comment=$id">Izmeni</a></div>
						<br class="clear both"/>
					</div>
KONTROLA;
			}
			$komentari=$komentari.$privremeni.$kontrola."</div>";
		}
		return $komentari."</div>";
	}
	
	
	
	
?>