<?php class system extends masterclass {

	function gettables() {
		return [
			'system' => [
				'fields' => [
					'name' 		=> [ 'string', 'text', ],
					'value' 	=> [ 'string', 'text', ],
					'deletable'	=> [ 'bool', 'checkbox', ]
				],
				'idx' => [
					'name' => [ 'name' ],
				]
			],
		];	
	}
	
	function logout() {
		global $_SESSION; 
		unset($_SESSION['user']);
		redirect(BASE_URL);		
	}
	
	
	function install() { 
		if(!superAdmin()) die();
		parent :: install();		
		include('data/default.globals.php'); 
		foreach($globals as $k => $v) {
			$item = array(
				'name'		=> $k,
				'value'		=> $v,
				'deletable'	=> 0,
			);
			q($this->cl)->qadd($item)->run();
		}
	}
	
	function set($key, $value) {
		$this->id = q($this)->select('id')->where(qEq('name',$key))->run(MySQL::DBCELL);
		$this->saveDB(array('name' => $key, 'value' => $value));
		$this->cache();	
	}
	
	function save() {
		$ret = parent:: save();
		$this->cache();
		return $ret;		
	}
	
	function delete() {
		parent::delete();
		$this->cache();	
	}
	
	function extend() {
		$this->description = 'Core module for setting up global settings';	
		/*$this->buttons = array(
			'admin' => array( 'add' => 'fa-plus', 'langs' => 'languages', 'themes' => 'themes' ),
			'table' => array( 'item/{id}' => 'edit',  'view/{id}' => 'view', ),
		); */
	}
	
	function cache($data = NULL) {
		$cache 	= array();		
		$data 	= q($this->cl)->qlist()->run();
		foreach($data as $row){
			$cache[$row['name']] = $row['value'];
		}
		cache($this->className, $cache);
	}
	
	function login() { 
		if(superAdmin()) redirect(BASE_URL);
	
		if($this->post) { 
			$this->ajax = true;
			if(md5($_POST['pass']) == ADM_PASS){;	
				session('user', true);				
				echo json_encode(array('message' => T('success'), 'status' => 'ok', 'redirect' => BASE_URL));  die();
			}
			echo json_encode(array('message' => T('wrong pass'), 'status' => 'error', 'redirect' => BASE_URL));  die();
		}
	}
	
	
}