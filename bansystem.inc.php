<?php 
    session_start();
    ob_start();
    include("database.inc.php");
    
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

    $userID = $_SESSION['userid'];
    
    //test if user has more than 2 Bans
    if($_SESSION['rank'] != 'admin' AND $_SESSION['rank'] != 'mod'){
        if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM themes WHERE userID='$userID' AND NOT warned='0'")) == '3'){
            //user bannen
            mysqli_query($conn, "UPDATE users SET Banned='1' WHERE ID='$userID'");
            header("Location: account/logout.php");
        }
    }
    mysqli_close($conn);

?>