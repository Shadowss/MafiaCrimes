posting = false;
function addslashes(str) {
str=str.replace(/\\/g,'\\\\');
str=str.replace(/\'/g,'\\\'');
str=str.replace(/\"/g,'\\"');
str=str.replace(/\0/g,'\\0');
return str;
}
function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
function ShowSmilies() {
  var SmiliesWindow = window.open("moresmiles.php?form=shoutbox_form&text=shoutbox_input", "Smilies","width=600,height=500,resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=no,status=no");
  if (window.focus) {SmiliesWindow.focus()}
}

function InsertSmilie(texttoins)
{
	$("#shoutbox_input").val($("#shoutbox_input").val() + texttoins);
	$("#shoutbox_input").focus();
}
function printShouts(obj){
	if(obj.failed){
		alert("Failed! Reason:"+obj.failed);
		return false;
	}
	if(posting)
		return false;
	var out = "";
	for(var i=0;i<obj.length;i++){
		out+="<tr><td><nobr>";
		if(obj[i].staff)
			out+= "[<a href='javascript:void(0)' onclick='deleteShouts("+obj[i].id+")'>X</a>][<a href='javascript:void(0)' onclick='editShouts("+obj[i].id+",\""+obj[i].edit+"\")'>E</a>]";
		if(obj[i].userid !=0)
			out+="["+obj[i].date+"]</nobr></td><td><nobr><span><a href='viewuser.php?u="+obj[i].userid+"'>"+obj[i].username+"</a>:</nobr></span></td><td width='100%' id='shoutbox_message"+obj[i].id+"'>"+obj[i].message+"</td></tr>";
		else
			out+="["+obj[i].date+"]</nobr></td><td><nobr><span><a href='javascript:void(0)'><b>"+obj[i].username+"</b></a>:</nobr></span></td><td width='100%' id='shoutbox_message"+obj[i].id+"'>"+obj[i].message+"</td></tr>";
	}
//	$("#shoutbox_container").children().remove();
	$("#shoutbox_container").html(out);
}
function deleteShouts(id){
	if(posting){
		alert('Posting in progress. Please be patient');
		return false;
	}
	var confirmdelete = confirm("Are you sure you want to delete the post?!");
	if(!confirmdelete) return false;
	posting = true;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: {do: "shout", delete: id},
		dataType: 'json',
		cache: false,
		async: false,
		success:function(r){
			posting=false;
			printShouts(r);
		}
	});
}
var editText = "";
function editShouts(id,sb_text){
	editText = sb_text;
	if(posting){
		alert('Posting in progress. Please be patient');
		return false;
	}
	posting = true;
	if($("#shoutbox_message"+id).length){
		$("#shoutbox_message"+id).children().remove();
		$("#shoutbox_message"+id).html("<input type='text' name='" + id + "' id='Edit" + id + "' value='" + sb_text.replace(/'/g,"&#39;") + "' STYLE='color: black;  background-color: white;' size='70' length='70' maxlength='250' /> - <span style='cursor:pointer;'><a onclick=\"CompleteEdit('" + id + "')\">Submit</a></span> - <span style='cursor:pointer;'><a onclick=\"DoNotEdit('"+id+"')\">Cancel</a></span>");
	}
}
function CompleteEdit(id) {
	if (!posting){
		alert('Error! Try again!');
		return false;
	}
		Shout = $("#Edit" + id).val();
	if (Shout.replace(/ /g, '') == ''){
		alert('You must enter a shout.');
		return false;
	}
	if(Shout.length > 250){
		alert("You wrote "+Shout.length+" characters. The maximum allowed is 250.");	
		return false;
	}
	if($("#shoutbox_message"+id).length){
		$("#shoutbox_message"+id).children().remove();
		$("#shoutbox_message"+id).html(Shout);
	}
	$.ajax({
		type: 'POST',
		url: "ajax.php",
		data: {do: "shout", edit:id, message: Shout},
		dataType: 'json',
		cache: false,
		async: false,
		success:function(r){
			printShouts(r);
		}
	});
	posting = false;
	return false;
	}
function DoNotEdit(id){
	posting = false;
	if($("#shoutbox_message"+id).length){
		$("#shoutbox_message"+id).children().remove();
		$("#shoutbox_message"+id).html(editText);
	}
}
function viewShouts(){
	if(!posting)
	     $.ajax({
		url: "ajax.php",
		data: {do: "shout"},
		async: false,
		dataType: "json",
		success:function(r){
			printShouts(r);
		}
	    });
	setTimeout('viewShouts()',10000);
}
function sendShouts(){
	if(posting){
		alert('Posting in progress. Please be patient');
		return false;
	}
	var Shout = $("#shoutbox_input").val();
	if (Shout.replace(/ /g, '') == ''){
		alert('You must enter a shout.');
		return false;
	}
	if(Shout.length > 250){
		alert("You wrote "+Shout.length+" characters. The maximum allowed is 250.");	
		return false;
	}
	posting = true;
	$("#shoutbox_input").val("");
	var sendParam = new Object;
	sendParam.do="shout";
	sendParam.message=Shout;
	var inputObjs = $("#shoutbox_form > input");
	for (i = 0; i < inputObjs.length; i++)
		if (inputObjs[i].type == 'hidden' && inputObjs[i].value != '')
			sendParam[inputObjs[i].name] = inputObjs[i].value;
	$.ajax({
		type: 'POST',
		url: "ajax.php",
		data: sendParam,
		dataType: 'json',
		cache: false,
		async: false,
		success:function(r){
			posting=false;
			printShouts(r);
		},
		ajaxError:function(){
			alert("There was an error! If it persists please refresh the page.");
			posting=false;
		}
	});
	return false;
}


function sb_Input_SC(sProperty, setting)
{
	set_shout_memory_cookie('shoutbox_' + sProperty, setting)
	eval('document.forms["shoutbox_form"].shoutbox_input.style.' + sProperty + ' = "' + setting + '"')
	eval('document.forms["shoutbox_form"].' + sProperty + '.value = "' + setting + '"')
}

function getSelectionValue(eSelector)
{
	return eSelector.options[eSelector.options.selectedIndex].value == 'Default' ? '' : eSelector.options[eSelector.options.selectedIndex].value
}

function sb_PropChange(eSelector, sProperty)
{
	sb_Input_SC(sProperty, getSelectionValue(eSelector))
}

function sb_PropChange_Button_Value(sProperty)
{
	trueValue = ''
	switch (sProperty)
	{
		case 'fontWeight':
		falseValue = 'bold'
		break;

		case 'textDecoration':
		falseValue = 'underline'
		break;

		case 'fontStyle':
		falseValue = 'italic'
		break;
	}

	set_shout_memory_cookie('shoutbox_' + sProperty, ((eval('document.forms["shoutbox_form"].' + sProperty + '.value'))? trueValue : falseValue))

	return (eval('document.forms["shoutbox_form"].' + sProperty + '.value'))? trueValue : falseValue
}

function sb_PropChange_Button(cButton, sProperty)
{
	if(cButton.style.backgroundImage.match(/pressed/))
		cButton.style.backgroundImage = cButton.style.backgroundImage.replace(/_pressed/, '');
	else
		cButton.style.backgroundImage = cButton.style.backgroundImage.replace(/.png/, '_pressed.png');

	sb_Input_SC(sProperty, sb_PropChange_Button_Value(sProperty))
}


function set_shout_memory_cookie(name, value)
{
	expires = new Date();
	expires.setTime(expires.getTime() + (1000 * 86400 * 365));
	value = value.replace('#', '')

	if (value != '')
	{
		set_cookie(name, value.replace('#', ''), expires);
	}
	else
	{
		delete_cookie(name);
	}
}

function grab_memory_cookies()
{
	memory_font = fetch_cookie('shoutbox_fontFamily')
	memory_color = fetch_cookie('shoutbox_color')
	memory_bold = fetch_cookie('shoutbox_fontWeight')
	memory_underline = fetch_cookie('shoutbox_textDecoration')
	memory_italic = fetch_cookie('shoutbox_fontStyle')
	memory_size = fetch_cookie('shoutbox_size');

	if(memory_font == "Impact")
		memory_font = "";
	if (memory_color == "silver" || memory_color == "black")
		memory_color = "";
	if (memory_font != null && memory_font != '')
	{
		obj = document.getElementById('bb_font')

		for (i = 0; i < obj.options.length; i++)
		{
			if (obj.options[i].value == memory_font)
			{
				obj.options[i].selected = true
				sb_PropChange(obj, 'fontFamily')
			}
		}
	}

	if (memory_color != null && memory_color != '')
	{
		obj = document.getElementById('bb_color')

		for (i = 0; i < obj.options.length; i++)
		{
			if (obj.options[i].value == memory_color)
			{
				obj.options[i].selected = true
				sb_PropChange(obj, 'color')
			}
		}
	}

	if (memory_size != null && memory_size != '')
	{
		obj = document.getElementById('bb_size')

		for (i = 0; i < obj.options.length; i++)
		{
			if (obj.options[i].value == memory_size)
			{
				obj.options[i].selected = true
				sb_PropChange(obj, 'size')
			}
		}
	}
	if (memory_bold != null && memory_bold != '')
	{
		sb_PropChange_Button(document.getElementById('bb_bold'), 'fontWeight')
	}

	if (memory_underline != null && memory_underline != '')
	{
		sb_PropChange_Button(document.getElementById('bb_underline'), "textDecoration")
	}

	if (memory_italic != null && memory_italic != '')
	{
		sb_PropChange_Button(document.getElementById('bb_italic'), "fontStyle")
	}

}

function fetch_cookie(name)
{
	cookie_name = name + '=';
	cookie_length = document.cookie.length;
	cookie_begin = 0;
	while (cookie_begin < cookie_length)
	{
		value_begin = cookie_begin + cookie_name.length;
		if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
		{
			var value_end = document.cookie.indexOf (';', value_begin);
			if (value_end == -1)
			{
				value_end = cookie_length;
			}
			var cookie_value = unescape(document.cookie.substring(value_begin, value_end));
			return cookie_value;
		}
		cookie_begin = document.cookie.indexOf(' ', cookie_begin) + 1;
		if (cookie_begin == 0)
		{
			break;
		}
	}
	return null;
}

function set_cookie(name, value, expires)
{
	document.cookie = name + '=' + escape(value) + '; path=/' + (typeof expires != 'undefined' ? '; expires=' + expires.toGMTString() : '');
}

function delete_cookie(name)
{
	document.cookie = name + '=' + '; expires=Thu, 01-Jan-70 00:00:01 GMT' +  '; path=/';
}
grab_memory_cookies()