<ul>
	<?php $data = explode(',', G('menu')); foreach($data as $cat) { ?>
		<a href="<?php echo BASE_URL;?>cat/<?php echo $cat;?>" <?php if($cat = path(2)) echo ' class="active"';?>><?php echo $cat;?></a> 
	<?php } ?>
</ul>