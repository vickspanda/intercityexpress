let stationsList = [];
let booking_limit = 0;

// Function to fetch station names and populate dropdowns
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


// Function to populate dropdowns with station names
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

    // Add event listeners
    fromDropdown.addEventListener('change', updateToDropdown);
    toDropdown.addEventListener('change', updateFromDropdown);
}

// Function to update the "To" dropdown based on the "From" selection
function updateToDropdown() {
    const fromDropdown = document.querySelector('.from');
    const toDropdown = document.querySelector('.to');
    const selectedFrom = fromDropdown.value;

    // Preserve current "To" value
    const currentToValue = toDropdown.value;

    // Clear current "To" options
    toDropdown.innerHTML = '<option disabled hidden selected>To</option>';

    // Populate "To" dropdown excluding the selected "From" value
    stationsList.forEach(station => {
        if (station.station_name !== selectedFrom) {
            const optionTo = document.createElement('option');
            optionTo.value = station.station_name;
            optionTo.textContent = station.station_name;
            toDropdown.appendChild(optionTo);
        }
    });

    // Restore previously selected "To" value if still valid
    if (currentToValue && toDropdown.querySelector(`option[value="${currentToValue}"]`)) {
        toDropdown.value = currentToValue;
    }
}

// Function to update the "From" dropdown based on the "To" selection
function updateFromDropdown() {
    const fromDropdown = document.querySelector('.from');
    const toDropdown = document.querySelector('.to');
    const selectedTo = toDropdown.value;

    // Preserve current "From" value
    const currentFromValue = fromDropdown.value;

    // Clear current "From" options
    fromDropdown.innerHTML = '<option disabled hidden selected>From</option>';

    // Populate "From" dropdown excluding the selected "To" value
    stationsList.forEach(station => {
        if (station.station_name !== selectedTo) {
            const optionFrom = document.createElement('option');
            optionFrom.value = station.station_name;
            optionFrom.textContent = station.station_name;
            fromDropdown.appendChild(optionFrom);
        }
    });

    // Restore previously selected "From" value if still valid
    if (currentFromValue && fromDropdown.querySelector(`option[value="${currentFromValue}"]`)) {
        fromDropdown.value = currentFromValue;
    }
}


// Call fetchStations and bookingLimit on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchStations();

    // Add event listener to the form
    const form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
});
