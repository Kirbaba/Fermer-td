<?php
if(isset($_POST['productID']) && ($_POST['productID'] != 0 || $_POST['productID'] != '')){
	$root = dirname(dirname(__FILE__));
	include($root .'/core/inc/config.php');
	
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
	require_once($root .'/core/classes/Shop/Cart.class.php');

	$cart = new Cart();
	$cart->add_item_2_cart();
	$response = $cart->get_cart_info();

	return print json_encode($response);
}
?>