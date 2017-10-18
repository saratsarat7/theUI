<?php
require 'Includes/db_connect.php';
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
        <a href="index.php" id="home">DECENG Home</a><br/>
        <input type="text" name="rule" required="required" id="rule_box"/> <br/><br/>
        <div id="parse_json"> </div> <br/>
        <div id="rule_out"
            style="
            color: green;
            font-family: &quot;Comic Sans MS&quot;, cursive, sans-serif;">
        </div> <br/>
        <button type="button" id="parse_rule">Create Rule File</button>
        <script>
            $(document).ready(function(){
                $("#rule_box").on('keyup paste', function(){
                    process_rule($("#rule_box").val());
                });
                $("#parse_rule").click(process_json);
                $("#rule_out").click(download);
            });
        </script>
    </body>
</html>