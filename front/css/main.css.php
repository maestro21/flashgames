
* {
	font-family: 'Open Sans';
	color: <?php echo $textColor; ?>
}

h1,h2,h3,h4,h5,h6 {
	color: <?php echo $mainColor; ?>;	
}

h1,h2,h3,h4,h5,h6,
.footer a, .header a {
	font-family: 'PT Serif';
}

.fa {
	font-family: FontAwesome !important;
}

body, html {
	height: 100%;
	padding: 0px; 
	margin: 0px;
}

body.admin {
	padding-top:35px;
}


.page-wrapper {
    min-height: 100%;
    margin-bottom: -50px;
}
* html .page-wrapper {
    height: 100%;
   
}
.page-buffer {
    height: 80px;
}


a {
 color: <?php echo $mainColor2; ?>;	
 font-weight:bold;
 cursor:pointer;
 text-decoration: none;
}


.wrap {
	width:1200px;
	margin:auto auto;
	display: block;
}


.header,
.header a,
.footer,
.footer .wrap,
.footer a {
	background-color: <?php echo $mainColor; ?>;
	color: <?php echo $bgColor; ?>;
}
	.header a.active,
	.header a:hover {
		color: <?php echo $mainColor; ?>;
		background-color: <?php echo $bgColor; ?>;
	}

.header .wrap {
	height:70px;
}

.header .wrap div {
	display: block;
	float: left;
	margin-right: 50px;
}

	.menu {
		height:70px;
	}
	
	.menu a{
		font-size:18px;
		line-height:20px;
		padding:25px 20px;
		display:table-cell;
		font-weight:bold;
	}

		.logo img{
			margin: 10px;
		}
		
		.topmenu {
			
		margin: 0 50px;
		}
	
		.langs {
			float:right !important;
		}


	
.content {
	padding-bottom:30px;
	font-size:15px;
	text-align:justify;
}
	

	.item {
		padding:5px 20px;
		text-align:justify;
	}

.footer {
	height: 50px;
}	
	
.footer .wrap { 
	padding-left: 300px;
	padding-top: 15px;
	font-size: smaller;
}


.login .center {
	text-align: center;
	margin-top: 10%;
}


.i18nform {
	padding-left: 0 !important;	
}

 #form.i18nform input,
 #form.i18nform textarea,
 #form.i18nform select
{
	min-width: 200px  !important;
	width: 200px  !important;
}

.message {
	padding: 10px;
	margin: 10px;
    border: 1px black solid;
    display: inline-block;
}


.header a,
.footer a,
h1 {
	font-family: 'Roboto', sans-serif;
	text-transform: uppercase;
	font-weight: 300;
}

.gamelist div {
	display: inline-block;
}


.cats a {
    color: #b00;
    font-weight: 400;
    cursor: pointer;
    text-decoration: underline;
	font-family: 'Roboto', sans-serif;
	margin-right:10px;
}