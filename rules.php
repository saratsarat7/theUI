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
        <a href="index.php" id=home>DECENG Home</a><br/>
        <form action="<?php $_PHP_SELF ?>" method="POST">
            Enter your rules: <br/>
            <input type="text" name="rule" required="required" id="rule_box"/> <br/> <br/>
            <input type="text" name="test" required="required" id="test"/> <br/> <br/>
            <p id="demo">
            </p>
            <input class=button type="submit" value="Process"/>
        </form>
        <script>
            $(document).ready(function(){
                $("#rule_box").on('keyup paste', function(){
                    process_rule($("#rule_box").val());
                });
            });
        </script>
    </body>
</html>