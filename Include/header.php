<?php
$kullaniciid = $_SESSION['KullaniciXssXessio11000001xSs'];
$Sorgu1 = $VeriTabaniBaglantisi->prepare("SELECT * FROM kullanicilar WHERE id = :id");
$Sorgu1->bindParam(":id", $kullaniciid, PDO::PARAM_INT);
$Sorgu1->execute();
$Sorgu1Say = $Sorgu1->rowCount();
if($Sorgu1Say>0){
    $Sorgu2 = $Sorgu1->fetchAll(PDO::FETCH_OBJ);
    foreach ($Sorgu2 as $Veriler){
        $Ad             = $Veriler->Ad;
        $Soyad          = $Veriler->Soyad;
        $EPosta         = $Veriler->EPosta;
        $KayitTarihi    = $Veriler->KayitTarihi;
        $KayitSaati     = $Veriler->KayitSaati;
    }
}
?>