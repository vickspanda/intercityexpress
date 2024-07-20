document.getElementById('employeeForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Full Name Validation
    if($part === 'profile'){

        const fullName = document.getElementById('fullName');
    const fullNameError = document.getElementById('fullNameError');
    if (fullName.value.trim() === '' || fullName.value.length > 50) {
        fullNameError.textContent = 'Full Name is required and should not exceed 50 characters.';
        fullName.classList.add('error-border');
        isValid = false;
    } else {
        fullNameError.textContent = '';
        fullName.classList.remove('error-border');
    }



    }else{
    

    // Address Validation
    const address = document.getElementById('address');
    const addressError = document.getElementById('addressError');
    if (address.value.trim() === '' || address.value.length > 100) {
        addressError.textContent = 'Residential Address is required and should not exceed 100 characters.';
        address.classList.add('error-border');
        isValid = false;
    } else {
        addressError.textContent = '';
        address.classList.remove('error-border');
    }

    // Pin Code Validation
    const pinCode = document.getElementById('pinCode');
    const pinCodeError = document.getElementById('pinCodeError');
    if (pinCode.value.trim() === '' || !/^\d{6}$/.test(pinCode.value)) {
        pinCodeError.textContent = 'Valid Pin Code is required.';
        pinCode.classList.add('error-border');
        isValid = false;
    } else {
        pinCodeError.textContent = '';
        pinCode.classList.remove('error-border');
    }


    // Mobile Number Validation
    const mobile = document.getElementById('mobile');
    const mobileError = document.getElementById('mobileError');
    if (mobile.value.trim() === '' || !/^\d{10}$/.test(mobile.value)) {
        mobileError.textContent = 'Valid Mobile Number is required.';
        mobile.classList.add('error-border');
        isValid = false;
    } else {
        mobileError.textContent = '';
        mobile.classList.remove('error-border');
    }

    }

    if (!isValid) {
        event.preventDefault();
    }
});


document.getElementById('mobile').addEventListener('input', function(event) {
    const mobile = document.getElementById('mobile');
    const mobileError = document.getElementById('mobileError');
    if (mobile.value.trim() === '' || !/^\d{10}$/.test(mobile.value)) {
        mobileError.textContent = 'Valid Mobile Number is required.';
        mobile.classList.add('error-border');
        isValid = false;
    } else {
        mobileError.textContent = '';
        mobile.classList.remove('error-border');
    }

});



document.getElementById('pinCode').addEventListener('input', function(event) {
    const pinCode = document.getElementById('pinCode');
    const pinCodeError = document.getElementById('pinCodeError');
    if (pinCode.value.trim() === '' || !/^\d{6}$/.test(pinCode.value)) {
        pinCodeError.textContent = 'Valid Pin Code is required.';
        pinCode.classList.add('error-border');
        isValid = false;
    } else {
        pinCodeError.textContent = '';
        pinCode.classList.remove('error-border');
    }
});

document.getElementById('address').addEventListener('input', function(event) {
                // Address Validation
                const address = document.getElementById('address');
    const addressError = document.getElementById('addressError');
    if (address.value.trim() === '' || address.value.length > 100) {
        addressError.textContent = 'Residential Address is required and should not exceed 100 characters.';
        address.classList.add('error-border');
        isValid = false;
    } else {
        addressError.textContent = '';
        address.classList.remove('error-border');
    }
});

document.getElementById('fullName').addEventListener('input', function(event) {
    const fullName = document.getElementById('fullName');
    const fullNameError = document.getElementById('fullNameError');
    if (fullName.value.trim() === '' || fullName.value.length > 50) {
        fullNameError.textContent = 'Full Name is required and should not exceed 50 characters.';
        fullName.classList.add('error-border');
        isValid = false;
    } else {
        fullNameError.textContent = '';
        fullName.classList.remove('error-border');
    }
});


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

function populateDistricts() {
    const stateSelect = document.getElementById('state');
    const districtSelect = document.getElementById('district');
    const selectedState = stateSelect.value;

    districtSelect.innerHTML = '<option value="" disabled hidden selected>Select District</option>';

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


function setDateRange() {
    const dateInput = document.querySelector('input[name="dob"]');
    const today = new Date();
    const maxDate = new Date(today);

    maxDate.setDate(today.getDate() - 9131); // 8 days from today

    dateInput.max = maxDate.toISOString().split('T')[0];

    console.log("Date range set:", dateInput.max); // Debug log
}


// Function to validate the form before submission
function validateForm(event) {
    const dateInput = document.querySelector('input[name="dob"]');
    const selectedDate = new Date(dateInput.value);
    const maxDate = new Date(dateInput.max);

    if (selectedDate > maxDate) {
        event.preventDefault(); // Prevent form submission
        alert(`Employee's Age can't be smaller than 25 !!!`);
    }


}

// Call fetchStations and setDateRange on page load
document.addEventListener('DOMContentLoaded', () => {
    setDateRange();
    setDateofJoin();

    // Add event listener to the form
    const form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
});