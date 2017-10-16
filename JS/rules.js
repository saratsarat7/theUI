function process_rule(value) {
    // var value = document.getElementById(id).value;
    document.getElementById('test').value=value;
    // document.write(value);
    document.getElementById("demo").innerHTML = PARSER.parse(value);
}

function write_file() {
    
}