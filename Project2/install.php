<html>
<head>
    <title>Install Store DB</title>
</head>
<body>
    <!-- here is where we install our SQL tables -->
<?php
require_once "config.php";
try {
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    //create store table
    $query = file_get_contents('store.sql');
    $dbh->exec($query);
    echo "<p>Successfully installed database</p>";
}
catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
}
?>
</body>
</html>