<?php
// ini_set('memory_limit','2G');
set_time_limit(3000);
require_once './connect.php';
$umbral = 85;

$sql_estudiantes    = "SELECT estudiantes.ci as ci,
                        CONCAT(estudiantes.name, ' ', estudiantes.last_name_1, ' ', estudiantes.last_name_2) as full_name
                        FROM estudiantes
                        WHERE estudiantes.estado_id = 2";

$sql_trabajadores   = "SELECT trabajadors.ci as ci,
                        CONCAT(trabajadors.name, ' ', trabajadors.last_name_1, ' ', trabajadors.last_name_2) as full_name
                        FROM trabajadors
                        WHERE trabajadors.baja = '0'";

$estudiantes = mysqli_query($connection, $sql_estudiantes);
$trabajadores = mysqli_query($connection, $sql_trabajadores);

$dataFile = getData('UltimoReport.csv');
$count = 0;

$allData = [];
$coincidencias = [];

while ($consulta = mysqli_fetch_array($estudiantes)) {

    foreach ($dataFile as $data) {
        // $count++;                         
        $data[2] = sanearString($data[2]);
        $consulta['full_name'] = sanearString($consulta['full_name']);
        similar_text(strtoupper($data[2]), strtoupper($consulta['full_name']), $pct);
        
        if ($pct > $umbral) {
            $count++;
            $coincidencias[$count] = ['estudiante', $pct, $data[2], $data[1]];
        }
    }
    $allData[$consulta['full_name']] = $coincidencias;
    unset($coincidencias);
    $count = 0;
}

while ($consulta = mysqli_fetch_array($trabajadores)) {

    foreach ($dataFile as $data) {
        // $count++;                         
        $data[2] = sanearString($data[2]);
        $consulta['full_name'] = sanearString($consulta['full_name']);
        similar_text(strtoupper($data[2]), strtoupper($consulta['full_name']), $pct);
        
        if ($pct > $umbral) {
            $count++;
            $coincidencias[$count] = ['trabajador', $pct, $data[2], $data[1]];
        }
    }
    $allData[$consulta['full_name']] = $coincidencias;
    unset($coincidencias);
    $count = 0;
}

$json = json_encode($allData);
$bytes = file_put_contents('newAllData.json', $json);

require_once './close_cnx.php';

function tratamiento($data_bdunica, $data_ldap)
{
    $data_bdunica = strtoupper($data_bdunica);
    $data_ldap = strtoupper($data_ldap);

    $data_bdunica = sanearString($data_bdunica);
    $data_ldap = sanearString($data_ldap);
}

function sanearString($cadena)
{

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
        $cadena
    );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena
    );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena
    );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena
    );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    $cadena = str_replace(
        array(' ', '  ', '   '),
        array('', '', ''),
        $cadena
    );

    $cadena = strtoupper($cadena);

    return $cadena;
}

function getData($file_address)
{

    $file = $file_address;

    $openfile = fopen($file, 'r');

    while (!feof($openfile)) {
        $data[] = fgetcsv($openfile, 0, ',', ' ');
    }

    return $data;
}
