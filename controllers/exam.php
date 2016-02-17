<?php
include '../core/includes.php';
$exam = new Exam();
$action = array('create' => 'create', 'update' => 'update', 'delete' => 'delete', 'getExamsListAdmin' => 'getExamsListAdmin');
$output = array('code'=>'0',
		'message'=>'',
		'type'=>'info');
if(isset($_REQUEST['action']) && !empty($_REQUEST['action']) && isset($action[$_REQUEST['action']]))
	doAction($exam, $action[$_REQUEST['action']]);

function doAction(Exam $obj, $function){
	echo json_encode($function($obj)); 
}
function getExamsListAdmin(Exam $obj){
	return $obj->getExams(array('id','name','start_time'));
}
function create(Exam $obj){
	$columns = array('exam_name','start_time','end_time','exam_duration','exam_student_group','show_result','exam_about','exam_type');
	$output = array('code'=>'000',
			'message'=>'Something gone wrong. Please try again',
			'type'=>'danger');
	if($obj->createExam($_REQUEST[$columns[0]], $_REQUEST[$columns[1]], $_REQUEST[$columns[2]], $_REQUEST[$columns[3]], $_REQUEST[$columns[4]], $_REQUEST[$columns[5]], $_REQUEST[$columns[6]], $_REQUEST[$columns[7]]))
		$output = array('code'=>'200',
				'message'=>'Exam created successfully.',
				'type'=>'success');
	return $output;
}
function update(Exam $obj){
	
}
function delete(Exam $obj){
	$output = array('code'=>'000',
			'message'=>'Something gone wrong. Please try again',
			'type'=>'danger');
	if($obj->deleteExam($_REQUEST['id']))
		$output = array('code'=>'200',
				'message'=>'Exam deleted successfully.',
				'type'=>'success');
	return $output;
}