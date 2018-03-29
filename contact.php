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

require "core.php"; 
print <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>{$set['game_name']} - $metacu </title>
<meta name="keywords" content="RPG, Online Games, Online Mafia Game" />
<meta name="description" content=" {$set['game_name']} - Online Mafia Game " />
<meta name="author" content="Mafia Crimes" />
<meta name="copyright" content="Copyright {$_SERVER['HTTP_HOST']} " />
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link rel="stylesheet" href="css/stylenew.css" type="text/css" />
<link rel='stylesheet' href='css/lightbox.css' type='text/css' media='screen' />
<!--<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>-->

</head>
<body>
    <div id="pagecontainer">
        <!-- Header Part Starts -->
            <div class="headerpart">
                <div ></div>
                <div class="toplist">
                                   
                </div>
            </div>
            <!--<script language="JavaScript" type="text/javascript">
            function countd(){
                var wesinurodz= new Date("10/15/2009 13:30:00");
                var wesinnow = new Date();
                var wesinile = wesinurodz.getTime() - wesinnow.getTime();
                var nday = Math.floor(wesinile / 86400000);
                if(nday<=0){nday=0;}
                var nhor = Math.floor((wesinile-nday*86400000)/3600000);
                if(nhor<=0){nhor=0;}
                var nmin = Math.floor((wesinile-nday*86400000-nhor*3600000)/60000);
                if(nmin<=0){nmin=0;}
                var nsec = Math.floor((wesinile-nday*86400000-nhor*3600000-nmin*60000)/1000);
                if(nsec<=0){nsec=0;}
                var ttttt = nday+' days '+nhor+' hours '+nmin+' minutes '+nsec+' seconds';
                document.getElementById('countdown').innerHTML = ttttt;  
            }
            setInterval("countd()",200);
            </script>
            -->
            
  
  
  <script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_nbGroup(event, grpName) { //v6.0
  var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])? args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) {
      img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr)
      for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}
//-->
</script>
  
            
            
            
        <!-- //Header Part End -->        
        <!-- Flash Part Starts -->

            <div class="flashpart">
              <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="1000" height="460" title="Mafia Crimes">
                <param name="movie" value="images/mafia.swf" />
                <param name="quality" value="high" />
                <param name="wmode" value="Transparent" />
                <embed src="images/mafia.swf" quality="high"  wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="1000" height="460"></embed>
              </object>
            </div>
        <!-- //Falsh Part End -->
        
        <div class="menu">
                <ul>
                    <li class="home_active"><a href="login.php" title="Home">&nbsp;</a></li>
                    <li class="story"><a href="story.php" title="The Story">&nbsp;</a></li>
                    <li class="contact"><a href="contact.php" title="Contact Us">&nbsp;</a></li>
                    <li class="signup"><a href="signup.php" title="Sign Up">&nbsp;</a></li>
                </ul>            
            </div>

        <!-- Menu Part End -->
        
        
        <!-- Center Part Starts -->
            <div class="centerpart">
                <div class="column1">                    
                        <div class="col1_top"><img src="images/col1_top.gif" alt="" /></div>
                        
                            <div class="welpart">
<div class="column1_left" style="width:520px;">
                                <div id="story1">
<p style="width:520px;line-height:18px;">

Contact Us Page

</p>

<br /><br />  <br /><br />  <br /><br />  <br /><br />  <br /><br />  
<br /><br />  <br /><br />  <br /><br />  <br /><br /> <br /> 

</div>


    </div>
                            
    </div>                    

                        <div class="col1_btm"><img src="images/col1_btm.jpg" alt="Bottom" /></div>                                
                </div>
                
                <div class="column2">
                     <form method="post" action="authenticate.php" name="loginform" id="loginform">

                    <p>Username :<span></span>Password :</p>
                    <div class="formpart">
                            <div class="uname_box"><input type="text" name="username" id="uname" /></div>
                            <div class="uname_box"><input type="password" name="password" id="upass" style="margin-left:7px;"/></div>
                            <div class="loginbtn"><input type="submit" value="Login" title="Login" /></div>            
                    </div>

                    
                    <div class="userchoice">
                        <div class="server">
                        </div>
                        <div class="forgot_txt"><input type="checkbox" name="remember" value="1" > Remember &nbsp; <a href="forgot.php" title="Forgot password ?">Forgot password ?</a></div>

                    </div>
                    </form>
                    

  <div class="redbg">
<div class="red_txt1">Total Mobsters:&nbsp;&nbsp;<span> $membs</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Online Now: <span> $online</span>&nbsp;</div>
<table width='180' border='0' cellspacing='0' cellpadding='0'>
<tr>&nbsp;&nbsp;
<style type='text/css'>
.style1 {
text-align: center;
}
</style>

<div class='style1'>
<h3><u>$gameinfo</h3></u><br>
$players $membs <br>
$mal $male <br>
$fems $fem</div> <br /></td></tr>
</table> <br/>
                
<div align="center"><a href="signup.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('signup','','images/createaccount_over.gif',1)"><img src="images/createaccount.gif" name="signup" width="254" height="90" border="0" id="signup" /></a><br />
</div> </div> </div></div> </div> </div> <div class="clear"></div>



 <!--  Do Not Remove Powered By Ravan Scripts without permission .
              
However, if you would like to use the script without the powered by links you may do so by purchasing a Copyright removal license for a very low fee.   -->


EOF;
$IP = $IP = $_SERVER['REMOTE_ADDR'];

if(file_exists('ipbans/'.$IP))
{
die("<b><font color=red size=+1>$ipban</font></b></body></html>");
}
$year=date('Y');




OUT;

include "lfooter.php";  

?>


