<?php
session_start();
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout Page</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
<!-- this it the checkout page, which shows up after you buy items to confirm your purchase -->
    <?php
        try{
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            // here we check to see if the customer is logged in before getting the customer id
            if(isset($_SESSION['customer'])){
                $user = $dbh->prepare("SELECT `id` FROM customer WHERE `user_name` = :user"); 
                $user->bindValue(':user', $_SESSION['customer']);
                $user->execute();
                $id= $user->fetch();
// here we make all of the customer's items are in cart into being bought 
                $buy = $dbh->prepare("UPDATE `purchased` SET `bought` = 'True' WHERE `customer_id` = :id");
                $buy->bindValue(':id', $id['id']);
                $buy->execute();
            }
            else{
                header("Location: homepage.php"); //if customer is not logged in, then take customer away
            }
        }
        catch (PDOException $e) {
            echo "<p>Error: {$e->getMessage()}</p>";
          }
    ?>
    <!-- here we display a message to show that the customer has bought their items -->
    <h1>You have purchased your items</h1>
    <img id = "image" src="download.png" alt="boba"><br>
    <p>Come back again soon</p><br>
    <button type='button' id='logout' class='button' onClick='navigateToHomePage()'>Logout</button>
</body>
<script>
    function navigateToHomePage() {
            window.location.href = 'homepage.php';
    }
    </script>
</html>