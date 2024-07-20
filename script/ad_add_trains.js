let stationsList = [];
        let isValid = true;

        function fetchStations() {
            fetch('../process/fetch_stations.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error:', data.error);
                } else {
                    stationsList = data;
                    populateDropdowns(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function populateDropdowns(stations) {
            const fromDropdown = document.querySelector('.from');
            const toDropdown = document.querySelector('.to');

            stations.forEach(station => {
                const optionFrom = document.createElement('option');
                optionFrom.value = station.station_name;
                optionFrom.textContent = station.station_name;
                fromDropdown.appendChild(optionFrom);

                const optionTo = document.createElement('option');
                optionTo.value = station.station_name;
                optionTo.textContent = station.station_name;
                toDropdown.appendChild(optionTo);
            });

            fromDropdown.addEventListener('change', updateToDropdown);
            toDropdown.addEventListener('change', updateFromDropdown);
        }

        function updateToDropdown() {
            const fromDropdown = document.querySelector('.from');
            const toDropdown = document.querySelector('.to');
            const selectedFrom = fromDropdown.value;

            const currentToValue = toDropdown.value;
            toDropdown.innerHTML = '<option disabled hidden selected>To</option>';

            stationsList.forEach(station => {
                if (station.station_name !== selectedFrom) {
                    const optionTo = document.createElement('option');
                    optionTo.value = station.station_name;
                    optionTo.textContent = station.station_name;
                    toDropdown.appendChild(optionTo);
                }
            });

            if (currentToValue && toDropdown.querySelector(`option[value="${currentToValue}"]`)) {
                toDropdown.value = currentToValue;
            }
        }

        function updateFromDropdown() {
            const fromDropdown = document.querySelector('.from');
            const toDropdown = document.querySelector('.to');
            const selectedTo = toDropdown.value;

            const currentFromValue = fromDropdown.value;
            fromDropdown.innerHTML = '<option disabled hidden selected>From</option>';

            stationsList.forEach(station => {
                if (station.station_name !== selectedTo) {
                    const optionFrom = document.createElement('option');
                    optionFrom.value = station.station_name;
                    optionFrom.textContent = station.station_name;
                    fromDropdown.appendChild(optionFrom);
                }
            });

            if (currentFromValue && fromDropdown.querySelector(`option[value="${currentFromValue}"]`)) {
                fromDropdown.value = currentFromValue;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchStations();
            const form = document.querySelector('form');
            form.addEventListener('submit', validateForm);
            document.getElementById("train_no").addEventListener("input", validateTrain);
            document.getElementById("train_name").addEventListener("input", validateTrainName);
            document.getElementById("SS_fare").addEventListener("input", validateSS);
            document.getElementById("AC_fare").addEventListener("input", validateAC);

        });

        function validateForm(event) {
            validateTrain();
            validateTrainName();
            validateSS();
            validateAC();

            const routeMessage = document.getElementById('routeMessage').innerHTML;
            if (routeMessage === 'Route not found' || !isValid) {
                event.preventDefault();
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
                return false; // Prevent form submission
            }

            document.getElementById('checkboxError').style.display = 'none';
            return true;
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

        function validateSS() {
            const SS_fare = document.getElementById("SS_fare");
            const SS_fareError = document.getElementById("SS_fareError");
            const SS_farePattern = /^[0-9]*$/;

            if (!SS_farePattern.test(SS_fare.value)) {
                SS_fare.classList.add("invalid");
                SS_fareError.style.display = "inline";
                isValid = false;
            } else {
                SS_fare.classList.remove("invalid");
                SS_fareError.style.display = "none";
                isValid = true;
            }
        }

        function validateAC() {
            const AC_fare = document.getElementById("AC_fare");
            const AC_fareError = document.getElementById("AC_fareError");
            const AC_farePattern = /^[0-9]*$/;

            if (!AC_farePattern.test(AC_fare.value)) {
                AC_fare.classList.add("invalid");
                AC_fareError.style.display = "inline";
                isValid = false;
            } else {
                AC_fare.classList.remove("invalid");
                AC_fareError.style.display = "none";
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

        function validateTrainNo() {
            const train_no = document.getElementById('train_no').value.trim();
            const form = document.getElementById('signUpForm');
            const formData = new FormData(form);

            fetch('ad_check_train.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("trainMessage").innerHTML = data;
            })
            .catch(error => {
                document.getElementById("trainMessage").innerHTML = 'Error: ' + error;
                console.error('Error:', error);
            });
        }

        function fetchRouteNo() {
            const from = document.getElementById('from_station').value.trim();
            const to = document.getElementById('to_station').value.trim();

            if (from && to) {
                fetch('ad_check_route.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'from_station=' + encodeURIComponent(from) + '&to_station=' + encodeURIComponent(to)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('routeMessage').innerHTML = data.error;
                    } else {
                        document.getElementById('route_code').value = data.route_code;
                        document.getElementById('routeMessage').innerHTML = '';
                    }
                })
                .catch(error => {
                    document.getElementById('routeMessage').innerHTML = 'Error: ' + error;
                    console.error('Error:', error);
                });
            }
        }
