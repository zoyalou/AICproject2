<?php
    require_once "config.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Saved</title>
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
            if (isset($_GET['deleteid']) && filter_var($_GET['deleteid'], FILTER_VALIDATE_INT) && $_GET["deleteid"]>0 && $_GET["deleteid"]<=$max) {
                $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
                $sth1 = $dbh->prepare("SELECT * FROM items");
                $sth1->execute();
                $items = $sth1->fetchAll();

                $sth2 = $dbh->prepare("DELETE FROM items WHERE id=:id");
                $sth2->bindValue(":id", $_GET["deleteid"]);
                if ($sth2->execute()) {
                    echo "<h2>Item List Updated!</h2>";
                }
                $newitems = $sth2->fetch();
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
