<?php

function js_log($obj){
    echo "<script>window.js_var=JSON.parse('".addslashes(Mage::helper('core')->jsonEncode($obj))."');console.log(window.js_var)</script>";
}

function getLang(){
    $codes_lang=array(
        'default' => 'en',
        'spanish' => 'es'
    );
    return $codes_lang[Mage::app()->getStore()->getCode()];
}

function isLang($lang){
    return getLang()==$lang;
}

function lang($args){
    return $args[getLang()];
}

function getCustomBlock($number){
    return Mage::getBaseDir().'/app/design/frontend/neighborhood/default/template/catalog/product/multiproduct/multi-block/'.$number.'.phtml';
}