<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr> 
          <td class="tiny" valign="top" align="center"> 
            <? $staq = mysql_query("select player, winpot from ".DB_STATS." order by winpot desc"); $i=1; while( ($star = mysql_fetch_array($staq)) && ($i < 7)){ $prefix = $i.PLACE_POSI; if($i == 1) $prefix = $i.PLACE_POSI_1; if($i == 2) $prefix = $i.PLACE_POSI_2; if($i == 3) $prefix = $i.PLACE_POSI_3; $name = $star['player']; $win = money_small($star['winpot']); $ava = display_ava($name); echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tiny"><tr><td width="44">'.$ava.'</td><td><b><font color="#FFCC33">'.$prefix.' '.PLACE.'<br></font>'.$name.'</b> <br>'.$win.'</td></tr></table>'; $i++; } ?>
          </td>
</tr>
</table>