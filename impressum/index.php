<?php session_start(); ob_start(); ?>
<html>
    <head>
        <title>Datenschutzerklärung - Geeler.net</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="responsive.css">
        <?php //DARKMODE & LIGHTMODE CSS
        if($_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="design.css">
        <?php }else{ ?>
        <link rel="stylesheet" href="design_dark.css">
        <?php } ?>

        <?php //STATIC & MOVING BACKGROUND CSS
        if($_COOKIE['background'] != 'static' AND $_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="../media/site/background.css">
        <?php }else if($_COOKIE['background'] == 'static' AND $_COOKIE['theme'] != 'dark'){ ?>
        <link rel="stylesheet" href="../media/site/background_static.css">
        <?php }else if($_COOKIE['background'] == 'static' AND $_COOKIE['theme'] == 'dark'){ ?>
            <link rel="stylesheet" href="../media/site/background_static_dark.css">
        <?php }else{ ?>
            <link rel="stylesheet" href="../media/site/background_dark.css">
        <?php } ?>
        <link rel="stylesheet" href="widgets.css">
        <link rel="icon" href="../media/icon/logo_small_icon.png">
        <script src="https://kit.fontawesome.com/a44080dbce.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include("../media/site/header.inc.php"); ?>
        <div class="body">
            <h1 id="title">Impressum</h1>
            <p><strong>Kontakt-Adresse</strong></p><p>Noah Geeler<br/>Ruchwiesenstrasse 66<br/>8404 Winterthur<br/>Schweiz</p><p>E-Mail:<br/>noah.d.geeler@gmail.com</p><br/><br/><p><strong>Haftungsausschluss</strong></p>Der Autor &uuml;bernimmt keinerlei Gew&auml;hr hinsichtlich der inhaltlichen Richtigkeit, Genauigkeit, Aktualit&auml;t, Zuverl&auml;ssigkeit und Vollst&auml;ndigkeit der Informationen.</p><p>Haftungsanspr&uuml;che gegen den Autor wegen Sch&auml;den materieller oder immaterieller Art, welche aus dem Zugriff oder der Nutzung bzw. Nichtnutzung der ver&ouml;ffentlichten Informationen, durch Missbrauch der Verbindung oder durch technische St&ouml;rungen entstanden sind, werden ausgeschlossen.</p><p>Alle Angebote sind unverbindlich. Der Autor beh&auml;lt es sich ausdr&uuml;cklich vor, Teile der Seiten oder das gesamte Angebot ohne besondere Ank&uuml;ndigung zu ver&auml;ndern, zu erg&auml;nzen, zu l&ouml;schen oder die Ver&ouml;ffentlichung zeitweise oder endg&uuml;ltig einzustellen.</p><br/><br/><p><strong>Haftungsausschluss f&uuml;r Links</strong></p><p>Verweise und Links auf Webseiten Dritter liegen ausserhalb unseres Verantwortungsbereichs. Es wird jegliche Verantwortung f&uuml;r solche Webseiten abgelehnt. Der Zugriff und die Nutzung solcher Webseiten erfolgen auf eigene Gefahr des jeweiligen Nutzers.</p><br/><br/><p><strong>Urheberrechte</strong></p><p>Die Urheber- und alle anderen Rechte an Inhalten, Bildern, Fotos oder anderen Dateien auf dieser Website, geh&ouml;ren ausschliesslich <strong>Noah Geeler</strong> oder den speziell genannten Rechteinhabern. F&uuml;r die Reproduktion jeglicher Elemente ist die schriftliche Zustimmung des Urheberrechtstr&auml;gers im Voraus einzuholen.</p><br/><br/><!--ACHTUNG: Wenn Sie die Quelle ohne Erlaubnis von SwissAnwalt entfernen, dann begehen Sie eine Urheberrechtsverletzung welche in jedem Fall geahndet wird.--><span>Quelle:</span> <a href="https://www.swissanwalt.ch" target="_blank" rel="noopener">SwissAnwalt</a><!--Bitte beachten Sie die AGB von SwissAnwalt betreffend allf&auml;llig anfallenden Kosten bei Weglassen der Quelle!-->
        </div>
        <?php include("../media/site/footer.inc.php"); ?>
    </body>
</html>