<?php

include "clients.php";

function editRow(){
    global $conn;
    $company_id = $_GET['id'];
    $string = "";

    try {
        $stmt = $conn->query("SELECT company_name, contact_person, phone, address, created_by FROM clients WHERE company_id =".$company_id);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $companyName = $result[0]["company_name"];
        $contactPerson = $result[0]["contact_person"];
        $phone = $result[0]["phone"];
        $address = $result[0]["address"];
        $createdBy = $result[0]["created_by"];

        if ($createdBy == $_SESSION["username"]){
            $string = "<main>
                    <form method='post' action='push.php?id=$company_id'>
                        <div>
                            <label for='CompName'>Company Name:</label>
                            <input type='text' name='CompName' id='CompName' value='$companyName'>
                        </div>
                        <div>
                            <label for='conPer'>Contact Person:</label>
                            <input type='text' name='conPer' id='conPer' value='$contactPerson'>
                        </div>
                        <div>
                            <label for='phone'>Phone Number:</label>
                            <input type='text' name='phone' id='phone' value='$phone'>
                        </div>
                        <div>
                            <label for='address'>Address:</label>
                            <input type='text' name='address' id='address' value='$address'>
                        </div>
                        <div>
                            <input type='submit' value='SUBMIT'>
                        </div>
                    </form>
                </main>";
        }
        else{
            echo "<p class='errorMsg'>You are not permitted to edit that</p>";
        }

    }catch (PDOException $e){
        echo "<p class='errorMsg'>Query failed: ".$e->getMessage()."</p>";
    }

    return $string;
}

echo editRow();