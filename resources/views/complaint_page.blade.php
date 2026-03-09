<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quirino State University | "Electronic Public Assistance And Complaint Desk"</title>
    <link rel="icon" href="{{ asset('../assets/shortcut_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('../assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/complaint_page.css') }}">
</head>
<body>

<header class="header">
    <div class="logo-container">
        <a href="https://www.bagongpilipinastayo.com/" target="_blank" rel="noopener noreferrer" title="Bagong Pilipinas"><img src="{{ asset('assets/bagong-pilipinas_logo.png')}}" alt="bagong_pilipinas" class="bagong_pilipinas"></a>
        <a href="https://www.gov.ph/" target="_blank" rel="noopener noreferrer" class="gov" title="GOV.PH">GOV.PH</a>
        <a href="https://arta.gov.ph/" target="_blank" rel="noopener noreferrer" title="ARTA"><img src="{{ asset('assets/arta_logo.png')}}" alt="Arta" class="arta"></a>
    </div>

    <nav class="navbar" id="navbar">
        <a href="{{ url('/') }}#home">Home</a>
        <a href="{{ url('/') }}#about">About</a>
        <a href="{{ route('inquiries.page') }}">Assistance</a>
        <a href="{{ route('citizen.charter') }}">Citizen's Charter</a>
        <a href="{{ url('/feedback') }}">Feedback</a>
    </nav>

    <div class="icon">
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>
</header>

