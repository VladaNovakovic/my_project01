<?php

require "../path.php";
require "$TRAZI_FILE$MASTER";

echo top(vratiNaslov());
echo obradiKomentar();
echo bottom();


function obradiKomentar()
{
	$obrada = "";
	
	global $TRAZI_FILE;
	global $KOMENTARI_FUNKCIJE;
	require "$TRAZI_FILE$KOMENTARI_FUNKCIJE";
	
	if (isset ($_GET['akcija']))
	{
		$akcija = $_GET['akcija'];
		$idiNa="";
		
		if(isset($_POST['prethodna_stranica']))
		{
			$idiNa=$_POST['prethodna_stranica'];
			$_SESSION['prethodna_stranica']=$idiNa; 
		}
		else if(isset($_SERVER["HTTP_REFERER"]))
		{
			$idiNa=$_SERVER["HTTP_REFERER"];
		}
		else if(isset($_SESSION['prethodna_stranica']))
		{
			$idiNa=$_SESSION['prethodna_stranica'];
		}
		else 
		{
			global $INDEX;
			global $TRAZI_LINK;
			$idiNa="$TRAZI_LINK$INDEX";
		}
		
		switch ($akcija)
		{
			case "unos":
				if(isset($_GET['id_clanak']))
				{
					$id_clanak=$_GET['id_clanak'];
					$obrada = $obrada . "<h1>dosli ste da unesete komentar</h1>";
					$obrada = $obrada.unosKomentara($id_clanak);
				}
				else 
					$obrada = $obrada . "<h1>neki zajeb</h1>";
				break;
			case "izmena":
				if (isset ($_GET['id_comment']))
				{
					$id=$_GET['id_comment'];
					$obrada = $obrada . "<h1>dosli ste da izmenite komentar id=$id</h1>".izmenaKomentara($id);
				}
				else
				{
					$obrada = $obrada . "<h1>nije setovan komentar id</h1>";
				}
				break;	
				
			case "brisanje":
				if(isset($_SESSION['username']) && ($_SESSION['level']>=5))
				{
					if (isset ($_GET['id_comment']))
					{
						$id=$_GET['id_comment'];
						$obrada = $obrada . "<h1>dosli ste da obrisete komentar id=$id</h1>".brisanjeKomentara($id);
					}
					else
					{
						$obrada = $obrada . "<h1>nije setovan komentar id</h1>";
					}
				} else $obrada = $obrada . "nemate dozvolu za pristup ovoj stranici";
				break;	
			case "izmena_forma":
			
				global $KOMENTARI_OBRADA;
				global $TRAZI_LINK;
				global $KORISNIK_PROFIL;
				
				if (isset ($_GET['id_comment']))
				{
					$id=$_GET['id_comment'];
			
				$autor="";
				$sadrzaj="";
				$id_autor="";
				if ($q=vratiKomentar($id))
				{
					$qq=$q->fetch_object();
					$autor=$qq->Autor;
					$sadrzaj=$qq->Sadrzaj;
					$id_autor=$qq->autor_id;
				}
				
				$obrada = $obrada . '<h2>Izmena Komentara</h2>
				<div class="forma">
				<form method="post" action="'.$TRAZI_LINK.$KOMENTARI_OBRADA.'?akcija=izmena&id_comment='.$_GET['id_comment'].'">
					<input type="hidden" name="prethodna_stranica" value='.$idiNa.'>
					<table>
						<tr>
							<td>Sadrzaj : </td>
						</tr>
						<tr>
							<td><textarea name="sadrzaj" rows="5" cols="40">'.$sadrzaj.'</textarea></td>
						</tr>
						<tr>
							<td>Autor : <a class="link" href="'.$TRAZI_LINK.$KORISNIK_PROFIL.'?id='.$id_autor.'">'.$autor.'</a></td>
						</tr>
						<tr>
							<td><input type="submit" name="unos" value="Ubaci" /></td>
						</tr>
					</table>
				</form></div>';
				}
				else
				{
					$obrada = $obrada . "<h1>nije setovan komentar id</h1>";
				}
				break;
			default:
					$obrada = $obrada . "<p>Nepostojeća akcija!</p>";
					break;
		}

			
			
		if($_GET['akcija']!="izmena_forma")
		{
			header("refresh:3; url=".$idiNa);	
		}
		//return $komentari_rad; 	
	}
	return $obrada;
}
function vratiNaslov()
{
	$naslov="";

	if (isset ($_GET['akcija']))
	{
		$akcija = $_GET['akcija'];
		
		switch ($akcija)
		{
			case "unos":
				$naslov = "Unos komentara";
				break;
			case "izmena":
				$naslov = "Izmena komentara";
				break;	
				
			case "brisanje":
				$naslov = "Brisanje komentara";
				break;	
			case "izmena_forma":
				$naslov = "Izmenite komentar";
				break;
			default :
				$naslov = "Nepostojeća akcija!";
				break;
		} 		
	}
	else 
	{
		$naslov="Nije setovana akcija!";
	}
	
	return $naslov;
}
?>