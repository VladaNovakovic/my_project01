<?php

function korisnikInfo()
{
	require "../path.php";
	
	session_start();
	
	$info = "<div id='korisnik_info'>";
	
	if(isset($_SESSION['username']))
	{	
		$username = $_SESSION['username'];
		$level = $_SESSION['level'];
		$info = $info.'<table><td>'.$username.' | </td><td> level ('.$level.') | </td><td><a href="'.$TRAZI_LINK.$KORISNIK_LOGOUT.'">Logout</td></table>';
	}
	else
	{
		$info = $info.'<form method="post" action="'.$TRAZI_LINK.$KORISNIK_AUTENTIFIKACIJA.'"><table>
		<td>Username: </td><td><input type="textarea" name="korisnik"></td>
		<td>Password: </td><td><input type="password" name="sifra"></td>
		<td><input type="submit" name="login" value="Login!"></td><td> | or <a href="'.$TRAZI_LINK.$KORISNIK_REGISTRACIJA.'">register</a></td></table></form>';
	}

		return $info."</div>";
}
?>