<div class="contact-card">
    <form action="{{ route('complaint.store') }}" method="POST" class="contact-left" enctype="multipart/form-data">
        @csrf
        <div class="contact-left-title">
            <h2>Write your complaint here!</h2>
            <hr>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="registerButton">
            <div id="clienttype" class="contact-left custom-select-wrapper">
                <select name="client_type" id="clientTypeSelector" class="contact-inputs" required>
                    <option value="" disabled selected hidden>Client Type</option>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Staff">Staff</option>
                    <option value="Government (another agency)">Government (another agency)</option>
                    <option value="Guest">Guest</option>
                    <option value="Alumni">Alumni</option>
                    <option value="Supplier">Supplier</option>
                </select>
                <i class="fa-solid fa-angle-down dropdown-arrow"></i>
            </div>
        </div>



        <!-- NEW: Department Dropdown -->
        <div class="departmentButton">
            <div id="departmentSelect" class="contact-left custom-select-wrapper">
                <select name="department" id="departmentSelector" class="contact-inputs" required>
                    <option value="" disabled selected hidden>Department of the Person You Are Reporting</option>
                    <option value="Office of the President">Office of the President</option>
                    <option value="Office of the Board Secretary">Office of the Board Secretary</option>
                    <option value="Office of the Vice President for Administration and Finance">Office of the Vice President for Administration and Finance</option>
                    <option value="Office of the Vice President for Academic, Research and Extension">Office of the Vice President for Academic, Research and Extension</option>
                    <option value="Planning Unit">Planning Unit</option>
                    <option value="Information Unit">Information Unit</option>
                    <option value="Information Communication Technology Unit">Information Communication Technology Unit</option>
                    <option value="Internal Audit Unit">Internal Audit Unit</option>
                    <option value="Legal Unit">Legal Unit</option>
                    <option value="International Relations Unit">International Relations Unit</option>
                    <option value="Project Management Unit">Project Management Unit</option>
                    <option value="Quality Assurance Unit">Quality Assurance Unit</option>
                    <option value="Gender and Development Unit">Gender and Development Unit</option>
                    <option value="Alumni Affairs Unit">Alumni Affairs Unit</option>
                    <option value="Security Services">Security Services</option>
                    <option value="Human Resources Management Unit">Human Resources Management Unit</option>
                    <option value="General Services Unit">General Services Unit</option>
                    <option value="Supply and Property Management Unit">Supply and Property Management Unit</option>
                    <option value="Procurement Management Unit">Procurement Management Unit</option>
                    <option value="Records Unit">Records Unit</option>
                    <option value="Medical and Dental Services">Medical and Dental Services</option>
                    <option value="Cashiering Unit">Cashiering Unit</option>
                    <option value="Budget Unit">Budget Unit</option>
                    <option value="Accounting Unit and Men’s Dormitory">Accounting Unit and Men’s Dormitory</option>
                    <option value="Auxiliary and Enterprise Development">Auxiliary and Enterprise Development</option>
                    <option value="Research and Development">Research and Development</option>
                    <option value="Extension and Training Services">Extension and Training Services</option>
                    <option value="Knowledge Center">Knowledge Center</option>
                    <option value="Office of the University Registrar">Office of the University Registrar</option>
                    <option value="NSTP">NSTP</option>
                    <option value="Bachelor of Elementary Education (BEEd)">Bachelor of Elementary Education (BEEd)</option>
                    <option value="Bachelor of Secondary Education (BSE)">Bachelor of Secondary Education (BSE)</option>
                    <option value="Bachelor of Technology and Livelihood Education (BTLED)">Bachelor of Technology and Livelihood Education (BTLED)</option>
                    <option value="Bachelor of Science in Criminology (BSC) and Student Tribunal">Bachelor of Science in Criminology (BSC) and Student Tribunal</option>
                    <option value="Bachelor of Science in Hospitality Management (BSHM)">Bachelor of Science in Hospitality Management (BSHM)</option>
                    <option value="Bachelor of Science in Tourism Management (BSTM)">Bachelor of Science in Tourism Management (BSTM)</option>
                    <option value="Bachelor of Science in Nutrition and Dietetics (BSND)">Bachelor of Science in Nutrition and Dietetics (BSND)</option>
                    <option value="Bachelor of Science in Office Administration (BSOA)">Bachelor of Science in Office Administration (BSOA)</option>
                    <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
                    <option value="Bachelor of Science in Agriculture (BSA)">Bachelor of Science in Agriculture (BSA)</option>
                    <option value="Bachelor of Science in Forestry (BSF)">Bachelor of Science in Forestry (BSF)</option>
                    <option value="Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)">Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)</option>
                    <option value="Student Affairs and Services">Student Affairs and Services</option>
                    <option value="Student Publications">Student Publications</option>
                    <option value="Ladies Dormitory">Ladies Dormitory</option>
                    <option value="Guidance and Counselling Services">Guidance and Counselling Services</option>
                    <option value="Registered Student Organizations and Student Economic Enterprise Development">RSO and Student Economic Enterprise Development</option>
                    <option value="UNIFAST and Scholarship Services">UNIFAST and Scholarship Services</option>
                    <option value="Socio-Cultural Affairs">Socio-Cultural Affairs</option>
                    <option value="Sports Development">Sports Development</option>
                    <option value="Multi-Faith Services">Multi-Faith Services</option>
                    <option value="Student Government">Student Government</option>
                    <option value="Internal Audit Unit-Secretariat">Internal Audit Unit-Secretariat</option>
                </select>
                 <i class="fa-solid fa-angle-down dropdown-arrow"></i>
            </div>
        </div>



        <!-- Name -->
        <input type="text" name="name" placeholder="Your Name" class="contact-inputs" autocomplete="off" oninput="this.value = this.value.replace(/[^a-zA-Z.\s]/g, '');">

        <!-- Contact Number -->
        <input type="text" name="contact" placeholder="Contact Number *" 
            class="contact-inputs" autocomplete="off" required 
            pattern="\d{11}" maxlength="11" minlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');">

        <!-- Email -->
        <input type="email" name="email" id="emailInput" placeholder="Email Address *" class="contact-inputs" autocomplete="off" required>

        <!-- Send OTP Button -->
        <button type="button" id="sendOtpBtn" class="otp-btn">Send OTP</button>

        <!-- OTP Input (Hidden by Default) -->
        <div id="otpSection" style="display:none; margin-top:10px;">
            <input type="text" id="otpInput" maxlength="6" placeholder="Enter OTP Code" class="contact-inputs">
            <button type="button" id="verifyOtpBtn" class="otp-btn">Verify OTP</button>
            <p id="otpStatus" style="font-size:14px; margin-top:5px;"></p>
        </div>

        {{-- <!-- Contact Number (used for OTP now) -->
        <input type="tel" name="contact" id="phoneInput" placeholder="Phone Number *" 
            class="contact-inputs" autocomplete="off" required 
            pattern="09\d{9}" maxlength="11" minlength="11"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');">

        <!-- Send OTP Button -->
        <button type="button" id="sendOtpBtn" class="otp-btn">Send OTP</button>

        <!-- OTP Input (Hidden by Default) -->
        <div id="otpSection" style="display:none; margin-top:10px;">
            <input type="text" id="otpInput" maxlength="6" placeholder="Enter OTP Code" class="contact-inputs">
            <button type="button" id="verifyOtpBtn" class="otp-btn">Verify OTP</button>
            <p id="otpStatus" style="font-size:14px; margin-top:5px;"></p>
        </div> --}}



        <!-- Message -->
        <textarea name="message" placeholder="Please write your complaint's here *" class="contact-inputs" autocomplete="off" required></textarea>

       <!-- Image Upload -->
        <div class="upload-group">
            <label for="imageUpload" class="upload-label">Attach Image Proof (optional):</label>
            <input type="file" name="image" id="imageUpload" accept="image/*" class="contact-inputs" onchange="previewImage(event)">

            <div class="preview-container" id="imageContainer" style="display:none;">
                <div class="menu-dots" onclick="toggleImageMenu()">⋮
                    <div class="menu-dropdown" id="imageMenu">
                        <button type="button" onclick="removeImage()">Remove</button>
                    </div>
                </div>
                <img id="imagePreview" src="#" alt="Image Preview" />
            </div>
        </div>

        <!-- Video Upload -->
        <div class="upload-group">
            <label for="videoUpload" class="upload-label">Attach Video Proof (optional):</label>
            <input type="file" name="video" id="videoUpload" accept="video/*" class="contact-inputs" onchange="previewVideo(event)">

            <div class="preview-container" id="videoContainer" style="display:none;">
                <div class="menu-dots" onclick="toggleVideoMenu()">⋮
                    <div class="menu-dropdown" id="videoMenu">
                        <button type="button" onclick="removeVideo()">Remove</button>
                    </div>
                </div>
                <video id="videoPreview" controls></video>
            </div>
        </div>


        <!-- Submit Button -->
        <button type="submit" id="submitbtn">Submit <i class="fa-solid fa-arrow-right"></i></button>
    </form>
