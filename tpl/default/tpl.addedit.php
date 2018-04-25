<h1><?php echo $title;?></h1>
<?php $formid = $class . '_form_item_' . $id;?>
<form method="POST" id="form" class="content" enctype='multipart/form-data' action="<?php echo BASE_URL . $class;?>/save?ajax=1">
<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
	<table cellpadding=0 cellspacing=0>
	<?php 
		echo drawForm($fields, $data, $options); 
	?>
		<tr>
			<td colspan="2" align="center">
				<div class="btn submit"><?php echo T('save');?></div>
				<div class="messages"></div>
			</td>
		</tr>
	</table>	
</form>

<script src="<?php echo BASE_URL;?>external/savectrls.js" type="text/javascript"></script>
