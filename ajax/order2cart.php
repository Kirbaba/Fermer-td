<?php
if(isset($_GET['orderID']) && $_GET['orderID'] != 0){
	$root = dirname(dirname(__FILE__));
	include($root .'/core/inc/config.php');
	
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
	require_once($root .'/core/classes/Shop/Cart.class.php');
	require_once($root .'/core/classes/Cabinet/Cabinet.class.php');

	$cart = new Cart();
	$cabinet = new Cabinet();
	$cabinet->order2cart();
	$response = $cart->get_cart_info();

	return print json_encode($response);
}
?>