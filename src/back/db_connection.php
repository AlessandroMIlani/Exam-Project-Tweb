<?php
try {
    $password = 'sql';
    $username = 'root';
    $dsn= "mysql:dbname=distrodb;host=db:3306";

    $db = new PDO( $dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'connection failed: ' . $e->getMessage();
    die("Errore generico");
}
?>