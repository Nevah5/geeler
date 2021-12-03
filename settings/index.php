<?php session_start(); ob_start();
    include("../database.inc.php");

    include("../account/cookielogin.inc.php");
    
    //Check for account deletion
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

    if(isset($_SESSION['login'])){
        $id = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $sql = "SELECT Username, ID FROM users WHERE ID='$id' AND Username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            header("Location: ../account/logout.php?accountdeleted");
        }
    }
    
    mysqli_close($conn);
    if(isset($_GET['accept'])){
        setcookie("accept", true, time() + (86400 * 30), "/");
    }else if(!isset($_COOKIE['accept'])){
        include("../media/site/cookies.inc.php");
    }
?>
<html>
    <head>
        <title>Einstellungen - Geeler.net</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="responsive.css">

        <?php //DARKMODE & LIGHTMODE CSS
        if($_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="design.css">
        <?php }else{ ?>
        <link rel="stylesheet" href="design_dark.css">
        <?php } ?>

        <?php //STATIC & MOVING BACKGROUND CSS
        if($_COOKIE['background'] != 'static' AND $_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="../media/site/background.css">
        <?php }else if($_COOKIE['background'] == 'static' AND $_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="../media/site/background_static.css">
        <?php }else if($_COOKIE['background'] == 'static' AND $_COOKIE['theme'] == 'dark'){ ?>
            <link rel="stylesheet" href="../media/site/background_static_dark.css">
        <?php }else{ ?>
            <link rel="stylesheet" href="../media/site/background_dark.css">
        <?php } ?>

        <link rel="icon" href="../media/icon/logo_small_icon.png">
        <script src="https://kit.fontawesome.com/a44080dbce.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include("../media/site/header.inc.php"); ?>
        <div class="body">
            <div id="toggle">
                <h1>Statischer Hintergrund</h1>
                <p>Klicke unten, um den bewegenden Hintergrund auszuschalten. (Auf mobilen Geräten ist diese Funktion permanent an!)</p>
                <a href="?togglebg"><?php if($_COOKIE['background'] != 'static'){ echo 'An'; }else{ echo 'Aus'; } ?></a>
                <?php 
                    if(isset($_GET['togglebg'])){
                        if(!isset($_COOKIE['background'])){
                            setcookie("background", "static", time() + (86400 * 30), "/");
                            header("Location: ../settings");
                        }else{
                            setcookie("background", "", time() - 1, "/");
                            header("Location: ../settings");
                        }
                    }
                ?>
            </div>
            <div id="toggledark">
                <h1>Darkmode</h1>
                <p>Um den Darkmode ein- und auszuschalten, klicke unten.</p>
                <a href="?toggledark"><?php if($_COOKIE['theme'] != 'dark'){ echo 'An'; }else{ echo 'Aus'; } ?></a>
                <?php 
                    if(isset($_GET['toggledark'])){
                        if(!isset($_COOKIE['theme'])){
                            setcookie("theme", "dark", time() + (86400 * 30), "/");
                            header("Location: ../settings");
                        }else{
                            setcookie("theme", "", time() - 1, "/");
                            header("Location: ../settings");
                        }
                    }
                ?>
            </div>
            <?php if($_SESSION['rank'] == 'admin'){ ?>
            <div id="admin">
                <h1>Administration Tools</h1>
                <h3>Get User Verification url:</h3>
                <form action="../account/admin/getuserverification.php" method="GET"><input type="text" name="id" placeholder="ID"><input type="submit" value="Submit"></form>

                <h3>Registrierung:</h3>
                <?php registration_status(); ?>
                <h3>Login:</h3>
                <?php login_status(); ?>
                <h3>Nutzernamen ändern:</h3>
                <?php usernamechange_status(); ?>
                <h3>Wartungsmodus:</h3>
                <?php maintenance_status(); ?>
                <h3>AutoVerify:</h3>
                <?php autoverify_status(); ?>
            </div>
            <?php } ?>
        </div>
        <?php include("../media/site/footer.inc.php"); ?>
    </body>
</html>
<?php 
    function registration_status(){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT registration FROM admin WHERE ID='1' AND registration=true";
        $result = mysqli_fetch_array($conn->query($sql));

        if ($result["registration"]) {
            echo '<a href="https://geeler.net/settings?registration_off"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
        }else{
            echo '<a href="https://geeler.net/settings?registration_on"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

    if(isset($_GET['registration_on']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET registration=true WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }else if(isset($_GET['registration_off']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET registration=false WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }

    function login_status(){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT login FROM admin WHERE ID='1' AND login=true";
        $result = mysqli_fetch_array($conn->query($sql));

        if ($result["login"]) {
            echo '<a href="https://geeler.net/settings?login_off"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
        }else{
            echo '<a href="https://geeler.net/settings?login_on"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

    if(isset($_GET['login_on']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET login=true WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }else if(isset($_GET['login_off']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET login=false WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }

    function usernamechange_status(){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT usernamechanging FROM admin WHERE ID='1' AND usernamechanging=true";
        $result = mysqli_fetch_array($conn->query($sql));

        if ($result["usernamechanging"]) {
            echo '<a href="https://geeler.net/settings?usernamechange_off"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
        }else{
            echo '<a href="https://geeler.net/settings?usernamechange_on"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

    if(isset($_GET['usernamechange_on']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET usernamechanging=true WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }else if(isset($_GET['usernamechange_off']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET usernamechanging=false WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }

    function maintenance_status(){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT maintenance FROM admin WHERE ID='1' AND maintenance=true";
        $result = mysqli_fetch_array($conn->query($sql));

        if ($result["maintenance"]) {
            echo '<a href="https://geeler.net/settings?maintenance_off"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
        }else{
            echo '<a href="https://geeler.net/settings?maintenance_on"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

    if(isset($_GET['maintenance_on']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET maintenance=true WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }else if(isset($_GET['maintenance_off']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET maintenance=false WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }

    function autoverify_status(){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT autoverify FROM admin WHERE ID='1' AND autoverify=true";
        $result = mysqli_fetch_array($conn->query($sql));

        if ($result["autoverify"]) {
            echo '<a href="https://geeler.net/settings?autoverify_off"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
        }else{
            echo '<a href="https://geeler.net/settings?autoverify_on"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }
    if(isset($_GET['autoverify_on']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET autoverify=true WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }else if(isset($_GET['autoverify_off']) and $_SESSION['rank'] == 'admin'){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE admin SET autoverify=false WHERE ID='1'";
        $result = mysqli_fetch_array($conn->query($sql));

        mysqli_close($conn);
        
        header("Location: ../settings");
    }
?>