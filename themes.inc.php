<?php $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname); ?>
<div class="theme-general">
    <h1>Allgemein</h1>
    <?php
        if($_GET['sort'] == 'newest'){
            $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='general' ORDER BY timestamp DESC";
        }else if($_GET['sort'] == 'oldest'){
            $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='general' ORDER BY timestamp ASC";
        }else{
            $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='general' ORDER BY timestamp DESC";
        }
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
            $userexists = true;
            if(mysqli_num_rows(mysqli_query($conn, $getuserdata)) == '0'){
                $userexists = false;
            }
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><?php if($userexists == true){ ?><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); }else{ echo 'gelöschter Benutzer'; }?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<div class="theme-updatelog">
    <h1>Updatelog</h1>
    <?php
        $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='updatelog' ORDER BY timestamp DESC";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); ?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<div class="theme-eia">
    <h1>Elektronik, Informatik & Automation</h1>
    <?php
        $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='eia' ORDER BY timestamp DESC";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); ?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<div class="theme-hn">
    <h1>Holz & Natur</h1>
    <?php
        $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='hn' ORDER BY timestamp DESC";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); ?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<div class="theme-gd">
    <h1>Gestaltung & Druck</h1>
    <?php
        $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='gd' ORDER BY timestamp DESC";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); ?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<div class="theme-mm">
    <h1>Metall & Maschine</h1>
    <?php
        $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='mm' ORDER BY timestamp DESC";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); ?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<div class="theme-bt">
    <h1>Bau & Technik</h1>
    <?php
        $query = "SELECT * FROM `themes` WHERE type='post' AND deleted='0' AND theme='bt' ORDER BY timestamp DESC";
        $result = mysqli_query($conn,$query);
        $number =  mysqli_num_rows($result);
            
        if($number > 0){
        foreach($result as $key => $data){
            $userID = $data['userID'];
            $getuserdata = "SELECT * FROM users WHERE ID='$userID'";
            $result = mysqli_fetch_array(mysqli_query($conn, $getuserdata));
    ?>
        <div class="post">
            <a href="?postid=<?= $data['postID'] ?>"><div id="title"><span><?= $data['title'] ?><?php if($_SESSION['username'] == $result['Username'] OR $_SESSION['rank'] == 'mod' OR $_SESSION['rank'] == 'admin'){ ?> <a href="delete.php?postid=<?= $data['postID'] ?>&delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></span></div></a>
            <p id="time"><?php echo date("d.m.Y H:i", strtotime($data['timestamp'])); ?><span> - <b><a href="?user=<?= $data['userID'] ?>"><?= $result['Username'] ?></a></b><?php echo rankicon($result['Rank'], 3); ?></span></p>
            
            <div id="likes">
                <?php 
                    $post_id = $data['postID'];
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
                    $post_id = $data['postID'];
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
        </div>
    <?php }} ?>
</div>
<?php mysqli_close($conn); ?>