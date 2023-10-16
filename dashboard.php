<!DOCTYPE html>
<html lang="eg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
    <title>Dashboard</title>
</head>

<?php
include "databaseConnection.php";
session_start();

if (!isset($_SESSION["username"])){
    header("Location: index.php");
}

    function logout(){
        session_destroy();
        header("Location: index.php");
        exit();
    }

    function pushNewCompany()
    {
        global $conn;
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $companyName = $_POST["companyName"];
            $contactPerson = $_POST["contactPerson"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $createdBy = $_SESSION["username"];
            $msg = "";

            try {
                $stmt = $conn->prepare('INSERT INTO clients (company_name, contact_person, phone, address, created_by) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$companyName, $contactPerson, $phone, $address, $createdBy]);
                $msg = "<p>Client got added to the clients table</p>";


            }catch (PDOException $e) {
                $msg = "<p class='errorMsg'>Query failed: " . $e->getMessage()."</p>";
            }
            echo $msg;
        }
    }

?>
<body>
    <header>
        <h1>Dashboard</h1>
        <div>
            <p>Logged in as <?php echo $_SESSION["username"]; ?></p>

            <form method="post">
                <div>
                    <input type="submit" value="Logout" name="logout">
                </div>
            </form>
        </div>
    </header>

    <main>
        <h2>Add new customers to database</h2>
        <form method="post">
            <div>
                <label for="companyName">Company Name:</label>
                <input type="text" name="companyName" id="companyName">
            </div>
            <div>
                <label for="contactPerson">Contact Person:</label>
                <input type="text" name="contactPerson" id="contactPerson">
            </div>
            <div>
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone">
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" id="address">
            </div>
            <div>
                <input type="submit" value="SUBMIT" name="submit">
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li><a href="clients.php">To customer overview</a></li>
        </ul>
    </nav>

<?php

    if (isset($_POST["logout"])){
        logout();
    }
    elseif (isset($_POST["submit"])){
        pushNewCompany();
    }
?>
</body>
</html>
