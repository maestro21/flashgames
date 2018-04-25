<div class="adminpanel">
	<div class="wrap">
		<div class="dropdownmenu">		
			<ul>
				<li><a href="<?php echo BASE_URL;?>"><img src="<?php echo PUB_URL;?>img/logo.png" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp;
				<li>
					<a href="<?php echo BASE_URL;?>modules/admin">Modules</a>
					<?php $modules = cache('modules'); 
					if($modules) {?>
						<ul>
							<?php foreach($modules as $module) { 
								if($module['status'] > 1) {?>
								<li><a href="<?php echo BASE_URL . $module['name'];?>/admin"><?php echo T($module['name']);?></a></li>
							<?php } 
							}?>	
						</ul>
					<?php } ?>
				</li>		
			</ul>
		</div>
		<div class="logout">
			<a href="<?php echo BASE_URL;?>system/logout"><?php echo T('logout');?></a>
		</div>
	</div>
</div>