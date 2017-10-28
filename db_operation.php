<?php
require 'Includes/db_connect.php';

function get_rule_max ($conn) {
    $sql = "SELECT `rule_id` from rule_table where `rule_id` = (SELECT max(`rule_id`) FROM rule_table)" ;
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 0) {
        return 0;
    } else {
        $row = mysqli_fetch_array($result);
        return $row['rule_id'];
    }
}

if(isset($_POST["rule"]) || isset($_POST["peg"]) || isset($_POST["dsg"])) {
    $rule       = $_POST["rule"];
    $peg        = $_POST["peg"];
    $dsg        = $_POST["dsg"];

    echo $rule;

    $conn = new mysqli(HOST,USER,PASS,DB);
    if ($conn->connect_error) {
        die("SQL Connection failed: " . $conn->connect_error);
    }

    $rule_id = get_rule_max($conn) + 1;

    $sql = "INSERT INTO `rule_table` (`rule_id`, `rule_plain`, `rule_peg`, `rule_dsg`) VALUES ('$rule_id', '$rule', '$peg', '$dsg')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    exit();
}
?>