<?php
class QuestionBank {
	private $db;
	private $qb_table = "question_banks";
	private $q_table = "question_bank";
	private $course;
	function __construct(){
		$this->db = new DBManager();
		$this->course = new Course();
	}
	function create($name, $course){
		if ($this->course->isCourse($course))
			return $this->db->insertData($this->qb_table, array('name','course'), array($name, $course));
		return false;
	}
	function isQb($id){
		return $this->db->isExist($this->qb_table, 'id', "id = '$id'");
	}
	function delete($id){
		return $this->deleteQuestionByQbId($id) && $this->db->deleteRow($this->qb_table, "id = '$id'");
	}
	function deleteQBByCourseId($courseId){
		$list = Comman::convertArrayToSingle($this->getList(array('id'), $courseId), 'id');
		foreach ($list as $item)
			$this->delete($item);
		return true;
	}
	function getList($info = array(), $course = 'all'){
		$where = "course = '$course'";
		if($course == 'all')
			$where = "id != 0";
		return $this->db->getDataGrid($this->qb_table, $info, $where . " ORDER BY `creation_date` DESC");
	}
	function getInfo($id, $info){
		if($this->isQb($id))
			return $this->db->getSingleData($this->qb_table, $info, "id='$id'");
		return false;
	}
	function isQuestion($id){
		return $this->db->isExist($this->q_table, 'id', "id = '$id'");
	}
	function addQuestion($ques, $ans, $type, $qb_id, $options = ""){
		if($this->isQb($qb_id))
			return $this->db->insertData($this->q_table, array('question', 'type', 'options', 'answer', 'question_bank'), array($ques, $type, $options, $ans, $qb_id));
		return false;
	}
	function updateQuestion($id, $columns, $data){
		return $this->db->updateMultipleColumn($this->q_table, $columns, $data, "id = '$id'");
	}
	function deleteQuestion($id){
		return $this->db->deleteRow($this->q_table, "id = '$id'");
	}
	function deleteQuestionByQbId($qbid){
		return $this->db->deleteRow($this->q_table, "question_bank = '$qbid'");
	}
	function getQList($info = array(), $qbid = 'all'){
		$where = "question_bank = '$qbid'";
		if($qbid == 'all')
			$where = "id != 0";
		return $this->db->getDataGrid($this->q_table, $info, $where . " ORDER BY `creation_date` DESC");
	}
	function getQuestionInfo($id, $info){
		if($this->isQuestion($id))
			return $this->db->getSingleData($this->q_table, $info, "id='$id'");
		return false;
	}
}