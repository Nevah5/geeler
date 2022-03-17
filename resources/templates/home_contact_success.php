<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'f!ch#zen0!ac9#5Acr=7', "ubibudud_geeler");
  include("../../../resources/scripts/autologin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/resources/icons/logo.png">
  <title>${register_success.title}</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <div class="info"><div class="content">
    <span>${home.contact.form.success}</span>
  </div></div>
  ${footer}
</body>
</html>
<?php
mysqli_close($con);