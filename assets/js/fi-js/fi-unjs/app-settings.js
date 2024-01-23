                      $(document).on("submit", "form", function(e) {
                          var $data = new FormData(this);
                          $.ajax({
                              url: "./resimupload.fi",
                              data: $data,
                              contentType: false,
                              processData: false,
                              type: "POST",
                              success: function(xhr) {
                                  $("#modeldiv").html(xhr);
                              }
                          });
                      });

                      $(document).ready(function() {
                          $("#eo").on("click", function() {
                              $('.form-control').removeAttr('readonly');
                          });
                          $("#update").on("click", function() {
                              var appdata = "company=" + $("#company").val() + "&name=" + $("#name").val() + "&surname=" + $("#surname").val() + "&tel=" + $("#tel").val() + "&tel2=" + $("#tel2").val() + "&mail=" + $("#mail").val() + "&adres=" + $("#adres").val();
                              $.ajax({
                                  url: "update.fi",
                                  type: "POST",
                                  data: appdata,
                                  success: function(a) {
                                      $("div#modeldiv").html("").html(a)
                                  }
                              });
                          });
                      });