<?php

function getData($path){
        
    $file = $path;

    $openfile = fopen($file, 'r');

    while(!feof($openfile)){
        $data[] = fgetcsv($openfile, 0, ',', ' ');
    }

    return $data;
}
function getData1($path){
        
    $file = $path;

    $openfile = fopen($file, 'r');

    while(!feof($openfile)){
        $data[] = fgetcsv($openfile, 0, ',', '"');
    }

    return $data;
}

?>