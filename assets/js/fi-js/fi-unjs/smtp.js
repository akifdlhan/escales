 $("#testgonder").on("click",function(){
                                    var testmail = 'testmail='+$("#testmail").val();                                    
                                    $.ajax({
                                        url:'../settings/smtp-action.fi', 
                                        type:'POST', 
                                        data:testmail,
                                        success:function(e){ 
                                           $("div#son").html("").html(e);
                                        }
                                    });
                                    
                            });