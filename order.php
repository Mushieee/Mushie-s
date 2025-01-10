<?php include('partials-front/menu.php'); ?>

    <?php 

        // Check whether food id is set or not
        if(isset($_GET['food_id']))
        {
            // Get the food id and the details of the selected food
            $food_id = $_GET['food_id'];

            // Get the Details of the selected food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count the Rows
            $count = mysqli_num_rows($res);

            // Check whether the data is available or not
            if($count == 1)
            {
                // We have Data or Food
                // Get the Data from the Database
                $row = mysqli_fetch_assoc($res);
                
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                // Food is not Available
                // Therefore, Redirect to Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            // Redirect to homepage
            header('location:'.SITEURL);
        }

    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method = "POST" class="order text-white">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                    <?php 

                        // Check whether the image is available or not
                        if($image_name == "")
                        {
                            // Image Not Available
                            echo "<div class = 'error'>Image Not Available.</div>";
                        }
                        else
                        {
                            // Image is Available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Classic Burger" class="img-responsive img-curve food-menu-img-order">
                            <?php
                        }

                    ?>
                    
                    </div>
    
                    <div class="food-menu-desc">
                        <h3 class="food-menu-desc-order"><?php echo $title; ?></h3>
                        <input type = "hidden" name = "food" value = "<?php echo $title; ?>">

                        <p class="food-price food-menu-desc-order">$<?php echo $price; ?></p>
                        <input type = "hidden" name = "price" value = "<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>

                <br><br>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Dave Camato" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@davecamato.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary btn-order">
                </fieldset>

            </form>

            <?php 

                // Check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    // Get all the details from the form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // Total = price x quantity

                    $order_date = date("Y-m-d h:i:sa"); // Order Date

                    $status = "Ordered"; // Ordered, On Delivery, Delivered, Cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];


                    // Save the Order in Database
                    // Create SQL to save the Data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    //echo $sql2;
                    // die();

                    // Now, Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether query executed successfully or not
                    if($res2 == true)
                    {
                        // Query Executed and Order Saved
                        $_SESSION['order'] = "<div class = 'success text-center'>Food Ordered Successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        // Failed to Set Order
                        $_SESSION['order'] = "<div class = 'error text-center'>Failed to Order Food.</div>";
                        header('location:'.SITEURL);
                    }
                }
        
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
