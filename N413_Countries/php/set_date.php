<?php
include("n413connect.php");

$id = 0;
if(isset($_REQUEST["id"])){$id = intval($_REQUEST["id"]);}
$traveldate = "";
if(isset($_REQUEST["traveldate"])){
	//sanitize
	$traveldate = html_entity_decode($_REQUEST["traveldate"]);
	$traveldate = trim($traveldate);
	$traveldate = stripslashes($traveldate);
	$traveldate = strip_tags($traveldate);
	$traveldate = mysqli_real_escape_string( $link, $traveldate );
}

$sql = "UPDATE countries SET travel_date = '".$traveldate."' WHERE id = '".$id."' ";
$result = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) == 1){
	echo "success";
}else{
	echo "There was a problem updating the database";
}

?>