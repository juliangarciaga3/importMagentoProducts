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

if(isset($_POST["url_csv"])){
	$nombre_archivo_csv = $_POST['url_csv'];

	$time_start=time();

	#ARGYOR
	if(isset($_REQUEST['argyor'])){
		$argyor=new Argyor();
		$argyor->sync('http://eu.grupoqz.net/~qztesteu/Libro1.csv');
	}

	$time_end=time();
	$time=round(($time_end-$time_start)/60);
	echo "<hr>Duración del proceso: {$time} minutos";
}else{
	echo '<form action="http://eu.grupoqz.net/~qztesteu/Magento_Pruebas/qz/sync_module/init.php?Qz&argyor" method="post">
	 <p>Introduzca la url del archivo: <input type="text" name="url_csv" /></p>
	 <p><input type="submit" /></p>
	</form>';
}