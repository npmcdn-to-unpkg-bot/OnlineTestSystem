<?php 
include '../core/includes.php';
$config = new Config();
$auth = new Auth();
$action = $_REQUEST['action'];
if(!$auth->isAdmin() || !isset($_REQUEST['action'])){
	echo "Please try accssing data with valid permissions and page.";
	exit();
}
$users = new User();
if($_REQUEST['action'] == 'getStudents')
	echo json_encode($users->getUsers(array('id','name','branch','college')));
?>