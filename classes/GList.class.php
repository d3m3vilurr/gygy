<?php

class GList extends Module {
  var $page;
  
  function GList($page = 0) {
    if ($page == 0) {
      return;
    }
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

  function changeItemStatus($item_id, $status) {
    $db = new DB;
    if ($status <= 2) {
      $db->query("update t_list set f_status = " . $status . " where f_id = " . $item_id);
    } else {
      $db->query("delete from t_list where f_id = " . $item_id);
    }
    $this->page->updateModifyDate();
  }

  function isEmpty() {
    $db = new DB;
    $result = $db->query("select count(*) from t_list where f_page_id = '" . $this->page->id . "'");
    $row = mysql_fetch_assoc($result);
    $count = $row["count(*)"];
    return $count == 0;
  }

  function getButton() {
    return sprintf('<a href="#" onclick="showList(%d)">List</a>', $this->page->id);
  }

  function getHTML() {
    $html = '<div id="list_content" style="display:block">';
    $html .= "<h2>List</h2>";
    if ($this->isEmpty() == false) {
      $items = $this->getItems();
      foreach ($items as $item) {
	$html .= '<input type="checkbox" onclick="checkListItem(' . $this->page->id . ',' . $item["f_id"] . ', 2)"/>';
	$html .= $item["f_content"];
	$html .= "<br />";
      }
      $html .= '<div id="inputFormLink"><a href="#" onclick="showListItemInputForm(' . $this->page->id . ')">Add item</a></div>';
    }
    $html .= '<div id="inputListItemForm">';
    if ($this->isEmpty()) {
      $html .= GList::getListItemInputForm($this->page->id);
    }
    $html .= '</div>';
    if ($this->isEmpty() == false) {
      $items = $this->getCompleteItems();
      foreach ($items as $item) {
	$html .= '<input type="checkbox" onclick="checkListItem(' . $this->page->id . ',' . $item["f_id"] . ', 1)"/>';
	$html .= $item["f_content"];
	$html .= ' <a href="#" onclick="checkListItem(' . $this->page->id . ',' . $item["f_id"] . ', 3)">delete</a>';
	$html .= "<br />";
      }
    }
    $html .= '</div>';
    if ($this->isEmpty()) {
      $html .= "<script>_g('list_content').style.display='none';</script>";
    }
    return $html;
  }

  function getListItemInputForm($page_id) {
    $html = '<form action="#" method="post">';
    $html .= '<input id="inputListItem" type="text" name="content" style="width:300px"/><br />';
    $html .= '<input type="button" value="Add Item" onclick="addListItem(' . $page_id .  ' )"/>';
    $html .= 'or <a href="#" onclick="hideListItemInputForm()">Close</a>';
    $html .= '</form>';
    return $html;
  }
}

?>
