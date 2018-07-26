<?php

define('WEBSITE', 'wydr');
define('DIR_ROOT', __DIR__);	
define('START_TIME', microtime(true));


$requestParams = $_REQUEST;
$uri 		= $requestParams['rquest'];
$uri_parts 	= explode('/', $uri);
$status = 200; // initial status to be shown
$message = "";


try{
	// logic for the creation of the class and redirection to the required method
	if(!empty($uri_parts) && $uri_parts[0] == WEBSITE && !empty($uri_parts[1]) && !empty($uri_parts[2]) ){
		$controller 	= ucfirst($uri_parts[1]);
		$method     	= $uri_parts[2];
		$ControllerFile = DIR_ROOT . '/modules/' . $controller . '/' . $controller . '.php';

		if(file_exists($ControllerFile)){
			require_once($ControllerFile);
			if (class_exists($controller)) {
	            $params = array_slice($uri_parts, 2);
	            $classCreated = new \ReflectionClass($controller);
	            $data = $classCreated->getMethod($method)->invokeArgs($classCreated->newInstanceArgs(), $params);
	            $status = 200;
	            	        }
		}else{
			$message = $uri . ':No request handler exists';
        	$status = 404;	
		}
	}else{
        $message = $uri . ':No request handler exists';
        $status = 404;
    }
}catch(Exception $e){
	$message = $e->getMessage();
	$status = $e->getCode();
}

// displaying the output on the screen
$empty = new stdClass(); 
$output = array(
    'response_time' => (microtime(true) - START_TIME),
    'message' => $message,
    'status' => $status,
    'response' => (empty($data)) ? $empty : $data
);
$responseStr = json_encode($output);
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
echo $responseStr;
exit;
?>