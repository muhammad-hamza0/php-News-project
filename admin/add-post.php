<?php include "header.php"; 

if(isset($_POST['submit'])) {

    if(isset($_FILES['fileToUpload'])){
        $error = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_extension = strtolower(end(explode('.', $file_name)));
        $file_accept = array('jpeg, jpg, png');

        if(in_array($file_extension, $file_accept) == false) {
            $error[] = "Only png, jpeg, and jpg files are accepted";
        }

        if($file_size > 2097152) {
            $error[] = "Please upload less then or equal to 2mb file size";
        }

        if(empty($error) == true) {
            move_uploaded_file($file_tmp, "upload/". $file_name);
        }else {
            print_r($error);
        }
    }

    session_start();

    $post_title = $_POST['post_title'];
    $post_desc = $_POST['postdesc'];
    $post_category = $_POST['category'];
    $post_date = date('d M, Y');
    $author = $_SESSION['user_id']; 

    $insert_query = "INSERT INTO post(title, description, category, post_date, author, post_img)
                    VALUES ('{$post_title}', '{$post_desc}', '{$post_category}', '{$post_date}', {$author}, '{$file_name}');";
    $insert_query .= "UPDATE category SET post = post + 1 WHERE category_id =  $post_category";            

    if(mysqli_multi_query($con, $insert_query)) {
        header("Location: {$hostname}admin/post.php");
    }else {
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
                              
                              include 'config.php';

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
