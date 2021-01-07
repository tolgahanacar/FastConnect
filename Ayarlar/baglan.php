<?php
ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL);
try{
    $VeriTabaniBaglantisi = new PDO("mysql:host=localhost;dbname=fastconnect;charset=UTF8","tolga","123456");
    $VeriTabaniBaglantisi->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}catch(PDOException $HataAciklamasi){
    echo "Hata Açıklaması :"." ".$HataAciklamasi->getMessage();
    die();
}
?>