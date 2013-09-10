<?php
	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	require "$TRAZI_FILE$KORISNIK_FUNKCIJE";
	

	echo top("Profil : ".vratiUsername($_GET['id']));
	echo sadrzajKorisnik();	
	echo bottom();

	
	function sadrzajKorisnik()
	{
		$user_id=$_GET['id'];
		
		if(!$q=vratiKorisnikId($user_id))
		{
			return '<div class="tabela"><h2>Nema trazenog korisnika</h2></div>';
		}
		else 
		{
			$red = $q->fetch_object();
			//$user_id=$red->id_user;
			$username=$red->username;
			//echo $username;
			$email=$red->email;
			$level=$red->level;
			$reg_date=$red->reg_date;
			$ban=$red->ban;
			$ban_date=$red->ban_date;
			
			return "<div class='forma'>
			<table>
				<tr><td>user_id</td><td>:</td><td>$user_id</td></tr>
				<tr><td>username</td><td>:</td><td>$username</td></tr>
				<tr><td>email</td><td>:</td><td>$email</td></tr>
				<tr><td>level</td><td>:</td><td>$level</td></tr>
				<tr><td>reg_date</td><td>:</td><td>$reg_date</td></tr>
				<tr><td>ban</td><td>:</td><td>$ban</td></tr>
				<tr><td>ban_date</td><td>:</td><td>$ban_date</td></tr>
			</table>
			</div>";
		}
	}
?>