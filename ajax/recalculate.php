<?php
if(isset($_GET['productID'], $_GET['name']) && ($_GET['productID'] != 0 || $_GET['productID'] != '')){
	$root = dirname(dirname(__FILE__));
	include($root .'/core/inc/config.php');
	
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
	require_once($root .'/core/classes/Shop/Cart.class.php');

	$cart = new Cart();
	$product_id = $_GET['productID'];
	$count = $_GET['count'];
	$cart->set_item_quantity($product_id, $count);
	$response = $cart->get_cart_info();

	return print json_encode($response);
}
?>