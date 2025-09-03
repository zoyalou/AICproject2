<?php
session_start();
require_once "config.php";
?>
<html>
<head>
    <title>Store</title>
    <link rel="stylesheet" href="items.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>
<body>
    <!-- this is where customers see all of the items in the store and can order them -->
<?php
    try {
        // we check to see if username and passwod is inputed
    if (isset($_POST['password']) && isset($_POST['username'])) {
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $sth1 = $dbh->prepare("SELECT password FROM customer WHERE :username = user_name");
        $sth1->bindValue(':username', $_POST['username']);
        $sth1->execute();
        $hash = $sth1->fetch();
        // we make sure that the password exists, if not then we take the customer back to login
        if(isset($hash["password"])){
            $passwordhash = $hash["password"];
        }
        else if(!isset($_SESSION['customer'])){
            header("Location: customerlogin.php");
        }
        $password = $_POST['password'];
    }
    else if(!isset($_SESSION['customer'])){
        header("Location: customerlogin.php");
    }
    if(isset($_SESSION['customer'])) {

        // //debug
        // if (password_verify($password, $passwordhash)) {
        //     echo "password correct";
        // }
        // else {
        //     echo "password incorrect";
        //     // header("Location: customerlogin.php");
        // }
?>
<!-- here we create the page with all of the shop item for customers to buy -->
<!-- here is the toppings page which pops up when you order something, it gives the options of 3 toppins as well as for the user to add the item to their cart -->
<div id="toppingpage" class="hide">
        <h1 id="itemname">Item Name</h1>
        <div id="toppingbody">
        <h2>Toppings</h2>
    <table id="toppingtable">
        <tr>
        <td><input type="radio" id="1" name="boba" value="tapioca pearls"  onClick='addtopping(this.id)'>
        <label for="topping1"> Tapioca Pearls</label><br></td>
</tr>
<tr>
        <td><input type="radio" id="2" name="jelly" value="Lychee jelly"  onClick='addtopping(this.id)'>
        <label for="topping2">Lychee Jelly</label><br></td>
</tr>
<tr>
        <td><input type="radio" id="3" name="foam" value="Cheese foam"  onClick='addtopping(this.id)'>
        <label for="topping3"> Cheese Foam</label><br></td>
</tr>
    </table>
        <button type='button' id='back' class='button' onClick='exit()'>Exit</button>
        <button type='button' id='cart' class='button' onClick='addToCart()'>Add to cart</button>
        </div>
    </div>
<?php
// here we take all of the items in the store
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $getitem = $dbh->prepare("SELECT * FROM items");
    $getitem->execute();
    $items = $getitem->fetchAll();
    echo "<div id='header'>";
    echo "<h1>Store</h1>";
    echo "<button type='button'><img class='adminbutton' src='cart-icon.png' alt='cart-button' id='cart-button' onClick='navigateToCart()' /></button>";
    echo "   <a id='history' href='purchase.php'>History</a>";
    echo "</div>";
    echo "<div class='itemset'>";
    foreach($items as $item){//shows the image, name and price of the items in store from the table
        echo"<div class='item'>";
        if(isset($item['item_image'])){
            echo"<img src='" . $item['item_image'] . "' alt='no image' class='image'>";
        }
        if(isset($item['item_name']) && isset($item['price'])){
            echo '<p class="itemname">' . $item['item_name'] . " - $" . $item['price'] . "</p>";
        }
        $itemname = $item['item_name'];
        echo"<button type='button' id='{$item['id']}. {$item['item_name']}.{$item['category']}' class='button' onClick='topping(this.id)'>Order</button><br><br>";
        echo"</div>";
        // echo "<div id='toppingpage' class='hide'>";
        // echo "<h1>Toppings</h1>";
        // echo "<input type='checkbox' id='topping1' name='boba' value='tapioca pearls'><br>";
        // echo "<input type='checkbox' id='topping2' name='jelly' value='Lychee jelly'><br>";
        // echo "<input type='checkbox' id='topping3' name='foam' value='Cheese foam'><br>";
        // echo "<button type='button' id='back' class='button' onClick='exit()'>Exit</button>";
        // echo "<button type='button' id='cart' class='button' onClick='navigateToCart()'>Exit</button>";
        // echo "</div>";
    }
    echo "</div>";
    // echo "<button type='button' id='logout' class='button' onClick='navigateToHomePage()'>Logout</button>";
    ?> 
    <!-- <button type='button' id='cart' class='button' onClick='navigateToCart()'>Go to Cart</button> -->
    <script>
    function topping(name){//lets you add toppings to your item
        toppingid = 0;
        //alert("name=" + name+ " category="+ category);
        itemname = name;
        namesplit = name.split(".");
        itemid= namesplit[0];
        category= namesplit[2];
        if(category == "boba" || category == "smoothie"){
            document.getElementById("itemname").innerHTML = namesplit['1'];
            $(".hide").removeClass("hide").addClass("see");
        }
        else{
            addToCart();
        }
    }
    function exit(){
        $(".see").removeClass("see").addClass("hide");
    }
    function addToCart() {//addes your item and toppings to cart using their id
        if(toppingid > 0 && toppingid <= 3){
            window.location.href = 'addtocart.php?id=' + itemid + "&topping=" + toppingid;
        }
        else if (confirm("Added")) {
            window.location.href = 'addtocart.php?id=' + itemid;
        } 
    }
    function navigateToCart(){
        window.location.href = 'cart.php';
    }
    function navigateToHomePage(){
        window.location.href = 'homepage.php';
    }
    function addtopping(id){
        toppingid = parseInt(id);
    }
    </script>
<?php
        } //we make sure that the password is correct, if not we take the customer back
        else {
        // echo "session not set";
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password']) && isset($_POST['username']) && password_verify($password, $passwordhash)) {
            $_SESSION['customer'] = $_POST['username'];
            // echo "password correct, username set, session set";
            header("Location: itemsinstore.php");
        }
        else {
            header("Location: customerlogin.php");
        }
        }
    }
    catch (PDOException $e) {
        echo "<p>Error connecting to database!</p>";
    }
?>
<a id="logoutbutton" href="logout.php">Logout</a>
</body>
</html>
