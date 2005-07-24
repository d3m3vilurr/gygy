<?php

class Page {
  var $id;
  var $subject;
  var $body;
  var $objects;
  
  function Page($id = 0) {
    if ($id == 0) {
      return;
    }
    $this->id = $id;
    $db = new DB;
    $result = $db->query("select * from t_page where f_id=" . $id . "");
    $r = mysql_fetch_assoc($result);
    $this->subject = $r["f_subject"];
    
    $this->body = new Body($this);
    
    $this->objects = array();
    global $modules;
    foreach ($modules as $moduleName) {
      $o = new $moduleName($this);
      $this->objects[$moduleName] = $o;
    }
  }

  function getObject($name) {
    return $this->objects[$name];
  }

  function getButton() {
    $html = $this->body->getButton();
    foreach ($this->objects as $o) {
      $html .= $this->getSeparator() . $o->getButton();
    }
    return $html;
  }

  function getSeparator()
  {
    return " ";
  }

  function getHTML() {
    $html = $this->body->getHTML();
    foreach ($this->objects as $o) {
      $html .= $o->getHTML();
    }
    return $html;
  }

  function updateModifyDate() {
    $db = new DB;
    $db->query("update t_page set f_last_modify_date = '" . time() . "' where f_id='" . $this->id . "'");
  }

  function getRecentPages() {
    $db = new DB;
    $result = $db->query("select f_id, f_subject from t_page where f_id != 1 order by f_last_modify_date desc limit 10"); //TODO: get last 10 pages
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
