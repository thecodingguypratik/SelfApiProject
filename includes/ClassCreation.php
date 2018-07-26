<?php

class ClassCreation {

	public  function __construct() {
        
    }

    public static function Factory($class_name = null) {
        $class_full_qualified_name = $class_name.'Action';
        $dir_to_include = dirname(__FILE__).'/../classes/'.$class_name.'/'.$class_full_qualified_name.'.php';
        require_once $dir_to_include;
        $class_reflection = new \ReflectionClass($class_full_qualified_name);
        $argList = func_get_args();
        array_shift($argList);
        $class_instance = $class_reflection->newInstanceArgs($argList);
        return $class_instance;
    }

    public static function getRawPostData() {
        $fh = fopen('php://input', 'r');
        $input = stream_get_contents($fh);
        fclose($fh);
        $args = func_get_args();
        if (!empty($args)) {
            $callback = array_shift($args);
            array_unshift($args, $input);
            return call_user_func_array($callback, $args);
        }
        return json_decode($input,true);
    }

}

?>
