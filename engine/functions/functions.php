<?php


function session($key = null, $value = null) {
	global $_SESSION;
	if(!$key) return $_SESSION;
	if($value) {
		$_SESSION[$key] = $value;
	}
	return $_SESSION[$key];
	
}


function var2string($val) {
	if(is_array($val)) $val = implode(',', $val);
	return $val;	
}


function striprow($arr = array()){
	if(!empty($arr))
		foreach ($arr as $k=>$v){
			$arr[$k] = stripslashes($v);
		}
		
	return $arr;
}

/** DEBUG FUNCTIONS **/
function debug($text=''){
	$info = debug_backtrace();
	$info = $info[0];
	$text = "File ".$info['file'] . "->class ".$info['type']."->function ".$info['function']."->line ".$info['line']."->data => (\n "
	. print_r($text,1);
	if(file_exists(LOGFILE)){
		$f = fopen(LOGFILE,"a+");
		fwrite($f,$text . "\n)\n\r");
		fclose($f);
	}	
}

/** TEMPLATE FUNCTION **/

/**
	Main function to display template; 	
	Can be called -anywhere- in code.
	
	@$_TPL string - path to template;
	@$vars array - template variables;
	@return string - parsed tempate html;
**/
function tpl($_TPL, $vars=array()){
	/** 
		Defining template to choose; 
		If it has format class/method then class/tpl.method.php would be included;
		If it is basic template (i.e. `index`) then just tpl.method.php would be included;
	**/
	@list($class, $method) = explode('/',$_TPL); 
	if($method == '') {
		$method = $class; 
		$class = '';
	}
	/** 
		Priority of template:
		1. Theme class method tpl
		2. Theme class default view tpl
		3. Default class method tpl
		4. Default class default view tpl
		5. Otherwise return 404 not found.
	**/ 
	$theme = (G('theme') != '' ? G('theme') : DEFTHEME);  
	if(file_exists(THEME_FOLDER . "{$theme}/tpl/{$class}/tpl.{$method}.php")) {
		$_url = THEME_FOLDER . "{$theme}/tpl/{$class}/tpl.{$method}.php";
	} elseif(file_exists(THEME_FOLDER . "{$theme}/tpl/default/tpl.{$method}.php")) {
		$_url = THEME_FOLDER . "{$theme}/tpl/default/tpl.{$method}.php";
	} elseif(file_exists(TPL_FOLDER . "{$class}/tpl.{$method}.php")) {
		$_url = TPL_FOLDER . "{$class}/tpl.{$method}.php";
	} elseif(file_exists(TPL_FOLDER . "default/tpl.{$method}.php")) {
		$_url = TPL_FOLDER . "default/tpl.{$method}.php";
	} else {
		return '<h3>' . T('404 not found') . '</h3>';
	}	

	/**	
		Parsing template variables and returning parsed template
	**/
	if($_url){	
		foreach ($vars as $k =>$v){  
			if(!is_array($v) && !is_object($v))
				$$k=html_entity_decode(stripslashes($v)); 
			else
				$$k=$v;
		}	
			
		ob_start(); 	
		include($_url); 
		$tpl = ob_get_contents(); 
		ob_end_clean();	
	}
	
	return $tpl;	
}


function mtpl($name, $data = null) {
	$fpath = UPLOADS_FOLDER . 'tpl/' . $name . EXT_TPL;
	if(!file_exists($fpath)) return FALSE;
	
	if($data) {
		foreach ($data as $k =>$v){  
			if(!is_array($v) && !is_object($v))
				$$k=html_entity_decode(stripslashes($v)); 
			else
				$$k=$v;
		}	
	}
	
	ob_start(); 	
	include($fpath); 
	$content = ob_get_contents(); 
	ob_end_clean();
			
	return $content;
}

function getform($id) {
	return call('forms', 'view', $id);
}


