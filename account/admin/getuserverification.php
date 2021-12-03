<?php
    session_start();
    include("../../database.inc.php");

    $id = $_GET['id'];

    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT Email, Verified, ID FROM users WHERE ID='$id'";
    $result = mysqli_fetch_array($conn->query($sql));

    echo 'https://www.geeler.net/account/verify.php?email=' . $result['Email'] . '&hash=' . $result['Verified'];

    if(!mysqli_query($conn, $sql)){
        echo "<p id='error'> Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }
    mysqli_close($conn);
?>
<html>
    <head>
        <title>ADMINTOOL - VERIFICATION</title>
        <link rel="icon" href="../../media/logo_small_icon.png">
        <meta charset="UTF-8">
    </head>
    <body>
        <br><a href="../../account">Zurück</a>
    </body>
</html>