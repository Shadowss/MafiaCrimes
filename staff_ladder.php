<?php
include_once (DIRNAME(__FILE__) . '/sglobals.php');

if($ir['user_level'] != '2') 
{
    echo '<font color="#FF0000>403 - Unauthorized Access</font>';
    $h->endpage();
    exit;
}

$_GET['act'] = isset($_GET['act']) && is_string($_GET['act']) ? trim($_GET['act']) : "";
switch($_GET['act'])
{
    case 'CreateLadder': 
    CreateLadder(); 
    break;
    
    case 'DeleteLadder': 
    DeleteLadder(); 
    break;
    
    default:
    echo '<font color="#FF0000>This form requires an action</font>';
    break;
}


function CreateLadder()
{
    global $db, $c, $h;
    
    if(isset($_POST['NAME']) AND isset($_POST['LEVEL']))
    {
        if(strlen($_POST['NAME']) < '5')
        {
            echo 'Sorry, The Battle Lader Name Is Too Short.<br />
            <a href="'.$_SERVER['PHP_SELF'].'">Back</a>';
            $h->endpage();
            exit;
        }
        $Get = $db->query(sprintf("SELECT `ladderName` FROM `battle_ladders` WHERE `ladderName`='%s'", addslashes($_POST['NAME'])));
        
        if($db->num_rows($Get))
        {
            echo 'Sorry, You Can\'t Have Two Battle Ladders With The Same Name.';
            $h->endpage();
            exit;
        }
        
        $db->query(sprintf("INSERT INTO `battle_ladders` (`ladderName`, `ladderLevel`) VALUES ('%s', '%u')", addslashes($_POST['NAME']), abs(@intval($_POST['LEVEL']))));
        echo 'Battle Ladder ('.addslashes($_POST['NAME']).') Added!<br />
        > <a href="'.$_SERVER['PHP_SELF'].'?act=CreateLadder">Create Another!</a><br />
        > <a href="staff.php">Back To Staff Index</a>';
        stafflog_add('Created A Battle Ladder ('.addslashes($_POST['NAME']).')');
        $h->endpage();
        exit;
    }
    else
    {
        echo '
        
<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Adding A Battle Ladder...</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

            <form action="'.$_SERVER['PHP_SELF'].'?act=CreateLadder" method="post">
            <table class="table">
                <tr>
                    <th>Ladder Name:</th>
                    <td><input type="text" STYLE="color: black;  background-color: white;" name="NAME"></td>
                </tr>
                <tr>
                    <th>Ladder Level:</th>
                    <td><input type="text" STYLE="color: black;  background-color: white;" name="LEVEL"></td>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" STYLE="color: black;  background-color: white;" value="Add Battle Ladder!" /></th>
                </tr>
            </table>
</form>  </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>
';
    }
}

function DeleteLadder()
{
    global $db, $c, $h;
    
    if (isset($_POST['Ladder']))
    {
        $Ladder = $db->fetch_row($db->query(sprintf("SELECT `ladderId`, `ladderName` FROM `battle_ladders` WHERE `ladderId` = '%u'", @intval($_POST['Ladder']))));
        $db->query(sprintf("DELETE FROM `battle_members` WHERE `bmemberLadder`='%u'", $Ladder['ladderId']));
        $db->query(sprintf("DELETE FROM `battle_ladders` WHERE `ladderId`='%u'", $Ladder['ladderId']));
        
        echo 'Ladder Deleted!<br />
        > <a href="'.$_SERVER['PHP_SELF'].'?act=DeleteLadder">Delete Another!</a><br />
        > <a href="staff.php">Back To Staff Index</a>';
        stafflog_add('Deleted Battle Ladder ('.$Ladder['ladderName'].')');
        $h->endpage();
        exit;
        
    }
    else
    {
        echo '
        
<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Delete Battle Ladder</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

        
        
        Deleting A Ladder Is Permanent!<br />
        Any Users On This Battle Ladder Will Be Taken Off.<br /><br />
        <form action="'.$_SERVER['PHP_SELF'].'?act=DeleteLadder" method="post">
            <table class ="table">
                <tr>
                    <td>Ladder:</td>
                    <td>'.ladder_dropdown('Ladder').'</td>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" STYLE="color: black;  background-color: white;" value="Delete Ladder!" /></th>
                </tr>
            </table>

        </form> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>
';
    }
}

$h->endpage();
?>