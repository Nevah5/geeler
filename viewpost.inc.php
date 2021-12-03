<?php 
    $userID = $result['userID'];
    $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
    $userdata = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    $userexists = true;
    if(mysqli_num_rows(mysqli_query($conn, $getuserdata)) == '0'){
        $userexists = false;
    }
?>
<div class="viewpost">
    <link rel="stylesheet" href="flairs.css">
    <h1 id="title"><?= $result['title'] ?><?php if($_SESSION['username'] == $userdata['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $result['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a> <?php } ?>
    <?php 
        if($result['theme'] == 'general'){
            echo '<div id="flair"><span>Allgemein</span></div>';
        }if($result['theme'] == 'updatelog'){
            echo '<div id="flair_red"><span>Updatelog</span></div>';
        }if($result['theme'] == 'eia'){
            echo '<div id="flair_darkblue"><span>Elektronik, Informatik & Automation</span></div>';
        }if($result['theme'] == 'mm'){
            echo '<div id="flair_darkblue"><span>Metall & Maschine</span></div>';
        }if($result['theme'] == 'hn'){
            echo '<div id="flair_darkgreen"><span>Holz & Natur</span></div>';
        }if($result['theme'] == 'gd'){
            echo '<div id="flair_blue"><span>Gestaltung & Druck</span></div>';
        }if($result['theme'] == 'bt'){
            echo '<div id="flair_green"><span>Bau & Technik</span></div>';
        }if($result['theme'] == 'hidden'){
            echo '<div id="flair_blue"><span>Versteckt</span></div>';
        }
    ?>
    </h1>
    
    <div id="likes">
        <?php 
            $userID = $_SESSION['userid'];
            $test = "SELECT * FROM `themes` WHERE userID='$userID' AND postID='$post_id' AND (type='like' OR type='dislike')";
            
            if(mysqli_num_rows(mysqli_query($conn, $test)) == 0){
                echo '<a href="?postid=' . $post_id . '&like"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';
            }else{
                $likestate = "SELECT * FROM `themes` WHERE userID='$userID' AND postID='$post_id' AND type='like'";
                if(mysqli_num_rows(mysqli_query($conn, $likestate)) > 0){
                    echo '<i id="locked" class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }else{
                    echo '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }
            }
        ?>
        <span id="points">
        <?php 
            $post_id = $_GET['postid'];
            $getlikes = "SELECT * FROM `themes` WHERE postID='$post_id' AND type='like'";
            $getdislikes = "SELECT * FROM `themes` WHERE postID='$post_id' AND type='dislike'";
            $likes = mysqli_num_rows(mysqli_query($conn, $getlikes));
            $dislikes = mysqli_num_rows(mysqli_query($conn, $getdislikes));
            $total = $likes - $dislikes;
            echo $total; 
        ?>
        </span>
        <?php 
            if(mysqli_num_rows(mysqli_query($conn, $test)) == 0){
                echo '<a href="?postid=' . $post_id . '&dislike"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>';
            }else{
                $likestate = "SELECT * FROM `themes` WHERE userID='$userID' AND postID='$post_id' AND type='dislike'";
                if(mysqli_num_rows(mysqli_query($conn, $likestate)) > 0){
                    echo '<i id="locked" class="fa fa-thumbs-down" aria-hidden="true"></i>';
                }else{
                    echo '<i class="fa fa-thumbs-down" aria-hidden="true"></i>';
                }
            }
        ?>
    </div>
    <div id="time"><?php echo date("d.m.Y H:i", strtotime($result['timestamp'])); ?><span id="user"> - <b><?php if($userexists == true){ ?><a href="?user=<?= $result['userID'] ?>"><?= $userdata['Username'] ?></a></b><?php echo rankicon($userdata['Rank'], 3); }else{ echo 'gelöschter Benutzer'; }?></span></p>
    <p id="description"><?= $result['contents'] ?></p></div>
</div>
<?php if($_SESSION['login']){ ?>
<div class="writecomment">
    <span>Kommentieren als Benutzer "<?= $_SESSION['username'] ?>"</span>
    <form action="?postid=<?= $post_id ?>&comment" method="POST">
        <textarea maxlength="1000" name="comment" id="commentbox" cols="150" rows="3"></textarea>
        <input type="submit" name="submit" value="Absenden">
        <?php 
            if(isset($_GET['comment'])){
                if(empty($_POST['comment'])){
                    echo '<p id="error">Du kannst keinen leeren Kommentar abgeben.</p>';
                }else{
                    comment($_POST['comment']);
                }
            }
        ?>
    </form>
</div>
<?php } ?>
<div class="comments">
    <h1>Kommentare</h1>
    <?php
        $post_id = $_GET['postid'];
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
        $query = "SELECT * FROM `themes` WHERE type='comment' AND postid='$post_id' AND edited='0'";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
        $resultarray = mysqli_fetch_array($result);
        if($number > 0){
        foreach($result as $key => $data){
            $comment_id = $data['ID'];
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $userdata = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
            $userexists = true;
            if(mysqli_num_rows(mysqli_query($conn, $getuserdata)) == '0'){
                $userexists = false;
            }
            $warningnbr = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM themes WHERE type='comment' AND NOT warned='0' AND userID='$userID'"));
            $contents = str_replace(array( "\n", "\r" ), array( "\\n", "\\r" ), $data['contents']);
            if($data['warned'] != '0'){
                $warnedbyid  = $data['warnedby'];
                $getwarnedbyusername = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE ID='$warnedbyid'"));
                $warnedby = $getwarnedbyusername['Username'];
            }
    ?>
        <div id="comment">
            <span id="title"><b><?php if($userexists == true){ ?><a href="?user=<?= $data['userID'] ?>"><?= $userdata['Username'] ?></a></b><?php echo rankicon($userdata['Rank'], 3); if($userdata['Username'] == $op_username){ rankicon('OP', 3); } }else{ echo 'gelöschter Benutzer'; } ?></span><br>
            <span id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><?php if(($_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin' OR $data['userID'] == $_SESSION['userid']) AND $data['deleted'] == '0'){ ?> <a href="delete.php?postid=<?= $post_id ?>&deletecomment=<?= $comment_id ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php }else if(($_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin') AND $data['deleted'] != '0' AND $data['warned'] == '0'){ ?><span id="placeholder"> </span><a href="?postid=<?= $post_id ?>&warn=<?= $comment_id ?>"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a><?php } ?></span>
            <p id="line"></p>
            <p id="content"><?php if($data['deleted'] == '0'){echo $data['contents'];}else{echo '<i id="hide' . $key . '">Inhalt gelöscht...</i>';if($_SESSION['rank'] == 'admin' OR $_SESSION['rank'] == 'mod'){?> <i style="cursor: pointer" id="eye<?= $key ?>" onclick="reveal('<?= $contents ?>', <?= $key ?>)" class="fa fa-eye" aria-hidden="true"></i><?php } if($data['userID'] == $_SESSION['userid'] AND $data['deleted'] != '0' AND $data['warned'] == '0'){echo ' <a href="?postid=' . $data['postID'] . '&undodelete=' . $data['ID'] .'"><i class="fa fa-undo" aria-hidden="true"></i></a>';} ?></span><?php } ?></p>
            <?php if($data['warned'] != '0' AND ($_SESSION['rank'] == 'admin' OR $_SESSION['rank'] == 'mod' OR $data['userID'] == $_SESSION['userid'])){?><p id="warning">Warnung [<?= $warningnbr ?>]: <?= $data['warned'] ?>  <?php if(isset($warnedby)){ ?>[<?= $warnedby ?>]<?php } ?></p><?php } ?>
        </div>
    <?php }} ?>
</div>
<script>
    function reveal(content, key){
        if(document.getElementById("hide" + key).innerHTML == 'Inhalt gelöscht...'){
            document.getElementById("hide" + key).innerHTML = content;
            document.getElementById("eye" + key).classList.remove('fa-eye');
            document.getElementById("eye" + key).classList.add('fa-eye-slash');
        }else{
            document.getElementById("hide" + key).innerHTML = 'Inhalt gelöscht...';
            document.getElementById("eye" + key).classList.add('fa-eye');
            document.getElementById("eye" + key).classList.remove('fa-eye-slash');
        }
    }
</script>


<?php 
    if(isset($_GET['postid']) AND isset($_GET['undodelete'])){
        $postID = $_GET['postid'];
        $commentID = $_GET['undodelete'];
        $userID = $_SESSION['userid'];
        //test if user is comment owner:
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM themes WHERE ID='$commentID' AND userID='$userID' AND NOT deleted='0' AND warned='0'")) != 0){
            if(!mysqli_query($conn, "UPDATE themes SET deleted='0' WHERE ID='$commentID' AND userID='$userID' AND NOT deleted='0' AND warned='0'")){
                echo mysqli_error($conn);
            }else{
                header("Location: ?postid=".$postID);
            }
        }else{
            header("Location: ?postid=".$postID);
        }
    }
    if(isset($_GET['postid']) AND isset($_GET['warn'])){
        $postID = $_GET['postid'];
        $commentID = $_GET['warn'];
        $userID = $_SESSION['userid'];
        //test if user is able to warn:
        if($_SESSION['rank'] == 'admin' || $_SESSION['rank'] == 'mod'){
            //Warngrund:
            $reason = 'Unangemessener Inhalt';
            if(!mysqli_query($conn, "UPDATE themes SET warned='$reason', warnedby='$userID' WHERE ID='$commentID' AND NOT deleted='0' AND warned='0'")){
                echo mysqli_error($conn);
            }else{
                header("Location: ?postid=".$postID);
            }
        }else{
            header("Location: ?postid=".$postID);
        }
    }
?>