<?php
require 'Includes/db_connect.php';
if( isset($_POST["username"]) || isset($_POST["password"]) || isset($_POST["re_password"])) {
    $username       = $_POST["username"];
    $password       = $_POST["password"];
    $re_password    = $_POST["re_password"];

    $conn = new mysqli(HOST,USER,PASS,DB);
    if ($conn->connect_error) {
        die("SQL Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO `admin_table` (`username`, `password`) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    exit();
}
?>

<html>  
    <head>
        <title>Register</title>
		<link rel="stylesheet" type="text/css" href="CSS/layout_register.css">
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
                <tr class=plain_text>
                    <td>
                        Re Enter Password:
                    </td>
                    <td>
                        <input type="password" name="re_password" required="required" />
                    </td>
                </tr>
            </table>
           <input class=button type="submit" value="Sign Up"/>
        </form>
    </body>
</html>