<!DOCTYPE html>
<html lang="eg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
    <title>Register</title>
</head>
<body>
<?php
include "databaseConnection.php";

function register()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $mail = $_POST["email"];
        $pw = $_POST["password"];
        $repassword = $_POST["repassword"];
        $msg = "";

        try {
            $stmt = $conn->query("SELECT name FROM users");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($username) && !empty($mail) && !empty($pw) && !empty($repassword)){
                if ($pw == $repassword){
                    foreach ($results as $row){
                        if ($row["name"] == $username){
                            echo "<p class='errorMsg'>Username already exists</p>";
                            exit(100);
                        }
                    }
                    $pw = password_hash($pw, PASSWORD_BCRYPT);

                    $stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
                    $stmt->execute([$username, $mail, $pw]);
                    $msg = "<p>User was created</p>";

                    session_start();
                    $_SESSION["username"] = $username;
                    header("Location: index.php");
                }
                else{
                    $msg = "<p>Passwords do not match</p>";
                }
            }

        } catch (PDOException $e) {
            $msg = "<p class='errorMsg'> Query failed: " . $e->getMessage()."</p>";
        }

        echo $msg;
    }
}

?>
    <main>
        <h2>Register</h2>
        <form method="post" action="<?php register(); ?>">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="email">E-Mail:</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="repassword">Confirm Password:</label>
                <input type="password" name="repassword" id="repassword">
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
