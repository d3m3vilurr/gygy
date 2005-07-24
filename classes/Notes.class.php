<?php
class Notes extends Module {
  var $page;

  function Notes($page = 0) {
    if ($page == 0) {
      return;
    }
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

  function getButton() {
    return sprintf('<a href="#" onclick="showNotes(%d)"><img src="web/t-notes-off.gif" alt="Notes" /></a>', $this->page->id);
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
        $html .= "<h3 id='show_note_$id'>";
        $html .= $item["f_subject"];
        $html .= " <span id='edit_note_${id}_link2'><a href='#' class='trashcan' onclick='delNote($page_id, $id)'>del</a></span>";
        $html .= "</h3>";
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

    $html .= '<p id="add_note"><a href="#" onclick="showAddNoteDialog()">Add note</a> | <a href="#">Reorder</a></p>';

    $html .= "</div>";  ///< notes div
    $html .= "</div>";  ///< notes_block div
    return $html;
  }
}

function shownotes($page_id) {
  $page = new Page($page_id);
  $notes = $page->getObject("Notes");
  return $notes->getHTML();
}
sajax_export("shownotes");

function addnote($page_id, $subject, $content)
{
  $page = new Page($page_id);
  $notes = $page->getObject("Notes");
  return $notes->createItem($subject, $content);
}
sajax_export("addnote");

function delnote($page_id, $note_id)
{
  $page = new Page($page_id);
  $notes = $page->getObject("Notes");
  return $notes->deleteItem($page_id, $note_id);
}
sajax_export("delnote");

?>