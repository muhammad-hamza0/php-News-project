<?php 

include 'config.php';

$cat_id = $_GET['id'];

$query = "DELETE FROM category WHERE category_id = $cat_id";

$result = mysqli_query($con, $query) or die('query failed');

if($result) {
    header("Location: {$hostname}admin/category.php");
}

?>