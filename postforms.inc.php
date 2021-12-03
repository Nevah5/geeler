<?php if($_GET['create'] == 'general' AND $_SESSION['login']){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Allgemein</h1>
    <form action="?create=general&submit" name="create-general" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];

                    c_theme($title, $description, 'general');
                }
            }
        ?>
    </form>
</div>
<?php }else if($_GET['create'] == 'updatelog' AND $_SESSION['rank'] == 'admin'){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Updatelog</h1>
    <form action="?create=updatelog&submit" name="create-updatelog" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];

                    c_theme($title, $description, 'updatelog');
                }
            }
        ?>
    </form>
</div>
<?php }else if($_GET['create'] == 'eia' AND $_SESSION['login']){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Elektronik, Informatik & Automation</h1>
    <form action="?create=eia&submit" name="create-eia" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];

                    c_theme($title, $description, 'eia');
                }
            }
        ?>
    </form>
</div>
<?php }else if($_GET['create'] == 'hn' AND $_SESSION['login']){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Holz & Natur</h1>
    <form action="?create=hn&submit" name="create-hn" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                        
                    c_theme($title, $description, 'hn');
                }
            }
        ?>
    </form>
</div>
<?php }else if($_GET['create'] == 'gd' AND $_SESSION['login']){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Gestaltung & Druck</h1>
    <form action="?create=gd&submit" name="create-gd" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];

                    c_theme($title, $description, 'gd');
                }
            }
        ?>
    </form>
</div>
<?php }else if($_GET['create'] == 'mm' AND $_SESSION['login']){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Metall & Maschine</h1>
    <form action="?create=mm&submit" name="create-mm" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];

                    c_theme($title, $description, 'mm');
                }
            }
        ?>
    </form>
</div>
<?php }else if($_GET['create'] == 'bt' AND $_SESSION['login']){ ?>
<div class="postform">
    <h1><a href="../" id="back">Zurück</a> Thema erstellen - Bau & Technik</h1>
    <form action="?create=bt&submit" name="create-bt" method="POST">
        <?php
            if(isset($_GET["submit"])){
                $captcha=$_POST['g-recaptcha-response'];
                
                $secretKey = "6LdRUsAaAAAAAKALeySeOZbsdhQFxj6MKx1UjmY7";
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response,true);
            }
        ?>
        <input type="text" maxlength="50" name="title" placeholder="Titel" minlength="10" autofocus value="<?php echo $_POST['title']; ?>"><br>
        <?php
            if(isset($_GET["submit"]) and $captcha){
                if(empty($_POST['title'])){
                    $err = true;
                    echo '<p id="error">Bitte gib ein Titel an.</p>';
                }
            }
        ?>
        <textarea cols="50" rows="20" maxlength="2000" placeholder="Beschreibung..." name="description"><?php echo $_POST['description']; ?></textarea><br>
        <?php
            if(isset($_GET["submit"]) AND $captcha){
                if(empty($_POST['description'])){
                    $err = true;
                    echo '<p id="error">Bitte gib eine Beschreibung an.</p>';
                }
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdRUsAaAAAAAE8fgFDbFLKqIxCok8wWuw2oCD1H"></div>
        <?php 
            if(isset($_GET['submit'])){
                if(!$captcha){
                    echo '<p id="error">Bitte löse zuerst das reCaptcha!</p>';
                    $err = true;
                }
                // should return JSON with success as true
                if(!$responseKeys["success"] && $err == false) {
                    echo '<p id="error">Das reCaptcha ist fehlgeschlagen. Bitte versuche es erneut.</p>';
                    $err = true;
                }
            }
        ?>
        <input type="submit" value="Posten">
        <!-- PHP zum Posten -->
        <?php 
            if(isset($_GET['submit'])){
                if(!$err AND $captcha){
                    $title = $_POST['title'];
                    $description = $_POST['description'];

                    c_theme($title, $description, 'bt');
                }
            }
        ?>
    </form>
</div>
<?php } ?>