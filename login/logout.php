<?php 
	require "../path.php";
	require "$TRAZI_FILE$MASTER";

	echo top("Logout page");
	echo logout();
	echo bottom();
	
	function logout()
	{
		global $TRAZI_LINK;
		global $INDEX;
	
		session_destroy();
		header( "refresh:2;url=$TRAZI_LINK$INDEX" );
		return "<h1>Dovidjenja!</h1>";
		
	}
		
?>
