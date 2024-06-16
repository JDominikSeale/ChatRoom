setInterval(function() {
    sessionStorage.setItem('storedText', document.getElementById('textMessageBox').value);
    fetch('../scripts/checkRefresh.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            if (data == 'new_message') {
                location.reload();
            }
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}, 5000);