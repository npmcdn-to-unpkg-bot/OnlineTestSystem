<?php
include '../core/includes.php';
$auth = new Auth();
$user = new User();
$config = new Config();
$output = array(
		'code' => 0,
		'message' => '',
		'type' => 'success'
		);
if(!isset($_POST['username']) || !isset($_POST['password'])){
	$output['code'] = 403;
	$output['type'] = 'danger';
	$output['message'] = 'Please try to log in through login page or <a href="'.$config->site_address.'login">click here</a>';
}else if((int)$_POST['username'] < 1000000000 || (int)$_POST['username'] > 9999999999){
	$output['code'] = 501;
	$output['type'] = 'danger';
	$output['message'] = 'Username must be of 10 digit';
}else if(strlen($_POST['password']) < 4){
	$output['code'] = 502;
	$output['type'] = 'danger';
	$output['message'] = 'Password must be of at least 4 chars';
}else if($auth->checkAdmin($_POST['username'], $_POST['password'], true)){
	$output['code'] = 200;
	$output['type'] = 'success';
	$output['message'] = 'Logged in successfully.';
}else{
	Requests::register_autoloader();
	$responce = Requests::post("https://www.psit.in/psit/loginlist.php",array(),array('username' => $_POST['username'], 'password' => $_POST['password'], 'rand' => '5266'));
	$data = $responce->body;
	if($data == "164"){
		$output['code'] = 200;
		$output['type'] = 'success';
		$output['message'] = 'Logged in successfully.';
		if(!$user->isUser($_POST['username']))
			$user->makeUser($_POST['username']);
		$auth->letHimGainAccess($_POST['username']);
	}else{
		$output['code'] = 404;
		$output['type'] = 'danger';
		$output['message'] = 'Username/Password is wrong';
	}
}
echo json_encode($output);