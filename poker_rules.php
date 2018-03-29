<?php    
$special_page = '<link rel="stylesheet" href="css/poker.css" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/lobby.php"></script>
<style type="text/css">
<!--
.style1 {
	font-size: large;
	font-weight: bold;
}
.style5 {font-size: 11px}
-->
</style>
';
$menuhide=1;
$userStatsHide=1;

include "globals.php";
if($ir['jail'] or $ir['hospital']) { print "This page cannot be accessed while in jail or hospital.";

$h->endpage(); 
exit; 
}
require('poker_includes/gen_inc.php'); 
poker_menu_start(RULES);
?>
        </tr>
      </table>
      <div style="border : solid 0px   padding : 1px; width : 100%; height : 450px; overflow : auto; ">
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td valign="top"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr> 
                  <td class="smllfont" colspan="2"><font color="#FFCC33"><b>Overview</b></font></td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" colspan="2"> 
                    <p>The object of Texas Holdem is to make the best 5 card poker 
                      hand from the 5 community cards on the table and your own 
                      2 cards that only you can see. The community cards are dealt 
                      out during the hand with betting rounds in between so you 
                      are betting on the likleyhood of forming a winning hand 
                      by the end of the hand when all cards are revealed.<br>
                      <br>
                      A game consists of playing hands of cards and each hand 
                      is split into alternating rounds of revealing cards and 
                      betting on the results.<br>
                      <br>
                      Your good buddy has lent you $10K to join a high stakes 
                      poker game. Whatever profit or loss you make whilst playing 
                      in a game will be added or deducted from your total bankroll 
                      whenever you leave a table. The total bankroll determines 
                      your player ranking. <br>
                      <br>
                      Be careful not to lose the initial $10K or it's back to 
                      your buddy to plead for more!<br>
                    </p>
                  </td>
                </tr>
              </table>
              <br>
              <table width="100%" border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                <tr> 
                  <td colspan="2" class="smllfont"><b><font color="#FFCC33">Poker 
                    Hands </font></b><font color="#FFCC33">(highest to lowest)</font></td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/royalflush.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Royal Flush</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">The highest possible poker hand 
                    is the Royal Flush. It consists of a Ten, Jack, Queen, King 
                    and Ace, all of the same suit.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/straightflush.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Straight Flush</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">A combination of both a straight 
                    and a flush. The cards must all be of the same suit and they 
                    must run in value (e.g. 4,5,6,7,8). If more than one player 
                    has a Straight Flush, the player with the best Highcard wins.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/4ofakind.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Four Of A Kind</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">This hand is made up with 4 cards 
                    of the same value (e.g. 4 X Jacks). If more than one player 
                    has Four Of A Kind the highest value Four Of A Kind would 
                    win.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/fullhouse.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Full House</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">This hand is made up with 3 cards 
                    of one value and two of another value (e.g. 3 X Nines and 
                    2 X Queens). If more than one player has a Full House the 
                    winning hand would be the one with the highest triple value 
                    or failing that the highest double value.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/flush.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Flush</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">A Flush is when the hand contains 
                    5 cards of the same suit (e.g. 5 X Spades). If more than one 
                    player has a Flush the winner is the player with the best 
                    Highcard.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/straight.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Straight</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">To make a Straight the must run 
                    in value (e.g. 4,5,6,7,8) but it does not matter what suit 
                    they are. If more than one player has a Straight , the player 
                    with the best Highcard wins.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/3ofakind.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Three Of A Kind</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">This hand is made up with 3 cards 
                    of the same value (e.g. 3 X Sevens). If more than one player 
                    has a Three Of A Kind the winning hand would be the one with 
                    the highest value Three Of A Kind.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/2pair.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Two Pair</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">Two pair of the same value (e.g. 
                    2 X Fours and 2 X Sevens). If more than one player has Two 
                    Pair, the winner is the player with the highest pair value. 
                    If both players have the same pairs the player with the best 
                    Highcard wins.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/pair.jpg" width="119" height="61"></td>
                  <td width="80%"><b>One Pair</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">One pair of the same value (e.g. 
                    2 X Fours). If more than one player has One Pair, the winner 
                    is the player with the highest pair value. If both players 
                    have the same pair the player with the best Highcard win.</td>
                </tr>
                <tr> 
                  <td width="20%" rowspan="2"><img src="images/tutorial/highcard.jpg" width="119" height="61"></td>
                  <td width="80%"><b>Highcard</b></td>
                </tr>
                <tr> 
                  <td width="80%" valign="top">The Highcard is the highest value 
                    card that is in your hand that is not duplicated (not a pair, 
                    3 of a kind or 4 of a kind). If one or more players has the 
                    same Highcard the next highest Highcard will be evaluated 
                    until a winner is found.</td>
                </tr>
              </table>
              <br>
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr> 
                  <td class="smllfont" colspan="2"><font color="#FFCC33"><b>Game 
                    Play</b></font></td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">1) </td>
                  <td class="smllfontwhite" width="96%">The hand begins.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">2)</td>
                  <td class="smllfontwhite" width="96%">The next player from the 
                    <b>dealer button</b> posts the <b>small blind</b>. </td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">3)</td>
                  <td class="smllfontwhite" width="96%">The next player posts 
                    the <b>big blind</b>. </td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">4)</td>
                  <td class="smllfontwhite" width="96%">Each player is dealt their 
                    personal hand (2 cards each). These are called the player's 
                    <b>hole cards</b>.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">5)</td>
                  <td class="smllfontwhite" width="96%"><b>Betting round</b> 1 
                    commences (pre-flop). </td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">6)</td>
                  <td class="smllfontwhite" width="96%">The first 3 community 
                    cards are dealt out. This is called the <b>Flop</b>.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">7)</td>
                  <td class="smllfontwhite" width="96%"><b>Betting round</b> 2 
                    commences.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">8)</td>
                  <td class="smllfontwhite" width="96%">The 4th community card 
                    is dealt out. This is called the <b>Turn</b> card.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">9)</td>
                  <td class="smllfontwhite" width="96%"><b>Betting round</b> 3 
                    commences.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">10)</td>
                  <td class="smllfontwhite" width="96%">The 5th and last community 
                    card is dealt. This is called the <b>River </b>card.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">11)</td>
                  <td class="smllfontwhite" width="96%">Last <b>betting round</b> 
                    commences.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">12)</td>
                  <td class="smllfontwhite" width="96%">The cards of the remaining 
                    players that have not <b>folded</b> are turned over to find 
                    the winner.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">13)</td>
                  <td class="smllfontwhite" width="96%">The winnings are distributed**. 
                    If more than one player wins the pot is split. </td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">14)</td>
                  <td class="smllfontwhite" width="96%">If more than one player 
                    still has money in their pot, a new hand begins.</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">&nbsp;</td>
                  <td class="smllfontwhite" width="96%">&nbsp;</td>
                </tr>
                <tr> 
                  <td class="smllfontwhite" width="4%">**</td>
                  <td class="smllfontwhite" width="96%">Note: You cannot win more 
                    than the amount you bet from another player.</td>
                </tr>
              </table>
              <br>
              <table width="100%" border="0" cellspacing="0" cellpadding="4">
                <tr> 
                  <td class="smllfont" colspan="2"><font color="#FFCC33"><b>Terms</b></font></td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Dealer Button</b></td>
                  <td class="smllfontwhite" width="83%">A chip that marks where 
                    the dealing begins. This moves forward one player each hand.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Small Blind</b></td>
                  <td class="smllfontwhite" width="83%">An automatic small bet 
                    that must be paid by the next player from the dealer button 
                    at the beginning of a hand.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Big Blind</b></td>
                  <td class="smllfontwhite" width="83%">An automatic large bet 
                    that must be paid by the next player from the small blind 
                    player at the beginning of a hand. During the first betting 
                    round this is the amount players must match or raise to stay 
                    in the current hand.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Hole Cards</b></td>
                  <td class="smllfontwhite" width="83%">The 2 cards that you are 
                    dealt as your personal hand. Other players cannot see your 
                    cards unless they turn over at the end of the hand to find 
                    the winner.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Betting Round</b></td>
                  <td class="smllfontwhite" width="83%">There are 4 betting rounds 
                    during a game. A player can choose to call a bet, raise a 
                    bet or fold their hand.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Flop</b></td>
                  <td class="smllfontwhite" width="83%">The first 3 community 
                    cards dealt out during the hand after the first betting round.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Turn</b></td>
                  <td class="smllfontwhite" width="83%">The 4th community card 
                    dealt out after the second betting round.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>River</b></td>
                  <td class="smllfontwhite" width="83%">The 5th community card 
                    dealt out after the third betting round.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Call</b></td>
                  <td class="smllfontwhite" width="83%">Match the current bet 
                    amount.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Raise</b></td>
                  <td class="smllfontwhite" width="83%">Raise the current bet 
                    amount.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Fold</b></td>
                  <td class="smllfontwhite" width="83%">Discard your current hand 
                    and lose any money you have bet so far in this hand.</td>
                </tr>
                <tr valign="top"> 
                  <td class="smllfontwhite" width="17%"><b>Allin</b></td>
                  <td class="smllfontwhite" width="83%">Bet your entire pot on 
                    the hand.</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
      </td>
  </tr>
<?
poker_menu_end();
$h->endpage();
?>