<?php
	//require_once "broker.php";
	require "../path.php";
	require_once "$TRAZI_FILE$DB_BROKER";
	
	function unosKomentara($id_Clanak)
	{
		$unos="";
		if (isset($_POST['autor']) && isset($_POST['id_autor']) && !empty($_POST['sadrzaj']))
		{	
			global $mysqli;
			
			$autor = $_POST['autor'];
			$id_autor = $_POST['id_autor'];
			$sadrzaj = $_POST['sadrzaj'];
			
			//sql injection zastita
			$sadrzaj = $mysqli->real_escape_string($sadrzaj);
		
			$tabela= "komentari";
			$kolone= "autor_id, Autor, Sadrzaj, Clanak_id";
			$vrednosti= "'$id_autor', '$autor', '$sadrzaj', '$id_Clanak'";
			
			if(upis($tabela, $kolone, $vrednosti))
			{
				$unos="<p>Uspesan unos</p>";
			}
			else 
			{
				$unos= "<p>Nastala je greška pri ubacivanju u bazu</p>";
			}
		} 
		else 
			{
				$unos= "Nisu prosleđeni parametri!";
			}
		return $unos;
	}
	
	function brisanjeKomentara($id)
	{
		$brisi = "";
		
		$tabela="komentari";
		$uslov="id_comment = ".$id;
		
		if(brisi($tabela, $uslov))
		{
			$brisi = "<p>Brisanje zapisa je uspešno!</p>";
			//return true;
		}
		else
		{
			$brisi = "<p>Nastala je greska pri brisanju iz baze</p>";	
			//return false;
		}
		return $brisi;
	}
	
	function brisKomentareClanka($clanak)
	{
		
		$tabela="komentari";
		$uslov="clanak_id = ".$clanak;
		if(brisi($tabela, $uslov))
		{
			echo "<p>Brisanje zapisa je uspešno!</p>";
		}
		else
		{
			echo "<p>Nastala je greska pri brisanju iz baze</p>";	
		}
	}
	function prikazKomentara($id_Clanak)
	{
		$tabela = "komentari";
		$kolone = "autor_id, Autor, Sadrzaj, Vreme, id_comment";
		$uslov = "Clanak_id=$id_Clanak";
		$redosled = "id_comment DESC";
		
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
	
	function vratiKomentar($id)
	{
		$tabela = "komentari";
		$kolone = "autor_id, Autor, Sadrzaj, id_comment";
		$uslov = "id_comment=$id";
		$redosled = "";
		
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
			echo "<p>nema trazenog komentara</p>";
			return false;
		}
	}
	function izmenaKomentara($id)
	{
		$izmena = "";
		if (isset ($_POST['sadrzaj']))
			{
				
				$Sadrzaj = $_POST['sadrzaj'];
				
				//sql injection zastita
				$Sadrzaj = $mysqli->real_escape_string($sadrzaj);
				
				$tabela = "komentari";
				$vrednost = "Sadrzaj='".$Sadrzaj."'";
				$uslov= "id_comment=".$id;
				
				if(!$q=editovanje($tabela, $vrednost, $uslov))
				{
					$izmena =  "<p>Nastala je greška pri izmeni Komentara</p>";
					//return false;
				}
				else
				{
					$izmena = "<p>Uspesno izmenjeno!</p>";
					//echo $q;
					//return true;
				}
			} else 
			{
				$izmena = "<p>Nisu prosleđeni parametri za izmenu</p>";
				//return false;
			}
		return $izmena;
	}
?>