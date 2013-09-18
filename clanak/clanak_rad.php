<?php
	require "../path.php";
	
	require "$TRAZI_FILE$CLANAK_FUNKCIJE";
	require "$TRAZI_FILE$MASTER";
	
	
	echo top(vratiNaslovClanakRad());
	
	//globalne promenljive, potrbne za funkciju za popunjavanje forme
	$autor=$_SESSION['username'];
	$autor_id=$_SESSION['user_id'];
	$naslov="";
	$opis="";
	$text="";
	$zaIzmenu="";
	
	//provera prava pristupa, ne moze se uraditi nista ako je level ispod 5 (mod)
	if(!isset($_SESSION['level']) || ($_SESSION['level']<5))
	{
		//header("refresh: 2; url=$TRAZI_LINK$KORISNIK_LOGIN");
		echo "<h1>nemate dozvolu za pristup ovoj stranici!<h1>";
		preusmerenje();
	}
	else 
	{
		if (isset($_GET['akcija']) && isset($_SESSION['username']) && isset($_SESSION['user_id']))
		{	
			echo noviClanak();
		}
		else echo "sada ste dosli ovde, nesto nije setovano!";
	
	}
	echo bottom();

	
	
	
function noviClanak()
	{
	
		$clanak = "";
		

		if (isset ($_GET['akcija']))
		{
			$akcija = $_GET['akcija'];
			
			
			switch ($akcija)
			{
			
				case "izmena_forma":	// prikazivanje forme za izmenu ili unos... valja promeniti malo ovaj sistem
							
					if(!isset($_GET['id_clanak']))	//ovde se proverava da li je setovan id clanka koji hocemo da menjamo
					{
						preusmerenje("clanci");
						$clanak = $clanak . "nije setovan clanak";
						break;
					}
					else 
					{
						$kontrola = akcijaKontrola();
						
						switch ($kontrola)
						{
							case "sacuvaj":		//unose se izmenjene vrednosti iz forme u bazu
							{
								$idClanak=$_GET['id_clanak'];
								if(clanakIzmena($idClanak))
								{
									$clanak = $clanak . "izmenjeno";
									preusmerenje("izmena");
								}
								else $clanak = $clanak . "nepromenjeno";
								break;
							}
							case "prikaz":		//uzimaju se vrednosti za prikazivanje
							{
								global $naslov;
								global $opis;
								global $text;
								global $autor;
								global $autor_id;
								
								$naslov = $_POST['naslov'];
								$opis = $_POST['opis'];
								$text = $_POST['text'];
								$autor = $_POST['autor'];
								$autor_id = $_POST['autor_id'];
								$clanak = $clanak . formaUnosIzmena();	//stampa se forma
								break;
								
							}
							default :	//ovde se uzima clanak iz baze za editovanje, i postavljaju vrednosti za polja forme
							{
								$id=($_GET['id_clanak']);
								$zaIzmenu='<input type="hidden" name="id_clanak" value="$_GET["id_clanak"]">';
								
								$clanak = $clanak . "<h1>hocete da izmenite clanak $id</h1>";
								$q=vratiClanak($id);
								if($q)
								{
									global $naslov;
									global $opis;
									global $text;
									global $autor;
									global $autor_id;
									
									$qq=$q->fetch_object();
									$naslov=$qq->naslov;
									$opis=$qq->opis;
									$text=$qq->text;
									$autor=$qq->autor;
									$autor_id=$qq->autor_id;
									
								}
								else
								{
									$clanak = $clanak . "<p>Nastala je greska pri citanju clanka iz baze</p>";
								}
								$clanak = $clanak . formaUnosIzmena();	//stampa se forma
								break;
							}
						}
					}
					break;
					
				case "novi_clanak":
					
					$kontrola=akcijaKontrola();
					switch($kontrola)
					{
						case "sacuvaj":		//ako je doslo ovde pritiskom na dugme sacuvaj
							$q = clanakUnos();
							if($q)
							{
								preusmerenje("unos");
								break;
							}
							else if ($q=="greska")
							{
								$clanak = $clanak . "Greska pri upisu u bazu!";
								break;
							}
							else if(!$q)
							{	
								$clanak = $clanak . "nisu setovani svi parametri";
								//ispise poruku da nisu setovani svi parametri i popuni ponovo promenljive za formu
								//ne treba break jer treba ponovo popuniti formu
							}
							
						case "prikaz":		//ako je doslo ovde pritiskom na dugme prikaz, ili propadanjem iz ovog iznad
							global $naslov;
							global $opis;
							global $text;
							global $autor;
							global $autor_id;
								
							$naslov = $_POST['naslov'];
							$opis = $_POST['opis'];
							$text = $_POST['text'];
							$autor = $_POST['autor'];
							$autor_id = $_POST['autor_id'];
							//break;	//ne treba mi ovaj brejk jer mi je sledeca linija koda svakako ovo ispod
													
						default :
							$clanak = $clanak . formaUnosIzmena();
							break;
					
					}
					break;
					
				case "unos":
					$clanak = $clanak . "<h1>uspesno uneto!<h1>";
					preusmerenje("clanci");
					break;
					
				case "izmena":
					$clanak = $clanak . "<h1>uspesno izmenjeno!<h1>";
					preusmerenje("clanci");
					break;
				
				case "brisanje":
					
						if (isset ($_GET['id_clanak']))
						{ 
							$id=$_GET['id_clanak'];
							$clanak = $clanak . "<h1>dosli ste da obrisete clanak id=$id</h1>";
							$clanak = $clanak . clanakBrisanje($id);
						}
						else
						{
							$clanak = $clanak . "<h1>nije setovan clanak id</h1>";
						}
					preusmerenje("clanci");
					break;	
					
				default:
					$clanak = $clanak . "<h1>Nepostojeća akcija!</h1>";
					preusmerenje("clanci");
					break;
			}
					
		}
		else
		{
			$clanak = $clanak . "<h1>niste uneli zeljene parametre</h1>";
			preusmerenje("clanci");
		}
		
		return $clanak;
	}
	
