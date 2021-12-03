<?php
    session_start();
    
    
    include("../database.inc.php");

    //Check for account deletion
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

    if($_SESSION['login'] == true){
        $id = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $sql = "SELECT Username, ID FROM users WHERE ID='$id' AND Username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo '<span id="error">Ein Administrator hat deinen Account gelöscht. Bitte wende dich an den Support wenn du Fragen hast.</p>';
            echo '<span id="error">Klicke </span><a href="../../">hier</a><span id="error">, um zurück zur Startseite zu kommen.</span>';
            session_destroy();
        }else{
            session_destroy();
            setcookie("cookielogin", '', time() - 84000, "/");
            setcookie("cookieusrid", '', time() - 84000, "/");
            if(!isset($_GET['newusername'])){
                header("Location: ../account");
            }else{
                header("Location: ../account?newusername=" . $_GET['newusername']);
            }
        }
    }else{
        header("Location: ../account");
    }
    
    mysqli_close($conn);
?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
</html>