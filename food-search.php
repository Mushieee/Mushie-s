<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php

            // Get the Search Keyword
            $search = $_POST['search'];

            ?>
            <h2 class="text-white">Foods on Your Search <a href="#" class="text-food-search-color">"<?php echo $search; ?>"</a></h2>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class = "food-menu">
        <div class = "container">
            <h2 class = "text-center">Food Menu</h2>

            <?php 
            // Create SQL Query to Get Foods based on search keyword
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count the rows
            $count = mysqli_num_rows($res);

            // Check whether the food is available or not
            if($count > 0)
            {
                // Food is Available
                while($row=mysqli_fetch_assoc($res))
                {
                    // Get the Details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class = "food-menu-box">
                        <div class = "food-menu-img">
                            <?php 
                                // Check whether the image is Available or Not
                                if($image_name == "")
                                {
                                    // Image is not Available
                                    echo "<div class = 'error'>Food is not Available.</div>";
                                }
                                else
                                {
                                    // Image is Available
                                    ?>
                                    <img src = "<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt = "Cheese Pizza" class = "img-responsive img-curve">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class = "food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class = "food-price"><?php echo $price; ?></p>
                            <p class = "food-detail">
                                <?php echo $description; ?>
                            </p>

                            <br>

                            <a href = "<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class = "btn-primary">Order Now</a>
                        </div>
                        <div class = "clearfix"></div>
                    </div>

                    <?php
                }
            }
            else
            {
                // Food is not Available
                echo "<div class = 'error'>Food Not Available.</div>";
            }
            ?>
                     

            <div class = "clearfix"></div>
        </div>
    </section>
    <!-- fOOD Menu Section Ends Here -->

 <?php include('partials-front/footer.php'); ?>
