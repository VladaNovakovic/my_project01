<?php
	require "../path.php";
	require "$TRAZI_FILE$MASTER";

	echo top("Registracija");
	
	$regEmail = "";
	$regUsername = "";
	
	if(isset($_SESSION['username']))
	{
		echo "<h1>registrovani ste!<h1/>";
	}
	else 
	{
		if(isset($_SESSION['regEmail']) && isset($_SESSION['regUsername']))
		{	
			$regEmail = $_SESSION['regEmail'];
			$regUsername = $_SESSION['regUsername'];
			//echo registracijaForma($_SESSION['regUsername'], $_SESSION['regEmail']);
		}
		
		echo registracijaForma($regUsername, $regEmail);
	}
	echo bottom();
	
function registracijaForma($username="", $email="")
{
	if(isset($_POST['submit']) && isset($_POST['email']) && isset($_POST['username']))
	{
		$email=$_POST['email'];
		$username=$_POST['username'];
	}
		global $TRAZI_LINK;
		global $KORISNIK_REGISTRACIJA_OBRADA;
		$registracija='<center><div class="forma">
			<form name="registracija" method="post" action="'.$TRAZI_LINK.$KORISNIK_REGISTRACIJA_OBRADA.'?akcija=registruj">
			<table>
				<tr>
					<td>Username : </td>
					<td><input type="text" name="username" value='.$username.' ></td>
					<!--<td><input type="button" name="proveri" value="Proveri" action="'.$TRAZI_LINK.$KORISNIK_REGISTRACIJA_OBRADA.'" />-->
				</tr>
				<tr>
					<td>email : </td>
					<td><input type="email" name="email" value='.$email.' ></td>
				</tr>
				<tr>
					<td>Password : </td>
					<td><input type="password" name="password" /></td>
				</tr>
				<tr>
					<td>Confirm password : </td>
					<td><input type="password" name="confirmPass" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Registruj"/></td>
				</tr>
			</table>
			</form>
		</div></center>';
	return $registracija;
}

?>