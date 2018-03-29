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
<div class='info_mid'><h2 style='padding-top:10px;'> Donations</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<b>[<a href='willpotion.php'>Buy Will Potions</a>]</b><br />
If you become a donator to {$set['game_name']}, you will receive (each time you donate):<br />
<b>1st Offer: 1 Euro</b><ul>
<li>\$5,000 game money</li>
<li>50 crystals</li>
<li>50 IQ, the hardest stat to get in the game!</li>
<li>14 days Donator Status: Green name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul>
<li><b>NEW!</b> Gain HP twice as quick</li></ul>
<li><b>NEW!</b> Gain Will twice as quick</li></ul>
<li><b>NEW!</b> Gain Brave twice as quick</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type=hidden name=cmd value=_xclick>
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|DP|1|{$userid}">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/donatordone.php?action=done&type=standard">
<input type="hidden" name="cancel_return" value="http://{$domain}/donatordone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_donator.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>2nd Offer: 1 Euro</b><ul>
<li>100 crystals</li>
<li>14 days Donator Status: Green name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul>
<li><b>NEW!</b> Gain HP twice as quick</li></ul>
<li><b>NEW!</b> Gain Will twice as quick</li></ul>
<li><b>NEW!</b> Gain Brave twice as quick</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|DP|2|{$userid}">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/donatordone.php?action=done&type=crystals">
<input type="hidden" name="cancel_return" value="http://{$domain}/donatordone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_donator.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>3rd Offer: 1 Euro</b><ul>
<li>120 IQ, the hardest stat to get in the game!</li>
<li>14 days Donator Status: Green name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul>
<li><b>NEW!</b> Gain HP twice as quick</li></ul>
<li><b>NEW!</b> Gain Will twice as quick</li></ul>
<li><b>NEW!</b> Gain Brave twice as quick</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|DP|3|{$userid}">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/donatordone.php?action=done&type=iq">
<input type="hidden" name="cancel_return" value="http://{$domain}/donatordone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_donator.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>4th Offer: 5 Euro</b><ul>
<li>\$15,000 game money</li>
<li>75 crystals</li>
<li>80 IQ, the hardest stat to get in the game!</li>
<li>28 days Donator Status: Green name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul>
<li><b>NEW!</b> Gain HP twice as quick</li></ul>
<li><b>NEW!</b> Gain Will twice as quick</li></ul>
<li><b>NEW!</b> Gain Brave twice as quick</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|DP|4|{$userid}">
<input type="hidden" name="amount" value="5.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/donatordone.php?action=done&type=fivedollars">
<input type="hidden" name="cancel_return" value="http://{$domain}/donatordone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_donator.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>5th Offer: 7 Euro</b><ul>
<li>\$35,000 game money</li>
<li>160 crystals</li>
<li>180 IQ, the hardest stat to get in the game!</li>
<li>A free Rifle valued at \$25,000</li>
<li>42 days Donator Status: Green name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul>
<li><b>NEW!</b> Gain HP twice as quick</li></ul>
<li><b>NEW!</b> Gain Will twice as quick</li></ul>
<li><b>NEW!</b> Gain Brave twice as quick</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{$set['paypal']}">
<input type="hidden" name="item_name" value="{$domain}|DP|5|{$userid}">
<input type="hidden" name="amount" value="7.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$domain}/donatordone.php?action=done&type=tendollars">
<input type="hidden" name="cancel_return" value="http://{$domain}/donatordone.php?action=cancel">
<input type="hidden" name="notify_url" value="http://{$domain}/ipn_donator.php">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
$h->endpage();
?>


