<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                <?php 
                
                include 'config.php';

                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else {
                    $page = 1;
                }
                $limit = 5;
                $page_offset = ($page - 1) * $limit;

                if(session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                if($_SESSION['user_role'] == 1) {

                $query = "SELECT * FROM post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        ORDER BY post.post_id DESC LIMIT $page_offset, $limit";

                }elseif($_SESSION['user_role'] == 0) {
                    $user_id = $_SESSION["user_uid"];
                    $query = "SELECT * FROM post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE post.author = {$user_id}
                        ORDER BY post.post_id DESC LIMIT $page_offset, $limit";
                }


                $result = mysqli_query($con, $query) or die('Query failed');

                if(mysqli_num_rows($result) > 0) {

                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php 
                        while($row = mysqli_fetch_assoc($result)) {
                        ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id']?></td>
                              <td><?php echo $row['title']?></td>
                              <td><?php echo $row['category_name']?></td>
                              <td><?php echo $row['post_date']?></td>
                              <td>
                                <?php 
                                if($row['role'] == 1) {
                                    echo 'ADMIN';
                                }else {
                                    echo 'USER';
                                }
                                ?>
                              </td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']?>&cat_id=<?php echo $row['category_id']?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                         <?php }?>
                      </tbody>
                  </table>
                  <?php }
                  
                  $pagination_query = "SELECT * FROM post";

                  $pagination_result = mysqli_query($con, $pagination_query) or die('Query Failed');

                  if(mysqli_num_rows($pagination_result) > 0){

                    $Total_records = mysqli_num_rows($pagination_result);
                    
                    $Total_pages = ceil($Total_records / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                    for($i = 1; $i <= $Total_pages; $i++) {
                        if($i == $page) {
                            $active = 'active';
                        }else {
                            $active = '';
                        }
                        echo "<li><a class='$active' href='post.php?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                  }
                  
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
