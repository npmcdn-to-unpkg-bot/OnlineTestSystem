<?php
class Message{
	private static $tamplate="<div class=\"alert notice alert-{{class}} alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>{{icon}}{{type}} {{msg}}</div>{{next}}";
	private $auth;
	function __construct(){
		if (!isset($_SESSION['msg'])||empty($_SESSION['msg']))
			$_SESSION['msg']="";
		$this->auth=new Auth();
	}
	static function setSuccessMessage($msg=null){
		if ($msg==null)
			$msg="The action you performed is successfully cmpleted.";
		$class="success";
		Message::setMessage($class, $msg);
	}
	static function setFailMessage($msg=null){
		if ($msg==null)
			$msg="The action you performed is failed.";
		$class="danger";
		Message::setMessage($class, $msg);
	}
	static function setInfoMessage($msg=null){
		if ($msg==null)
			$msg="This action can be performed by this.";
		$class="info";
		Message::setMessage($class, $msg);
	}
	static function setWarningMessage($msg=null){
		if ($msg==null)
			$msg="This action can cause this.";
		$class="warning";
		Message::setMessage($class, $msg);
	}
	private static function setMessage($class, $msg, $icon=null, $type=null){
		$tam=Message::$tamplate;
		$tam=str_replace("{{class}}", $class, $tam);
		if($icon!=null)
			$tam=str_replace("{{icon}}", "<span class=\"fa fa-$icon\"></span>", $tam);
		else 
			$tam=str_replace("{{icon}}", "", $tam);
		if($type!=null)
			$tam=str_replace("{{type}}", "<strong>$type</strong>", $tam);
		else
			$tam=str_replace("{{type}}", "", $tam);
		$tam=str_replace("{{msg}}", $msg, $tam);
		$_SESSION['msg'].=$tam;
	}
	static function getMessage($isPrint=false, $force=false){
		$msg_list=array();
		$auth=new Auth();
		if (!$auth->isAdmin()&&$force==false)
			return false;
		if (isset($_SESSION['msg'])||!empty($_SESSION['msg']))
			$msg_list=explode("{{next}}", $_SESSION['msg']);
		if ($isPrint==false){
			?>
			<script>
			$(document).ready(function (){
			<?php 
			if(count($msg_list)>0)
				foreach ($msg_list as $msg){
			?>
				$("body").append("<?=str_replace('"', '\"', $msg)?>");
			<?php 
				}
			?>
			}());
			</script>
			<?php 
		}else
			if(count($msg_list)>0)
				foreach ($msg_list as $msg)
					echo $msg;
		$_SESSION['msg']="";
	}
}