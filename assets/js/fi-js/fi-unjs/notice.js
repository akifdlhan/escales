 $(document).ready(function(){
                            $("#notice-save").on("click",function(){                 
                            notice="islem=1&"+"user="+$("#notice-user").val()+"&title="+$("#title").val()+"&desc="+$("#notice-desc").val();
                                    $.ajax({
                                        url:'../settings/notice-process.fi', 
                                        type:'POST', 
                                        data:notice,
                                        success:function(e){ 
                                            $("div#son").html("").html(e);
                                        }
                                    });
                            });
                            $("#notice-active").on("click",function(){
                                
                                notice="islem=2&"+"active="+$("#notice-active").is(':checked');

                                $.ajax({
                                        url:'../settings/notice-process.fi', 
                                        type:'POST', 
                                        data:notice,
                                        success:function(e){ 
                                            $("div#son").html("").html(e);
                                        }
                                    });
                            });
                           });