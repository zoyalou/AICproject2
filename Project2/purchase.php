<?php
session_start();
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Purchase History</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
  <!-- this is where a customer's past purchases is displayed -->
    <h1>Past Purchases</h1>
    <?php
        try{
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            // we make sure that the customer is logged in before getting the customer id
            if(isset($_SESSION['customer'])){
                $user = $dbh->prepare("SELECT `id` FROM customer WHERE `user_name` = :user"); 
                $user->bindValue(':user', $_SESSION['customer']);
                $user->execute();
                $id= $user->fetch();
                // we make sure that the id exists before taking all of the purchases items of the customer
                if(isset($id['id'])){
                  $sth = $dbh->prepare("SELECT items.item_name, items.price, `topping` FROM items INNER JOIN purchased ON items.id=purchased.item_id WHERE `customer_id` = :id AND `bought` = 'True'"); 
                $sth->bindValue(':id', $id['id']);
                $sth->execute();
                $items= $sth->fetchAll();
                }
                //var_dump($items);
                // here we dipslay all of the customer's purchase items
                echo "<table>";
                if(isset($items)){
                  echo "<th>Item</th>";
                echo "<th>Topping</th>";
                echo "<th>Price</th>";
                foreach($items as $item){
                  echo "<tr>";
            //  echo "<p>"" ".$item['price']."</p>";
              echo "<td>".$item['item_name']."</td>";
              // we check to see which topping they chose
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
                echo "<td>None</td>"; //if not toppins were chosen, then display none
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
    <button type='button' id='logout' class='button' onClick='back()'>Back</button>
</body>
<script>
    function back() {
            window.location.href = 'itemsinstore.php';
    }
    </script>
</html>
