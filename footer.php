<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
                include 'config.php';

                $query = "SELECT * FROM settings";

                $result = mysqli_query($con, $query) or die('Query Failed: Read Settings Data');
                $row = mysqli_fetch_assoc($result);
                ?>
                <span><?php echo $row['footer_description']?></a></span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
