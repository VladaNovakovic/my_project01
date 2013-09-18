<?php
	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	
	echo top("Registrating...");
	echo registracijaObrada();
	echo bottom();
	

function registracijaObrada()
{
	$registracija = "";

	global $TRAZI_FILE;
	global $KORISNIK_FUNKCIJE;
	global $HASH;
	
	require "$TRAZI_FILE$KORISNIK_FUNKCIJE";
	require "$TRAZI_FILE$HASH";
	
	
	if(isset($_GET['akcija']))
	{
		$akcija=$_GET['akcija'];
		switch($akcija)
		{
			case "registruj":
				if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirmPass']))
				{
					$username = $_POST['username'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					$confirmPass = $_POST['confirmPass'];
					
					//ovaj deo treba prebaciti da provereava na registration.php ajaxom
					//dodati proveru za duzinu username-a, minimum 6 ili nesto tako... maximum 16... 
					if(!checkUsername($username)) 
					{
						$registracija = $registracija . "postoji username<br/>";
					}
					else 
					{
						$registracija = $registracija . "dobar username<br/>";
								
						//ovaj deo treba prebaciti da provereava na registration.php ajaxom
						if(!checkEmail($email)) 
						{
							$registracija = $registracija . "postoji email<br/>";
						}
						else 
						{
							$registracija = $registracija . "dobar email<br/>";
							
							//ovaj deo treba prebaciti da provereava na registration.php ajaxom
							//minimum duzina, npr 8... maximum duzina 16
							//12 characters and require at least two letters, two digits, and two symbols
							if($password==$confirmPass) 
							{
								$registracija = $registracija . "sifre su iste<br/>";
								$passwordHash = create_hash($password);
								
								if(registruj($username, $email, $passwordHash))
								{
									$registracija = $registracija . "registrovan";
								}
								else $registracija = $registracija . "nije uspesno registrovan";
							}
							else $registracija = $registracija . "sifre se razlikuju<br/>";
						}
					}
					
				}
				else 
				{
					$registracija = $registracija . "<h1>nisu prosledjeni parametri</h1>";
				}
				//vracanje parametara da se popuni forma za registraciju
				if(isset($_POST['username']))
					$_SESSION['regUsername']=$_POST['username'];
				if(isset($_POST['email']))
					$_SESSION['regEmail'] = $_POST['email'];
				header("refresh:3; url=$TRAZI_LINK$KORISNIK_REGISTRACIJA");
				break;
			case "menjaj_sifru";
				{
					if(isset($_POST['menjaj']) && !empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword']) &&($_POST['newPassword']==$_POST['confirmPassword']) && isset($_SESSION['user_id']) && proveriSifru($_SESSION['user_id'],$_POST['oldPassword']))
					{
						$novaSifra = create_hash($_POST['newPassword']);
						if(menjajSifru($_SESSION['user_id'],$novaSifra))
						{
							$registracija = $registracija . "uspesno promenjena sifra";
						}
						else $registracija = $registracija . "greska pri promeni";
					}
					else $registracija = $registracija . "<h1>greska, ne slazu se svi parametri ili nisu prosledjeni</h1>";
					header("refresh:3; url=$TRAZI_LINK$KORISNIK_REGISTRACIJA");
				}
				break;
		}
	}
	else $registracija = $registracija . "<h1>nepoznata akcija</h1>";
	
	return $registracija;
}

?>