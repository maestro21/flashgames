<?php
class i18n extends masterclass {

	function gettables() {}

	
	function extend() {
		$this->description = 'Core module for internationalization';
		
		$this->options = [
			'type' => [
				1 => WIDGET_TEXT,
				2 => WIDGET_TEXTAREA,
				3 => WIDGET_KEYVALUES
			],
		];
		/* fields */
		$this->fields = [					
					'label'			=>	[ 'string', 'text', 'search' => TRUE,],	
					'type'			=>	[ 'int', 'select' ],						
				];
		$langs = getLangs();		
		foreach($langs as $lang) {
			$this->fields[$lang['abbr']] = [ 'string', 'text'];
		}
		
		
		$this->data = cache('i18n');
		
	}

	
	function items() {}
	function del() {}
	function add() {}
	function edit() {}
	
	/**
		Admin method for class data listing
		@return array() or FALSE;
	**/
	public function admin() {
		if(hasRight($this->rights['admin'])){
			return $this->data;
		}
		return FALSE;
	}	
	
	
	public function save() {
		$this->ajax =true;
		$data = array();
		$langs = getLangs();
		foreach($this->post['form']['fields'] as $row) {
			if($row['type'] == 3) {
				$langs = getLangs();		
				foreach($langs as $lang) {
					$row[$lang['abbr']] = strToKeyValues($row[$lang['abbr']]);
				}	
			}
			$data[$row['label']] = $row;
		}	
		ksort($data, SORT_FLAG_CASE);
		$this->cache($data);
		
		echo json_encode(array('message' => T('saved'), 'status' => 'ok'));	die();	
	}
	

	
	function addField($key = '{key}', $data = null) {
		$this->ajax = true;	
		
		
		return tpl('i18n/field', array(
			'key' 		=> $key,
			'fields' 	=> $this->fields,
			'widgets' 	=> $this->options['type'],
			'data' 		=> $data)
		);
	}
	
}