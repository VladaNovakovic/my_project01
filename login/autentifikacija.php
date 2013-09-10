<?php

	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	require "$TRAZI_FILE$HASH";

	echo top("Autentification page");
	echo sadrzajAutentifikacija();
	echo bottom();
	
	
function sadrzajAutentifikacija()
{
	$sadrzaj = "<h1>dosli ste na autentifikaciju</h1>";
	
	global $INDEX;
	global $TRAZI_FILE;
	global $TRAZI_LINK;
	global $KORISNIK_FUNKCIJE;
	global $KORISNIK_LOGIN;
	global $KORISNIK_AUTENTIFIKACIJA;
	
	if(isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']!=$TRAZI_LINK.$KORISNIK_AUTENTIFIKACIJA))
	{
		$prethodnaStranica = $_SERVER['HTTP_REFERER'];
	}
	else
	{
		$prethodnaStranica = $TRAZI_LINK.$INDEX;
	}
	
	if( isset($_POST['login']) && !empty($_POST["korisnik"]) && !empty($_POST["sifra"]))
	{
		require "$TRAZI_FILE$KORISNIK_FUNKCIJE";
		
		$username = $_POST["korisnik"];
		$enteredPassword = $_POST["sifra"];
		
		$korisnik = vratiKorisnik($username);
		
		
		
		if( $korisnik && $korisnik->num_rows == 1 )
		{
			$k=$korisnik->fetch_object();
			$level = $k->level;
			$password = $k->password;
			$id_user = $k->id_user;
			
			if(!validate_password($enteredPassword, $password))
			{
				$sadrzaj = $sadrzaj."<h1>Wrong Username or password</h1>";
			}
			else
			{
				
		
				if($k->ban) 
				{	
					$ban_date = $k->ban_date;
					
					$sada =  time() + (2 * 60 * 60);
					$trenutno_vreme = date('Y-m-d H:i:s', $sada);
					
					if($ban_date>$trenutno_vreme)
					{
						$sadrzaj=$sadrzaj."<script>alert('Jos uvek ste banovani!');</script>";
					}
					else 
					{
						if(banujKorisnika($id_user, false))
						{	
							loguj($id_user, $username, $level);
							$sadrzaj=$sadrzaj."skinut ban!";
						}
						else
						{
							$sadrzaj=$sadrzaj."nije sve ok! neka graska";
						}
						$sadrzaj=$sadrzaj."<script>alert('Ban je prosao!');</script>";
						
					}
				
				}
				else
				{
					$sadrzaj = $sadrzaj.loguj($id_user, $username, $level);
				}
			}
			
		}
		else 
		{
			$sadrzaj = $sadrzaj."<h1>Wrong Username or password</h1>";
		}
	}
	else 
	{
		$sadrzaj = $sadrzaj. "nisu uneti parametri";
	}
	header( "refresh:2;url=$prethodnaStranica" );
	return $sadrzaj;
		
}
function loguj($id_user, $username, $level)
{
	// Register $username id and level 
	$_SESSION['username'] = $username;
	$_SESSION['user_id']=$id_user;
	$_SESSION['level']=$level;
	
	return "<h1>uspesno ste se logovali!</h1>";
}
?>