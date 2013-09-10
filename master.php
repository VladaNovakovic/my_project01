<?php

require "path.php";

function top($naslov)
{
	session_start();
	
	$info = korisnikInfo();
	$meni = meni();
	
	$gornji=<<<TOP
<html>
	<head>
		<title>$naslov | Ovde dodje naslov sajta</title>
		<style>
		body
		{
			background-color: yellow;
			font-family: vedrana, arial;
		}
		#wrap
		{
			background-color: black;
			color: yellow;
			width: 1000px;
			min-height: 800px;
			margin: auto;
			padding: 10px;
		}
		#banner
		{
			background-color: rgba(ff,ff,00,0.5);
			background-color: yellow;
			width: 700px;
			height: 75px;
			margin-left: auto;
			margin-right: auto;
			
			
		}
		.forma
		{
			border: 1px solid yellow;
			margin: auto;
			margin-top: 50px;
			width: 600px;
		}
		.tabela
		{
			border: 1px solid yellow;
			margin: auto;
			margin-top: 50px;
			width: 900px;
		}
		.tabela table
		{
			color: yellow;
			margin: auto;
			margin-top: 20px;
			margin-bottom: 20px;
		}
		.forma table
		{
			color: yellow;
			margin: auto;
			margin-top: 20px;
			margin-bottom: 20px;
		}
		#korisnik_info
		{
			height: 30px;
			min-width: 200px;
			margin: auto;
			margin-bottom: 20px;
			border: 1px solid yellow;
			box-align:center;
		}
		#korisnik_info table
		{
			color: yellow;
			
		}
		
		.meni
		{
			background-color: yellow;
			margin-top: 10px;
			margin-bottom: 10px;
			height: 20px;
			padding: 5px;
		}
		.meni a
		{
			margin: 10px;
			margin-top: 5px;
			margin-bottom: 5px;
		}
		#footer
		{
			background-color: yellow;
			color: black;
			text-align: center;
			
		}
		#content
		{
			border: 1px solid yellow;
			min-height: 800px;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.link
		{
			color: red;
			text-decoration:none;
			margin: 5px;
		}
		.link:hover
		{
			text-decoration:underline;
		}
		.meni_link
		{
			font-weight: bold;
		}
		div.inline_left { float:left; }
		div.inline_right { float:right; }
		.clearBoth { clear:both; }
		</style>
	</head>
	<body>
		<div id="wrap">
			<!-- ovde dodje za info o sesiji -->
			$info
			
			<div id="banner"></div>
			$meni
			<div id="content">
			
	
TOP;
	return $gornji;

}
function korisnikInfo()
{
	//require "path.php";
	global $TRAZI_LINK;
	global $KORISNIK_PROFIL;
	global $KORISNIK_LOGOUT;
	global $KORISNIK_PROMENA_SIFRE;
	global $KORISNIK_AUTENTIFIKACIJA;
	global $KORISNIK_REGISTRACIJA;
	
	$info = "<div id='korisnik_info'><div class='inline_right'>";
	
	if(isset($_SESSION['username']))
	{	
		$username = $_SESSION['username'];
		$user_id = $_SESSION['user_id'];
		$level = $_SESSION['level'];
		//$info = $info.'<table><td>'.$username.' | </td><td> level ('.$level.') | </td><td><a href="'.$TRAZI_LINK.$KORISNIK_LOGOUT.'">Logout</td><td> | <a href="'.$TRAZI_LINK.$KORISNIK_PROMENA_SIFRE.'">Promena sifre</td></table>';
		$info = $info.'<table><td><a class="link" href="'.$TRAZI_LINK.$KORISNIK_PROFIL.'?id='.$user_id.'">'.$username.'</a> | </td>
						<td> level ('.$level.') | </td>
						<td><a class="link" href="'.$TRAZI_LINK.$KORISNIK_LOGOUT.'">Logout</a></td>
						<td> | <a class="link" href="'.$TRAZI_LINK.$KORISNIK_PROMENA_SIFRE.'">Promena sifre</td></table>';
	}
	else
	{
		$info = $info.'<form method="post" action="'.$TRAZI_LINK.$KORISNIK_AUTENTIFIKACIJA.'"><table>
		<td>Username: </td><td><input type="textarea" name="korisnik"></td>
		<td>Password: </td><td><input type="password" name="sifra"></td>
		<td><input type="submit" name="login" value="Login!"></td><td> | or <a class="link" href="'.$TRAZI_LINK.$KORISNIK_REGISTRACIJA.'">register</a></td></table></form>';
	}

		return $info."</div><br class='clearBoth'></div>";
}
function bottom()
{
	$donji=<<<BOTTOM
			</div>
			<div id="footer">footer</div>
		</div>
	</body>
</html>
BOTTOM;
	return $donji;
}

function stilovi()
{
	$stilovi=<<<STILOVI
			<h1>heder1</h1>
			<h2>heder2</h2>
			<h3>heder3</h3>
			<h4>heder4</h4>
			<h5>heder5</h5>
			<p>bla bla bla bla</p>
			<p>bla bla bla blabla bla bla blabla bla bla bla</p>
			<p>bla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla bla</p>
STILOVI;

	return $stilovi;
}

function meni()
{
	//require "path.php";
	global $TRAZI_LINK;
	global $CLANCI_PRIKAZ;
	global $ADMIN_PAGE;
	
	
	$meni="<div class='meni'>
			<a class='link meni_link' href=".$TRAZI_LINK.$CLANCI_PRIKAZ.">clanci</a>";
	if(!(!isset($_SESSION['level']) || $_SESSION['level']<5))
	{
		$meni = $meni."<a class='link meni_link' href=".$TRAZI_LINK.$ADMIN_PAGE.">admin</a>";
	}
	return $meni."</div>";
}

?>