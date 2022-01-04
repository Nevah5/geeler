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
  <div id="langs">
    <a <?= $lang != "en" ? "href=\"?lang=en\"" : "" ?> <?= $lang == "en" ? "id=\"selected\"" : "" ?>>EN</a>
    <a <?= $lang != "de" ? "href=\"?lang=de\"" : "" ?> <?= $lang == "de" ? "id=\"selected\"" : "" ?>>DE</a>
  </div>
  <?php
    if(isset($lang) && in_array($lang, $langs)){
  ?>
  <div id="compile">
    <a href='compile.php?input=home.php&lang=<?= $lang ?>&output=index.php'>Home</a>
    <a href='compile.php?input=login.php&lang=<?= $lang ?>&output=login/index.php'>Login</a>
    <a href='compile.php?input=register.php&lang=<?= $lang ?>&output=register/index.php'>Register</a>
    <a href='compile.php?input=register_success.php&lang=<?= $lang ?>&output=register/success/index.php'>Register/Success</a>
    <a href='compile.php?input=401.php&lang=<?= $lang ?>&output=401/index.php'>401</a>
    <a href='compile.php?input=403.php&lang=<?= $lang ?>&output=403/index.php'>403</a>
    <a href='compile.php?input=404.php&lang=<?= $lang ?>&output=404/index.php'>404</a>
    <a href='compile.php?input=410.php&lang=<?= $lang ?>&output=410/index.php'>410</a>
  </div>
  <?php
      $types = mysqli_query($con, "SELECT DISTINCT type FROM lang WHERE lang='$lang'");
      foreach($types as $value){
        $type = $value["type"];
        echo "<div>";
        $togglehref = $_GET["section"] != $type ? "?lang=".$lang."&section=".$type : "?lang=".$lang;
        $togglearrow = $_GET["section"] != $type ? "🔼" : "🔽";
        echo "<h1>".strtoupper($type)." <a href=\"$togglehref\">$togglearrow</a></h1>";
        if($_GET["section"] == $type){
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