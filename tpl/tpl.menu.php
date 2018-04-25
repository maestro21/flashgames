<ul class="topmenu"> <?php $path = implode('/',path());?>
	<li><a href="<?php echo BASE_URL;?>" <?php if(empty($path)) echo ' class="active"';?>>All games</a></li>
	<?php $data = explode(',', G('categories')); foreach($data as $cat) { $cat = trim($cat);?>
		<li><a href="<?php echo BASE_URL;?>cat/<?php echo $cat;?>" <?php if($cat == path(1)) echo ' class="active"';?>><?php echo $cat;?></a></li>
	<?php } ?>
</ul>