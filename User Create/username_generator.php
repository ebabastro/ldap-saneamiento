<?php
function generator_1($name, $last_name_1, $last_name_2){
    $username = $name.$last_name_1[0].$last_name_2[0];
    $username = sanearString($username);
    return $username;
}
function generator_2($name, $last_name_1){
    $username = $name[0].$last_name_1;
    $username = sanearString($username);
    return $username;
}
function generator_3($name, $last_name_2){
    $username = $name[0].$last_name_2;
    $username = sanearString($username);
    return $username;
}

function sanearString($cadena){

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    // $cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    $cadena = str_replace(
        array(' ','  ','   '),
        array('','',''),
        $cadena
    );

    $cadena = strtolower($cadena);
    return $cadena;
}

?>