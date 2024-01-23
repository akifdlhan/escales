    $(document).ready(function(){
                            
                            $("#sifre-tekrar").keyup(function() {
                                var sifretekrar = $("#sifre-tekrar").val();
                                var sifre = $("#sifre").val();
                                if(sifre == sifretekrar){
                                    $("#passcontrol").css({"color":"green","font-weight": "200"});
                                    $("small#passcontrol").html("").html("Şifreler uyuşuyor.");
                                    $("#kullanici-olustur").prop("disabled", false);
                                }else{
                                    $("#passcontrol").css({"color":"red","font-weight": "bold"});
                                    $("small#passcontrol").html("").html("Şifreler uyuşmuyor.");
                                    $("#kullanici-olustur").prop("disabled", true);
                                }
                            
                            });

                            $("#yetki-id").change(function() {
                                var yetki = $("#yetki-id").val();
                                if(yetki == 100){
                                    $("#yetkikontrol").css({"color":"red","font-weight": "bold"});
                                    $("small#yetkikontrol").html("").html("Yetki Grubu Seçiniz..");
                                    $("#kullanici-olustur").prop("disabled", true);
                                }else{
                                    $("#yetkikontrol").css({"color":"green","font-weight": "200"});
                                    $("small#yetkikontrol").html("").html("");
                                    $("#kullanici-olustur").prop("disabled", false);
                                }
                            });

                            $("#soyadi").keyup(function() {
                                var adi = $("#adi").val();
                                var soyadi = $(this).val();
                                slugify = function(text) {
                                        var trMap = {
                                            'çÇ':'c',
                                            'ğĞ':'g',
                                            'şŞ':'s',
                                            'üÜ':'u',
                                            'ıİ':'i',
                                            'öÖ':'o'
                                        };
                                        for(var key in trMap) {
                                            text = text.replace(new RegExp('['+key+']','g'), trMap[key]);
                                        }
                                        return  text.replace(/[^-a-zA-Z0-9\s]+/ig, '') // remove non-alphanumeric chars
                                                    .replace(/\s/gi, "-") // convert spaces to dashes
                                                    .replace(/[-]+/gi, "-") // trim repeated dashes
                                                    .toLowerCase();

                                    }
                                    soyadi = slugify(soyadi);
                                    adi = slugify(adi);
                                    if(adi == ""){
                                        adi = soyadi;
                                    }else{
                                        adi = adi;
                                    }
                                $("#username-view").val(adi+"."+soyadi);  
                                $("#username-data").val(adi+"."+soyadi);  
                                });
                                
                                
                                $("#kullanici-olustur").on("click",function(){
                                    var username = $("#username-data").val();
                                    var sifre = $("#sifre").val();
                                    var adi = $("#adi").val();
                                    var soyadi = $("#soyadi").val();
                                    var telefon = $("#telefon").val();
                                    var mail = $("#mail").val();
                                    var adres = $("#adres").val();
                                    var yetki = $("#yetki-id").val();

                                    if(adi == "" || sifre == "" || soyadi == "" || telefon == "" || mail == "" || adres == "" ){
                                        toastr["error"]("Boş alanlar mevcut lütfen kontrol ediniz.");
                                    }else{

                                        userinfo="islem=1&"+
                                    "username="+username+
                                    "&sifre="+sifre+
                                    "&adi="+adi+
                                    "&soyadi="+soyadi+
                                    "&telefon="+telefon+
                                    "&mail="+mail+
                                    "&adres="+adres+
                                    "&yetki="+yetki;
                                    
                                    $.ajax({
                                        url:'../settings/users-process.fi', 
                                        type:'POST', 
                                        data:userinfo,
                                        success:function(e){ 
                                           $("div#son").html("").html(e);
                                        }
                                    });
                                    
                                        
                                    }
                            });
                                
                           });