<?php
class File{
	private $dir;
	function __construct(){
		$this->dir=realpath(static_dir.DS."user".DS."img".DS);
	}
	function uploadFile($file_name, $file_tmp, $overwrite=false, $target=null){
		if($target==null)
			$target=$this->dir.DS;
		if (!is_array($file_name)||!is_array($file_tmp)){
			$target_file=$target.basename($file_name);
			if ($overwrite==true)
				return move_uploaded_file($file_tmp, $target_file);
			else{
				if (file_exists($target.DS.$file_name))
					return false;
				return move_uploaded_file($file_tmp, $target_file);
			}
		}else{
			$i=0;
			$j=0;
			foreach ($file_name as $file){
				$target_file=$target.basename($file);
				if ($overwrite==true||!file_exists($target.DS.$file))
					if (move_uploaded_file($file_tmp[$i], $target_file))
						$j++;
				$i++;
			}
			return $j;
		}
	}
	function deleteFile($file, $dir=null){
		if ($dir==null)
			$dir=$this->dir.DS;
		return unlink($dir.$file);
	}
}