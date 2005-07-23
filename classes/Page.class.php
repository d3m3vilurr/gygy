<?php

class Page {
  var $id;
  var $subject;
  var $body;
  var $list;
  
  function Page($id) {
    $this->id = $id;
    $db = new DB;
    $result = $db->query("select * from t_page where f_id=" . $id . "");
    $r = mysql_fetch_assoc($result);
    $this->subject = $r["f_subject"];
    
    $this->body = new Body($this);
    $this->list = new GList($this);
  }
 
  function getHTML() {
    $html = $this->body->getHTML();
    $html .= $this->list->getHTML();
    return $html;
  }

  function updateModifyDate() {
    $db = new DB;
    $db->query("update t_page set f_last_modify_date = '" . time() . "' where f_id='" . $this->id . "'");
  }

  function getRecentPages() {
    $db = new DB;
    $result = $db->query("select f_id, f_subject from t_page where f_id != 1 order by f_last_modify_date desc"); //TODO: get last 10 pages
    $pages = array();
    while ($row = mysql_fetch_assoc($result)) {
      $pages[] = $row;
    }
    return $pages;
  }

  function createPage($subject, $content, $date) {
    $db = new DB;
    $db->query("insert into t_page (f_subject, f_last_modify_date) values ('" . $subject . "', '" . $date . "');");
    $pageid = mysql_insert_id();
    if ($content != "") {
      $db->query("insert into t_body (f_page_id, f_content) values ('" . $pageid . "', '" . $content . "');");
    }
  }
}