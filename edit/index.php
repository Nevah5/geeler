<?php
session_start();
ob_start();
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
  <link rel="stylesheet" href="style.css">
  <title>Edit home - geeler.net</title>
</head>
<body>
  <form action="./" method="GET">
    <select name="lang" id="lang">
      <option value="" <?= !isset($lang) || empty($lang) ? "selected" : "" ?> disabled hidden>Choose</option>
      <option value="de" <?= $lang == "de" ? "selected" : "" ?>>DE</option>
      <option value="en" <?= $lang == "en" ? "selected" : "" ?>>EN</option>
    </select>
    <input type="submit">
  </form>
  <div>
    <div>
      <a href="/">HOME</a>
      <a href='/compiler/compile.php?input=home.php&lang=en&output=index.php'>Home Index [EN]</a>
      <a href='/compiler/compile.php?input=home.php&lang=de&output=index.php'>Home Index [DE]</a>
    </div>
    <div>
      <a href="/login/">LOGIN</a>
      <a href='/compiler/compile.php?input=login.php&lang=en&output=login/index.php'>Login Index [EN]</a>
      <a href='/compiler/compile.php?input=login.php&lang=de&output=login/index.php'>Login Index [DE]</a>
    </div>
    <div>
      <a href="/register/">REGISTER</a>
      <a href='/compiler/compile.php?input=register.php&lang=en&output=register/index.php'>Register Index [EN]</a>
      <a href='/compiler/compile.php?input=register.php&lang=de&output=register/index.php'>Register Index [DE]</a>
    </div>
  </div>
  <?php
    if(isset($lang) && in_array($lang, $langs)){
      $types = mysqli_query($con, "SELECT DISTINCT type FROM lang WHERE lang='$lang'");
      foreach($types as $value){
        $type = $value["type"];
        echo "<div>";
        echo "<h1>".strtoupper($type)."</h1>";
        $sitedata = mysqli_query($con, "SELECT * FROM lang WHERE lang='$lang' AND type='$type'");
        foreach($sitedata as $value){
          echo "
            <form action=\"./?lang=".$lang ."&id=".$value['ID']."\" method=\"POST\">
              <h3>".$value['title']."</h3>
              <textarea name=\"content".$value['ID']."\" cols=\"30\" rows=\"10\">".htmlspecialchars($value['content'])."</textarea>
              <label for=\"submitbtn".$value['ID']."\" id=\"submitbtn\">Update</label>
              <input type=\"submit\" id=\"submitbtn".$value['ID']."\">
            </form>
          ";
        }
        echo "</div>";
      }
      // print_r($sitedata);
    }
  ?>
  <?php
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $newcontent = $_POST["content$id"];
    if(!empty($newcontent) && mysqli_num_rows(mysqli_query($con, "SELECT ID FROM lang WHERE ID=$id")) == 1){
      mysqli_query($con, "UPDATE lang SET content='$newcontent' WHERE ID=$id");
      header("Location: ./?lang=".$lang);
    }
  }
  ?>
</body>
</html>