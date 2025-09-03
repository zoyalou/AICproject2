
<?php
require_once "config.php";
session_start();
?>
<!DOCTYPE html>
<html>
<body>
    <!-- this is the page where items are added to cart -->
    <?php
    try {
        if (isset($_SESSION['customer'])) {


            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            if(isset($_GET['id']) && isset($_SESSION['customer'])){
                $itemid = $_GET['id'];
                // getting the customer id
                $get = $dbh->prepare("SELECT id FROM customer WHERE user_name = :name"); 
                $get->bindValue(":name", $_SESSION['customer']);
                $get->execute();
                $user= $get->fetchAll();
                var_dump($user);
                $userid = $user[0]['id'];
                //echo $userid;
                //if there is a topping, then we add the topping
                if(isset($_GET['topping'])){
                    $toppingid = $_GET['topping'];
                    $sth = $dbh->prepare("INSERT INTO purchased (`customer_id`, `item_id`, `topping`, `bought`) VALUES (:customer, :item, :topping, 'False')"); 
                    $sth->bindValue(":customer", $userid);
                    $sth->bindValue(":item", $itemid);
                    $sth->bindValue(":topping", $toppingid);
                }
                else{ //if no topping
                    $sth = $dbh->prepare("INSERT INTO purchased (`customer_id`, `item_id`, `topping`, `bought`) VALUES (:customer, :item, '0', 'False')"); 
                    $sth->bindValue(":customer", $userid);
                    $sth->bindValue(":item", $itemid);
                }
                $sth->execute();
            echo "<br>Added to cart!<br>";
            echo "<a href='itemsinstore.php'>Back</a>";
            header("Location: itemsinstore.php"); //takes user back to iteminstore immediately
            }
            else{
                header("Location: itemsinstore.php"); 
            }

            
        }
        else {
            header("Location: customerlogin.php"); //if the customer is not signed in, then it takes the customer to the signin page
        }
        // }
    }
    catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
    //   header("Location: itemsinstore.php");
    }
?>
</body>
</html>