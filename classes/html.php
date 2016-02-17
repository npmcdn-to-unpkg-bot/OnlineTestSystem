<?php
class HTML{
	private $meta = array();
	private $css = array();
	private $js = array();
	private $header = null;
	private $footer = null;
	private $title = null;
	private $activeMenu = null;
	private $customHeadCode = array();
	private $customFootCode = array();
	function setActiveMenu($menu){
		$this->activeMenu = $menu;
		return $this;
	}
	function __construct(){
		return $this;
	}
	function addCustomHeadCode($code){
		array_push($this->customHeadCode, $code);
		return $this;
	}
	function addCustomFootCode($code){
		array_push($this->customFootCode, $code);
		return $this;
	}
	function setTitle($title){
		$this->title = $title;
		return $this;
	}
	function addMeta($name, $value){
		array_push($this->meta, array($name, $value));
		return $this;
	}
	function addJs($path){
		array_push($this->js, $path);
		return $this;
	}
	function addCss($path){
		array_push($this->css, $path);
		return $this;
	}
	function setHeader($path){
		$this->header = $path;
		return $this;
	}
	function setFooter($path){
		$this->footer = $path;
		return $this;
	}
	function renderHeader(){
		ob_start();
		global $title;
		global $css;
		global $meta;
		global $code;
		global $activeMenu;
		$activeMenu = $this->activeMenu;
		$code = $this->customHeadCode;
		$title = $this->title;
		$css = $this->css;
		$meta = $this->meta;
		include $this->header;
		$result = ob_get_contents();
		ob_end_clean();
		print_r($result);
	}
	function renderFooter(){
		ob_start();
		global $js;
		global $code;
		$code = $this->customFootCode;
		$js = $this->js;
		include $this->footer;
		$result = ob_get_contents();
		ob_end_clean();
		print_r($result);
	}
}