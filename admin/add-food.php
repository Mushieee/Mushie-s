<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">        
        <h1>Add Food</h1>

        <br>

        <?php 
        
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <form action = "" method = "POST" enctype = "multipart/form-data">
            <table class = "tbl-50">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type = "text" name = "title" placeholder = "Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name = "description" cols = "30" rows = "5" placeholder = "Description of the Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type = "number" name = "price">
                    </td>
                </tr>

                <tr>
                    <td>Image: </td>
                    <td>
                        <input type = "file" name = "image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name = "category" >
                            
                            <?php 
                                // Create PHP code to display the Categories from Database
                                // 1. Create SQL to get all the active categories from Database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                // Executing Query
                                $res = mysqli_query($conn, $sql);

                                // Count Rows to Check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                // If count is greater the zero, then we have categories else, we do not have categories
                                if($count > 0)
                                {
                                    // We have Category
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        // Get the details of Categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>

                                        <option value = "<?php echo $id; ?>"><?php echo $title; ?></option>

                                         <?php
                                    }
                                }
                                else
                                {
                                    // We do not have Category
                                    ?>
                                       <option value = "0">No Category Found</option>
                                    <?php
                                }

                                // 2. Display on Dropdown
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type = "radio" name = "featured" value = "Yes"> Yes
                        <input type = "radio" name = "featured" value = "No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type = "radio" name = "active" value = "Yes"> Yes
                        <input type = "radio" name = "active" value = "No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <input type= "submit" name = "submit" value = "Add Food" class = "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
    
            // Check whether the button is Clicked or not
            if(isset($_POST['submit']))
            {
                // Add the food in DataBase
                // echo "Button Clicked";

                // 1. Get the data from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                // Check whether radio button featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    // Setting the Default Value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    // Setting the Default Value
                    $active = "No";
                }

                // 2. Upload the Image if selected
                // Check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    // Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // Check whether the Image is selected or not and upload image only if selected
                    if($image_name != "")
                    {
                        // Image is selected already
                        // A. Rename the Image
                        // Get the extension of the selected image (jpg, png, gif, etc.) "Dave-Camato.jpg" Dave-Camato jpg
                        $temp = explode('.', $image_name);
                        $ext = end($temp);
                        
                        // Create New Name for Image
                        // New Image Name may be "Food-Name-657.jpg"
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        // B. Upload the Image
                        // Get the Source Path and the Destination Path

                        // Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        // Destination path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        // Finally, upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        // Check whether the image is uploaded or not
                        if($upload == false)
                        {
                            // Failed to upload the image
                            // Redirect to Add Food Page with error message
                            $_SESSION['upload'] = "<div class = 'error'>Failed to Upload Image. </div>";
                            header('location:'.SITEURL.'admin/add-food.php');

                            // Stop the process
                            die();
                        }
                    }
                }
                else
                {
                    // Setting Default Value as blank
                    $image_name = "No";
                }

                // 3. Insert into Database
                // Create a SQL Query to Save or Add food
                // For Numerical Value, no need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                 ";

                // Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether the data is inserted or not
                
                // 4. Redirect with message to Manage Food Page
                if($res2 == true)
                {
                    // Means data inserted successfully
                    $_SESSION['add'] = "<div class = 'success'>Food Added Successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    // Failed to insert data
                    $_SESSION['add'] = "<div class = 'error'>Failed to Add Food. </div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>