<?php include('partials/menu.php');?>

<div class = "main-content">
    <div class = "wrapper">
        <h1>Change Password</h1>
       
        <br>

        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action = "" method = "POST">
            <table class = "tbl-50">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type = "password" name = "current_password" placeholder = "Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td> 
                        <input type = "password" name = "new_password" placeholder = "New Password">
                    </td>
                </tr>

                <tr> 
                    <td>Confirm Password: </td>
                    <td>
                        <input type = "password" name = "confirm_password" placeholder = "Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                        <input type= "submit" name = "submit" value = "Change Password" class = "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

            // Check whether the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                // echo "Clicked";

                // 1. Get the data from the form
                $id = $_POST['id'];
                $current_password = md5($_POST['current_password']);
                $new_password = md5($_POST['new_password']);
                $confirm_password = md5($_POST['confirm_password']);


                // 2. Check whether the user with current ID and Current Password exists or not
                $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";

                // Execute the Query
                $res = mysqli_query($conn, $sql);

                if($res == true)
                {
                    // Check whether the data is available or not
                    $count = mysqli_num_rows($res);

                    if($count == 1)
                    {
                        // User Exists and Password can be changed
                        // echo "User Found.";

                        // Check whether the new password and confirm password match or not.

                        if($new_password == $confirm_password)
                        {
                            // Update the password
                            // echo "Password Match";

                            $sql2 = "UPDATE tbl_admin SET 
                                password = '$new_password'
                                WHERE id = $id
                            ";

                            // Execute the Query
                            $res2 = mysqli_query($conn, $sql2);

                            // Check whether the query executed or not

                            if($res2 == true)
                            {
                                // Display Success Message
                                // Redirect to Manage Admin Page with Success message
                                $_SESSION['change-pwd'] = "<div class = 'success'>Password Changed Successfully. </div>";

                                // Redirect the user
                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                            else
                            {
                                // Display Error Message
                                // Redirect to Manage Admin Page with Success message
                                $_SESSION['change-pwd'] = "<div class = 'error'>Failed to Change Password. </div>";

                                // Redirect the user
                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                        }
                        else
                        {
                            // Redirect to Manage Admin Page with error message
                            $_SESSION['pwd-not-match'] = "<div class = 'error'>Password did not match. </div>";

                            // Redirect the user
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        // User does not exists set message and redirect
                        $_SESSION['user-not-found'] = "<div class = 'error'>User Not Found. </div>";

                        // Redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                // 3. Check whether the New Password and Confirm Password matched or not

                // 4. Change Password if all above is true
            }

?>

<?php include('partials/footer.php');?>