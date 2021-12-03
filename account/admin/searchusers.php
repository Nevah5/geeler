<?php 
    include("../../database.inc.php");
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
?>
<html>
    <head>
        <title>Searchusers - Test</title>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="../../media/labels/labels.css">
    </head>
    <body>
        <form method="POST" action="searchusers.php">
            <input type="text" name="search" placeholder="Suchen">
            <input type="submit" value="Suchen">
        </form>
    </body>
</html>
<?php
    if(isset($_POST['search']) AND !empty($_POST['search'])){
        $search = $_POST['search'];
        $userquery = "SELECT * FROM users WHERE Username LIKE '%". $search ."%'";
        $postquery = "SELECT * FROM themes WHERE title LIKE '%". $search ."%' AND deleted='0'";

        $searchposts = mysqli_query($conn, $postquery);
        $searchusers = mysqli_query($conn, $userquery);

        if(mysqli_num_rows($searchposts)){
            echo '<h2>Posts</h2>';
            foreach($searchposts as $key => $data){
                $postID = $data['postID'];
                $OP_ID = $data['userID'];
                $userquery = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$OP_ID'"));
                $postusername = $userquery['Username'];
                $postsrank = $userquery['Rank'];

                echo '<div>';
                echo '<span><a href="https://geeler.net?postid='. $postID .'">'. $data['title'] .'</a><span><br>';
                echo '<span><a href="https://geeler.net?user='. $postID .'">'. $postusername .'-'. rankicon($postsrank, 3) . '</a><span>';
                echo '</div>';
            }
        }
        if(mysqli_num_rows($searchusers) AND strlen($search) >= 3){
            echo '<h2>Users</h2>';
            foreach($searchusers as $key => $data){
                echo '<div>';
                echo '<span><a href="https://geeler.net?user='. $data['ID'] .'">'. $data['Username'] .'</a><span>';
                echo '</div>';
            }
        }if(strlen($search) < 3){
            echo '<h2>Users</h2>';
            echo 'Um Benutzer zu suchen, musst du mindestens 3 Zeichen angeben.';
        }
    }

mysqli_close($conn);

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
    }else if($rank == 'OP'){
        if($size == 3){
            echo '<span id="posticon3_op">OP</span>';
        }else  if($size == 2){
            echo '<span id="posticon2_op">OP</span>';
        }else{
            echo '<span id="posticon1_op">OP</span>';
        }
    }
}