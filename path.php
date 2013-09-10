<?php
	//ovo cu sve promeniti u konstante sa define()...
	
	$DB_BROKER =  "broker.php";
	
	$CLANAK_PRIKAZ = "clanak/clanak.php";
	$CLANAK_OBRADA = "clanak/clanak_rad.php";
	$CLANAK_FUNKCIJE = "clanak/clanakDAO.php";
	$CLANCI_PRIKAZ = "clanak/clanci.php";
	
	$KOMENTARI_PRIKAZ = "komentari/komentari.php";
	$KOMENTARI_OBRADA = "komentari/komentari_rad.php";
	$KOMENTARI_FUNKCIJE = "komentari/komentariDAO.php";

	$KORISNIK_LOGIN = "login/login.php"; 
	$KORISNIK_LOGOUT = "login/logout.php"; 
	$KORISNIK_AUTENTIFIKACIJA = "login/autentifikacija.php";
	$KORISNIK_REGISTRACIJA = "registracija/registration.php"; 
	$KORISNIK_REGISTRACIJA_OBRADA = "registracija/registruj.php";
	$KORISNIK_PROMENA_SIFRE = "registracija/promena_sifre.php";
	$KORISNIK_LOGIN_SUCCESS = "login/login_success.php"; //ovo obrisati kad proverim da se nigde ne koristi
	
	$KORISNIK_FUNKCIJE = "korisnik/korisniciDAO.php";
	$KORISNIK_PROFIL = "korisnik/korisnik.php";
	$KORISNIK_OBRADA = "korisnik/korisnik_rad.php";
	
	
	$MASTER = "master.php";
	$INDEX = "index.php";
	$HASH = "hash.php";
	
	$ADMIN_PAGE = "admin/admin.php";
	
	//linkovi
	$TRAZI_LINK="http://localhost/komentari-clanci/"; //treba mi bolje resenje od ovoga i od $_SERVER['SERVER_NAME'] koji mi baguje
		
	//fajlovi
	$TRAZI_FILE=$_SERVER['DOCUMENT_ROOT']."komentari-clanci/";
	
	//define("TRAZI_FILE_CONST", $_SERVER['DOCUMENT_ROOT']."komentari-clanci/");
	
	
	
?>