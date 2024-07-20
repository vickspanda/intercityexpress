    // Function to fetch station details
    function fetchStationDetails() {
        var stationName = document.getElementById('username').value.trim();

        if (stationName) {
            fetch('fetch_station_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'station_name=' + encodeURIComponent(stationName)
            })
            .then(response => response.text()) // Get response as text
            .then(data => {
                try {
                    const jsonData = JSON.parse(data); // Parse JSON

                    if (jsonData.error) {
                        document.getElementById('usernameMessage').innerHTML = jsonData.error;
                    } else {
                        document.getElementById('stationCode').value = jsonData.station_code;
                        document.getElementById('state').value = jsonData.state;
                        document.getElementById('pltfno').value = jsonData.no_of_platform;
                        document.getElementById('usernameMessage').innerHTML = '';
                    }
                } catch (error) {
                    document.getElementById('usernameMessage').innerHTML = 'Error parsing JSON: ' + error;
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(error => {
                document.getElementById('usernameMessage').innerHTML = 'Error: ' + error;
                console.error('Error:', error);
            });
        }
    }

    // Function to validate the form before submission
    function validateForm(event) {
        var usernameMessage = document.getElementById('usernameMessage').innerHTML;
        if (usernameMessage === 'Station not found') {
            event.preventDefault(); // Prevent form submission
            alert('Please correct the errors before submitting the form.');
        }
    }