<?php
	//include "korisniciDAO.php";
	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	
	echo top("Registrating...");
	registracijaObrada();
	echo bottom();
	
	function registracijaObrada()
{
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
						echo "postoji username<br/>";
					}
					else echo "dobar username<br/>";
							
					//ovaj deo treba prebaciti da provereava na registration.php ajaxom
					if(!checkEmail($email)) 
					{
						echo "postoji email<br/>";
					}
					else echo "dobar email<br/>";
					
					//ovaj deo treba prebaciti da provereava na registration.php ajaxom
					//minimum duzina, npr 8... maximum duzina 16
					//12 characters and require at least two letters, two digits, and two symbols
					if($password==$confirmPass) 
					{
						echo "sifre su iste<br/>";
						$passwordHash = create_hash($password);
					}
					else echo "sifre se razlikuju<br/>";
					
					//echo $username."<br/>".$email."<br/>".$passwordHash."<br/>".$confirmPass."<br/>";
					
					if(registruj($username, $email, $passwordHash))
					{
						echo "registrovan";
					}
					else echo "nije uspesno registrovan";
					
					//header( "refresh:2;url=registration.php" );
				}
				break;
			case "menjaj_sifru";
				{
					echo "parametri : <br/>";
					//echo $_SESSION['username']."<br/>".$_SESSION['user_id']."<br/>".$_POST['oldPassword']."<br/>".$_POST['newPassword']."<br/>".$_POST['confirmPassword']."<br/>";
					
					if(isset($_POST['menjaj']) && !empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword']) &&($_POST['newPassword']==$_POST['confirmPassword']) && isset($_SESSION['user_id']) && proveriSifru($_SESSION['user_id'],$_POST['oldPassword']))
					{
						$novaSifra = create_hash($_POST['newPassword']);
						if(menjajSifru($_SESSION['user_id'],$novaSifra))
						{
							echo "uspesno promenjena sifra";
						}
						else echo "greska pri promeni";
					}
					else echo "greska, ne slazu se svi parametri";
					
					//echo "ovde f-ha za proveru sifre npr proveriSifru($_SESSION['id_user'],$_POST['oldPassword'])";
					
				}
				break;
		}
	}
	else echo "<h1>nisu prosledjeni parametri</h1>";
}

?>