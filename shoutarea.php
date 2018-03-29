<?php

$special_page = '
<script src="js/shoutbox.js" type="text/javascript"></script>
<script src="js/bbcodes.js" type="text/javascript"></script>
';
include_once('globals.php');

print '


<div class="usercmtpart">
<div><img src="images/usercomment_left.jpg" alt="" /></div>
<div class="usercmt_txtpart"> <br>
 <center> <font size="2"> <b> Shout Box </font> </center> </b>
</div>
<div><img src="images/usercomment_right.jpg" alt="" /></div>
</div>    
';
?>
<div><img src="images/generalinfo_top.jpg" alt="" /></div>
<div class="generalinfo_simple">
<table width="100%">
 <tr>
  <td style="height:200px; overflow:auto;">
    <div style="width:100%;height:200px; overflow:auto;"><table id="shoutbox_container" width="100%" style="text-align:left;"><tr><td><img src="/images/ajaxloading.gif" border="0" /></td></tr></table>
  </td>
 </tr>
 <tr>
  <td>
  <form method=post name="shoutbox_form" id="shoutbox_form" onsubmit="if(!posting) sendShouts();else alert('Posting in progress..');return false;">
   <input type='hidden' name='do' value='shout' />
   <input type='hidden' name='fontWeight' />
   <input type='hidden' name='textDecoration' />
   <input type='hidden' name='fontStyle' />
   <input type='hidden' name='fontFamily' />
   <input type='hidden' name='color' />
   <input type='hidden' name='size' />
   <table style='width: 95%;' align=center cellpadding=3 cellspacing=0>
	<tr>
		<td class=bottom colspan=2>
			<table cellpadding=1 cellspacing=1>
				<tr>
					<td class=bottom align=center>
						<input type="button" id="bb_bold" title="Bold" class="bbcode" style="background-image: url(/images/bbcode/shoutbox/icon_bold.png); width: 20px; height: 20px;" onclick="sb_PropChange_Button(this, 'fontWeight')" /></td>
					<td class=bottom align=center>
						<input type="button" id="bb_underline" title="Underline" class="bbcode" style="background-image: url(/images/bbcode/shoutbox/icon_underline.png); width: 20px; height: 20px;" onclick="sb_PropChange_Button(this, 'textDecoration')" />
					</td>
					<td class=bottom align=center>
						<input type="button" id="bb_italic" title="Italic" class="bbcode" style="background-image: url(/images/bbcode/shoutbox/icon_italic.png); width: 20px; height: 20px;" onclick="sb_PropChange_Button(this, 'fontStyle')" />
					</td>
					<td class=bottom align=center>
						<select id='bb_color' title='Color' name='colort_selector' onchange='sb_PropChange(this, "color")' style="height: 20px;"><option value="Default">Color (default)</option><option value="red" style="color: red">red</option>
							<option value="blue" style="color: blue">blue</option>
							<option value="teal" style="color: teal">teal</option>
							<option value="green" style="color: green">green</option>
							<option value="orange" style="color: orange">orange</option>
							<option value="purple" style="color: purple">purple</option>
							<option value="magenta" style="color: magenta">magenta</option>
							<option value="pink" style="color: pink">pink</option>
							<option value="yellow" style="color: yellow">yellow</option>
							<option value="brown" style="color: brown">brown</option>
							<option value="brown" style="color: brown">navy</option>
							<option value="limegreen" style="color: limegreen">limegreen</option>
							<option value="aqua" style="color: aqua">aqua</option>
							<option value="olive" style="color: olive">olive</option>
						</select>
					</td>
					<td class=bottom align=center>
						<select id='bb_font' title='Font' name='font_selector' onchange='sb_PropChange(this, "fontFamily")' style="height: 20px;"><option value="Default">Font (default)</option><option value="Arial" style="font-family: Arial">Arial</option>
							<option value="Arial Black" style="font-family: Arial Black">Arial Black</option>
							<option value="Book Antiqua" style="font-family: Book Antiqua">Book Antiqua</option>
							<option value="Century Gothic" style="font-family: Century Gothic">Century Gothic</option>
							<option value="Comic Sans MS" style="font-family: Comic Sans MS">Comic Sans MS</option>
							<option value="Courier New" style="font-family: Courier New">Courier New</option>
							<option value="Fixedsys" style="font-family: Fixedsys">Fixedsys</option>
							<option value="Garamond" style="font-family: Garamond">Garamond</option>
							<option value="Lucida Console" style="font-family: Lucida Console">Lucida Console</option>
							<option value="Microsoft Sans Serif" style="font-family: Microsoft Sans Serif">Microsoft Sans Serif</option>
							<option value="System" style="font-family: System">System</option>	
							<option value="Tahoma" style="font-family: Tahoma">Tahoma</option>
							<option value="Times New Roman" style="font-family: Times New Roman">Times New Roman</option>
							<option value="Verdana" style="font-family: Verdana">Verdana</option>
						</select>
					</td>
					<td class=bottom align=center>
						<select id='bb_size' title='Size' name='size_selector' onchange='sb_PropChange(this, "size")' style="height: 20px;">
							<option value="Default">Size (default)</option>
							<option value=1 style="font-size: 1;">1</option>
							<option value=2 style="font-size: 15px;">2</option>
							<option value=3 style="font-size: 20px;">3</option>
							<option value=4 style="font-size: 25px;">4</option>
						</select>
					</td>
					<td class=bottom>
						&nbsp;
					</td>
					<td class=bottom align=center>
						<input type=button name=img title="Insert image" class=bbcode onclick="surroundText('[img]', '[/img]', document.shoutbox_form.shoutbox_input)" style="background-image: url(/images/bbcode/shoutbox/icon_img.gif); width: 20px; height: 20px;" />
					</td>
					<td class=bottom align=center>
						<input type=button name=quote title="Insert quote" class=bbcode onclick="surroundText('[quote]', '[/quote]', document.shoutbox_form.shoutbox_input)" style="background-image: url(/images/bbcode/shoutbox/icon_quote.gif); width: 20px; height: 20px;" />
					</td>	
					<td class=bottom align=center>
						<input type=button name=list title="Insert list item" class=bbcode onclick="surroundText('[*]', '', document.shoutbox_form.shoutbox_input)" style="background-image: url(/images/bbcode/shoutbox/icon_list.gif); width: 20px; height: 20px;" />
					</td>
				</tr>

			</table>
		</td>
	</tr>
	<tr>
		<td class=bottom align=center style='vertical-align:middle; width: 100%; padding-right: 3px;'>
		<input type="text" id="shoutbox_input" STYLE="color: black;  background-color: white; width:100%" maxlength="250">
		</td>
		<td class=bottom align=left>
			<input type="submit" STYLE="color: black;  background-color: white;" value="Shout">
		</td>
	</tr>
	<tr>
		<td align=center class=bottom style='width: 100%;'>
			<table class=bottom>
				<tr>
					<td align=center class=bottom><img src='/images/smilies/smile1.gif' title=':-)' alt=':-)' style='cursor: pointer;' onclick="InsertSmilie(':-)');" /></td>
					<td align=center class=bottom><img src='/images/smilies/smile2.gif' title=':smile:' alt=':smile:' style='cursor: pointer;' onclick="InsertSmilie(':smile:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/grin.gif' title=':-D' alt=':-D' style='cursor: pointer;' onclick="InsertSmilie(':-D');" /></td>
					<td align=center class=bottom><img src='/images/smilies/laugh.gif' title=':lol:' alt=':lol:' style='cursor: pointer;' onclick="InsertSmilie(':lol:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/boogie.gif' title=':boogie:' alt=':boogie:' style='cursor: pointer;' onclick="InsertSmilie(':boogie:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/w00t.gif' title=':w00t:' alt=':w00t:' style='cursor: pointer;' onclick="InsertSmilie(':w00t:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/tongue.gif' title=':-P' alt=':-P' style='cursor: pointer;' onclick="InsertSmilie(':-P');" /></td>
					<td align=center class=bottom><img src='/images/smilies/wink.gif' title=';)' alt=';)' style='cursor: pointer;' onclick="InsertSmilie(';)');" /></td>
					<td align=center class=bottom><img src='/images/smilies/noexpression.gif' title=':-|' alt=':-|' style='cursor: pointer;' onclick="InsertSmilie(':-|');" /></td>
					<td align=center class=bottom><img src='/images/smilies/confused.gif' title=':-/' alt=':-/' style='cursor: pointer;' onclick="InsertSmilie(':-/');" /></td>
					<td align=center class=bottom><img src='/images/smilies/sad.gif' title=':-(' alt=':-(' style='cursor: pointer;' onclick="InsertSmilie(':-(');" /></td>
					<td align=center class=bottom><img src='/images/smilies/cry.gif' title=':cry:' alt=':cry:' style='cursor: pointer;' onclick="InsertSmilie(':cry:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/angry.gif' title=':angry:' alt=':angry:' style='cursor: pointer;' onclick="InsertSmilie(':angry:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/mad.gif' title=':mad:' alt=':mad:' style='cursor: pointer;' onclick="InsertSmilie(':mad:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/dry.gif' title='<_<' alt='<_<' style='cursor: pointer;' onclick="InsertSmilie('<_<');" /></td>
					<td align=center class=bottom><img src='/images/smilies/unsure.gif' title=':unsure:' alt=':unsure:' style='cursor: pointer;' onclick="InsertSmilie(':unsure:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/blush.gif' title=':blush:' alt=':blush:' style='cursor: pointer;' onclick="InsertSmilie(':blush:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/yawn.gif' title=':yawn:' alt=':yawn:' style='cursor: pointer;' onclick="InsertSmilie(':yawn:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/sick.gif' title=':sick:' alt=':sick:' style='cursor: pointer;' onclick="InsertSmilie(':sick:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/hmmm.gif' title=':-?' alt=':-?' style='cursor: pointer;' onclick="InsertSmilie(':-?');" /></td>
					<td align=center class=bottom><img src='/images/smilies/noob.gif' title=':noob:' alt=':noob:' style='cursor: pointer;' onclick="InsertSmilie(':noob:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/nerd.gif' title=':nerd:' alt=':nerd:' style='cursor: pointer;' onclick="InsertSmilie(':nerd:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/yes.gif' title=':yes:' alt=':yes:' style='cursor: pointer;' onclick="InsertSmilie(':yes:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/no.gif' title=':no:' alt=':no:' style='cursor: pointer;' onclick="InsertSmilie(':no:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/blink.gif' title=':blink:' alt=':blink:' style='cursor: pointer;' onclick="InsertSmilie(':blink:');" /></td>
					<td align=center class=bottom><img src='/images/smilies/huh.gif' title=':huh:' alt=':huh:' style='cursor: pointer;' onclick="InsertSmilie(':huh:');" /></td>
				</tr>
			</table>
		</td>
		<td class=bottom align=center><nobr>
			&nbsp;[<a href='javascript:ShowSmilies();'><b>More smilies</b></a>]</nobr>
		</td>
	</tr>
   </table>
  </form>
 </td>
</tr>
</table>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div>
<script type="text/javascript">viewShouts()</script>
<?
$h->endpage();
?>