<!DOCTYPE html>
<html lang="eg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
    <title>Customer Overview</title>
</head>
<body>
<?php

include "databaseConnection.php";
session_start();

if (!isset($_SESSION["username"])){
    header("Location: index.php");
}

function showTable()
{
    global $conn;
    $tableString = "";

    try {
        $stmt = $conn->query("SELECT * FROM clients");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tableString .= "<table>
                            <tr>
                                <th>company_id</th>
                                <th>company_name</th>
                                <th>contact_person</th>
                                <th>phone</th>
                                <th>address</th>
                                <th>created_by</th>
                                <th>edited_at</th>
                                <th></th>
                                <th></th>
                            </tr>";
        $rowCount = 0;
        foreach ($results as $row){
            $rowCount++;
            $companyId = $row["company_id"];
            $tableString .= "<tr>";
            $tableString .= "<td id='id$rowCount'>".$row["company_id"]."</td>";
            $tableString .= "<td>".$row["company_name"]."</td>";
            $tableString .= "<td>".$row["contact_person"]."</td>";
            $tableString .= "<td>".$row["phone"]."</td>";
            $tableString .= "<td>".$row["address"]."</td>";
            $tableString .= "<td>".$row["created_by"]."</td>";
            $tableString .= "<td>".$row["edited_at"]."</td>";
            $tableString .= "<td><a href='editTable.php?id=$companyId' class='edit'>edit</a></td>";
            $tableString .= "<td><a href='deleteEntry.php?id=$companyId' class='delete'>delete</a></td>";
            $tableString .= "</tr>";
        }
        $tableString .= "</table>";

    }catch (PDOException $e){
        echo "<p class='errorMsg'>Query failed: ".$e->getMessage()."</p>";
    }
    return $tableString;
}

?>

    <main>
        <h1>Customer Overview</h1>
        <?php echo showTable() ?>
    </main>
    <nav>
        <ul>
            <li><a href="dashboard.php">Back to dashboard</a></li>
        </ul>
    </nav>
</body>
</html>