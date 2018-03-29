var dmn_formSubmitted = false;
if (typeof(document.getElementById) == "undefined")
	document.getElementById = function (id)
	{
		return document.all[id];
	}
function reqWin(desktopURL, alternateWidth, alternateHeight)
{
	window.open(desktopURL, 'requested_popup', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,width=' + (alternateWidth ? alternateWidth : 480) + ',height=' + (alternateHeight ? alternateHeight : 220) + ',resizable=no');
	return false;
}
function storeCaret(text)
{
	if (typeof(text.createTextRange) != 'undefined')
		text.caretPos = document.selection.createRange().duplicate();
}
function replaceText(text, textarea)
{
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange)
	{
		var caretPos = textarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		caretPos.select();
	}
	else if (typeof(textarea.selectionStart) != "undefined")
	{
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var scrollPos = textarea.scrollTop;
		textarea.value = begin + text + end;
		if (textarea.setSelectionRange)
		{
			textarea.focus();
			textarea.setSelectionRange(begin.length + text.length, begin.length + text.length);
		}
		textarea.scrollTop = scrollPos;
	}
	else
	{
		textarea.value += text;
		textarea.focus(textarea.value.length - 1);
	}
}
function surroundText(text1, text2, textarea)
{
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange)
	{
		var caretPos = textarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text1 + caretPos.text + text2 + ' ' : text1 + caretPos.text + text2;
		caretPos.select();
	}
	else if (typeof(textarea.selectionStart) != "undefined")
	{
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;
		textarea.value = begin + text1 + selection + text2 + end;
		if (textarea.setSelectionRange)
		{
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length, newCursorPos + text1.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	else
	{
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}
}
function isEmptyText(theField)
{
	var theValue = theField.value;
	while (theValue.length > 0 && (theValue.charAt(0) == ' ' || theValue.charAt(0) == '\t'))
		theValue = theValue.substring(1, theValue.length);
	while (theValue.length > 0 && (theValue.charAt(theValue.length - 1) == ' ' || theValue.charAt(theValue.length - 1) == '\t'))
		theValue = theValue.substring(0, theValue.length - 1);
	if (theValue == '')
		return true;
	else
		return false;
}
function submitonce(theform)
{
	dmn_formSubmitted = true;
}
function submitThisOnce(item)
{
	if (navigator.userAgent.indexOf('AppleWebKit') != -1)
		return !dmn_formSubmitted;
	for (var i = 0; i < item.form.length; i++)
		if (typeof(item.form[i]) != "undefined" && item.form[i].tagName.toLowerCase() == "textarea")
			item.form[i].readOnly = true;
	return !dmn_formSubmitted;
}
function setInnerHTML(element, toValue)
{
	if (typeof(element.innerHTML) != 'undefined')
		element.innerHTML = toValue;
	else
	{
		var range = document.createRange();
		range.selectNodeContents(element);
		range.deleteContents();
		element.appendChild(range.createContextualFragment(toValue));
	}
}
function setOuterHTML(element, toValue)
{
	if (typeof(element.outerHTML) != 'undefined')
		element.outerHTML = toValue;
	else
	{
		var range = document.createRange();
		range.setStartBefore(element);
		element.parentNode.replaceChild(range.createContextualFragment(toValue), element);
	}
}
function getInnerHTML(element)
{
	if (typeof(element.innerHTML) != 'undefined')
		return element.innerHTML;
	else
	{
		var returnStr = '';
		for (var i = 0; i < element.childNodes.length; i++)
			returnStr += getOuterHTML(element.childNodes[i]);
		return returnStr;
	}
}
function getOuterHTML(node)
{
	if (typeof(node.outerHTML) != 'undefined')
		return node.outerHTML;
	var str = '';
	switch (node.nodeType)
	{
		case 1:
			str += '<' + node.nodeName;
			for (var i = 0; i < node.attributes.length; i++)
			{
				if (node.attributes[i].nodeValue != null)
					str += ' ' + node.attributes[i].nodeName + '="' + node.attributes[i].nodeValue + '"';
			}
			if (node.childNodes.length == 0 && in_array(node.nodeName.toLowerCase(), ['hr', 'input', 'img', 'link', 'meta', 'br']))
				str += ' />';
			else
				str += '>' + getInnerHTML(node) + '</' + node.nodeName + '>';
			break;
		case 3:
			str += node.nodeValue;
			break;
		case 4:
			str += '<![CDATA' + '[' + node.nodeValue + ']' + ']>';
			break;
		case 5:
			str += '&' + node.nodeName + ';';
			break;
		case 8:
			str += '<!--' + node.nodeValue + '-->';
			break;
	}
	return str;
}
function in_array(variable, theArray)
{
	for (var i = 0; i < theArray.length; i++)
	{
		if (theArray[i] == variable)
			return true;
	}
	return false;
}


