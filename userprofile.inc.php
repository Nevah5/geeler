<?php 
    include("database.inc.php");
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);
    $userid = $_GET['user'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE ID='$userid'");
    $data = mysqli_fetch_array($query);
    mysqli_close($conn);
    if(mysqli_num_rows($query) > 0){
?>
<div class="userprofile">
    <img src="media/uploads/profiles/<?= $data['Avatar'] ?>" alt="" class="profileimg1">
    <div class="right">
        <span id="title" style="font-size: 2rem;"><?= $data['Username'] ?><?= rankicon($data['Rank'], 2) ?></span><br><br><?php if(!empty($data['Description'])){ ?>
        <span>Beschreibung:<br> <?= $data['Description'] ?></span><br><br><br><?php } ?>
        <span>Zuletzt online: <?= date("d.m.Y H:i", strtotime($data['last_seen'])) ?></span><br>
        <span>Beigetreten am: <?= date("d.m.Y H:i", strtotime($data['Joindate'])) ?></span><br>
        <span>Themen erstellt: <?= $data['Themes_created'] ?></span><br>
        <span>Kommentare erstellt: <?= $data['Posts_created'] ?></span><br>
        <span>Erfahrungspunkte: <?= $data['Experience'] ?></span><br>
    </div>
</div>
<?php }else{ ?>
<h1 id="information">Dieser Benutzer existiert nicht.</h1>
<?php } ?>