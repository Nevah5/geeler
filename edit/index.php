<?php
session_start();
$con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
if(!$_SESSION["login"] || $_SESSION["username"] != "admin"){
  header("Location: ../");
}
$langs = ["de", "en"];
$lang = $_GET["lang"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit home - geeler.net</title>
</head>
<body>
  <form action="./" method="GET">
    <select name="lang" id="lang">
      <option value="" <?= !isset($lang) ? "selected" : "" ?> disabled hidden>Choose</option>
      <option value="de" <?= $lang == "de" ? "selected" : "" ?>>DE</option>
      <option value="en" <?= $lang == "en" ? "selected" : "" ?>>EN</option>
    </select>
    <input type="submit">
  </form>
  <?php
    if(isset($lang) && in_array($lang, $langs)){
      $types = mysqli_query($con, "SELECT DISTINCT type FROM lang WHERE lang='$lang'");
      foreach($types as $value){
        $type = $value["type"];
        echo "<h1>$type</h1>";
        $sitedata = mysqli_query($con, "SELECT * FROM lang WHERE lang='$lang' AND type='$type'");
        foreach($sitedata as $key => $value){
          echo "
          <form action=\"./?lang=".$lang ."&id=".$key."\" method=\"POST\">
            <textarea name=\"site\" id=\"site\" cols=\"30\" rows=\"10\">".htmlspecialchars($value['content'])."</textarea>
            <input type=\"submit\">
          </form>
          ";
        }
      }
      // print_r($sitedata);
    }
  ?>
</body>
</html>