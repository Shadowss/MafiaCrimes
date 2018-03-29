<?php
include "globals.php";

if($ir['energy'] < 10)
{
  die("Sorry, it costs 10 energy to Arson a Home. You only have {$ir['energy']} energy. Come back later.");
}

if($ir['jail'] or $ir['hospital'])
{
  die("You cannot Burn a House while in jail or hospital.");
}
    

switch($_GET['action'])
{
    case 'search': search(); break;
    case 'searchsub': search_sub(); break;
    case 'pourpetrol': pour_petrol(); break;
    case 'burn': burn(); break;
    default: index(); break;
}


function index()
{
    global $db,$ir,$userid;
    
    $_GET['ID'] = abs((int) $_GET['ID']);
    $r = $db->fetch_row($db->query("SELECT * FROM `users` WHERE `userid` = {$_GET['ID']}"));
    
    $cost = ($r['level'] * 2000);
    
    if(!$r['userid'])
    {
        die("Invalid User");
    }
    else
    {
        print "
        
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Burn House</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
        
        Would you like to burn down {$r['username']}'s home for \$$t".money_formatter($cost,'')."? <br /> <br />
    
        <form action = 'burnhouse.php?action=pourpetrol&ID={$_GET['ID']}' method = 'post' />
        <input type = 'submit' STYLE='color: black;  background-color: red;' value = 'YES' /> </form>  <br>    
    
        <form action = 'index.php' method = 'post' />
        <input type = 'submit' STYLE='color: black;  background-color: green;' value = 'NO WAY' /> </form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
    }
}


