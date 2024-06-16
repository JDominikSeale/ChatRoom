var messageContainer = document.getElementById('messageContainer');
messageContainer.scrollTop = messageContainer.scrollHeight;
var textMessageBox = document.getElementById('textMessageBox');
textMessageBox.value = sessionStorage.getItem('storedText');