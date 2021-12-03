<?php 
    session_start();
    ob_start();

    include("cookielogin.inc.php");
    include("updatesession.inc.php");
    include("../online.inc.php");

    
    include("../database.inc.php");

    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

    if(isset($_SESSION['login'])){
        $id = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $sql = "SELECT Username, ID FROM users WHERE ID='$id' AND Username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            header("Location: account/logout.php?accountdeleted");
        }
    }
    
    mysqli_close($conn);
    if(isset($_GET['accept'])){
        setcookie("accept", true, time() + (86400 * 30), "/");
    }else if(!isset($_COOKIE['accept'])){
        include("media/site/cookies.inc.php");
    }
?>

<html>
    <head>
        <title>Account - Geeler.net</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="responsive.css">
        <link rel="stylesheet" href="design.css">
        <link rel="stylesheet" href="interactive.css">
        <link rel="stylesheet" href="../media/labels/labels.css">
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
            <?php if(!isset($_SESSION["username"])){ ?>
            <?php if(isset($_GET['newusername'])){ 
                $_POST['username'] = $_GET['newusername'];
            } ?>
            <div class="flex-container">
                <!-- LOGIN -->
                <div class="login">
                    <h1>Einloggen</h1><br>
                    <?php 
                        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                        if(!$conn){
                            die("Connection failed: " . mysqli_connect_error());
                        }
                
                        $sql = "SELECT login FROM admin WHERE ID='1' AND login=true";
                        $result = mysqli_fetch_array($conn->query($sql));
                
                        if ($result["login"]) {
                            $login = true;
                        }else{
                            $login = false;
                        }
                        if(!mysqli_query($conn, $sql)){
                            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                        }
                        mysqli_close($conn);
                        if($login == true){
                    ?>
                    <form action="?l" method="post">
                        <!-- USERNAME: -->
                        <input type="text" size="40" maxlength="250" name="username" placeholder="Benutzername" value="<?php echo $_POST["username"] ?>"><br>
                        <?php
                            if(isset($_GET["l"])){
                                $err = false;
                                if (empty($_POST["username"])) {
                                    echo '<p id="error">Bitte gib einen Benutzername an.</p>';
                                    $err = true;
                                }else{
                                    $username = $_POST["username"];

                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

                                    if(!$conn){
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    $sql = "SELECT Username FROM users WHERE Username='$username'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $err = false;
                                    }else{
                                        echo '<p id="error">Dieser Benutzer existiert nicht.</p>';
                                        $err = true;
                                    }
                                    if(!mysqli_query($conn, $sql)){
                                        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";

                                    }
                                    mysqli_close($conn);
                                }
                            }
                        ?>

                        <!-- PASSWORD: -->
                        <input type="password" size="40"  maxlength="250" name="password" placeholder="Passwort" value="<?php echo $_POST["password"] ?>"><br>
                        <?php
                            if(isset($_GET["l"])){
                                if(empty($_POST["password"])){
                                    echo '<p id="error">Bitte gib ein Passwort an.</p>';
                                    $err = true;
                                }else{
                                    $username = $_POST["username"];
                                    $password = $_POST["password"];

                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    if(!$conn){
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    $sql = "SELECT Password FROM users WHERE Username='$username'";
                                    $result = mysqli_fetch_array($conn->query($sql));

                                    if (password_verify($password, $result["Password"])) {
                                        $err = false;
                                    }else{
                                        echo '<p id="error">Das angegebene Passwort ist falsch.</p>';
                                        $err = true;
                                    }
                                    if(!mysqli_query($conn, $sql)){
                                        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";

                                    }
                                    mysqli_close($conn);
                                }
                            }
                        ?>

                        <input type="submit" value="Einloggen">

                        <!-- PHP zum Login -->
                        <?php
                            if(isset($_GET["l"])){
                                if($err == false){
                                    $username = $_POST["username"];
                                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    if(!$conn){
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    $sql = "SELECT Verified, Email, Banned FROM users WHERE Username='$username'";
                                    $update_ip = "UPDATE users SET last_IP='$ip' WHERE Username='$username'";
                                    $result = mysqli_fetch_array($conn->query($sql));
                                    mysqli_query($conn, $update_ip);
                                    $dbid = "SELECT * FROM users WHERE Username='$username'";
                                    $iddb = mysqli_fetch_array($conn->query($dbid));
                                    $autoverify = mysqli_fetch_array(mysqli_query($conn, "SELECT autoverify FROM admin WHERE ID='1'"));
                                    if($result["Banned"] == 1){
                                        echo '<p id="error">Du wurdest von geeler.net gesperrt.</p>';
                                        $err = true;
                                    }else if ($result["Verified"] == 'yes' OR $autoverify['autoverify'] == true) {
                                        $err = false;
                                        $email = $result['Email'];
                                    }else{
                                        echo '<p id="error">Dir wurde eine Verifizierungsemail gesendet. Bitte bestätige diese bevor du dich einloggen kannst.</p>';
                                        $err = true;
                                    }
                                    if(!mysqli_query($conn, $sql)){
                                        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";

                                    }
                                    mysqli_close($conn);
                                }

                                if($err == false){
                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    $_SESSION['username'] = $username;
                                    $_SESSION['email'] = $email;
                                    $_SESSION['login'] = true;
                                    $_SESSION['userid'] = $iddb['ID'];
                                    $_SESSION['rank'] = $iddb['Rank'];
                                    $_SESSION['Changed_Username'] = $iddb['Changed_Username'];
                                    $userid = $iddb['ID'];
                                    $cookielogin = md5(rand(0, 99999));
                                    setcookie("cookielogin", $cookielogin, time() + (84000 * 7), "/");
                                    setcookie("cookieusrid", "$userid", time() + (84000 * 7), "/");
                                    $sql_savecookie = "INSERT INTO cookielogin(token, IP, userID) VALUES ('$cookielogin', '$ip', '$userid')";
                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    $conn->query($sql_savecookie);
                                    
                                    mysqli_close($conn);
                                    header("Location: ../../");
                                }
                            }
                        ?>
                    </form>
                    <?php }else{?>
                        <p id="error">Das Einloggen wurde tempörär von einem Administrator ausgeschaltet. Bitte komme später zurück.</p>
                    <?php }?>
                </div>


                <!-- REGISTER -->
                <div class="register">
                    <h1>Registrieren</h1><br>
                    <?php 
                        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                        if(!$conn){
                            die("Connection failed: " . mysqli_connect_error());
                        }
                
                        $sql = "SELECT registration FROM admin WHERE ID='1' AND registration=true";
                        $result = mysqli_fetch_array($conn->query($sql));
                
                        if ($result["registration"]) {
                            $registration = true;
                        }else{
                            $registration = false;
                        }
                        if(!mysqli_query($conn, $sql)){
                            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                        }
                        mysqli_close($conn);
                        if($registration == true){
                    ?>
                    <form action="?r" method="post">
                        <!-- EMAIL: -->
                        <input type="email" size="40" maxlength="36" name="email" placeholder="Email" value="<?php echo $_POST["email"] ?>"><br>
                        <?php 
                            if(isset($_GET["r"])){
                                $err = false;
                                if(!empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                                    echo '<p id="error">Die angegebene Email ist nicht gültig.</p>';
                                    $err = true;
                                }else if(empty($_POST["email"])){
                                    echo '<p id="error">Bitte gebe eine Email an.</p>';
                                    $err = true;
                                }else if ($err == false){
                                    $email = $_POST["email"];

                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    if(!$conn){
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    $sql = "SELECT Email FROM users WHERE Email='$email'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        echo '<p id="error">Diese Email Adresse wurde bereits registriert.</p>';
                                        $err = true;
                                    }
                                    if(!mysqli_query($conn, $sql)){
                                        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";

                                    }
                                    mysqli_close($conn);
                                }
                            }
                        ?>
                        
                        <!-- USERNAME: -->
                        <input type="text" size="40" maxlength="40" name="username" placeholder="Benutzername" value="<?php echo $_POST["username"] ?>"><br>
                        <?php
                            if(isset($_GET["r"])){
                                $username = $_POST["username"];
                                if(strlen($username) > 40){
                                    echo '<p id="error">Dein Benutzername darf maximal 40 Zeichen lange sein!</p>';
                                    $err = true;
                                }
                                //a-z, A-Z, 0-9, _, min. 8 Zeichen /^[\w\d\s]{8,}$/
                                if (empty($username)) {
                                    echo '<p id="error">Bitte gib einen Benutzername an. [a-Z, A-Z, 0-9, "_"]</p>';
                                    $err = true;
                                }

                                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                if(!$conn){
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                $sql = "SELECT Username FROM users WHERE Username='$username'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<p id="error">Dieser Benutzername wurde bereits registriert.</p>';
                                    $err = true;
                                }
                                if(!mysqli_query($conn, $sql)){
                                    echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";

                                }
                                mysqli_close($conn);
                            }
                        ?>

                        <!-- PASSWORD: -->
                        <input type="password" size="40"  maxlength="250" name="password" placeholder="Passwort" value="<?php echo $_POST["password"] ?>"><br>
                        <input type="password" size="40" maxlength="250" name="password2" placeholder="Passwort wiederholen"><br>
                        <?php 
                            if(isset($_GET["r"])){
                                //a-z, A-Z, 0-9, _, min. 8 Zeichen /^[\w\d\s]{8,}$/
                                if (!empty($_POST["password"]) && !preg_match("/^.{8,}$/",$_POST["password"])) {
                                    echo '<p id="error">Dein Passwort muss mindestens 8 Zeichen beinhalten.</p>';
                                    $err = true;
                                }if ($_POST["password"] != $_POST["password2"]) {
                                    echo '<p id="error">Deine Passwörter müssen übereinstimmen.</p>';
                                    $err = true;
                                }if(empty($_POST["password"])){
                                    echo '<p id="error">Bitte gib ein Passwort an.</p>';
                                    $err = true;
                                }
                            }
                        ?>

                        <input type="submit" value="Registrieren">

                        <!-- PHP zur Registration: -->
                        <?php
                            if(isset($_GET["r"])){
                                $username = $_POST["username"];
                                $email = $_POST["email"];
                                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                                $hash = md5(rand(0,99999));
                                $userid = dechex(time() * rand(0, 9999999));
                                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                
                                if(spam_check($ip)){
                                    echo '<p id="error">Du darfst dich nicht mehr registrieren!</p>';
                                    $err == true;
                                }else if($err == false){
                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    if(!$conn){
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    $sql = "INSERT INTO users (ID, Username, Email, Password, Verified, last_IP)
                                    VALUES ('" . $userid . "', '" . $username . "', '" . $email ."', '" . $password . "', '" . $hash ."', '" . $ip . "')";

                                    if(mysqli_query($conn, $sql)){
                                        $id_sql = "SELECT ID FROM users WHERE Email='$email'";
                                        $d = mysqli_fetch_array($conn->query($id_sql));
                                        $autoverify = mysqli_fetch_array(mysqli_query($conn, "SELECT autoverify FROM admin WHERE ID='1'"));
                                        if($autoverify['autoverify'] == false){
                                            echo '<p id="error">Um den Registrationsprozess abzuschlissen, musst du deinen Account mit der gesendeten Bestätigungsmail aktivieren. (ID: ' . $d['ID'] . ') </p>';
                                        }else{
                                            echo '<p id="error">Dein Account wurde erstellt. Du kannst dich nun einloggen.</p>';
                                        }
                                    }
                                    mysqli_close($conn);
                                }
                            }
                        ?>
                    </form>
                    <?php }else{?>
                        <p id="error">Das Registrieren wurde tempörär von einem Administrator ausgeschaltet. Bitte komme später zurück.</p>
                    <?php }?>
                </div>
            </div>
            <?php }else{ ?>
            <!-- USER SETTINGS -->
            <div class="user_settings">
                <h2>Benutzereinstellungen</h2><?php //get location of pfp
                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                    $userid = $_SESSION['userid'];
                    $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userid'"));
                    $pfp = $data['Avatar'];
                    
                    //Test if File still exists, if not then put in default pic for the user.
                    if(!file_exists("../media/uploads/profiles/" . $pfp)){
                        mysqli_query($conn, "UPDATE users SET Avatar='default.png' WHERE ID='$userid'");
                        $pfp = 'default.png';
                    }
                ?>
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <img src="../media/uploads/profiles/<?= $pfp ?>" id="profileDisplay" class="profileimg2"  alt="">
                    <br><br><label for="profileImage"><i class="fa fa-upload" aria-hidden="true"></i> Bild hochladen</label><input type="file" name="Avatar" id="profileImage" onchange="displayImage(this)"><br>
                    <input type="submit" value="Speichern">
                <?php //ERROR CODES
                    include("upload.inc.php");
                    if(isset($_GET['imguploadfailed'])){
                        if($_GET['imguploadfailed'] == 'size'){
                            echo '<p style="font-weight: 1000;color:#df3333;">Das Bild darf nicht grösser als 5MB sein.</p>';
                        }else if($_GET['imguploadfailed'] == 'type'){
                            echo '<p style="font-weight: 1000;color:#df3333;">Die Datei muss mit ".png" oder ".jpg" enden.</p>';
                        }
                    }
                    mysqli_close($conn);
                ?></form><br>
                <p><span>Account ID:</span> <?php echo $_SESSION['userid']; ?></p>
                <p><span>Benutzername:</span> <?php echo $_SESSION['username']; ?></p>
                <p><span>Email:</span> <?php echo $_SESSION['email']; ?></p>
                <p><span>Letzte IP Adresse:</span> <?php echo $_SERVER['HTTP_X_FORWARDED_FOR']; ?></p>
                <p><span>Rang:</span><?php rankicon($_SESSION['rank'], 3); ?></p><br>
                <a href="../?user=<?= $_SESSION['userid'] ?>">Öffentliches Profil ansehen</a>
            </div>
            <?php if($_SESSION['Changed_Username'] == '0' and $_SESSION['rank'] != 'admin'){ ?>
            <div id="changeusername">
                <h2>Nutzername ändern</h2>
                <?php 
                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                    if(!$conn){
                        die("Connection failed: " . mysqli_connect_error());
                    }
            
                    $sql = "SELECT usernamechanging FROM admin WHERE ID='1' AND usernamechanging=true";
                    $result = mysqli_fetch_array($conn->query($sql));
            
                    if ($result["usernamechanging"]) {
                        $usernamechanging = true;
                    }else{
                        $usernamechanging = false;
                    }
                    if(!mysqli_query($conn, $sql)){
                        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                    }
                    mysqli_close($conn);
                    if($usernamechanging == true){
                ?>
                <p>Bitte beachte: Du kannst deinen Benutzernamen nur <b>EINMAL</b> ändern!<br><br>Wenn du den Benutzernamen änderst, wirst du bei einer fehlerfreien Änderung ausgeloggt.</p>
                <form action="?changeusername" method="post"><input type="text" size="40"  maxlength="250" name="new_username" placeholder="neuer Nutzername"><br>
                    <input type="submit" value="Bestätigen">
                    <?php
                        if(isset($_GET['changeusername'])){
                            if(!empty($_POST["new_username"]) AND strlen($_POST['new_username']) <= 250){
                                $new_username = $_POST["new_username"];
                                $username = $_SESSION['username'];
                                $id = $_SESSION['userid'];

                                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                if(!$conn){
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                $sql = "SELECT Username FROM users WHERE Username='$username'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $sql2 = "UPDATE users SET Username='$new_username', Changed_Username='$username' WHERE Username='$username'";
                                    $_SESSION['username'] = $new_username;
                                    $username = $new_username;
                                    mysqli_query($conn, $sql2);
                                    header("Location: ../account/logout.php?newusername=" . $username);
                                }else{
                                    echo '<script type="text/javascript" language="Javascript"> 
                                    alert("Dieser Nutzername existiert bereits.") 
                                    </script> ';
                                }
                                if(!mysqli_query($conn, $sql)){
                                    echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                                }
                                mysqli_close($conn);
                            }else{
                                header("Location: ../account");
                            }
                        }
                    ?>
                </form>
                <?php }else{?>
                    <p id="error">Das ändern des Benutzernamens wurde von einem Administrator temporär ausgeschaltet.</p>
                <?php }?>
            </div>
            <?php } ?>
            <div id="setdescription">
                <h2>Account-Beschreibung setzen/ändern</h2>
                <form action="?setdescription" method="POST">
                    <textarea maxlength="100" name="description" id="descriptionbox" cols="150" rows="9"></textarea>
                    <input type="submit" name="submit" value="Speichern">
                    <?php 
                        if(isset($_GET['setdescription']) AND strlen($_POST['description']) <= 150){
                            if(empty($_POST['description'])){
                                echo '<p style="font-weight: 1000;color:#df3333;">Bitte gib eine Beschreibung an.</p>';
                            }else if($_POST['description'] == '-LÖSCHEN-'){
                                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                $username = $_SESSION['username'];
                                $userid = $_SESSION['userid'];
                                $savedescription = "UPDATE users SET Description=DEFAULT WHERE Username='$username' AND ID='$userid'";
                                if(!mysqli_query($conn, $savedescription)){
                                    echo mysqli_error($conn);
                                }
                                mysqli_close($conn);
                                header("Location: ../account");
                            }else{
                                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                $username = $_SESSION['username'];
                                $userid = $_SESSION['userid'];
                                $new_description = $_POST['description'];
                                $savedescription = "UPDATE users SET Description='$new_description' WHERE Username='$username' AND ID='$userid'";
                                if(!mysqli_query($conn, $savedescription)){
                                    echo mysqli_error($conn);
                                }
                                mysqli_close($conn);
                                header("Location: ../account");
                            }
                        }
                    ?>
                </form>
                <span>Um die Beschreibung zu löschen, setze die Beschreibung "-LÖSCHEN-".</span>
            </div>
            <div id="pwreset">
                <h2>Passwort Ändern</h2>
                <p>Bitte bestätige im ersten Schritt, indem du dein Passwort eingibst.<br>Folgend bekommst du eine Email, wo du dein Passwort ändern kannst.</p>
                <form action="?resetpassword" method="post"><input type="password" size="40"  maxlength="250" name="password" placeholder="Passwort"><br>
                    <input type="submit" value="Zurücksetzen anfordern">
                    <?php
                        if(isset($_GET['resetpassword'])){
                            if(!empty($_POST["password"])){
                                $username = $_SESSION['username'];
                                $id = $_SESSION['userid'];

                                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                if(!$conn){
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                $sql = "SELECT Password FROM users WHERE Username='$username'";
                                $result = mysqli_fetch_array($conn->query($sql));

                                if (password_verify($_POST['password'], $result["Password"])) {
                                    if($_SESSION['rank'] != 'admin'){
                                        //MAIL SEND
                                        echo '<script type="text/javascript" language="Javascript"> 
                                        alert("Die Email wurde versendet. (Sie wurde nicht versendet.)") 
                                        </script> ';
                                        header("Location: ../account/logout.php");
                                    }else{
                                    echo '<script type="text/javascript" language="Javascript"> 
                                    alert("Du kannst dein Passwort nicht ändern.") 
                                    </script> ';
                                    }
                                }else{
                                    echo '<script type="text/javascript" language="Javascript"> 
                                    alert("Das Passwort ist nicht korrekt. Bitte versuche es erneut.") 
                                    </script> ';
                                }
                                if(!mysqli_query($conn, $sql)){
                                    echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                                }
                                mysqli_close($conn);
                            }else{
                                header("Location: ../account");
                            }
                        }
                    ?>
                </form>
            </div>
            <div id="overlay_background" onclick="delete_overlay(false)" style="display: none;"></div>
            <div class="user">
                <div id="logout" onclick="logout()"><a href="logout.php">Ausloggen</a></div>
                <div id="delete"><a onclick="delete_overlay(true)"><span>Löschen</span></a></div>
                <div id="delete_overlay">
                    <h2>Account löschen?</h2>
                    <p>Bitte bestätige, indem du dein Passwort eingibst.</p>
                    <form action="?delete" method="post"><input type="password" size="40"  maxlength="250" name="password" placeholder="Passwort">
                        <input type="submit" value="Löschen">
                        <a id="close" onclick="delete_overlay(false)">Abbrechen</a></div>
                        <?php
                            if(isset($_GET['delete'])){
                                if(!empty($_POST["password"])){
                                    $username = $_SESSION['username'];
                                    $id = $_SESSION['userid'];

                                    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                                    if(!$conn){
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    $sql = "SELECT Password FROM users WHERE Username='$username'";
                                    $result = mysqli_fetch_array($conn->query($sql));

                                    if (password_verify($_POST['password'], $result["Password"])) {
                                        if($_SESSION['rank'] != 'admin'){
                                            $delete = "DELETE FROM users WHERE Username='$username' AND ID='$id'";
                                            mysqli_query($conn, $delete);
                                            header("Location: ../account/logout.php");
                                        }else{
                                        echo '<script type="text/javascript" language="Javascript"> 
                                        alert("Du kannst deinen Account nicht löschen.") 
                                        </script> ';
                                        }
                                    }else{
                                        echo '<script type="text/javascript" language="Javascript"> 
                                        alert("Das Passwort ist nicht korrekt. Dein Account wurde nicht gelöscht.") 
                                        </script> ';
                                    }
                                    if(!mysqli_query($conn, $sql)){
                                        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                                    }
                                    mysqli_close($conn);
                                }else{
                                    header("Location: ../account");
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php include("../media/site/footer.inc.php"); ?>
    </body>

    <script>
        function delete_overlay(state){
            if(state == true){
                document.getElementById('delete_overlay').style.display = 'inline-block';
                document.getElementById('overlay_background').style.display = 'block';
            }else{
                document.getElementById('overlay_background').style.display = 'none';
                document.getElementById('delete_overlay').style.display = 'none';
            }
        }
        function logout(){
            window.location.replace("https://www.geeler.net/account/logout.php");
        }

        function displayImage(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e){
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>
</html>
<?php
    include("../database.inc.php");

    function spam_check($ip){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM users WHERE last_IP='$ip' AND NOT Verified='yes'";
        $result = $conn->query($sql);

        if ($result->num_rows >= 5) {
            return true;
        }else{
            return false;
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

    //RANK ICON
    function rankicon($rank, $size){
        if($rank == 'admin'){
            if($size == 3){
                echo '<span id="rankicon3_admin">Administrator</span>';
            }else  if($size == 2){
                echo '<span id="rankicon2_admin">Administrator</span>';
            }else{
                echo '<span id="rankicon1_admin">Administrator</span>';
            }
        }else if($rank == 'mod'){
            if($size == 3){
                echo '<span id="rankicon3_mod">Moderator</span>';
            }else  if($size == 2){
                echo '<span id="rankicon2_mod">Moderator</span>';
            }else{
                echo '<span id="rankicon1_mod">Moderator</span>';
            }
        }else if($rank == 'verified'){
            if($size == 3){
                echo '<span id="rankicon3_verified">Verifiziert</span>';
            }else  if($size == 2){
                echo '<span id="rankicon2_verified">Verifiziert</span>';
            }else{
                echo '<span id="rankicon1_verified">Verifiziert</span>';
            }
        }else{
            if($size == 3){
                echo '<span id="rankicon3_default">Standart</span>';
            }else  if($size == 2){
                echo '<span id="rankicon2_default">Standart</span>';
            }else{
                echo '<span id="rankicon1_default">Standart</span>';
            }
        }
    }

    //Edit Password
    function passwordedit() {
        //MAIL SEND
        echo '<p id="error">Dir wurde eine Email für das ändern des Passwords geschickt.</p>';
    }

    function registration_status(){
        include("../database.inc.php");

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT registration FROM admin WHERE ID='1' AND registration=true";
        $result = mysqli_fetch_array($conn->query($sql));

        if ($result["registration"]) {
            echo '<h2 style="color:green;font-weight:1000;">Registration:</h2>';
        }else{
            echo '<h2 style="color:red;font-weight:1000;">Registration:</h2>';
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

?>