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

include_once('sglobals.php');

echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Stock Market Panel</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<table width="300" class=table bgcolor="black" border="2">
<tr>
<td colspan="100%"><center>
<b>Manage Stocks:</b></center></td></tr>
<tr><td><a href="staff_stocks.php?action=add">Add Stock</a></a></td>
<td> <a href="staff_stocks.php?action=edit">Edit Stock</a></td></tr>
<tr><td> <a href="staff_stocks.php?action=del">Delete Stock  </a>  </td>
<td> <a href="stocks.php">Back</a>  </td></tr>

</td>
</tr>
</table> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> <br/>


';






$x = (isset($_GET['action']) && ctype_alnum($_GET['action'])) ? trim($_GET['action']) : FALSE;
switch($x)    {
    default: echo ''; break;
    case 'add': add_stock(); break;
    case 'del': delete_stock(); break;
    case 'edit': edit_stocks(); break;
    case 'editn': edit_stock(); break;
}
function edit_stocks()    {
    global $ir,$h;
    echo '
    
    <div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Edit Stock</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>
    
    
    Edit a stock bellow.<br /><br />
    <form action="'.$_SERVER['PHP_SELF'].'?action=editn" method="post">';
        $stock = mysql_query("SELECT stockNAME,stockID FROM `stock_stocks`") or die(mysql_error());
        while($soc = mysql_fetch_assoc($stock))    {
            echo '<input type="radio" value="'.$soc['stockID'].'" name="ID" /> '.$soc['stockNAME'].'<br />';
        }    echo '
        <br /><input type="submit" STYLE="color: black;  background-color: white;" value="Edit Stock" />
    </form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
function edit_stock()    {
    global $ir,$h;
    $ID = abs(@intval($_REQUEST['ID']));
    $stre = mysql_query("SELECT stockID,stockNAME,stockOPRICE,stockNPRICE FROM `stock_stocks` WHERE `stockID` = ".$ID) or die(mysql_error());
    if(mysql_num_rows($stre) == 0)    {
        echo 'Invalid Stock!';
        exit($h->endpage());
    }
    if(isset($_POST['name']))    {
        $name = mysql_real_escape_string($_POST['name']);
        $nprice = abs(@intval($_POST['nprice']));
        $oprice = abs(@intval($_POST['oprice']));
        mysql_query("UPDATE `stock_stocks` SET `stockNAME` = '".$name."',`stockOPRICE` = ".$oprice.", `stockNPRICE` = ".$nprice." WHERE `stockID` = ".$ID) or die(mysql_error());
        echo 'Stock edited successfuly';
    }
    else    {
        $row = mysql_fetch_assoc($stre);
        echo '
        
        <div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Editing stock - '.$row['stockNAME'].' </h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


        <form action="'.$_SERVER['PHP_SELF'].'?action=editn&ID='.$ID.'" method="post">
            Stock Name: <input type="text" STYLE="color: black;  background-color: white;" name="name" value="'.$row['stockNAME'].'" /><br />
            Stock Orig Price: <input type="text" STYLE="color: black;  background-color: white;" name="oprice" value="'.$row['stockOPRICE'].'" /><br />
            Stock Now Price: <input type="text" STYLE="color: black;  background-color: white;" name="nprice" value="'.$row['stockNPRICE'].'" /><br />
            <input type="submit" STYLE="color: black;  background-color: white;" value="Edit Stock" />
        </form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
}
function add_stock()    {
    global $ir,$h;
    if(isset($_POST['name']))    {
        $name = mysql_real_escape_string($_POST['name']);
        $orgp = abs(@intval($_POST['origp']));
        mysql_query("INSERT INTO `stock_stocks` (`stockNAME`,`stockOPRICE`,`stockNPRICE`) VALUES ('".$name."',".$orgp.",".$orgp.")") or die(mysql_error());
        echo 'Stock Created!';
    }
    else    {
        echo '
        
        
            <div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Add Stock</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>
        
        
        
        Add a stock below<br /><br />
        <form action="'.$_SERVER['PHP_SELF'].'?action=add" method="post">
            Name: <input type="text" STYLE="color: black;  background-color: white;" name="name" /><br />
            Original Price: <input type="text" STYLE="color: black;  background-color: white;" name="origp" value="2000" /><br />
            <input type="submit" STYLE="color: black;  background-color: white;" value="Add Stock" />
        </form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
}
function delete_stock()    {
    global $ir,$h;
    if(isset($_POST['del']))    {
        $id = abs(@intval($_POST['stock']));
        mysql_query("DELETE FROM `stock_stocks` WHERE `stockID` = ".$id) or die(mysql_error());
        mysql_query("DELETE FROM `stock_holdings` WHERE `holdingSTOCK` = ".$id) or die(mysql_error());
        echo 'Stock Deleted.';
    }
    else    {
        echo '
        
        <div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Delete Stock</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>
        
        <br /><br />
        <form action="'.$_SERVER['PHP_SELF'].'?action=del" method="post">';
        $stock = mysql_query("SELECT stockNAME,stockID FROM `stock_stocks`") or die(mysql_error());
        while($soc = mysql_fetch_assoc($stock))    {
            echo '<input type="radio" STYLE="color: black;  background-color: white;" value="'.$soc['stockID'].'" name="stock" /> '.$soc['stockNAME'].'<br />';
        }    echo '
        <br /><input type="submit" STYLE="color: black;  background-color: white;" value="Delete Stock" name="del" />
        </form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
}
$h->endpage();
?>