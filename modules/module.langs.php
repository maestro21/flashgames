<?php 

class langs extends masterclass {
	
	
function gettables() {
		return
		[
			'langs' => [
				'fields' => [
					'abbr' 			=> [ 'string', 'text', 'search' => TRUE ],
					'name' 			=> [ 'string', 'text', 'null' => TRUE  ],
					'website'		=> [ 'string', 'url',  'null' => TRUE  ],
					'active'		=> [ 'bool', 'checkbox', 'null' => TRUE ],
				],
				'idx' => [
					'abbr' => [ 'abbr' ],
				]
			],
		];	
	}
	
	    /** Save element **/
    public function save() {  //die();
		$this->parse = FALSE; 
		$ret = $this->saveDB($this->post['form']);
		$this->cache();
		return json_encode($ret);
	}
	
	public function install() {
		parent:: install();
		$this->saveDB(
			[
				'abbr' => 'en',
				'name' => 'English',
				'active' => 1
			]);
		$this->cache();	
	}
}