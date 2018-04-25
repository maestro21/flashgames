<?php header("Content-type: text/css"); 

$rebuild = (!file_exists('style.css')); 
$rebuild = true;



/* rebuild css if needed */
if($rebuild) {	
	include('../settings.php');
	include('../data/cache/system.php');
	include('../engine/functions/functions.php'); getGlobals();

	ob_start();
	/* google fonts */
	$fontfamilies = array(
		'Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic',
		'Raleway:400,800,300,200,700,500',
	);


	/* FA */
	$fa = file_get_contents('../' . EXT_FOLDER . 'fa/css/font-awesome.min.css'); 
	$fa = str_replace('..', '../' . EXT_FOLDER . 'fa', $fa);
	echo $fa;
	
	/* dropzone */
	include('../' . EXT_FOLDER . 'dropzone/dropzone.css');

	/* css params */
	$mainColor = '#000'; //$system['mainColor']; //'#222';
	$mainColor2 = '#b00';
	$textColor = '#222';
	$bgColor = 'white';

	/* theme */
	$tp = '../' . tpath() . 'style_vars.php';  
	if(file_exists($tp)){
		include($tp);
	}
	
	/* main css */
	$css = dir_list('css');
	foreach($css as $file) {
		include('css/' . $file); 
	}

	
	foreach($fontfamilies as $font) {
		echo file_get_contents('http://fonts.googleapis.com/css?family=' . $font);
	}
	
	/* theme */
	$tp = '../' . tpath() . 'style.php';  
	if(file_exists($tp)){
		include($tp);
	}
	
	
	$data = ob_get_contents(); 
	file_put_contents('style.css', $data);
	ob_end_clean();		
}


include('style.css');