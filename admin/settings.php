<?php include "header.php"; 
include 'config.php';

if(isset($_POST['submit'])) {

    if(empty($_FILES['logo_image']['name'])) {
        $file_name = $_POST['old_image'];
    }else {
        $error = array();

        $file_name = $_FILES['logo_image']['name'];
        $file_type = $_FILES['logo_image']['type'];
        $file_tmp = $_FILES['logo_image']['tmp_name'];
        $file_size = $_FILES['logo_image']['size'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); 
        $file_accept = array("jpeg", "jpg", "png");

        if(!in_array($file_extension, $file_accept)) { 
            $error[] = "Only png, jpeg, and jpg files are accepted";
        }

        if($file_size > 2097152) {
            $error[] = "Please upload less than or equal to 2MB file size";
        }

        if(empty($error)) {
            move_uploaded_file($file_tmp, "images/". $file_name);
        } else {
            print_r($error);
            die();
        }
    }

    $footer_desc = $_POST['footdesc'];

    $Update_query = "UPDATE settings SET logo_img='{$file_name}', footer_description='{$footer_desc}'";

    $Update_result = mysqli_query($con, $Update_query) or die('Query Failed: Update Settings');

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
        <h1 class="admin-heading">Settings</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->

        <?php 
        $query = "SELECT * FROM settings";

        $result = mysqli_query($con, $query) or die('Query Failed: Read Data');

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>

        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="">Logo</label>
                <input type="file" name="logo_image">
                <img src="images/<?php echo $row['logo_img']?>" style="height='150px'" />
                <input type="hidden" name="old_image" value="<?php echo $row['logo_img']?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Footer Description</label>
                <textarea name="footdesc" class="form-control"  required rows="5"><?php echo $row['footer_description']?></textarea>
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