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

$page = new Page($pageid);

echo "<h1>";
echo $page->subject;
echo "</h1>\n";

echo '<a href="#" onclick="editBody(' . $page->id . ');">Edit Body</a> ';
echo '<a href="#" onclick="showList(' . $page->id . ');">List</a> ';
echo '<a href="#" onclick="showNotes(' . $page->id . ');">Notes</a><br /><br />';

echo $page->getHTML();
?>

<?php
include("footer.php");
?>
