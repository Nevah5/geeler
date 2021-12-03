<?php 
    session_start();
    ob_start();

    include("../database.inc.php");

    if($_SESSION['login'] != true){
        if(isset($_COOKIE['cookielogin']) AND isset($_COOKIE['cookieusrid'])){
            $cookielogin = $_COOKIE['cookielogin'];
            $userid = $_COOKIE['cookieusrid'];
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

            $sql_checkcookie = "SELECT * FROM cookielogin WHERE token='$cookielogin' AND userID='$userid' AND IP='$ip'";
            $sql_getuserdata = "SELECT * FROM users WHERE ID='$userid'";

            $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

            $result = $conn->query($sql_checkcookie);

            if($result->num_rows > 0){
                $query = mysqli_fetch_array($conn->query($sql_getuserdata));
                $_SESSION['username'] = $query['Username'];
                $_SESSION['email'] = $query['Email'];
                $_SESSION['login'] = true;
                $_SESSION['userid'] = $_COOKIE['cookieusrid'];
                $_SESSION['rank'] = $query['Rank'];
                //SAVE NEW COOKIES
                $cookielogin = md5(rand(0, 99999));
                setcookie("cookielogin", $cookielogin, time() + (84000 * 7), "/");
                setcookie("cookieusrid", "$userid", time() + (84000 * 7), "/");
                $sql_savecookie = "INSERT INTO cookielogin(token, IP, userID) VALUES ('$cookielogin', '$ip', '$userid')";
                $sql_updateip = "UPDATE users SET last_IP='$ip' WHERE ID='$userid' AND Username='$username'";
                $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
                mysqli_query($conn, $sql_savecookie);
                mysqli_query($conn, $sql_updateip);
            }else{
                setcookie("cookielogin", '', time() - 84000, "/");
                setcookie("cookieusrid", '', time() - 84000, "/");
            }
        }else{
            setcookie("cookielogin", '', time() - 84000, "/");
            setcookie("cookieusrid", '', time() - 84000, "/");
        }
    }
?>