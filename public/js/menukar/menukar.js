$(document).ready(function(){
  
  $(".header-champ").live("focusin focusout", function(event) {
    if(event.type == "focusin") {
      if(this.value == "Recherche...") {
        this.value = "";
      }
      $(this).addClass('selected');
    } else {
      if(this.value == "") {
        this.value = "Recherche...";
        $(this).removeClass('selected');
      }
    }
  });
  
  $(".header-submit").live("click", function() {
    var research = $('.header-champ').attr('value');
    $.ajax({ 
      url: "/index/search",
      data: "search=" + research + "&type=null",
      success: function(msg) {
        $(".bloc-ajax").html(msg);
      }
    });
  });
  
  $(".header-champ").live("keypress", function(e) {
    if(e.keyCode == 13) {
      var research = $('.header-champ').attr('value');
      $.ajax({ 
        url: "/index/search",
        data: "search=" + research + "&type=null",
        success: function(msg) {
          $(".bloc-ajax").html(msg);
        },
        error: function(msg) {
          $(".bloc-ajax").html(msg);
        }
      });
    }
  });
  
  $(".news-tags").live("click", function() {
    var research = $(this).html();
    $.ajax({ 
      url: "/index/search",
      data: "search=" + research + "&type=tag",
      success: function(msg) {
        $(".bloc-ajax").html(msg);
      }
    });
  });
});
