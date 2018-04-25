<?php $id = $data['id'];
$path = 'data/img/'. $id . '.png'; 
$size = explode('x', G('imgsize'));?>
<h1><?php if(file_exists(BASE_PATH . $path)) { ?><img src="<?php echo BASE_URL . $path;?>?v=<?php echo rand();?>" width="<?php echo $size[0];?>" height="<?php echo $size[1];?>" align="left"><?php } ?><?php echo $data['name'];?>		
<?php if(superAdmin()) { ?>
	<a href="<?php echo BASE_URL.$class;?>/edit/<?php echo $id;?>" target="_blank" class="fa-pencil fa icon icon_sml"></a>
	<a href="javascript:void(0)" onclick="conf('<?php echo BASE_URL.$class;?>/del/<?php echo $id;?>', '<?php echo T('del conf');?>')" class="fa-trash-o fa icon icon_sml"></a>	<br>
<?php } ?></h1>
Genre: 
<span class="cats"><?php $cats = explode(',',$data['categories']);
			foreach($cats as $cat) { ?>
				<a href="<?php echo BASE_URL;?>cat/<?php echo $cat;?>"><?php echo $cat;?></a>
			<?php } ?>
			</span>
			
<p>		<?php echo $data['description'];?>	</p>
<?php echo $data['code'];?>