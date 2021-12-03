<?php 
    //This file is for updating the database "last_seen" in users

    session_start();

    include("database.inc.php");

    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    $update = "UPDATE users SET last_seen=now() WHERE Username='$username' AND ID='$userid'";

    if(!mysqli_query($conn, $update)){
        echo mysqli_error($conn);
    }

    mysqli_close($conn);
?>