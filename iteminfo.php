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

include "globals.php";
//look up item
$_GET['ID'] = abs((int) $_GET['ID']);
$itmid=$_GET['ID'];

if(!$itmid)
    {
        print "
        
        
            <div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

    Invalid item ID
    
    <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>";
        
    exit;   
    }
else
    {
        $r = sprintf("SELECT 
                    i.`itmid`,`itmtype`,`itmname`,`itmdesc`,`itmbuyprice`,`itmsellprice`,`weapon`,`armor`,
                    it.`itmtypeid`,`itmtypename` FROM `items` i 
                    LEFT JOIN `itemtypes` it 
                    ON i.itmtype = '%d' 
                    WHERE i.itmid = %d 
                    LIMIT 1",
        $itmtypeid,        
        mysql_real_escape_string($itmid));
        $q = $db->query($r);



if (!$db->num_rows($q))
    {
    print "
    
    <div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

    Invalid item ID
    
    <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>
    
    ";
    $h->endpage(); 
    exit;
    
    
    }
else
    {
    $id=$db->fetch_row($q);

    $item= mysql_fetch_object($db->query("SELECT `itmtypename` FROM `itemtypes` WHERE itmtypeid= ".$id['itmtype']." "));



$main = '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> '.$id['itmname'].' </h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

  
<table width="75%" class="table" cellspacing="1">  
        <tr>
            <th colspan=2><b><strong> Item Info</strong></b></th>



            <tr>
         <td width="50%" class="style8">
               <font color=green><b>Category</b></font> <br /></td>
                <td width="50%" class="style8">
                    <font color=green><b>Description</b></font></td>
                        </tr><table width="75%" class="table" cellspacing="1">  
        <tr>
         <td width="50%" class="style8">
               '.$item->itmtypename.' </td>
                <td width="50%" class="style8">
                    '.$id['itmdesc'].'</b></td>
                        </tr>
                         <tr>
                   <th>Item Buy Price</th>
             <th>Item Sell Price</th></tr>
   <tr>
   
   
<td width="50%" class="style8">';
print($main);

}
if($id['itmbuyprice'])
    {
        echo money_formatter($id['itmbuyprice']);
    }
else
    {
        echo "N/A";   
    }
print "</td><td width='50%' class='style8'>";

if($id['itmsellprice'])
    {
        echo money_formatter($id['itmsellprice']);
    }
else
    {
        echo "N/A";
    }
        echo " </td></tr></table><P> ";

$formula=(int) $id['weapon'] / 2500 * 100;
$armgreen=(int) $id['armor'] / 2500 * 100;
    $enopp = 100 - $forumla;
    $armred= 100 - $armgreen;


echo"
 <table width=75% class='table' cellspacing='1'>
<tr>
    <th width='50%'>Power</th>
    <th width='50%'>Defense</th>
</tr>
   <tr><td width='50%'>";
if($id['weapon'] > 0)        
   {
    echo "
    <style type='text/css'>
.style9 {
    text-align: center;
}
</style>
</head>

<div class='style9'>
    
    <br />    
      Power: [<font color=red>{$id['weapon']}</font>]  <br /> 
      <img src='images/redbar.png' width='$formula' height='12'><img src='images/blackbar.png' width='$enopp' height='12'><br /><P></div> ";
   }
     else
   {
echo " <style type='text/css'>
.style1a {
    text-align: center;
}
</style>


<div class='style1a'>
    <br /> N/A </div>
<P> 
";
   }
echo "</td><td width='50%'>";
if($id['armor'] > 0)
   { 
    echo " <style type='text/css'>
.style9 {
    text-align: center;
}
</style>

<div class='style9'>
    <br />
      Defense: [<font color=green>{$id['armor']}</font>]  <br />
      <img src='images/greenbar.png' width='$armgreen' height='12'><img src='images/blackbar.png' width='$armred' height='12'><br /><P>
</div>
";
   }
 else 
   {
     echo "<style type='text/css'>
.style1a {
    text-align: center;
}
</style>


<div class='style1a'>
    <br /> N/A </div>
<P> 
     ";

   }
  echo " </td></tr></table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>  ";
 }
$h->endpage();
?>