<?php
session_start();
$con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");

if(!isset($_GET["input"]) || !isset($_GET["lang"]) || !isset($_GET["output"])){
  header("Location: ../");
}
if(!$_SESSION["login"] && $_SESSION["username"] == "admin"){
  header("Location: ../");
}

$input = "../resources/templates/" . $_GET["input"]; //input file with placeholders
$lang = strtoupper($_GET["lang"]);
$output = "../" . $_GET["output"]; //output

$replace = [];
//load contents to replace into array from database
$data = mysqli_query($con, "SELECT * FROM lang WHERE lang='$lang'");
foreach($data as $value){
  $replace[$value["type"] . "." . $value["title"]] = $value["content"];
}

//replace placeholders
$handle = fopen($input, "r");
$new_content = "";
if ($handle) {
  while (($line = fgets($handle)) != false) {
    if (preg_match('/[${]{1}.+[}]{1}/', $line)) {
      $index = explode('${', explode('}', $line)[0])[1]; //gets ${this}
      //if footer replace with footer
      if($index == "footer"){
        $replace_with = file_get_contents("../resources/footer/footer.php");
      }else{
        $replace_with = $replace[$index]; //gets contents to replace with placeholder
      }
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

// save compiled file
file_put_contents($output, $new_content);

// $redirect = explode("index.php", $output)[0];
// print_r($replace);
mysqli_close($con);
header("Location: index.php?lang=".$_GET["lang"]);