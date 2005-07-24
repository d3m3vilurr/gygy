<?php
	include_once("config.php");
	include_once("classes/DB.class.php");

	$items_id = array();
	$items_subject = array();
	$items_last_modify_date = array();
	$items_description = array();
	$items_num;
	$max_items_num = 10;
	$title = "RSS_TEST"; //TODO : title 받아 오기 
	$title_description = "RSS_TEST_DESCRIPTION"; // TODO : description 받아오기

	$db = new DB;
	$result = $db->query("select * from t_page order by f_last_modify_date desc limit ".$max_items_num);
	// get data
	while ( $row = mysql_fetch_assoc($result) ) {
		$items_id[] = $row["f_id"];
		$items_subject[] = $row["f_subject"];
		$items_last_modify_date[] = $row["f_last_modify_date"];
	}
	foreach ( $items_id as $item_id ) {
		$result = $db->query("select f_content from t_body where f_page_id = ".$item_id);
		$row= mysql_fetch_assoc($result);
		$items_description[]= $row["f_content"];
	}
	$items_num = count($items_id);

	// show data
	$encoding = "utf-8";
	if (isset($_GET["encoding"])) {
		$encoding = $_GET["encoding"];
	}
	if ( $encoding == "cp949" || $encoding == "euc-kr" ) {
		for ( $i = 0; $i < $items_num; $i++ ) {
			$items_subject[$i] = iconv("UTF-8","EUC-KR",$items_subject[$i]);
			$items_description[$i] = iconv("UTF-8","EUC-KR",$items_description[$i]);
		}
		$title_description = iconv("UTF-8","EUC-KR",$title_description);
	}
	header ("Content-Type: text/xml; charset=$encoding");
	echo "<?xml version=\"1.0\"  encoding=\"$encoding\"?>\n<rss version=\"2.0\">\n<channel>\n";
	echo "	<title>$title</title>\n";
	echo "	<link> </link>\n"; // TODO : $link
	echo "	<description>$title_description</description>\n";
	for ( $i = 0; $i < $items_num; $i++ ) {
		echo "	<item>\n";
		echo "		<title>$items_subject[$i]</title>\n";
		echo "		<link> </link>\n"; // TODO : $link
		echo "		<pubDate>".date("l dS of F Y h:i:s A")."</pubDate>\n";
		echo "		<lastBuildDate>".date("l dS of F Y h:i:s A",$items_last_modify_date[$i])."</lastBuildDate>\n";
		echo "		<description>".$items_description[$i]."</description>\n";
		echo "	</item>\n";
	}
	echo "</channel>\n</rss>";
?>
