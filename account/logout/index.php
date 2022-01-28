<?php
session_start();
session_destroy();
setcookie("stayloggedin", "", time()-60, "/");
header("Location: ../../login/");