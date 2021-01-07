<?php
setlocale(LC_TIME, 'tr_TR.UTF-8');
date_default_timezone_set('Europe/Istanbul');
/*echo strftime('%e %B %Y %A %H:%M:%S');*/

function RakamlarHaricTumKarakterleriSil($Deger){
    $Islem = preg_replace("/[^0-9]/","",$Deger);
    $Sonuc = $Islem;
    return $Sonuc;
}

function TumBosluklariSil($Deger){
    $Islem = preg_replace("/\s|&nbsp;/","",$Deger);
    $Sonuc = $Islem;
    return $Sonuc;
}

function DonusumleriGeriDondur($Deger){
    $GeriDondur     = htmlspecialchars_decode($Deger, ENT_QUOTES);
    $Sonuc          = $GeriDondur;
    return $Sonuc;
}

function Guvenlik($Deger){
    $BoslukSil      = trim($Deger);
    $TaglariTemizle = strip_tags($BoslukSil);
    $EtkisizYap     = htmlspecialchars($TaglariTemizle,  ENT_QUOTES);
    $Sonuc          = $EtkisizYap;
    return $Sonuc;
}

function SayiliIcerikleriFiltrele($Deger){
    $BoslukSil      = trim($Deger);
    $TaglariTemizle = strip_tags($BoslukSil);
    $EtkisizYap     = htmlspecialchars($TaglariTemizle);
    $Temizle        = RakamlarHaricTumKarakterleriSil($EtkisizYap,  ENT_QUOTES);
    $Sonuc          = $Temizle;
    return $Sonuc;

}

function Sifreleme($Deger){
    $MD5sifrele     = md5($Deger);
    $SHA1sifrele    = sha1($MD5sifrele);
    $Sonuc          = $SHA1sifrele;
    return $Sonuc;
}

function IBANBicimlendir($Deger){
    $BoslukSil 		= trim($Deger);
    $TumBoslukSil 	= TumBosluklariSil($Deger);
    $BirinciBlok  	= substr($TumBoslukSil, 0, 4);
    $IkinciBlok  	= substr($TumBoslukSil, 4, 4);
    $UcuncuBlok  	= substr($TumBoslukSil, 8, 4);
    $DorduncuBlok  	= substr($TumBoslukSil, 12, 4);
    $BesinciBlok  	= substr($TumBoslukSil, 16, 4);
    $AltinciBlok  	= substr($TumBoslukSil, 20, 4);
    $YedinciBlok  	= substr($TumBoslukSil, 24, 2);
    $Duzenle      	= $BirinciBlok." ".$IkinciBlok." ".$UcuncuBlok." ".$DorduncuBlok." ".$BesinciBlok." ".$AltinciBlok." ".$YedinciBlok;
    $Sonuc = $Duzenle;
    return $Sonuc;

}

function TelefonBicimlendir($Deger){
    $BoslukSil 		= trim($Deger);
    $TumBoslukSil 	= TumBosluklariSil($Deger);
    $BirinciBlok  	= substr($TumBoslukSil, 0, 3);
    $IkinciBlok  	= substr($TumBoslukSil, 3, 3);
    $UcuncuBlok  	= substr($TumBoslukSil, 6, 2);
    $DorduncuBlok   = substr($TumBoslukSil, 8, 2);
    $Duzenle      	= $BirinciBlok." ".$IkinciBlok." ".$UcuncuBlok." ".$DorduncuBlok;
    $Sonuc = $Duzenle;
    return $Sonuc;
}

function seflink($text){
    $find = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
    $degis = array("G","U","S","I","O","C","g","u","s","i","o","c");
    $text = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$text);
    $text = preg_replace($find,$degis,$text);
    $text = preg_replace("/ +/"," ",$text);
    $text = preg_replace("/ /","-",$text);
    $text = preg_replace("/\s/","",$text);
    $text = strtolower($text);
    $text = preg_replace("/^-/","",$text);
    $text = preg_replace("/-$/","",$text);
    return $text;
}


