<?php
$lang = "de";
$file = fopen("$lang.txt", "r");
$before = false;
echo "INSERT INTO lang VALUES" . PHP_EOL;
while($line = fgets($file)){
  //split up line with both title and value
  $content = explode(":", $line);
  $content = str_replace(array("\r", "\n"), '', $content);
  $title = $content[0];
  $value = str_replace('"', '""', $content[1]);

  //splits title into new and type of tupel
  $title = explode(".", $title);
  $type = $title[0];
  unset($title[0]);
  $title = implode(".", $title);

  if($title != ""){
    echo $before ? "," . PHP_EOL : "";
    $before = true;
    echo "(\"" . strtoupper($lang) . "\", \"" . $type . "\", \"". $title ."\", \"" . $value . "\")";
  }
}
echo ";";

fclose($file);
