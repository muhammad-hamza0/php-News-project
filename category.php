<?php include 'header.php';
$id = $_GET['id'];
include 'config.php';

?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php 
                    $title_query = "SELECT * FROM category WHERE category_id = $id";
                    $title_result = mysqli_query($con, $title_query) or die('Query Faild: Title');
                    $cat_data = mysqli_fetch_assoc($title_result);
                    ?>
                  <h2 class="page-heading"><?php echo $cat_data['category_name']?></h2>
                  <?php 
                

                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else {
                    $page = 1;
                }
                $limit = 2;
                $page_offset = ($page - 1) * $limit;

                

                if(session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $query = "SELECT * FROM post
                LEFT JOIN category ON post.category = category.category_id
                LEFT JOIN user ON post.author = user.user_id
                WHERE category = $id
                ORDER BY post.post_id DESC LIMIT $page_offset, $limit";

                $result = mysqli_query($con, $query) or die('Query failed: post');

                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id']?>"><img src="admin/upload/<?php echo $row['post_img']?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row['post_id']?>'><?php echo $row['title']?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?id=<?php echo $id?>'><?php echo $row['category_name']?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?id=<?php echo $row['author']?>'><?php if($row['role'] == 1) { echo "Admin"; }else {echo $row['username'];} ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']?>
                                        </span>
                                    </div>
                                    <p class="description">
                                    <?php echo substr($row['description'], 0, 200) . "..."?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }
              
                    $pagination_query = "SELECT * FROM post WHERE category = $id";

                    $pagination_result = mysqli_query($con, $pagination_query) or die('Query Failed: category');

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
                            echo "<li class='$active'><a href='category.php?id=$id&page=$i'>$i</a></li>";
                        }
                        echo "</ul>";
                    }
                    
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
