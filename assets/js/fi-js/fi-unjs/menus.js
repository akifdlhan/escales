 $(document).ready(function(){
                            $("#menus-full").DataTable({
                                order: [[1, 'asc']],
                                "lengthMenu": [10,15,20,50,100]   
                            });
                            $("#title").keyup(function() {
                                var str = $(this).val();
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
                                    str = slugify(str);
                                $("#url").val(str);  
                                });
                                
                                $("#submit-page").on("click",function(){                 
                                    var yetkiGrubuValues = $("#YetkiGrubu:checked").map(function() {
                                        return $(this).val();
                                    }).get();
                                    var yetkiGrubuString = yetkiGrubuValues.join(',');
                                    page="islem=1&"+"parent="+$("#parent").val()+"&title="+$("#title").val()+"&position="+$("#position").val()+"&url="+$("#url").val()+"&icon="+$("#icon").val()+"&access="+yetkiGrubuString;
                                    $.ajax({
                                        url:'../settings/menu-process.fi', 
                                        type:'POST', 
                                        data:page,
                                        success:function(e){ 
                                           $("div#son").html("").html(e);
                                        }
                                    });
                            });
                                
                           });

                           $(".duzenleme").on("click", function(){
	                            var menuinfo = 'MenuID='+$(this).find('i.EditID').attr('id');
                                $.ajax({
                                    url:'../settings/access-process.fi', 
                                    type:'POST', 
                                    data:menuinfo,
                                    success:function(e){ 
                                       $("div#AccessEdit").html("").html(e);
                                    }
                                });
                            });
