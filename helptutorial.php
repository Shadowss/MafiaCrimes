<?php
include 'globals.php';


//print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
//	<div class='generalinfo_simple'>");

print "<h2><p id='contents'><u>{$set['game_name']} Help Tutorial</u></p></h2>  
<table align='left' width=20%'>
<tr><td style='border: 1px #FFFFFF solid; padding: 8px;'>
<ul>
<li><a href='helptutorial.php#guide1'>Introduction</a></li>
<li><a href='helptutorial.php#guide2'>Events</a></li>
<li><a href='helptutorial.php#guide3'>Energy, Brave and Will</a></li>
<li><a href='helptutorial.php#guide4'>Mailbox</a></li>
<li><a href='helptutorial.php#guide5'>Stats</a></li>
<li><a href='helptutorial.php#guide6'>Crimes</a></li>
<li><a href='helptutorial.php#guide7'>Searching</a></li>
<li><a href='helptutorial.php#guide8'>Courses</a></li>
<li><a href='helptutorial.php#guide9'>Friends List/Enemy List</a></li>
<li><a href='helptutorial.php#guide10'>Jail</a></li>
<li><a href='helptutorial.php#guide11'>Hospital</a></li>
<li><a href='helptutorial.php#guide13'>Hall of Fame</a></li>
<li><a href='helptutorial.php#guide14'>Gangs</a></li>
<li><a href='helptutorial.php#guide15'>Joining a Gang</a></li>
<li><a href='helptutorial.php#guide16'>Creating a Gang</a></li>
<li><a href='helptutorial.php#guide17'>Gang Reputation</a></li>
<li><a href='helptutorial.php#guide18'>Gang Wars</a></li>
<li><a href='helptutorial.php#guide19'>Your Profile</a></li>
<li><a href='helptutorial.php#guide20'>Editing Your Profile</a></li>
<li><a href='helptutorial.php#guide21'>Basic Game Terms</a></li>";

print "</ul></td></tr></table>
<table align='right' width='80%'><tr><td border='1'>


<p style='padding-left: 15px;' id='guide1'>Introduction</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
{$set['game_name']} is where to succeed you're required to train hard and do as many crimes as you can. You can either spend all day in the gym training to beat your enemies, or join a Gang and work as a team destroying others to be a part of the best around.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide2'>Events</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
The events section is where all current news that has happened to you will be displayed. This could include events such as being attacked, being sent money or being rescued from jail. Again, events are displayed in chronological order, and can be easily deleted by using the Delete link. The events section also has a Delete all events, which clear the list of all your events.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide3'>Energy, Brave and Will</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
At the top of the Sidebar you can see some of your details, including your current Energy, Brave and Will.<br /><br />
<u>Energy</u>. You can use your energy for training 10 times, unless you are a donator, then you can then train 15 times. You get 5 energy every 5 minutes. You are able to use energy for training your battle stats, attend lessons at Courses or attacking players (50 energy).<br /><br />
<u>Brave</u> is used to do crimes. Harder crimes will use up more of your bar, but gain you more cash as a result. You gain 1 brave every 5 minutes.<br /><br />
<u>Will</u>. The better your will is, the more stat points you will gain per one set while training. The length of the will bar depends on the property that you own for example if you own Lower Class Apartments you will have a higher will bar than if you have The Projects.<br />
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide4'>Mailbox</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
The mailbox is where all your messages from other players and staff will be sent to. Check your mails on a regular basis, the link will bold when you have received a new message. Mails will be displayed in the order you have received them, but will only display the first 25.<br />

There are three ways to send a mail, depending on whether you have a previous mail from them. To send a mail for the first time, find the users profile page, and click on the Send Mail link. Type your message in the box provided and click the Send button. If you have contacted this person before, simply use the Reply link to send a message the same way. You will notice that the message history will be displayed at the bottom of the page.<br />
Deleting a message is very simple, click the Delete link in the list on the left.<br />
<br />
<b><span style='color: red;'>{$set['game_name']} staff will never ask for your username or password, please report any messages sent to you of this nature and then delete.</span></b>
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide5'>Stats</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Stats are used for attacking others, the different type of stats are as follows:<br />

Strength: Makes you inflict more damage on the opponent.<br />
Guard: Makes your opponent inflict less damage on you.<br />
Rob Skill: The higher Rob Skoll you have the higher your chance of robbing a company. If your rob skill is greater than companys security level , you'll suceed , otherwise busted!
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide6'>Crimes</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
There are currently 5 types of crimes: Searching, Mugging, Sell Copied Media, Robbery and Illegal Goods. The easiest using 1 brave; however this will gain you least experience and money. When you fail to complete a crime you could get put in jail for a certain amount time depending on the difficulty of the crime.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide7'>Searching</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Searching is a vital part of the game. Initially you may only search the Streets, but as you progress in the game you will have other options opened up to you to have different outcomes.<br />
<br />
You choose your search area, and wait to see what your result is. You may find potions, weapons or armour! Of course, that's just the basic items you are able to gain; at higher levels, you will find that your searches will become more and more rewarding.<br />
<br />
You will get 25 free searches every day, and if that's not enough, you can always refill that 25 searches using 200 white crystals. Note that the searches will not carry over to the next day so you should finish them before the day is over.<br />
<br />
Take your chances of good and bad outcomes, and long term you will find yourself better off.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide8'>Courses</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Courses give you the opportunity to train yourself with various skills to help improve you as a killer.<br />
<br />
You can only do 1 course at any one time, and attend the course once an hour. The maximum number a day for one course is 6 but this you can have extra 2 hours if you spend white crystals. These extra trains gained by using white crystals aren't permanent and must be used before {$set['game_name']} new day begins . Each time you attend, it costs 5 Energy, but the outcomes are worthwhile for the effort in the long term.<br />

