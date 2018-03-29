<? 
require('poker_includes/gen_inc.php'); 
require('poker_includes/inc_sitout.php'); 
?>
<html>
<head>
<title><? echo TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/poker.css" type="text/css">
<script language="JavaScript" type="text/JavaScript" >
function countdown(passcount){
if(passcount > 0){
document.getElementById('sitout').innerHTML = '<font color="black" size="4"><b>'+passcount+'</b></font>';
passcount = (passcount-1);
var e = passcount;
setTimeout(function(){countdown(passcount)},1000);
}else{
parent.document.location.href = "lobby.php"; 
}
}
</script>
</head>

<body bgcolor="#000000" text="#CCCCCC" onLoad="countdown('<? echo $start; ?>');">
<table width="772" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#1B1B1B">
  <tr> 
    <td valign="top" bgcolor="#333333"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr> 
          <td> 
            <? require('includes/scores.php'); ?>
          </td>
        </tr>
        <tr> 
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="10">
              <tr>
                <td class="fieldsethead" align="center"><b> 
                  <? echo SITOUT_TIMER; ?>
                  </b></td>
              </tr>
              <tr>
                <td>
                  <div align="center">
                    <table width="60%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFFF99">
                      <tr>
                        <td align="center">
                          <div id="sitout"><font face="Verdana, Arial, Helvetica, sans-serif" size="6"></font></div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td width="650" class="fieldsethead" valign="top" height="100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td bgcolor="#333333"><b><font size="3"><i><? echo SITOUT; ?></i></font></b></td>
        </tr>
      </table>
      <b><font size="3"><br>
      </font></b> 
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="25" bgcolor="#333333">
              <tr>
                <td>
                  <div align="center"><font size="7">YOUR BANNER HERE</font></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td> 
            <table width="100%" border="0" cellspacing="0" cellpadding="25" bgcolor="#666666">
              <tr> 
                <td> 
                  <div align="center"><font size="7">YOUR BANNER HERE</font></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td> 
            <table width="100%" border="0" cellspacing="0" cellpadding="25" bgcolor="#333333">
              <tr> 
                <td> 
                  <div align="center"><font size="7">YOUR BANNER HERE</font></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td> 
            <table width="100%" border="0" cellspacing="0" cellpadding="25" bgcolor="#666666">
              <tr> 
                <td> 
                  <div align="center"><font size="7">YOUR BANNER HERE</font></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <b><font size="3"> </font></b><br>
    </td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
