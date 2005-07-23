<?php

class DB {
  function DB() {
    global $db_host, $db_name, $db_user, $db_pass;
    $this->host = $db_host;
    $this->db = $db_name;
    $this->user = $db_user;
    $this->pass = $db_pass;
    $this->link = mysql_connect($this->host, $this->user, $this->pass);
    mysql_select_db($this->db);
    register_shutdown_function(array(&$this, "close"));
  }

  function query($query) {
    $result = mysql_query($query, $this->link);
    return $result;
  }

  function close() {
    mysql_close($this->link);
  }
}

?>