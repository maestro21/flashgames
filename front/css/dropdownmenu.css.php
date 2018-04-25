	/* DROPDOWN */
	
	/* NECESSARY THINGS */
	
	
	.dropdownmenu {
		display: inline-block;
	}
	
	.dropdownmenu ul {
		float: left;		
		margin:0;
		padding: 0px;
		list-style-image: none;
		list-style-type: none;
	}	
	.dropdownmenu > ul > li {
		float: left;
		position: relative;		
		list-style: none;
		margin:0;
	}
	/*.dropdownmenu a {
		display: block;
	}*/
	

	.dropdownmenu ul ul {
		position: absolute;
		left: 0;
		top: 100%;
		visibility: hidden;
		opacity: 0;
		box-shadow: 0 2px 5px rgba(0,0,0,0.5); 
	}
	.dropdownmenu ul ul ul {
		left: 100%;
		top: 0;
	}
	.dropdownmenu li:hover > ul {
		visibility: visible;
		opacity: 1;
	}
	