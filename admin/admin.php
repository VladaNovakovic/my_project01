<?php

	require "../path.php";
	require "$TRAZI_FILE$MASTER";
	require "$TRAZI_FILE$KORISNIK_FUNKCIJE";
	

	echo top("Admin page");
	echo sadrzajAdmin();	
	echo bottom();
	
	
	
	function sadrzajAdmin()
	{
		if(!isset($_SESSION['level']) || ($_SESSION['level']<5))
		{
			return "<h1>NEMATE DOZVOLU ZA PRISTUP OVOJ STRANICI!</h1>";
		}
		else return "<h1>Dobrodosli na admin stranicu!</h1>".pisiKorisnike();
	}
	
	function prikazBanovanja($user_id, $ban)	//funkcija koja ispisuje banuj/odbanuj u zavisnosti od toga da li je banovan ili ne
	{
		global $TRAZI_LINK;
		global $KORISNIK_OBRADA;
		
		$banovanje = '<a class="link" href="'.$TRAZI_LINK.$KORISNIK_OBRADA;
		
		switch($ban)
		{
			case 0:
				$banovanje = $banovanje.'?akcija=banuj&id='.$user_id.'">banuj</a>';
				break;
			case 1:
				$banovanje = $banovanje.'?akcija=skini_ban&id='.$user_id.'">odbanuj</a>';
				break;
			default:
				$banovanje = $banovanje.'">neka greska</a>';
				break;
		}
		return $banovanje;
		
	}
	
	function pisiKorisnike()
	{
	
		$tabela="<div class='tabela'><table>
			<tr>
				<td>user_id</td>
				<td>username</td>
				<td>email</td>
				<td>level</td>
				<td>reg_date</td>
				<td>ban</td>
				<td>ban_date</td>
			</tr>
			";
		if(!$korisnici=listajKorisnike())
		{
			return "nema korisnika, mora da je neka greska...";
		}
		while ($red=$korisnici->fetch_object())
		{
			$user_id=$red->id_user;
			$username=$red->username;
			$email=$red->email;
			$level=$red->level;
			$reg_date=$red->reg_date;
			$ban=$red->ban;
			$ban_date=$red->ban_date;
			$banovanje=prikazBanovanja($user_id, $ban);
			
			global $TRAZI_LINK;
			global $KORISNIK_PROFIL;
			
			$privremeni=<<<KOMENTARI
			<tr>
				<td>$user_id</td>
				<td><a class="link" href="$TRAZI_LINK$KORISNIK_PROFIL?id=$user_id">$username</a></td>
				<td>$email</td>
				<td>$level</td>
				<td>$reg_date</td>
				<td>$banovanje</td>
				<td>$ban_date</td>
			</tr>
			
KOMENTARI;
			$tabela=$tabela.$privremeni;
			
		}
		return $tabela."</table></div>";
	}
?>