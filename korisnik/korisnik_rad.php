<?php
	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	require "$TRAZI_FILE$KORISNIK_FUNKCIJE";
	

	echo top(dohvatiNaslov());	
	echo sadrzajRad(); //ovde dodje prikaz sadrzaja
	echo bottom();

	
function dohvatiNaslov()
{
	$naslov = "";
	
	if (!isset($_GET['akcija']) || !isset($_GET['id']))
	{
		$naslov = "Nisu setovani parametri";
		
	}
	else
	{
		$akcija = $_GET['akcija'];
		switch($akcija)
		{
			case 'banuj':
				$naslov = "Banovanje korisnika";
				break;
			case 'skini_ban':
				$naslov = "Skidanje bana";
				break;
			default :
				$naslov = "Nepoznata akcija";
				break;
		}
	}
	return $naslov;
}
function sadrzajRad()
{
	$sadrzaj = "";
	
	if (!isset($_GET['akcija']) || !isset($_GET['id']))
	{
		$sadrzaj = "<h1>nisu setovani parametri</h1>";
	}
	else if(isset($_SESSION['level']) && $_SESSION['level']>=5)
	{
		$akcija = $_GET['akcija'];
		$id = $_GET['id'];
		
		switch ($akcija)
		{
			case 'banuj':
				if(banujKorisnika($id, true))
				{
					$sadrzaj = $sadrzaj . "<h2>korisnik banovan!</h2>";
				}
				else 
				{
					$sadrzaj = $sadrzaj . "<h1>nije uspesno odradjen zahtev</h1>";
				}
				break;
				
			case 'skini_ban':
				if(banujKorisnika($id, false))
				{
					$sadrzaj = $sadrzaj . "<h2>korisnik odbanovan!</h2>";
				}
				else 
				{
					$sadrzaj = $sadrzaj . "<h1>nije uspesno odradjen zahtev</h1>";
				}
				break;
			
			default:
				$sadrzaj = $sadrzaj . "<h1>nepoznat zahtev...</h1>";
				break;
		}
	}
	else $sadrzaj = $sadrzaj . "<h1>Nemate ovlascenje za pristup ovoj stranici</h1>";
	
	global $TRAZI_LINK;
	global $ADMIN_PAGE;
	
	header("refresh:3; url=".$TRAZI_LINK.$ADMIN_PAGE);
	return $sadrzaj;
}
?>