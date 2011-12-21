window.ma = (function() {
  return window.ma || {
    version: 0.1,
    commentNews: {
      tmplComment:  '{{each(index, value) request}}' +
                    ' <div class="comment-bloc-user">' +
                    '   <div class="comment-bloc-info"><span class="comment-bloc-author">${Auteur_C}</span> à dit : <span class="comment-bloc-date">le ${Date_C} à ${Heure_C}</span></div>' +
                    '   <p class="comment-bloc-text">${Text_C}</p>' +
                    ' </div>' +
                    '{{/each}}'
    },
    config: {
      debug: true
    },
    
    generateComment: function(nID, toggle) {
      var comTpl = this.commentNews.tmplComment,
          newsId = nID;
          
      toggle = toggle || false;
      
      $(function(){
        $("#zone-com-view-" + newsId).html("Chargement des commentaires !");
        
        if(toggle){
          $("#zone-com-id-" + newsId).toggle();
        }
        
        if($("#zone-com-id-" + newsId).attr("style") != "display: none;") {
          var dataString     = 'news='+ newsId;
          
          $.template('teamTpl', comTpl);
          
          $.ajax({
            type    : "POST",
            url     : "/index/get-commentaire",
            data    : dataString,
            success: function(msg){
              $("#zone-com-view-" + newsId).html("");
              $("#zone-com-view-" + newsId).append("teamTpl", msg);
            }
          });
        }
      });
    }
  };
}());
