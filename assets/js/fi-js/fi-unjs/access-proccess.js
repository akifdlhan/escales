                            $("#YetkiDuzenleButon").on("click", function(){
                              var yetkiGrubuValues = $("#YetkiGrubu:checked").map(function() {
                                        return $(this).val();
                                    }).get();
                                    var yetkiGrubuString = yetkiGrubuValues.join(',');
	                            var accessinfo = 'Toggle='+$("#AltMenuSw").is(':checked')+'&MenuID='+$("#MenuID").val()+"&access="+yetkiGrubuString;
                                $.ajax({
                                    url:'../settings/access-last-process.fi', 
                                    type:'POST', 
                                    data:accessinfo,
                                    success:function(e){ 
                                       $("div#AccessEdit").html("").html(e);
                                    }
                                });
                            });