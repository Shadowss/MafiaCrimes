<?php
include "globals.php";

print"<h3>BBCode Gradient Text Generator</h3>";


function prepareGradien($hexstart, $hexend, $sentence) 
{ 

    $steps = strlen($sentence); 

    $start['r'] = hexdec(substr($hexstart, 0, 2)); 
    $start['g'] = hexdec(substr($hexstart, 2, 2)); 
    $start['b'] = hexdec(substr($hexstart, 4, 2)); 

    $end['r'] = hexdec(substr($hexend, 0, 2)); 
    $end['g'] = hexdec(substr($hexend, 2, 2)); 
    $end['b'] = hexdec(substr($hexend, 4, 2)); 

    $step['r'] = ($start['r'] - $end['r']) / ($steps); 
    $step['g'] = ($start['g'] - $end['g']) / ($steps); 
    $step['b'] = ($start['b'] - $end['b']) / ($steps); 

    $gradien = array(); 
    for($i = 0; $i < $steps; $i++) 
    { 
        $rgb['r'] = floor($start['r'] - ($step['r'] * $i)); 
        $rgb['g'] = floor($start['g'] - ($step['g'] * $i)); 
        $rgb['b'] = floor($start['b'] - ($step['b'] * $i)); 

        $hex['r'] = sprintf('%02x', ($rgb['r'])); 
        $hex['g'] = sprintf('%02x', ($rgb['g'])); 
        $hex['b'] = sprintf('%02x', ($rgb['b'])); 

        $gradien[] = implode(NULL, $hex); 
    } 

    $letters = array(); 
    for($i = 0; $i < $steps; $i++) 
    { 
        $letters[] = $sentence{$i}; 
    } 

    $grad = array(); 
    for($j = 0; $j < $steps; $j++) 
    { 
        $grad[$gradien[$j]] = $letters[$j]; 
    } 

    return $grad; 
} 

function gradien($hexstart, $hexend, $sentence) 
{ 
    $gradien = prepareGradien($hexstart, $hexend, $sentence); 
    foreach($gradien as $key => $value) 
    { 
       
     $value = str_replace('&','&',$value); 
        $value = str_replace('<','<',$value); 
        $value = str_replace('>','>',$value); 
        print"[color=#".$key."]".$value."[/color]"; 
            
    } 
}  


function prepareGradie($hexstart, $hexend, $sentence) 
{ 

    $steps = strlen($sentence); 

    $start['r'] = hexdec(substr($hexstart, 0, 2)); 
    $start['g'] = hexdec(substr($hexstart, 2, 2)); 
    $start['b'] = hexdec(substr($hexstart, 4, 2)); 

    $end['r'] = hexdec(substr($hexend, 0, 2)); 
    $end['g'] = hexdec(substr($hexend, 2, 2)); 
    $end['b'] = hexdec(substr($hexend, 4, 2)); 

    $step['r'] = ($start['r'] - $end['r']) / ($steps); 
    $step['g'] = ($start['g'] - $end['g']) / ($steps); 
    $step['b'] = ($start['b'] - $end['b']) / ($steps); 

    $gradie = array(); 
    for($i = 0; $i < $steps; $i++) 
    { 
        $rgb['r'] = floor($start['r'] - ($step['r'] * $i)); 
        $rgb['g'] = floor($start['g'] - ($step['g'] * $i)); 
        $rgb['b'] = floor($start['b'] - ($step['b'] * $i)); 

        $hex['r'] = sprintf('%02x', ($rgb['r'])); 
        $hex['g'] = sprintf('%02x', ($rgb['g'])); 
        $hex['b'] = sprintf('%02x', ($rgb['b'])); 

        $gradie[] = implode(NULL, $hex); 
    } 

    $letters = array(); 
    for($i = 0; $i < $steps; $i++) 
    { 
        $letters[] = $sentence{$i}; 
    } 

    $grad = array(); 
    for($j = 0; $j < $steps; $j++) 
    { 
        $grad[$gradie[$j]] = $letters[$j]; 
    } 

    return $grad; 
} 

function gradie($hexstart, $hexend, $sentence) 
{ 
    $gradie = prepareGradie($hexstart, $hexend, $sentence); 
    foreach($gradie as $key => $value) 
    { 
       
     $value = str_replace('&','&',$value); 
        $value = str_replace('<','<',$value); 
        $value = str_replace('>','>',$value); 
        print"<b><font color='#".$key."'>".$value."</font></b>"; 
            
    } 
}  









print "<form action='gradient.php' method='post'>
<input type=hidden name=submit value=1>

<select class=textbox name='start'>
<option value='0'>Select Start Color</option>
<option value='ff0000'>Red</option>
<option value='ffffff'>White</option>
<option value='ffff00'>Yellow</option>
<option value='0000ff'>Blue</option>
<option value='FF1493'>Pink</option>
<option value='696969'>Grey</option>
<option value='00ff00'>Lime</option>
<option value='E9967A'>Salmon</option>
<option value='9932CC'>Purple</option>
<option value='FFA500'>Orange</option>
<option value='40E0D0'>Turquoise</option>
</select>

<select class=textbox name='stop'>
<option value='0'>Select End Color</option>
<option value='ff0000'>Red</option>
<option value='ffffff'>White</option>
<option value='ffff00'>Yellow</option>
<option value='0000ff'>Blue</option>
<option value='FF1493'>Pink</option>
<option value='696969'>Grey</option>
<option value='00ff00'>Lime</option>
<option value='E9967A'>Salmon</option>
<option value='9932CC'>Purple</option>
<option value='FFA500'>Orange</option>
<option value='40E0D0'>Turquoise</option>
</select>


<br /><br />

<font color='red'><b>Enter the Text you wish to Convert</b></font><br />
<input type='text' STYLE='color: black;  background-color: white;' name='text' maxlength='40' length='40' /><br /><font color='red'>Maximum of 40 Characters</font><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Convert to BBCode' />
</form><br />";


if($_POST['submit'])
{

if ($_POST['start'] == $_POST['stop']) 
{
print "The Start color and End color cannot be the same";
$h->endpage();
exit;
}

if (strlen($_POST['text']) > 40) 
{
print "Stop trying to abuse the game!!!";
$h->endpage();
exit;
}

if($_POST['text'] == "")
{
print "You did not enter any text.";
}
else
{

print"<textarea rows=5 cols=100>";
gradien($_POST['start'], $_POST['stop'], $_POST['text']);
print"</textarea><br />";

print"<br /><table class='table' width='75%'><tr><th>Your Text will look like this</th></tr><tr><td>";
gradie($_POST['start'], $_POST['stop'], $_POST['text']);
print"</td></tr></table>";
}
}



$h->endpage();
?>