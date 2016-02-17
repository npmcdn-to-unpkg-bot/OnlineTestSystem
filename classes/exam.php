<?php
class Exam{
	public $table = "exams";
	public $db;
	function __construct(){
		$this->db = new DBManager();
	}
	function createExam($name, $start_time, $end_time, $duration, $student_group, $show_result, $type, $about){
		if(is_array($student_group))
			$student_group = implode(";", $student_group);
		$columns = array('name','start_time','end_time','duration','student_group','show_result','type','about');
		$data = array($name, $start_time, $end_time, $duration, $student_group, $show_result, $type, $about);
		return $this->db->insertData($this->table, $columns, $data);
	}
	function isExam($id){
		return $this->db->isExist($this->table, 'id', 'id="$id"');
	}
	function getExams($info, $groups = 'all', $activeCurrentlyOnly = false){
		$where = "student_group='$groups' ORDER BY `creation_date` DESC";
		if ($groups == 'all')
			$where = "id != 0 ORDER BY `creation_date` DESC ";
		return $this->db->getDataGrid($this->table, $info, $where);	
	}
	function updateExamInfo($id){
		
	}
	function deleteExam($id){
		return $this->db->deleteRow($this->table, "id='$id'");
	}
}