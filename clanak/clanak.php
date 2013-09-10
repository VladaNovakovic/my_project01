<?php

require "../path.php";
require "$TRAZI_FILE$MASTER";
require "$TRAZI_FILE$CLANAK_FUNKCIJE";
require "$TRAZI_FILE$KOMENTARI_PRIKAZ";

//setovanje i dohvatanje naslova za prikaz u tabu
$naslov = "Nije setovan";	
if (isset($_GET['clanak']))
{
	global $naslov;
	$naslov = vratiNaslov($_GET['clanak']);
}

echo top($naslov);
echo clanakIspis();
echo bottom();

function clanakIspis()
{
	if (isset ($_GET['clanak']))
	{
		$id=$_GET['clanak'];
		
		$clanak = pisiClanak($id);
		if($clanak)
		{
			$clanak = $clanak.pisiKomentare($id);
		}
	}
	else $clanak = "nije setovan clanak_id";

	return $clanak;
}
?>