function parse_tags($sText) {
	$sPattern = "/{{(.*?)}}/s";
	preg_match_all($sPattern, $sText, $aMatches);
	foreach($aMatches[1] as $sMatch) {
		$aMatch = explode('|', $sMatch);
		$sPattern = '{{' . $sMatch . '}}';
		$replace = '';
		switch($aMatch[0]) {		
			case 'tpl':
				$replace = mtpl($aMatch[1]); 
			break;
			case 'form':
				$replace = getform($aMatch[1]); 
			break;
			case 'var':
				$replace = constant($aMatch[1]); 
			break;
			case 'icon':
				$replace = '<i class="icon fa ' . $aMatch[1] .'"></i>';
			break;			
		}
		$sText = str_replace('{{' . $sMatch . '}}', $replace, $sText);
	}
	return $sText;
}

/**
	Returns file url based on theme
**/
function tdir() {
	$theme = (G('theme') != '' ? G('theme') : DEFTHEME); 
	return  THEME_FOLDER . $theme . '/';
}
function turl() {
	return BASE_URL . tdir();
}
function tpath() {
	return BASE_FOLDER . tdir();
}


/** MAIN FUNCTIONS **/

/** $_GLOBALS[$name] getters\setter **/
function G($name, $value = NULL) {
	global $_GLOBALS; //var_dump($_GLOBALS);
	//if($name == 'db_lastbackup') { var_dump($_GLOBALS); foreach ($_GLOBALS as $k => $v) echo $k . ' ' . $v . "<BR>";}
	if($value != NULL) {
		$_GLOBALS[$name] = $value; 
		M('system')->set($name, $value);
	}
	return (isset($_GLOBALS[$name]) ? $_GLOBALS[$name] : NULL);
}

function delG($name) {
	M('system')->delByName($name);
}


function T($text, $number = 1, $addnumber = false, $ucfirst = false) {
	$_text = $text;
	$labels = S('labels');
	$lang = getLang();
	if(!isset($labels[$text])) { 
		//addLabel($text);	
	}
	$text = (isset($labels[$text][$lang]) ? $labels[$text][$lang] : $text);
	if(is_array($text)) 
		$text = (isset($text[$number]) ? $text[$number] : ((isset($text['other']) ? $text['other'] : array_pop($text))));
	if($addnumber) 
		$text = $number . ' ' . $text;	
	
	if(empty($text)) $text = $_text;
	
	if($lang != 'ru' && $ucfirst) $text = strtoupper($text);
	
	return $text;
	
}

function addLabel($key) {
	$labels = cache('i18n');
	if(!$labels) $labels = array();
	if(!isset($labels[$key])) {
		$labels[$key] = [
			'label' => $key,
			'type' => '1'
		];
		cache('i18n', $labels);
	}
}

function M($module) { 
	global $masterclass;
	$filename = CLASS_FOLDER . 'module.' . $module . '.php';
	if(file_exists($filename)) {
		require_once($filename);
		require_once('engine/class.masterclass.php');
		return new $module();
	}
	return FALSE;
}

/** $_SESSION[$name] getters\setter **/
function S($name, $value = NULL) {
	global $_SESSION; //var_dump($_GLOBALS);
	//if($name == 'db_lastbackup') { var_dump($_GLOBALS); foreach ($_GLOBALS as $k => $v) echo $k . ' ' . $v . "<BR>";}
	if($value != NULL) {
		$_SESSION[$name] = $value;
	}
	return (isset($_SESSION[$name]) ? $_SESSION[$name] : NULL);
}

/** function q() is defined directly in [dblanguage].php (i.e. mysql.php) **/

/** FORMAT FUNCTIONS **/ 
function parseString($string = '') {
	return addslashes(htmlspecialchars(@trim($string)));
}

function string_decode($string) {
	return html_entity_decode(stripslashes($string));
}