function akcijaKontrola()
{
	$kontrola = "";
	if(isset($_POST['sacuvaj']))
	{ 
		$kontrola = "sacuvaj"; 
	}
	else if(isset($_POST['prikaz']))
	{ 
		$kontrola = "prikaz"; 
	}
	
	return $kontrola;
}

function preusmerenje($gde="")
{	
	global $TRAZI_LINK;
	global $CLANAK_OBRADA;
	global $CLANCI_PRIKAZ;
	global $KORISNIK_LOGIN;
	global $INDEX;
	
	switch($gde)
	{
		case "unos":
			header("location: $TRAZI_LINK$CLANAK_OBRADA?akcija=unos");
			break;
		case "izmena":
			header("location: $TRAZI_LINK$CLANAK_OBRADA?akcija=izmena&id_clanak=$idClanak");
			break;
		case "clanci":
			header("refresh:3; url=$TRAZI_LINK$CLANCI_PRIKAZ");
			break;
		case "login":
			header("refresh: 2; url=$TRAZI_LINK$KORISNIK_LOGIN");
			break;
		default:
			header("refresh:3; url=$TRAZI_LINK$INDEX");
			break;
		}
}

function vratiNaslovClanakRad()
{
	$naslov = "";
	$akcija = "";
	
	if(isset($_GET['akcija']))
		$akcija = $_GET['akcija'];
	
	switch($akcija)
	{
		case "unos":
			$naslov = "Unosenje...";
			break;
		case "izmena":
			$naslov = "Menjanje...";
			break;
		case "novi_clanak":
			$naslov = "Novi clanak";
			break;
		case "izmena_forma":
			$naslov = "Izmena clanka";
			if(isset($_GET['id_clanak']))
			{
				
				$id = $_GET['id_clanak'];
				$naslov = $naslov." - ".vratiNaslov($id);
			}
			else
			{
				$naslov = $naslov." - nije setovan id!";
			}
			break;
		case "brisanje":
			$naslov = "Brisanje...";
			break;
		default:
			$naslov = "Nije poznata akcija...";
			break;
	}
	return $naslov;
}

function formaUnosIzmena()
{
	global $naslov;
	global $opis;
	global $text;
	global $autor;
	global $autor_id;
	
	global $zaIzmenu;
					
	global $TRAZI_LINK;
	global $KORISNIK_PROFIL;
			
	//echo '
	$forma = '
		<div class="forma"><form method="post" action="">
			<table>
				<tr>
					<td>Naslov : </td>
					<td><input type="text" name="naslov" size="35" value="'.$naslov.'"/></td>
				</tr>
				<tr>
					<td>Opis : </td>
					<td><textarea name="opis" rows="4" cols="40">'.$opis.'</textarea></td>
				</tr>
				<tr>
					<td>Text : </td>
					<td><textarea name="text" rows="8" cols="40">'.$text.'</textarea></td>
				</tr>
				<tr>
					<td>Autor : </td>
					<td><a class="link" href="'.$TRAZI_LINK.$KORISNIK_PROFIL.'?id='.$autor_id.'">'.$autor.'</a></td>
				</tr>
				<tr>
					<td>
					<input type="hidden" name="autor" value="'.$autor.'" >
					<input type="hidden" name="autor_id" value="'.$autor_id.'" >
					</td>
					<td><input type="submit" name="sacuvaj" value="Sacuvaj" /><input type="submit" name="prikaz" value="Prikazi" /></td>
				</tr>
			</table>'.$zaIzmenu.'</form></div>';
				
	if(isset($_POST['prikaz']))
	{
		//echo "<h1>$naslov</h1>$text";
		$forma = $forma . "<h1>$naslov</h1>$text";
	}
			
	return $forma;
}
	
?>