<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orderDetails'])){
	$root = dirname(dirname(__FILE__));
	

	//подключаем конфиг сайта
	include($root .'/core/inc/config.php');
	require_once($root .'/core/classes/Site/Content.class.php');
	require_once($root .'/core/classes/Site/Message.class.php');
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');

	if($_POST['capcha'] == $_SESSION['capcha']){
		$content = new Content();
		$response = $content->order_product();
		
		$code = $response['code'];
		$replace = $response['replace'];
	}else{
		$code = 91;
		$replace = '';
	}

	//получение сообщения
	$message = new Message($code, $replace);
	$msg = $message->printMessage();
	$response= array('message' => $msg);
	return print json_encode($response);
}
?>