<?php

if($ir['traveltime'] > 0)
{
    print"<center><p style='color: red;font-weight: bold;font-size: 2' />You are travelling for {$ir['traveltime']} minutes. Please wait until you arrive at your destination to access this page.</font>    </center> <br />
";
  exit;
}

?>