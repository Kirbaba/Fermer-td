<?php
if(isset($_POST['script'])){
	$root = dirname(dirname(__FILE__));
	include($root .'/core/inc/config.php');
	
	require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
	require_once($root .'/core/classes/Cabinet/Cabinet.class.php');

	switch($_POST['script']){
		case 'getAccounts';
			$cabinet = new Cabinet();
			$data = array('companyID' => $_POST['companyID']);
			$response = $cabinet->get_options('bank_accounts', $data);
			break;
	}
	return print json_encode($response);
}
?>