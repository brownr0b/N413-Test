<?php
include("n413connect.php");

$id = $_REQUEST['id'];

$sql = "delete from history_weather where user_id = '$id' ";
$result = mysqli_query($link, $sql);

if ($link->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: ";
}

session_write_close();
?>