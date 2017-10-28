<?php
require 'Includes/db_connect.php';

function get_vars ($conn) {
    $sql = "SELECT * FROM vars_table";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    $json = null;
    if ($num_rows == 0) {
        echo "No variables defined in the database.";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $results[] = array(
                'var_name' => $row['var_name'],
                'var_type' => $row['var_type'],
                'var_id' => $row['var_id']
            );
        }
        $json = json_encode($results);
    }
    return $json;
}

function get_rules ($conn) {
    $sql = "SELECT * FROM rule_table";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    $json = null;
    if ($num_rows == 0) {
        echo "No rules defined in the database.";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $results[] = array(
                'rule_id' => $row['rule_id'],
                'rule_plain' => $row['rule_plain'],
                'rule_peg' => $row['rule_peg'],
                'rule_dsg' => $row['rule_dsg']
            );
        }
        $json = json_encode($results);
    }
    return $json;
}

$conn = new mysqli(HOST,USER,PASS,DB);
if ($conn->connect_error) {
    die("SQL Connection failed: " . $conn->connect_error);
}
$vars_list  = get_vars($conn);
$rules_list = get_rules($conn);

?>

<html>
    <head>
        <title>Rules Engine</title>
        <link rel="stylesheet" type="text/css" href="CSS/layout_rules.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
        </script>
    </head>
    <body>
        <script type="text/javascript" src="JS/rules.js"></script>
        <script type="text/javascript" src="JS/parser.js"></script>
        <input type="hidden" id="error_switch" value="Y">
        <div id="vars_json" style="display: none;">
            <?php echo $vars_list; ?>
        </div>
        <div id="rules_json" style="display: none;">
            <?php echo $rules_list; ?>
        </div>
        <a href="index.php" id="home">DECENG Home</a><br/>
        <div id="old_rules"> </div>
        <input type="text" name="rule" required="required" id="rule_box"/> <br/><br/>
        <div id="parse_json"> </div> <br/>
        <div id="rule_out"
            style="
            color: green;
            font-family: &quot;Comic Sans MS&quot;, cursive, sans-serif;">
        </div> <br/>
        <button type="button" id="parse_rule">Create Rule File</button> <br/> <br/>
        <div id="error_msg"></div>
        <script>
            $(document).ready(function(){
                load_rules();
                $("#rule_box").on('keyup paste', function(){
                    process_rule($("#rule_box").val());
                });
                $("#parse_rule").click(process_json);
                $("#rule_out").click(function(){
                    insert_db($("#rule_box").val());
                });
            });
        </script>
    </body>
</html>