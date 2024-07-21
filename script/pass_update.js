const districts = {
    "Andaman and Nicobar Islands" : ["Nicobar","North and Middle Andaman","South Andaman" ],
                            "Andhra Pradesh": ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Krishna", "Kurnool", "Nellore", "Prakasam", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari", "Y.S.R. Kadapa"],
                            "Arunachal Pradesh": ["Tawang", "West Kameng", "East Kameng", "Papum Pare", "Kurung Kumey", "Kra Daadi", "Lower Subansiri", "Upper Subansiri", "West Siang", "East Siang", "Siang", "Upper Siang", "Lower Siang", "Lower Dibang Valley", "Dibang Valley", "Anjaw", "Lohit", "Namsai", "Changlang", "Tirap", "Longding"],
                            "Assam": ["Baksa","Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo","Chirang","Darrang", "Dhemaji","Dhubri", "Dibrugarh", "Dima Hasao", "Goalpara", "Golaghat","Hailakandi","Hojai", "Jorhat","Kamrup","Kamrup Metropolitan","Karbi Anglong","Karimganj","Kokrajhar","Lakhimpur","Majuli","Morigaon","Nagaon","Nalbari", "Sivasagar","Sonitpur","South Salmara-Mankachar","Tinsukia","Udalguri","West Karbi Anglong"],
                            "Bihar" : ["Araria","Arwal","Aurangabad","Banka","Begusarai","Bhagalpur","Bhojpur","Buxar","Darbhanga","East Champaran (Motihari)","Gaya","Gopalganj","Jamui","Jehanabad","Kaimur (Bhabua)","Katihar","Khagaria","Kishanganj","Lakhisarai","Madhepura","Madhubani","Munger (Monghyr)","Muzaffarpur","Nalanda","Nawada","Patna","Purnia (Purnea)","Rohtas","Saharsa","Samastipur","Saran","Sheikhpura","Sheohar","Sitamarhi","Siwan","Supaul","Vaishali","West Champaran"],
                            "Chandigarh" : ["Chandigarh"],
                            "Chhattisgarh" : ["Balod","Baloda Bazar","Balrampur","Bastar","Bemetara","Bijapur","Bilaspur","Dantewada","Dhamtari","Durg","Gariaband","Janjgir-Champa","Jashpur","Kabirdham (Kawardha)","Kanker","Kondagaon","Korba","Koriya","Mahasamund","Mungeli","Narayanpur","Raigarh","Raipur","Rajnandgaon","Sukma","Surajpur","Surguja"],
                            "Dadra and Nagar Haveli and Daman And Diu" : ["Dadra and Nagar Haveli","Daman","Diu"],
                            "Delhi" : ["Central Delhi","East Delhi","New Delhi","North Delhi","North East Delhi","North West Delhi","Shahdara","South Delhi","South East Delhi","South West Delhi","West Delhi"],
                            "Goa" : ["North Goa","South Goa"],
                            "Gujarat" : ["Ahmedabad","Amreli","Anand","Aravalli","Banaskantha","Bharuch","Bhavnagar","Botad","Chhota Udaipur","Dahod","Dang","Devbhoomi Dwarka","Gandhinagar","Gir Somnath","Jamnagar","Junagadh","Kutch","Kheda","Mahisagar","Mehsana","Morbi","Narmada","Navsari","Panchmahal","Patan","Porbandar","Rajkot","Sabarkantha","Surat","Surendranagar","Tapi","Vadodara","Valsad"],
                            "Haryana" : ["Ambala","Bhiwani","Charkhi Dadri","Faridabad","Fatehabad","Gurugram","Hisar","Jhajjar","Jind","Kaithal","Karnal","Kurukshetra","Mahendragarh","Nuh","Palwal","Panchkula","Panipat","Rewari","Rohtak","Sirsa","Sonipat","Yamunanagar"],
                            "Himachal Pradesh" : ["Bilaspur","Chamba","Hamirpur","Kangra","Kinnaur","Kullu","Lahaul and Spiti","Mandi","Shimla","Sirmaur","Solan","Una"],
                            "Jharkhand": ["Bokaro","Chatra","Deoghar","Dhanbad","Dumka","East Singhbhum","Garhwa","Giridih","Godda","Gumla","Hazaribagh","Jamtara","Khunti","Koderma","Latehar","Lohardaga","Pakur","Palamu","Ramgarh","Ranchi","Sahibganj","Seraikela Kharsawan","Simdega","West Singhbhum"],
                            "Jammu and Kashmir" : ["Anantnag","Bandipora","Baramulla","Budgam","Doda","Ganderbal","Jammu","Kathua","Kishtwar","Kulgam","Kupwara","Poonch","Pulwama","Rajouri","Ramban","Reasi","Samba","Shopian","Srinagar","Udhampur"],
                            "Ladakh" : ["Leh","Kargil"],
                            "Lakshadweep": ["Lakshadweep"],
                            "Karnataka": ["Bagalkot","Ballari (Bellary)","Belagavi (Belgaum)","Bengaluru Rural","Bengaluru Urban","Bidar","Chamarajanagar","Chikballapur","Chikkamagaluru (Chikmagalur)","Chitradurga","Dakshina Kannada","Davangere","Dharwad","Gadag","Hassan","Haveri","Kalaburagi (Gulbarga)","Kodagu","Kolar","Koppal","Mandya","Mysuru (Mysore)","Raichur","Ramanagara","Shivamogga (Shimoga)","Tumakuru (Tumkur)","Udupi","Uttara Kannada (Karwar)","Vijayapura (Bijapur)","Yadgir"],
                            "Madhya Pradesh" : ["Agar Malwa","Alirajpur","Anuppur","Ashoknagar","Balaghat","Barwani","Betul","Bhind","Bhopal","Burhanpur","Chhatarpur","Chhindwara","Damoh","Datia","Dewas","Dhar","Dindori","Guna","Gwalior","Harda","Hoshangabad","Indore","Jabalpur","Jhabua","Katni","Khandwa","Khargone","Mandla","Mandsaur","Morena","Narsinghpur","Neemuch","Panna","Raisen","Rajgarh","Ratlam","Rewa","Sagar","Satna","Sehore","Seoni","Shahdol","Shajapur","Sheopur","Shivpuri","Sidhi","Singrauli","Tikamgarh","Ujjain","Umaria","Vidisha"],
                            "Maharashtra" : ["Ahmednagar","Akola","Amravati","Aurangabad","Beed","Bhandara","Buldhana","Chandrapur","Dhule","Gadchiroli","Gondia","Hingoli","Jalgaon","Jalna","Kolhapur","Latur","Mumbai City","Mumbai Suburban","Nagpur","Nanded","Nandurbar","Nashik","Osmanabad","Palghar","Parbhani","Pune","Raigad","Ratnagiri","Sangli","Satara","Sindhudurg","Solapur","Thane","Wardha","Washim","Yavatmal"],
                            "Manipur" : ["Bishnupur","Chandel","Churachandpur","Imphal East","Imphal West","Jiribam","Kakching","Kamjong","Kangpokpi","Noney","Pherzawl","Senapati","Tamenglong","Tengnoupal","Thoubal","Ukhrul"],
                            "Meghalaya" : ["East Garo Hills","East Jaintia Hills","East Khasi Hills","North Garo Hills","Ribhoi","South Garo Hills","South West Garo Hills","South West Khasi Hills","West Garo Hills","West Jaintia Hills","West Khasi Hills"],
                            "Mizoram" : ["Aizawl","Champhai","Kolasib","Lawngtlai","Lunglei","Mamit","Saiha","Serchhip"],
                            "Odisha" : ["Angul","Balangir","Balasore","Bargarh","Bhadrak","Boudh","Cuttack","Deogarh","Dhenkanal","Gajapati","Ganjam","Jagatsinghpur","Jajpur","Jharsuguda","Kalahandi","Kandhamal","Kendrapara","Kendujhar (Keonjhar)","Khordha","Koraput","Malkangiri","Mayurbhanj","Nabarangpur","Nayagarh","Nuapada","Puri","Rayagada","Sambalpur","Subarnapur (Sonepur)","Sundargarh"],
                            "Nagaland" : ["Dimapur","Kiphire","Kohima","Longleng","Mokokchung","Mon","Peren","Phek","Tuensang","Wokha","Zunheboto"],
                            "Puducherry" : ["Puducherry","Karaikal","Mahe","Yanam"],
                            "Punjab" : ["Amritsar","Barnala","Bathinda","Faridkot","Fatehgarh Sahib","Fazilka","Ferozepur","Gurdaspur","Hoshiarpur","Jalandhar","Kapurthala","Ludhiana","Mansa","Moga","Muktsar","Pathankot","Patiala","Rupnagar (Ropar)","Sahibzada Ajit Singh Nagar (Mohali)","Sangrur","Shahid Bhagat Singh Nagar (Nawanshahr)","Sri Muktsar Sahib","Tarn Taran"],
                            "Rajasthan" : ["Ajmer","Alwar","Banswara","Baran","Barmer","Bharatpur","Bhilwara","Bikaner","Bundi","Chittorgarh","Churu","Dausa","Dholpur","Dungarpur","Hanumangarh","Jaipur","Jaisalmer","Jalore","Jhalawar","Jhunjhunu","Jodhpur","Karauli","Kota","Nagaur","Pali","Pratapgarh","Rajsamand","Sawai Madhopur","Sikar","Sirohi","Sri Ganganagar","Tonk","Udaipur"],
                            "Sikkim" : ["East Sikkim","North Sikkim","South Sikkim","West Sikkim"],
                            "Kerala" : ["Alappuzha","Ernakulam","Idukki","Kannur","Kasaragod","Kollam","Kottayam","Kozhikode","Malappuram","Palakkad","Pathanamthitta","Thiruvananthapuram","Thrissur","Wayanad"],
                            "Tamil Nadu" : ["Ariyalur","Chengalpattu","Chennai","Coimbatore","Cuddalore","Dharmapuri","Dindigul","Erode","Kallakurichi","Kanchipuram","Kanyakumari","Karur","Krishnagiri","Madurai","Mayiladuthurai","Nagapattinam","Namakkal","Nilgiris","Perambalur","Pudukkottai","Ramanathapuram","Ranipet","Salem","Sivaganga","Tenkasi","Thanjavur","Theni","Thoothukudi","Tiruchirappalli","Tirunelveli","Tirupathur","Tiruppur","Tiruvallur","Tiruvannamalai","Tiruvarur","Vellore","Viluppuram","Virudhunagar"],
                            "Telangana" : ["Adilabad","Bhadradri Kothagudem","Hyderabad","Jagtial","Jangaon","Jayashankar Bhupalapally","Jogulamba Gadwal","Kamareddy","Karimnagar","Khammam","Komaram Bheem","Mahabubabad","Mahabubnagar","Mancherial","Medak","Medchal-Malkajgiri","Nagarkurnool","Nalgonda","Nirmal","Nizamabad","Peddapalli","Rajanna Sircilla","Ranga Reddy","Sangareddy","Siddipet","Suryapet","Vikarabad","Wanaparthy","Warangal Rural","Warangal Urban","Yadadri Bhuvanagiri"],
                            "Tripura" : ["Dhalai","Gomati","Khowai","North Tripura","Sepahijala","South Tripura","Unakoti","West Tripura"],
                            "Uttarakhand" : ["Almora","Bageshwar","Chamoli","Champawat","Dehradun","Haridwar","Nainital","Pauri Garhwal","Pithoragarh","Rudraprayag","Tehri Garhwal","Udham Singh Nagar","Uttarkashi"],
                            "Uttar Pradesh" : ["Agra","Aligarh","Allahabad","Ambedkar Nagar","Amethi","Amroha","Auraiya","Azamgarh","Baghpat","Bahraich","Ballia","Balrampur","Banda","Barabanki","Bareilly","Basti","Bijnor","Budaun","Bulandshahr","Chandauli","Chitrakoot","Deoria","Etah","Etawah","Faizabad","Farrukhabad","Fatehpur","Firozabad","Gautam Buddh Nagar","Ghaziabad","Ghazipur","Gonda","Gorakhpur","Hamirpur","Hapur","Hardoi","Hathras","Jalaun","Jaunpur","Jhansi","Kannauj","Kanpur Dehat","Kanpur Nagar","Kasganj","Kaushambi","Kushinagar","Lakhimpur Kheri","Lalitpur","Lucknow","Maharajganj","Mahoba","Mainpuri","Mathura","Mau","Meerut","Mirzapur","Moradabad","Muzaffarnagar","Pilibhit","Pratapgarh","Raebareli","Rampur","Saharanpur","Sambhal","Sant Kabir Nagar","Shahjahanpur","Shamli","Shravasti","Siddharthnagar","Sitapur","Sonbhadra","Sultanpur","Unnao","Varanasi"],
                            "West Bengal" : ["Alipurduar","Bankura","Birbhum","Cooch Behar","Dakshin Dinajpur","Darjeeling","Hooghly","Howrah","Jalpaiguri","Jhargram","Kalimpong","Kolkata","Malda","Murshidabad","Nadia","North 24 Parganas","Paschim Bardhaman","Paschim Medinipur","Purba Bardhaman","Purba Medinipur","Purulia","South 24 Parganas","Uttar Dinajpur"],
};

