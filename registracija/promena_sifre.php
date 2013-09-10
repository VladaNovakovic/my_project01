<?php
	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	
	echo top("Promena sifre");
	echo promenaSifre();
	echo bottom();

	function promenaSifre()
	{
		$promenaSifre = "";
		
		if(isset($_SESSION['username']))
		{
			$username=$_SESSION['username'];
			global $TRAZI_LINK;
			global $KORISNIK_REGISTRACIJA_OBRADA;
			
			$promenaSifre = $promenaSifre."<p>dosli ste da promenite sifru<p>
			<div class='forma'>
			<form name='promena' method='post' action='$TRAZI_LINK$KORISNIK_REGISTRACIJA_OBRADA?akcija=menjaj_sifru'>
			<table>
				<tr>
					<td>Username : </td>
					<td>$username</td>
				</tr>
				<tr>
					<td>Old password : </td>
					<td><input type='password' name='oldPassword'></td>
				</tr>
				<tr>
					<td>New password : </td>
					<td><input type='password' name='newPassword'></td>
				</tr>
				<tr>
					<td>Confirm password : </td>
					<td><input type='password' name='confirmPassword'></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='submit' name='menjaj' value='Menjaj' ></td>
				</tr>
			</table>
			</form>
			</div>";
		} 
		else
		{
			$promenaSifre = $promenaSifre."<p>niste logovani</p>";
		}
		return $promenaSifre;
	}
	
?>