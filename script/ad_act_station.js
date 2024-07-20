// Function to check username availability
function validateUsername() {
    var username = document.getElementById('username').value;
    var userType = document.getElementById('userType').value;
    var wtdo = document.getElementById('do').value;
    userType.trim();
    wtdo.trim();

    // Simulate form submission to check username availability
    var form = document.getElementById('signUpForm');
    var formData = new FormData(form);

    fetch('ad_check_un.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('usernameMessage').innerHTML = data;
    })
    .catch(error => {
        document.getElementById('usernameMessage').innerHTML = 'Error: ' + error;
        console.error('Error:', error);
    });
}

// Function to validate the form before submission
function validateForm(event) {
    var usernameMessage = document.getElementById('usernameMessage').innerHTML;
    if (usernameMessage === 'Station Not Found') {
        event.preventDefault(); // Prevent form submission
        alert('Please Correct the Errors before submitting the Form.');
    }
}