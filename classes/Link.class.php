<?php

class Link extends Module {
  var $page;
  
  function Link($page = 0) {
    if ($page == 0) {
      return;
    }
    $this->page = $page;
  }

  function getItems() {
    $db = new DB;
    $query = sprintf("SELECT t_page.f_id AS id, ".
		     "       t_page.f_subject AS subject, ".
		     "       t_link.f_page_peer_id AS peer ".
		     "FROM t_page LEFT JOIN t_link ".
		     "ON t_page.f_id = t_link.f_page_peer_id ".
		     "AND t_link.f_page_id = %s ".
		     "WHERE t_page.f_id != %s",
		     $this->page->id,
		     $this->page->id);
    /*
    $query = sprintf("SELECT f_subject FROM t_link, t_page " .
		      "WHERE f_page_id = '%s' ".
		     "AND f_page_peer_id = t_page.f_id ",
		     $this->page->id);
    */
    #echo "query : " . $query . "<br />\n";
    $result = $db->query($query);
    $items = array();

    while ($row = mysql_fetch_assoc($result)) {
      $items[] = $row;
    }
    #var_dump ($items);
    return $items;
  }

  function createItem($page_peer) {
    $db = new DB;
    $p1 = $this->page->id;
    $p2 = $page_peer;

    syslog(LOG_INFO, rand() ."--" . __FILE__ .":". __LINE__  .":" . __FUNCTION__);
    if ($p1 == $p2) {
      return;
    } else {
      $query = "INSERT INTO t_link (f_page_id, f_page_peer_id) ".
	"VALUES (" . $p2 . "," . $p1 . ")";
      $result = $db->query($query);
      $query = "INSERT INTO t_link (f_page_id, f_page_peer_id) ".
	"VALUES (" . $p1 . "," . $p2 . ")";
      $result = $db->query($query);
      $this->page->updateModifyDate();
    }
  }

  function deleteItem() {
    
  }
  
  function isEmpty() {
    $db = new DB;

    $result = $db->query("SELECT count(*) FROM t_link " .
			 " WHERE f_page_id=".$this->page->id);

    $row = mysql_fetch_assoc($result);
    $count = $row["count(*)"];

    return $count == 0;
    
  }

  function getButton() {
    return sprintf('<a href="#" onclick="showLink(%d)"><img src="web/t-links-off.gif" alt="Link" /></a>', $this->page->id);
  }

  function getHTML() {
    $candidates = "";
    $links = "";

    $html = '<div id="link_content" style="display:block">';
    $html .= "Link<hr/>";

    
    if ($this->isEmpty() == false) {
      $items = $this->getItems();
      //$items = $this->getCandidates();
      foreach ($items as $item) {
	if ($item["peer"]) {
	  $links .= "<a href=\"index.php?page=" . $item["id"] . '">' . $item["subject"] . "</a></br />\n";
	}
	else {
	    #var_dump($item);
	  $candidates .= sprintf ("<option value=\"%s\">%s</option>",
				  $item["id"],
				  $item["subject"]);
	}
      }
      $html .= $links;
      $html .= '<div id="linkInputFormLink"><a href="#" onclick="showLinkItemInputForm(' . $this->page->id . ')">Add item</a></div>';
    }




    $html .= '<div id="inputLinkItemForm">';
    if ($this->isEmpty()) {
      $html .= Link::getLinkItemInputForm($this->page->id, $candidate);
    }
    $html .= '</div>';

    if ($this->isEmpty()) {
      $html .= "<script>_g('link_content').style.display='none';</script>";
    }

    return $html;
  }

  function getLinkItemInputForm($page_id) {
    $page = new Page($page_id);
    $link = $page->getobject("Link");
    $items = $link->getItems();
    //$items = $this->getCandidates();
    foreach ($items as $item) {
      if (!$item["peer"]) {
#var_dump($item);
	$candidates .= sprintf ("<option value=\"%s\">%s</option>",
				$item["id"],
				$item["subject"]);
      }
    }


    $html .= "<select id=\"existLinkItem\" name=\"exist_link\">\n";
    $html .= $candidates;
    $html .= "</select>\n";
    $html .= '<form action="#" method="post">';
    $html .= '<input id="inputLinkItem" type="text" name="peer_page_id" style="width:300px"/><br />';
    $html .= '<input type="button" value="Add Item" onclick="addLinkItem(' .$page_id .  ' )"/>';
    $html .= 'or <a href="#">Close</a>';
    $html .= '</form>';
    return $html;
  }
}

function showlink($page_id) {
  $page = new Page($page_id);
  #var_dump($page_id);
  $link = $page->getObject("Link");
  return $link->getHtml();
}

function addlinkitem($page_id, $peer_page_id) {
  #var_dump($page_id);
  $page = getPage($page_id);
  $link = $page->getObject("Link");
  #var_dump($link);
  $link->createItem($peer_page_id);
  return $page_id;
}

function showlinkiteminputform($page_id) {

  return Link::getLinkItemInputForm($page_id);
}


sajax_export("showlink");
sajax_export("addlinkitem");
sajax_export("showlinkiteminputform");
?>