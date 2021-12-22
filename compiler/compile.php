<?php
session_start();

if(!isset($_GET["input"]) || !isset($_GET["lang"]) || !isset($_GET["output"])){
  header("Location: ../");
}else if(!$_SESSION["login"] && $_SESSION["username"] == "admin"){
  header("Location: ../");
}

$input = "../media/raw/" . $_GET["input"]; //input file with placeholders
$file_replacements = "../media/lang/" . $_GET["lang"] . ".txt"; //placeholders contents to replace
$output = "../" . $_GET["output"]; //output

$replace = [];
//load contents to replace into array
$handle = fopen($file_replacements, "r");
if ($handle) {
    while (($line = fgets($handle)) != false) {
        $replace[explode(":", $line)[0]] = str_replace(array("\n", "\r"), '', explode(":", $line)[1]);
    }
    fclose($handle);
} else {
    echo "Error opening \"$file_replacements\"";
    exit;
}

//replace placeholders
$handle = fopen($input, "r");
$new_content = "";
if ($handle) {
    while (($line = fgets($handle)) != false) {
        if (preg_match('/[${]{1}.+[}]{1}/', $line)) {
            $index = explode('${', explode('}', $line)[0])[1]; //gets ${this}
            $replace_with = $replace[$index]; //gets contents to replace with placeholder
            $line = preg_replace('/[${]{1}.+[}]{1}/', $replace_with, $line); //replaces placeholder
            $new_content .= $line;
        } else {
            $new_content .= $line;
        }
    }
    fclose($handle);
} else {
    echo "Error opening \"$file_replace\"";
    exit;
}

//save compiled file
file_put_contents($output, $new_content);

echo "Done!" . PHP_EOL;
