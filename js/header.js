
function insert(el,ins) {
if (el.setSelectionRange){
el.value = el.value.substring(0,el.selectionStart) + ins + el.value.substring(el.selectionStart,el.selectionEnd) + el.value.substring(el.selectionEnd,el.value.length);
}
else if (document.selection && document.selection.createRange) {
el.focus();
var range = document.selection.createRange();
range.text = ins + range.text;
}
}
function addSmilie(smilie, smilieForm, smilieField) {
	var revisedMessage;
	var currentMessage = document.smilieForm.elements[smilieField].value;
	revisedMessage = currentMessage+smilie;
	document.smilieForm.elements[smilieField].value=revisedMessage;
	document.smilieForm.elements[smilieField].focus();
	return;
}