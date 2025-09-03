<?php
    require_once "config.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Store (Admin)</title>
    <link rel="stylesheet" href="items.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>
<body>
    <!-- this is the admin storefront, which has a table of all the the items in the store -->
    <h1 class="title">Store (Admin)</h1>
    <?php
      try {

        if (isset($_POST['password']) && isset($_POST['username'])) {
            // here we make sure that the username is correct and we get the password
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $sth1 = $dbh->prepare("SELECT password FROM admin WHERE :username = user_name");
            $sth1->bindValue(':username', $_POST['username']);
            $sth1->execute();
            $hash = $sth1->fetch();
            if(isset($hash["password"])){
                $passwordhash = $hash["password"];
            }
            else if(!isset($_SESSION['admin'])){
                header("Location: adminlogin.php"); //if not correct then we take the admin back
            }
            $password = $_POST['password'];
        }
        else if(!isset($_SESSION['admin'])){
          header("Location: adminlogin.php"); //if the admin is not in session then we also take the admin back to the login page
        }
        if (isset($_SESSION['admin'])) {
    ?>

    <div id="body">
    <?php
// here we selecta all of the items from the store
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $sth2 = $dbh->prepare("SELECT * FROM items");
        $sth2->execute();
        $items = $sth2->fetchAll();

    ?>
    <!-- forms for editing, deleting, adding items -->
        <div id="form">
        <h2>Edit, Add, or Delete Items in Store: </h2><br>

        <!-- editing -->
        <h3>Edit an Item</h3>
        <form action='editsaved.php' method='get'>
            
            <label for="editid">Choose an item number to edit: </label>
            <select name="editid" required>
            <?php
            // here is a list of all the items 
            foreach ($items as $item) {
                echo "<option value=".$item['id'].">".$item['id']."</option>";
            }
            ?>
            </select>
            <br>
            <label for="name">New Name: </label>
            <input type="text" name="name" required><br>
            <label for="price">New Price: </label>
            <input type="number" name="price" min="1" required>
            <br>

            <input class='save' type='submit' value='Save'>
        </form>
        <br>
        
        <!-- adding an item to the store-->
        <h3>Add an Item</h3>
        <form action='addsaved.php' method='get'>
            <label for="category">Category: </label>
            <select name="category" required>
                <option value="boba">Boba</option>
                <option value="snack">Snack</option>
                <option value="smoothie">Smoothie</option>
            </select><br>
            <label for="name">Name: </label>
            <input type="text" name="name" required><br>
            <label for="price">Price: </label>
            <input type="number" name="price" min="1" required>
            <br>

            <input class='save' type='submit' value='Add Item'>
        </form>
        <br>

        <!-- deleting an item in the store-->
        <h3>Delete an Item</h3>
        <form action='deletesaved.php' method='get'>
            <label for="deleteid">Choose an item number to delete: </label>
            <select name="deleteid" required>
            <?php
            foreach ($items as $item) {
                echo "<option value=".$item['id'].">".$item['id']."</option><br>";
            }
            echo "<br>";
            ?>
            </select><br>
            <input class='save' type='submit' value='Delete'>
        </form>
        
        </div>

    <?php
        // table w item info
        echo "<table id='adminedittable'>";
        echo "<th>Item Number</th>";
        echo "<th>Item Name</th>";
        echo "<th>Item Price</th>";
        foreach ($items as $item) {
            echo "<tr id='item".$item['id']."'>";
            echo "<td>". $item['id'] . "</td>";
            echo "<td>".$item['item_name']."</td>";
            echo "<td>$ ".$item['price']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
    </div>

    <?php
        }
        else {
            // here we make sure that the password is correct before letting the admin in
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password']) && isset($_POST['username']) && password_verify($password, $passwordhash)) {
            $_SESSION['admin'] = $_POST['username'];
            header("Location: adminstore.php");
        }
        else {
            header("Location: adminlogin.php"); //if its not correct, then we take the user back to the login page
        }
        }
    }
    catch (PDOException $e) {
        echo "<p>Error connecting to database!</p>";
    }
    ?>
    <!-- here is the logout button to end the session -->
<a id="logoutbutton" href="logout.php">Logout</a> 
</body>
</html>