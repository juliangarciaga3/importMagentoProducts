<?php


#security
//if(!isset($_REQUEST['qz'])) exit(0);


#include
include_once "kint/Kint.class.php";
include_once "Argyor.class.php";
include_once "../functions.php";
include_once "../../app/Mage.php";

#config
umask(0);
Mage::app();
set_time_limit(9360);
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '1024M');

$nombre_archivo_csv;
$opciones;

if(isset($_GET["url_csv"])){
	$nombre_archivo_csv = $_GET['url_csv'];
	if(isset($_GET['option_file'])){
		foreach($_GET['option_file'] as $selected){
			$opciones.=$selected;
		}
	}
}else{

	$nombre_archivo_csv = 'http://eu.grupoqz.net/~lamparas/subida_family_1.csv';
}

$time_start=time();

#ARGYOR
//if(isset($_REQUEST['argyor'])){
$argyor=new Argyor();
$argyor->sync($nombre_archivo_csv, $opciones);
//}

$time_end=time();
$time=round(($time_end-$time_start)/60);
echo "<hr>Duración del proceso: {$time} minutos";