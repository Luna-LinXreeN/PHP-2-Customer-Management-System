<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'php_kmu';

global $conn;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div><p class='databaseText'>Connected to Database</p></div>"
} catch (PDOException $e) {
    echo "<div><p class='errorMsg'> No Database connection: " . $e->getMessage()."</p></div>";
}

?>