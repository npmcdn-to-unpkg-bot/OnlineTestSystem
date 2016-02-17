<?php
class HitCounter{
	private $table="hit_counter";
	private $db;
	private $url;
	private $auth;
	function __construct(){
		$this->db=new DBManager();
		$this->url=new URL();
		$this->auth=new Auth();
	}
	public static function countHit(){
		$obj=new HitCounter();
		$ip=$_SERVER['REMOTE_ADDR'];
		$ref="";
		if (isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTP_REFERER']))
			$ref=$_SERVER['HTTP_REFERER'];
		if (isset($_REQUEST['ref'])&&!empty($_REQUEST['ref']))
			$ref=$_REQUEST['ref'];
		$url=$obj->url->getRequestedUri(true);
		$query=$obj->url->getRequestedQuery();
		$url=str_replace("?".$query, "", $url);
		$columns=array(0=>'ip',
				1=>'url',
				2=>'query',
				3=>'admin',
				4=>'ref');
		$data=array(0=>$ip,
				1=>$url,
				2=>$query,
				3=>$obj->auth->isAdmin(),
				4=>$ref);
		return $obj->db->insertData($obj->table, $columns, $data);
	}
	function getTotalHits($unique=false){
		$column='count(*)';
		$where="admin!=1";
		if ($unique)
			$where.=" GROUP BY `ip`";
		if (!$unique)
			return $this->db->getSingleData($this->table, $column, $where);
		else
			return count($this->db->getDataGrid($this->table, array(0=>'ip'), $where));
	}
	function getHitCountsByDate($date, $unique=false){
		$column='count(*)';
		$where="admin!=1 AND DATE_FORMAT(date, '%d-%m-%Y') = '$date'";
		if ($unique)
			$where.=" GROUP BY `ip`";
		if (!$unique)
			return $this->db->getSingleData($this->table, $column, $where);
		else
			return count($this->db->getDataGrid($this->table, array(0=>'ip'), $where));
	}
	function getTodaysHits($unique=false){
		return $this->getHitCountsByDate(date("d-m-Y"), $unique);
	}
	function getThisMonthHits($unique=false){
		$column='count(*)';
		$where="admin!=1 AND DATE_FORMAT(date, '%m-%Y') = '".date("m-Y")."'";
		if ($unique)
			$where.=" GROUP BY `ip`";
		if (!$unique)
			return $this->db->getSingleData($this->table, $column, $where);
		else
			return count($this->db->getDataGrid($this->table, array(0=>'ip'), $where));
	}
	function getHitCountsByDays($days=null,$unique=false){
		$result=array();
		if ($days==null){
			$result[0]['date']=date("d-m-Y");
			$result[0]['hits']=$this->getTodaysHits($unique);
		}else{
			$startDate=mktime(1,0,0,date('m',strtotime("-$days Days")), date('d',strtotime("-$days Days")), date('Y',strtotime("-$days Days")));
			$endDate=mktime(1,0,0,date('m'), date('d'), date('Y'));
			$result=array();
			$i=0;
			while($startDate<=$endDate){
				$date=date("d-m-Y", $startDate);
				$result[$i]['date']=$date;
				$result[$i++]['hits']=$this->getHitCountsByDate($date,$unique);
				$startDate+=86400;
			}
		}
		return $result;
	}
	function getReferers(){
		$where="admin!=1 GROUP BY `ref`";
		return Comman::convertArrayToSingle($this->db->getDataGrid($this->table, array('ref'),$where), 'ref');
	}
	function getReferersCount($ref){
		return $this->db->getSingleData($this->table, 'count(*)', "ref LIKE '$ref%' AND admin!=1");
	}
	function getRefererCountByDate($ref,$date){
		return $this->db->getSingleData($this->table, 'count(*)', "ref LIKE '$ref%' AND admin!=1 AND date LIKE '$date%'");
	}
	function getCountByURLKeyword($keyWord, $ref){
		return $this->db->getSingleData($this->table, 'count(*)', "url LIKE '%$keyWord%' AND ref LIKE '$ref%' AND admin!=1");
	}
	function getCountByTimeSpan($span, $ref=null, $date=null){
		$w="";
		for ($i=0; $i<count($span); $i++){
			if ($i!=0)
				if ($date==null)
					$w.="OR date LIKE '___________".$span[$i].":%' ";
				else
					$w.="OR date LIKE '".$date."_".$span[$i].":%' ";
			else
				if ($date==null)
					$w="date LIKE '___________".$span[$i].":%' ";
				else
					$w="date LIKE '".$date."_".$span[$i].":%' ";
		}
		if ($ref==null)
			return $this->db->getSingleData($this->table, 'count(*)', "($w) AND admin!=1");
		return $this->db->getSingleData($this->table, 'count(*)', "($w) AND ref='$ref' AND admin!=1");
	}
}