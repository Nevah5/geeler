<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../../../media/scripts/autologin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/media/icons/logo.png">
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