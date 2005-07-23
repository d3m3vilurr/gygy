<?php
include("setting.php");

if (isset($_POST["subject"])) {
  Page::createPage($_POST["subject"], $_POST["content"], time());
  header("Location: index.php");
  exit();
}

include("header.php");
?>

<form action="new.php" method="post">
Enter the title of your new page<br />
<input type="text" name="subject" style="width: 90%;" /><br />
<i>Optional: Enter body text for this page (you can do this later)</i><br />
<textarea name="content" style="width: 90%; height: 150px;"></textarea><br />
<br />
<input type="submit" value="Create"> or <a href="index.php">Cancel</a>
</form>

<?php
include("footer.php");
?>