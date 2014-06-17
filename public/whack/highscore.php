<?php

//save the list to a file
function save($list, $file) {
    //open the file for writing
    $write = fopen($file, 'w');
    //turn the array into a string
    $string = implode("\n", $list);
    // write the string onto the file
    fwrite($write, $string . "\n");
    //close the file
    fclose($write);
}

// open in a file
function open_file($file = 'whack.txt') {
    $list = [];
    if (is_readable($file) && filesize($file) > 0) {
        
        $filesize = filesize($file);
        //open file to read
        $read = fopen($file, 'r');
        //read file into string
        $list_string = trim(fread($read, $filesize));
        //turn string into array
        $list = explode("\n", $list_string);
        //close the file
        fclose($read);
    }
    //dump the array
    return $list;
}

function php_to_js($value) {
	return json_encode($value);
}

function js_to_php($value) {
	return json_decode($value);
}

// $score = open_file();

// $js = php_to_js([$score]);
// echo $js . PHP_EOL;

// $php = js_to_php($js);
// foreach ($php as $value) {
// 	echo $value . PHP_EOL;
// }

?>