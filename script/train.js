// Function to check username availability
function validateTrain() {
    var train_no = document.getElementById('train').value.trim();

    // Simulate form submission to check username availability
    var form = document.getElementById('signUpForm');
    var formData = new FormData(form);

    fetch('ad_check_train.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('trainMessage').innerHTML = data;
    })
    .catch(error => {
        document.getElementById('trainMessage').innerHTML = 'Error: ' + error;
        console.error('Error:', error);
    });
}

// Function to validate the form before submission
function validateForm(event) {
    var trainMessage = document.getElementById('trainMessage').innerHTML;
    if (trainMessage === 'Train Not Found !!!') {
        event.preventDefault(); // Prevent form submission
        alert('Please Correct the Errors before submitting the Form.');
    }
}