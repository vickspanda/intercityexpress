async function fetchStationName(station_code){
    if (station_code) {
        try {
            const response = await fetch('fetch_station_name.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'station_code=' + encodeURIComponent(station_code)
            });
            const data = await response.text();
            const jsonData = JSON.parse(data);

            if (jsonData.error) {
                document.getElementById('trainMessage').innerHTML = jsonData.error;
            } else {
                return jsonData.station_name;
            }
        } catch (error) {
            document.getElementById('trainMessage').innerHTML = 'Error: ' + error;
            console.error('Error:', error);
        }
    }
}

async function fetchStations(){
    var train_no = document.getElementById('train_no').value.trim();

    if (train_no) {
        try {
            const response = await fetch('fetch_stations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'train_no=' + encodeURIComponent(train_no)
            });
            const data = await response.text();
            const jsonData = JSON.parse(data);

            if (jsonData.error) {
                document.getElementById('trainMessage').innerHTML = jsonData.error;
            } else {
                var from = jsonData.start_station;
                var to = jsonData.end_station;
                document.getElementById('from_station').value = await fetchStationName(from);
                document.getElementById('to_station').value = await fetchStationName(to);
                document.getElementById('trainMessage').innerHTML = '';
            }
        } catch (error) {
            document.getElementById('trainMessage').innerHTML = 'Error: ' + error;
            console.error('Error:', error);
        }
    }
}

async function fetchTrainDetails() {
    var train_no = document.getElementById('train_no').value.trim();

    if (train_no) {
        try {
            const response = await fetch('fetch_train_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'train_no=' + encodeURIComponent(train_no)
            });
            const data = await response.text();
            const jsonData = JSON.parse(data);

            if (jsonData.error) {
                document.getElementById('trainMessage').innerHTML = jsonData.error;
            } else {
                document.getElementById('route_code').value = jsonData.route_code;
                document.getElementById('train_name').value = jsonData.train_name;
                document.getElementById('SS_fare').value = jsonData.ss_fare;
                document.getElementById('AC_fare').value = jsonData.ac_fare;
                document.getElementById('trainMessage').innerHTML = '';
            }
        } catch (error) {
            document.getElementById('trainMessage').innerHTML = 'Error: ' + error;
            console.error('Error:', error);
        }
    }
}

async function fetchScheduleDetails() {
    var train_no = document.getElementById('train_no').value.trim();

    if (train_no) {
        try {
            const response = await fetch('fetch_train_schedule.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'train_no=' + encodeURIComponent(train_no)
            });
            const data = await response.text();
            const jsonData = JSON.parse(data);

            if (jsonData.error) {
                document.getElementById('trainMessage').innerHTML = jsonData.error;
            } else {
                document.getElementById('dep').value = jsonData.dep;
                document.querySelector('input[name="mon"]').checked = jsonData.mon === "TRUE";
                document.querySelector('input[name="tue"]').checked = jsonData.tue === "TRUE";
                document.querySelector('input[name="wed"]').checked = jsonData.wed === "TRUE";
                document.querySelector('input[name="thu"]').checked = jsonData.thu === "TRUE";
                document.querySelector('input[name="fri"]').checked = jsonData.fri === "TRUE";
                document.querySelector('input[name="sat"]').checked = jsonData.sat === "TRUE";
                document.querySelector('input[name="sun"]').checked = jsonData.sun === "TRUE";
                document.getElementById('trainMessage').innerHTML = '';
            }
        } catch (error) {
            document.getElementById('trainMessage').innerHTML = 'Error: ' + error;
            console.error('Error:', error);
        }
    }
}

function fetchDetails() {
    fetchScheduleDetails();
    fetchTrainDetails();
    fetchStations();
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
    document.getElementById("train_no").addEventListener("input", validateTrain);
    document.getElementById("train_name").addEventListener("input", validateTrainName);
});

function validateForm(event) {
    validateTrain();
    validateTrainName();
    var trainMessage = document.getElementById('trainMessage').innerHTML;
    if (trainMessage === 'Train not found') {
        event.preventDefault(); // Prevent form submission
        alert('Please correct the errors before submitting the form.');
    }

    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let isChecked = false;

    // Check if at least one checkbox is checked
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            isChecked = true;
        }
    });

    // If no checkbox is checked, show error message and prevent form submission
    if (!isChecked) {
        document.getElementById('checkboxError').style.display = 'block';
        event.preventDefault(); // Prevent form submission
    } else {
        document.getElementById('checkboxError').style.display = 'none';
    }
}

function validateTrain() {
    const train_no = document.getElementById("train_no");
    const trainNoError = document.getElementById("trainNoError");
    const trainNoPattern = /^[0-9]*$/;

    if (!trainNoPattern.test(train_no.value)) {
        train_no.classList.add("invalid");
        trainNoError.style.display = "inline";
        isValid = false;
    } else {
        train_no.classList.remove("invalid");
        trainNoError.style.display = "none";
        isValid = true;
    }
}

function validateTrainName() {
    const train_name = document.getElementById("train_name");
    const trainNameError = document.getElementById("trainNameError");

    if (train_name.value.length > 100) {
        train_name.classList.add("invalid");
        trainNameError.style.display = "inline";
        isValid = false;
    } else {
        train_name.classList.remove("invalid");
        trainNameError.style.display = "none";
        isValid = true;
    }
}