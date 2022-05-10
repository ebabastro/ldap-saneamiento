<?php
function generarCsv($data, $path, $delimitador, $encapsulador){
    $file_handle = fopen($path, 'w');
    foreach ($data as $line) {
        fputcsv($file_handle, $line, $delimitador, $encapsulador);
    }
    rewind($file_handle);
    fclose($file_handle);
}

?>