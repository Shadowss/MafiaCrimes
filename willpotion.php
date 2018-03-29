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
print <<<EOF


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Will Potions</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Buy will potions today! They restore 100% will.<br />
<b>Buy One:</b> (1.00 Euro)<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|WP|1|{$userid}">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/willpdone.php?action=done&quantity=one">
<input type="hidden" name="cancel_return" value="http://{$domain}/willpdone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_wp.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>Buy Five:</b> (4.50 Euro)<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|WP|5|{$userid}">
<input type="hidden" name="amount" value="4.50">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/willpdone.php?action=done&quantity=five">
<input type="hidden" name="cancel_return" value="http://{$domain}/willpdone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_wp.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
$h->endpage();
?>