function TarayiciTuru() {
    $tarayicibul=$_SERVER['HTTP_USER_AGENT'];
    if(stristr($tarayicibul,"MSIE")) { $tarayici="Internet Explorer"; }
    if(stristr($tarayicibul,"Trident")) { $tarayici="Internet Explorer"; }
    elseif(stristr($tarayicibul,"Opera")) { $tarayici="Opera"; }
    elseif(stristr($tarayicibul,"OPR"))   { $tarayici="Opera"; }
    elseif(stristr($tarayicibul,"Firefox")) { $tarayici="Mozilla Firefox"; }
    elseif(stristr($tarayicibul,"YaBrowser")) { $tarayici="Yandex Browser"; }
    elseif(stristr($tarayicibul,"Chrome")) { $tarayici="Google Chrome"; }
    elseif(stristr($tarayicibul,"Safari")) { $tarayici="Safari"; }
    elseif(stristr($tarayicibul,"Edg")) { $tarayici="Microsoft Edge"; }
    else {$tarayici="Tarayıcı Bulunamadı!";}
    return $tarayici;
}


function IsletimSistemi() {
    $tespit=$_SERVER['HTTP_USER_AGENT'];
    if(stristr($tespit,"Windows 95")) { $islemsistemi="Windows 95"; }
    elseif(stristr($tespit,"Windows 98")) { $islemsistemi="Windows 98"; }
    elseif(stristr($tespit,"Windows NT 5.0")) { $islemsistemi="Windows 2000"; }
    elseif(stristr($tespit,"Windows NT 5.1")) { $islemsistemi="Windows XP"; }
    elseif(stristr($tespit,"Windows NT 6.0")) { $islemsistemi="Windows Vista"; }
    elseif(stristr($tespit,"Windows NT 6.1")) { $islemsistemi="Windows 7"; }
    elseif(stristr($tespit,"Windows NT 6.2")) { $islemsistemi="Windows 8"; }
    elseif(stristr($tespit,"Windows NT 6.3")) { $islemsistemi="Windows 8.1"; }
    elseif(stristr($tespit,"Windows NT 10.0")) { $islemsistemi="Windows 10"; }
    elseif(stristr($tespit,"Mac")) { $islemsistemi="Mac"; }
    elseif(stristr($tespit,"Linux")) { $islemsistemi="Linux"; }
    else {$islemsistemi="İşletim Sistemi Bilinmiyor!";}
    return $islemsistemi;
}

function TarayiciDili(){
    $denetledil = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    if(stristr($denetledil,"tr-TR")) {$tarayicidili = "Türkçe";}
    elseif(stristr($denetledil,"en")) {$tarayicidili="İngilizce";}
    elseif(stristr($denetledil,"en-EN")) {$tarayicidili="İngilizce";}
    elseif(stristr($denetledil,"en-US")) {$tarayicidili="Amerikan İngilizcesi";}
    elseif(stristr($denetledil,"en-CA")) {$tarayicidili="Kanada İngilizcesi";}
    elseif(stristr($denetledil,"en-IN")) {$tarayicidili="Hindistan İngilizcesi";}
    elseif(stristr($denetledil,"en-NZ")) {$tarayicidili="Yeni Zelanda İngilizcesi";}
    elseif(stristr($denetledil,"en-AU")) {$tarayicidili="Avusturalya İngilizcesi";}
    elseif(stristr($denetledil,"az-AZ")) {$tarayicidili="Azerice";}
    else{$tarayicidili="Tarayıcı Dili Bilinmiyor!";}
    return $tarayicidili;
}

$ipadresi           =     $_SERVER['REMOTE_ADDR'];
$uzakhost           =     gethostbyaddr($_SERVER['REMOTE_ADDR']);
$sunucuprotokolu    =     $_SERVER['SERVER_PROTOCOL'];
@$karakterseti      =     $_SERVER['HTTP_ACCEPT_CHARSET'];
$istekturu          =     $_SERVER['REQUEST_METHOD'];
$tarayicidili       =     TarayiciDili();
$isletimsistemi     =     IsletimSistemi();
@$gercekip          =     $_SERVER['HTTP_X_FORWARDED_FOR'];
@$cerezler          =     $_SERVER['HTTP_COOKIE'];
$uzakport           =     $_SERVER['REMOTE_PORT'];
$sikistirmaistegi   =     $_SERVER['HTTP_ACCEPT_ENCODING'];
$tarayicituru       =     TarayiciTuru();
$Tarih              =     date('d.m.Y');
$Saat               =     date('H:i:s');
?>