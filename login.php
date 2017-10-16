<?php
require 'Includes/db_connect.php';
if(isset($_POST["username"]) || isset($_POST["password"])) {
    $username       = $_POST["username"];
    $password       = $_POST["password"];

    $conn = new mysqli(HOST,USER,PASS,DB);
    if ($conn->connect_error) {
        die("SQL Connection failed: " . $conn->connect_error);
    }
    // SELECT `username` FROM `admin_table` WHERE `username` = 'Sarat'
    $sql = "SELECT username, password FROM admin_table WHERE username = '$username'";
    // $result = $conn->query($sql);
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 0) {
        echo "Invalid User ID";
    } else {
        $row = mysqli_fetch_array($result);
        $reg_pass = $row['password'];
        if ($reg_pass != $password) {
            echo "Invalid Password";
        } else {
            // echo "header("rules.php")";
            echo "<a href='rules.php' id=home>Rules Page</a>";
        }
    }
    exit();
}
?>

<html>
    <head>
        <title>Admin Login</title>
		<link rel="stylesheet" type="text/css" href="CSS/layout_login.css">
    </head>
    <body>
        <a href="index.php" id=home>DECENG Home</a><br/><br/>
        <form action="<?php $_PHP_SELF ?>" method="POST">
            <table>
                <tr class=plain_text>
                    <td>
                        Enter Username:
                    </td>
                    <td>
                        <input type="text" name="username" required="required" />
                    </td>
                </tr>
                <tr class=plain_text>
                    <td>
                        Enter Password:
                    </td>
                    <td>
                        <input type="password" name="password" required="required" />
                    </td>
                </tr>
            </table>
           <input class=button type="submit" value="Login"/>
        </form>
    </body>
</html>