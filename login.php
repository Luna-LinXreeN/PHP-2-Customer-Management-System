<?php
session_start();
?>
<!DOCTYPE html>
<html lang="eg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
    <title>Login</title>
</head>
<body>
<?php
include 'databaseConnection.php';

function submitForm(){
    $sql = "SELECT name, password FROM users";
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pw = $_POST["password"];
        $username = $_POST["username"];

        try {
            $stmt = $conn->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($pw) && !empty($username)) {
                foreach ($results as $row) {
                    echo $pw. $row["password"];
                    if ($row['name'] == $username && password_verify($pw, $row['password']) ) {
                        $_SESSION["username"] = $username;
                        header("Location: dashboard.php");
                    }
                    else{
                        echo "<p class='errorMsg'>Wrong password or username</p>";
                    }
                }
            }
            else{
                session_destroy();
            }
        } catch (PDOException $e) {
            echo "<p class='errorMsg'>Query failed: " . $e->getMessage()."</p>";
        }
    }
}
?>
    <main>
        <h2>Login</h2>
        <form method="post" action="<?php submitForm(); ?>">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <input type="submit" value="SUBMIT">
            </div>
        </form>
    </main>

    <nav>
        <ul>
            <li><a href="login.php">Go to Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</body>
</html>