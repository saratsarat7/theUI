function process_rule(value) {
    // var value = document.getElementById(id).value;
    // document.getElementById('test').value=value;
    // document.write(value);
    var parse_json = null;
    var parse_error = null;
    try {
        var parse_json = PARSER.parse(value);
    } catch (e) {
        if (e.location !== undefined) {
            var parse_error = "Line " + e.location.start.line + ", column " + e.location.start.column + ": " + e.message;
        } else {
            var parse_error = e.message;
        }
    }
    if (parse_error != null) {
        document.getElementById("parse_json").innerHTML = parse_error;
        document.getElementById("error_switch").value = "Y";
    } else {
        document.getElementById("parse_json").innerHTML = parse_json;
        document.getElementById("error_switch").value = "N";
    }
}

function process_json() {
    var json_error = null;
    var json_htlm = null;

    var json_error = document.getElementById("error_switch").value;
    if (json_error == "Y") {
        window.alert("Please fix the errors and then create rule file");
    } else {
        json_htlm = JSON.parse(document.getElementById("parse_json").innerHTML);
        create_rule (json_htlm);
    }
}

function create_rule(json_rule) {
    var json_cond = json_rule.condition;
    var json_out  = json_rule.output;
    var rule = "";
    // Looping through rules
    for(var i = 0; i < json_cond.length; i++) {
        var obj = json_cond[i];
        rule = rule.concat("?",obj[0],"=",obj[1]);
    }
    // Looping through outputs
    for(var i = 0; i < json_out.length; i++) {
        var obj = json_out[i];
        rule = rule.concat(".",obj[0],"=",obj[1]);
    }
    document.getElementById("rule_out").innerHTML = rule;
    return rule;
}

function download() {
    var filename = "rules.dsg";
    var text = document.getElementById("rule_out").innerHTML;
    var error = document.getElementById("error_switch").value;

    if (error == "Y") {
        window.alert("Cant download there is an eroor or rule is empty.");
    } else {
        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    }
}

function insert_db(rule_inp) {
    // var rule_inp = document.getElementById("rule").value;
    var peg_out = document.getElementById("parse_json").innerHTML;
    var dsg_out = document.getElementById("rule_out").innerHTML;
    var error = document.getElementById("error_switch").value;

    if (error == "Y") {
        window.alert("There is an error, cant insert to DB.");
    } else {
        $.post("db_operation.php",
        {
            rule: rule_inp,
            peg: peg_out,
            dsg: dsg_out
        },
        function(data, status){
            if (status == "success") {
                window.alert("Rule Added Successfully");
                location.reload();
            }
            // document.getElementById("error_msg").innerHTML = status;
            // window.alert("Data: " + data + "\nStatus: " + status);
        });
    }
}

function load_rules() {
    var rules_json = JSON.parse(document.getElementById("rules_json").innerHTML);
    var old_rules = document.getElementById("old_rules");

    for (var i in rules_json) {
        var div = document.createElement("div");
        div.id = rules_json[i].rule_id;
        var input = document.createElement("input");
        input.type = "text"; 
        input.value = rules_json[i].rule_plain;
        input.style.width = rules_json[i].rule_plain.length * 7;
        div.appendChild(input);
        var br = document.createElement("br");
        div.appendChild(br);
        old_rules.appendChild(div);
    }
}