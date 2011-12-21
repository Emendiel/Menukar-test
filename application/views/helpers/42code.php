<?php 
  function bbcode($text, $db)
  {
    
    /**
      * Emoticone
      */
    
    $emote = $db->fetchAll("SELECT * FROM emote ORDER BY nom_ge, ID_e");
    
    foreach ($emote as $emoteview)
    {
      $text=str_replace( $emoteview['code_e'], '<img src="/'.$emoteview['image_e'].'" />',$text);
    }
    
    /**
      * BBcode
     */
    
    // Gras
    $text = preg_replace('#\[b\](.+)\[/b\]#i', '<b>$1</b>', $text);
    // Italique
    $text = preg_replace('#\[i\](.+)\[/i\]#i', '<em>$1</em>', $text);
    // Soulign�
    $text = preg_replace('#\[u\](.+)\[/u\]#i', '<span style="text-decoration: underline;">$1</span>', $text);
    // barr�
    $text = preg_replace('#\[s\](.+)\[/s\]#i', '<span style="text-decoration: line-through">$1</span>', $text);
    // URL
    $text = preg_replace('#\[url\]((.+))\[/url\]#i', '<a href="$1" target="_blank">$2</a>', $text);
    // URL titre
    $text = preg_replace('#\[url=(.+)\](.+)\[/url\]#i', '<a href="$1" target="_blank">$2</a>', $text);
    // Centr�
    $text = preg_replace('#\[center\](.+)\[/center\]#i', '<center>$1</center>', $text);
    // Centr�
    $text = preg_replace('#\[h([1-4])\](.+)\[/h([1-4])\]#i', '<h$1>$2</h$3>', $text);
    // Quote
        $text = preg_replace('#\[quote\=(.+)\](.+)\[/quote\]#i', '<fieldset style="background-color: #DFDFDF;"><legend>$1</legend>$2</fieldset>', $text);
    // image
    $text = preg_replace('#\[img\](.+)\[/img\]#i', '<img src="$1"/>', $text);
    // \n
    $text = preg_replace('#\\n#i', '<br />', $text);
    // \'
    $text=str_replace( "\'", "&#39;",$text);
        // \"
        $text=str_replace( '\"', '&#34;',$text);
        
    return $text;
  }