</div>


<!-- Privacy Modal -->
<div id="privacyModal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Privacy Notice</h2>
    </div>
    <div class="modal-body">
      <p>
        Please be informed that your personal information and complaint details 
        will be handled confidentially and securely. By proceeding, you agree 
        to the terms and conditions regarding your privacy.
      </p>

      <div class="checkbox-container">
        <input type="checkbox" id="agreeCheckbox">
        <label for="agreeCheckbox">
          I have read and agree to the Privacy Notice.
        </label>
      </div>

      <button id="acceptBtn">Proceed</button>
    </div>
  </div>
</div>

<!-- Custom Notification Modal -->
<div id="customModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>
        <p id="customModalMessage">System:</p>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {

    // -------------------
    // PRIVACY MODAL
    // -------------------
    const modal = document.getElementById("privacyModal");
    const closeBtn = document.querySelector(".close");
    const acceptBtn = document.getElementById("acceptBtn");
    const agreeCheckbox = document.getElementById("agreeCheckbox");

    modal.style.display = "block";

    closeBtn.addEventListener("click", () => {
        window.location.href = "{{ url('/') }}";
    });

    acceptBtn.addEventListener("click", () => {
        if (!agreeCheckbox.checked) {
            showModal("Please check the box to agree to the Privacy Notice before proceeding.");
        } else {
            modal.style.display = "none";
        }
    });

    window.addEventListener("click", (event) => {
        if (event.target == modal) {
            window.location.href = "{{ url('/') }}";
        }
    });

    // -------------------
    // IMAGE PREVIEW
    // -------------------
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const imageContainer = document.getElementById('imageContainer');
    const imageMenu = document.getElementById('imageMenu');

    window.previewImage = function(event) {
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imageContainer.style.display = 'block';
    };

    window.removeImage = function() {
        imageUpload.value = '';
        imagePreview.src = '#';
        imageContainer.style.display = 'none';
        imageMenu.style.display = 'none';
    };

    window.toggleImageMenu = function() {
        imageMenu.style.display = imageMenu.style.display === 'block' ? 'none' : 'block';
    };

    // -------------------
    // VIDEO PREVIEW
    // -------------------
    const videoUpload = document.getElementById('videoUpload');
    const videoPreview = document.getElementById('videoPreview');
    const videoContainer = document.getElementById('videoContainer');
    const videoMenu = document.getElementById('videoMenu');

    window.previewVideo = function(event) {
        videoPreview.src = URL.createObjectURL(event.target.files[0]);
        videoContainer.style.display = 'block';
    };

    window.removeVideo = function() {
        videoUpload.value = '';
        videoPreview.pause();
        videoPreview.removeAttribute('src');
        videoPreview.load();
        videoContainer.style.display = 'none';
        videoMenu.style.display = 'none';
    };

    window.toggleVideoMenu = function() {
        videoMenu.style.display = videoMenu.style.display === 'block' ? 'none' : 'block';
    };

    // -------------------
    // OTP SYSTEM
    // -------------------
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');
    const emailInput = document.getElementById('emailInput');
    const otpSection = document.getElementById('otpSection');
    const otpInput = document.getElementById('otpInput');
    const otpStatus = document.getElementById('otpStatus');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let otpVerified = false;

    // SEND OTP
    sendOtpBtn.addEventListener('click', () => {
        const email = emailInput.value.trim();
        if (!email) { showModal("Please enter your email."); return; }

        sendOtpBtn.disabled = true;
        sendOtpBtn.textContent = "Sending...";

        fetch("{{ route('send.otp') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify({ email })
        })
        .then(res => res.json())
        .then(data => {
            otpSection.style.display = 'block';
            otpStatus.style.color = 'black';
            otpStatus.textContent = "OTP sent! Check your email.";
            sendOtpBtn.disabled = false;
            sendOtpBtn.textContent = "Send OTP";
        })
        .catch(err => {
            console.error(err);
            otpStatus.style.color = 'red';
            otpStatus.textContent = "Failed to send OTP.";
            sendOtpBtn.disabled = false;
            sendOtpBtn.textContent = "Send OTP";
        });
    });

    // VERIFY OTP
    verifyOtpBtn.addEventListener('click', () => {
        const otp = otpInput.value.trim();
        if (!otp) { showModal("Please enter OTP."); return; }

        verifyOtpBtn.disabled = true;
        verifyOtpBtn.textContent = "Verifying...";

        fetch("{{ route('verify.otp') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify({ otp })
        })
        .then(res => res.json())
        .then(data => {
            otpVerified = data.valid;
            otpStatus.style.color = data.valid ? 'green' : 'red';
            otpStatus.textContent = data.message || (data.valid ? "OTP verified!" : "Invalid OTP.");
            if (data.valid) otpSection.style.display = 'none';
            verifyOtpBtn.disabled = false;
            verifyOtpBtn.textContent = "Verify OTP";
        })
        .catch(err => {
            console.error(err);
            otpStatus.style.color = 'red';
            otpStatus.textContent = "OTP verification failed.";
            verifyOtpBtn.disabled = false;
            verifyOtpBtn.textContent = "Verify OTP";
        });
    });

    // BLOCK FORM SUBMIT IF OTP NOT VERIFIED
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", (e) => {
            if (!otpVerified) {
                e.preventDefault();
                showModal("Please verify the code that we were sending to you before proceeding.");
            } else {
                modal.style.display = "none";
            }
        });
    }

