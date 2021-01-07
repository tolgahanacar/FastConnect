$(document).ready(function(){
    $("#ekstrasifre").hide();
    $("#sifreler").click(function (){
       $("#ekstrasifre").show(500);
       $("#sifrelertekrar").click(function (){
          $("#ekstrasifre").hide(500);
       });
    });
});