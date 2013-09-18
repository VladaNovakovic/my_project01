<?php
	
	require "../path.php";
	require "$TRAZI_FILE$DB_BROKER";
	
	
	
	function vratiKorisnik($username)
	{
		$username = obradiString($username); 
		
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
		$username = obradiString($username); 
		
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
		$email = obradiString($username);
		
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
		$username = obradiString($username); 
		$email = obradiString($username);
		
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
	
	*/
?>