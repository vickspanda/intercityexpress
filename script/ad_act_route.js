let stationsList = [];
        let isValid = true;

        function fetchStations() {
            fetch('../process/fetch_stations_act.php')
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

        function fetchRouteNo() {
            const from = document.getElementById('from_station').value.trim();
            const to = document.getElementById('to_station').value.trim();

            if (from && to) {
                fetch('ad_get_route.php', {
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

        document.addEventListener('DOMContentLoaded', () => {
            fetchStations();
            const form = document.querySelector('form');
            form.addEventListener('submit', validateForm);
        });
        function validateForm(event) {
        const routeMessage = document.getElementById('routeMessage').innerText;
        if (routeMessage) {
            event.preventDefault();
            alert('Please resolve the errors before submitting the form.');
        }
}

