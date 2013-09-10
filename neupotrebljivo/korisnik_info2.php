<?php
	session_start();

	
	if(isset($_SESSION['username']))
	{	
		$username=$_SESSION['username'];
		$level=$_SESSION['level'];
		echo '<div><table><td>'.$username.' | </td><td> level ('.$level.') | </td><td><a href="logout.php">Logout</td></table></div>';
	}
	else
	{
		echo '<div><form method="post" action="autentifikacija.php"><table>
		<td>Username: </td><td><input type="textarea" name="korisnik"></td>
		<td>Password: </td><td><input type="password" name="sifra"></td>
		<td><input type="submit" name="login" value="Login!"></td><td> | or <a href="registration.php">register</a></td></table></form></div>';
	}
?>