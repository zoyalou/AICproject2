<?php
    require_once "config.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Saved</title>
    <link rel="stylesheet" href="items.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    try {
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $sth = $dbh->prepare("SELECT * FROM items ORDER BY id DESC");
        $sth->execute();
        $edit = $sth->fetch(); //max number of ownerships
        $max = $edit['id'];

        if (isset($_SESSION['admin'])) {
            if (isset($_GET['category']) && isset($_GET['name']) && isset($_GET['price']) && filter_var($_GET['price'], FILTER_VALIDATE_INT) && $_GET["price"]>0) {
                if ($_GET['category'] == "boba" || $_GET['category'] == "snack" || $_GET['category'] == "smoothie") {
                    if ($_GET['category'] == "boba") {
                        $itemimage = 'boba-gen.jpg';
                    }
                    if ($_GET['category'] == "snack") {
                        $itemimage = 'togo.jpg';
                    }
                    if ($_GET['category'] == "smoothie") {
                        $itemimage = 'smoothie-gen.jpg';
                    }
                    $max=$max+1;
                    $sth2 = $dbh->prepare("INSERT INTO items (id, item_name, price, item_image) VALUES ( :max, :name, :price, :image)");
                    $sth2->bindValue(":name", $_GET["name"]);
                    $sth2->bindValue(":price", $_GET["price"]);
                    $sth2->bindValue(":max", $max);
                    $sth2->bindValue(":image", $itemimage);
                    if ($sth2->execute()) {
                        echo "<h2>Item List Updated!</h2>";
                    }
                    $newitems = $sth2->fetch();
                }
            }
            else {
                echo "<p>Invalid Input</p>";
            }

            echo "<a href='adminstore.php'>Return to edit page</a>";
            echo "<a id='logoutbutton' href='logout.php'>Logout</a>";
        }
        else {
            header("Location: adminlogin.php");
        }    
    }
    catch (PDOException $e) {
        echo "<p>Error connecting to database!</p>";
    }
    ?>
</body>
</html>
