<?php 

$user_id = $_GET['id'];

include 'config.php';

$query = "DELETE FROM user WHERE user_id = $user_id";

$Result = mysqli_query($con, $query) or die('query unsuccessfull');

if($Result) {
    header("Location: {$hostname}admin/users.php");
}

?>