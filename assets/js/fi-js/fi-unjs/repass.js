$(document).ready(function(){
                $("#resetis").on("click",function(){ 
                    var user = $("#user").val();                
                    var oldpass = $("#oldpass").val();                
                    var npass = $("#npass").val();                
                    var npasst = $("#npass2").val();
                    if(npass == npasst){
                        passinfo="islem=1&"+
                                    "user="+user+
                                    "&oldpass="+oldpass+
                                    "&npass="+npass+
                                    "&npasst="+npasst;
                        $.ajax({
                            url:'../settings/repass-process.fi', 
                            type:'POST', 
                            data:passinfo,
                            success:function(e){ 
                                $("div#son").html("").html(e);
                            }
                        });
                    }else{
                        Swal.fire({ title: "Hata!", text: "Girilen şifreler uyuşmuyor!", icon: "error" });
                    }    
                       
                    });
                });