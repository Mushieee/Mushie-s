<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class = "food-menu">
        <div class = "container">
            <h2 class = "text-center">Food Menu</h2>


            <?php
                // Display Food that are Active
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                // Execute the Query
                $res = mysqli_query($conn, $sql);

                // Count the rows
                $count = mysqli_num_rows($res);

                // Check whether the Food is Available or Not
                if($count > 0)
                {
                    // Foods Are Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // Get the Values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                        <div class = "food-menu-box">
                            <div class = "food-menu-img">
                                <?php 
                                    // Check whether image is available or not
                                    if($image_name == "")
                                    {
                                        // Image is Not Available
                                        echo "<div class = 'error'>Image is Not Available.</div>";
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
                        </div>
                        <?php
                    }
                }
                else
                {
                    // Foods are Not Available
                    echo "<div class = 'error'>Food is not Available.</div>";
                }
            ?>

            <div class = "clearfix"></div>
        </div>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
