<?php

include "globals.php";
include "travellingglobals.php";

switch($_GET['action'])
{
case "pickcity": pickcity(); break;
case "travel": travel(); break;
default: index(); break;
}
function index()
{
global $db, $ir, $c, $h, $set, $userid;
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg"alt=""/></div>
<div class="info_mid"><h2 style="padding-top:10px;"> <h3>Welcome to the '.$set['game_name'].' Travel Center<br /> </h3></div>
<div><img src="images/info_right.jpg"alt=""/></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<h3>How would you like to travel today?</h3>
    
<table width="90%" class="table"><tr><th colspan="3">Choose your preferred method of travel from the options below. Please be aware that different modes of travel have different costs and the travel times will vary.</th></tr>
<th>Plane</th><th>Train</th><th>Automobile</th>
<tr>
<td><image src="/images/jet.jpg" width="180" height="150"></td>
<td><image src="/images/train.jpg" width="180" height="150"></td>
<td><image src="/images/car.jpg" width="180" height="150"></td>
</tr>
<tr><form action="travel.php?action=pickcity" method="post">
<td><input type="radio" name="traveltype" value="Plane" /> Travel By Plane </td>
<td><input type="radio" name="traveltype" value="Train" /> Travel By Train </td>
<td><input type="radio" name="traveltype" value="Automobile" /> Travel By Automobile </td>
</tr>
<tr><td colspan="3"><input type="submit" STYLE="color: black;  background-color: white;" value="Pick City" />
</table></div><div><img src="images/generalinfo_btm.jpg"alt=""/></div><br></div></div></div></div></div>';

}
function pickcity()
{ 
    $traveltype = htmlentities(mysql_real_escape_string($_POST['traveltype'])); 
    
global $db, $ir, $c, $h, $userid;  
if(!$traveltype)
{
die ('<h2>ERROR</h2>
You must choose a travel type. <br />
<a href=travel.php>> Back</a>');
$h->endpage();
exit;
}  
else

if(!$_GET['to'])
{
    $city = sprintf
(
        "SELECT * FROM cities WHERE cityid = '%u' ",
        abs(@intval($ir['location']))
);
        
        $c = $db->query($city);
        
            $r = $db->fetch_row($c);
    

$cost=3000;
$type=($_POST['traveltype']);
if ($traveltype == Plane)
{
$rantime=($r['citytravtime']);
$cost=$cost*8;
$go=fly;
//since the travel type is by plane then the cost would be higher but the travel time would be less significant.
}
else
if ($traveltype == Train)
{
$rantime=($r['citytravtime']*2);
$cost=$cost*5;
$go=ride;
//since the travel type is by train then the cost would be less but the travel time would be a little longer.
}
else
if ($traveltype == Automobile)
{
$rantime=($r['citytravtime']*4);
$cost=$cost;
$go=drive;
//since the travel type is by car then the cost would be normal cost but the travel time would be even greater than the other types.
}

$check = sprintf
(
        "SELECT * FROM cities WHERE cityid != '%u' AND cityminlevel <= '%u' ",
        
        abs(@intval($ir['location'])),
        abs(@intval($ir['level']))
);
        $citycheck = $db->query($check);
        

echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg"alt=""/></div>
<div class="info_mid"><h4 style="padding-top:10px;"> You have chosen to travel by '.$traveltype.'. </h4></div>
<div><img src="images/info_right.jpg"alt=""/></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<h4><font color="#ff0000"><font color="#ffffff"> You are currently exploring <font color="#339966">'.$r['cityname'].' </h4> </font><br /> 

 <h4> Where would you like to '.$go.' today? </h4> <br />
 
 <h4> Ticket Cost: <font color="red">$'.$cost.' </font></h4>   <br />
 
   

<table width="90%" cellspacing="1" class="table"><tr><th>City</th><th>Description</th><th>Min Level</th><th>Time Taken</th><th>Travel</th></tr>';


while($r=$db->fetch_row($citycheck))

 { 
     
if ($traveltype == Plane)
{
$rs=($r['citytravtime']);    

echo '
<tr>
<td>'.$r['cityname'].'</td>
<td>'.$r['citydesc'].'</td>
<td>'.$r['cityminlevel'].'</td>  
<td>'.$rs.' min</td>  
<td><a href="travel.php?action=travel&to='.$r['cityid'].'&type='.$type.'">Go</a></td></tr>';

}

else
if ($traveltype == Train)
{
$rs=($r['citytravtime']*2); 

echo '
<tr>
<td>'.$r['cityname'].'</td>
<td>'.$r['citydesc'].'</td>
<td>'.$r['cityminlevel'].'</td>  
<td>'.$rs.' min</td>  
<td><a href="travel.php?action=travel&to='.$r['cityid'].'&type='.$type.'">Go</a></td></tr>';

}
else
if ($traveltype == Automobile)
{
$rs=($r['citytravtime']*4); 


echo '
<tr>
<td>'.$r['cityname'].'</td>
<td>'.$r['citydesc'].'</td>
<td>'.$r['cityminlevel'].'</td>  
<td>'.$rs.' min</td>  
<td><a href="travel.php?action=travel&to='.$r['cityid'].'&type='.$type.'">Go</a></td></tr>';

}

   
}  


    


echo '</table> <br/>


</div><div><img src="images/generalinfo_btm.jpg"alt=""/></div><br></div></div></div></div></div>';
}
}

function travel()
{
global $db, $ir, $c, $h, $userid;
$_GET['to'] = abs((int) $_GET['to']);
$_GET['type'] = htmlentities(mysql_real_escape_string($_GET['type'])); 
$cost = abs((int) $cost);

if($ir['money'] < $cost)
{
die ('<h2>ERROR</h2>
You dont have enough money.');
$h->endpage();
exit;
}
else if( ((int) $_GET['to']) != $_GET['to'])
{
die('<h2>ERROR</h2>
Just where in the hell are you trying to go??');
$h->endpage();
exit;
}
else
{        
    
    $check2 = sprintf
(
        "SELECT * FROM cities WHERE cityid = '%u' AND cityminlevel <= '%u' ",
        
        abs(@intval($ir['location'])),
        abs(@intval($ir['level'])),
        abs(@intval($ir['level']))
);
        $citycheck2 = $db->query($check2);
        
        
$q=$db->query("SELECT * FROM cities WHERE cityid = {$_GET['to']} AND cityminlevel <= {$ir['level']}");       
        
if($ir['money'] < $cost)
{
die ('<h2>ERROR</h2>
You dont have enough money.');
$h->endpage();
exit;
}
else if( ((int) $_GET['to']) != $_GET['to'])
{
die('<h2>ERROR</h2>
Just where in the hell are you trying to go??');
$h->endpage();
exit;
}               

else if(!$db->num_rows($q))
{
print "<h2>ERROR</h2> <br/> This city either does not exist or you cannot go there.";
$h->endpage();
exit;

}

else
{
$r=$db->fetch_row($q);

$cost=3000;
$type=($_GET['type']);
if ($_GET['type'] == Plane)
{
$rantime=($r['citytravtime']);
$tcost=$cost*8;
//since the travel type is by plane then the cost would be higher but the travel time would be less significant.
}
else
if ($_GET['type'] == Train)
{
$rantime=($r['citytravtime']*2);
$tcost=$cost*5;
//since the travel type is by train then the cost would be less but the travel time would be a little longer.
}
else
if ($_GET['type'] == Automobile)
{
$rantime=($r['citytravtime']*4);
$tcost=$cost;
//since the travel type is by car then the cost would be normal cost but the travel time would be even greater than the other types.
}


if($ir['money'] < $tcost)
{
die ('<h2>ERROR</h2>
You dont have enough money.');
$h->endpage();
exit;
}

else if( ((int) $_GET['to']) != $_GET['to'])
{
die('<h2>ERROR</h2>
Just where in the hell are you trying to go??');
$h->endpage();
exit;
}

else if($ir['level'] <  $r['cityminlevel'] )
{
print "<h2>ERROR</h2> <br/> Your level is too low to go there !";
$h->endpage();
exit;

}

else if(!$db->num_rows($q))
{
print "<h2>ERROR</h2> <br/> This city either does not exist or you cannot go there.";
$h->endpage();
exit;

}



$travel = sprintf
(
        "UPDATE users SET `money` = `money` - '%d' , `location` = '%d' , `traveltime` = '%d' WHERE `userid` =  '%u' ", 
        
        abs(@intval($tcost)),
        abs(@intval($_GET['to'])),
        abs(@intval($rantime)),        
        abs(@intval($userid))
);
        $send = $db->query($travel);

echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg"alt=""/></div>
<div class="info_mid"><h2 style="padding-top:10px;"> <h3>Congratulations<br /> </h3></div>
<div><img src="images/info_right.jpg"alt=""/></div> </div>
<div class="generalinfo_simple"><br> <br><br>

Congratulations, you paid '.$tcost.' and start travelling ! It will take '.$rantime.' minutes to arrive.</div><div><img src="images/generalinfo_btm.jpg"alt=""/></div><br></div></div></div></div></div>';
}
}
}
$h->endpage();
?>