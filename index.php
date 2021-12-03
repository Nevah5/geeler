<?php session_start(); ob_start(); 
    
    include("database.inc.php");

    include("account/cookielogin.inc.php");
    include("account/updatesession.inc.php");
    include("online.inc.php");
    
    
    //Check for account deletion
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
        <title>Home - Geeler.net</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="responsive.css">
        <link rel="stylesheet" href="media/labels/labels.css">
        <?php //DARKMODE & LIGHTMODE CSS
        if($_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="design.css">
        <?php }else{ ?>
        <link rel="stylesheet" href="design_dark.css">
        <?php } ?>

        <?php //STATIC & MOVING BACKGROUND CSS
        if($_COOKIE['background'] != 'static' AND $_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="media/site/background.css">
        <?php }else if($_COOKIE['background'] == 'static' AND $_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="media/site/background_static.css">
        <?php }else if($_COOKIE['background'] == 'static' AND $_COOKIE['theme'] == 'dark'){ ?>
            <link rel="stylesheet" href="media/site/background_static_dark.css">
        <?php }else{ ?>
            <link rel="stylesheet" href="media/site/background_dark.css">
        <?php } ?>
        <link rel="icon" href="media/icon/logo_small_icon.png">
        <script src="https://kit.fontawesome.com/a44080dbce.js" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <?php include("media/site/header.inc.php"); ?>
        <div class="body">
            <?php include("bansystem.inc.php"); ?>
            <?php 
                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                if(!$conn){
                    die("Connection failed: " . mysqli_connect_error());
                }
        
                $sql = "SELECT maintenance FROM admin WHERE ID='1' AND login=true";
                $result = mysqli_fetch_array($conn->query($sql));
                
                if ($result["maintenance"]) {
                    $maintenance = true;
                }else{
                    $maintenance = false;
                }
                if(!mysqli_query($conn, $sql)){
                    echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                }
                mysqli_close($conn);
                if($maintenance == true and $_SESSION['rank'] != 'admin' and $_SESSION['rank'] != 'mod'){
            ?>
            <h3 id="information"><?php if(isset($_SESSION['username'])) { ?>Wilkkommen, <?php echo $_SESSION['username'] . '!'; ?><br><?php } ?>Das Forum ist zurzeit in Wartungen.</h3>
            <?php }else{ ?>
                <?php include("postforms.inc.php") ?>
            <?php if(isset($_GET['success'])){ ?>
            <h1 id="information2">Dein Post wurde erfolgreich gepostet!</h1>
            <?php }else if(isset($_GET['user'])){
                include("userprofile.inc.php");
            }else if(isset($_GET['create']) AND !$_SESSION['login']){ ?>
            <h1 id="information">Du musst eingeloggt sein, um einen Post zu erstellen.</h1>
            <?php }else if(isset($_GET['postid'])){ 
                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                $post_id = $_GET['postid'];
                $query = "SELECT * FROM `themes` WHERE postID='$post_id' AND type='post' AND deleted='0'";
                //test if postid deos not exist, test if theme does not exist
                $result = mysqli_fetch_array($conn->query($query));
                if(mysqli_num_rows(mysqli_query($conn, $query)) == 0){ header("Location: ../"); }
            ?>
            <?php include("viewpost.inc.php"); ?>
            <?php mysqli_close($conn);
            }else if(!isset($_GET['create'])){ ?>
            <div class="home-r">
                <div class="c-list">
                    <h2>Posts erstellen</h2>
                        <ul>    
                            <li><a href="?create=general">Allgemein</a></li>
                            <?php if($_SESSION['rank'] == 'admin'){ ?>
                            <li><a href="?create=updatelog">Updatelog</a></li>
                            <?php } ?>
                            <li><a href="?create=eia">EIA</a></li>
                            <li><a href="?create=hn">Holz & Natur</a></li>
                            <li><a href="?create=gd">Gestaltung & Druck</a></li>
                            <li><a href="?create=mm">Metall & Maschine</a></li>
                            <li><a href="?create=bt">Bau & Technik</a></li>
                        </ul>
                </div>
                <div class="online-users">
                    <?php $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                    //get total 
                    $getonline = mysqli_query($conn, "SELECT * FROM users WHERE last_seen >= (now() - INTERVAL 5 MINUTE) ORDER BY FIELD(Rank, 'admin', 'mod', 'verified', 'default'), ID"); 
                    $ranked = 0; ?>
                    <h2>Aktive Benutzer [<?= mysqli_num_rows($getonline) ?>]</h2>
                    <?php
                    if(mysqli_num_rows($getonline) > 0){
                    foreach($getonline as $key => $data){ 
                        $rank = $data['Rank']; if ($data['Rank'] == 'admin' OR $data['Rank'] == 'mod' OR $data['Rank'] == 'verified'){ $ranked++;?>
                        <a id="user" href="?user=<?= $data['ID'] ?>"><?= $data['Username'] ?></a></b><?php echo rankicon($data['Rank'], 3); ?><br>
                <?php }}}else{
                    echo '<p id="user">Zurzeit sind keine Benutzer online.</p>';
                } mysqli_close($conn); ?>
                    <p id="user">Andere Benutzer [<?= mysqli_num_rows($getonline) - $ranked ?>]</p>
                </div>
            </div>
            <div class="home-l">
                <?php include("themes.inc.php") ?>
            </div>
            <?php } ?>
            
            <?php } ?>
        </div>
        <?php include("media/site/footer.inc.php"); ?>
    </body>
