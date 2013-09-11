<?php

/**
 * @author Vlad Bartusica
 * The script allows definition of functions to be called from the terminal.
 * A sample call is this one: <calculator.php 3 add_one>
 * Help is also implemented by <calculator.php --help> or some small variations
 * @copyright 2013
 */
    
function add_one($i) {
    return $i++;
}
function multiply_by_five($i) {
    return $i*5;
}
function add_two($i) {
    return $i+2;
}
function sq($i) {
    return $i*$i;
}

if(isset($argv)) {
    
    if(isset($argv[1])&&($argv[1]=='help'||$argv[1]=='--help'||$argv[1]=='-help')) {
        echo 'Possible functions: add_one, multiply_by_five, add_two';
    } elseif(count($argv)>2){
        $calledFuncs = array();
                
        if(intval($argv[1])!=$argv[1]){
            die('Incorrect parameter entered');
        }
        
        $x = $argv[1];
        
        if(count($argv)==3) {
            $fInput = explode(',',$argv[2]);
            foreach($fInput as $key=>$func)
                $calledFuncs[] = strtolower(trim($func));
        } else
            for($i=2;$i<count($argv);$i++) {
                $calledFuncs[] = strtolower(trim($argv[$i]));
            }
        
        $callResults = array();
        $errorMessages = array();        
        
        foreach($calledFuncs as $key=>$func) {
            if(function_exists($func))
                $callResults[] = call_user_func($func,$x);
                else $errorMessages[] = $func;   
        }
               
        $output = implode(' ',$callResults);
        if(!empty($errorMessages))
            $output .= '   --    Incorrect function names: '.implode(' ', $errorMessages);
        
        echo $output;
        
    } else {
        echo 'Incorrect number of parameters';
    }
}