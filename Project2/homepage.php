<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link rel="stylesheet" href="homepage.css">
    </head>
    <body>
        <!-- this it the homepage of the store, where the user can choose where to login or to create a new account -->
        <h1>Boba Store</h1>
        <div id="links">
            <!-- here they log in as a customer -->
            <div id="customerlogin">
                <a class="login" href="customerlogin.php">Customer Login</a> 
            </div>
            <!-- here is if a customer doesn't have an account -->
            <div id="createacc">
                <a href="newcustomer.php">New? Sign up here!</a>
            </div>
            <!-- here is where admins go to log in -->
            <div id="adminlogin">
                <a class="login" href="adminlogin.php">Admin Login</a>
            </div>
        </div>
        <?php
        // here we check to see if either customer or admin is logged in, in which case we take them directly to the store page 
        if (isset($_SESSION['customer'])) {
          header("Location: customerstore.php");
        }
        if (isset($_SESSION['admin'])) {
            header("Location: admin.php");
          }
     ?>
     <a href="references.html">References</a>
    </body>
</html>