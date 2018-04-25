.filenode {
    display: inline-block;
    width: 145px;
    border: 1px gray solid;
    margin: 10px;
	padding: 10px;
	padding-left: 120px;
	background-color: #fbfbfb;
	background-repeat: no-repeat;
	background-position: 30px center;
	cursor: pointer;
	overflow: hidden;
}


.filenode.dir {
	background-image:url('<?php echo IMG_URL;?>fileviewer/folder.png');
}


.filenode.text {
	background-image:url('<?php echo IMG_URL;?>fileviewer/txt.png');
}
.filenode.code {
	background-image:url('<?php echo IMG_URL;?>fileviewer/code.png');
}

.filenode.default {
	background-image:url('<?php echo IMG_URL;?>fileviewer/default.png');
}
.filenode.image {
	background-image:url('<?php echo IMG_URL;?>fileviewer/img.png');
}
.filenode.archive {
	background-image:url('<?php echo IMG_URL;?>fileviewer/archive.png');
}
.filenode.dir {
	background-image:url('<?php echo IMG_URL;?>fileviewer/folder.png');
}

h2.path a{
	padding: 0 10px;	
}

.wrap-fileviewer h2 {
	margin-bottom: 0;
}
.wrap-fileviewer h1 {
	margin-top: 10px;
}


.wrap-fileviewer p {
	font-size: 12px;
	margin: 5px;
	color: #666;
}

.wrap-fileviewer p b {
	font-size: 16px;	
}

.selected {
	border-color: navy;
	background-color: lightblue;
}

.wrap-fileviewer h1 div {
	display: inline-block;
	margin-right: 30px;
}