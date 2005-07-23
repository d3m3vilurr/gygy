<?php

class GList {
  var $page;
  
  function GList($page) {
    $this->page = $page;
  }

  function getItems() {
    $db = new DB;
    $result = $db->query("select * from t_list where f_page_id = '" . $this->page->id . "' and f_status = 1");
    $items = array();
    while ($row = mysql_fetch_assoc($result)) {
      $items[] = $row;
    }
    return $items;
  }

  function getCompleteItems() {
    $db = new DB;
    $result = $db->query("select * from t_list where f_page_id = '" . $this->page->id . "' and f_status = 2");
    $items = array();
    while ($row = mysql_fetch_assoc($result)) {
      $items[] = $row;
    }
    return $items;
  }

  function createItem($content) {
    $db = new DB;
    $db->query("insert into t_list (f_page_id, f_content, f_status) values ('" . $this->page->id . "', '" . $content . "', '1')");
    $this->page->updateModifyDate();
  }

  function deleteItem() {
    //f_status + 1. if f_status > 2, delete it
  }

  function isEmpty() {
    $db = new DB;
    $result = $db->query("select count(*) from t_list where f_page_id = '" . $this->page->id . "'");
    $row = mysql_fetch_assoc($result);
    $count = $row["count(*)"];
    return $count == 0;
  }

  function getHTML() {
    $html = "";
    $html .= "List<hr/>";
    if ($this->isEmpty() == false) {
      $items = $this->getItems();
      foreach ($items as $item) {
	$html .= $item["f_content"] . "<br />";
      }
    }
    $html .= '<form action="#" method="post">';
    $html .= '<input id="inputListItem" type="text" name="content" style="width:300px"/><br />';
    $html .= '<input type="button" value="Add Item" onclick="addListItem(' . $this->page->id .  ' )"/>';
    $html .= 'or <a href="#">Close</a>';
    $html .= '</form>';
    return $html;
  }
}

?>