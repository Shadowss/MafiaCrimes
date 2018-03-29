<?php
require_once (dirname (__file__) .'/globals.php');
    $users = $db->query ("SELECT u.`userid`, u.`username`, u.`level`, u.`location`, u.`hp`, u.`gang`, g.`gangname`, g.`gangPREF` FROM `users` u LEFT JOIN `gangs` g ON `gangID` = u.`gang` ");
   echo '
   
   
<div class="generalinfo_txt">
<div><img src="images/info_left.jpg"alt=""/></div>
<div class="info_mid"><h2 style="padding-top:10px;">Attack List</h2></div>
<div><img src="images/info_right.jpg"alt=""/></div> </div>
<div class="generalinfo_simple"><br> <br><br>
   
   
   <table width="100%" class="table">
    <tr>
        <th>Player</th><th>Status</th><th>Level</th><th>Gang</th><th>Options</th>
    </tr>
   ';
               while ($u = $db->fetch_row ($users) ) {
   echo '
        <tr>
            <td>
   ';
   echo ( $u['gang'] != 0 ) ? "[".$u['gangPREF']."]&nbsp;".stripslashes(htmlentities($u['username'], ENT_QUOTES)) : "".stripslashes(htmlentities($u['username'], ENT_QUOTES));
   echo '</td>
            <td>
   ';
   echo ( $u['hp'] <= 1 ) ? "<span style='font-color: red;'>Not Alive</span>" : "<span style='font-color: green;'>Alive</span>";
   echo '</td>
            <td>'.number_format($u['level']).'</td>
            <td>
   ';
   echo ( $u['gang'] != 0 ) ? "<a href='gangs.php?action=gang_view&gang_id=".$u['gang']."'>".stripslashes(htmlentities($u['gangname'], ENT_QUOTES))."</a>" : "<span>No Gang</span>";
   echo '</td>         
            <td>
   ';
   echo ( $u['hp'] <= 1 ) ? "<span style='font-color: #999; text-decoration: line-through;'>Attack</span>" : "<a href='attack.php?ID=".$u['userid']."'><span style='font-color: red;'>Attack</span></a>";
   echo '</td>
        </tr>
   ';
               }
   echo '
</table> </div><div><img src="images/generalinfo_btm.jpg"alt=""/></div><br></div></div></div></div></div>
   ';
   $h->endpage();
?> 