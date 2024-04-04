<?php 

session_start();

include 'config.php';

if(!isset($_SESSION['username'])) {
    header("Location: {$hostname}admin");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>ADMIN Panel</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <!-- Custom stlylesheet -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <!-- HEADER -->
        <div id="header-admin">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <?php 
                    $query = "SELECT * FROM settings";

                    $result = mysqli_query($con, $query) or die('Query Failed: Read Settings Data');
                    
                    ?>
                    <!-- LOGO -->
                    <div class="col-md-2">
                        <?php 
                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $logo_img = $row['logo_img'];
                            echo "<a href='../index.php'><img class='logo' src='images/$logo_img'></a>";
                        }else {
                            echo "<a href='../index.php'><img class='logo' src='images/news.jpg'></a>";
                        }
                        ?>
                        
                    </div>
                    <!-- /LOGO -->
                      <!-- LOGO-Out -->
                    <div class="col-md-10 text-right">
                        <a href="logout.php" class="admin-logout" >
                        <?php 
                        if(session_status() == PHP_SESSION_NONE) {

                            session_start();
                        }
                        $username = $_SESSION['username'];
                        echo "<span>$username</span>";
                        ?>    
                        logout</a>
                    </div>
                    <!-- /LOGO-Out -->
                </div>
            </div>
        </div>
        <!-- /HEADER -->
        <!-- Menu Bar -->
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <ul class="admin-menu">
                            <li>
                                <a href="post.php">Post</a>
                            </li>
                            <?php 
                            if($_SESSION['user_role'] == 1) {
                            ?>
                            <li>
                                <a href="category.php">Category</a>
                            </li>
                            <li>
                                <a href="users.php">Users</a>
                            </li>
                            <li>
                                <a href="settings.php">Settings</a>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Menu Bar -->
