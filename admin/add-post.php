<?php include "header.php"; 
 include 'config.php';

 if(isset($_POST['submit'])) {
    if(isset($_FILES['fileToUpload'])){
        $error = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); 
        $file_accept = array("jpeg", "jpg", "png");

        if(!in_array($file_extension, $file_accept)) { 
            $error[] = "Only png, jpeg, and jpg files are accepted";
        }

        if($file_size > 2097152) {
            $error[] = "Please upload less than or equal to 2MB file size";
        }

        $image_file = time() . '-' . $file_name;

        $target = "upload/" . $image_file;

        if(empty($error)) {
            move_uploaded_file($file_tmp, $target);
        } else {
            print_r($error);
            die();
        }
    }

    if (session_status() == PHP_SESSION_NONE) { 
        session_start(); 
    }
    
    $post_title = mysqli_real_escape_string($con, $_POST['post_title']);
    $post_desc = mysqli_real_escape_string($con, $_POST['postdesc']);
    $post_category = mysqli_real_escape_string($con, $_POST['category']);
    $post_date = date('d M, Y');
    $author = $_SESSION['user_uid'];

    $insert_query = "INSERT INTO post(title, description, category, post_date, author, post_img)
                    VALUES('{$post_title}', '{$post_desc}', {$post_category}, '{$post_date}', {$author}, '{$image_file}')";
    $update_query = "UPDATE category SET post = post + 1 WHERE category_id = {$post_category}";

    if(mysqli_query($con, $insert_query) && mysqli_query($con, $update_query)) {
        header("Location: {$hostname}admin/post.php");
        exit(); 
    } else {
        echo "<div class='alert alert-danger'>Query Failed</div>";
    }
}

?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                              <option value="" disabled> Select Category</option>
                              <?php 
                              
                             

                              $query = "SELECT * FROM category";

                              $result = mysqli_query($con, $query) or die('query failed');

                              if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                              ?>
                              <option value="<?php echo $row['category_id']?>"><?php echo $row['category_name']?></option>
                              <?php }
                              }?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
