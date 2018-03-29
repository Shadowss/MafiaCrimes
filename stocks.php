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

include_once('globals.php');


if($ir['user_level'] == 1) 

    {

echo '
<style language="text/css">
    .red    {
        color: red;
    }
    .green    {
        color: green;
    }
    .stock td    {
        border: 1px black solid;
    }
    .stock th    {
        border: 1px black solid;
    }
</style>

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Stock Market</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


';

    }
  
  
  if($ir['user_level'] > 1) 

    {

echo '
<style language="text/css">
    .red    {
        color: red;
    }
    .green    {
        color: green;
    }
    .stock td    {
        border: 1px black solid;
    }
    .stock th    {
        border: 1px black solid;
    }
</style>

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Stock Market  - <a href="staff_stocks.php">Stock Panel </a> </h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


';

    }  
    
    

$arrs = array('buy','log','sell','removelog','view');
$x = (isset($_GET['trip']) && ctype_alnum($_GET['trip']) && in_array($_GET['trip'], $arrs)) ? trim($_GET['trip']) : FALSE; # False making it not exist making it default page.
switch($x)    {
    case 'buy': buy_stock(); break;
    case 'sell': sell_stock(); break;
    case 'view': view_stock(); break;
    case 'log': view_stock_log(); break;
    case 'removelog': remove_stock_log(); break;
    default: stock_default(); break;
}
function view_stock_log()    {
    global $ir,$h;
    $log = mysql_query("SELECT recordTIME,recordTEXT FROM `stock_records` WHERE `recordUSER` = ".$ir['userid']." ORDER BY `recordTIME` DESC") or die(mysql_error());
    if(mysql_num_rows($log) == 0)    {
        echo 'You do not have any log records.';
    }
    else    {
        while($soc = mysql_fetch_assoc($log))    {
            $time = date('F jS Y g:i:s', $soc['recordTIME']);
            echo '<strong>'.$time.'</strong> '.str_replace('me', 'You', $soc['recordTEXT']).'<br />';
        }
    }
 
if(mysql_num_rows($log) > 0)    {   
    
print'

<br /> <a href="'.$_SERVER['PHP_SELF'].'?trip=removelog">Clear Logs</a>';

}

print'

</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}




