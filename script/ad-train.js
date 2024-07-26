document.addEventListener("DOMContentLoaded", function() {
    // Function to check if the input is a number
    function isNumber(value) {
        return /^\d+$/.test(value);
    }

    // Function to fetch train details and validate train number
    function fetchDetails() {
        const trainNoInput = document.getElementById("train_no");
        const trainNoError = document.getElementById("trainNoError");
        const trainMessage = document.getElementById("trainMessage");

        const trainNo = trainNoInput.value;

        // Check if train number is a number
        if (!isNumber(trainNo)) {
            trainNoError.style.display = "block";
            trainNoInput.classList.add("invalid");
            trainMessage.innerHTML = "";
        } else {
            trainNoError.style.display = "none";
            trainNoInput.classList.remove("invalid");

            // Fetch train details from server
            fetch(`../process/fetch_train_details.php?train_no=${trainNo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        trainMessage.innerHTML = "";
                    } else {
                        trainMessage.innerHTML = "Train not found!";
                    }
                })
                .catch(error => {
                    trainMessage.innerHTML = "Error fetching train details!";
                });
        }
    }

    // Function to validate the form
    function validateForm() {
        const trainNoInput = document.getElementById("train_no");
        const trainNoError = document.getElementById("trainNoError");
        const trainMessage = document.getElementById("trainMessage");
        const trainNo = trainNoInput.value;

        let isValid = true;

        // Validate train number
        if (!isNumber(trainNo)) {
            trainNoError.style.display = "block";
            trainNoInput.classList.add("invalid");
            isValid = false;
        } else {
            trainNoError.style.display = "none";
            trainNoInput.classList.remove("invalid");
        }

        // Check if train is found
        if (trainMessage.innerHTML === "Train not found!") {
            isValid = false;
        }

        return isValid;
    }

    // Attach event listeners
    document.getElementById("train_no").addEventListener("blur", fetchDetails);
    document.getElementById("signUpForm").addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