function populateDistricts() {
    const stateSelect = document.getElementById('state');
    const districtSelect = document.getElementById('district');
    const selectedState = stateSelect.value;


    if (districts[selectedState]) {
        districts[selectedState].forEach(function(district) {
            const option = document.createElement('option');
            option.text = district;
            option.value = district;
            districtSelect.add(option);
        });
    }
}

document.getElementById('state').addEventListener('change', populateDistricts);

// Function to check username availability
function validateUsername() {
    var username = document.getElementById('p_username').value;
    if (username.trim() === '') {
        document.getElementById('usernameMessage').innerHTML = 'Please enter a username.';
        return;
    }

    // Simulate form submission to check username availability
    var form = document.getElementById('signUpForm');
    var formData = new FormData(form);

    fetch('check_username.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('usernameMessage').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}

document.getElementById('p_username').addEventListener('blur', validateUsername);

// Add event listener for form submission to validate inputs
document.getElementById('signUpForm').addEventListener('submit', function(event) {
    var nameInput = document.getElementById('p_name');
    var addressInput = document.getElementById('p_address');
    var pincodeInput = document.getElementById('p_pincode');
    var dobInput = document.getElementById('p_dob');
    var mobileInput = document.getElementById('p_mobile');
    var emailInput = document.getElementById('p_email');
    
    var nameError = document.getElementById('nameError');
    var addressError = document.getElementById('addressError');
    var pincodeError = document.getElementById('pincodeError');
    var dobError = document.getElementById('dobError');
    var mobileError = document.getElementById('mobileError');
    var emailError = document.getElementById('emailError');

    var isValid = true;

    // Validate Full Name
    if (nameInput.value.trim().length > 60) {
        nameError.style.display = 'block';
        nameInput.classList.add('invalid');
        isValid = false;
    } else {
        nameError.style.display = 'none';
        nameInput.classList.remove('invalid');
    }

    // Validate Address
    if (addressInput.value.trim().length > 500) {
        addressError.style.display = 'block';
        addressInput.classList.add('invalid');
        isValid = false;
    } else {
        addressError.style.display = 'none';
        addressInput.classList.remove('invalid');
    }

    // Validate Pin Code
    var pincodePattern = /^[1-9][0-9]{5}$/;
    if (!pincodePattern.test(pincodeInput.value.trim())) {
        pincodeError.style.display = 'block';
        pincodeInput.classList.add('invalid');
        isValid = false;
    } else {
        pincodeError.style.display = 'none';
        pincodeInput.classList.remove('invalid');
    }

    // Validate Date of Birth
    if (dobInput.value.trim() === '') {
        dobError.style.display = 'block';
        dobInput.classList.add('invalid');
        isValid = false;
    } else {
        dobError.style.display = 'none';
        dobInput.classList.remove('invalid');
    }

    // Validate Mobile Number
    var mobilePattern = /^[6-9][0-9]{9}$/;
    if (!mobilePattern.test(mobileInput.value.trim())) {
        mobileError.style.display = 'block';
        mobileInput.classList.add('invalid');
        isValid = false;
    } else {
        mobileError.style.display = 'none';
        mobileInput.classList.remove('invalid');
    }

    // Validate Email
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(emailInput.value.trim())) {
        emailError.style.display = 'block';
        emailInput.classList.add('invalid');
        isValid = false;
    } else {
        emailError.style.display = 'none';
        emailInput.classList.remove('invalid');
    }

    if (!isValid) {
        event.preventDefault();
    }
});


document.getElementById("p_name").addEventListener("input", function() {
    const name = document.getElementById("p_name");
    const nameError = document.getElementById("nameError");
    if (name.value.length > 60) {
        name.classList.add("invalid");
        nameError.style.display = "inline";
    } else {
        name.classList.remove("invalid");
        nameError.style.display = "none";
    }
});

document.getElementById("p_address").addEventListener("input", function() {
    const address = document.getElementById("p_address");
        const addressError = document.getElementById("addressError");
        if (address.value.length > 500) {
            address.classList.add("invalid");
            addressError.style.display = "inline";
            isValid = false;
        } else {
            address.classList.remove("invalid");
            addressError.style.display = "none";
        }
});

document.getElementById("p_pincode").addEventListener("input", function() {
    const pincode = document.getElementById("p_pincode");
        const pincodeError = document.getElementById("pincodeError");
        const pinPattern = /^[0-9]{6}$/;
        if (!pinPattern.test(pincode.value)) {
            pincode.classList.add("invalid");
            pincodeError.style.display = "inline";
            isValid = false;
        } else {
            pincode.classList.remove("invalid");
            pincodeError.style.display = "none";
        }
});

document.getElementById("p_mobile").addEventListener("input", function() {
    const mobile = document.getElementById("p_mobile");
        const mobileError = document.getElementById("mobileError");
        const mobilePattern = /^[0-9]{10}$/;
        
        if (!mobilePattern.test(mobile.value)) {
            mobile.classList.add("invalid");
            mobileError.style.display = "inline";
            isValid = false;
        } else {
            mobile.classList.remove("invalid");
            mobileError.style.display = "none";
        }
});

document.getElementById("p_email").addEventListener("input", function() {
    const email = document.getElementById("p_email");
        const emailError = document.getElementById("emailError");
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email.value)) {
            email.classList.add("invalid");
            emailError.style.display = "inline";
            isValid = false;
        } else {
            email.classList.remove("invalid");
            emailError.style.display = "none";
        }
});


function setDateRange() {
    const dateInput = document.querySelector('input[name="p_dob"]');
    const today = new Date();
    const maxDate = new Date(today);

    maxDate.setDate(today.getDate() - 6570); // 8 days from today

    dateInput.max = maxDate.toISOString().split('T')[0];

    console.log("Date range set:", dateInput.max); // Debug log
}

// Function to validate the form before submission
function validateForm(event) {
    const dateInput = document.querySelector('input[name="p_dob"]');
    const selectedDate = new Date(dateInput.value);
    const maxDate = new Date(dateInput.max);

    if (selectedDate > maxDate) {
        event.preventDefault(); // Prevent form submission
        alert(`Passenger's Age can't be smaller than 18 !!!`);
    }
}

// Call fetchStations and setDateRange on page load
document.addEventListener('DOMContentLoaded', () => {
    setDateRange();

    // Add event listener to the form
    const form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
});