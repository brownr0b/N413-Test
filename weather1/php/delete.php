<?php
include("n413connect.php");

$id = $_REQUEST['id'];
$city = $_REQUEST['city'];

$sql = "delete from history_weather where user_id = '$id' and city = '$city' ";
$result = mysqli_query($link, $sql);

if ($link->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: ";
}

session_write_close();
?>