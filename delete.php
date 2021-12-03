<?php
    session_start();
    ob_start();
    
    include("database.inc.php");

    //START OF (UPDATE SESSION VARIABLES)
    $userID = $_SESSION['userid'];
    $getuserdata = "SELECT * FROM users WHERE ID='$userID'";

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
    //END OF (UPDATE SESSION VARIABLES)
    
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
    if(isset($_GET['postid'])  AND isset($_GET['delete'])){
        $post_id = $_GET['postid'];
        //Test if post already deleted
        $testdel = "SELECT * FROM `themes` WHERE type='post' AND postID='$post_id' AND deleted='0'";
        if(mysqli_num_rows(mysqli_query($conn, $testdel)) > 0){
            //Test if user that deletes post is either an admin, moderator or the creator of the post
            if($_SESSION['rank'] == 'admin' || $_SESSION['rank'] == 'mod'){
                //delete post
                $post_id = $_GET['postid'];
                $username = $_SESSION['username'];
                $delpost = "UPDATE `themes` SET deleted='$username' WHERE postID='$post_id' AND type='post'";
                if(!mysqli_query($conn, $delpost)){
                    echo mysqli_error($conn);
                }
                
                header("Location: ../");
            }else{
                //TEST IF IT IS THE POST CREATOR
                $getpost = "SELECT * FROM `themes` WHERE type='post' AND postID='$post_id'";

                $post = mysqli_fetch_array(mysqli_query($conn, $getpost));

                if($post['username'] == $_SESSION['username'] AND $post['userID'] == $_SESSION['userid']){
                    //delete post
                    $post_id = $_GET['postid'];
                    $username = $_SESSION['username'];
                    $delpost = "UPDATE `themes` SET deleted='$username' WHERE postID='$post_id' AND type='post'";
                    if(!mysqli_query($conn, $delpost)){
                        echo mysqli_error($conn);
                    }
                    
                    header("Location: ../");
                }else{
                    header("Location: ../");
                }
            }
        }else{
            echo "Dieser Post wurde bereits gelöscht.";
        }
    }else if(isset($_GET['postid']) AND isset($_GET['deletecomment'])){
        $comment_id = $_GET['deletecomment'];
        $post_id = $_GET['postid'];
        //Test if comment already deleted
        $testdel = "SELECT * FROM `themes` WHERE type='comment' AND ID='$comment_id' AND postID='$post_id' AND deleted='0'";
        $getcomment = mysqli_fetch_array(mysqli_query($conn, $testdel));
        if(mysqli_num_rows(mysqli_query($conn, $testdel)) > 0){
            //TEst if rank admin or mod
            if($_SESSION['rank'] == 'admin' || $_SESSION['rank'] == 'mod'){
                //delete comment
                $comment_id = $_GET['deletecomment'];
                $username = $_SESSION['username'];
                $delcomment = "UPDATE `themes` SET deleted='$username' WHERE type='comment' AND ID='$comment_id'";
                if(!mysqli_query($conn, $delcomment)){
                    echo mysqli_error($conn);
                }
                
                header("Location: ../?postid=" . $_GET['postid']);
            }else if($getcomment['userID'] == $_SESSION['userid']){
                //delete comment
                $comment_id = $_GET['deletecomment'];
                $username = $_SESSION['username'];
                $delcomment = "UPDATE `themes` SET deleted='$username' WHERE type='comment' AND ID='$comment_id'";
                if(!mysqli_query($conn, $delcomment)){
                    echo mysqli_error($conn);
                }
                
                header("Location: ../?postid=" . $_GET['postid']);
            }else{
                header("Location: ../?postid=" . $_GET['postid']);
            }
        }else{
            echo "Dieser Kommentar wurde bereits gelöscht.";
        }
    }else{
        header("Location: ../");
    }

    mysqli_close($conn);
?>