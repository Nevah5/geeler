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
        <title>Bewertungen - Geeler.net</title>
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
            <?php }else if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM reviews WHERE userID='$userID'")) == 0){ ?>
            <div class="postform">
                <h1><a href="../" id="back">Zurück</a> Bewertung abgeben</h1>
                <form action="?submit" name="create-general" method="POST">
                    <h3>Eindruck:</h3>
                    <section class="rating">
                        <input type="radio" id="verygood" name="impression" value="verygood">
                        <label for="verygood"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></label><br>
                        <input type="radio" id="good" name="impression" value="good">
                        <label for="good"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></label><br>
                        <input type="radio" id="neutral" name="impression" value="neutral">
                        <label for="neutral"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></label><br>
                        <input type="radio" id="bad" name="impression" value="bad">
                        <label for="bad"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></label><br>
                        <input type="radio" id="verybad" name="impression" value="verybad">
                        <label for="verybad"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></label><br>
                    </section><br>

                    <textarea cols="50" rows="20" maxlength="2000" placeholder="Bewertung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
                    <?php
                        if(isset($_GET["submit"])){
                            if(empty($_POST['description'])){
                                $err = true;
                                echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                            }
                        }
                    ?>
                    <input type="submit" value="Bewertung Einreichen">
                    <?php
                        //PHP zum Einreichen
                        if(isset($_GET['submit'])){
                            if(!$err){
                                $title = $_POST['title'];
                                $description = $_POST['description'];
                                $impression = $_POST['impression'];
                                $userID = $_SESSION['userid'];

                                if(!mysqli_query($conn, "INSERT INTO `reviews`(`userID`, `impression`, `feedback`) VALUES ('$userID','$impression','$description')")){
                                    echo mysqli_error($conn);
                                }else{
                                    header("Location: ../review");
                                }
                            }
                        }
                    ?>
                </form>
            </div>
            <?php }else{ ?>
            <h3 id="information">Du hast bereits eine Bewertung abgegeben. Vielen Dank!</h3>
            <?php }}else{
                //display reviews ?>
                <div class="comments">
                <h1>Rückmeldungen</h1>
                <?php
                    $reviews = mysqli_query($conn, "SELECT * FROM `reviews` WHERE 1");
                    foreach($reviews as $key => $data){
                        $userID = $data['userID'];
                        $userdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$userID'"));
                ?>
                    <div id="comment">
                        <span id="title"><b><a href="../?user=<?= $data['userID'] ?>"><?= $userdata['Username'] ?> <?php rankicon($userdata['Rank'], 3); ?></a></b></span><br>
                        <span id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?></span>
                        <p id="line"></p>
                        <p id="rating">
                            <?php 
                                if($data['impression'] == 'verygood'){
                                    echo '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
                                }else if($data['impression'] == 'good'){
                                    echo '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
                                }else if($data['impression'] == 'neutral'){
                                    echo '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
                                }else if($data['impression'] == 'bad'){
                                    echo '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
                                }else if($data['impression'] == 'verybad'){
                                    echo '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            
                            ?>    
                        </p>
                        <p id="content"><?= $data['feedback']; ?></span></p>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php include("../media/site/footer.inc.php"); mysqli_close($conn); ?>
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
?>