<?php
include("n413connect.php");

$id = 0;
if(isset($_REQUEST["id"])){$id = intval($_REQUEST["id"]);}
$comment = "";
if(isset($_REQUEST["comment"])){
	//sanitize
	$comment = html_entity_decode($_REQUEST["comment"]);
	$comment = trim($comment);
	$comment = stripslashes($comment);
	$comment = strip_tags($comment);
	$comment = mysqli_real_escape_string( $link, $comment );
}

$sql = "UPDATE countries SET comments = '".$comment."' WHERE id = '".$id."' ";
$result = mysqli_query($link, $sql);

$data = Array();
if(mysqli_affected_rows($link) == 1){
	$data["status"] = "success";
}else{
	$data["status"] = "There was a problem updating the database";
}

echo json_encode($data);

?>