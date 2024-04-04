<!-- office branch -->
<?php
include 'config.php';

$page_title = basename($_SERVER['PHP_SELF']);

switch ($page_title) {
    case 'category.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM category WHERE category_id = $id";
            $result = mysqli_query($con, $query) or die('Category Query Failed');
            $row = mysqli_fetch_assoc($result);
            $title =  $row['category_name'] . ' | ' . 'News';
        } else {
            $title = 'Not Found';
        }
        break;
    case 'single.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM post WHERE post_id = $id";
            $result = mysqli_query($con, $query) or die('Single Query Failed');
            $row = mysqli_fetch_assoc($result);
            $title =  $row['title'];
        } else {
            $title = 'Not Found';
        }
        break;
    case 'author.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM user WHERE user_id = $id";
            $result = mysqli_query($con, $query) or die('Author Query Failed');
            $row = mysqli_fetch_assoc($result);
            $title =  $row['first_name'] . ' ' . $row['last_name'] . ' | ' . 'News';
        } else {
            $title = 'Not Found';
        }
        break;
    case 'search.php';
        if (isset($_GET['search'])) {
            $search_term = $_GET['search'];
            $title = $search_term . ' | ' . 'News';
        } else {
            $title = 'Not Found';
        }
        break;
    default:
        $title = 'News Site';
}
// echo $page_title;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <?php
                $query = "SELECT * FROM settings";

                $result = mysqli_query($con, $query) or die('Query Failed: Read Settings Data');

                ?>
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $logo_img = $row['logo_img'];
                        echo "<a href='index.php'><img id='logo' src='admin/images/$logo_img'></a>";
                    } else {
                        echo "<a href='index.php'><img id='logo' src='admin/images/news.jpg'></a>";
                    }
                    ?>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-11">
                    <ul class='menu'>
                        <?php

                        echo "<li><a href='{$hostname}'>Home</a></li>";

                        $query = "SELECT * FROM category WHERE post > 0";

                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                        }

                        $result = mysqli_query($con, $query) or die('Query Failed');

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                if (isset($id)) {
                                    if ($row['category_id'] == $id) {
                                        $active = 'active';
                                    } else {
                                        $active = '';
                                    }
                                }
                        ?>
                                <li><a class="<?php echo $active ?>" href='category.php?id=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a></li>
                        <?php }
                        } ?>
                    </ul>
                </div>
                <div class="col-md-1">
                    <ul class='menu'>
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (isset($_SESSION['username'])) {
                            echo "<li><a href='admin/post.php'>Admin</a></li>";
                        } else {
                            echo "<li><a href='admin'>Login</a></li>";
                        }

                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->