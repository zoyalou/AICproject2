<html>
<head>
    <title>Drop Store DB</title>
</head>
<body>
<?php
require_once "config.php";
try {
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    //create store table
    $query = file_get_contents('drop.sql');
    $dbh->exec($query);
    echo "<p>Successfully dropped database</p>";
}
catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
}
?>
</body>
</html>