<?php

include "clients.php";

global $conn;

$company_id = $_GET["id"];

try {
    $stmt = $conn->query("SELECT created_by FROM clients WHERE company_id =" . $company_id);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $createdBy = $result[0]["created_by"];

    if ($createdBy == $_SESSION["username"]) {
        $stmt = $conn->prepare("DELETE FROM clients WHERE company_id = :companyId");
        $stmt->bindParam(":companyId", $company_id);
        $stmt->execute();
        header("Location: clients.php");
    }else{
        echo "<p class='errorMsg'>You are not permitted to delete that</p>";
    }
}catch(PDOException $e){
    echo "<p class='errorMsg'>Query failed: " . $e->getMessage() . "</p>";
}
