<?php
include_once("config.php");
include_once("classes/DB.class.php");
include_once("classes/Page.class.php");
include_once("classes/Body.class.php");
include_once("classes/GList.class.php");

include_once("lib/Sajax.php");

function savebody($page_id, $content) { //FIXME: move to some other file :(
  $page = new Page($page_id);
  $page->body->saveContent($content);
  return $content;
}

function showlist($page_id) {
  $page = new Page($page_id);
  return $page->list->getHTML();
}

function addlistitem($page_id, $content) {
  $page = new Page($page_id);
  print $content;
  $page->list->createItem($content);
}

$sajax_request_type = "GET";
sajax_init();
sajax_export("savebody");
sajax_export("showlist");
sajax_export("addlistitem");
sajax_handle_client_request();
?>