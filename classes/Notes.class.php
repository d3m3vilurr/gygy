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

  function deleteItem($page_id, $note_id)
  {
    $db = new DB;
    $db->query("DELETE FROM t_note WHERE f_id = $note_id");
    $this->page->updateModifyDate();
    return $note_id;
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
    $page_id = $this->page->id;

    $items = $this->getItems();
    echo "<script type='text/javascript'>var note_count=".sizeof($items)."</script>";

    $html = '<div id="notes_block">';
    $html .= "<h2>Notes</h2>";
    $html .= '<div id="notes">';
    if ($this->isEmpty() == false) {
      foreach ($items as $item) {
        $id = $item["f_id"];
        $html .= "<div id='note_$id'>";
        $html .= "<h3 id='show_note_$id'>" . $item["f_subject"] . " <a href='#' onclick='delNote($page_id, $id)'>del</a></h3>";
        $html .= "<div class='note_content'>" . $item["f_content"] . "</div>";
        $html .= "</div>";
      }
    }
    $html .= '<div id="add_note_dialog" style="display:none;">';
    $lines = file("notes.html");
    foreach ($lines as $line) {
      $html .= $line;
    }
    $html .= "</div>";  ///< add_note_dialog div

    $html .= '<p id="add_note"><a href="#" onclick="showAddNoteDialog()">Add note</a></p>';

    $html .= "</div>";  ///< notes div
    $html .= "</div>";  ///< notes_block div
    return $html;
  }
}

?>
