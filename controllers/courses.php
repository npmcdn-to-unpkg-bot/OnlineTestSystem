<?php
include '../core/includes.php';
$course = new Course();
$action = array('create' => 'create', 'update' => 'update', 'delete' => 'delete', 'getListAdmin' => 'getListAdmin');
$output = array('code'=>'0',
		'message'=>'',
		'type'=>'info');
if(isset($_REQUEST['action']) && !empty($_REQUEST['action']) && isset($action[$_REQUEST['action']]))
	doAction($course, $action[$_REQUEST['action']]);

function doAction(Course $obj, $function){
	echo json_encode($function($obj)); 
}
function getListAdmin(Course $obj){
	return $obj->getList(array('id','course_name'));
}
function create(Course $obj){
	$columns = array('name');
	$output = array('code'=>'000',
			'message'=>'Something gone wrong. Please try again',
			'type'=>'danger');
	if($obj->create($_REQUEST['name']))
		$output = array('code'=>'200',
				'message'=>'Course created successfully.',
				'type'=>'success');
	return $output;
}
function update(Course $obj){
	
}
function delete(Course $obj){
	$output = array('code'=>'000',
			'message'=>'Something gone wrong. Please try again',
			'type'=>'danger');
	if($obj->delete($_REQUEST['id']))
		$output = array('code'=>'200',
				'message'=>'Course deleted successfully.',
				'type'=>'success');
	return $output;
}