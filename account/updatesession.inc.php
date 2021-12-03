<?php
    //Get the user data from the database
    $userID = $_SESSION['userid'];
    $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
    
    include("../database.inc.php");

    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

    $userdata = mysqli_fetch_array(mysqli_query($conn, $getuserdata));

    //Compare the data from the database with the session
    if($userdata['Rank'] != $_SESSION['rank']){
        //Update Rank
        $_SESSION['rank'] = $userdata['Rank'];
    }else if($userdata['Username'] != $_SESSION['username']){
        //Update Username
        $_SESSION['username'] = $userdata['Username'];
    }
    mysqli_close($conn);
?>