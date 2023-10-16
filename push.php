<?php

include "editTable.php";

global $conn;

$company_id = $_GET["id"];
$compName = $_POST["CompName"];
$conPer = $_POST["conPer"];
$phone = $_POST["phone"];
$address = $_POST["address"];

$currentTime = date("Y-m-d H:i:s");

try {
    $stmt = $conn->prepare("UPDATE clients 
                                SET company_name = :companyName, contact_person = :conPer, phone = :phone, address = :address, edited_at = :currentTime
                                WHERE company_id = :company_id");

    $stmt->bindParam(':companyName', $compName);
    $stmt->bindParam(':conPer', $conPer);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':currentTime', $currentTime);
    $stmt->bindParam(':company_id', $company_id);

    $stmt->execute();

    header("Location: clients.php");

}catch (PDOException $e){
    echo "<p class='errorMsg'>Query failed: ".$e->getMessage()."</p>";
}