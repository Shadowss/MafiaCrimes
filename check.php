<?php

/**************************************************************************************************
| Software Name        : Ravan Scripts Online Mafia Game
| Software Author      : Ravan Soft Tech
| Software Version     : Version 2.0.1 Build 2101
| Website              : http://www.ravan.info/
| E-mail               : support@ravan.info
|**************************************************************************************************
| The source files are subject to the Ravan Scripts End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Ravan Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Ravan Scripts . All rights reserved.
|**************************************************************************************************/
include "language.php";
if(!isset($_GET['password'])){ // If they are trying to view this without ?password=password.
    die("Whats this document for?"); // Lawl what is this doccument for anyways?
}elseif(isset($_GET['password'])){ // ElseIf we cant to check the passwords strength.
    $PASS=stripslashes(strip_tags(htmlspecialchars($_GET['password'], ENT_QUOTES))); // Cleans all nasty input from the password.
    $strength=1; // Sets their default amount of points to 1.
   
    if($PASS != NULL){ // If the current password is not NULL (empty).   
        $numbers=array( // Creates our array to store 1 - 9 in.
            1 => "1", // 1.
            2 => "2", // 2.
            3 => "3", // 3.
            4 => "4", // 4.
            5 => "5", // 5.
            6 => "6", // 6.
            7 => "7", // 7.
            8 => "8", // 8.
            9 => "9", // 9.
            0 => "0"  // 0.
        ); // Closes the Array.
   
        $undercase=array(  // Creates our array to store a - z in.
            1 => "a", // a.
            2 => "b", // b.
            3 => "c", // c.
            4 => "d", // d.
            5 => "e", // e.
            6 => "f", // f.
            7 => "g", // g.
            8 => "h", // h.
            9 => "i", // i.
            10 => "j", // j.
            11 => "k", // k.
            12 => "l", // l.
            13 => "m", // m.
            14 => "n", // n.
            15 => "o", // o.
            16 => "p", // p.
            17 => "q", // q.
            18 => "r", // r.
            19 => "s", // s.
            20 => "t", // t.
            21 => "u", // u.
            22 => "v", // v.
            23 => "w", // w.
            24 => "x", // x.
            25 => "y", // y.
            26 => "z"  // z.
        ); // Closes the Array.
       
        $uppercase=array(  // Creates our array to store A - Z in.
            1 => "A", // A.
            2 => "B", // B.
            3 => "C", // C.
            4 => "D", // D.
            5 => "E", // E.
            6 => "F", // F.
            7 => "G", // G.
            8 => "H", // H.
            9 => "I", // I.
            10 => "J", // J.
            11 => "K", // K.
            12 => "L", // L.
            13 => "M", // M.
            14 => "N", // N.
            15 => "O", // O.
            16 => "P", // P.
            17 => "Q", // Q.
            18 => "R", // R.
            19 => "S", // S.
            20 => "T", // T.
            21 => "U", // U.
            22 => "V", // V.
            23 => "W", // W.
            24 => "X", // X.
            25 => "Y", // Y.
            26 => "Z"  // Z.
        ); // Closes the Array.
$symbs=array('\\','/','"',"'","{","}",")","(","|","?",".",",","<",">","_","-","!","#","\$","%","^","&","*");
$strength=0;
if(strlen($PASS) >= 7) { $strength+=3;  }
$nc=0;
foreach($numbers as $v)
{
if(strstr($PASS, $v))
{
$nc++;
}
}
if($nc >= 2) { $strength+=1;  }
if($nc >= 5) { $strength+=1; }
$nc=0;
foreach($undercase as $v)
{
if(strstr($PASS, $v))
{
$nc++;
}
}
if($nc >= 2) { $strength+=1; }
if($nc >= 5) { $strength+=1; }
$nc=0;
foreach($uppercase as $v)
{
if(strstr($PASS, $v))
{
$nc++;
}
}
if($nc >= 2) { $strength+=1; }
if($nc >= 5) { $strength+=1; }
$nc=0;
foreach($symbs as $v)
{
if(strstr($PASS, $v))
{
$nc++;
}
}
if($nc >= 1) { $strength+=1; }
if($nc >= 2) { $strength+=1; }
if($nc >= 5) { $strength+=1; }
       
            if($strength <= 2){ // If there total points are equal or less than 5.
                $overall = '<span style="color:#FF0000">Weak</span>'; // Eeek very week!
            }elseif($strength <= 5){ // If there total points are equal or less than 8.
                $overall = '<span style="color:#999900">Moderate</span>'; // Omg week.
            }elseif($strength <= 10){ // If there total points are equal or less than 12.
                $overall = '<span style="color:#008800">Good</span>'; // Meh Moderate.
            }elseif($strength >= 12){ // If there total points are greator than 12.
                $overall = '<span style="color:#0000ff">Excellent</span>'; // Thats the way Superman.
            } // End If.
           
    echo 'Password strength: '.$overall.''; // Tells them their passwords strength.
   
    }elseif($PASS == NULL){ // ElseIf their password is NULL (empty).
        echo ''; // Dont display anything.
    } // End ElseIf.
} // End ElseIF.
?>
