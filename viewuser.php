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
print pageHelp(_HELP_VIEWUSER_HEADER, _HELP_VIEWUSER);
$_GET['u'] = abs((int) $_GET['u']);
if(!$_GET['u'])
{
print "Invalid use of file";
}
else
{
$q=$db->query("SELECT u.*,us.*,c.*,h.*,g.*,f.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN cities c ON u.location=c.cityid LEFT JOIN houses h ON u.maxwill=h.hWILL LEFT JOIN gangs g ON g.gangID=u.gang LEFT JOIN fedjail f ON f.fed_userid=u.userid WHERE u.userid={$_GET['u']}");
if($db->num_rows($q) == 0)
{
print "Sorry, we could not find a user with that ID, check your source.";
}
else
{
$r=$db->fetch_row($q);
if($r['user_level'] == 1) { $userl="Member"; } else if($r['user_level'] == 2) { $userl="Admin"; } else if ($r['user_level'] == 3) { $userl="Secretary"; } else if($r['user_level'] == 0) { $userl="NPC"; }  else {$userl="Assistant"; }
$lon=($r['laston'] > 0) ?date('F j, Y g:i:s a',$r['laston']) : "Never";
$sup=date('F j, Y g:i:s a',$r['signedup']);
$ts=$r['strength']+$r['agility']+$r['guard']+$r['labour']+$r['IQ'];
$d="";
if($r['laston'] > 0)
{
$la=time()-$r['laston'];
$unit="seconds";
if($la >= 60)
{
$la=(int) ($la/60);
$unit="minutes";
}
if($la >= 60)
{
$la=(int) ($la/60);
$unit="hours";
if($la >= 24)
{
$la=(int) ($la/24);
$unit="days";
}
}
$str="$la $unit ago";
}
else
{
$str="--";
}
if($r['last_login'] > 0)
{
$ll=time()-$r['last_login'];
$unit2="seconds";
if($ll >= 60)
{
$ll=(int) ($ll/60);
$unit2="minutes";
}
if($ll >= 60)
{
$ll=(int) ($ll/60);
$unit2="hours";
if($ll >= 24)
{
$ll=(int) ($ll/24);
$unit2="days";
}
}
$str2="$ll $unit2 ago";
}
else
{
$str2="--";
}

$money=money_formatter($r['money']); 
if($r['donatordays']) { $r['username'] = "<font color=green>{$r['username']}</font>";$d="<img src='donator.gif' alt='Donator: {$r['donatordays']} Days Left' title='Donator: {$r['donatordays']} Days Left' />"; }
if($r['laston'] >= time()-15*60) { $on="images/online.gif"; }  else { $on="images/offline.gif"; }
if($r['laston'] >= time()-15*60) { $status="Online"; } else { $status="Offline"; }
print "

<div class='icolumn2' id='mainContentDiv'>

<div class='gangpage_container' style='margin-left:0px;'>
<!-- Member Profile Page Starts -->
<div class='member_toppart'>
<div class='bluetxt'>{$r['username']}</div>
<div class='blueimg'><img src='images/profilepage_txt.jpg' alt='' /></div>

</div>
<!-- Member Content Part Starts -->
<div class='mem_conpart1'>
<div class='mem_conpart1_left'>
<div class='con_txt1'>{$r['username']} <span>[{$r['userid']}] $d </span> </div>
<div class='online_btn'> <img src='$on' alt='$status' title='$status' style='float: left'  /> </div>
<div class='respart'>

<div class='resimg_bg' style='padding-top:2px;position:relative;'>
<img src='{$r['display_pic']}' width='168' height='140' alt='User Display Pic' title='User Display Pic' style='float: left'   />
<p class='occlusion'><img src='images/ze.png' alt='' /></p>
</div>
</div> ";


if($r['donatordays'] > 0)
{
    
print " 

<div class='res_txtpart'>  

<div class='restxt_bg'></div>  ";
    
}


else

print " <br/> <br/>  ";

  


print " 

<b> ".get_gameranks($r['level'],$r['hPRICE'],$r)." </b>

<div class='leveltxt'  style='background:url(./images/exp_100.gif);' style='float: left'>Level {$r['level']}</div>



<br/>
<div class='caption_part'>
<div class='cap_txtpart'>
    <div class='cap_txt1'>User Level:</div>
    <div class='cap_txt2'>$userl</div>
</div>
<div class='cap_txtpart'>
    <div class='cap_txt1'>Gender:</div>

    <div class='cap_txt2'>{$r['gender']}</div>
</div>
<div class='cap_txtpart'>
    <div class='cap_txt1'>Status:</div>
    <div class='cap_txt2'><span><font color='#70cb00'><b><img src='$on' alt='$status' title='$status'  /></b></font></span></div>
</div>
<div class='cap_txtpart'>

    <div class='cap_txt1'>Last Active:</div>
    <div class='cap_txt2'>$str</div>
</div>
<div class='cap_txtpart'>
    <div class='cap_txt1'>Days Old:</div>
    <div class='cap_txt2'>{$r['daysold']}</div>
</div>

<div class='cap_txtpart'>
    <div class='cap_txt1'>City:</div>
    <div class='cap_txt2'>{$r['cityname']}  [<a href='travel.php' style='color:#7EE800;'>Travel</a>]</div>
</div>
<div class='cap_txtpart cap_txtpart1'>
    <div class='cap_txt1 cap_txt11'>Rating:</div>

    <div class='cap_txt2 cap_txt22'>                                                
<div>&nbsp; &nbsp; &nbsp;&nbsp;<a href='rating.php?ID={$r['userid']}&action=goodrating'><img src='images/thumbsup.gif' title='Give user good rating'></a> <strong>&nbsp; {$r['ratings']} &nbsp;</strong>  <a href='rating.php?ID={$r['userid']}&action=badrating'><img src='images/thumbsdown.gif' title='Give user bad rating'></a><br /></div>
    </div>
</div>        

<div class='cap_txtpart' style='padding-top:10px;'>

    <div class='cap_txt1'>Property:</div>
    <div class='cap_txt2'> {$r['hNAME']} </div>
</div>

<div class='cap_txtpart'>
    <div class='cap_txt1'>Money:</div>
    <div class='cap_txt2'>{$money}</div>

</div>


<div class='cap_txtpart'>
    <div class='cap_txt1'>Crystals:</div>
    <div class='cap_txt2'>{$r['crystals']}</div>

</div>

 <div class='cap_txtpart'>
    <div class='cap_txt1'>Level:</div>
    <div class='cap_txt2'>{$r['level']}</div>

</div>


<div class='cap_txtpart'>
    <div class='cap_txt1'>Health:</div>
    <div class='cap_txt2'>{$r['hp']}/{$r['maxhp']} </div>
</div> ";

$rr=$db->query("SELECT * FROM referals WHERE refREFER={$r['userid']}");
$referal=$db->num_rows($rr);

print " 
     <div class='cap_txtpart'>
    <div class='cap_txt1'>Friends:</div>
    <div class='cap_txt2'>{$r['friend_count']}</div>

</div>


<div class='cap_txtpart'>
    <div class='cap_txt1'>Enemies:</div>
    <div class='cap_txt2'>{$r['enemy_count']}</div>

</div>

 <div class='cap_txtpart'>
    <div class='cap_txt1'>Referals:</div>
    <div class='cap_txt2'>$referal</div>

</div>



</div>
</div>
</div>



<div class='mem_conpart1_right'>
<div class='mem_rightbg1' >

<div class='mem_gangtxt'  style='padding-left: 85px;'><img src='images/mem_gangtxt.jpg' alt='' style=';'/></div>

<div class='mem_clicktxt'>

";

if($r['gang'])
{
print " <a href='gangs.php?action=gang_view&gang_id={$r['gang']}'>{$r['gangNAME']} </a> ";
}
else
{
print "N/A";
}

print" </div>
<div class='mem_right_imgpart'>
    <!--<div class='money_img' style='background: url(./images/money_img.jpg) no-repeat; overflow: hidden; width: 210px; padding-top:100px;padding-buttom:66px;text-align:center;color:red;font-weight:bold;'>$5,250</div>-->
    <div class='money_img' style='text-align:center;'><a href='voting.php'>{$money}<br /><img src='images/money_img.jpg' /></a></div>
    <div class='estate_img' style='text-align:center;'><a href='estate.php'>
{$r['hNAME']}<br /><img src='images/estate_img.jpg' alt='Estate Agent'/>
    </a>

    </div>
</div>
</div>                            
<div class='mem_rightbg2'>  

<div class='useraction_txt'><img src='images/useraction_txt.jpg' alt='' /></div>
<div class='user_imgpart'>
    <div class='user_leftimgpart'>

        <div class='user_leftimg1'> <div align='left'> <a href='sendcash.php?ID={$r['userid']}'>Send Cash</a></div> </div> <div class='user_leftimg2'> <div align='left'> <a href='sendcrys.php?ID={$r['userid']}'>Send Crystals</a></div> </div> <div class='user_leftimg3'>  <div align='centre'> <a href='attack.php?ID={$r['userid']}'>Attack</a> </div> </div> <div class='user_leftimg4'><div align='left'><a href='friendslist.php?action=add&ID={$r['userid']}'>Add Friend</a></div></div><div class='user_rightimg5'><div align='left'><a href='mailbox.php?action=compose&ID={$r['userid']}'>Mail User</a></div></div>
    </div>
    
    <div class='user_rightimgpart'>
        <div class='user_rightimg1'> <div align='left'> <a href='killer.php'>Assassinate</a></div> </div> <div class='user_rightimg3'><div align='left'><a href='burnhouse.php?ID={$r['userid']}'>Arson</a></div></div><div class='user_rightimg5'><div align='left'><a href='contactlist.php?action=add&ID={$r['userid']}'>Add Contact</a></div></div><div class='user_leftimg4'><div align='left'><a href='blacklist.php?action=add&ID={$r['userid']}'>Add Enemy</a></div></div>

    </div>
    
</div>
</div>

</div>        
</div>

<div id='bubble' class='float_con' style='display:none; left: 100px; top: 400px;'>
<div id='bubblecaption' style='color:#BC1134'>CALLOUT</div>
<div id='bubbledescription' style='color:#BC1134'><img id='imgshow' style='width:102px;height:75px' src='#' /></div>
</div>
<div id='spy_pop_out' style='padding: 10px; display: none; position: absolute; left: 10%; top: 200px; width: 400px; height: 60px; z-index: 100; background-color: #000000; border: 5px solid #222222'  class='generalinfo_simple'>

</div> ";


if($r['fedjail'])
{
print "<br />


<div class='cmt_tittxt'>&nbsp;</div><div><img src='images/generalinfo_top.jpg' alt='' /></div>

<div class='generalinfo_simple'>

<b><font color=red>In federal jail for {$r['fed_days']} day(s).&nbsp;&nbsp;{$r['fed_reason']}</font></b>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div><br>";
}
if($r['hospital'])
{
print "<br />
<div class='cmt_tittxt'>&nbsp;</div><div><img src='images/generalinfo_top.jpg' alt='' /></div>

<div class='generalinfo_simple'>

<b><font color=red>In hospital for {$r['hospital']} minutes.&nbsp;&nbsp;{$r['hospreason']}</font></b>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div><br>";
}
if($r['jail'])
{
print "<br />
<div class='cmt_tittxt'>&nbsp;</div><div><img src='images/generalinfo_top.jpg' alt='' /></div>

<div class='generalinfo_simple'><b><font color=red>In jail for {$r['jail']} minutes.&nbsp;&nbsp;{$r['jail_reason']}</font></b>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div>";
}






if($ir['user_level'] == 2 || $ir['user_level'] == 3 || $ir['user_level'] == 5)
{
$r['lastiph']=@gethostbyaddr($r['lastip']);
$r['lastiph']=checkblank($r['lastiph']);
$r['lastip_loginh']=@gethostbyaddr($r['lastip_login']);
$r['lastip_loginh']=checkblank($r['lastip_loginh']);
$r['lastip_signuph']=@gethostbyaddr($r['lastip_signup']);
$r['lastip_signuph']=checkblank($r['lastip_signuph']);
print "  <style type='text/css'>
.style1 {   text-align: center;}</style>
<div class='style1'><br>  <br><h2>User Internet Info </div></h3> 

<table width='80%' border='2' cellspacing='1' class='table'>
<tr><td></td><td class='h'>IP</td><td class='h'>Hostname</td></tr>
<tr><td class='h'>Last Hit</td><td>$r[lastip]</td><td>$r[lastiph]</td></tr>
<tr><td class='h'>Last Login</td><td>$r[lastip_login]</td><td>$r[lastip_loginh]</td></tr>
<tr><td class='h'>Signup</td><td>$r[lastip_signup]</td><td>$r[lastip_signuph]</td></tr></table>";
print "<form action='staffnotes.php' method='post'>
Staff Notes: <br />
<textarea rows=4 cols=40 name='staffnotes'>{$r['staffnotes']}</textarea>
<br /><input type='hidden' name='ID' value='{$_GET['u']}' />
<input type='submit' STYLE='color: black;  background-color: white;' value='Change' /></form></div> ";
}



if($ir['user_level'] == 2 || $ir['user_level'] == 3 || $ir['user_level'] == 5)
{


print "


<div class='mem_rightbg2'>  

<div class='useraction_txt'><img src='images/staff_links.gif' alt='' /></div>
<div class='user_imgpart'>
    <div class='user_leftimgpart'>

        <div class='user_rightimg5'> <div align='left'> <a href='jailuser.php?userid={$r['userid']}'>Jail</a></div> </div> 
    </div>
    
    <div class='user_rightimgpart'>
        <div class='user_rightimg5'> <div align='left'> <a href='mailban.php?userid={$r['userid']}'>Mail Ban</a></div> </div> 
        <br>  <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 

    </div>
    
</div>
</div>

</div>        
</div>




<!-- //Member Profile Page End -->
</div>
</div></div>
</div>
</div>
</div>";

} 



print '


<div class="usercmtpart">
<div><img src="images/usercomment_left.jpg" alt="" /></div>
<div class="usercmt_txtpart">
<div class="usercmt_left">Profile Signature</div>
<div class="usercmt_right"></div>
</div>
<div><img src="images/usercomment_right.jpg" alt="" /></div>
</div>    
';


if($r['signature'])
{
print "<br />
<div class='cmt_tittxt'>&nbsp;</div><div><img src='images/generalinfo_top.jpg' alt='' /></div>

<div class='generalinfo_simple'><b><i> <font color=white>{$r['signature']}</font></i> </b>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div> <br/>" ;
}
else
{
print "<br />
<div class='cmt_tittxt'>&nbsp;</div><div><img src='images/generalinfo_top.jpg' alt='' /></div>

<div class='generalinfo_simple'><b><i><font color=white>User Has No Signature</font></i></b>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div><br/>" ;
}



print '


<div class="usercmtpart">
<div><img src="images/usercomment_left.jpg" alt="" /></div>
<div class="usercmt_txtpart">
<div class="usercmt_left">User Comments</div>
<div class="usercmt_right"><a href=Comments.php?ID='.$_GET['u'].' >Add Comment</a></div>
</div>
<div><img src="images/usercomment_right.jpg" alt="" /></div>
</div>    
';



$Data = mysql_query("SELECT g.`ID`,g.`SenderID`,g.`RecieverID`,g.`Comment`,u.`userid`,u.`username` FROM `gComments` g LEFT JOIN `users` u "."ON g.`SenderID` = u.`userid` WHERE (`RecieverID` = ".abs(intval($_GET['u'])).")");
if(!mysql_num_rows($Data))
{

print "<br />
<div class='cmt_tittxt'>&nbsp;</div><div><img src='images/generalinfo_top.jpg' alt='' /></div>

<div class='generalinfo_simple'><b><font color=green>User Has No Comments</font></b>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div>" ;


exit($h->endpage());
}

else
{

while($cData = mysql_fetch_array($Data))
{


print '                          
<div class="cmt_tittxt"><a href=viewuser.php?u='.stripslashes($cData['userid']).'> '.htmlentities($cData['username']).' </a>  says :</div>    
<div class="cmtbox_part"> ';

if($_SESSION['userid'] === $cData['RecieverID'])
{
print'
<div class="cmtbox_top" style="text-indent:400px;"> <a href = "/Comments.php?Delete&ID='.$cData['ID'].'"> Delete Comment </a> </div> ';
} 

else
{
print'
<div class="cmtbox_top" style="text-indent:400px;"> </div> ';
}

print '

<div class="cmtbox_md">
<div class="cmtcontent">'.stripslashes(htmlentities($cData['Comment'], ENT_QUOTES)).' </div>
</div>
<div><img src="images/cmtbox_btm.jpg" alt="" /></div>
</div><br>
<div class="nosign_line"><img src="images/sign_line.jpg" alt="" /> </div> 

';


}

}



if($_SESSION['userid'] === $cData['RecieverID'])
{
echo ('
<td width = "10%" align = "center"> <a href = "/Comments.php?Delete&ID='.$cData['ID'].'"> <span style = "color:#8B0000">Delete</span></a></td>');
}










print "</tr></table>";
}
}
function checkblank($in)
{
if(!$in) { return "N/A"; }
return $in;
}
$h->endpage();
?>
