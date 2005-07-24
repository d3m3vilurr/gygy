<?php
include_once("lib/Sajax.php");

include_once("config.php");
include_once("classes/Module.class.php");

$sajax_request_type = "GET";
sajax_init();

$classes = array();

$dh = opendir("classes");
while (($file = readdir($dh)) !== false) {
  $filename = explode(".", $file);
  if ($filename[count($filename) - 1] == "php") {
    include_once("classes/" . $file);
    $classes[] = $file;
  }
}
closedir($dh);

$modules = array();
foreach ($classes as $file) {
  $filename = explode(".", $file);
  $o = new $filename[0];
  if (is_subclass_of($o, "Module")) {
    $modules[] = $filename[0];
  }
}

sajax_handle_client_request();
?>
