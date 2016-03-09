<?php
if(isset($_GET['productId']) && ($_GET['productId'] != 0 || $_GET['productId'] != '')){
	$root = dirname(dirname(__FILE__));
	include($root .'/core/inc/config.php');
	
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
	require_once($root .'/core/classes/Cabinet/Cabinet.class.php');

	$cabinet = new Cabinet();
	$response = $cabinet->add_item2bookmarks();

	return print json_encode($response);
}
if(isset($_POST['productId']) && ($_POST['productId'] != 0 || $_POST['productId'] != '')){
	$root = dirname(dirname(__FILE__));
	include($root .'/core/inc/config.php');
	
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
	require_once($root .'/core/classes/Cabinet/Cabinet.class.php');

	$cabinet = new Cabinet();
	$response = $cabinet->removeBookmark();

	return print json_encode($response);
}
?>