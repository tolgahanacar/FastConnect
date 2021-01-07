<?php
session_start();
require_once 'Ayarlar/baglan.php';
require_once 'Fonksiyonlar/fonksiyonlar.php';
?>

<!DOCTYPE html>
<html lang="tr-TR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="Content-Language" content="tr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="Robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <title>Document</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="Assets/js/main.js" language="JavaScript"></script>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<div>
    <form method="post">
        <div>
            <label for="Ad">Adınız</label><br>
            <input type="text" name="ad" id="ad" placeholder="Adınız" required>
        </div>
        <div>
            <label for="Soyad">Soyadınız</label><br>
            <input type="text" name="soyad" id="soyad" placeholder="Soyadınız" required>
        </div>
        <div>
            <label for="E-Posta">E-Posta Adresiniz</label><br>
            <input type="email" name="eposta" id="eposta" placeholder="E-Posta Adresiniz" required>
        </div>
        <div id="sifreler">
            <label for="Şifre">Şifreniz</label><br>
            <input type="password" name="sifre" id="sifre" placeholder="Şifreniz" minlength="8" required>
        </div>
		<div id="ekstrasifre">
			<small>* En az 1 büyük harf </small><br>
			<small>* En az 8 karakter </small>
		</div>
        <div id="sifrelertekrar">
            <label for="Şifre Tekrar">Şifreniz Tekrar</label><br>
            <input type="password" name="sifretekrar" id="sifretekrar" placeholder="Şifreniz Tekrar" minlength="8" required>
        </div>
        <div>
            <input type="checkbox" name="sozlesme" id="sozlesme" required><a href="uyelik-sozlesmesi.php">Üyelik Sözleşmesi</a>'ni okudum ve kabul ediyorum.
        </div>
        <input type="submit" value="Kayıt" name="kayit">
    </form>
</div>
<?php
if (isset($_POST['kayit'])){
    if(!isset($_POST['sozlesme'])){
        echo "Üyelik Sözleşmesini işaretlediğinizden emin olun!";
        die();
    }
    $ad             = Guvenlik(ucwords(strtolower($_POST['ad'])));
    $soyad          = Guvenlik(ucwords(strtolower($_POST['soyad'])));
    $eposta         = Guvenlik($_POST['eposta']);
    $sifre          = Guvenlik($_POST['sifre']);
    $sifretekrar    = Guvenlik($_POST['sifretekrar']);
    $kontrol        = "/\S*((?=\S{8,})(?=\S*[A-Z]))\S*/";

    if (empty($ad) || empty($soyad) || empty($eposta) || empty($sifre) || empty($sifretekrar)) {
        echo "Lütfen boş alan bırakmayınız!";
        die();
    }

    if (is_numeric($ad) || is_numeric($soyad)) {
        echo "Ad veya Soyad sayısal değer içeremez!";
        die();
    }

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        echo "Girmiş olduğunuz E-Posta, E-Posta kriterlerine uymamaktadır!";
        die();
    }

    $Sorgu = $VeriTabaniBaglantisi->prepare("SELECT * FROM kullanicilar WHERE EPosta = :eposta");
    $Sorgu->bindParam(":eposta", $eposta, PDO::PARAM_STR);
    $Sorgu->execute();
    $Sorgusay = $Sorgu->rowCount();
    if($Sorgusay>0){
        echo "Sisteme kayıtlı böyle bir e-posta adresi var!";
        die();
    }

    if(!preg_match($kontrol,$sifre)){
        echo "Lütfen şifrenizi 1 büyük harf ve en az 8 karakter olacak şekilde tekrardan giriniz!";
        die();
    }

    if(strlen($sifre)<8){
        echo "Şifreniz 8 karakterden küçük olamaz!";
        die();
    }


    $sifreyolu = "Include/sifreler.php";
    if(file_exists($sifreyolu)){
        include 'Include/sifreler.php';
        if(in_array($sifre, $sifreler)){
            echo "Bu şifre kullanılamaz!";
            die();
        }
    }

    if ($sifre != $sifretekrar) {
        echo "Şifreler uyuşmuyor!";
        die();
    }

    $sifre2 = Sifreleme($sifre);
    $Durum  = 0;

    $ekle = $VeriTabaniBaglantisi->prepare("INSERT INTO kullanicilar (Ad,Soyad,EPosta,Sifre,KayitTarihi,KayitSaati,Durum) VALUES (:ad, :soyad, :eposta, :sifre, :tarih, :saat, :durum)");
    $ekle->bindParam(":ad",     $ad,     PDO::PARAM_STR);
    $ekle->bindParam(":soyad",  $soyad,  PDO::PARAM_STR);
    $ekle->bindParam(":eposta", $eposta, PDO::PARAM_STR);
    $ekle->bindParam(":sifre",  $sifre2, PDO::PARAM_STR);
    $ekle->bindParam(":tarih",  $Tarih,  PDO::PARAM_STR);
    $ekle->bindParam(":saat",   $Saat,   PDO::PARAM_STR);
    $ekle->bindParam(":durum",  $Durum,  PDO::PARAM_INT);
    $ekle->execute();
    if ($VeriTabaniBaglantisi->lastInsertId()) {
        echo "Kayıt işlemi başarılı";
        header("refresh:1;url=giris.php");
    } else {
        echo "Kayıt işlemi başarısız! Lütfen tekrar deneyiniz.";
    }
}
?>
</body>
</html>


