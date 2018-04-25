<?php if(path(0) == 'cat') $title = path(1); else $title = T('all games'); ?>
<h1><?php echo $title;?>
<?php if(superAdmin()) {?> <a href="<?php echo BASE_URL;?>games/add" class="fa fa-plus icon"></a> <?php } ?></h1>

<div class="gamelist">
<?php  foreach (@$data as $row){ 
	$id = $row['id']; unset($row['id']); 
	$path = 'data/img/'. $id . '.png';
	$size = explode('x', G('imgsize'));
	if(!file_exists(BASE_PATH . $path)) $path = BASE_URL . 'front/img/nothumb.jpg'; else $path = BASE_URL . $path;?>
	<div>
		<?php if(superAdmin()) { ?>
			<a href="<?php echo BASE_URL.$class;?>/edit/<?php echo $id;?>" target="_blank" class="fa-pencil fa icon icon_sml"></a>
			<a href="javascript:void(0)" onclick="conf('<?php echo BASE_URL.$class;?>/del/<?php echo $id;?>', '<?php echo T('del conf');?>')" class="fa-trash-o fa icon icon_sml"></a>	<br>
		<?php } ?>
		<a href="<?php echo BASE_URL.$class;?>/view/<?php echo $id;?>" target="_blank">
			<b><?php echo $row['name'];?></b><br>
			<img src="<?php echo $path;?>?v=<?php echo rand();?>" width="<?php echo $size[0];?>" height="<?php echo $size[1];?>">
		</a>
		<br><span class="cats"><?php $cats = explode(',',$row['categories']);
			foreach($cats as $cat) { ?>
				<a href="<?php echo BASE_URL;?>cat/<?php echo $cat;?>"><?php echo $cat;?></a>
			<?php } ?>
			</span>
	</div>		
<?php } ?> 
</div>
