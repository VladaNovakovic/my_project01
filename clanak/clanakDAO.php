<?php
	require "../path.php";
	require "$TRAZI_FILE$DB_BROKER";
	
	function clanakUnos()
	{
		if (isset($_POST['sacuvaj']) && !empty($_POST['naslov']) && !empty($_POST['opis']) && !empty($_POST['text']) && isset($_POST['autor']) && isset($_POST['autor_id']))
		{
			//sql injection
			$naslov = obradiString($_POST['naslov']);
			$opis = obradiString($_POST['opis']);
			$text = obradiString($_POST['text']);
			$autor = obradiString($_POST['autor']);
			$autor_id = obradiString($_POST['autor_id']);
			
			
			
			$tabela= "clanci";
			$kolone= "naslov, opis, text, autor, autor_id";
			$vrednosti= "'$naslov', '$opis', '$text', '$autor', '$autor_id'";
			
			if(upis($tabela, $kolone, $vrednosti))
			{
				//echo "<p>Uspesan unos</p>";
				return true;
			}
			else 
			{
				//echo "<p>Nastala je greška pri ubacivanju u bazu</p>";
				//return false;
				return "greska"; //ovde bi moglo da bude izuzetak
			}
			
		}
		else 
		{
			//echo "nisu prosledjeni parametri";
			//echo "<script>alert('nisu prosledjeni parametri');</script>";
			return false;
		}
	}
	
	function clanakBrisanje($id)
	{
		$tabela="clanci";
		$uslov="id_clanak = ".$id;
		
		if(brisi($tabela, $uslov))
		{
			echo "<p>Brisanje clanka je uspešno!</p>";
			global $KOMENTARI_FUNKCIJE;
			global $TRAZI_FILE;
			require_once "$TRAZI_FILE$KOMENTARI_FUNKCIJE";
			echo brisKomentareClanka($id);
		}
		else
		{
			echo "<p>Nastala je greska pri brisanju iz baze</p>";	
		}
	}
	
	function listajClanke()
	{
		$tabela = "clanci";
		$kolone = "id_clanak, naslov, opis, autor, autor_id, vreme";
		$uslov = "";
		$redosled = "id_clanak DESC";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			echo "<p>Nastala je greska pri citanju iz baze</p>";
			return false;
		}
		else if($q)
		{
			return $q;
		}
		if($q==0)
		{
			echo "<p>nema trazenog sadrzaja</p>";
			return false;
		}
	}
	
	function vratiClanak($id)
	{
		$tabela = "clanci";
		$kolone = "id_clanak, naslov, opis, text, autor, autor_id, vreme";
		$uslov = "id_clanak= ".$id;
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			return false;
		}
		else
		{
			return $q;
		}
	}
	
	function vratiNaslov($id)
	{
		$tabela = "clanci";
		$kolone = "naslov";
		$uslov = "id_clanak= ".$id;
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			return "Nije nadjen clanak";
			
		}
		else
		{
			$rad=$q->fetch_object();
			return $rad->naslov;
			//return $q;
		}
	}
	
	function pisiClanak($id)
	{
		$q=vratiClanak($id);
		if($q)
		{
			$red=$q->fetch_object();
			
			$naslov=$red->naslov;
			$opis=$red->opis;
			$text=$red->text;
			$vreme=$red->vreme;
			$autor=$red->autor;
			$autor_id=$red->autor_id;
			
			global $TRAZI_LINK;
			global $KORISNIK_PROFIL;
			
			$clanak=<<<CLANAK
			<h1>$naslov</h1>
			<h5>$vreme</h5>
			$text
			<h5><a class="link" href="$TRAZI_LINK$KORISNIK_PROFIL?id=$autor_id">$autor</a></h5>
CLANAK;
			//ovde iznad za $text nije potreban p tag jer se text clanka unosi formatiran
			return $clanak;
		}
		else
		{
			return false;
		}
	}
	function clanakIzmena($id)
	{
		if (!empty($_POST['naslov']) && !empty($_POST['opis']) && !empty($_POST['text'])/* && isset($_POST['autor']) && isset($_POST['autor_id']) ovaj deo dodati kad budem dodavao edited by...*/)
		{
			//sql injection
			$naslov = obradiString($_POST['naslov']);
			$opis = obradiString($_POST['opis']);
			$text = obradiString($_POST['text']);
			
			
			
			$tabela = "clanci";
			$vrednosti = "naslov='".$naslov."', opis='".$opis."', text='".$text."'";
			$uslov = "id_clanak='".$id."'";
			
			if(!$q=editovanje($tabela, $vrednosti, $uslov))
				{
					echo "<p>Nastala je greška pri izmeni clanka</p>";
					return false;
				}
				else
				{
					echo $q;
					return true;
				}
		} else 
			{
				echo "<p>Nisu prosleđeni parametri za izmenu";
				return false;
			}
	}

?>