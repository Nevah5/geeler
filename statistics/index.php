<?php session_start(); ob_start(); 
    include("../database.inc.php");

    include("../account/cookielogin.inc.php");
    include("../account/updatesession.inc.php");
    include("../online.inc.php");
    
    
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
    
    if(isset($_GET['accept'])){
        setcookie("accept", true, time() + (86400 * 30), "/");
    }else if(!isset($_COOKIE['accept'])){
        include("../media/site/cookies.inc.php");
    }
?>
<html>
    <head>
        <title>Statistiken - Geeler.net</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="responsive.css">
        <link rel="stylesheet" href="rankicons.css">
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
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <?php include("../media/site/header.inc.php"); ?>
        <div class="body">
            <div class="statistics">
                <?php 
                $totalusers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE 1"));
                $totallogins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cookielogin WHERE 1"));
                $visits = $totallogins;
                $totalposts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `themes` WHERE type='post'"));
                $totalcomments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `themes` WHERE type='comment'"));
                $totallikes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `themes` WHERE type='like'"));
                $totaldislikes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `themes` WHERE type='dislike'"));
                $totalxp = mysqli_query($conn, "SELECT Experience FROM users WHERE 1");
                $totalwarns = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM themes WHERE NOT warned='0'"));
                $totalbannedusers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE banned='1'"));
                $totalreviews = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM reviews WHERE 1"));
                $totaladmins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE Rank='admin'"));
                $totalmods = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE Rank='mod'"));
                $totalverified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE Rank='verified'"));
                $xp = 0;
                foreach($totalxp as $key => $data){
                    $xp += $data['Experience'];
                }
                ?>
                <h1>Statistiken [Forum]</h1>
                <span>Registrierte Benutzer: <?= $totalusers ?></span><br>
                <span>Logins: <?= $totallogins ?></span><br>
                <span>Anzahl Posts: <?= $totalposts ?></span><br>
                <span>Anzahl Kommentare: <?= $totalcomments ?></span><br>
                <span>Anzahl Likes: <?= $totallikes ?></span><br>
                <span>Anzahl Dislikes: <?= $totaldislikes ?></span><br>
                <span>Anzahl Erfahrungspunkte: <?= $xp ?></span><br>
                <span>Warnungen: <?= $totalwarns ?></span><br>
                <span>Gebannte Benutzer: <?= $totalbannedusers ?></span><br>
                <span>Anzahl Rückmeldungen: <?= $totalreviews ?></span><br>
                <br>
                <span>Administratoren: <?= $totaladmins ?></span><br>
                <span>Moderatoren: <?= $totalmods ?></span><br>
                <span>Verifizierte Benutzer: <?= $totalverified ?></span><br>
                <br>
                <br>
                <h1><b>Statistiken [Projekt]</b></h1>
                <span>Zeitaufwand: 235h+</span><br>
                <span>Zeilen HTML & PHP: 4215</span><br>
                <span>Zeilen CSS: 9022</span><br>
                <span>Total: 13237</span><br>
                <span>Anzahl PHP Dateien: 36</span><br>
                <span>Anzahl HTML Dateien: 1</span><br>
                <span>Anzahl CSS Dateien: 29</span><br>
            </div>
        </div>
        <?php include("../media/site/footer.inc.php"); ?>
    </body>
</html>
<?php mysqli_close($conn); ?>