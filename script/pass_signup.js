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

    fetch('../process/check_username.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('usernameMessage').innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

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
    const stateSelect = document.getElementById("state");
    const districtSelect = document.getElementById("district");
    const selectedState = stateSelect.value;

    districtSelect.innerHTML = '<option value="" disabled hidden selected>Select District</option>';

    if (districts[selectedState]) {
        districts[selectedState].forEach(function(district) {
            const option = document.createElement("option");
            option.text = district;
            option.value = district;
            districtSelect.add(option);
        });
    }
}

document.getElementById("state").addEventListener("change", populateDistricts);
populateDistricts();

document.getElementById("signUpForm").addEventListener("submit", function(event) {
    let isValid = true;

    // Validate Full Name
    const name = document.getElementById("p_name");
    const nameError = document.getElementById("nameError");
    if (name.value.length > 60) {
        name.classList.add("invalid");
        nameError.style.display = "inline";
        isValid = false;
    } else {
        name.classList.remove("invalid");
        nameError.style.display = "none";
    }

    // Validate Address
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

    // Validate Pincode
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

    // Validate Date of Birth
    const dob = document.getElementById("p_dob");
    const dobError = document.getElementById("dobError");
    
    if (dob.value === "") {
        dob.classList.add("invalid");
        dobError.style.display = "inline";
        isValid = false;
    } else {
        dob.classList.remove("invalid");
        dobError.style.display = "none";
    }

    // Validate Mobile Number
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

    // Validate Email
    const email = document.getElementById("p_email");
    const emailError = document.getElementById("emailError");
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!emailPattern.test(email.value)) {
        email.classList.add("invalid");
        emailError.style.display = "inline";
        isValid = false;
    } else {
        email.classList.remove("invalid");
        emailError.style.display = "none";
    }

    // Validate Gender
    const genderMale = document.getElementById("male");
    const genderFemale = document.getElementById("female");
    const genderError = document.getElementById("genderError");
    
    if (!genderMale.checked && !genderFemale.checked) {
        genderError.style.display = "inline";
        isValid = false;
    } else {
        genderError.style.display = "none";
    }

    // Validate Username
    const username = document.getElementById("p_username");
    const usernameError = document.getElementById("usernameError");
    
    if (username.value.length > 30) {
        username.classList.add("invalid");
        usernameError.style.display = "inline";
        isValid = false;
    } else {
        username.classList.remove("invalid");
        usernameError.style.display = "none";
    }

    // Validate Password
    const password = document.getElementById("p_password");
    const passwordError = document.getElementById("passwordError");
    
    if (password.value.length < 8) {
        password.classList.add("invalid");
        passwordError.style.display = "inline";
        isValid = false;
    } else {
        password.classList.remove("invalid");
        passwordError.style.display = "none";
    }

    // Validate Confirm Password
    const confirmPassword = document.getElementById("p_confirm_password");
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    
    if (password.value !== confirmPassword.value) {
        confirmPassword.classList.add("invalid");
        confirmPasswordError.style.display = "inline";
        isValid = false;
    } else {
        confirmPassword.classList.remove("invalid");
        confirmPasswordError.style.display = "none";
    }

    // Validate Security Question
    const secQues = document.getElementById("sec_ques");
    const secQuesError = document.getElementById("secQuesError");
    
    if (secQues.value === "") {
        secQues.classList.add("invalid");
        secQuesError.style.display = "inline";
        isValid = false;
    } else {
        secQues.classList.remove("invalid");
        secQuesError.style.display = "none";
    }

    // Validate Security Answer
    const secAns = document.getElementById("p_seca");
    const secAnsError = document.getElementById("secAnsError");
    
    if (secAns.value === "") {
        secAns.classList.add("invalid");
        secAnsError.style.display = "inline";
        isValid = false;
    } else {
        secAns.classList.remove("invalid");
        secAnsError.style.display = "none";
    }

    // Validate Terms and Conditions
    const tnc = document.getElementById("tnc");
    const tncError = document.getElementById("tncError");
    
    if (!tnc.checked) {
        tncError.style.display = "inline";
        isValid = false;
    } else {
        tncError.style.display = "none";
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

document.getElementById("p_username").addEventListener("input", function() {
    const username = document.getElementById("p_username");
        const usernameError = document.getElementById("usernameError");
        if (username.value.length > 30) {
            username.classList.add("invalid");
            usernameError.style.display = "inline";
            isValid = false;
        } else {
            username.classList.remove("invalid");
            usernameError.style.display = "none";
        }
});

document.getElementById("p_password").addEventListener("input", function() {
    const password = document.getElementById("p_password");
    const passwordError = document.getElementById("passwordError");
    if (password.value.length < 8) {
            password.classList.add("invalid");
            passwordError.style.display = "inline";
            isValid = false;
        } else {
            password.classList.remove("invalid");
            passwordError.style.display = "none";
        }
});

document.getElementById("p_confirm_password").addEventListener("input", function() {
    const password = document.getElementById("p_password");
        const passwordError = document.getElementById("passwordError");
        const confirmPassword = document.getElementById("p_confirm_password");
        const confirmPasswordError = document.getElementById("confirmPasswordError");
        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add("invalid");
            confirmPasswordError.style.display = "inline";
            isValid = false;
        } else {
            confirmPassword.classList.remove("invalid");
            confirmPasswordError.style.display = "none";
        }
});


        // Function to set the date range
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