function pour_petrol()
{
    global $db,$ir,$userid;
    
    $_GET['ID'] = abs((int) $_GET['ID']);
    $r=$db->fetch_row($db->query("SELECT * FROM `users` WHERE `userid` = {$_GET['ID']}"));
    
    $cost = ($r['level'] * 200);
    
    if($_GET['ID'] == $userid)
    {
          die("Only the Crazy Burn their own homes down.");
    }
    
    if(!$r['userid'])
    {
          die("Invalid user");
    }
    
    if($ir['money'] < $cost)
    {
        die("You don't have enough money. <a href = 'bank.php' />Go Here</a> to get some more.");
    }
    
    if($ir['petrol'] == 0)
    {
        die("You can't burn down {$r['username']}'s house when you don't have any petrol. Search for some <a href = 'burnhouse.php?action=search' />HERE</a>.");
    }
    else
    {
        print "
        
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Burn House</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
        
        You pour petrol all over {$r['username']}'s furniture and walls. After emptying a three-gallon carton of petrol, you pull out your matchbox. Do you pull out a match and light it? <br /> <br />
        
        <form action = 'burnhouse.php?action=burn&ID={$_GET['ID']}' method = 'post' />
        <input type = 'submit' STYLE='color: black;  background-color: white;' value = 'Light Match' /> </form> <br>      
        
        <form action = 'index.php' method = 'post' />
        <input type = 'submit' STYLE='color: black;  background-color: white;' value = 'No, Go Home' /> </form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
    }
}
    
    
function burn()
{
    global $db,$ir,$userid;
    
    if($_GET['ID'] == $userid)
    {
        die("Only the crazy burn down their own home down.");
    }
    
    $_GET['ID'] = abs((int) $_GET['ID']);
    $r = $db->fetch_row($db->query("SELECT * FROM `users` WHERE `userid` = {$_GET['ID']}"));
    
    if(!$r['userid'])
    {
        die("Invalid User");
    }
    
    if($ir['petrol'] == 0)
    {
        die("You don't have any petrol to burn down the house. Go <a href = 'burnhouse.php?action=search' />HERE</a> to find some more.");
    }
    
    elseif($ir['matches'] == 0)
    {
        die("You open the box of matches and see there's none inside. You'll have to get some more. Go <a href = 'burnhouse.php?action=search' />HERE</a> to get some more.");
    }
    else
    {
        $mult = $r['level'] * $r['level'];
        $chance = min(($ir['crimexp']/$mult) * 50+1, 95);
        $harm = rand(1,200);
        $cost = ($ir['level'] * 200);
        
        if(rand(1,210) < $chance AND $harm < 190)
        {
             $gain=$r['level']*5;
             
              print "You light the match, drop it and run outside. You successfully burned {$r['username']} 's Home Down.<br /> <br />
              > <a href='index.php'>Run Home</a>";
              
              $db->query(sprintf("UPDATE `users` SET `crimexp` = `crimexp` + '%d',
                                 `petrol` = `petrol` - '%d',
                                 `matches` = `matches` - '%d',
                                 `money` = `money` - '%d'
                                 WHERE `userid` = ('%u')",
                                 $gain, 1, 1, $cost, $userid));
                                 
              $db->query(sprintf("UPDATE `users` SET `will` = 0
                                 WHERE `userid` = {$r['userid']}"));
                                                                 
              $db->query(sprintf("UPDATE `users` SET `jail` = 0
                                 WHERE `userid` = {$r['userid']}"));
                                                                  
              event_add($r['userid'], "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> Burned your House down. You lost all of your will and was let out of Jail if you were in jail. Click <a href='burnhouse.php?action=pourpetrol&ID={$userid}'>here</a> to Arson their Home.", $c);
        }
        
        elseif(rand(1,210) < $chance AND $harm > 190)
        {
                $gain=$r['level']*5;
                $hosp = rand(300,500);
             
                  print "You light the match and drop it, not noticing you have petrol on your shoes and jeans. As the match hits the floor, the room goes aflame but so do you. You successfully burned {$r['username']} 's Home Down but go into hospital for $hosp minutes with severe burns. <br /> <br />
                  > <a href='index.php'>Go to Hospital</a>";
              
                  $db->query(sprintf("UPDATE `users` SET `crimexp` = `crimexp` + '%d',
                                        `hospital` = '%d',
                                        `hospreason` = 'Caught alight when burning down a house',
                                        `petrol` = `petrol` - '%d',
                                        `matches` = `matches` - '%d',
                                        `money` = `money` - '%d'
                                        WHERE `userid` = ('%u')",
                                        $gain, $hosp, 1, 1, $cost, $userid));
                                 
                  $db->query(sprintf("UPDATE `users` SET `will` = 0
                                        WHERE `userid` = {$r['userid']}"));
                                
                  $db->query(sprintf("UPDATE `users` SET `jail` = 0
                                        WHERE `userid` = {$r['userid']}"));
                                 
                  event_add($r['userid'], "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> Burned your House down. You lost all of your will and was let out of Jail if you were in jail. They also went into hospital for setting themselves alight. Click <a href='burnhouse.php?action=pourpetrol&ID={$userid}'>here</a> to Arson their Home.", $c);
            
        }
        
        elseif(rand(1,210) > $chance AND $harm < 190)
        {
            $jailtime = min($mult, 100);
            $hospital = min(rand(60,200), 75);
            
            print "You light the match and drop it. You run outside and bump straight into a police officer, who wrestles you to the floor. After cuffing you, he calls the fire department who arrive in 5 minutes. They put the fire out before too much damage is caused. You go to jail for $jailtime minutes and {$r['username']} goes to hospital for $hospital minutes with a few burns. <br /> <br />
            > <a href = 'jail.php' />Go to Jail</a>";
            
            $db->query(sprintf("UPDATE `users` SET `jail` = '%d',
                               `jail_reason` = 'Ran into a cop after attempting to arson a house',
                               `money` = `money` - '%d',
                               `matches` = `matches` - '%d',
                               `petrol` = `petrol` - '%d'
                               WHERE `userid` = ('%u')",
                               $jailtime, $cost, 1, 1, $userid));
                               
            $db->query(sprintf("UPDATE `users` SET `hospital` = `hospital` + '%d',
                                  `hospreason` = 'Got burnt when their house was arsoned'
                                  WHERE `userid` = {$r['userid']}",
                                  $hospital));
                                  
            event_add($r['userid'], "<a href = 'viewuser.php?u={$ir['userid']}' />{$ir['username']}</a> ran into a cop after attempting to arson your house. He went to jail but you also went into hospital with some burns.", $c);
        }
        
        elseif(rand(1,210) > $chance AND $harm > 190)
        {
            $jailtime = min($mult, 100);
            $hospital = min(rand(60,200), 75);
            $cost = ($r['level'] * 200);
            
            print "You light the match and drop it on the floor. As you run for the door, you trip on the carpet and fall face first into a bookshell. You're engulfed by the flames. As you scream for help, you hear sirens in the distance. 10 minutes later, you're pulled from the house with burns all over your body. You're taken to the hospital. When there, your ward is surrounded by cops, ready to take you to jail when you get better. However, you successfully burned down {$r['username']}'s house!<br /> <br />
            > <a href = 'jail.php' />Go to Jail</a>       > <a href = 'hospital.php' />Go to Hospital</a>";
            
            $db->query(sprintf("UPDATE `users` SET `jail` = '%d',
                               `jail_reason` = 'Got caught arsoning a house',
                               `hospital` = '%d',
                               `hospreason` = 'Got burnt when arsoning a house',
                               `money` = `money` - '%d',
                               `matches` = `matches` - '%d',
                               `petrol` = `petrol` - '%d'
                               WHERE `userid` = ('%u')",
                               $jailtime, $hospital, $cost, 1, 1, $userid));
                               
            $db->query(sprintf("UPDATE `users` SET `jail` = '%d',
                               `will` = '%d'
                               WHERE `userid` = {$r['userid']}",
                               0, 0));
        }                      
            
        elseif(rand(1,210) > $chance)
            {
                  print "While trying Arson the House you were seen buy a Cop. Before you could light the match, the cops bursts into the house and tackles you to the floor. He arrests you and takes you to jail. Unlucky!!<br /> <br />
                  > <a href='jail.php'>Go to Jail</a>";
              
                  $time=min($mult, 100);
              
                  $db->query(sprintf("UPDATE `users` SET `jail` = '%d',
                                        `jail_reason` = 'Caught trying to Burn Down the Home of {$r['username']}',
                                        `petrol` = `petrol` - '%d',
                                        `money` = `money` - '%d'
                                        WHERE `userid` = ('%u')",
                                        $time, 1, $cost, $userid));
                                 
                  event_add($r['userid'], "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> was caught trying to Burn your house down.", $c);
            }
        
        else
        {
            print "You chicken out before you light the match. You quickly run out of the house and run home. You lose a gallon of petrol. <br /> <br />
            
            > <a href = 'index.php' />Go Home</a>";
            
            $db->query(sprintf("UPDATE `users` SET `petrol` = `petrol` - '%d'
                               WHERE `userid` = ('%d')",
                               1, $userid));
                               
        }
    }
}


function search()
{
    global $db,$ir,$userid;
    
    if($ir['warehouse'] == 5)
    {
        die("You've already searched the warehouse 5 times today. You're too tired to search it again. Come back tomorrow. <a href = 'index.php' />Go Home</a>");
    }
    else
    {
        print "<h3 />Search for Petrol/Matches</h3> <br /> <br />
    
        You head over to an abandoned warehouse and have a look at it. Do you want to break in and search for petrol and matches? <br /> <br />
    
        <form action = 'burnhouse.php?action=searchsub' method = 'post' />
        <input type = 'submit' STYLE='color: black;  background-color: white;' value = 'Break In' /> </form>  <br>    
    
        <form action = 'index.php' method = 'post' />
        <input type = 'submit' STYLE='color: black;  background-color: white;' value = 'Go Home' /> </form>";
    }
}


function search_sub()
{
    global $db,$ir,$userid;
    
    $search = rand(1,4);
    $cash = rand(200,800);
    $matches = rand(2,6);
    $petrol = rand(1,4);
    $jtime = rand(65,100);
    $pet = rand(6,8);
    $mat = rand(6,10);
    $big = rand(800,1000);
    
    if($ir['warehouse'] == 5)
    {
        die("You've already searched here 5 times and are too tired to search again. Come back tomorrow. <a href = 'index.php' />Go Home</a>");
    }
    else
    {
        if($search == 1)
        {
            print "While searching the abandoned warehouse, you find $matches matches and $petrol gallons of petrol. Good job! <a href = 'index.php' />Go Home</a>.";
        
            $db->query(sprintf("UPDATE `users` SET `matches` = `matches` + '%d',
                                  `petrol` = `petrol` + '%d',
                                  `warehouse` = `warehouse` + '%d'
                                 WHERE `userid` = ('%u')",
                                  $matches, $petrol, 1, $userid));
                           
        }
        elseif($search == 2)
        {
            print "While searching through the abandoned warehouse, you find nothing but \$$cash. Disappointed, you head <a href = 'index.php' />home</a>.";
        
            $db->query(sprintf("UPDATE `users` SET `money` = `money` + '%d',
                                  `warehouse` = `warehouse` + '%d'
                                   WHERE `userid` = ('%u')",
                                   $cash, 1, $userid));                       
        }
        elseif($search == 3)
        {
            print "While searching through the abandoned warehouse, you knock over a stack of shelves which fall on top of you. You start screaming for help and 10 minutes later the cops arrive. They take you away to the jail for $jtime for breaking and entering. <br /> <br />
            <a href = 'jail.php' />Go to Jail</a>";
        
            $db->query(sprintf("UPDATE `users` SET `jail` = '%d',
                               `jail_reason` = 'Got caught searching the warehouse',
                               `warehouse` = `warehouse` + '%d'
                                  WHERE `userid` = ('%u')",
                                  $jtime, 1, $userid));                
        }
        elseif($search == 4)
        {
            print "While searching through the abondoned warehouse, you get lucky and find a large stash of petrol, matches and money. Feeling selfish, you take the lot: $pet gallons of petrol, $mat matches and \$$big. <a href = 'index.php' />Head home</a>.";
        
            $db->query(sprintf("UPDATE `users` SET `money` = `money` + '%d',
                                  `matches` = `matches` + '%d',
                                  `petrol` = `petrol` + '%d',
                                  `warehouse` = `warehouse` + '%d'
                                  WHERE `userid` = ('%u')",
                                  $big, $mat, $pet, 1, $userid));                       
        }
    }
}
    
    
$h->endpage();
?>