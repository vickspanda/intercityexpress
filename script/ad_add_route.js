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
            document.getElementById("r_dist").addEventListener("input", validatePincode);
            document.getElementById("r_time").addEventListener("input", validateTime);
        });

        function validateForm(event) {
            validatePincode();
            validateTime();
            var usernameMessage = document.getElementById('usernameMessage').innerHTML;
            if (usernameMessage === 'Station Already Exists' || !isValid) {
                event.preventDefault();
                alert('Please Correct the Errors before submitting the Form.');
            }
        }

        function validatePincode() {
            const pincode = document.getElementById("r_dist");
            const pincodeError = document.getElementById("distError");
            const pinPattern = /^[0-9]*$/;

            if (!pinPattern.test(pincode.value)) {
                pincode.classList.add("invalid");
                pincodeError.style.display = "inline";
                isValid = false;
            } else {
                pincode.classList.remove("invalid");
                pincodeError.style.display = "none";
                isValid = true;
            }
        }

        function validateTime() {
            const time = document.getElementById("r_time");
            const timeError = document.getElementById("timeError");
            const timePattern = /^[0-9]*$/;

            if (!timePattern.test(time.value)) {
                time.classList.add("invalid");
                timeError.style.display = "inline";
                isValid = false;
            } else {
                time.classList.remove("invalid");
                timeError.style.display = "none";
                isValid = true;
            }
        }

        function validateUsername() {
            var username = document.getElementById('username').value;
            var userType = document.getElementById('userType').value;
            var wtdo = document.getElementById('do').value;

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