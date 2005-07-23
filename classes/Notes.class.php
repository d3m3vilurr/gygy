<?php
class Notes {
  var $page;

  function Notes($page) {
    $this->page = $page;
  }

  function createItem($subject, $content) {
    $db = new DB;
    $db->query("INSERT INTO t_note (f_page_id, f_subject, f_content)  values (" . $this->page->id . ", '" . $subject . "', '" . $content . "')");
    $this->page->updateModifyDate();
    return "INSERT INTO t_note (f_page_id, f_subject, f_content)  values (" . $this->page->id . ", '" . $subject . "', '" . $content . "')";
  }

  function getItems()
  {
      $db = new DB;
      $result = $db->query("SELECT * FROM t_note WHERE f_page_id=" . $this->page->id);
      $items = array();
      while ($row = mysql_fetch_assoc($result)) {
        $items[] = $row;
      }
      return $items;
  }

  function isEmpty()
  {
    $db = new DB;
    $result = $db->query("select count(*) from t_note where f_page_id=" . $this->page->id);
    $row = mysql_fetch_assoc($result);
    $count = $row["count(*)"];
    return $count == 0;
  }

  function getHTML()
  {
    $html = "";
    $html .= "<h2>Notes</h2>";
    if ($this->isEmpty() == false) {
      $items = $this->getItems();
      foreach ($items as $item) {
        $html .= "<div class='note'>";
        $html .= "<h3>" . $item["f_subject"] . "</h3>";
        $html .= $item["f_content"];
        $html .= "</div>";
      }
    }
    $lines = file("notes.html");
    foreach ($lines as $line) {
      $html .= $line;
    }
    return $html;
  }
}

?>