<br />
If you have finished a course you can view what you got by going to Courses and on main page at bottom click View each to the course you want to see information about.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide9'>Friends List/Enemy List</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
The friends list is the best place to store your favourite mates on {$set['game_name']}, and is <u>only available to donators</u>. If you want to add a friend to your list, click on the Add Friend link at the top of the page and type in their user ID as well as an optional comment. If you don't know their user ID, find it by using the search feature with their name. Adding people to your friends list makes it easier to send cash as well as mailing them. To remove a friend, simply click the Remove link at the end of the row. The Enemy list works in a similar fashion, using the user ID to add them to the list. The enemy list however creates a shortcut to the attack page, making it easier to hit them. The lists also offer a quick way to see if your friends are online or not.<br />
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide10'>Jail</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Jail is like the Hospital as you can't do much whilst in there either. To be sent to Jail you will either be caught doing crimes, being in wrong place in Searching or if you fail to rescue someone from Jail. Rescuing players out of Jail will cost you 10 Energy pass or fail.<br />
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide11'>Hospital</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
When in Hospital you will not be able to do anything until your Time Left in the hospital runs out. You can decrease your hospital time with Healing Potions. Which can be found by Searching, you can buy them from the Item Market from other players.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide13'>Hall of Fame</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Hall of Fame consists of the best Players and Gangs on {$set['game_name']}, you will find the Top 20 for each category; Level, Gold, Gang Respect, White Crystals, Best House, Lottery Wins, Lottery Winnings, Rescues, Crimes and Courses Finished.        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide14'>Gang</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Gangs are a group of members formed by a leader and a co-leader. By joining one you agree to be loyal and honest with the fellow members of it. While in a gang you could be in war in which when you attack enemy gang's to gain you reputation.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide15'>Joining a gang</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
To join, go to the Gang's profile and at the bottom of the page click Apply. Make sure your application is well written and detailed. You will need to explain what you are good at and why you wish to join that gang. Some gang's may ask for your battle stats. Once the application is submitted, you will need to wait a while for the gang leader or co-leader to accept or decline it.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide16'>Creating a gang</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
This is pretty simple however may be extremely costly. To create one go to the explore in the Darkest Side part. You will have a choice of three options. By clicking 'Gangs' it will take you to a page with other gangs, once on the page up top you see a link called 'Create A Gang Here'. Click it.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide17'>Gang reputation</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Reputation is the most important aspect of a gang. When a gangs reputation hits 0, it is dead. The members will then be without a gang however are free to join any others. A gang can only lose reputation during gang wars. When at war the members can attack the enemy gang members causing them to lose reputation, and the other gang to gain some. The amount of reputation gained or lost depends on the amount of chain that has gone on. Hospitalizing the enemy members will gain you more reputation and they will lose more.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide18'>Gang Wars</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
Gang wars are when the existing gang battle it out for the top spot and financial gain. All gangs start out with 100 reputation. When a gang 'zeros' it is no longer in existence.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide19'>Your profile</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>
At the bottom left hand side of your profile you will see a preferences link. Once clicked it gives you a list of options. Firstly go to Profile Sig Change. Clicking this will just let you see a profile signiture box where you can put information in.<br />

You can add pictures, music and videos to your own profile signature, but as a general rule, no content must exceed a width of 500px.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide20'>Editing your profile</p>
<div style='border: 1px #FFFFFF solid; padding: 8px;'>
Your profile can be edited very easily. To start editing your profile and other information- click on the Preferences option in the Options section on the left hand side of the screen.<br />
<br />
The first link on your profile section, Name is simply where you can change your display name. Your ID and login name will still stay the same though, so other users can still find you.<br />

<br />
The Profile Signature section is where you can edit your signature or add information you would want others to see. When adding your signature please be aware that the max size for a signature is 500px wide and although there is no maximum height, 400px wide by 150px is a good size. <br />
When putting a signature on your profile it should have<br />[img]profile picture here[/img]<br />You can do this by uploading your picture onto the following sites.<br />
<br />
The User Image section is where you can add your own picture that you want others to see the max size for it is 150 kb and the default size is 200 x 270.<br />
<br />
The last part of the settings allows you to change your password. Change Password this is where you click to change your password. It's good to change it monthly, however if you change it, make sure you remember it.
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div>


<p style='padding-left: 15px;' id='guide21'>Basic Game Terms</p>
<div style=' border: 1px #FFFFFF solid; padding: 8px;'>

<b>Regeneration:</b><br />
Energy - 5 every 5 minutes<br />
Brave - 1 every 5 minutes<br />
Will - 5 every 5 minutes<br /><br />

<i>With Donator status: &nbsp;It alternates energy</i><br /><br />

<b>Temporary increases:</b><br />
150 energy. (31 days)<br />
<br />
<b>Permanent Increases:</b><br />
There isn't any.<br />
<br />
        <div style='text-align: right; font-size: 9px; height: 6px; font-weight: bold;'>
        [<a href='helptutorial.php#contents' style='font-weight: normal; color:#990000;'>back to top</a>]&nbsp;
        [<a href='explore.php' style='font-weight: normal; color:#990000;'>back to explore</a>]</div></div></td></tr></table>";
//print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>