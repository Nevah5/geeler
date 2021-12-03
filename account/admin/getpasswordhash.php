<html>
    <head><title>Administration - Passwordhash</title></head>
    <body>
        <form action="?submit" method="POST">
            <input type="text" name="pw"></input>
            <input type="submit"></input>
        </form>
        <?php 
            if(isset($_GET['submit'])){
                $pw = $_POST['pw'];
                echo dechex(rand(0, 99999999));
                echo '<br>';
                echo password_hash($pw, PASSWORD_DEFAULT);
            }
        ?>
    </body>
</html>
