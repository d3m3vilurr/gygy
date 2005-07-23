<?php

class Body {
  var $id;
  var $page;
  var $content;

  function Body($page) {
    $this->page = $page;
    
    $db = new DB;
    $result = $db->query("select * from t_body where f_page_id=" . $page->id . "");
    $r = mysql_fetch_assoc($result);
    $this->id = $r["f_id"];
    $this->content = $r["f_content"];
  }

  function saveContent($content) { //rename to setContent?
    $db = new DB;
    $db->query("update t_body set f_content = '" . $content . "' where f_id ='" . $this->id . "'");
    $this->page->updateModifyDate();
  }

  function getHTML() {
    $html = '<div id="body_content">';
    $html .= $this->content;
    $html .= "</div>";
    return $html;
  }
}

?>