<?php 
class Home{
	private $table="core_conf";
	private $db;
	private $auth;
	function __construct(){
		$this->db=new DBManager();
		$this->auth=new Auth();
	}
	function setImages($images){
		if (!$this->auth->isAdmin())
			return false;
		$images = array_filter($images);
		return Comman::setConfig('home', 'images', implode(";", array_filter($images)));
	}
	function setCaption($captions){
		if (!$this->auth->isAdmin())
			return false;
		return Comman::setConfig('home', 'caption', implode(";", array_filter($captions)));
	}
	function getCaptions(){
		return explode(";",Comman::getConfig('home', 'caption'));
	}
	function getImages(){
		return explode(";",Comman::getConfig('home', 'images'));
	}
	function removeImage($image){
		$images = $this->getImages();
		unset($images[array_search($image, $images)]);
		return $this->setImages($images);
	}
}
?>