<?php 

    // echo "Delete Food Page";
    include('../config/constants.php');

    // Either use 'AND' or '&&'
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        // Process to Delete
        // echo "ID and Image Deleted";

        // 1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. Remove the Image if available
        // Check whether the image is available or not
        if($image_name != "")
        {
            // It has image and need to remove from folder
            $path = "../images/food/".$image_name;

            // Remove Image file from Folder
            $remove = unlink($path);

            // Check whether the image is removed or not
            if($remove == false)
            {
                // Failed to Remove the Image
                $_SESSION['upload'] = "<div class = 'error'>Failed to remove the image file. </div>";

                // Then redirect to Manage Food Page
                header('location:'.SITEURL.'admin/manage-food.php');

                // Finally, stop the process of Deleting Food
                die();
            }
        }
        
        // 3. Delete Food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Check whether the Query executed or not and set the session message respectively
        // 4. Redirect to Manage Food Page with Session Message
        if($res == true)
        {
            // Food has been deleted
            $_SESSION['delete'] = "<div class = 'success'>Food Deleted Successfully. </div>";

            // Then redirect to Manage Food Page
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Failed to delete the image
            $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Food. </div>";

            // Then redirect to Manage Food Page
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        // Redirect to Manage Food Page
        // echo "REDIRECT";
        $_SESSION['unauthorized'] = "<div class = 'error'>Unauthorized Access. </div>";

        // Then redirect to manage-food page
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>