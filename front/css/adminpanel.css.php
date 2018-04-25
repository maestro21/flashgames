.adminpanel{
	background-color:black;
	color: white;
	padding:5px;
	height:25px;
	box-shadow: 0 2px 5px rgba(0,0,0,0.5); 
	position: fixed;
	z-index: 10;
	width: 100%;
	top: 0;
	-webkit-box-shadow: 0px 0px 2px 1px #555;
       -moz-box-shadow: 0px 0px 2px 1px #555;
            box-shadow: 0px 0px 2px 1px #555;
}	

.adminpanel + .page-wrapper {
	/*margin-top: 30px;*/
}

	.adminpanel a{
		color: white;
		font-weight:normal;
	}	
	
	.adminpanel .dropdownmenu > ul > li > a:hover {
		background-color: transparent;
	}
	
	.adminpanel li {
		background-color:black;
	}
	
	.adminpanel .dropdownmenu {
		padding:0px;
		list-style:none;
	}
	
		.adminpanel .dropdownmenu ul {
			list-style:none;
			background-color:black;
		}
		
			.adminpanel .dropdownmenu > ul > li > ul {
				margin-left: -5px;
				padding-top: 5px;
			}
		
			.adminpanel .dropdownmenu > ul  ul a {				
				display: block;
				padding: 5px 10px;
			}
		
			.adminpanel .dropdownmenu > ul ul  a:hover {
				color: black;
				background-color: white;
			}
	
.adminpanel .logout {
	float: right;
}