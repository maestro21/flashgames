<?php class games extends masterclass {

	function gettables() {
		return 
		[
			'games' => [
				'fields' => [					
					'name'			=>	[ 'string', 'text', 'search' => TRUE],
					'description'	=> 	[ 'text', 'textarea', 'search' => TRUE ],
					'code'			=>	[ 'text', 'textarea' ],
					'categories'	=>	[ 'string', 'text' ],
					'image'			=>  [ null, 'file', 'filename' =>   'data/img/{id}.png']	
				],
			],
			'game_categories' => [
				'fields' => [
					'game_id' => ['int'],
					'category' => ['string'] 
				]
			],
			
		];		
	}
	
	function install() {
		parent::install();
		G('categories', 'action,puzzle,shooting,racing,strategy,arcade,sports,io');
		G('imgsize', '150x100');
	}
	
	
	function extend() {
		$this->description = 'Module for adding games';		
	}
	
	
	function save() {
		if(!CheckLogged()) gohome();
		
		$cats = explode(',', $this->post['form']['categories']);
		$ret = parent::save();
		
		/* save categories */
		q()	->delete()
			->from('game_categories')
			->where(qEq('game_id',$this->id))
			->run();			
		foreach($cats as $cat) {
			$cat = trim($cat);
			q()	->insert()
				->into('game_categories')
				->set('game_id',$this->id)
				->set('category', $cat)
				->run();
		}		
		
		/* upload image */
		if(@$this->files['image']) {			
			$path = BASE_PATH . 'data/img/'. $this->id . '.png';
			$imgsize = explode('x', G('imgsize'));
			fm()->fupload('image', $path, $imgsize);
		} 
		
		return $ret;
	}
	
	function delimg() {
		if(!CheckLogged()) gohome();
		$path = BASE_PATH . 'data/img/'. $this->id . '.png';
		unlink($path);
		redirect(BASE_URL . $this->cl . '/edit/' . $this->id); die();
	}
	
	
	function items() {		
		$q = q()->select('g.*')->from('games','g');
		if(path(0) == 'cat') { 
			$q	->join('game_categories','`gc`.`game_id` = `g`.`id`', 'gc')
				->where(qEq('gc`.`category',path(1)));
		}		
		
		return $q->run();
		
	}
	
}