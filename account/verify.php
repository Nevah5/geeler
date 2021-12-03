<?php 
    session_start();
?>

<html>
    <head>
        <title>Account - geeler.net</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="responsive.css">
        <link rel="stylesheet" href="design.css">
        <link rel="stylesheet" href="interactive.css">
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
            <?php
                if(!isset($_GET['email'])){
                    header("Location: ../404");
                }else if(!isset($_GET['hash'])){
                    header("Location: ../404");
                }
                include("../database.inc.php");

                $email = $_GET['email'];
                $hash = $_GET['hash'];

                // Create connection
                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                // Check connection
                if(!$conn){
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT Verified FROM users WHERE Email='$email'";
                $result = mysqli_fetch_array($conn->query($sql));

                if ($result['Verified'] == $hash) {
                    echo '<div id="information2"><h1><i class="fa fa-check-circle-o" aria-hidden="true"></i></h1><h3>Verifizierung Erfolgreich!</h3></div>';
                    $sql = "UPDATE users SET Verified='yes' WHERE Email='$email'";
                    mysqli_query($conn, $sql);
                    $err = false;
                }else{
                    echo '<div id="information"><h1><i class="fa fa-times-circle-o" aria-hidden="true"></i></h1><br><h3>Verifizierung Fehlgeschlagen!</h3>';
                    if($result['Verified'] == 'yes'){
                        echo '<p>Du bist bereits verifiziert.</p>';
                    }else{
                        echo '<p>Dies ist nicht der richtige Verifizierungslink!</p>';
                    }
                    echo '</div>';
                    $err = true;
                }
                if(!mysqli_query($conn, $sql)){
                    echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                }
                mysqli_close($conn);
            ?>
        </div>
        <?php include("../media/site/footer.inc.php"); ?>
    </body>
</html>