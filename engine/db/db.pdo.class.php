<?php
class PDODB { 
    
    private static $objInstance; 
    
    /* 
     * Class Constructor - Create a new database connection if one doesn't exist 
     * Set to private so no-one can create a new instance via ' = new DB();' 
     */ 
    private function __construct() {} 
    
    /* 
     * Like the constructor, we make __clone private so nobody can clone the instance 
     */ 
    private function __clone() {} 
    
    /* 
     * Returns DB instance or create initial connection 
     * @param 
     * @return $objInstance; 
     */ 
    public static function getInstance(  ) { 
            
        if(!self::$objInstance){ 
            self::$objInstance = new PDO(HOST_DRIVER, HOST_NAME, HOST_PASS); 
            self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } 
        
        return self::$objInstance; 
    
    } # end method 
    
    /* 
     * Passes on any static calls to this class onto the singleton PDO instance 
     * @param $chrMethod, $arrArguments 
     * @return $mix 
     */ 
    final public static function __callStatic( $chrMethod, $arrArguments ) { 
            
        $objInstance = self::getInstance(); 
        
        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments); 
        
    } # end method 
    
} 


function DBquery($sql, $echo = true)
{	
	//$echo = 1; echo $sql;
	$res = null;
	try {
		$res = PDODB::query($sql);
	} catch (Exception $e) { 
			print_r($e->getMessage());//print_r($e->getTrace());
			echo $sql . "<br>";
			echo PDODB::errorInfo();			
			echo "<pre>";
			print_r(debug_backtrace());

		die();	
	}
	return $res;	
}


function DBcell($sql, $echo = false) {
	return DBquery($sql, $echo)->fetchColumn();		
}


function DBrow($sql, $echo = false) {
	return DBquery($sql, $echo)->fetch();		
}

function DBcol($sql, $echo = false) {
	$arr = array();
	$res = DBquery($sql, $echo)->fetchAll();
	foreach($res as $row){
		$arr[] = $row[0];
	}
	return $arr;
}

function DBall($sql, $echo = false) {
	return DBquery($sql, $echo)->fetchAll();	
}

function DBinsertId(){
	return PDODB::lastInsertId();
}

function dbquote($val) {
	return PDODB::quote($val);
}
