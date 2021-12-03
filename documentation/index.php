<?php
    $file = getcwd() . '/GeelerNET-Documentation.zip';
    // http headers for zip downloads
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"GeelerNET-Documentation.zip\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($file));
    ob_end_flush();
    @readfile($file);
?>