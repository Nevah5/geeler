<?php
$lang = "de";
$file = fopen("$lang.txt", "r");
$before = false;
echo "INSERT INTO lang VALUES" . PHP_EOL;
while($line = fgets($file)){
  $content = explode(":", $line);
  $content = str_replace(array("\r", "\n"), '', $content);
  $content[1] = str_replace('"', '""', $content[1]);
  if($content[0] != ""){
    echo $before ? "," . PHP_EOL : $before = true;
    echo "(\"" . $content[0] . "\", \"" . $content[1] . "\", \"" . strtoupper($lang) . "\")";
  }
}
echo ";";

fclose($file);
