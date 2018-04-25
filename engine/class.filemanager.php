<?php 
define('THUMB_PREFIX', 'thumb_');
define('FMPATH', 'data/uploads/');
define('BASEFMDIR', BASE_PATH . FMPATH);
define('BASEFMURL', BASE_URL . FMPATH);


class filemanager {
	
	
	
	
	
	function dloop($path = '') {		
		$dirs = array();
		$_dirs = scandir(BASEFMDIR . $path);
		$_dirs = array_diff($_dirs, array('.', '..'));
		foreach($_dirs as $dir) {
			$_dir = $path . '/' . $dir;
			if(is_dir(BASEFMDIR . $_dir)) {
				$dirs[$_dir] = $this->dloop($_dir);
			}
		}
		return $dirs;
	}
	
	
	public function dscan($path) {
		if(!file_exists($path)) return FALSE;
		
		$files = scandir($path); 	
		if(!$files) return FALSE;
		
		$files = array_diff($files, array('.', '..'));
		$_dirs = array();
		$_files = array();
		foreach($files as $file) {
			$_fpath = $path . '/' . $file;
			$_finfo = $this->finfo($_fpath);
			if($_finfo['is_dir']) {
				$_dirs[] = $_finfo;
			} else { 
				$_files[] = $_finfo;
			}
		}		
		$result = array_merge($_dirs, $_files);
		
		return $result;
	}	
	
	public function fmk($path){
		if(file_exists($path)) return FALSE;
		$ret = fopen($path, 'w');
		if($ret) {
			return fclose($ret);			
		}
		return FALSE;
	}
	
	public function dmk($path, $mode = 0777, $recursive = true) {
		return @mkdir($path, $mode, $recursive);
	}	

	public function dlist($dir) {
        return array_diff(scandir($dir), array('.','..'));
    }

	public function drm($dir) {
		if(!file_exists($dir)) return FALSE; 
		
		$files = dlist($dir);
		foreach ($files as $file) { 
			(is_dir("$dir/$file")) ? $this->drm("$dir/$file") : unlink("$dir/$file"); 
		} 
		return rmdir($dir);  
	}
		
	public function fdrm($path) {
		if(!file_exists($path)) return FALSE;
		if(is_dir($path)) $this->drm($path); else $this->fdel($path);
	}
	
	public function fdel($path) {
		if(!file_exists($path)) return FALSE;
		unlink($path);
		$thumb = dirname($path) . '/' . THUMB_PREFIX . basename($path);
		if(file_exists($thumb)) unlink($thumb);
	}
	
	public function fsave($path, $contents){
		return file_put_contents($path, $contents);	
	}
	
	public function finfo($path){
		if(!file_exists($path)) return FALSE;
		
		$_finfo = array();			
		$_finfo['name'] = basename($path);			
		$_finfo['filemtime'] = filemtime($path);
		$_finfo['filectime'] = filemtime($path);
		if(is_dir($path)) {
			$_finfo['type'] = 'dir';
			$fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
			$_finfo['files'] = iterator_count($fi);
			$_finfo['is_dir'] = true;
		} else {
			$_finfo['type'] = 'file';
			$_finfo['filetype'] = mime_content_type($path);
			$_finfo['size'] = filesize($path);
			$_finfo['is_dir'] = false;
		}
		
		return $_finfo;
	}
	
	public function frn($path, $path2) {
		return rename($path, $path2);
	}
	
	public function fcopy($path, $path2) {
		return copy($path, $path2);
	}



	public function fupload($file, $path, $imgsize) {
		global $_FILES;
		if(empty($_FILES) || !file_exists($_FILES[$file]["tmp_name"])) return FALSE;
		$file = $_FILES[$file];		
		$type = explode('/',$file['type']);
		$tmpname = $file["tmp_name"];
		$ext = $type[1];
		/* create thumb for image */
		if($type[0] == 'image') {
            if(is_array($imgsize)) {
                createthumb($tmpname, $path, $imgsize[0], $imgsize[1], $file['type'], 'png');
            }
		}
	}
}




function createThumb($name,$target, $thumb_width, $thumb_height, $type, $newtype = null) {
	switch($type){
		case 'image/jpg':
		case 'image/jpeg':
			$src_img=imagecreatefromjpeg($name); $type = "jpg";
		break;
		
		case 'image/gif':
			$src_img=imagecreatefromgif($name); $type = "gif";
		break;
		
		case 'image/png':
			$src_img=imagecreatefrompng($name); $type = "png";
		break;
	}
	if($newtype == NULL) $newtype = $type;
	$filename = 'output.jpg';
	$width = imagesx($src_img);
	$height = imagesy($src_img);
	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;
	if ( $original_aspect >= $thumb_aspect )
	{
	   // If image is wider than thumbnail (in aspect ratio sense)
	   $new_height = $thumb_height;
	   $new_width = $width / ($height / $thumb_height);
	}
	else
	{
	   // If the thumbnail is wider than the image
	   $new_width = $thumb_width;
	   $new_height = $height / ($width / $thumb_width);
	}
	$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
	// Resize and crop
	imagecopyresampled($thumb,
					   $src_img,
					   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
					   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
					   0, 0,
					   $new_width, $new_height,
					   $width, $height);
					   
	switch($newtype){
		case 'jpg': imagejpeg($thumb,$target);  break;
		case 'gif': imagegif($thumb,$target);  break;
		case 'png': imagepng($thumb,$target); break;
	} 

	imagedestroy($thumb); 
	imagedestroy($src_img); 
}

function fm() {
	return new filemanager();
}