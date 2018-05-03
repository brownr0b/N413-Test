<?php
include("n413connect.php");

$result = NULL;

if (isset($_REQUEST["id"])){
	$id = intval($_REQUEST["id"]);
	
	//look up student
	$roster_query = "SELECT * FROM class_roster WHERE id = '".$id."'";
	$roster_result = mysqli_query($link, $roster_query);
	$student = mysqli_fetch_array($roster_result, MYSQLI_BOTH);
	
	if (isset($_REQUEST["week"])){
		$week = intval($_REQUEST["week"]);
		//look up the week's attendance record
		$week_query = "SELECT week FROM attendance 
					WHERE roster_id = '".$id."'
					AND week = '".$week."'";
		$week_result = mysqli_query($link, $week_query);
		
		//check to see if a record for this week exists
		$present_this_week = false;	
		if (mysqli_num_rows($week_result) > 0){$present_this_week = true;}
		if (! $present_this_week){
			//There is no attendance record for this week  -- INSERT an attendance record
			$query = "INSERT INTO `attendance` (`id`, `roster_id`, `week`,`timestamp`) 
						VALUES (NULL, '".$id."','".$week."', NOW())";
			$result = mysqli_query($link, $query);	
			if ($result){$present_this_week = true;}
		}
	}
	
}

//write the correct HTML to display in the student's <div> tag
$html = '<img src="'.$student["photo"].'" height="30"> '.$student["first_name"].' '.$student["last_name"];

if ($present_this_week){
	$html .= '
	<span class="glyphicon glyphicon-check" aria-hidden="true" style="float:right;margin-right:0.3em;"></span>';
}else{
	$html .= '
	<span class="glyphicon glyphicon-unchecked" aria-hidden="true" style="float:right;margin-right:0.3em;"></span>';
}

echo $html;

?>
