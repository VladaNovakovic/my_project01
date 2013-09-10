<?php
	require "../path.php";
	require "$TRAZI_FILE$MASTER";

	echo top("Login page");
	echo sadrzajLogin();
	echo bottom();
	
	function sadrzajLogin()
	{	
		global $TRAZI_LINK;
		global $KORISNIK_AUTENTIFIKACIJA;
		global $KORISNIK_LOGOUT;
			
		$sadrzaj="";
		if(isset($_SESSION['username']))
		{
			$sadrzaj='<h3>Morate prvo da se izlogujete! >>><a class="link" href="'.$TRAZI_LINK.$KORISNIK_LOGOUT.'">Logout</a><<<</h3>';
			
		}
		else
		{
			
			$sadrzaj =<<<SADRZAJ
		<div id="login_forma" class="forma">
		<form method="post" action="$TRAZI_LINK$KORISNIK_AUTENTIFIKACIJA">
			<table>
				<tr>
					<td><p>Username: </p></td>
					<td><input type="textarea" name="korisnik"></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="password" name="sifra"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="login" value="Login!"></td>
				</tr>
			</table>
		</form>
		</div>
SADRZAJ;
		}
		return $sadrzaj;
	}
	
?>