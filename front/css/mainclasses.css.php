hr {
	color: <?php echo $mainColor; ?>;
	background-color:<?php echo $mainColor; ?>;
	border: 1px <?php echo $mainColor; ?> solid;
}

	

/* Table styles */
.table, 
table {
	width: 100%;
}
 .table .td,
table td {
	padding:10px 20px;
}	
.table input[type=text],
table input[type=text]{
	width:500px;
}	
.td {
	display: table-cell !important;
}

.thead .td,
.thead .td a,
thead td,
thead td a {
	font-weight:bold;
	color: <?php echo $bgColor; ?>;
	background-color:<?php echo $mainColor; ?>;
}
.table input.date,
table input.date {
	width:15px;
}
.table input.date.year,
table input.date.year {
	width:40px;
}
	
.label {
	width:100px;
	text-align:right;
	vertical-align:top;
	font-weight:bold;
}	



.table {
	display:table;
}

.tr {
	display: table-row;
}

.td {
	display: table-cell;
}


/** pagination **/
.pagination {
	margin:20px;
}
	
.pagination a{
	color: white;
	background-color: black;
	border:1px black solid;
	padding: 3px 10px;
	margin: 5px;
	line-height: 30px;
	text-decoration:none;
}		

.pagination a:hover,
.pagination a.active
{
	color: black;
	background-color:white;
}





/** main classes **/


.hidden{
	display:hidden;
}
.hover {
	cursor:pointer;
}
.left {
	float:left;
}
.right {
	float: right;
}
.tleft {
	text-align: left;
}
.tright {
	text-align:right;
}

/* messages */

.done,
.ok {
	color: forestgreen ;
	border: 1px forestgreen solid;
	background-color: lightgreen;
}
.not,
.error {
	border: 1px darkred solid;
	background-color: pink;
	color: darkred;
}
.actual {
	border: 1px gold solid;
	background-color: #FFFF99;
}
.far {
	border: 1px darkgray solid;
	background-color: lightgray;
	color: darkgray;
}

.done,
.ok,
.actual,
.far,
.btn,
.not,
.error {
	padding:10px 20px;
	margin:10px;
	font-size:12px;
	text-align:left;
}

.done b,
.actual b,
.not b,
.far b,
.ok b,
.error b {
	font-size:14px;
}

/* buttons */

.btn {
	display:inline-block;
	cursor:pointer;
	color:black;
	text-decoration:none;
	font-weight:bold;
	border-radius: 3px;
	border: 1px <?php echo $mainColor2; ?> solid;	
	background-color:<?php echo $mainColor2; ?>;
	color:<?php echo $bgColor; ?>;
	text-align: center;
}

.btn:hover {
	color:<?php echo $mainColor2; ?>;
	background-color:<?php echo $bgColor; ?>;
}

.btn-active {
	background-color:blue;
	color:white;
}
.btn-active:hover {
	color: blue;
	border-color: blue;
}

.btn-ok {
	background-color:green;
	color:white;
}
.btn-ok:hover {
	color: green;
	border-color: green;
}

.btn-del {
	border-color: darkred;
	background-color:darkred;
	color:white;
}
.btn-del:hover {
	border-color: darkred;
	color: darkred;
}



.content .admin h1{
	display:inline-block;
}


/** icons **/

.fa.icon {
	border-radius: 100%;
	background-color: <?php echo $mainColor2; ?>;
	border: 2px solid <?php echo $mainColor2; ?>;
	color: <?php echo $bgColor; ?>;
	text-align:center;
	width: 20px;
	height: 20px;
	line-height:20px;
}

.fa {	
	font-weight: normal !important;
}


h1 .icon,
h1 .btn {
    position: relative;
    top: -3px;
    margin: 0;
    margin-left: 10px;
	font-size: 15px;
	border-width: 2px;
}
h1 .fa.icon,
.fa.icon-big {
	width: 40px;
	height: 40px;
	line-height:40px !important;
	font-size: 20px;
	border-color: white;
	box-shadow: 0 0 1pt 1px <?php echo $mainColor2; ?>;
}

.icon_sml {
	border: 1px solid <?php echo $mainColor2; ?>;
	width: 20px;
	height: 20px;
	line-height:20px !important;
}

.icon:hover {
	background-color: <?php echo $bgColor; ?>;
	color: <?php echo $mainColor2; ?>;
}


/** blockquote **/
blockquote {
  display:block;
  background: #fff;
  padding: 15px 20px 15px 45px;
  margin: 0 0 20px;
  position: relative;
  
  /*Font*/
  font-family: Georgia, serif;
  font-size: 16px;
  line-height: 1.2;
  color: #666;
  text-align: justify;
  
  /*Borders - (Optional)*/
  border-left: 15px solid <?php echo $textColor; ?>;
  border-right: 2px solid <?php echo $textColor; ?>;
  
  /*Box Shadow - (Optional)*/
  -moz-box-shadow: 2px 2px 15px #ccc;
  -webkit-box-shadow: 2px 2px 15px #ccc;
  box-shadow: 2px 2px 15px #ccc;
}

blockquote * {
	color: #666;
	font-family: Georgia;	
}

blockquote::before{
  content: "\201C"; /*Unicode for Left Double Quote*/
  
  /*Font*/
  font-family: Georgia, serif;
  font-size: 60px;
  font-weight: bold;
  color: #999;
  
  /*Positioning*/
  position: absolute;
  left: 10px;
  top:5px;
}

blockquote::after{
  /*Reset to make sure*/
  content: "";
}

blockquote a{
  text-decoration: none;
  background: #eee;
  cursor: pointer;
  padding: 0 3px;
  color: #c76c0c;
}

blockquote a:hover{
 color: #666;
}

blockquote em{
  font-style: italic;
}


h6 {
	font-size: 1.1em;
}

h5 {
	font-size: 1.2em;
}

h4 {
	font-size: 1.4em;
}

h3 {
	font-size: 1.6em;
}

h2 {
	font-size: 2em;
}

h1 {
	font-size: 2.5em;
}


.hand {
	cursor: pointer;
}