//     // -------------------
//     // OTP SYSTEM (Phone)
//     // -------------------
//     const sendOtpBtn = document.getElementById('sendOtpBtn');
//     const verifyOtpBtn = document.getElementById('verifyOtpBtn');
//     const phoneInput = document.getElementById('phoneInput');
//     const otpSection = document.getElementById('otpSection');
//     const otpInput = document.getElementById('otpInput');
//     const otpStatus = document.getElementById('otpStatus');
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     let otpVerified = false;

//     // SEND OTP
// sendOtpBtn.addEventListener('click', () => {
//     const phone = phoneInput.value.trim();

//     if (!phone.match(/^09\d{9}$/)) {
//         showModal("Please enter a valid 11-digit Philippine phone number starting with 09.");
//         return;
//     }

//     // Convert to international format for Twilio
//     const internationalPhone = '+63' + phone.substring(1);

//     sendOtpBtn.disabled = true;
//     sendOtpBtn.textContent = "Sending...";

//     fetch("{{ route('send.otp') }}", {
//         method: "POST",
//         headers: { 
//             "Content-Type": "application/json", 
//             "X-CSRF-TOKEN": csrfToken 
//         },
//         body: JSON.stringify({ phone }) // keep local phone format for validation in backend
//     })
//     .then(res => res.json())
//     .then(data => {
//         otpSection.style.display = 'block';
//         otpStatus.style.color = 'black';
//         otpStatus.textContent = data.message || "OTP sent! Check your phone.";
//         sendOtpBtn.disabled = false;
//         sendOtpBtn.textContent = "Send OTP";
//     })
//     .catch(err => {
//         console.error(err);
//         otpStatus.style.color = 'red';
//         otpStatus.textContent = "Failed to send OTP.";
//         sendOtpBtn.disabled = false;
//         sendOtpBtn.textContent = "Send OTP";
//     });
// });

