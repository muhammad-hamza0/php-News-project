<?php 

include 'config.php';

$post_id = $_GET['id'];
$cat_id = $_GET['cat_id'];

$query1 = "SELECT * FROM post WHERE post_id = $post_id";

$result = mysqli_query($con, $query1) or die('Query Failed');

$row = mysqli_fetch_assoc($result);

$query = "DELETE FROM post WHERE post_id = {$post_id};";

$query .= "UPDATE category SET post = post - 1 WHERE category_id = {$cat_id}";

if(mysqli_multi_query($con, $query)){
    unlink("upload/". $row['post_img']);
    header("Location: {$hosname}post.php");
}else {
    echo "Query Failed";
}

?>