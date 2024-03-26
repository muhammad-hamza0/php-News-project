<?php include "header.php"; 
include 'config.php';

if(isset($_POST['submit'])) {

    if(empty($_FILES['new_image']['name'])) {
        $file_name = $_POST['old_image'];
    }else {
        $error = array();

        $file_name = $_FILES['new_image']['name'];
        $file_type = $_FILES['new_image']['type'];
        $file_tmp = $_FILES['new_image']['tmp_name'];
        $file_size = $_FILES['new_image']['size'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); 
        $file_accept = array("jpeg", "jpg", "png");

        if(!in_array($file_extension, $file_accept)) { 
            $error[] = "Only png, jpeg, and jpg files are accepted";
        }

        if($file_size > 2097152) {
            $error[] = "Please upload less than or equal to 2MB file size";
        }

        if(empty($error)) {
            move_uploaded_file($file_tmp, "upload/". $file_name);
        } else {
            print_r($error);
            die();
        }
    }

    $post_id = $_POST['post_id'];
    $post_title = $_POST['post_title'];
    $post_desc = $_POST['postdesc'];
    $post_category = $_POST['category'];

    $Update_query = "UPDATE post SET title='{$post_title}', description='{$post_desc}', category={$post_category}, post_img='{$file_name}' WHERE post_id = $post_id";

    $Update_result = mysqli_query($con, $Update_query) or die('Query Failed');

    if($Update_result) {
        header("Location: {$hostname}admin/post.php");
    }else {
        echo "Query Failed";
    }

}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->

        <?php 

        $post_id = $_GET['id'];
        
        $query = "SELECT * FROM post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE post_id = $post_id";

        $result = mysqli_query($con, $query) or die('Query Failed');

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>

        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id']?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $row['description']?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                    <?php 
                    
                    $cat_query = "SELECT * FROM category";

                    $cat_result = mysqli_query($con, $cat_query) or die('Query Failed');
                    if(mysqli_num_rows($cat_result) > 0) {
                        while($row1 = mysqli_fetch_assoc($cat_result)) {
                        if($row1['category_id'] == $row['category']) {
                            $selected = 'selected';
                        }else {
                            $selected = '';
                        }
                    ?> 
                    <option <?php echo $selected?> value="<?php echo $row1['category_id']?>"><?php echo $row1['category_name']?></option>
                   <?php 
                   }
                    }else {
                        echo "Result Not Found!";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new_image">
                <img  src="upload/<?php echo $row['post_img']?>" height="150px">
                <input type="hidden" name="old_image" value="<?php echo $row['post_img']?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php 
        }
        }else {
            echo "Result Not Found!";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
