<?php 
    session_start();
    ob_start();
    include("../database.inc.php");

    //test if user is logged in
    if($_SESSION['login'] != true){
        header("../");
    }else{
        //Upload a new Avatar:
        if(isset($_FILES['Avatar'])){
            $avatar = pathinfo($_FILES['Avatar']['name']);// $avatar['extension'], $avatar['basename'], $avatar['dirname'], $avatar['filename']
            $ext = mb_strtolower($avatar['extension']);
            if($ext != 'png' AND $ext != 'jpg'){ 
                //Test if Extension is right
                header("Location: ?imguploadfailed=type");
                $err = true;
            }if ($_FILES["Avatar"]["size"] > 5000000) { // 5 MB (standart in "php.ini") only change if need to lower size, else in "php.ini"
                //Test if Size is too big
                header("Location: ?imguploadfailed=size");
                $err = true;
            }if($err != true){
                $username = $_SESSION['username'];
                $userid = $_SESSION['userid'];
                $avatarname = $userid . '-' . time() . '.' . $avatar['extension'];
                $destination_file = "../media/uploads/profiles/" . $avatarname;

                $getoldfile = mysqli_fetch_array(mysqli_query($conn, "SELECT Avatar FROM users WHERE ID='$userid' AND Username='$username'"));
                $old_file = $getoldfile['Avatar'];
                if($old_file != 'default.png'){
                    unlink("../media/uploads/profiles/".$old_file);
                }

                if(move_uploaded_file($_FILES["Avatar"]["tmp_name"], $destination_file)){
                    if(mysqli_query($conn, "UPDATE users SET Avatar='$avatarname' WHERE ID='$userid' AND Username='$username'")){
                        header("Location: ../account");
                    }else{
                        echo mysqli_error($conn);
                    }
                }else{
                    if($_FILES['Avatar']['error'] == 1){ //File size cant exeed 5 MB (defined in "php.ini") SOURCE: https://stackoverflow.com/questions/3501749/php-move-uploaded-file-error
                        echo "<p id='error'>Du darfst keine Datei die grösser als 5MB ist auswählen.</p>";
                    }else{
                        echo "Ein Fehler unbekannter Fehler beim hochladen der Datei ist aufgetreten. [ Error Code: " . $_FILES['Avatar']['error'] . " ] Bitte versuche es später erneut.";
                    }
                }
            }
            //rename file and save in db
            /*
            echo '<br>extension: '. $avatar['extension'];
            echo '<br>basename: '. $avatar['basename'];
            echo '<br>dirname: '. $avatar['dirname'];
            echo '<br>filename: '. $avatar['filename'];
            echo '<br>tmp_name: '. $_FILES['Avatar']['tmp_name'];
            echo '<br>Size: '. $_FILES['Avatar']['size'];
            echo '<br>New File Name: '. $avatarname;
            echo '<br>Target File: '. $target_file;*/
        }
        //Upload XYZ:
    }
?>