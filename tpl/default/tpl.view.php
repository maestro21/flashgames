<table>
<?php foreach ($data as $k => $v){ ?>
	<tr>
		<td><?php echo T($k);?></td>
		<td><?php echo (isset($options[$k])?T($options[$k][$v]):$v);?></td>		
	</tr>	
<?php	
} ?>
</table>