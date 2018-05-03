<?php
////////////////////// MAMP version ///////////////////////

	$dbhost = 'localhost';
	$dbuser = 'brownrob';
	$dbpwd  = 'brownrob';
	$dbname = 'brownrob_db';  //'<your MAMP database name>';

	$link = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);

	if (!$link) {
		die('Connect Error (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
	}

//////////////////////////////////////////////////////////

////////////////////// web-4 method /////////////////////

/// I don't have a web-4 server so this method won't work ///

//	$dbhost = 'localhost';
//	$dbuser = 'brownrob';
//	$dbpwd  = 'brownrob';
//	$dbname = 'brownrob_db';
//
//	$link = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);
//
//	if (!$link) {
//		die('Connect Error (' . mysqli_connect_errno() . ') '
//				. mysqli_connect_error());
//	}
?>