// // VERIFY OTP
// verifyOtpBtn.addEventListener('click', () => {
//     const otp = otpInput.value.trim();
//     const phone = phoneInput.value.trim();

//     if (!otp) { showModal("Please enter OTP."); return; }

//     verifyOtpBtn.disabled = true;
//     verifyOtpBtn.textContent = "Verifying...";

//     fetch("{{ route('verify.otp') }}", {
//         method: "POST",
//         headers: { 
//             "Content-Type": "application/json", 
//             "X-CSRF-TOKEN": csrfToken 
//         },
//         body: JSON.stringify({ otp, phone })
//     })
//     .then(res => res.json())
//     .then(data => {
//         otpVerified = data.valid;
//         otpStatus.style.color = data.valid ? 'green' : 'red';
//         otpStatus.textContent = data.message || (data.valid ? "OTP verified!" : "Invalid OTP.");
//         if (data.valid) otpSection.style.display = 'none';
//         verifyOtpBtn.disabled = false;
//         verifyOtpBtn.textContent = "Verify OTP";
//     })
//     .catch(err => {
//         console.error(err);
//         otpStatus.style.color = 'red';
//         otpStatus.textContent = "OTP verification failed.";
//         verifyOtpBtn.disabled = false;
//         verifyOtpBtn.textContent = "Verify OTP";
//     });
// });

// // BLOCK FORM SUBMIT IF OTP NOT VERIFIED
// const form = document.querySelector("form");
// if (form) {
//     form.addEventListener("submit", (e) => {
//         if (!otpVerified) {
//             e.preventDefault();
//             showModal("Please verify the code sent to your phone before submitting.");
//         } else {
//             modal.style.display = "none";
//         }
//     });
// }



    // --- CUSTOM MODAL FUNCTIONS ---
    const customModal = document.getElementById("customModal");
    const customModalMessage = document.getElementById("customModalMessage");
    const customClose = document.querySelector(".custom-close");

    function showModal(message) {
        customModalMessage.textContent = message;
        customModal.style.display = "block";
    }

    customClose.addEventListener("click", () => {
        customModal.style.display = "none";
    });

    window.addEventListener("click", (event) => {
        if (event.target == customModal) {
            customModal.style.display = "none";
        }
    });


});
</script>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