function inspect($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


function getGet($label,$defval = ''){
	global $_GET;
	return (isset($_GET[$label])?$_GET[$label]:$defval);
}

function getPost($label,$defval = ''){
	global $_POST;
	return (isset($_POST[$label])?$_POST[$label]:$defval);
}

function getAll($label,$defval = ''){
	global $_REQUEST;
	return (isset($_REQUEST[$label])?$_REQUEST[$label]:$defval);
}

function insertSQL($data=array()){
	$return = '';
	
}

 
/** SESSION **/
 
 
function getVar($label,$defval = ''){
	global $_SESSION;
	return (isset($_SESSION[$label])?$_SESSION[$label]:$defval);
}

function setVar($label,$val){
	global $_SESSION;
	$_SESSION[$label] = $val;
}

function unsetVar($label){
	global $_SESSION;
	unset($_SESSION[$label]);
}

function checkVar($label){
	global $_SESSION;
	return isset($_SESSION[$label]);
}

function debugVar($label){
	global $_SESSION;
	debug($_SESSION[$label]);
}




/*** FILTERS **/
function setFilter(){
	setVar(getAll('filter'),getAll('value'));
	unset($_GET['filter']);	
	goBack();
} 


function setLang($lang){ 
	$langs = getLangs(); 
	foreach($langs as $_lang) {
		if($_lang['active']) {  
			if(empty($lang) && HOST == $_lang['website']) {
				setVar('lang',$_lang['abbr']);
			} elseif($lang == $_lang['abbr']) {
				setVar('lang',$_lang['abbr']);
			}
		}
	}
}

function getLang(){
	$lang = getVar('lang');
	if(empty($lang)) $lang = G('deflang');
	return $lang;
}

function getLabels(){
	global $labels;
	$tmp = file("lang/".getVar('lang',G('deflang','en')).".txt");
	foreach($tmp as $s){
		$_s = explode("=",$s); $label = $_s[0]; unset($_s[0]); $text = join("=",$_s);
		$labels[trim($label)] = trim($text);
	}
	if(file_exists('themes/'.G('theme').'/lang.php')) include('themes/'.G('theme').'/lang.php');
}

function getFilterState($class,$field){
	$f = explode("_",getVar('sort_'.$class));
	if($f[0] == $field){
		switch ($f[1]){
			case 'NONE': return 'ASC'; break;
			case 'ASC': return 'DESC'; break;
			case 'DESC': return 'NONE'; break;		
		}	
	}
	return 'ASC';
}

function filterImg($class,$field){
	$f = explode("_",getVar('sort_'.$class));
	if($f[0] == $field){
		switch ($f[1]){
			case 'ASC': echo "&uArr;"; break;
			case 'DESC': echo "&dArr;"; break;		
		}	
	}
}

function fullpath() {
	global $_PATH;
	return BASE_URL . implode('/',$_PATH); 
}

/** URL redirect fuctions  **/

function redirect($to,$time=0, $relative = false){
	$to = str_replace('#','', $to); if($relative) $to = fullpath()  . '/' . $to; 
	echo "<html><body><script>setTimeout(\"location.href='$to'\", {$time}000);</script></body></html>";
	if($time==0) die();
}	

function goBack(){
	redirect($_SERVER['HTTP_REFERER']);
}

function gohome() {
	redirect(BASE_URL);
}


/*** 
	
	MISC 
	
***/

function doLogin(){
	$sql = "SELECT * from users where login='".getPost('login')."' AND pass=md5('".getPost('pass')."')"; 
	if (DBnumrows($sql)>0){
		$user = DBrow($sql);
		$user['logged'] = 1;
		setVar('admin',$user);		
	}
	goBack();
}

function doLogout(){
	unsetVar('admin');
	unsetVar('logged');
	//print_r($_SESSION); 
	die();
}


function getModules(){
	return M('modules')->cache();
}

/** DATA fuctions **/
const WIDGET_TEXT 		= 'text';
const WIDGET_TEXTAREA 	= 'textarea';
const WIDGET_HTML 		= 'html';
const WIDGET_BBCODE 	= 'bbcode';
const WIDGET_PASS 		= 'pass';
const WIDGET_HIDDEN 	= 'hidden';
const WIDGET_CHECKBOX 	= 'checkbox';
const WIDGET_RADIO 		= 'radio';
const WIDGET_SELECT		= 'select';
const WIDGET_MULTSELECT	= 'multselect';
const WIDGET_DATE		= 'date';
const WIDGET_CHECKBOXES	= 'checkboxes';
const WIDGET_INFO		= 'info';
const WIDGET_KEYVALUES  = 'keyvalues';
const WIDGET_EMAIL 		= 'email';
const WIDGET_PHONE		= 'phone';
const WIDGET_NUMBER		= 'number';
const WIDGET_URL		= 'url';
const WIDGET_SLUG		= 'slug';
const WIDGET_FILE		= 'file';
const WIDGET_TIME		= 'time';
const WIDGET_DATETIME	= 'datetime';

const DB_TEXT 	= 'text';
const DB_BLOB 	= 'blob';
const DB_STRING = 'string';
const DB_BOOL 	= 'bool';
const DB_INT 	= 'int';
const DB_DATE 	= 'date';
const DB_FLOAT 	= 'float';


function drawForm($fields,$data = array(),$options = array(), $split = false){  
	Hset('validate');
	return tpl('form', array( 'data' => $data, 'fields' => $fields, 'options' => $options , 'split' => $split));
}

function fType($value, $type, $options = null, $fieldname = null) { 
	switch($type) {
		
		case WIDGET_NUMBER:
			return (int)$value;
		break;
		
		
		case WIDGET_HTML:
			Hset('editor');
		
		case WIDGET_INFO:
		case WIDGET_TEXT:
		case WIDGET_TEXTAREA:
		case WIDGET_BBCODE:
		case WIDGET_EMAIL:
		case WIDGET_PHONE:
		case WIDGET_URL:
			return nl2br($value);
		break;
		
		case WIDGET_KEYVALUES :
			$values = array();
			foreach($value as $k => $v) {
				$values[] = $k . '=' . $v;
			}
			$result = implode('<br>', $values);
			return $result;
		break;
		
		
		case WIDGET_PASS:
			if(!$fieldname) return '*****';
		break;
		
		case WIDGET_HIDDEN: 
			return; 
		break;
		
	
		case WIDGET_CHECKBOX:
			if($fieldname)
				return (!(bool)$value ?  T('not') : '') . ' ' . T($fieldname);
			else
				return ((bool)$value ? T('yes') : T('no'));
		break;
		
		case WIDGET_RADIO:
		case WIDGET_SELECT:
			return (isset($options[$value])? $options[$value] : $value);
		break;
		
		case WIDGET_DATE:
			return fDateTime($value);
		break;
		
		case WIDGET_CHECKBOXES:		
		case WIDGET_MULTSELECT:
			$values = explode(',',$value);
			foreach($values as $k =>  $val) {
				if(isset($options[$val])) {
					$values[$k] = $options[$val];
				}
			}
			$result = implode(',', $values);
			if($fieldname) $result = T($fieldname . 's') . ': ' . $result;
			return $result;
		break;
	}
}

function strToKeyValues($data) {
	$return = array();
	$data = explode(PHP_EOL,$data);
	foreach($data as $row) {
		$_data = explode('=', $row);
		$key = trim($_data[0]);
		$value = trim($_data[1]);
		$return[$key] = $value;
	}
	return $return;
}


function chkz($int){
	if($int < 10) return '0'.$int;
}

function sqlPrepare($value) {
	$value = "'" . mysql_real_escape_string(stripslashes($value)) . "'";
	return $value;
}

function sqlFormat($type, $value = '', $quote = false){ //echo $type;
	switch($type){
		case 'int': $value = intval($value);
		break;
			
		case 'text': $value =  parseString($value); 
		break;
		
		case 'float': $value = floatval($value);
		break;
		
		case 'pass' : $value = md5($value);
		break;
		
		case 'array': $value = serialize($value); 
		break;
		
		case 'date': if($value=='') $value = date("Y-m-d H:i:s"); else{ print_r($value);
				$value = date("Y-m-d H:i:s",mktime(
					intval(@$value['h']), 
					intval(@$value['mi']), 
					intval(@$value['s']),
					intval(@$value['m']), 
					intval(@$value['d']), 
					intval(@$value['y'])
				));
			}		
		break;
	}
	if($quote) $value = dbquote($value);
	return $value;
} 

function now() {
	return sqlFormat('date', '');
}


function CheckLogged(){
	global $_SESSION,$_POST,$_COOKIE;//s inspect($_SESSION);
	
	if(isset($_SESSION['user'])) return true;
	
	if(isset($_COOKIE['mail'])){
		$sql ="SELECT * FROM users where email='{$_COOKIE['mail']}'"; //echo $sql;
		$res = DBrow($sql); //inspect($res);
		if($res !='') $_SESSION['user'] = $res;
	}
	
	return isset($_SESSION['user']);
}

function treeDraw($data, $tpl='', $eval = ''){
	$ret = '';
	foreach ($data as $k => $row){ 
		if($eval !='') eval($eval);
		inspect($row);
		$_T = $tpl; //echo $_T;
		if($row['children']!='')
			$row['children'] = treeDraw($row['children'],$tpl);
			
		foreach ($row as $kk => $vv){
			$_T = str_replace('%'.$kk, $vv, $_T);
		}
		$ret .=$_T;
	}
	return $ret;
}


function fDate($date) {
	$date = explode("-", $date);
	return (int)$date[2] . " " . T('mon_'.(int)$date[1]) . " " .$date[0];
}

function fTime($time) {
	$time = explode(":", $time);
	return (int)$time[0] . ":" . $time[1];
}

function fDateTime($datetime){
	$datetime = explode(" ", $datetime);	
	return fDate($datetime[0]) . ", " . fTime($datetime[1]);
}

function fdateunix($unixtime) {
	$mysqltime  = date("Y-m-d H:i:s", $unixtime);
	return fDateTime($mysqltime);
}

function getGlobals(){
	global $_GLOBALS;
	$_GLOBALS = cache('system');
}

function getlangs() {
	return  G('langs');
}

function superAdmin(){
	global $_SESSION;
	return (@$_SESSION['user']);//(@$_SESSION['user']['id'] == 1);
}


function getRights(){
	global $_SESSION, $_RIGHTS;
	$_RIGHTS['admin'] = TRUE;
}

function sendMail($data){
	/*$headers = 
"MIME-Version: 1.0 \r\n
Content-type: text/html; charset=utf-8\r\n
From: ".G('mailFrom')."\r\n"; */
    $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 	
	if(isset($data['from'])) {		
		$from = $data['from'];
		$headers .= "From:  $from\r\n"; 	
		$headers .= "Reply-To:  $from\r\n"; 
	}
	mail($data['to'],$data['title'],$data['subject'],$headers); 
}function loadClass($cl,$clname=''){	if(file_exists("classes/$cl.php")){		require_once("classes/$cl.php");		$class = new $cl($clname); //echo $cl;	}else{		$class = new masterclass($clname);		$class->className = $cl;		}		return $class;}

function getthumb($img, $dir){
	$thumbpath = BASEFMDIR .  $dir . '/' . THUMB_PREFIX . $img; 
	$thumburl = BASEFMURL .  $dir . '/' . THUMB_PREFIX . $img; 
	if(file_exists($thumbpath))
		echo " style=\"background-image:url('$thumburl');background-position-x: 0;\"";

	
}

function BB($text)	{
		//inspect($text);
		
		$text = preg_replace('/\[(\/?)(b|i|u|s|center|left|right)\s*\]/', "<$1$2>", $text);
		
		$text = preg_replace('/\[code\]/', '<pre><code>', $text);
		$text = preg_replace('/\[\/code\]/', '</code></pre>', $text);
		
		$text = preg_replace('/\[(\/?)quote\]/', "<$1blockquote>", $text);
		$text = preg_replace('/\[(\/?)quote(\s*=\s*([\'"]?)([^\'"]+)\3\s*)?\]/', "<$1blockquote>Цитата $4:<br>", $text);
		
		//$text = preg_replace('/\[url\](?:http:\/\/)?([a-z0-9-.]+\.\w{2,4})\[\/url\]/', "<a href=\"http://$1\">$1</a>", $text);
		/*$text = preg_replace('/\[url\s*\](?:http:\/\/)?([^\]\[]+)\[\/url\]/', "<a href=\"http://$1\" target='_blank'>$1</a>", $text);
		$text = preg_replace('/\[url\s?=\s?([\'"]?)(?:http:\/\/)?(.*)\1\](.*?)\[\/url\]/s', "<a href=\"http://$2\" target='_blank'>$3</a>", $text);*/
		$text = preg_replace("/\[url\](.*?)\[\/url\]/si","<a href=\\1 target=\"_blank\">\\1</a>",$text);
        $text = preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/si","<a href=\"\\1\" target=\"_blank\">\\2</a>",$text);
		
		$text = preg_replace('/\[img\s*\]([^\]\[]+)\[\/img\]/', "<img src='$1'/>", $text);
		$text = preg_replace('/\[img\s*=\s*([\'"]?)([^\'"\]]+)\1\]/', "<img src='$2'/>", $text);
		//inspect($text); die();
		
		$text = preg_replace_callback("/\[video\](.*?)\[\/video\]/si","parse_video_tag",$text);
		
		return nl2br($text);
}

function getUser(){
	return 1;
}

function parse_video_tag($matches){
	$url = $matches[1];
	return '<div>'.parse_video($url).'</div>';
}

function parse_video($url,$title = '') { 
	$site = parse_url($url); 
	
	$query = explode($site['query']);	
	$host = str_replace('www.','',$site['host']);
	
	if($host == 'local') {
		$id = str_replace('/','',$site['path']);
		$video = DBrow(sprintf("SELECT * FROM videos WHERE id=%d",$id));
		return parse_video($video['url'],$video['title']);
	}
	
	
	switch($host) {
		case 'youtube.com':
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			$video_id = $match[1];
		}
		$vurl = "http://www.youtube.com/v/$video_id&autoplay=1";
		$ret  = "<a href='$vurl' rel=\"shadowbox['field_video']\"><img src='http://img.youtube.com/vi/$video_id/0.jpg' width=400 height=300></a>"; //die();
		
		break;	
	}
	
	if($ret != ''){
		if($title != '') {
			$ret = "<a href='$url' target='_blank'><b>$title</b></a><br>" . $ret;
		}
		return $ret;
	}
}






function rus2url($st)
{

	return strtr($st,
		array(
				"а" => "a",
				"б" => "b",
				"в" => "v",
				"г" => "g",
				"д" => "d",
				"е" => "e",
				"ё" => "yo",
				"ж" => "zh",
				"з" => "z",
				"и" => "i",
				"й" => "j",
				"к" => "k",
				"л" => "l",
				"м" => "m",
				"н" => "n",
				"о" => "o",
				"п" => "p",
				"р" => "r",
				"с" => "s",
				"т" => "t",
				"у" => "u",
				"ф" => "f",
				"х" => "h",
				"ц" => "c",
				"ч" => "ch",
				"ш" => "sh",
				"щ" => "shch",
				"ь" => "j",
				"ы" => "i",
				"ъ" => "'",
				"э" => "e",
				"ю" => "yu",
				"я" => "ya",
				"А" => "a",
				"Б" => "b",
				"В" => "v",
				"Г" => "g",
				"Д" => "d",
				"Е" => "ye",
				"Ё" => "yo",
				"Ж" => "zh",
				"З" => "z",
				"И" => "i",
				"Й" => "j",
				"К" => "k",
				"Л" => "l",
				"М" => "m",
				"Н" => "n",
				"О" => "o",
				"П" => "p",
				"Р" => "r",
				"С" => "s",
				"Т" => "t",
				"У" => "u",
				"Ф" => "f",
				"Х" => "h",
				"Ц" => "c",
				"Ч" => "ch",
				"Ш" => "sh",
				"Щ" => "shch",
				"Ь" => "j",
				"Ы" => "i",
				"Ъ" => "'",
				"Э" => "e",
				"Ю" => "yu",
				"Я" => "ya",  
				" " => "-",				
				)
		 );
}

/** Cache getter\setter **/
function cache($name, $data = NULL) {
	$filename = BASE_PATH . 'data/cache/' . $name . '.php';
	if(NULL !== $data) { 
		file_put_contents($filename, '<?php $' . $name .' = ' . var_export($data, TRUE) . ";" ) ;
	} elseif(file_exists($filename)) {
		include($filename);
		return $$name;
	} else {
		return NULL;
	}	
}


/** Clears cache **/
function cacherm($name) {
	$filename = 'data/cache/' . $name . '.php';
	if(file_exists($filename)) {
		unlink($filename);
	}
}

/** checking if our engine is installed; `globals` and `modules` are the only crucial modules, both cached, so if no cache exists, engine is not installed **/
function installationCheck() {
	$modules = array('system', 'modules', 'pages');
	$dbrestored = false;
	foreach($modules as $module) {
		if(NULL == cache($module)) {
			if(!$dbrestored) $dbrestored = dbrestore();
			if(!$dbrestored) call($module, 'install');
			
			call($module, 'cache');
			//M($module)->call('install');
			//M($module)->call('cache');	


			q()->update('modules')->set('status',2)->where(qEq('name', $module))->run();			
		}
	}
	/* update module info */
	call('modules', 'cache');
}

function hasRight($rightname) {
	global $_RIGHTS;
	return true; //(isset($_RIGHTS[$rightname]));	
}


function route() {
	global $_SERVER, $_GET;
	
	$vars = explode('?', $_SERVER['REQUEST_URI']);  
	$path = trim(str_replace(HOST_FOLDER, '', $vars[0]), '/'); 	
	$path = mapping($path); 
	$_PATH = explode('/', $path);
	return $_PATH;
}


function mapping($path) {
	include(BASE_FOLDER . 'mapping.php');
	foreach ($mapping as $k => $v){
		$path = preg_replace('/'.$k.'/',$v,$path);
	}
	return $path;
}

function path($i = null) {
	global $_PATH;
	if ($i === null) return $_PATH;
	return @$_PATH[$i];
}

function dispatch() {
	global $_PATH;
	//print_r($_PATH);
	$module = $_PATH[0];
	

	if($module == 'filter'){ setFilterValue(@$_PATH[1], @$_PATH[2]); }

	/* lang settings */
		G('langs', cache('langs'));
	$langs = getLangs();
	$lang = getLang(); 
	if($lang != $module) {
		setLang($module); 
	} 
	S('labels', cache('i18n'));
	
	$module = M($module);
	if(!$module) $module = M(G('defmodule'));
	if(!$module) $module = M(DEFMODULE);
	if(!$module) return FALSE;
	
	$method = @$_PATH[1];
	
	$module->output = call($module, $method); //$module->call(@$_PATH[1]);
	return $module;	
}

function setFilterValue($filter = '', $value = '') {
	setVar($filter, $value); 
	goBack(); 
	die();
}

function loadDB($dbname = '') {
	include(BASE_PATH . "engine/db/db." . DB_TYPE . ".class.php");
	include(BASE_PATH . "engine/db/db." . DB_TYPE . ".functions.php");
	$class = new $dbname();
	return $class;
}


function themePath() {
	$theme = (G('theme') != '' ? G('theme') : DEFTHEME); 	
	return THEME_FOLDER . $theme . '/';
}

/*
function checkLogged() {
	global $_SESSION, $_SERVER;
	if(!$_SESSION['logged']) $_SERVER['REQUEST_URI'] = 'users/login';
}*/


function drawBtns($buttons, $params = array()) {
	$html = '';
	if(is_array($buttons) && sizeof($buttons > 0)) {
		foreach($buttons as $button => $text) {
			if(is_array($params) && sizeof($params > 0)) {
				foreach($params as $k => $v) {
					$button = str_replace('{' . $k . '}', $v);
				}
			}
			
			if (0 === strpos($text, 'fa-')) {
				$html .= "<a href='$button' class='fa $text icon'></a>";
			} else {
				$html .= "<a href='$button' class='btn'>" . T($text) . "</a>";
			}
		}
	}
	return $html;
}


function menu() { 
	return tpl('menu');
}

function pagination($data) {
	return tpl('pagination', $data);
}



function dbbackup() { return;
	$now = strtotime("now"); //var_dump(G('db_lastbackup'));
	if(empty(G('db_lastbackup'))) {
		$updateTime = 0;
	} else {
		$updateTime = strtotime(G('db_lastbackup')) +  strtotime(G('db_backup_frequency'));
	}
	//echo $now . ' ' . $updateTime;
	if($now > $updateTime){		
		$host = HOST_SERVER;
		$user = HOST_NAME;
		$pass = (empty(HOST_PASS) ? '' : '--password=' . HOST_PASS) ;
		$db   = HOST_DB;
		$fn = DUMP_FILE;
		$ddir = DUMP_DIR;
		$mysqldumppath = MYSQLDUMP_PATH;
		$exec = "$mysqldumppath --user=$user $pass --host=$host $db > $fn";/// echo $exec;
		exec($exec,$output);
		if(!DUMP_ONE_FILE) {
			$exec = "$mysqldumppath --user=$user $pass --host=$host $db > $ddir/$now.sql";
			exec($exec,$output);
		}	
		G('db_lastbackup', $now);
	}	
}

function dbrestore() {
	$mysql = MYSQL_PATH;
	$user = HOST_NAME;
	$pass = (empty(HOST_PASS) ? '' : '-p' . HOST_PASS) ;
	$db   = HOST_DB;
	$fn = DUMP_FILE;
	if(file_exists($fn)) {
		$exec = "$mysql -u $user $pass $db < $fn"; //echo $exec;
		exec($exec,$output);
		return TRUE;	
	}
	return FALSE;
}


function dir_list($directory) {
	$files = array_diff(scandir($directory), array('..', '.'));
	return $files;
}


function processFileType($mimeType) {
	$mimeType = explode('/',$mimeType);
	$type1 = $mimeType[0];
	$type2 = $mimeType[1];
	
	switch($type1) {
		case 'text' :
			if($type2 == 'x-php') return 'code';
			return 'text';
		break;
		
		case 'image':
			return 'image';
		break;
		
		case 'application':
			if($type2 == 'zip') return 'archive';
		break;
	}
	
	return 'default';
}


function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('bytes', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
} 

/** CSS\JS GENERATOR **/
// headers;



function Hset($hname) {
	global $_SESSION;
	$_H = $_SESSION['headerlinks'];
	if(!in_array($hname, $_H)) 	$_SESSION['headerlinks'][] = $hname;
}

function Hget($hname) {
	global $_SESSION;
	$_H = @$_SESSION['headerlinks'];
	if(isset($_H[$hname])) return $_H[$hname];
	return FALSE;
}

// return message
function msg($status, $message, $redirect = false) {
	$arr = array('status' => $status, 'message' => $message);
	if($redirect) $arr['redirect'] = $redirect;
	echo json_encode($arr); die();
}

function tslash($path){
	$path = rtrim($path, '/') . '/';
	return $path;
}

function trimslashes($path) {
	$path = trim($path, '/');
	$path = str_replace('//','/', $path);
	return $path;
}

function btn_submitForm($text = 'save', $form = 'form') {
	echo "<a class='btn submit' href='javascript:saveForm(\"$form\");'>" . T($text) . "</a>";
}

function drawtreeoptions($tree, $lvl=-1){
	$lvl++;
	foreach($tree as $leaf => $subleafs) {
		$_leaf = substr($leaf, 1);
		$name =  str_repeat('—', $lvl) . $_leaf;
		echo "<option value='$_leaf'>$name</option>";
		if(is_array($subleafs)) {
			drawtreeoptions($subleafs, $lvl);
		}
	}
}

function drawdirs($dir = '') {
	$tree = fm()->dloop($dir); print_r($tree);
	drawtreeoptions($tree);
}


function first() {
	global $_PATH;
	return (bool)(count($_PATH) < 2);
}



function langs() {
	return tpl('langs');
}

function moveToBottom($arr, $key) {
	if(!isset($arr[$key])) return $arr;
	$v = $arr[$key];
	unset($arr[$key]);
	$arr[$key] = $v;
	return $arr;
}