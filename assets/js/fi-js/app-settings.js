$(document).on("submit","form",(function(a){var e=new FormData(this);$.ajax({url:"./resimupload.fi",data:e,contentType:!1,processData:!1,type:"POST",success:function(a){$("#modeldiv").html(a)}})})),$(document).ready((function(){$("#eo").on("click",(function(){$(".form-control").removeAttr("readonly")})),$("#update").on("click",(function(){var a="company="+$("#company").val()+"&name="+$("#name").val()+"&surname="+$("#surname").val()+"&tel="+$("#tel").val()+"&tel2="+$("#tel2").val()+"&mail="+$("#mail").val()+"&adres="+$("#adres").val();$.ajax({url:"update.fi",type:"POST",data:a,success:function(a){$("div#modeldiv").html("").html(a)}})}))}));