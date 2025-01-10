<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
     <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bar Section Starts Here -->
     <section class = "navbar">
        <div class = "container">
            <div class = "logo">
                <a href="index.html" title = "Logo">
                    <img src = "images/logo.png" alt="Restaurant Logo" class = "img-responsive">
                </a>
            </div>

            <div class = "menu text-right">
                <ul>
                    <li>
                        <a href = "<?php echo SITEURL; ?>" class = "underline">Home</a>
                    </li>

                    <li>
                        <a href = "<?php echo SITEURL; ?>categories.php" class = "underline">Categories</a>
                    </li>

                    <li>
                        <a href = "<?php echo SITEURL; ?>foods.php" class = "underline">Foods</a>
                    </li>

                    <li>
                        <a href = "#" class = "underline">Contact</a>
                    </li>
                </ul>
            </div>

            <div class = "clearfix">

            </div>
        </div>
     </section>
    <!-- Navigation Bar Section Ends Here -->