function remove_stock_log()    {
    global $ir,$h;
    $log = mysql_query("Delete FROM `stock_records` WHERE `recordUSER` = ".$ir['userid']." ORDER BY `recordTIME` DESC") or die(mysql_error());
        echo 'Logs Cleared. </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}



function sell_stock()    {
    global $ir,$h;
    $id = abs(@intval($_GET['ID']));
    $holding = mysql_query("SELECT holdingID,holdingSTOCK,holdingQTY FROM `stock_holdings` WHERE `holdingID` = ".$id." AND `holdingUSER` = ".$ir['userid']) or die(mysql_error());
    if(mysql_num_rows($holding) == 0)    {
        echo 'This holding ID does not exist, or you do not own it.';
    }
    else    {
        $soc = mysql_fetch_assoc($holding);
        $stock = mysql_query("SELECT stockNAME,stockNPRICE FROM `stock_stocks` WHERE `stockID` = ".$soc['holdingSTOCK']) or die(mysql_error());
        $stock = mysql_fetch_assoc($stock);
        $tot = ($stock['stockNPRICE'] * $soc['holdingQTY']);
        mysql_query("DELETE FROM `stock_holdings` WHERE `holdingID` = ".$soc['holdingID']);
        mysql_query("INSERT INTO `stock_records` (`recordUSER`,`recordTIME`,`recordTEXT`) VALUES (".$ir['userid'].",unix_timestamp(),'me sold ".$soc['holdingQTY']." of stock ".$stock['stockNAME']." for ".money_formatter($tot)."')") or die(mysql_error());
        mysql_query("UPDATE `users` SET `money` = (`money` + ".$tot.") WHERE `userid` = ".$ir['userid']) or die(mysql_error());
        echo 'You sold '.number_format($soc['holdingQTY']).' stock of '.$stock['stockNAME'].' for '.money_formatter($tot).'! </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> ';
    }
}
function view_stock()    {
    global $ir,$h;
    $holdings = mysql_query("SELECT holdingID,holdingSTOCK,holdingQTY FROM `stock_holdings` WHERE `holdingUSER` = ".$ir['userid']) or die(mysql_error());
    if(mysql_num_rows($holdings) == 0)    {
        echo 'You do not hold any shares in any stocks atm.</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
    else    {
        echo '
        <table border="0" cellspacing="0" cellpadding="0" class="table" width="50%">
            <tr>
                <th>Stock Name</th>
                <th>Shares</th>
                <th>Sell Price</th>
                <th>Sell</th>
            </tr>';
            while($soc = mysql_fetch_assoc($holdings))    {
                $stock = mysql_query("SELECT stockNAME,stockNPRICE FROM `stock_stocks` WHERE `stockID` = ".$soc['holdingSTOCK']) or die(mysql_error());
                $stock = mysql_fetch_assoc($stock);
                echo '
            <tr>
                <td>'.$stock['stockNAME'].'</td>
                <td>'.number_format($soc['holdingQTY']).'</td>
                <td>'.money_formatter($stock['stockNPRICE'] * $soc['holdingQTY']).'</td>
                <td><a href="'.$_SERVER['PHP_SELF'].'?trip=sell&ID='.$soc['holdingID'].'">Sell Stock</a></td>
            </tr>';
            }    echo '
        </table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
}
function buy_stock()    {
    global $ir,$h;
    $id = abs(@intval($_GET['ID']));
    $rows = mysql_query("SELECT stockID FROM `stock_stocks` WHERE `stockID` = ".$id) or die(mysql_error());
    if(mysql_num_rows($rows) == 0)    {
        echo 'This stock does not exist.';
        exit($h->endpage());
    }
    if(isset($_POST['buy']))    {
        $amnt = abs(@intval($_POST['amnt']));
        $fetch_stock = mysql_query("SELECT stockID,stockNPRICE,stockNAME FROM `stock_stocks` WHERE `stockID` = ".$id) or die(mysql_error());
        $stock = mysql_fetch_assoc($fetch_stock);
        $mprice = ($stock['stockNPRICE'] * $amnt);
        if($ir['money'] <= $mprice)    {
            echo 'You do not have enough money for this amount of stocks.';
            exit($h->endpage());
        }
        $stock_holds = mysql_query("SELECT holdingID FROM `stock_holdings` WHERE `holdingUSER` = ".$ir['userid']." AND `holdingSTOCK` = ".$stock['stockID']) or die(mysql_error());
        if(mysql_num_rows($stock_holds))    {
            mysql_query("UPDATE `stock_holdings` SET `holdingQTY` = (`holdingQTY` + ".$amnt.") WHERE `holdingUSER` = ".$ir['userid']." AND `holdingSTOCK` = ".$stock['stockID']) or die(mysql_error());
        }
        else    {
            mysql_query("INSERT INTO `stock_holdings` (`holdingUSER`,`holdingSTOCK`,`holdingQTY`) VALUES (".$ir['userid'].",".$stock['stockID'].",".$amnt.")") or die(mysql_error());
        }
        mysql_query("UPDATE `users` SET `money` = (`money` - ".$mprice.") WHERE `userid` = ".$ir['userid']);
        mysql_query("INSERT INTO `stock_records` (`recordUSER`,`recordTIME`,`recordTEXT`) VALUES (".$ir['userid'].",unix_timestamp(),'me bought ".$amnt." of stock ".$stock['stockNAME']." for ".money_formatter($mprice)."')") or die(mysql_error());
        echo 'You successfuly bought '.number_format($amnt).' stocks of '.$stock['stockNAME'].'. </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
    else    {
        $stock = mysql_query("SELECT stockID,stockNAME,stockCHANGE,stockNPRICE,stockUD,stockOPRICE FROM `stock_stocks` WHERE `stockID` = ".$id) or die(mysql_error());
        $stock = mysql_fetch_assoc($stock);
        $symb = ($stock['stockUD'] == 1) ? '<big>^</big>' : '<big></big>';
        $class = ($stock['stockUD'] == 1) ? 'green' : 'red';
        $blip = ($stock['stockUD'] == 1) ? '+' : '-';
        $clor = ($stock['stockOPRICE'] < $soc['stockNPRICE']) ? 'green' : 'red';
        echo '
        <table border="0" class="table" cellspacing="0" width="50%">
            <tr>
                <td>Stock Name</td>
                <td>'.$stock['stockNAME'].'</td>
            </tr>
            <tr>
                <td>Price Change</td>
                <td><span class="'.$class.'">'.$blip.' '.money_formatter($stock['stockCHANGE']).' '.$symb.'</span></td>
            </tr>
            <tr>
                <td>Original Price</td>
                <td>'.money_formatter($stock['stockOPRICE']).'</td>
            </tr>
            <tr>
                <td>Now Price</td>
                <td>'.money_formatter($stock['stockNPRICE']).'</td>
            </tr>
            <tr>
                <td>Buy Stock</td>
                <td>
                    <form action="'.$_SERVER['PHP_SELF'].'?trip=buy&ID='.$id.'" method="post">
                        QTY: <input type="text" name="amnt" value="0" /><br />
                        <input type="submit" value="Buy" name="buy" />
                    </form>
                </td>
            </tr>
        </table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
}
function stock_default()    {
    global $ir,$h;
    echo '
    Here is a list of stocks available along with their price and such.<br />
    Stock Market update every 5 minutes !<br />
    -> <a href="'.$_SERVER['PHP_SELF'].'?trip=view">View your stocks</a><br />
    -> <a href="'.$_SERVER['PHP_SELF'].'?trip=log">View your log</a><br /><br />
    <table border="0" cellspacing="0" cellpadding="0" class="table" width="70%">
        <tr>
            <th>Stock Name</th>
            <th>Stock Orig Price</th>
            <th>Stock Now Price</th>
            <th>Price Change</th>
            <th>View</th>
        </tr>';
        $stocks = mysql_query("SELECT stockID,stockNAME,stockOPRICE,stockNPRICE,stockCHANGE,stockUD FROM `stock_stocks`") or die(mysql_error());
        if(mysql_num_rows($stocks) == 0)    {
            echo '
        <tr>
            <td align="center" colspan="5">No stocks available</td>
        </tr>
    </table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    exit($h->endpage());
        }
        while($soc = mysql_fetch_assoc($stocks))    {
            $symb = ($soc['stockUD'] == 1) ? '^' : '';
            $class = ($soc['stockUD'] == 1) ? 'green' : 'red';
            $blip = ($soc['stockUD'] == 1) ? '+' : '-';
            $clor = ($soc['stockOPRICE'] < $soc['stockNPRICE']) ? 'green' : 'red';
            $blic = ($soc['stockOPRICE'] < $soc['stockNPRICE']) ? '+' : '-';
            echo '
        <tr>
            <td>'.$soc['stockNAME'].'</td>
            <td>'.money_formatter($soc['stockOPRICE']).'</td>
            <td><span class="'.$clor.'">'.$blic.' '.money_formatter($soc['stockNPRICE']).'</span></td>
            <td><span class="'.$class.'">'.$blip.' '.money_formatter($soc['stockCHANGE']).' '.$symb.'</span></td>
            <td><a href="'.$_SERVER['PHP_SELF'].'?trip=buy&ID='.$soc['stockID'].'">Buy Or View</a></td>
        </tr>';
        }    echo '
    </table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
$h->endpage();
?>