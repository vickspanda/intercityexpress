// Populate districts based on state selection
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

// Function to populate district options based on selected state
function resPopulateDistricts() {
    const resStateSelect = document.getElementById("resState");
    const resDistrictSelect = document.getElementById("resDistrict");
    const resSelectedState = resStateSelect.value;

    // Clear existing options
    resDistrictSelect.innerHTML = '<option value="" disabled hidden selected>Select District</option>';

    // Populate district options based on selected state
    districts[resSelectedState].forEach(function(resDistrict) {
        const option = document.createElement("option");
        option.text = resDistrict;
        option.value = resDistrict;
        resDistrictSelect.add(option);
    });
}

function comPopulateDistricts() {
    const comStateSelect = document.getElementById("comState");
    const comDistrictSelect = document.getElementById("comDistrict");
    const comSelectedState = comStateSelect.value;

    // Clear existing options
    comDistrictSelect.innerHTML = '<option value="" disabled hidden selected>Select District</option>';

    // Populate district options based on selected state
    districts[comSelectedState].forEach(function(comDistrict) {
        const option = document.createElement("option");
        option.text = comDistrict;
        option.value = comDistrict;
        comDistrictSelect.add(option);
    });
}

function validateUsername() {
    var username = document.getElementById('username').value;
    if (username.trim() === '') {
        document.getElementById('usernameMessage').innerHTML = 'Please enter a username.';
        return;
    }

    // Simulate form submission to check username availability
    var form = document.getElementById('registrationForm');
    var formData = new FormData(form);

    fetch('ta_check_username.php', {
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


document.getElementById("registrationForm").addEventListener("submit", function(event) {
    let isValid = true;

    if($part === 'profile'){
        // Full Name Validation
    const fullName = document.getElementById("fullName");
    const fullNameError = document.getElementById("fullNameError");
    if (fullName.value.length > 60) {
        fullName.classList.add("invalid");
        fullNameError.style.display = "inline";
        isValid = false;
    } else {
        fullName.classList.remove("invalid");
        fullNameError.style.display = "none";
    }


    // Date of Birth Validation
    const dob = document.getElementById("dob");
    const dobError = document.getElementById("dobError");
    if (!dob.value) {
        dob.classList.add("invalid");
        dobError.style.display = "inline";
        isValid = false;
    } else {
        dob.classList.remove("invalid");
        dobError.style.display = "none";
    }



    // Commercial Address Validation
    const comAddress = document.getElementById("comAddress");
    const comAddressError = document.getElementById("comAddressError");
    if (comAddress.value.length > 500) {
        comAddress.classList.add("invalid");
        comAddressError.style.display = "inline";
        isValid = false;
    } else {
        comAddress.classList.remove("invalid");
        comAddressError.style.display = "none";
    }

    // Commercial Pin Code Validation
    const comPincode = document.getElementById("comPincode");
    const comPincodeError = document.getElementById("comPincodeError");
    if (!/^\d{6}$/.test(comPincode.value)) {
        comPincode.classList.add("invalid");
        comPincodeError.style.display = "inline";
        isValid = false;
    } else {
        comPincode.classList.remove("invalid");
        comPincodeError.style.display = "none";
    }

    }else if ($part === 'more'){



    // Residential Address Validation
    const resAddress = document.getElementById("resAddress");
    const resAddressError = document.getElementById("resAddressError");
    if (resAddress.value.length > 500) {
        resAddress.classList.add("invalid");
        resAddressError.style.display = "inline";
        isValid = false;
    } else {
        resAddress.classList.remove("invalid");
        resAddressError.style.display = "none";
    }

    // Residential Pin Code Validation
    const resPincode = document.getElementById("resPincode");
    const resPincodeError = document.getElementById("resPincodeError");
    if (!/^\d{6}$/.test(resPincode.value)) {
        resPincode.classList.add("invalid");
        resPincodeError.style.display = "inline";
        isValid = false;
    } else {
        resPincode.classList.remove("invalid");
        resPincodeError.style.display = "none";
    }

    

    // Mobile Number Validation
    const mobile = document.getElementById("mobile");
    const mobileError = document.getElementById("mobileError");
    if (!/^\d{10}$/.test(mobile.value)) {
        mobile.classList.add("invalid");
        mobileError.style.display = "inline";
        isValid = false;
    } else {
        mobile.classList.remove("invalid");
        mobileError.style.display = "none";
    }

    // Email Validation
    const email = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    if (email.value.length > 60) {
        email.classList.add("invalid");
        emailError.style.display = "inline";
        isValid = false;
    } else {
        email.classList.remove("invalid");
        emailError.style.display = "none";
    }

    
    
    }
    // Prevent form submission if validation fails
    if (!isValid) {
        event.preventDefault();
    }
});

document.getElementById("fullName").addEventListener("input", function() {
    const fullName = document.getElementById("fullName");
    const fullNameError = document.getElementById("fullNameError");
    if (fullName.value.length > 60) {
        fullName.classList.add("invalid");
        fullNameError.style.display = "inline";
        isValid = false;
    } else {
        fullName.classList.remove("invalid");
        fullNameError.style.display = "none";
    }
});


document.getElementById("resAddress").addEventListener("input", function() {
const resAddress = document.getElementById("resAddress");
    const resAddressError = document.getElementById("resAddressError");
    if (resAddress.value.length > 500) {
        resAddress.classList.add("invalid");
        resAddressError.style.display = "inline";
        isValid = false;
    } else {
        resAddress.classList.remove("invalid");
        resAddressError.style.display = "none";
    }
});

document.getElementById("resPincode").addEventListener("input", function() {
const resPincode = document.getElementById("resPincode");
    const resPincodeError = document.getElementById("resPincodeError");
    if (!/^\d{6}$/.test(resPincode.value)) {
        resPincode.classList.add("invalid");
        resPincodeError.style.display = "inline";
        isValid = false;
    } else {
        resPincode.classList.remove("invalid");
        resPincodeError.style.display = "none";
    }

});

document.getElementById("dob").addEventListener("input", function() {
const dob = document.getElementById("dob");
    const dobError = document.getElementById("dobError");
    if (!dob.value) {
        dob.classList.add("invalid");
        dobError.style.display = "inline";
        isValid = false;
    } else {
        dob.classList.remove("invalid");
        dobError.style.display = "none";
    }
});

document.getElementById("mobile").addEventListener("input", function() {
const mobile = document.getElementById("mobile");
    const mobileError = document.getElementById("mobileError");
    if (!/^\d{10}$/.test(mobile.value)) {
        mobile.classList.add("invalid");
        mobileError.style.display = "inline";
        isValid = false;
    } else {
        mobile.classList.remove("invalid");
        mobileError.style.display = "none";
    }
});

document.getElementById("email").addEventListener("input", function() {
const email = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    if (email.value.length > 60) {
        email.classList.add("invalid");
        emailError.style.display = "inline";
        isValid = false;
    } else {
        email.classList.remove("invalid");
        emailError.style.display = "none";
    }
});

document.getElementById("comAddress").addEventListener("input", function() {
const comAddress = document.getElementById("comAddress");
    const comAddressError = document.getElementById("comAddressError");
    if (comAddress.value.length > 500) {
        comAddress.classList.add("invalid");
        comAddressError.style.display = "inline";
        isValid = false;
    } else {
        comAddress.classList.remove("invalid");
        comAddressError.style.display = "none";
    }
});

document.getElementById("comPincode").addEventListener("input", function() {
const comPincode = document.getElementById("comPincode");
    const comPincodeError = document.getElementById("comPincodeError");
    if (!/^\d{6}$/.test(comPincode.value)) {
        comPincode.classList.add("invalid");
        comPincodeError.style.display = "inline";
        isValid = false;
    } else {
        comPincode.classList.remove("invalid");
        comPincodeError.style.display = "none";
    }
});

document.getElementById("idNumber").addEventListener("input", function() {
const idNumber = document.getElementById("idNumber");
    const idNumberError = document.getElementById("idNumberError");
    if (idNumber.value.length > 20) {
        idNumber.classList.add("invalid");
        idNumberError.style.display = "inline";
        isValid = false;
    } else {
        idNumber.classList.remove("invalid");
        idNumberError.style.display = "none";
    }
});

document.getElementById("username").addEventListener("input", function() {
const username = document.getElementById("username");
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

function setDateRange() {
    const dateInput = document.querySelector('input[name="ta_date_of_birth"]');
    const today = new Date();
    const maxDate = new Date(today);

    maxDate.setDate(today.getDate() - 9131); // 8 days from today

    dateInput.max = maxDate.toISOString().split('T')[0];

    console.log("Date range set:", dateInput.max); // Debug log
}

// Function to validate the form before submission
function validateForm(event) {
    const dateInput = document.querySelector('input[name="ta_date_of_birth"]');
    const selectedDate = new Date(dateInput.value);
    const maxDate = new Date(dateInput.max);

    if (selectedDate > maxDate) {
        event.preventDefault(); // Prevent form submission
        alert(`Travel Agent's Age can't be smaller than 25 !!!`);
    }
}

// Call fetchStations and setDateRange on page load
document.addEventListener('DOMContentLoaded', () => {
    setDateRange();

    // Add event listener to the form
    const form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
});