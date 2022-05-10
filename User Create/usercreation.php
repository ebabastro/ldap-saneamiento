<?php
require_once "obtenerCSV.php";
require_once "generarCSV.php";
require_once "username_generator.php";

//Path de los nuevos ingresos
$nuevoIngresoPath = "../estudiantes.csv";
//Path de los usuarios ya existentes
$oldUserPath = "../UltimoReport.csv";

//Datos obtenidos de los archivos csv
//!Se deben ignorar el primero(cabecera) y el ultimo(vacio) registro
$nuevoIngresoData = getData1($nuevoIngresoPath);

$sizeNuevoIngreso = sizeof($nuevoIngresoData); //Size del arreglo obtenido

$oldUserData = getData($oldUserPath);
$sizeOldUser = sizeof($oldUserData); //Size del arreglo obtenido
$oldUsernames = []; // Arrayu de los usernames ya existentes
//TODO Obteniendo los usernames de los usuarios ya existentes
for ($i=1; $i < $sizeOldUser-1; $i++) { 
    $oldUsernames[$i] = $oldUserData[$i][1];
}

//Array con las nuevos usernames
$newUsernames = [];
//Array para guardar la informacion con los nuevos usuarios, incluye username
$newUsers = [];

for ($i=1; $i < $sizeNuevoIngreso-1; $i++) { 
    
    $option1 = generator_1($nuevoIngresoData[$i][1],$nuevoIngresoData[$i][2],$nuevoIngresoData[$i][3]);
    $option2 = generator_2($nuevoIngresoData[$i][1],$nuevoIngresoData[$i][2]);
    $option3 = generator_3($nuevoIngresoData[$i][1],$nuevoIngresoData[$i][3]);
    
    if (!in_array($option1, $oldUsernames) && !in_array($option1, $newUsernames)) {
        $newUsernames[] = $option1;
        $nuevoIngresoData[$i][] = $option1;
    }
    elseif (!in_array($option2, $oldUsernames) && !in_array($option2, $newUsernames)) {
        $newUsernames[] = $option2;
        $nuevoIngresoData[$i][] = $option2;
    }
    elseif (!in_array($option3, $oldUsernames) && !in_array($option3, $newUsernames)) {
        $newUsernames[] = $option3;
        $nuevoIngresoData[$i][] = $option3;
    }
    else {
        echo "No se pudo crear el username con ninguno de los metodos \n";
    }

}
$newUsers = $nuevoIngresoData;
var_dump($newUsers);

$path = "./newUsersData.csv";
generarCsv($newUsers, $path, ',',' ');

?>