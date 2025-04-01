<?php
require_once "conn.php";

$id  = $_GET['id'] ?? '';
$sql = "DELETE FROM user_4 WHERE id='$id'";

if(mysqli_query($con,$sql)){
    header("Location:index.php");
}
?>