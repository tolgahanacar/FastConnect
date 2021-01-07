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
    <script type="text/javascript" src="script.js" language="JavaScript"></script>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<div>
    <form method="post">
        <div>
            <label for="E-Posta Adresiniz">E-Posta Adresiniz</label><br>
            <input type="email" name="eposta" id="eposta">
        </div>
        <div>
            <label for="Şifreniz">Şifreniz</label><br>
            <input type="password" name="sifre" id="sifre">
        </div>
        <input type="submit" value="Giriş" name="giris">
    </form>
</div>
<?php
if (isset($_POST['giris'])) {
    $eposta = Guvenlik($_POST['eposta']);
    $sifre  = Guvenlik($_POST['sifre']);

    if (empty($eposta) || empty($sifre)) {
        echo "Lütfen boş alan bırakmayınız!";
        die();
    }

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        echo "Girmiş olduğunuz E-Posta, E-Posta kriterlerine uymamaktadır!";
        die();
    }

    $Sifre2 = Sifreleme($sifre);
    $Durum  = 1;

    $Sorgu = $VeriTabaniBaglantisi->prepare("SELECT * FROM kullanicilar WHERE EPosta = :eposta AND Sifre = :sifre AND Durum = :durum");
    $Sorgu->bindParam(":eposta", $eposta, PDO::PARAM_STR);
    $Sorgu->bindParam(":sifre", $Sifre2, PDO::PARAM_STR);
    $Sorgu->bindParam(":durum", $Durum, PDO::PARAM_INT);
    $Sorgu->execute();
    $Say = $Sorgu->rowCount();
    $Sorgu2 = $Sorgu->fetchAll(PDO::FETCH_OBJ);
    foreach ($Sorgu2 as $item) {
        $id = $item->id;
    }
    if ($Say > 0) {
        echo "Giriş işlemi başarılı, Ana Sayfaya yönlendiriliyorsunuz";
        $_SESSION['KullaniciXssXessio11000001xSs'] = $id;
        header("refresh:1;url=index.php");
    } else {
        echo "E-Posta adresiniz veya şifreniz yanlış! Lütfen tekrar deneyiniz.";
        die();
    }
}
?>
</body>
</html>
