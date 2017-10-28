<?php
require 'Includes/db_connect.php';

function random_id ($var_id_len) {
    $a = mt_rand(1,9);
    for ($i = 0; $i<$var_id_len-1; $i++) 
    {
        $a .= mt_rand(1,9);
    }
    return $a;
}

$var_id = "Auto-Generated";

if(isset($_POST["var_name"]) || isset($_POST["var_type"])) {
    $var_name       = strtoupper($_POST["var_name"]);
    $var_type       = strtoupper($_POST["var_type"]);
    $var_type_num   = null;
    $var_id         = null;

    $conn = new mysqli(HOST,USER,PASS,DB);
    if ($conn->connect_error) {
        die("SQL Connection failed: " . $conn->connect_error);
    }

    switch ($var_type) {
        case "INT":
            $var_type_num = 1;
            break;
        case "FLOAT":
            $var_type_num = 2;
            break;
        case "DOUBLE":
            $var_type_num = 3;
            break;
        case "STRING":
            $var_type_num = 4;
            break; 
        case "CHAR":
            $var_type_num = 5;
            break;
        default:
            echo "Invalid Variable Type.";
            exit();
    }


    // Check if the variable name is already in the database.
    $sql = "SELECT var_name FROM vars_table WHERE var_name = '$var_name'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        echo "Variable name alredy exists in the database. <br>";
        exit();
    }

    // Create variable id to load into the table.
    $var_id = random_id(9);
    $sql = "SELECT var_name FROM vars_table WHERE var_id = '$var_id'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    
    while ($num_rows != 0) {
        echo "inside";
        $var_id = random_id(9); 
        $sql = "SELECT var_name FROM vars_table WHERE var_id = '$var_id'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
    }

    $sql = "INSERT INTO `vars_table` (`var_name`, `var_type`, `var_id`) VALUES ('$var_name', '$var_type_num', '$var_id')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully. <br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}
?>

<html>
    <head>
        <title>Rules Engine</title>
        <link rel="stylesheet" type="text/css" href="CSS/layout_vars.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
        </script>
    </head>
    <body>
        <a href="index.php" id="home">DECENG Home</a><br/>
        <form action="<?php $_PHP_SELF ?>" method="POST">
            <table>
                <tr class=plain_text>
                    <td>
                        Enter Variable Name:
                    </td>
                    <td>
                        <input type="text" name="var_name" required="required" />
                    </td>
                </tr>
                <tr class=plain_text>
                    <td>
                        Enter Variable Type:
                    </td>
                    <td>
                        <input type="radio" name="var_type" value="INT" required> INT 
                        <input type="radio" name="var_type" value="FLOAT"> FLOAT 
                        <input type="radio" name="var_type" value="DOUBLE"> DOUBLE 
                        <input type="radio" name="var_type" value="STRING"> STRING 
                        <input type="radio" name="var_type" value="CHAR"> CHAR 
                    </td>
                </tr>
                <tr class=plain_text>
                    <td>
                        Var #ID:
                    </td>
                    <td>
                        <?php echo $var_id; ?>
                    </td>
                </tr>
            </table>
           <input class=button type="submit" value="Create Variable"/>
        </form>
    </body>
</html>