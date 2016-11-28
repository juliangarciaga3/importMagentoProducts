<?php

if(!isset($_REQUEST['qz'])) exit;

include_once "../app/Mage.php";
umask(0);
Mage::app();

try{
    $process = Mage::getModel('index/indexer')->getProcessByCode('catalog_product_price');
    $process->reindexAll();
    echo 'success';
} catch (Exception $e){
    echo 'fail';
}

exit;