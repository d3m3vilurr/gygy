<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="web/style.css" type="text/css" />
<script type="text/javascript">
<?php
sajax_show_javascript();
?>
</script>
<?php
$dh = opendir("web");
while (($file = readdir($dh)) !== false) {
  $filename = explode(".", $file);
  if ($filename[count($filename) - 1] == "js") {
    echo '<script language="JavaScript" type="text/javascript" src="web/' . $file  .'"></script>';
    echo "\n";
  }
}
closedir($dh);
?>
</head>
<body onload="doLoad()">

<div id="header">
<a href="">Logout</a>
</div>

<div id="sidebar">
<a href="new.php">Make a new page</a>
<br />
<a href="index.php?page=1">Home page</a>
<?php
echo "<hr />";
$pages = Page::getRecentPages();
foreach($pages as $page) {
  echo '<a href="index.php?page=' . $page["f_id"] . '">' . $page["f_subject"] . '</a><br />';
}
?>
</div>

<div id="main">
