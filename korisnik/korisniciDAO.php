<?php
	
	require "../path.php";
	require "$TRAZI_FILE$DB_BROKER";
	
	
	
	function vratiKorisnik($username)
	{
		$tabela = "korisnici";
		$kolone = "id_user, username, password, level, ban, ban_date";
		$uslov = "username LIKE '$username'";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			//echo "<p>Nastala je greska pri citanju iz baze</p>";
			return false;
		}
		else
		{
			return $q;
		}
	}
	function vratiKorisnikId($user_id)
	{
		$tabela = "korisnici";
		$kolone = "id_user, username, password, level,reg_date, email, ban_date, ban";
		$uslov = "id_user = $user_id";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			//echo "<p>Nastala je greska pri citanju iz baze</p>";
			return false;
		}
		else
		{
			return $q;
		}
	}
	function vratiUsername($id)
	{
		$tabela = "korisnici";
		$kolone = "username";
		$uslov = "id_user = $id";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			//echo "<p>Nastala je greska pri citanju iz baze</p>";
			return "nije nadjen!";
		}
		else
		{
			$qq=$q->fetch_object();
			$ime= $qq->username;
			return $ime;
		}
	}
	function listajKorisnike()
	{
		$tabela = "korisnici";
		$kolone = "*";
		$uslov = "";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			//echo "<p>Nastala je greska pri citanju iz baze</p>";
			return false;
		}
		else
		{
			return $q;
		}
	}
	function proveriSifru($id_user,$password)
	{
		$tabela = "korisnici";
		$kolone = "id_user, password";
		//$uslov = "password LIKE '$password'";
		$uslov = "id_user = '$id_user'";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			//echo "<p>Nastala je greska pri citanju iz baze</p>";
			return false;
		}
		else
		{
			$qq=$q->fetch_object();
			$db_password = $qq->password;
			//echo $db_password."<br/>";
			
			
			//if($db_password == $password)
			if(!validate_password($password, $db_password))
			{
				//echo "sve je ok";
				return false;
			}
			else return true;
		}
	}
	function menjajSifru($id_user,$newPassword)
	{
		//return true;
		
		$tabela = "korisnici";
		$vrednost = "password='".$newPassword."'";
		$uslov= "id_user=".$id_user;
				
		if(!$q=editovanje($tabela, $vrednost, $uslov))
		{
			//echo "<p>Nastala je greška pri izmeni Komentara</p>";
			return false;
		}
		else
		{
			echo $q;
			return true;
		}
		
	}
	/*
			rad sa datumima
			
			//zeljeni format za prikaz
			$vreme1 = date("d.m.Y H:i ", $datetime);
			//format za upis u bazu
			$vreme2 = date('Y-m-d H:i:s', $datetime);
			
			//tacno vreme
			$tacnoVreme = time() + (2 * 60 * 60);
			//next week
			$nextWeek = time() + (2 * 60 * 60) + (7 * 24 * 60 * 60);
			//next month
			$nextMonth = time() + (2 * 60 * 60) + ( 30 * 24 * 60 * 60);
			//tacno vreme u pravom formatu
			$vreme3 = date('Y-m-d H:i:s', $tacnoVreme);
			
			$sada =  time() + (2 * 60 * 60);
			$zaDvaSata =  time();
			$prvi = date('Y-m-d H:i:s', $sada);
			$drugi = date('Y-m-d H:i:s', $zaDvaSata);
			
			if($prvi>$drugi)
			{
				$vreme = "prvi veci od drugog";
			}
			else if($prvi<$drugi)
			{
				$vreme = "prvi manji od drugog";
			}
			else $vreme = "jednaki su!";
			
	*/
	function banujKorisnika($id_user, $ban)
	{
		$tabela = "korisnici";
		$vrednost = "ban='".$ban."'";
		$uslov= "id_user=".$id_user;
		
		
		if($ban)
		{
			//setovanje datuma do kada traje ban
			$nextWeek = time() + (2 * 60 * 60) + (7 * 24 * 60 * 60);
			//$in3min = time() + (2 * 60 * 60) + (60);
			$ban_date = date('Y-m-d H:i:s', $nextWeek);
			$vrednost = $vrednost.", ban_date='".$ban_date."'";
		}
		
		if(!$q=editovanje($tabela, $vrednost, $uslov))
		{
			//echo "<p>Nastala je greška pri izmeni Komentara</p>";
			return false;
		}
		else
		{
			//echo $q;
			return true;
		}
		
	}
	
	function checkUsername($username)
	{
		$tabela = "korisnici";
		$kolone = "*";
		$uslov = "username LIKE '$username'";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function checkEmail($email)
	{
		$tabela = "korisnici";
		$kolone = "*";
		$uslov = "email LIKE '$email'";
		$redosled = "";
		
		$q = vratiRedove($tabela, $kolone, $uslov, $redosled);
		if(!$q)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function registruj($username, $email, $password)
	{
		$tabela= "korisnici";
		$kolone= "username, email, password, level, ban";
		$vrednosti= "'$username', '$email', '$password', '1', 'false'";
		//"'$Autor', '$Sadrzaj', '$id_Clanak'";
		
		if(upis($tabela, $kolone, $vrednosti))
		{
			echo "<p>Uspesan unos</p>";
			return true;
		}
		else 
		{
			echo "<p>Nastala je greška pri ubacivanju u bazu</p>";
			return false;
		}
	}
	/*
	
	function brisanje($id)
	{
		$tabela="komentari";
		$uslov="id_comment = ".$id;
		
		if(brisi($tabela, $uslov))
		{
			echo "<p>Brisanje zapisa je uspešno!</p>";
		}
		else
		{
			echo "<p>Nastala je greska pri brisanju iz baze</p>";	
		}
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
	
	function prikaz($id_Clanak)
	{
		$tabela = "komentari";
		$kolone = "Autor, Sadrzaj, Vreme, id_comment";
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
	*/
	
	/*
	function izmena($id)
	{
		if (isset ($_POST['Autor']) && isset ($_POST['Sadrzaj']))
			{
				$Autor = $_POST['Autor'];
				$Sadrzaj = $_POST['Sadrzaj'];
				
				$tabela = "komentari";
				$vrednost = "Autor='".$Autor."',Sadrzaj='".$Sadrzaj."'";
				$uslov= "id_comment=".$id;
				
				if(!$q=editovanje($tabela, $vrednost, $uslov))
				{
					echo "<p>Nastala je greška pri izmeni Komentara</p>";
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
	}*/
?>