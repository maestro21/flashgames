/** Forms **/
select,
input {
	width: 300px;
	padding: 8px;
	border-radius: 3px;
	box-sizing: border-box;
	border: 1px <?php echo $mainColor; ?> solid;
}

textarea {
	border-radius: 3px;
	width: auto;
	min-width: 1200px !important;
	border: 1px <?php echo $mainColor; ?> solid;	
}

.form sup {
	font-size: 14px;
	font-weight: 900;
	color: <?php echo $mainColor; ?>;
}


input[type="checkbox"] + label:before {
    content: '';
    background: #fff;
    border: 1px solid <?php echo $mainColor; ?>;
    display: inline-block;
    vertical-align: middle;
    width: 22px;
    height: 22px;
    padding: 2px;
    margin: 10px;
    text-align: center;
    line-height: 15px;
    font-size: 15px;
    border-radius: 3px;
    margin-left: 0;
    margin-top: 8px;
}

input[type=file] {
    display: none;
}

.mce-tinymce {
	border: 1px <?php echo $mainColor; ?> solid !important;
	border-radius: 3px;
	width: 1200px !important;
}
.hidden {
  visibility: hidden !important;
  display: none !important;
}

.visible {
  visibility: visible !important;
  display: block !important;
}


input[type="checkbox"] {
    display: none;
}

input[type="checkbox"]:checked + label:before {
    content: "\f00c";
	font-family: 'FontAwesome';
}

input[type="checkbox"] + label:before {
	cursor: pointer;
}

form sup {
    font-size: 14px;
    font-weight: 900;
    color: <?php echo $mainColor2; ?>;
}

.messages .message {
	display: inline-block;
	margin: 20px;
	border: 1px gray solid;
	padding: 10px;
	width: 300px;
}