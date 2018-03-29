<?php
function bb2html($text) {

    $pattern[] = "/\[url=([^<> \n]+?)\](.+?)\[\/url\]/i";
    $replacement[] = '<a href="\\1" target="_blank">\\2</a>';
    
    $pattern[] = "/\[url\](.+?)\[\/url\]/i";
    $replacement[] = '<a href="\\1" target="_blank">\\1</a>';

    $pattern[] = "/\[email=([^<> \n]+?)\](.+?)\[\/email\]/i";
    $replacement[] = '<a href="mailto:\\1">\\2</a>';

    $pattern[] = "/\[img[=]?(left|right)?\](([^<> \n]+?)\.(gif|jpg|jpeg|png|bmp))\[\/img\]/i";
    $replacement[] = '<img src="\\2" border="0" align="\\1" alt="">';

    $pattern[] = "/\[[bB]\](.+?)\[\/[bB]\]/s";
    $replacement[] = '<b>\\1</b>';

    $pattern[] = "/\[[iI]\](.+?)\[\/[iI]\]/s";
    $replacement[] = '<i>\\1</i>';

    $pattern[] = "/\[[uU]\](.+?)\[\/[uU]\]/s";
    $replacement[] = '<u>\\1</u>';

    $pattern[] = "/\[[pP]\](.+?)\[\/[pP]\]/s";
    $replacement[] = '<p>\\1</p>';
    
    $pattern[] = "/\[[sS]\](.+?)\[\/[sS]\]/s";
    $replacement[] = '<s>\\1</s>';

    $pattern[] = "/\[hr]/s";
    $replacement[] = '<hr />';

    $pattern[] = "/\[center](.+?)\[\/center\]/is";
    $replacement[] = '<center>\\1</center>';

    $pattern[] = "/\[align(=left|=right|=center|=justify)?\](.+?)\[\/align\]/is";
    $replacement[] = '<div align\\1>\\2</div>';

    $pattern[] = "/\[color=(#[A-F0-9]{6})\](.+?)\[\/color\]/is";
    $replacement[] = '<font color="\\1">\\2</font>';

    $pattern[] = "/\[link=([^<> \n]+?)\](.+?)\[\/link\]/i";
    $replacement[] = '<a href="\\1">\\2</a>';

    $pattern[] = "/\[nbsp]/s";
    $replacement[] = '&nbsp;';

    $pattern[] = "/\[div]/s";
    $replacement[] = '<div class="hr">&nbsp;</div>';

    $pattern[] = "/\[bp]/s";
    $replacement[] = '<img src="icons/bullet.png" title="Bullet Point" align="middle" border="0"> ';

    $pattern[] = "/\[arrow]/s";
    $replacement[] = '<img src="icons/arrow.png" title="Arrow" align="middle" border="0"> ';

    $pattern[] = "/\[ab=([^<> \n].+?)\](.+?)\[\/ab\]/i";
    $replacement[] = '<abbr title="\\1">\\2</abbr>';    
    
    $text = preg_replace($pattern, $replacement, $text);

    return $text;
}

function strip_bbcode($text) {

    $pattern[] = "/\[url=([^<> \n]+?)\](.+?)\[\/url\]/i";
    $pattern[] = "/\[email=([^<> \n]+?)\](.+?)\[\/email\]/i";
    $pattern[] = "/\[img(=left|=right)?\](([^<> \n]+?)\.(gif|jpg|jpeg|png))\[\/img\]/i";
    $pattern[] = "/\[[bB]\](.+?)\[\/[bB]\]/s";
    $pattern[] = "/\[[iI]\](.+?)\[\/[iI]\]/s";
    $pattern[] = "/\[[uU]\](.+?)\[\/[uU]\]/s";
    $pattern[] = "/\[hr]/s";
    $pattern[] = "/\[center](.+?)\[\/center\]/is";
    $pattern[] = "/\[align(=left|=right|=center|=justify)?\](.+?)\[\/align\]/is";
    $pattern[] = "/\[font(#[A-F0-9]{6})\](.+?)\[\/font\]/is";
    $pattern[] = "/\[link=([^<> \n]+?)\](.+?)\[\/link\]/i";
    $pattern[] = "/\[nbsp]/s";
    $pattern[] = "/\[div]/s";
    $pattern[] = "/\[bp]/s";

    $text = preg_replace($pattern, '', $text);

    return $text;
}

?>