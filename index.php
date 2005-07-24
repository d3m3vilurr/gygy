<?php
include("setting.php");
include("header.php");
?>

<?php
$pageid = 1;
if (isset($_GET["page"])) {
  $pageid = $_GET["page"];
}

echo "
<script type='text/javascript'>
var pageid = $pageid;
</script>
";

$page = getPage($pageid);

echo "<h1>";
echo $page->subject;
echo "</h1>\n";

echo "<div id='tools'>" . $page->getButton() . "</div>";
echo $page->getHTML();
?>

<?php
include("footer.php");
?>
