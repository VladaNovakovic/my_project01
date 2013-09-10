<?php
	require "../path.php";
	
	require "$TRAZI_FILE$MASTER";
	
	$akcija="";
	$autor="";
	$autor_id="";
	$naslov="";
	$opis="";
	$text="";

	echo top("Unos");
	
	//provera prava pristupa, ne moze se uraditi nista ako je level ispod 5 (mod)
	$dozvola=false;
	if(!isset($_SESSION['level']) || ($_SESSION['level']<5))
	{
		echo "<h1>nemate dozvolu za pristup ovoj stranici!<h1>";
		header("refresh: 2; url=$TRAZI_LINK$KORISNIK_LOGIN");
	}
	else 
	{
		$dozvola=true;
		
		if (isset($_GET['akcija']) && isset($_SESSION['username']) && isset($_SESSION['user_id']))
		{	
			$akcija = $_GET['akcija'];
			$autor=$_SESSION['username'];
			$autor_id=$_SESSION['user_id'];
			noviClanak();
			$naslov="";
			$opis="";
			$text="";
			//echo "dosli ste ovde!";
		}
		else echo "sada ste dosli ovde, nesto nije setovano!";
	
	}
	echo bottom();


	
	
function noviClanak()
	{
		global $TRAZI_FILE;
		global $CLANAK_FUNKCIJE;
		
		require "$TRAZI_FILE$CLANAK_FUNKCIJE";

		
		if (isset ($_GET['akcija']))
		{
			//echo $akcija."<br/>";
			//$akcija = $_GET['akcija'];
			//echo $akcija."<br/>";
			//$autor="anonymous";
			//$autor_id="";
			global $akcija;
			global $naslov;
			global $opis;
			global $text;
			global $autor;
			global $autor_id;
			
			$zaIzmenu="";
			switch ($akcija)
			{
			
				// prikazivanje forme za izmenu ili unos... valja promeniti malo ovaj sistem
				case "izmena_forma":
				
					//ovde se dohvataju vrednosti za prikazu u formi clanka koji hocemo da menjamo
					if(!isset($_GET['id_clanak']))
					{
						preusmerenje("clanci");
						echo "nije setovan clanak";
						break;
					}
					//ovde se uzima clanak iz baze za editovanje, i postavljaju vrednosti za polja forme
					else if (!isset($_POST['prikaz']))	
					{
						$id=($_GET['id_clanak']);
						$zaIzmenu='<input type="hidden" name="id_clanak" value="$_GET["id_clanak"]">';
						
						echo "<h1>hocete da izmenite clanak $id</h1>";
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
					}
					//uzimaju se vrednosti za prikazivanje
					else if(isset($_POST['prikaz'])) 
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
						
					}
					
					//stampa se forma
					formaUnosIzmena(); 
					
					//unose se izmenjene vrednosti iz forme u bazu
					if(isset($_POST['sacuvaj'])) 
					{
						$idClanak=$_GET['id_clanak'];
						if(clanakIzmena($idClanak))
						{
							echo "izmenjeno";
							preusmerenje("izmena");
						}
						else echo "nepromenjeno";
					}
					break;
					
				case "novi_clanak":
					echo "dosli ste da unesete novi clanak";
					if(isset($_POST['sacuvaj']))
					{
						echo "</br>sacuvaj</br>";
						if(!empty($_POST['naslov']) && !empty($_POST['opis']) && !empty($_POST['text']) && isset($_POST['autor']) && isset($_POST['autor_id']))
						{
							echo "setovani parametri sve ok";
							if(clanakUnos())
							{
								echo "<p>Uspesan unos</p>";
							}
							else echo "<p>Nastala je greška pri ubacivanju u bazu</p>";
							preusmerenje("clanci");
						}
						else 
						{
							echo "nisu setovani svi parametri";
							$naslov = $_POST['naslov'];
							$opis = $_POST['opis'];
							$text = $_POST['text'];
							$autor = $_POST['autor'];
							$autor_id = $_POST['autor_id'];
						}
					}
					else if(isset($_POST['prikaz']))
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
					}
					formaUnosIzmena();
					break;
					
				/* sad ne znam sta sam uradio i da li mi i dalje treba ovaj deo... :?
				case "unos":
					if(clanakUnos())
					{
						echo "<h1>uspesno uneto</h1>";
					}
					else echo "<h1>nije uspesno uneto</h1>";
					preusmerenje("clanci");
					break;*/
					
				case "izmena":
					echo "<h1>uspesno izmenjeno!<h1>";
					preusmerenje("clanci");
					break;
				
				case "brisanje":
					if(isset($_SESSION['username']) && ($_SESSION['level']>=5))
					{
						if (isset ($_GET['id_clanak']))
						{ 
							$id=$_GET['id_clanak'];
							clanakBrisanje($id);
							echo "<h1>dosli ste da obrisete clanak id=$id</h1>";
						}
						else
						{
							echo "<h1>nije setovan clanak id</h1>";
						}
					}
					else echo "<h1>nemate dozvolu za pristup ovoj stranici!</h1>";
					
					preusmerenje("clanci");
					break;	
					
				default:
					echo "<h1>Nepostojeća akcija!</h1>";
					preusmerenje("clanci");
					break;
			}
					
		}
		else
		{
			echo "<h1>niste uneli zeljene parametre</h1>";
			preusmerenje("clanci");
		}
		}
function preusmerenje($gde)
{	
	global $CLANAK_OBRADA;
	global $CLANCI_PRIKAZ;
	global $TRAZI_LINK;
	
	switch($gde)
	{
		case "unos":
			//header("location: clanak_rad.php?akcija=unos");
			header("location: $TRAZI_LINK$CLANAK_OBRADA?akcija=unos");
			break;
		case "izmena":
			//header("location: clanak_rad.php?akcija=izmena&id_clanak=$idClanak");
			
			header("location: $TRAZI_LINK$CLANAK_OBRADA?akcija=izmena&id_clanak=$idClanak");
			//echo $TRAZI_LINK.$CLANAK_OBRADA;
			break;
		case "clanci":
			//header("refresh:3; url=clanci.php");
			header("refresh:3; url=$TRAZI_LINK$CLANCI_PRIKAZ");
			break;
		default:
			//header("refresh:3; url=clanci.php");
			header("refresh:3; url=$TRAZI_LINK$CLANCI_PRIKAZ");
			
		}
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
			
			echo '
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
					echo "<h1>$naslov</h1>$text";
				}
		}
	
?>