<?php
class URL{
	private $url_full;
	private $url_sort;
	private $query;
	private $config;
	private $db;
	private $uri_parts;
	function __construct(){
		$this->config=new Config();
		$this->db=new DBManager();
		$this->url_full=urldecode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$this->url_sort=str_replace($this->config->site_address, "", $this->url_full);
		$this->query=$_SERVER['QUERY_STRING'];
		$this->uri_parts=array_filter(explode("/", str_replace("?".$this->query, "", $this->getRequestedUri(true))));
		if (isset($_REQUEST['path'])&&!empty($_REQUEST['path'])){
			$url_path=str_replace("%2F", "/", $_REQUEST['path']);
			if ($this->getRequestedModule()=='index'||$this->getRequestedModule()=='?path=video')
				$this->uri_parts=array_filter(explode("/", $url_path));
		}
	}
	function getRequestedUri($sort=false){
		if($sort==false)
			return $this->url_full;
		return $this->url_sort;
	}
	function getRequestedModule(){
		if (isset($this->uri_parts[0]) && !empty($this->uri_parts[0]))
			return $this->uri_parts[0];
		return 'index';
	}
	function getRequestedQuery(){
		return $this->query;
	}
	function getRequestedFunction(){
		if (isset($this->uri_parts[1]) && !empty($this->uri_parts[1]))
			return $this->uri_parts[1];
		return 'index';
	}
	function getRequestedItem(){
		if (isset($this->uri_parts[2]) && !empty($this->uri_parts[2]))
			return $this->uri_parts[2];
		return 'index';
	}
	function getUriPart($part){
		if (isset($this->uri_parts[$part-1]) && !empty($this->uri_parts[$part-1]))
			return $this->uri_parts[$part-1];
		return false;
	}
}