</html>

<?php 
    if(isset($_GET['postid']) AND isset($_GET['like']) AND $_SESSION['login']){ 
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        $post_id = $_GET['postid'];
        $username = $_SESSION['username'];
        $userID = $_SESSION['userid'];
        $rank = $_SESSION['rank'];
        $test = "SELECT * FROM `themes` WHERE userID='$userID' AND postID='$post_id' AND (type='like' OR type='dislike')";
        $result = $conn->query($test);
        if($result->num_rows == 0){
            $save_like = "
                INSERT INTO `themes`(
                    `postID`,
                    `type`,
                    `userID`
                )
                VALUES(
                    '$post_id',
                    'like',
                    '$userID'
                )";
            if(!mysqli_query($conn, $save_like)){
                echo "<p id='error'> Error: " . $save_like . "<br>" . mysqli_error($conn) . "</p>";
            }else{
                likexp();
                opxp('like'); //header in function
            }
        }else{
            header("Location: ../?postid=" . $post_id);
        }

        mysqli_close($conn);
    }else if(isset($_GET['postid']) AND isset($_GET['dislike']) AND $_SESSION['login']){
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        $post_id = $_GET['postid'];
        $username = $_SESSION['username'];
        $userID = $_SESSION['userid'];
        $rank = $_SESSION['rank'];
        $test = "SELECT * FROM `themes` WHERE userID='$userID' AND postID='$post_id' AND (type='like' OR type='dislike')";
        $result = $conn->query($test);
        if($result->num_rows == 0){
            $save_like = "
                INSERT INTO `themes`(
                    `postID`,
                    `type`,
                    `userID`
                )
                VALUES(
                    '$post_id',
                    'dislike',
                    '$userID'
                )";
            if(!mysqli_query($conn, $save_like)){
                echo "<p id='error'> Error: " . $save_like . "<br>" . mysqli_error($conn) . "</p>";
            }else{
                opxp('dislike'); //header in function
            }
        }else{
            
            header("Location: ../?postid=" . $post_id);
        }
    }
    function opxp($type){
        include("database.inc.php");
        
        $post_id = $_GET['postid'];
        
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

        //GET OP ID
        $getpost = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `themes` WHERE postID='$post_id' AND type='post'"));
        $userID_OP = $getpost['userID'];
        //GET OP XP 
        $getOPdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID_OP'"));
        $XPold_OP = $getOPdata['Experience'];

        //UPDATE OP XP
        if($type == 'like'){
            $XPnew_OP = $XPold_OP + 5;
        }else{
            $XPnew_OP = $XPold_OP - 3;
        }
        if(!mysqli_query($conn, "UPDATE users SET Experience='$XPnew_OP' WHERE ID='$userID_OP'")){
            mysqli_error($conn);
        }else{
            header("Location: ../?postid=" . $post_id);
        }

        mysqli_close($conn);
    }
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
        }else if($rank == 'OP'){
            if($size == 3){
                echo '<span id="posticon3_op">OP</span>';
            }else  if($size == 2){
                echo '<span id="posticon2_op">OP</span>';
            }else{
                echo '<span id="posticon1_op">OP</span>';
            }
        }
    }

    function c_theme($title, $description, $theme){
        include("database.inc.php");
        
        if(strlen($title) > 50 OR strlen($title) > 2000){
            echo '<p id="error">Dein Post hat zu viele Zeichen im Titel oder in der Beschreibung...</p>';
        }else{
            $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
            $post_id = dechex(time() * rand(0, 9999999));
            $username = $_SESSION['username'];
            $userID = $_SESSION['userid'];

            $save_post = "
                INSERT INTO `themes`(
                    `postID`,
                    `theme`,
                    `type`,
                    `title`,
                    `contents`,
                    `userID`
                )
                VALUES(
                    '$post_id',
                    '$theme',
                    'post',
                    '$title',
                    '$description',
                    '$userID'
                )";
                
            $lastpost = "SELECT * FROM `themes` WHERE type='post' AND userID='$userID' AND timestamp >= (now() - INTERVAL 15 MINUTE) ORDER BY ID";
            if(mysqli_num_rows(mysqli_query($conn, $lastpost)) == 0 OR $_SESSION['rank'] == 'admin' OR $_SESSION['rank'] == 'mod'){
                if(!mysqli_query($conn, $save_post)){
                    echo "<p id='error'> Error: " . $save_post . "<br>" . mysqli_error($conn) . "</p>";
                }else{

                    //User Stats update
                    $getuserstats = "SELECT Themes_created, Experience FROM users WHERE Username='$username' AND ID='$userID'";
                    $result = mysqli_fetch_array(mysqli_query($conn, $getuserstats));
                    $newstat_themescreated = $result['Themes_created'] + 1;
                    $newstat_experience = $result['Experience'] + 25;
                    $updateuserstats = "UPDATE users SET Themes_created='$newstat_themescreated', Experience='$newstat_experience' WHERE Username='$username' AND ID='$userID'";
                    
                    if(!mysqli_query($conn, $updateuserstats)){
                        echo "<p id='error'> Error: " . $save_post . "<br>" . mysqli_error($conn) . "</p>";
                    }
                    header("Location: ?success");
                }
            }else{
                header("../?postid=" . $post_id);
                echo '<p id="error">Bitte warte mindestens 15 Minuten zwischen jedem Post.</p>';
            }
            
            mysqli_close($conn);
        }
    }

    function likexp(){
        include("database.inc.php");
        
        
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        $username = $_SESSION['username'];
        $userID = $_SESSION['userid'];
        $getxp = "SELECT Experience FROM users WHERE Username='$username' AND ID='$userID'";
        $xp = mysqli_fetch_array(mysqli_query($conn, $getxp));
        $newxp = $xp['Experience'] + 1;
        $savexp = "UPDATE users SET Experience='$newxp' WHERE Username='$username' AND ID='$userID'";
        if(!mysqli_query($conn, $savexp)){
            echo "<p id='error'> Error: " . $savexp . "<br>" . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    }

    function comment($comment){
        include("database.inc.php");
        if(strlen($comment) > 1000){
            echo '<p id="error">Dein Kommentar ist zu lange. Bitte höre auf den HTML Code zu bearbeiten!</p>';
        }else{
            $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
            $post_id = $_GET['postid'];
            $username = $_SESSION['username'];
            $userID = $_SESSION['userid'];

            $save_comment = "
                INSERT INTO `themes`(
                    `postID`,
                    `type`,
                    `contents`,
                    `userID`
                )
                VALUES(
                    '$post_id',
                    'comment',
                    '$comment',
                    '$userID'
                )";
            
            $lastcomment = "SELECT * FROM `themes` WHERE type='comment' AND userID='$userID' AND timestamp >= (now() - INTERVAL 30 SECOND) ORDER BY ID";
            
            if(mysqli_num_rows(mysqli_query($conn, $lastcomment)) == 0 OR $_SESSION['rank'] == 'admin' OR $_SESSION['rank'] == 'mod'){
                if(!mysqli_query($conn, $save_comment)){
                    echo "<p id='error'> Error: " . $save_comment . "<br>" . mysqli_error($conn) . "</p>";
                }else{
                    //User Stats update
                    $getuserstats = "SELECT Posts_created, Experience FROM users WHERE Username='$username' AND ID='$userID'";
                    $result = mysqli_fetch_array(mysqli_query($conn, $getuserstats));
                    $newstat_postscreated = $result['Posts_created'] + 1;
                    $newstat_experience = $result['Experience'] + 10;
                    $updateuserstats = "UPDATE users SET Posts_created='$newstat_postscreated', Experience='$newstat_experience' WHERE Username='$username' AND ID='$userID'";

                    if(!mysqli_query($conn, $updateuserstats)){
                        echo "<p id='error'> Error: " . $save_comment . "<br>" . mysqli_error($conn) . "</p>";
                    }
                    header("Location: ../?postid=" . $post_id);
                }
            }else{
                header("Refresh:2; ../?postid=" . $post_id);
                echo '<p id="error">Bitte warte mindestens 30 Sekunden zwischen jedem Kommentar.</p>';
            }

            mysqli_close($conn);
        }
    }

    if(isset($_GET['delete']) OR isset($_GET['deletecomment'])){
        header("Location: delete.php");
    }
?>