<?php
include "globals.php";


$sql = sprintf("SELECT * FROM search WHERE userid = %d ", $ir['userid']);

$q1 = mysql_query($sql);
if(mysql_num_rows($q1) > 0)
{
$p = $db->fetch_row($q1);



print"

<div class='icolumn2' id='mainContentDiv'>
<div class='searchpage'>
            <div class='search_top'>
                <div class='gymtxt'><img src='images/searchtxt.jpg' align=left alt='' /></div>
                <div class='gym_para'></div>
            </div>
            <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> User Search</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=60% cellspacing=1 class='table' bordercolor='#636363' border='1'><tr><th colspan='2'>User Search</th></tr>

<tr><td colspan='2'><font color=red>*</font> is a required field.<br></td></tr>
<form action=searchdo.php method=POST>
<tr><td>Name: <input type=text STYLE='color: black;  background-color: white;' name=name value={$p['name']}></td>
<td>ID: <input type=text STYLE='color: black;  background-color: white;' name=id  value={$p['id']}></td></tr>
<tr><td colspan='2'>Search by Level</td></tr> 
<tr><td>From: <font color=red>* </font><input type=text STYLE='color: black;  background-color: white;' name=levelmin  value={$p['levelmin']}></td>
 <td>To: <font color=red>*</font> <input type=text STYLE='color: black;  background-color: white;' name=levelmax  value={$p['levelmax']}></td></tr>
 <tr><td colspan='2'>Search by Days Old</td></tr>
 <tr><td>Days Old: From: <input type=text STYLE='color: black;  background-color: white;' name=daysmin  value={$p['daysmin']}></td> 
 <td>To: <input type=text STYLE='color: black;  background-color: white;' name=daysmax value={$p['daysmax']}></td></tr>
 <tr><td colspan='2'>Search by Financial Criteria</td></tr>
<tr><td>Search by Money Greater than:</td> 
<td><font color=red>* </font><font color=green size=4><b>$</b></font><input type=text STYLE='color: black;  background-color: white;' name=moneymin  value={$p['moneymin']}></td></tr>
<tr><td colspan='2'>Misc. Search criteria</td></tr>
<tr><td>Location: <Select name=location type=dropdown value={$p['location']}>    
";

$sq = sprintf("SELECT cityname FROM cities WHERE cityid = %d ", $p['location']);

$q2 = mysql_query($sq);
$v = $db->fetch_row($q2);
print"<option value={$p['location']} >{$v['cityname']}</option>";

$s = sprintf("SELECT cityid, cityname FROM cities WHERE cityid != %d ", $p['location']);

$q = mysql_query($s);


while($r=$db->fetch_row($q))
{ 
print "<option value={$r['cityid']}>{$r['cityname']}</option>";
}


print"</select>  ";



print"

</td><td>Status: 
<select name=online type=dropdown value={$p['online']}>";
if($p['online'] !='online')
{

print"<option value=0>Offline</option><option value=online>Online</option>";
}
else
{

print"<option value=online>Online</option><option value=0>Offline</option>";
}
print"
</select></td>
</tr>";

print"


<tr><td colspan='2'><br /><input type='submit' STYLE='color: black;  background-color: white;' name='search' value='Search'>     <input type='submit' STYLE='color: black;  background-color: white;' name='save' value='Search and Save'>     <input type='submit' STYLE='color: black;  background-color: white;' name='clear' value='Clear Saved Search'></form></td></tr></table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";

}

else
{
print"

<div class='icolumn2' id='mainContentDiv'>
<div class='searchpage'>
            <div class='search_top'>
                <div class='gymtxt'><img src='images/searchtxt.jpg' alt='' /></div>
                <div class='gym_para'></div>
            </div>
            <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> User Search</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=60% cellspacing=1 class='table' bordercolor='#636363' border='1'><tr><th colspan='2'></th></tr>

<tr><td colspan='2'><font color=red>*</font> is a required field.<br></td></tr>
<form action=searchdo.php method=POST>
<tr><td>Name: <input type=text STYLE='color: black;  background-color: white;' name=name></td>
<td>ID: <input type=text STYLE='color: black;  background-color: white;' name=id></td></tr>
<tr><td colspan='2'>Search by Level</td></tr> 
<tr><td>From: <font color=red>* </font><input type=text STYLE='color: black;  background-color: white;' name=levelmin value=1></td>
 <td>To: <font color=red>*</font> <input type=text STYLE='color: black;  background-color: white;' name=levelmax value=500></td></tr>
 <tr><td colspan='2'>Search by Days Old</td></tr>
 <tr><td>Days Old: From: <input type=text STYLE='color: black;  background-color: white;' name=daysmin></td> 
 <td>To: <input type=text STYLE='color: black;  background-color: white;' name=daysmax></td></tr>
 <tr><td colspan='2'>Search by Financial Criteria</td></tr>
<tr><td>Search by Money Greater than:</td> 
<td><font color=red>* </font><font color=green size=4><b>$</b></font><input type=text STYLE='color: black;  background-color: white;' name=moneymin value=1></td></tr>
<tr><td colspan='2'>Misc. Search criteria</td></tr>
<tr><td>Location: <Select name=location type=dropdown>";
print"<option value=0 selected >select</option>";
$q=$db->query("Select * from cities");
while($r=$db->fetch_row($q))
{ 
print "<option value={$r['cityid']}>{$r['cityname']}</option>";
}


print"</select>  



</td><td>Status: 
 
<select name=online type=dropdown>
<option value=0 selected>Offline</option>
<option value=online>Online</option></select></td>
</tr>


<tr><td colspan='2'><br /><input type='submit' STYLE='color: black;  background-color: white;' name='search' value='Search'>     <input type='submit' STYLE='color: black;  background-color: white;' name='save' value='Search and Save'>     <input type='submit' STYLE='color: black;  background-color: white;' name='clear' value='Clear Saved Search'></form></td></tr></table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}


?>