$(document).ready(function(){
  
  $(".news-title").live("click", function() {
    var research = $(this).attr("id");
    var name = this;
    $.ajax({ 
      url: "/index/search",
      data: "search=" + research + "&type=alone",
      success: function(msg) {
        $(".bloc-ajax").html(msg);
        $(".selected").removeClass("selected");
        $(".fil-link.article").addClass("selected");
        $(".fil-link.article").attr("id", research);
        $(".fil-link.article").html($(name).html());
        $(".article").show();
      }
    });
  });
  
  $(".fil-link").live("click", function() {
    var cat = this.id;
    $.ajax({ 
      url: "/index/news",
      data: "cat=" + this.id,
      success: function(msg) {
        $(".bloc-ajax").html(msg);
        if(cat == "home") {
          $(".category").hide();
        }
        $(".article").hide();
      }
    });
  });
  
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
