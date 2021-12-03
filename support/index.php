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
    
    if(isset($_GET['accept'])){
        setcookie("accept", true, time() + (86400 * 30), "/");
    }else if(!isset($_COOKIE['accept'])){
        include("../media/site/cookies.inc.php");
    }
?>
<html>
    <head>
        <title>Support - Geeler.net</title>
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
        <link rel="stylesheet" href="../media/labels/labels.css">
        <script src="https://kit.fontawesome.com/a44080dbce.js" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <?php include("../media/site/header.inc.php"); ?>
        <div class="body">
            <?php
                $userID = $_SESSION['userid'];
                if($_SESSION['rank'] != 'admin'){
                if($_SESSION['login'] != true){
            ?>
            <h3 id="information">Du musst eingeloggt sein, um diese Seite zu sehen.</h3>
            <?php }else if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM reviews WHERE userID='$userID'")) == 0 && !isset($_GET['success'])){ ?>
                <div class="postform">
                <h1><a href="../" id="back">Zurück</a> Support</h1>
                <form action="?submit" method="POST">
                    <?php
                        if(isset($_GET["submit"])){
                            $captcha=$_POST['g-recaptcha-response'];
                            
                            $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                            $response = file_get_contents($url);
                            $responseKeys = json_decode($response,true);
                        }
                    ?>
                    <textarea cols="50" rows="20" maxlength="2000" placeholder="Schreibe hier deine Frage oder Bemerkung..." name="content"><?php echo $_POST['content']; ?></textarea><br>
                    <?php
                        if(isset($_GET["submit"]) AND $captcha){
                            if(empty($_POST['content'])){
                                $err = true;
                                echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                            }
                        }
                    ?>
                    <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
                    <?php 
                        if(isset($_GET['submit'])){
                            if(!$captcha){
                                echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                                $err = true;
                            }
                            // should return JSON with success as true
                            if(!$responseKeys["success"] && $err == false) {
                                echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                                $err = true;
                            }
                        }
                    ?>
                    <input type="submit" value="Einreichen">
                    <?php 
                        //PHP zum Einreichen
                        if(isset($_GET['submit'])){
                            if(!$err AND $captcha){
                                $content = $_POST['content'];
                                $userID = $_SESSION['userid'];
                                $caseID = dechex(rand(0, 999999999));
                                $getuserdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID'"));
                                $email = $getuserdata['Email'];

                                $savereview = mysqli_query($conn, "INSERT INTO `support`(`caseID`, `userID`, `content`, `state`) VALUES ('$caseID','$userID','$content','new')");
                                header("Location: ../support?success");
                            }
                        }
                    ?>
                </form>
            </div>
            <?php }else if(isset($_GET['success'])){ ?>
            <h3 id="information2">Besten Dank für deine Frage/Bemerkung! Du bekommst eine Antwort via deine Email.</h3>
            <?php }}else{
            //display reviews ?>
            <div class="container">
                <div class="comments">
                    <h1>Neue Tickets [letzten 48h]</h1>
                    <?php 
                        $reviews = mysqli_query($conn, "SELECT * FROM `support` WHERE timestamp >= (now() - INTERVAL 48 HOUR) AND NOT state='done' AND NOT state='cancelled' ORDER BY timestamp");
                        foreach($reviews as $key => $data){
                            $userID = $data['userID'];
                            $userdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID'"));
                    ?>
                    <div id="comment">
                            <span id="title"><b><a href="../?user=<?= $data['userID'] ?>"><?= $userdata['Username'] ?></a> <?php rankicon($userdata['Rank'], 3); echo ' - <a href="mailto:'. $userdata['Email'] .'">'. $userdata['Email']; ?></a></b></span><br>
                            <span id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?>
                            <span id="state">
                                <span id="placeholder"><b>[</b></span>
                        <?php 
                            if($data['state'] == 'new'){
                                echo '<i id="new" class="fa fa-certificate" aria-hidden="true"></i>';
                            }else if($data['state'] == 'processing'){
                                echo '<i id="processing" class="fa fa-clock-o" aria-hidden="true"></i>';
                            }else if($data['state'] == 'done'){
                                echo '<i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i>';
                            }else if($data['state'] == 'cancelled'){
                                echo '<i id="cancelled" class="fa fa-ban" aria-hidden="true"></i>';
                            }
                            $teamID = $data['teamID'];
                            if(isset($data['teamID'])){
                                $getteamiddata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$teamID'"));
                                echo ' - <a href="../?user=' . $teamID['teamID'] . '"><b>'. $getteamiddata['Username'] .'</b></a>';
                            }
                        ?>   
                        <span id="placeholder"> <b>]</b></span> 
                        </span>
                        </span>
                        <p id="line"></p>
                        <p id="content"><?= $data['content']; ?></span></p><br><br>
                        <span id="changestate">
                            <a href="?changestate=new&caseid=<?= $data['caseID'] ?>"><i id="new" class="fa fa-certificate" aria-hidden="true"></i></a>
                            <a href="?changestate=processing&caseid=<?= $data['caseID'] ?>"><i id="processing" class="fa fa-clock-o" aria-hidden="true"></i></a>
                            <a href="?changestate=done&caseid=<?= $data['caseID'] ?>"><i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                            <a href="?changestate=cancelled&caseid=<?= $data['caseID'] ?>"><i id="cancelled" class="fa fa-ban" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <?php } ?>
                </div>
                <div class="comments">
                    <h1>Ältere Tickets [nach 48h]</h1>
                    <?php 
                        $reviews = mysqli_query($conn, "SELECT * FROM `support` WHERE timestamp <= (now() - INTERVAL 48 HOUR) AND NOT state='done' AND NOT state='cancelled' ORDER BY timestamp");
                        foreach($reviews as $key => $data){
                            $userID = $data['userID'];
                            $userdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID'"));
                    ?>
                    <div id="comment">
                            <span id="title"><b><a href="../?user=<?= $data['userID'] ?>"><?= $userdata['Username'] ?></a> <?php rankicon($userdata['Rank'], 3); echo ' - <a href="mailto:'. $userdata['Email'] .'">'. $userdata['Email']; ?></a></b></span><br>
                            <span id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?>
                            <span id="state">
                                <span id="placeholder"><b>[</b></span>
                        <?php 
                            if($data['state'] == 'new'){
                                echo '<i id="new" class="fa fa-certificate" aria-hidden="true"></i>';
                            }else if($data['state'] == 'processing'){
                                echo '<i id="processing" class="fa fa-clock-o" aria-hidden="true"></i>';
                            }else if($data['state'] == 'done'){
                                echo '<i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i>';
                            }else if($data['state'] == 'cancelled'){
                                echo '<i id="cancelled" class="fa fa-ban" aria-hidden="true"></i>';
                            }
                            $teamID = $data['teamID'];
                            if(isset($teamID)){
                                $getteamiddata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$teamID'"));
                                echo ' - <a href="../?user=' . $teamID['teamID'] . '"><b>'. $getteamiddata['Username'] .'</b></a>';
                            }
                        ?>   
                        <span id="placeholder"> <b>]</b></span> 
                        </span>
                        </span>
                        <p id="line"></p>
                        <p id="content"><?= $data['content']; ?></span></p><br><br>
                        <span id="changestate">
                            <a href="?changestate=new&caseid=<?= $data['caseID'] ?>"><i id="new" class="fa fa-certificate" aria-hidden="true"></i></a>
                            <a href="?changestate=processing&caseid=<?= $data['caseID'] ?>"><i id="processing" class="fa fa-clock-o" aria-hidden="true"></i></a>
                            <a href="?changestate=done&caseid=<?= $data['caseID'] ?>"><i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                            <a href="?changestate=cancelled&caseid=<?= $data['caseID'] ?>"><i id="cancelled" class="fa fa-ban" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <?php } ?>
                </div>
                <div class="comments">
                    <h1>Erledigte Tickets</h1>
                    <?php 
                        $reviews = mysqli_query($conn, "SELECT * FROM `support` WHERE state='done' ORDER BY timestamp");
                        foreach($reviews as $key => $data){
                            $userID = $data['userID'];
                            $userdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID'"));
                    ?>
                    <div id="comment">
                            <span id="title"><b><a href="../?user=<?= $data['userID'] ?>"><?= $userdata['Username'] ?></a> <?php rankicon($userdata['Rank'], 3); echo ' - <a href="mailto:'. $userdata['Email'] .'">'.  $userdata['Email']; ?></a></b></span><br>
                            <span id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?>
                            <span id="state">
                                <span id="placeholder"><b>[</b></span>
                        <?php 
                            if($data['state'] == 'new'){
                                echo '<i id="new" class="fa fa-certificate" aria-hidden="true"></i>';
                            }else if($data['state'] == 'processing'){
                                echo '<i id="processing" class="fa fa-clock-o" aria-hidden="true"></i>';
                            }else if($data['state'] == 'done'){
                                echo '<i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i>';
                            }else if($data['state'] == 'cancelled'){
                                echo '<i id="cancelled" class="fa fa-ban" aria-hidden="true"></i>';
                            }
                            $teamID = $data['teamID'];
                            if(isset($teamID)){
                                $getteamiddata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$teamID'"));
                                echo ' - <a href="../?user=' . $teamID['teamID'] . '"><b>'. $getteamiddata['Username'] .'</b></a>';
                            }
                        ?>   
                        <span id="placeholder"> <b>]</b></span> 
                        </span>
                        </span>
                        <p id="line"></p>
                        <p id="content"><?= $data['content']; ?></span></p><br><br>
                        <span id="changestate">
                            <a href="?changestate=new&caseid=<?= $data['caseID'] ?>"><i id="new" class="fa fa-certificate" aria-hidden="true"></i></a>
                            <a href="?changestate=processing&caseid=<?= $data['caseID'] ?>"><i id="processing" class="fa fa-clock-o" aria-hidden="true"></i></a>
                            <a href="?changestate=done&caseid=<?= $data['caseID'] ?>"><i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                            <a href="?changestate=cancelled&caseid=<?= $data['caseID'] ?>"><i id="cancelled" class="fa fa-ban" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <?php } ?>
                </div>
                <div class="comments">
                    <h1>Abgebrochene Tickets</h1>
                    <?php 
                        $reviews = mysqli_query($conn, "SELECT * FROM `support` WHERE state='cancelled' ORDER BY timestamp");
                        foreach($reviews as $key => $data){
                            $userID = $data['userID'];
                            $userdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID'"));
                    ?>
                    <div id="comment">
                            <span id="title"><b><a href="../?user=<?= $data['userID'] ?>"><?= $userdata['Username'] ?></a> <?php rankicon($userdata['Rank'], 3); echo ' - <a href="mailto:'. $userdata['Email'] .'">'.  $userdata['Email']; ?></a></b></span><br>
                            <span id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?>
                            <span id="state">
                            <span id="placeholder"><b>[</b></span>
                            <?php 
                                if($data['state'] == 'new'){
                                    echo '<i id="new" class="fa fa-certificate" aria-hidden="true"></i>';
                                }else if($data['state'] == 'processing'){
                                    echo '<i id="processing" class="fa fa-clock-o" aria-hidden="true"></i>';
                                }else if($data['state'] == 'done'){
                                    echo '<i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i>';
                                }else if($data['state'] == 'cancelled'){
                                    echo '<i id="cancelled" class="fa fa-ban" aria-hidden="true"></i>';
                                }
                                $teamID = $data['teamID'];
                                if(isset($teamID)){
                                    $getteamiddata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$teamID'"));
                                    echo ' - <a href="../?user=' . $teamID['teamID'] . '"><b>'. $getteamiddata['Username'] .'</b></a>';
                                }
                            ?>   
                            <span id="placeholder"> <b>]</b></span> 
                        </span>
                        </span>
                        <p id="line"></p>
                        <p id="content"><?= $data['content']; ?></span></p><br><br>
                        <span id="changestate">
                            <a href="?changestate=new&caseid=<?= $data['caseID'] ?>"><i id="new" class="fa fa-certificate" aria-hidden="true"></i></a>
                            <a href="?changestate=processing&caseid=<?= $data['caseID'] ?>"><i id="processing" class="fa fa-clock-o" aria-hidden="true"></i></a>
                            <a href="?changestate=done&caseid=<?= $data['caseID'] ?>"><i id="done" class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                            <a href="?changestate=cancelled&caseid=<?= $data['caseID'] ?>"><i id="cancelled" class="fa fa-ban" aria-hidden="true"></i></a>
                        </span>
                    </div>
                <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php include("../media/site/footer.inc.php"); ?>
    </body>
</html>
<?php 
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
        }
    }

    if(isset($_GET['changestate']) AND isset($_GET['caseid']) AND ($_SESSION['rank'] == 'admin' OR $_SESSION['rank'] == 'mod')){
        //test if case is existing
        $caseID = $_GET['caseid'];
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM support WHERE caseID='$caseID'")) > 0){
            $newstate = $_GET['changestate'];
            //test if state is valid state
            //update
            $teamID = $_SESSION['userid'];
            mysqli_query($conn, "UPDATE support SET state='$newstate', teamID='$teamID' WHERE caseID='$caseID'");
            header("Location: ../support");
        }else{
            //if case is not existing
            header("Location: ../support");
        }
    }

    mysqli_close($conn);
?>