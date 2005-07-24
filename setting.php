<?php
include_once("config.php");
include_once("classes/Module.class.php");

$classes = array();
$dh = opendir("classes");
while (($file = readdir($dh)) !== false) {
  $filename = explode(".", $file);
  if ($filename[count($filename) - 1] == "php") {
    include_once("classes/" . $file);
    $classes[] = $file;
  }
}
closedir($dh);

$modules = array();
foreach ($classes as $file) {
  $filename = explode(".", $file);
  $o = new $filename[0];
  if (is_subclass_of($o, "Module")) {
    $modules[] = $filename[0];
  }
}

include_once("lib/Sajax.php");

function savebody($page_id, $content) { //FIXME: move to some other file :(
  $page = new Page($page_id);
  $page->body->saveContent($content);
  return $content;
}

function showlist($page_id) {
  $page = new Page($page_id);
  $list = $page->getObject("GList");
  return $list->getHTML();
}

function addlistitem($page_id, $content) {
  $page = new Page($page_id);
  $list = $page->getObject("GList");
  $list->createItem($content);
  return $page->id;
}

function showlistiteminputform($page_id) {
  return GList::getListItemInputForm($page_id);
}

function checklistitem($page_id, $item_id, $status) {
  $page = new Page($page_id);
  $list = $page->getObject("GList");
  $list->changeItemStatus($item_id, $status);
  return $page->id;
}

function shownotes($page_id) {
  $page = new Page($page_id);
  $notes = $page->getObject("Notes");
  return $notes->getHTML();
}

function addnote($page_id, $subject, $content)
{
  $page = new Page($page_id);
  $notes = $page->getObject("Notes");
  return $notes->createItem($subject, $content);
}

function delnote($page_id, $note_id)
{
  $page = new Page($page_id);
  $notes = $page->getObject("Notes");
  return $notes->deleteItem($page_id, $note_id);
}

$sajax_request_type = "GET";
sajax_init();
sajax_export("savebody");
sajax_export("showlist");
sajax_export("addlistitem");
sajax_export("shownotes");
sajax_export("addnote");
sajax_export("showlistiteminputform");
sajax_export("delnote");
sajax_export("checklistitem");
sajax_handle_client_request();
?>
