<?php
	$mysql_server = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_db = "komentari";
	
	// --------------- konekcija ------------------
	
	global $mysqli;
	$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_db);
	
	if($mysqli->connect_errno)
	{
		printf("konekcija neuspesna: %s\n", $mysqli->connect_error);
		exit;
	}
	$mysqli->set_charset("utf8");
	
	
	
	// --------------- rad sa bazom ------------------
	
	function upis($tabela, $kolone, $vrednosti)
	{
		global $mysqli;
			
		$upit="INSERT INTO $tabela ($kolone) VALUES ($vrednosti)";
		
		//echo $upit;
		
		if ($mysqli->query($upit))
		{
			return true;
		} 
		else 
		{
			//trebalo bi da ovde baci izuzetak
			return false;
		}
		
	}
	
	function brisi($tabela, $uslov)
	{
		global $mysqli;
		
		$upit = "DELETE FROM $tabela WHERE $uslov";
		
		//echo $upit;
		
		if (!$q=$mysqli->query($upit))
		{
			//trebalo bi da ovde baci izuzetak
			return false;
		} else 
		{
			return true;
		}
		
	}
	function vratiRedove($tabela, $kolone, $uslov, $redosled)
	{
		global $mysqli;
		$upit="SELECT $kolone FROM $tabela";
		
		if($uslov!="")
		{
			 $upit=$upit." WHERE $uslov";
		}
		
		if($redosled!="")
		{
			$upit=$upit." ORDER BY $redosled";
		}
		//echo $upit;
		
		if (!$q=$mysqli->query($upit))
		{
			//trebalo bi da ovde baci izuzetak
			return false;
		}
		
		if ($q->num_rows==0)
		{
			//traba da baci da nije nasao trazeni upit
			return false;
		}
		else 
		{
			return $q;
		}
	}
	function editovanje($tabela, $vrednosti, $uslov)
	{
		global $mysqli;
		
		$upit="UPDATE $tabela SET $vrednosti WHERE $uslov";
		//echo $upit;
		
		if ($mysqli->query($upit))
			{
				if ($mysqli->affected_rows > 0 )
				{
					$poruka = "<p>Podatak je uspešno izmenjen.</p>";
					return $poruka;
				} else 
				{
					$poruka = "<p>podatak nije izmenjen.</p>";
					return $poruka;
				}
			} else 
			{
				//trebalo bi da ovde baci izuzetak
				return false;
			}
		//$mysqli->close();
	}	
	
	//obrada parametra za zastitu od sql injection
	function obradiString($string)
	{
		global $mysqli;
		$rezultat=$mysqli->real_escape_string($string);
		return $rezultat;
	}
?>