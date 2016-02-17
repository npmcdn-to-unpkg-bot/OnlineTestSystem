<?php
include '../core/includes.php';
$qb = new QuestionBank();
$action = array('create' => 'create', 'update' => 'update', 'delete' => 'delete', 'getListAdmin' => 'getListAdmin');
$output = array('code'=>'0',
		'message'=>'',
		'type'=>'info');
if(isset($_REQUEST['action']) && !empty($_REQUEST['action']) && isset($action[$_REQUEST['action']]))
	doAction($qb, $action[$_REQUEST['action']]);

function doAction(QuestionBank $obj, $function){
	echo json_encode($function($obj)); 
}
function getListAdmin(QuestionBank $obj){
	$course = new Course();
	$list = $obj->getList(array('id','name','course'));
    $result = array();
    $i = 0;
    foreach ($list as $item){
		$result[$i]['id'] = $item['id'];
		$result[$i]['name'] = $item['name'];
		$result[$i]['course'] = $item['course'];
		$result[$i++]['course_name'] = $course->getInfo($item['course'], 'course_name');
	}
	return $result;
}
function create(QuestionBank $obj){
	$columns = array('name','course');
	$output = array('code'=>'000',
			'message'=>'Something gone wrong. Please try again',
			'type'=>'danger');
	if($obj->create($_REQUEST['name'], $_REQUEST['course']))
		$output = array('code'=>'200',
				'message'=>'Question Bank created successfully.',
				'type'=>'success');
	return $output;
}
function delete(QuestionBank $obj){
	$output = array('code'=>'000',
			'message'=>'Something gone wrong. Please try again',
			'type'=>'danger');
	if($obj->delete($_REQUEST['id']))
		$output = array('code'=>'200',
				'message'=>'Exam deleted successfully.',
				'type'=>'success');
	return $output;
}