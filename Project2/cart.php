<?php
session_start();
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart Page</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
  <!-- this is the cart page, where all items the user added to cart is displayed and can be bought -->
    <h1>Cart</h1>
     <?php
    try {
            if(isset($_SESSION['customer'])){
              // here we select the id of the customer
              $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
              $user = $dbh->prepare("SELECT `id` FROM customer WHERE `user_name` = :user"); 
                $user->bindValue(':user', $_SESSION['customer']);
                $user->execute();
                $id= $user->fetch();
                // we make sure that the id exists before selecting all the user's items that are in the cart and not bought yet
                if(isset($id['id'])){
                  $sth = $dbh->prepare("SELECT items.item_name, items.price, `topping` FROM items INNER JOIN purchased ON items.id=purchased.item_id WHERE `customer_id` = :id AND `bought` = 'False'"); 
                $sth->bindValue(':id', $id['id']);
                $sth->execute();
                $items= $sth->fetchAll();
                }
                //var_dump($items);
                // here we create a table with all of the user's cart items
                echo "<table>";
                if(isset($items)){
                  echo "<th>Item</th>";
                echo "<th>Topping</th>";
                echo "<th>Price</th>";
                foreach($items as $item){// prints out the ordered items and their prices
                  echo "<tr>";
            //  echo "<p>"" ".$item['price']."</p>";
              echo "<td>".$item['item_name']."</td>";
              // here we check to see with topping they chose and then display it
              if($item['topping'] == 1){
                echo "<td>Tapioca Pearls</td>";
              }
              elseif($item['topping'] == 2){
                echo "<td>Lychee Jelly</td>";
              }
              elseif($item['topping'] == 3){
                echo "<td>Cheese Foam</td>";
              }
              else{
                echo "<td>None</td>"; //if no toppings were chosen, then display none
              }
              echo "<td>".$item['price']."</td>";
              echo "</tr>";
                }
            }
            else{
              echo"<td>None</td>";
            }
            echo "</table>";
          }
          else{
              header("Location: homepage.php");
          }
        }  
    catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
    }
?>
<!-- here are some buttons they can click to go back, buy the cart items, or logout -->
   <form action="checkout.php" method="post">
       <div id="cart">
            <br><br>
            <button type='button' id='back' class='button' onClick='navigateToItemPage()'>Back to Items</button>
            <button type='button' id='checkout' class='button' onClick='navigateToCheckout()'>Buy</button><br>
            <button type='button' id='logout' class='button' onClick='navigateToHomePage()'>Logout</button>
            <br><br>
          </div>
    </form>
    <script>
      //Navigates back to certain webpages on button click
    function navigateToCheckout() {
            window.location.href = 'checkout.php';
     }
    function navigateToHomePage() {
            window.location.href = 'homepage.php';
     }
     function navigateToItemPage() {
            window.location.href = 'itemsinstore.php';
     }
    </script>
</body>
</html>