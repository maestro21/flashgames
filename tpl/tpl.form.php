<?php  
$id = null; if(isset($data['id'])) $id = $data['id'];
$prefix = 'form';
foreach($fields as $key => $field) { 

$widget = $field[1];
$value = (isset($data[$key]) ? $data[$key] : "");
$required = (@$field['required'] > 0);
?>

<tr>
	<?php
		switch($widget) { 
			case WIDGET_HIDDEN: break;
			
			case WIDGET_HTML:
			case WIDGET_TEXTAREA:
			case WIDGET_BBCODE:
				echo "<td colspan=2>";
				break;
			
			default: 
				echo "<td class='lbl'>" . T($key) . ($required ? "<sup>*</sup>":'') . "</td><td>";
				break;
	}

	switch($widget) { 

		case WIDGET_INFO: ?>
			<?php echo $value;?>
			<input type="hidden"
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		
		
		<?php break;
		

		case WIDGET_TEXT: ?>
			<input type="text" 
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		<?php break;
		
		case WIDGET_SLUG: ?>
			<input type="text" 
				class="slug"
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		<?php break;
		
		case WIDGET_EMAIL: ?>
			<input type="email" 
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		<?php break;
		
		case WIDGET_PHONE: ?>
			<input type="tel" 
				class="phone"
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		<?php break;
		
		case WIDGET_NUMBER: ?>
			<input type="number" 
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		<?php break;
		
		case WIDGET_URL: ?>
			<input type="url" 
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"<?php if($required) echo " required";?> />
		<?php break;
		
		case WIDGET_KEYVALUES: 
			$values = array();
			foreach($value as $k => $v) {
				$values[] = $k . '=' . $v;
			}
			$value = implode(PHP_EOL, $values);
		
		?>
			<textarea<?php if($required) echo " required";?> cols="50" rows="10" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]"
				id="<?php echo $key;?>"><?php echo $value;?></textarea>
		<?php break;
		
		case WIDGET_TEXTAREA: ?>
			<?php echo T($key);?>:<br>
			<textarea<?php if($required) echo " required";?> cols="100" rows="10" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]"
				id="<?php echo $key;?>"><?php echo $value;?></textarea>
		<?php break;
		
		case WIDGET_HTML:  ?>
			<?php echo T($key);?>:<br>
			<textarea<?php if($required) echo " required";?> class="html" cols="100" rows="10" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"><?php echo $value;?></textarea>
				
		<?php
			/*include('external/maestroeditor/editor.php');
			maestroeditor($key, $key, $value);
		
		/* ?>
			<?php echo T($key);?>:<br>
			<textarea cols="100" rows="20" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>"><?php echo $value;?></textarea>
			<script type="text/javascript">
				<!--CKEDITOR.replace( "<?php echo $key;?>" );-->
				bkLib.onDomLoaded(function() {
					new nicEditor({fullPanel : true,maxHeight : 600}).panelInstance('<?php echo $key;?>');
				});
			</script>				
		<?php break;	/**/		
		break;
		
		case WIDGET_BBCODE: ?>
			<?php echo T($key);?>:<br>
			<textarea<?php if($required) echo " required";?> cols="100" rows="15" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]"
				id="<?php echo $key;?>"><?php echo $value;?></textarea>
			<script type="text/javascript">
				CKEDITOR.config.toolbar_Full = [
					["Source"],
					["Undo","Redo"],
					["Bold","Italic","Underline","-","Link", "Unlink"], 
					["Blockquote", "TextColor", "Image"],
					["SelectAll", "RemoveFormat"]
				] ;
				CKEDITOR.config.extraPlugins = "bbcode";
				//<![CDATA["
					var sBasePath = document.location.pathname.substring(0,document.location.pathname.lastIndexOf("plugins")) ;
					var CKeditor = CKEDITOR.replace( "<?php echo $key;?>", { 
							customConfig : sBasePath + "plugins/bbcode/_sample/bbcode.config.js"
					}  );
				//]]>									
			</script>
		<?php break;			
		
		case WIDGET_PASS: ?>
			<input type="password"<?php if($required) echo " required";?> value="" name="<?php echo $prefix;?>[<?php echo $key;?>]" id="<?php echo $key;?>" />";
		<?php break;

		case WIDGET_HIDDEN: ?>
			<input type="hidden"
				value="<?php echo $value;?>" 
				name="<?php echo $prefix;?>[<?php echo $key;?>]" 
				id="<?php echo $key;?>" />
		<?php break;
		
		case WIDGET_CHECKBOX: ?>
			<!--<input type="hidden" name="<?php echo $prefix;?>[<?php echo $key;?>]" value="">-->
			<input type="checkbox"<?php if($required) echo " required";?>  value=1 name="<?php echo $prefix;?>[<?php echo $key;?>]" id="<?php echo $key;?>" 
			<?php if($value == 1) echo " checked";?> />
		<?php break;
		
		case WIDGET_RADIO: ?>
		<?php 
			if(is_array($options) && sizeof($options) > 0) { 
				foreach (@$options[$key] as $kk => $vv){ ?>
					<?php echo T($vv);?>
					<input type="radio" 
						name="<?php echo $prefix;?>[<?php echo $key;?>]" 
						value="<?php echo $kk;?>"<?php if($required) echo " required";?> 
						<?php if($kk == $value) echo " checked";?> />
			<?php } ?>
		<?php } ?>
		<?php break;
		
		case WIDGET_SELECT: ?>
			<select name="<?php echo $prefix;?>[<?php echo $key;?>]" id="<?php echo $key;?>">
			<?php 
				if(is_array($options) && sizeof($options) > 0) { 
					foreach (@$options[$key] as $kk => $vv){ ?>
						<option value="<?php echo $kk;?>" 
							<?php if($kk == $value) echo " selected='selected'";?>><?php echo T($vv);?>
						</option>
				<?php } ?>
			<?php } ?>
			</select>
		<?php break;        

		case WIDGET_MULTSELECT: ?>
			<select multiple<?php if($required) echo " required";?> name="<?php echo $prefix;?>[<?php echo $key;?>][]" id="<?php echo $key;?>">
			<?php 
				$dat = array_flip(explode(",", $value));
				if(is_array($options) && sizeof($options) > 0) { 
					foreach (@$options[$key] as $kk => $vv){ ?>
						<option value="<?php echo $kk;?>" 
							<?php if(isset($dat[$kk])) echo " selected='selected'";?>><?php echo T($vv);?>
						</option>
				<?php } ?>
			<?php } ?>
			</select>
		<?php break;     
		case WIDGET_DATE: 
			preg_match_all("/[[:digit:]]{2,4}/", $value, $matches);	
			$nums = $matches[0]; ?>
			<input type="text" class="date year" name="<?php echo $prefix;?>[<?php echo $key;?>][y]" 
				value="<?php echo (isset($nums[0])?$nums[0]:date("Y"));?>" size="4">-
			<select name="<?php echo $prefix;?>[<?php echo $key;?>][m]>">
				<?php if(!isset($nums[1])) $nums[1] = date("m");
				for($i=1;$i<13;$i++) { ?>
					<option value="<?php echo $i;;?>"<?php if($i==@$nums[1]) echo ' selected="selected"';?>><?php echo T("mon_$i");?>
				</option>
				<?php } ?>	
			</select>					
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][d] value="<?php echo (isset($nums[2])?$nums[2]:date("d"));?>" size=2> (YYYY-MM-DD)
		
		<?php break;
		
		
		case WIDGET_TIME: 
			preg_match_all("/[[:digit:]]{2,4}/", $value, $matches);	
			$nums = $matches[0]; ?>
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][h] value="<?php echo (isset($nums[0])?$nums[0]:date("G"));?>" size=2>:
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][mi] value="<?php echo (isset($nums[1])?$nums[1]:date("i"));?>" size=2>:
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][s] value="<?php echo (isset($nums[2])?$nums[2]:date("s"));?>" size=2>(HH:MM:SS)
		
		<?php break;
		
		
		case WIDGET_DATETIME: 
			preg_match_all("/[[:digit:]]{2,4}/", $value, $matches);	
			$nums = $matches[0]; ?>
			<input type="text" class="date year" name="<?php echo $prefix;?>[<?php echo $key;?>][y]" 
				value="<?php echo (isset($nums[0])?$nums[0]:date("Y"));?>" size="4">-
			<select name="<?php echo $prefix;?>[<?php echo $key;?>][m]>">
				<?php if(!isset($nums[1])) $nums[1] = date("m");
				for($i=1;$i<13;$i++) { ?>
					<option value="<?php echo $i;;?>"<?php if($i==@$nums[1]) echo ' selected="selected"';?>><?php echo T("mon_$i");?>
				</option>
				<?php } ?>	
			</select>					
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][d] value="<?php echo (isset($nums[2])?$nums[2]:date("d"));?>" size=2> (YYYY-MM-DD) &nbsp&nbsp&nbsp
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][h] value="<?php echo (isset($nums[3])?$nums[3]:date("G"));?>" size=2>:
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][mi] value="<?php echo (isset($nums[4])?$nums[4]:date("i"));?>" size=2>:
			<input type="text" class="date" name=<?php echo $prefix;?>[<?php echo $key;?>][s] value="<?php echo (isset($nums[5])?$nums[5]:date("s"));?>" size=2>(HH:MM:SS)
		
		<?php break;

		case WIDGET_CHECKBOXES: 
			$i = 0; 
			$dat = array_flip(explode(",",@$data[$key]));?>
			<div>
			<?php foreach (@$options[$key] as $kk => $vv){ 
				if($i % 10 == 0){  ?>
					</div><div style="float:left;border:1px black solid;">
				<?php } ?>
				<p><input type="checkbox" value="$kk" name="<?php echo $prefix;?>[<?php echo $key;?>][]" 
					<?php if(isset($dat[$kk])) echo " checked";?>><?php echo T($vv);?></p>
				<?php $i++;
			} ?>
			</div>
		<?php break;

		case WIDGET_FILE:  
				$filename = str_replace('{id}', $id, $field['filename']); 
				?>
				<div>
					<label for="<?php echo $key;?>"><i class="fa fa-plus icon file"></i> Upload file</label>					
					<input type="file" name="<?php echo $key;?>" id="<?php echo $key;?>" />
					<?php if(file_exists(BASE_PATH . $filename)) { ?>
						<br><img src="<?php echo BASE_URL . $filename;?>?v=<?php echo rand();?>"><a href="<?php echo BASE_URL . path(0);?>/delimg/<?php echo $id;?>" class="fa fa-remove icon"></a>
					<?php }?>
				</div>
			<?php 	
			break;		
		
	} ?>
	<label for="<?php echo $key;?>"></label>
	</td>
	</tr>
<?php }?>

<script>
	tinymce.init({ 
		selector:'textarea.html',
		menu: {},
		plugins: [
			'link lists image media table hr searchreplace visualblocks visualchars code fullscreen charmap insertdatetime template textcolor colorpicker alphamanager'
		],
		
		toolbar: 'html undo redo |  bold italic underline strikethrough | styleselect forecolor backcolor removeformat  | alignleft aligncenter alignright alignjustify | bullist numlist | table hr | insert link image media ',
	
		setup: function (editor) {
			editor.addButton('html', {
				text: 'html',
				icon: false,
				onclick: function () {
					//var $ = tinymce.dom.DomQuery;
					var myTextarea = $('#' + editor.id);
					var myIframe = $(editor.iframeElement);
				
					myIframe.toggleClass("hidden");
					myTextarea.toggleClass("visible");
					if ($('iframe.hidden').length > 0) {
					  myTextarea.prependTo(".mce-edit-area");
					  myTextarea.html(editor.getContent({
					  source_view: true
					}));
					} else {
						editor.setContent(myTextarea.val());
						myTextarea.appendTo('body');
					}
				}
			});
	  },	
	});


</script>
