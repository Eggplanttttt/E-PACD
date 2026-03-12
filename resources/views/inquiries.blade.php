@php
    // Prevent caching
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSU E-PACD | Inquiries</title>
    <link rel="icon" href="{{ asset('assets/shortcut_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('../assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/inquiries_page.css') }}">
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

<!-- Modal for selecting client type -->
<div id="clientTypeModal" class="modal-overlay">
    <div class="modal-box">
        <h2 class="modal-title">Welcome to Quirino State University E-PACD</h2>
        <p class="modal-description">
            To help us serve you better, please identify your client type below.
            This will ensure that your inquiry is directed to the right department.
        </p>

         <div class="custom-select-wrapper">
            <select id="clientTypeSelect" class="contact-inputs" required>
                <option value="" disabled selected hidden>Select Client Type</option>
                <option value="student">Student</option>
                <option value="faculty">Faculty / Staff</option>
                <option value="alumni">Alumni</option>
                <option value="others">Guest</option>
                <option value="register">New Account</option>
            </select>
            <i class="fa-solid fa-angle-down dropdown-arrow"></i>
        </div>

        <button class="clientButton" id="continueBtn">Continue</button>
    </div>
</div> 

    <!-- Success Modal -->
    @if(session('success'))
    <div id="successModal" class="modal-message" style="display: flex;">
        <div class="modal-content">
            <p>{{ session('success') }}</p>
            <button onclick="closeModal('successModal')">OK</button>
        </div>
    </div>
    @endif

    <!-- Error Modal (if any validation fails) -->
    @if($errors->any())
    <div id="errorModal" class="modal-message" style="display: flex;">
        <div class="modal-content">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button onclick="closeModal('errorModal')">OK</button>
        </div>
    </div>
    @endif

    <!-- Forms/Chat Interface Area -->
    <div id="loginForms" class="contact-card hidden">

    <!-- Student Login Form -->
    <form id="studentLoginForm" class="contact-left hidden" method="POST" action="{{ route('client.login.post', ['clientType' => 'student']) }}">
            @csrf
            <div class="contact-left-title">
                <h2>Student Login</h2>
                <a type="button" class="back-btn" onclick="goBackToClientType()">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <hr>
            </div>

            <p>Libris Account:</p>
            <input 
                type="text" 
                id="studentlogin"
                name="username_or_email" 
                placeholder="Enter your Libris Account *" 
                class="contact-inputs" 
                autocomplete="off" 
                required>

                <a href="{{ route('google.login') }}?clientType=student" 
                id="pickGmailBtn" 
                class="google-btn"
                data-target="studentlogin">
                    <i class="fab fa-google"></i> Choose Gmail
                </a>

            <p>Password:</p>
            <div class="input-field" style="position: relative;">
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password *" 
                    autocomplete="off" 
                    required 
                    class="form-control password-input">

                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 45%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>

            <div class="forgot-password text-end">
                <a href="{{ route('student.password.forgot') }}">
                    Forgot password?
                </a>
            </div>
            
            <button type="submit">Login <i class="fa-solid fa-sign-in-alt"></i></button>
        </form>


        <form id="facultyLoginForm" class="contact-left hidden" method="POST" action="{{ route('client.login.post', ['clientType' => 'faculty']) }}">
        @csrf
        <div class="contact-left-title">
            <h2>Faculty / Staff Login</h2>
            <a type="button" class="back-btn" onclick="goBackToClientType()">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <hr>
        </div>

        <p>Libris Account:</p>
        <input 
            type="text" 
            id="facultylogin"
            name="username_or_email" 
            placeholder="Enter your University Email *" 
            class="contact-inputs" 
            autocomplete="off" 
            required>

        <a href="{{ route('google.login') }}?clientType=faculty" 
        id="pickGmailBtnFaculty" 
        class="google-btn"
        data-target="facultylogin">
            <i class="fab fa-google"></i> Choose Gmail
        </a>

        <p>Password:</p>
        <div class="input-field" style="position: relative;">
            <input 
                type="password" 
                name="password" 
                placeholder="Password *" 
                autocomplete="off" 
                required 
                class="form-control password-input">

            <i class="fa-solid fa-eye toggle-password" style="
                position: absolute;
                right: 10px;
                top: 45%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #555;
            "></i>
        </div>

        <div class="forgot-password text-end">
            <a href="{{ route('faculty.password.forgot') }}">
                Forgot password?
            </a>
        </div>

        <button type="submit">Login <i class="fa-solid fa-sign-in-alt"></i></button>
    </form>




    <!-- Alumni Login Form -->
    <form id="alumniLoginForm" class="contact-left hidden" method="POST" action="{{ route('client.login.post', ['clientType' => 'alumni']) }}">
        @csrf
        <div class="contact-left-title">
            <h2>Alumni Login</h2>
            <a type="button" class="back-btn" onclick="goBackToClientType()">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <hr>
        </div>
        <p>Email Address:</p>
        <input type="email" name="username_or_email" id="alumnilogin" placeholder="Email *" class="contact-inputs" autocomplete="off" required>

        <a href="{{ route('google.login') }}?clientType=alumni" id="pickGmailBtnAlumni" class="google-btn" data-target="alumnilogin"><i class="fab fa-google"></i> Choose Gmail </a>

        <p>Password:</p>
        <div class="input-field" style="position: relative;">
            <input type="password" name="password" placeholder="Password*" autocomplete="off" required class="form-control password-input">
            <i class="fa-solid fa-eye toggle-password" style="
                position: absolute;
                right: 10px;
                top: 45%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #555;
            "></i>
        </div>

        <div class="forgot-password text-end">
            <a href="{{ route('alumni.password.forgot') }}">
                Forgot password?
            </a>
        </div>

        <button type="submit">Login <i class="fa-solid fa-sign-in-alt"></i></button>
    </form>

    <!-- Others Login Form -->
    <form id="othersLoginForm" class="contact-left hidden" method="POST" action="{{ route('client.login.post', ['clientType' => 'others']) }}">
        @csrf
        <div class="contact-left-title">
            <h2>General Login</h2>
            <a type="button" class="back-btn" onclick="goBackToClientType()">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <hr>
        </div>
        <p>Username or Email:</p>
        <input type="text" name="username_or_email" id="otherslogin" placeholder="Username or Email Address *" class="contact-inputs" autocomplete="off" required>

        <p>Password:</p>
        <div class="input-field" style="position: relative;">
            <input type="password" name="password" placeholder="Password*" autocomplete="off" required class="form-control password-input">
            <i class="fa-solid fa-eye toggle-password" style="
                position: absolute;
                right: 10px;
                top: 45%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #555;
            "></i>
        </div>

        <div class="forgot-password text-end">
            <a href="{{ route('others.password.forgot') }}">
                Forgot password?
            </a>
        </div>

        <button type="submit">Login <i class="fa-solid fa-sign-in-alt"></i></button>
    </form>




   <!-- Common Dropdown to Select Client Type -->
    <div class="registerButton">
        <div id="clienttype" class="contact-left">
            <h2 class="client-title">Please Select Your Client Type</h2>
            <p class="client-desc">
                Kindly choose your role from the dropdown below so we can direct you to the correct registration or service form.
            </p>
             <div class="custom-select-wrapper">
            <select id="clientTypeSelector" class="contact-inputs" required>
                <option value="" disabled selected hidden>-- Client Type --</option>
                <option value="student">Student</option>
                <option value="faculty">Faculty / Staff</option>
                <option value="alumni">Alumni</option>
                <option value="others">Others</option>
            </select>
             <i class="fa-solid fa-angle-down dropdown-arrow" style="right:125px"></i>
             </div>
        </div>
    </div>


    <!-- Student Registration Form -->
    <form action="{{ route('register.store') }}" method="POST" id="form-student" class="contact-left">
        @csrf
        <div class="form-header">
            <h2>Student Registration</h2>
            <a type="button" class="back-btn" onclick="goBackToClientType()">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        <!-- Step 1: Email Verification -->
        <div id="emailVerification">
            <input type="email" name="email" id="studentEmail" placeholder="Enter your libris email" autocomplete="off" required>
            <div class="helper-note">
                <i class="fa-solid fa-circle-info"></i>
                Please use your <strong>real name</strong> that matches your email
                (example: <strong>juan.delacruz@libris.qsu.edu.ph</strong> → First Name: Juan, Last Name: Dela Cruz).
            </div>

            <button type="button" 
                    id="sendOtpBtn" 
                    data-send-otp="{{ route('student.sendOtp') }}" 
                    data-csrf="{{ csrf_token() }}">
                Send OTP
            </button>

            <div id="otpSection" style="display:none; margin-top:10px;">
                <input type="text" id="otpInput" autocomplete="off" placeholder="Enter OTP">
                <button type="button" id="verifyOtpBtn">Verify OTP</button>
                <button type="button" id="resendOtpBtn" 
                        data-send-otp="{{ route('student.sendOtp') }}" 
                        data-csrf="{{ csrf_token() }}">
                    Resend OTP
                </button>
            </div>

            <!-- Google Login (optional) -->
            <a href="{{ route('google.login') }}?clientType=student" 
            id="chooseGmailBtn" 
            class="google-btn"
            data-target="studentEmail">
                <i class="fab fa-google"></i> Choose Gmail
            </a>
        </div>

        <!-- Step 2: Full Registration -->
        <div id="registrationFields" style="display:none; margin-top:20px;">
            <div class="name-fields">
                <input type="text" name="first_name" placeholder="First Name *" required autocomplete="off" spellcheck="false" 
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

                <input type="text" name="middle_initial" placeholder="Middle Initial(Optional)" maxlength="2" autocomplete="off" spellcheck="false"
                    oninput="this.value = this.value.replace(/[^a-zA-Z.]/g, '');">

                <input type="text" name="last_name" placeholder="Last Name *" required autocomplete="off" spellcheck="false"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

                <input type="text" name="suffix" placeholder="Suffix(leave blank if none)" autocomplete="off" spellcheck="false"
                    oninput="this.value = this.value.replace(/[^a-zA-Z.,\s]/g, '');">
            </div>

            <input type="text" name="idnumber" placeholder="Student ID No. (ex. 12-34567) *" autocomplete="off" spellcheck="false" maxlength="8" oninput="validateIdFormat(this)" required>

            <div class="input-box">
                <div class="course-year-dropdowns">
                    <select id="courseSelect" required>
                        <option value="" disabled selected hidden>Select Course</option>
                        <option value="BEEd">BEEd</option>
                        <option value="BSEd-English">BSEd-English</option>
                        <option value="BSEd-Math">BSEd-Math</option>
                        <option value="BSEd-Filipino">BSEd-Filipino</option>
                        <option value="BSEd-Science">BSEd-Science</option>
                        <option value="BTLEd-HomeEcon">BTLEd-HomeEcon</option>
                        <option value="BTLEd-ICT">BTLEd-ICT</option>
                        <option value="BTLEd-AgriFishery">BTLEd-AgriFishery</option>
                        <option value="CAS-BSA">CAS-BSA</option>
                        <option value="BSABE">BSABE</option>
                        <option value="BSForestry">BSForestry</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSOA">BSOA</option>
                        <option value="BSCrim">BSCrim</option>
                        <option value="BSND">BSND</option>
                        <option value="Caregiving-NCII">Caregiving-NCII</option>
                        <option value="BSHM">BSHM</option>
                        <option value="BSTM">BSTM</option>
                    </select>

                    <select id="yearSelect" required>
                        <option value="" disabled selected hidden>Select Year</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <input type="hidden" name="course_year" id="courseYearInput" required>
            </div>

            <p>Password:</p>
            <div class="input-field" style="position: relative;">
                <input
                    type="password"
                    name="password"
                    placeholder="Password *"
                    autocomplete="new-password"
                    required
                    class="form-control password-input"
                    style="padding-right: 40px;"
                >
                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>
            <span id="passwordError" style="display:none; color:red;"></span>

            <p>Confirm Password:</p>
            <div class="input-field" style="position: relative;">
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password *"
                    autocomplete="new-password"
                    required
                    class="form-control password-input"
                    style="padding-right: 40px;"
                >
                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>
            <span id="confirmPasswordError" style="display:none; color:red;"></span>

            <input type="hidden" name="client_type" value="student">

            <div class="data-privacy">
                <input type="checkbox" id="agreePrivacy">
                <label for="agreePrivacy">
                    I agree to the 
                    <a href="#" id="privacyLink">Data Privacy Policy</a>
                </label>
            </div>

            <!-- Data Privacy Modal -->
            <div id="privacyModal" class="modal-overlay" style="display:none;">
                <div class="privacy-modal">

                    <!-- Header -->
                    <div class="privacy-modal-header">
                        Privacy Notice (RA 10173 – Data Privacy Act of 2012)
                    </div>

                    <!-- Body -->
                    <div class="privacy-modal-body">
                        <div class="privacy-text">
                            <p>
                                Quirino State University (“QSU”) respects your right to privacy and is committed to protecting your personal data
                                in compliance with <strong>Republic Act No. 10173</strong>, also known as the <strong>Data Privacy Act of 2012</strong>,
                                and its Implementing Rules and Regulations (IRR), as well as issuances of the <strong>National Privacy Commission (NPC)</strong>.
                            </p>

                            <p><strong>Purpose of Collection.</strong> We collect and process your information to:</p>
                            <ul>
                                <li>create and manage your account for QSU E-PACD services;</li>
                                <li>verify your identity (including email/OTP verification);</li>
                                <li>process and respond to inquiries, requests, and feedback;</li>
                                <li>generate service records, reports, and audit logs for accountability and service improvement; and</li>
                                <li>comply with legal and regulatory requirements.</li>
                            </ul>

                            <p><strong>Types of Personal Data Collected.</strong> This may include your name, email address, client type,
                                ID number (if applicable), department/course information, and system logs needed for security and fraud prevention.</p>

                            <p><strong>Use, Sharing, and Disclosure.</strong> Your personal data will be accessed only by authorized QSU personnel.
                                We do not sell your data. Disclosure may occur only when required by law, lawful order, or when necessary to deliver the service.</p>

                            <p><strong>Protection and Retention.</strong> QSU implements reasonable organizational, physical, and technical security measures.
                                Data is retained only for as long as necessary for the stated purposes and legal obligations, then securely disposed of.</p>

                            <p><strong>Your Data Privacy Rights.</strong> Subject to applicable laws and QSU policies, you may have the right to be informed,
                                access, correct, object, request deletion/blocking, and file a complaint with the NPC.</p>

                            <p class="mb-0">
                                By clicking <strong>Close</strong> and continuing to register, you confirm that you have read and understood this Privacy Notice
                                and consent to the processing of your personal data.
                            </p>

                            <p class="privacy-contact">
                                <small>For concerns, contact: <strong>info@qsu.edu.ph</strong></small>
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="privacy-modal-footer">
                        <button type="button" id="closePrivacyModal" class="privacy-close-btn">Close</button>
                    </div>

                </div>
            </div>
            <button type="submit" id="registerBtn">Register</button>
        </div>
    </form>



    <!-- Faculty Registration Form -->
    <form action="{{ route('register.store') }}" method="POST" id="form-faculty" class="contact-left hidden">
        @csrf
        <div class="form-header">
            <h2>Faculty / Staff Registration</h2>
            <a type="button" class="back-btn" onclick="goBackToClientType()">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        <!-- Step 1: Libris Email Verification -->
        <div id="facultyEmailVerification" >
            <input type="email" name="email" id="facultyEmail" placeholder="Enter your QSU Email" autocomplete="off" required>
            <div class="helper-note">
                <i class="fa-solid fa-circle-info"></i>
                Make sure your <strong>First Name</strong> and <strong>Last Name</strong> match your email format
                (example: <strong>firstname.lastname@qsu.edu.ph</strong>).
            </div>
            <button type="button" 
                    id="sendOtpBtnFaculty" 
                    data-send-otp="{{ route('faculty.sendOtp') }}" 
                    data-csrf="{{ csrf_token() }}">
                Send OTP
            </button>

            <div id="otpSectionFaculty" style="display:none; margin-top:10px;">
                <input type="text" id="otpInputFaculty" autocomplete="off" placeholder="Enter OTP">
                <button type="button" id="verifyOtpBtnFaculty">Verify OTP</button>
                <button type="button" id="resendOtpBtnFaculty" 
                        data-send-otp="{{ route('faculty.sendOtp') }}" 
                        data-csrf="{{ csrf_token() }}">
                    Resend OTP
                </button>
            </div>

            <!-- Google Login for Email -->
            <a href="{{ route('google.login') }}?clientType=faculty" 
            id="chooseGmailBtnFaculty" 
            class="google-btn"
            data-target="facultyEmail">
                <i class="fab fa-google"></i> Choose Gmail
            </a>
        </div>

        <!-- Step 2: Full Registration -->
        <div id="registrationFieldsFaculty" style="display:none; margin-top:20px;">
            <div class="name-fields">
                <input type="text" name="first_name" placeholder="First Name *" required autocomplete="off" spellcheck="false" 
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

                <input type="text" name="middle_initial" placeholder="Middle Initial (Optional)" autocomplete="off" spellcheck="false" maxlength="2" 
                    oninput="this.value = this.value.replace(/[^a-zA-Z.]/g, '');">

                <input type="text" name="last_name" placeholder="Last Name *" required autocomplete="off" spellcheck="false"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

                <input type="text" name="suffix" placeholder="Suffix(leave blank if none)" autocomplete="off" spellcheck="false" maxlength="10"
                    oninput="this.value = this.value.replace(/[^a-zA-Z.,]/g, '');">
            </div>

            <input type="text" name="facultyId" placeholder="Faculty ID No. (ex. D-12345) *" required autocomplete="off" spellcheck="false" maxlength="7" oninput="validateIdFormat(this)">

            <div class="input-box">
                <select id="departmentSelect" name="department_unit" required>
                    <option value="" disabled selected hidden>Select Department/Unit</option> 
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
                    <option value="Other">Other</option>
                </select>

                <!-- Hidden input for 'Other' -->
                <input type="text" id="otherDepartmentInput" name="other_department" placeholder="Specify Department/Unit" style="display:none; margin-top:5px;" autocomplete="off">
            </div>

            


            <p>Password:</p>
            <div class="input-field" style="position: relative;">
                <input
                    type="password"
                    name="password"
                    placeholder="Password *"
                    autocomplete="new-password"
                    required
                    class="form-control password-input"
                    style="padding-right: 40px;"
                >

                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>
            <span id="passwordErrorFaculty" style="display:none; color:red;"></span>

            <p>Confirm Password:</p>
            <div class="input-field" style="position: relative;">
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password *"
                    autocomplete="new-password"
                    required
                    class="form-control password-input"
                    style="padding-right: 40px;"
                >

                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>
            <span id="confirmPasswordErrorFaculty" style="display:none; color:red;"></span>

            <input type="hidden" name="client_type" value="faculty">

            <!-- Data Privacy Checkbox -->
            <div class="data-privacy">
                <input type="checkbox" id="agreePrivacyFaculty">
                <label for="agreePrivacyFaculty">
                    I agree to the 
                    <a href="#" id="privacyLinkFaculty">Data Privacy Policy</a>
                </label>
            </div>

            <!-- Data Privacy Modal -->
            <div id="privacyModal" class="modal-overlay" style="display:none;">
                <div class="privacy-modal">

                    <!-- Header -->
                    <div class="privacy-modal-header">
                        Privacy Notice (RA 10173 – Data Privacy Act of 2012)
                    </div>

                    <!-- Body -->
                    <div class="privacy-modal-body">
                        <div class="privacy-text">
                            <p>
                                Quirino State University (“QSU”) respects your right to privacy and is committed to protecting your personal data
                                in compliance with <strong>Republic Act No. 10173</strong>, also known as the <strong>Data Privacy Act of 2012</strong>,
                                and its Implementing Rules and Regulations (IRR), as well as issuances of the <strong>National Privacy Commission (NPC)</strong>.
                            </p>

                            <p><strong>Purpose of Collection.</strong> We collect and process your information to:</p>
                            <ul>
                                <li>create and manage your account for QSU E-PACD services;</li>
                                <li>verify your identity (including email/OTP verification);</li>
                                <li>process and respond to inquiries, requests, and feedback;</li>
                                <li>generate service records, reports, and audit logs for accountability and service improvement; and</li>
                                <li>comply with legal and regulatory requirements.</li>
                            </ul>

                            <p><strong>Types of Personal Data Collected.</strong> This may include your name, email address, client type,
                                ID number (if applicable), department/course information, and system logs needed for security and fraud prevention.</p>

                            <p><strong>Use, Sharing, and Disclosure.</strong> Your personal data will be accessed only by authorized QSU personnel.
                                We do not sell your data. Disclosure may occur only when required by law, lawful order, or when necessary to deliver the service.</p>

                            <p><strong>Protection and Retention.</strong> QSU implements reasonable organizational, physical, and technical security measures.
                                Data is retained only for as long as necessary for the stated purposes and legal obligations, then securely disposed of.</p>

                            <p><strong>Your Data Privacy Rights.</strong> Subject to applicable laws and QSU policies, you may have the right to be informed,
                                access, correct, object, request deletion/blocking, and file a complaint with the NPC.</p>

                            <p class="mb-0">
                                By clicking <strong>Close</strong> and continuing to register, you confirm that you have read and understood this Privacy Notice
                                and consent to the processing of your personal data.
                            </p>

                            <p class="privacy-contact">
                                <small>For concerns, contact: <strong>info@qsu.edu.ph</strong></small>
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="privacy-modal-footer">
                        <button type="button" id="closePrivacyModal" class="privacy-close-btn">Close</button>
                    </div>

                </div>
            </div>

            <button type="submit" id="registerBtnFaculty">Register</button>
        </div>
    </form>


    <!-- Alumni Registration Form -->
    <form action="{{ route('register.store') }}" method="POST" id="form-alumni" class="contact-left hidden">
        @csrf
        <div class="form-header">
            <h2>Alumni Registration</h2>
            <a type="button" class="back-btn" onclick="goBackToClientType()">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        <!-- Step 1: Gmail Verification -->
        <div id="alumniEmailVerification">
            <input type="email" name="email" id="alumniEmail" placeholder="Enter your Libris" autocomplete="off" required>
            <div class="helper-note">
                <i class="fa-solid fa-circle-info"></i>
                Tip: Use your <strong>real name</strong> that appears in your email to avoid registration errors.
            </div>
            <button type="button" 
                    id="sendOtpBtnAlumni" 
                    data-send-otp="{{ route('alumni.sendOtp') }}" 
                    data-csrf="{{ csrf_token() }}">
                Send OTP
            </button>

            <div id="otpSectionAlumni" style="display:none; margin-top:10px;">
                <input type="text" id="otpInputAlumni" autocomplete="off" placeholder="Enter OTP">
                <button type="button" id="verifyOtpBtnAlumni">Verify OTP</button>
                <button type="button" id="resendOtpBtnAlumni" 
                        data-send-otp="{{ route('alumni.sendOtp') }}" 
                        data-csrf="{{ csrf_token() }}">
                    Resend OTP
                </button>
            </div>

            <!-- Google Login for Email -->
            <a href="{{ route('google.login') }}?clientType=alumni" 
            id="chooseGmailBtnAlumni" 
            class="google-btn"
            data-target="alumniEmail">
                <i class="fab fa-google"></i> Choose Gmail
            </a>
        </div>

        <!-- Step 2: Full Registration -->
        <div id="registrationFieldsAlumni" style="display:none; margin-top:20px;">
            <div class="name-fields">
                <input type="text" name="first_name" placeholder="First Name *" required autocomplete="off" spellcheck="false" 
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

                <input type="text" name="middle_initial" placeholder="Middle Initial(Optional)" autocomplete="off" spellcheck="false" maxlength="2"
                    oninput="this.value = this.value.replace(/[^a-zA-Z.]/g, '');">

                <input type="text" name="last_name" placeholder="Last Name *" required autocomplete="off" spellcheck="false"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

                <input type="text" name="suffix" placeholder="Suffix(leave blank if none)" autocomplete="off" spellcheck="false" maxlength="10"
                    oninput="this.value = this.value.replace(/[^a-zA-Z.,]/g, '');">
            </div>

            <div class="input-box">
                <select id="gradYearSelect" name="gradyear" required>
                    <option value="" disabled selected hidden>Select Graduation Year</option>
                </select>
            </div>

            <div class="input-box">
                <select id="courseSelectAlumni" name="course_alumni" required>
                    <option value="" disabled selected hidden>Select Course</option>
                    <option value="BEEd">BEEd</option>
                    <option value="BSEd-English">BSEd-English</option>
                    <option value="BSEd-Math">BSEd-Math</option>
                    <option value="BSEd-Filipino">BSEd-Filipino</option>
                    <option value="BSEd-Science">BSEd-Science</option>
                    <option value="BTLEd-HomeEcon">BTLEd-HomeEcon</option>
                    <option value="BTLEd-ICT">BTLEd-ICT</option>
                    <option value="BTLEd-AgriFishery">BTLEd-AgriFishery</option>
                    <option value="CAS-BSA">CAS-BSA</option>
                    <option value="BSABE">BSABE</option>
                    <option value="BSForestry">BSForestry</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BSOA">BSOA</option>
                    <option value="BSCrim">BSCrim</option>
                    <option value="BSND">BSND</option>
                    <option value="Caregiving-NCII">Caregiving-NCII</option>
                    <option value="BSHM">BSHM</option>
                    <option value="BSTM">BSTM</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="otherCourseInputAlumni" name="other_course_alumni" placeholder="Specify Course" style="display:none; margin-top:5px;" autocomplete="off">
            </div>

            <p>Password:</p>
            <div class="input-field" style="position: relative;">
                <input
                    type="password"
                    name="password"
                    id="alumniPassword"
                    placeholder="Password *"
                    autocomplete="new-password"
                    required
                    class="form-control password-input"
                    style="padding-right: 40px;"
                >

                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>
            <span id="passwordErrorAlumni" style="display:none; color:red;"></span>


            <p>Confirm Password:</p>
            <div class="input-field" style="position: relative;">
                <input
                    type="password"
                    name="password_confirmation"
                    id="alumniPasswordConfirm"
                    placeholder="Confirm Password *"
                    autocomplete="new-password"
                    required
                    class="form-control password-input"
                    style="padding-right: 40px;"
                >

                <i class="fa-solid fa-eye toggle-password" style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #555;
                "></i>
            </div>
            <span id="confirmPasswordErrorAlumni" style="display:none; color:red;"></span>

            <!-- This tells Laravel the client type -->
            <input type="hidden" name="client_type" value="alumni">

            <!-- This tracks whether the email was verified -->
            <input type="hidden" id="emailVerifiedAlumni" name="emailVerifiedAlumni" value="0">

            <!-- Data Privacy Checkbox -->
            <div class="data-privacy">
                <input type="checkbox" id="agreePrivacyAlumni">
                <label for="agreePrivacyAlumni">
                    I agree to the 
                    <a href="#" id="privacyLinkAlumni">Data Privacy Policy</a>
                </label>
            </div>

            <!-- Data Privacy Modal -->
            <div id="privacyModal" class="modal-overlay" style="display:none;">
                <div class="privacy-modal">

                    <!-- Header -->
                    <div class="privacy-modal-header">
                        Privacy Notice (RA 10173 – Data Privacy Act of 2012)
                    </div>

                    <!-- Body -->
                    <div class="privacy-modal-body">
                        <div class="privacy-text">
                            <p>
                                Quirino State University (“QSU”) respects your right to privacy and is committed to protecting your personal data
                                in compliance with <strong>Republic Act No. 10173</strong>, also known as the <strong>Data Privacy Act of 2012</strong>,
                                and its Implementing Rules and Regulations (IRR), as well as issuances of the <strong>National Privacy Commission (NPC)</strong>.
                            </p>

                            <p><strong>Purpose of Collection.</strong> We collect and process your information to:</p>
                            <ul>
                                <li>create and manage your account for QSU E-PACD services;</li>
                                <li>verify your identity (including email/OTP verification);</li>
                                <li>process and respond to inquiries, requests, and feedback;</li>
                                <li>generate service records, reports, and audit logs for accountability and service improvement; and</li>
                                <li>comply with legal and regulatory requirements.</li>
                            </ul>

                            <p><strong>Types of Personal Data Collected.</strong> This may include your name, email address, client type,
                                ID number (if applicable), department/course information, and system logs needed for security and fraud prevention.</p>

                            <p><strong>Use, Sharing, and Disclosure.</strong> Your personal data will be accessed only by authorized QSU personnel.
                                We do not sell your data. Disclosure may occur only when required by law, lawful order, or when necessary to deliver the service.</p>

                            <p><strong>Protection and Retention.</strong> QSU implements reasonable organizational, physical, and technical security measures.
                                Data is retained only for as long as necessary for the stated purposes and legal obligations, then securely disposed of.</p>

                            <p><strong>Your Data Privacy Rights.</strong> Subject to applicable laws and QSU policies, you may have the right to be informed,
                                access, correct, object, request deletion/blocking, and file a complaint with the NPC.</p>

                            <p class="mb-0">
                                By clicking <strong>Close</strong> and continuing to register, you confirm that you have read and understood this Privacy Notice
                                and consent to the processing of your personal data.
                            </p>

                            <p class="privacy-contact">
                                <small>For concerns, contact: <strong>info@qsu.edu.ph</strong></small>
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="privacy-modal-footer">
                        <button type="button" id="closePrivacyModal" class="privacy-close-btn">Close</button>
                    </div>

                </div>
            </div>


            <button type="submit" id="registerBtnAlumni">Register</button>
        </div>
    </form>



<!-- Others Registration / Complete Profile (Facebook) -->
<form action="{{ route('others.completeProfile') }}" method="POST" id="form-others" class="contact-left hidden">
    @csrf

    <div class="form-header">
        <h2>Guest Registration</h2>
        <a type="button" class="back-btn" onclick="goBackToClientType()">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    @php
        $fbVerified = session('fb_verified_others', false);
        $fbName  = session('fb_name', '');
        $fbEmail = session('fb_email', '');

        // Split name: First = first token, Last = last token, Middle = everything between (optional)
        $parts = $fbName ? preg_split('/\s+/', trim($fbName)) : [];
        $fbFirst = $parts[0] ?? '';
        $fbLast  = count($parts) > 1 ? $parts[count($parts)-1] : '';
        $fbMiddle = count($parts) > 2 ? implode(' ', array_slice($parts, 1, -1)) : '';
    @endphp

    {{-- Show validation errors nicely --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="margin: 10px 0;">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Step 1: Facebook Verification -->
    <div id="othersFacebookVerification" style="{{ $fbVerified ? 'display:none;' : 'display:block;' }}">
        <p style="margin: 0 0 10px;">
            Continue using Facebook to verify your account. After confirming, you can always log in with Facebook.
        </p>

        <a href="{{ route('facebook.redirect', ['clientType' => 'others']) }}"
           class="facebook-btn"
           style="display:inline-flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none;">
            <i class="fab fa-facebook"></i> Continue with Facebook
        </a>
    </div>

    <!-- Step 2: Complete Registration (after Facebook) -->
    <div id="registrationFieldsOthers"
         style="{{ $fbVerified ? 'display:block;' : 'display:none;' }}; margin-top:20px;">

         <input type="hidden" id="emailVerifiedOthers" name="emailVerifiedOthers" value="1">
        <!-- Email from Facebook (show + ALWAYS send hidden) -->
        <div class="input-box">
            <input type="email"
                   value="{{ old('email', $fbEmail) }}"
                   readonly
                   placeholder="Email (from Facebook)"
                   class="contact-inputs">
            <input type="hidden" name="email" value="{{ old('email', $fbEmail) }}">
        </div>

        <div class="name-fields">
            <input type="text"
                   name="first_name"
                   placeholder="First Name *"
                   required
                   autocomplete="off"
                   spellcheck="false"
                   value="{{ old('first_name', $fbFirst) }}"
                   oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

            <input type="text"
                   name="middle_initial"
                   placeholder="Middle Name / Initial (Optional)"
                   autocomplete="off"
                   spellcheck="false"
                   maxlength="20"
                   value="{{ old('middle_initial', $fbMiddle) }}"
                   oninput="this.value = this.value.replace(/[^a-zA-Z.\s]/g, '');">

            <input type="text"
                   name="last_name"
                   placeholder="Last Name *"
                   required
                   autocomplete="off"
                   spellcheck="false"
                   value="{{ old('last_name', $fbLast) }}"
                   oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">

            <input type="text"
                   name="suffix"
                   placeholder="Suffix (leave blank if none)"
                   autocomplete="off"
                   spellcheck="false"
                   maxlength="10"
                   value="{{ old('suffix') }}"
                   oninput="this.value = this.value.replace(/[^a-zA-Z.,\s]/g, '');">
        </div>

        <div class="input-box">
            <input type="text"
                   name="address"
                   placeholder="Address *"
                   required
                   autocomplete="off"
                   spellcheck="false"
                   value="{{ old('address') }}">
        </div>

        <!-- Set Password -->
        <p>Create Password:</p>
        <div class="input-field" style="position: relative;">
            <input
                type="password"
                name="password"
                id="othersPassword"
                placeholder="Create Password *"
                autocomplete="new-password"
                required
                class="form-control password-input"
                style="padding-right: 40px;"
            >
            <i class="fa-solid fa-eye toggle-password" style="
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #555;
            "></i>
        </div>
        <span id="passwordErrorOthers" style="display:none; color:red;"></span>

        <p>Confirm Password:</p>
        <div class="input-field" style="position: relative;">
            <input
                type="password"
                name="password_confirmation"
                id="othersPasswordConfirm"
                placeholder="Confirm Password *"
                autocomplete="new-password"
                required
                class="form-control password-input"
                style="padding-right: 40px;"
            >
            <i class="fa-solid fa-eye toggle-password" style="
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #555;
            "></i>
        </div>
        <span id="confirmPasswordErrorOthers" style="display:none; color:red;"></span>

        <input type="hidden" name="client_type" value="others">
        <input type="hidden" name="fb_verified" value="{{ $fbVerified ? 1 : 0 }}">

        <div class="data-privacy">
            <input type="checkbox" id="agreePrivacyOthers">
            <label for="agreePrivacyOthers">
                I agree to the
                <a href="#" id="privacyLinkOthers">Data Privacy Policy</a>
            </label>
        </div>

        <!-- Data Privacy Modal -->
            <div id="privacyModalOthers" class="modal-overlay" style="display:none;">
                <div class="privacy-modal">

                    <!-- Header -->
                    <div class="privacy-modal-header">
                        Privacy Notice (RA 10173 – Data Privacy Act of 2012)
                    </div>

                    <!-- Body -->
                    <div class="privacy-modal-body">
                        <div class="privacy-text">
                            <p>
                                Quirino State University (“QSU”) respects your right to privacy and is committed to protecting your personal data
                                in compliance with <strong>Republic Act No. 10173</strong>, also known as the <strong>Data Privacy Act of 2012</strong>,
                                and its Implementing Rules and Regulations (IRR), as well as issuances of the <strong>National Privacy Commission (NPC)</strong>.
                            </p>

                            <p><strong>Purpose of Collection.</strong> We collect and process your information to:</p>
                            <ul>
                                <li>create and manage your account for QSU E-PACD services;</li>
                                <li>verify your identity (including email/OTP verification);</li>
                                <li>process and respond to inquiries, requests, and feedback;</li>
                                <li>generate service records, reports, and audit logs for accountability and service improvement; and</li>
                                <li>comply with legal and regulatory requirements.</li>
                            </ul>

                            <p><strong>Types of Personal Data Collected.</strong> This may include your name, email address, client type,
                                ID number (if applicable), department/course information, and system logs needed for security and fraud prevention.</p>

                            <p><strong>Use, Sharing, and Disclosure.</strong> Your personal data will be accessed only by authorized QSU personnel.
                                We do not sell your data. Disclosure may occur only when required by law, lawful order, or when necessary to deliver the service.</p>

                            <p><strong>Protection and Retention.</strong> QSU implements reasonable organizational, physical, and technical security measures.
                                Data is retained only for as long as necessary for the stated purposes and legal obligations, then securely disposed of.</p>

                            <p><strong>Your Data Privacy Rights.</strong> Subject to applicable laws and QSU policies, you may have the right to be informed,
                                access, correct, object, request deletion/blocking, and file a complaint with the NPC.</p>

                            <p class="mb-0">
                                By clicking <strong>Close</strong> and continuing to register, you confirm that you have read and understood this Privacy Notice
                                and consent to the processing of your personal data.
                            </p>

                            <p class="privacy-contact">
                                <small>For concerns, contact: <strong>info@qsu.edu.ph</strong></small>
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="privacy-modal-footer">
                        <button type="button" id="closePrivacyModalOthers" class="privacy-close-btn">Close</button>
                    </div>

                </div>
            </div>

        <button type="submit" id="registerBtnOthers">Finish Registration</button>
    </div>
</form>

    <!-- Custom Notification Modal -->
    <div id="customModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <p id="customModalMessage">System:</p>
        </div>
    </div>



    <!-- Modal for Email Already Registered -->
    @if($errors->has('email'))
        <div id="emailErrorModal" class="modal-overlay">
            <div class="modal-box">
                <h3>Email Already Registered</h3>
                <p>{{ $errors->first('email') }}</p>
                <button onclick="closeModal('emailErrorModal')">OK</button>
            </div>
        </div>
    @endif

    
<script src="{{ asset('js/inquiries.js') }}"></script>
<script>
document.addEventListener('click', function(e){
  const icon = e.target.closest('.toggle-password');
  if(!icon) return;

  const wrapper = icon.closest('.input-field');
  if(!wrapper) return;

  const input = wrapper.querySelector('input[type="password"], input[type="text"]');
  if(!input) return;

  const isPw = input.type === 'password';
  input.type = isPw ? 'text' : 'password';

  // switch icon
  icon.classList.toggle('fa-eye', !isPw);
  icon.classList.toggle('fa-eye-slash', isPw);
});
</script>
<script>

    // --- CUSTOM MODAL FUNCTIONS ---
    const customModal = document.getElementById("customModal");
    const customModalMessage = document.getElementById("customModalMessage");
    const customClose = document.querySelector(".custom-close");

    let modalAutoCloseTimer = null;
    let modalFadeOutTimer = null;

    function hideCustomModal() {
        if (!customModal) return;

        if (modalAutoCloseTimer) clearTimeout(modalAutoCloseTimer);
        if (modalFadeOutTimer) clearTimeout(modalFadeOutTimer);
        modalAutoCloseTimer = null;
        modalFadeOutTimer = null;

        customModal.style.opacity = "0";
        customModal.style.display = "none";
    }

    function shouldAutoFadeModal(message) {
        const text = (message || "").toLowerCase();
        return text.includes("otp sent") || text.includes("you may proceed") || text.includes("proceed to registration");
    }

    function showModal(message) {
        customModalMessage.textContent = message;
        customModal.style.display = "block";
        customModal.style.opacity = "1";
        customModal.style.transition = "opacity 0.3s ease";

        if (modalAutoCloseTimer) clearTimeout(modalAutoCloseTimer);
        if (modalFadeOutTimer) clearTimeout(modalFadeOutTimer);

        if (shouldAutoFadeModal(message)) {
            modalAutoCloseTimer = setTimeout(() => {
                customModal.style.opacity = "0";
                modalFadeOutTimer = setTimeout(() => {
                    customModal.style.display = "none";
                    customModal.style.opacity = "1";
                }, 300);
            }, 5000);
        }
    }

    customClose.addEventListener("click", () => {
        hideCustomModal();
    });

    window.addEventListener("click", (event) => {
        if (event.target == customModal) {
            hideCustomModal();
        }
    });

    

    document.addEventListener('DOMContentLoaded', () => {
        const studentEmail = document.getElementById('studentEmail');
        const sendOtpBtn = document.getElementById('sendOtpBtn');
        const resendOtpBtn = document.getElementById('resendOtpBtn');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        const otpSection = document.getElementById('otpSection');
        const registrationFields = document.getElementById('registrationFields');
        const emailVerification = document.getElementById('emailVerification');

        // Show OTP
        function showOtp() {
            otpSection.style.display = 'block';
            document.getElementById('otpInput').focus();
        }

        // Send OTP (student) - with anti double click + "Sending..."
        async function sendOtp(button) {
            const email = studentEmail.value.trim();

            if (!email.endsWith("@libris.qsu.edu.ph")) {
                showModal("Use official QSU Libris email.");
                studentEmail.focus();
                return;
            }

            // prevent double click / spam click
            if (button.dataset.locked === "1") return;
            button.dataset.locked = "1";

            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = "Sending...";

            try {
                // 1) Check if email is already registered
                const checkRes = await fetch("{{ route('student.checkEmail') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ email })
                });

                const checkData = await checkRes.json();

                if (checkData.exists) {
                showModal("This libris account is already registered. Please use your personal libris account!");
                studentEmail.focus();

                // unlock (since not sent)
                button.disabled = false;
                button.textContent = originalText;
                button.dataset.locked = "0";
                return;
                }

                // 2) Show OTP UI
                otpSection.style.display = "block";
                document.getElementById("otpInput").focus();

                // 3) Send OTP
                const sendRes = await fetch(button.dataset.sendOtp, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": button.dataset.csrf
                },
                body: JSON.stringify({ email })
                });

                const sendData = await sendRes.json();

                showModal(sendData.message || "OTP sent");

                // ✅ keep locked after successful send
                button.textContent = "Sent ✓";

                // OPTIONAL: If you want to allow again after some time, uncomment:
                // setTimeout(() => {
                //   button.disabled = false;
                //   button.textContent = originalText;
                //   button.dataset.locked = "0";
                // }, 60000);

            } catch (err) {
                console.error(err);
                showModal("Failed to send OTP. Please try again.");

                // unlock on failure
                button.disabled = false;
                button.textContent = originalText;
                button.dataset.locked = "0";
            }
        }


        sendOtpBtn.addEventListener('click', e => { e.preventDefault(); sendOtp(sendOtpBtn); });
        resendOtpBtn.addEventListener('click', e => { e.preventDefault(); sendOtp(resendOtpBtn); });

        function cooldown(button, seconds = 30) {
            let remaining = seconds;
            const original = button.dataset.originalText || button.textContent;

            button.disabled = true;

            const timer = setInterval(() => {
                button.textContent = `Resend (${remaining}s)`;
                remaining--;
                if (remaining < 0) {
                clearInterval(timer);
                button.disabled = false;
                button.textContent = original;
                button.dataset.locked = "0";
                }
            }, 1000);
        }



        // Verify OTP
        verifyOtpBtn.addEventListener('click', e => {
        e.preventDefault();
        const otpValue = document.getElementById('otpInput').value.trim();

        if (!otpValue) { 
            showModal('Enter OTP'); 
            return; 
        }

        console.log('Verifying OTP:', studentEmail.value, otpValue);

        fetch("{{ route('student.verifyOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: studentEmail.value, otp: otpValue })
        })
        .then(res => res.json())
        .then(data => {
            console.log('OTP verify response:', data);
            showModal(data.message || 'Verification failed');

            if (data.success) {
                emailVerification.style.display = 'none';
                registrationFields.style.display = 'block';
                registrationFields.querySelector('input[name="first_name"]').focus();
            } else {
                registrationFields.style.display = 'none';
            }
        })
        .catch(err => {
            console.error(err);
            showModal('Error verifying OTP.');
        });
    });


    document.getElementById('otpInput').addEventListener('keypress', e => {
        if (e.key === 'Enter') verifyOtpBtn.click();
    });

    // === ADD THIS FOR STUDENT ID VALIDATION ===
    const studentIdInput = document.getElementById('idnumber'); // make sure your input has id="studentId"

    studentIdInput.addEventListener('input', () => {
        // Allow only numbers and dash
        studentIdInput.value = studentIdInput.value.replace(/[^0-9-]/g, '');

        // Auto-insert dash after first 2 digits
        if(studentIdInput.value.length > 2 && studentIdInput.value[2] !== '-') {
            studentIdInput.value = studentIdInput.value.slice(0,2) + '-' + studentIdInput.value.slice(2);
        }

        // Validate format: XX-XXXX or XX-XXXXX
        const validFormat = /^\d{2}-\d{4,5}$/.test(studentIdInput.value);
        if(!validFormat && studentIdInput.value.length >= 7){
            studentIdInput.setCustomValidity("Use format: 00-0000 or 12-34567");
        } else {
            studentIdInput.setCustomValidity("");
        }
    });
});


// Google Login
    function setupGmailBtn(btnId){
        const btn = document.getElementById(btnId);
        if(!btn) return;
        btn.addEventListener('click', e => {
            e.preventDefault();
            const targetInputId = btn.dataset.target;
            const popup = window.open(btn.href, 'googleLogin', 'width=500,height=600');

            function receiveEmail(event){
                if(event.data.google_email){
                    const input = document.getElementById(targetInputId);
                    if(input) input.value = event.data.google_email;
                    popup.close();
                    window.removeEventListener('message', receiveEmail);
                }
            }

            window.addEventListener('message', receiveEmail);
        });
    }

    ['chooseGmailBtn','chooseGmailBtnFaculty','chooseGmailBtnAlumni','chooseGmailBtnOthers'].forEach(id => setupGmailBtn(id));

    ['pickGmailBtn','pickGmailBtnFaculty','pickGmailBtnAlumni','pickGmailBtnOthers'].forEach(id => setupGmailBtn(id));


    window.addEventListener('message', event => {
        if(event.data.google_email){
            Object.values(registerForms).forEach(form => {
                if(form && form.style.display !== 'none'){
                    const emailInput = form.querySelector('input[type="email"]');
                    if(emailInput) emailInput.value = event.data.google_email;
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
    const courseSelect = document.getElementById('courseSelect');
    const yearSelect = document.getElementById('yearSelect');
    const courseYearInput = document.getElementById('courseYearInput');

    function updateCourseYear() {
        if(courseSelect.value && yearSelect.value){
            courseYearInput.value = courseSelect.value + ' - ' + yearSelect.value;
        }
    }

    courseSelect.addEventListener('change', updateCourseYear);
    yearSelect.addEventListener('change', updateCourseYear);
});


    
   document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-student');
    if (!form) return;

    const studentEmailInput = document.getElementById('studentEmail'); 
    const studentIdInput = form.querySelector('input[name="idnumber"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmPasswordInput = form.querySelector('input[name="password_confirmation"]');

    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    const agreePrivacy = document.getElementById('agreePrivacy');
    const registerBtn = document.getElementById('registerBtn');

    const privacyLink = document.getElementById('privacyLink');
    const privacyModal = document.getElementById('privacyModal');
    const closePrivacyModal = document.getElementById('closePrivacyModal');

    // --- CUSTOM MODAL FUNCTIONS ---
    const customModal = document.getElementById("customModal");
    const customModalMessage = document.getElementById("customModalMessage");
    const customClose = document.querySelector(".custom-close");

    let modalAutoCloseTimer = null;
    let modalFadeOutTimer = null;

    function hideCustomModal() {
        if (!customModal) return;

        if (modalAutoCloseTimer) clearTimeout(modalAutoCloseTimer);
        if (modalFadeOutTimer) clearTimeout(modalFadeOutTimer);
        modalAutoCloseTimer = null;
        modalFadeOutTimer = null;

        customModal.style.opacity = "0";
        customModal.style.display = "none";
    }

    function shouldAutoFadeModal(message) {
        const text = (message || "").toLowerCase();
        return text.includes("otp sent") || text.includes("you may proceed") || text.includes("proceed to registration");
    }

    function showModal(message) {
        if (!customModal || !customModalMessage) return alert(message);
        customModalMessage.textContent = message;
        customModal.style.display = "block";
        customModal.style.opacity = "1";
        customModal.style.transition = "opacity 0.3s ease";

        if (modalAutoCloseTimer) clearTimeout(modalAutoCloseTimer);
        if (modalFadeOutTimer) clearTimeout(modalFadeOutTimer);

        if (shouldAutoFadeModal(message)) {
            modalAutoCloseTimer = setTimeout(() => {
                customModal.style.opacity = "0";
                modalFadeOutTimer = setTimeout(() => {
                    customModal.style.display = "none";
                    customModal.style.opacity = "1";
                }, 300);
            }, 5000);
        }
    }

    customClose?.addEventListener("click", () => {
        hideCustomModal();
    });

    window.addEventListener("click", (event) => {
        if (event.target === customModal) hideCustomModal();
    });

    // --- INITIAL SETUP ---
    if (registerBtn) registerBtn.disabled = true;

    // --- PASSWORD VALIDATION ---
    const strongPassword = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    function validatePassword() {
        if (!strongPassword.test(passwordInput.value)) {
        passwordError.textContent =
            "Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.";
        passwordError.style.display = "block";
        toggleRegisterButton();
        return false;
        }
        passwordError.style.display = "none";
        toggleRegisterButton();
        return true;
    }

    function validateConfirmPassword() {
        if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.style.display = "block";
        toggleRegisterButton();
        return false;
        }
        confirmPasswordError.style.display = "none";
        toggleRegisterButton();
        return true;
    }

    // --- STUDENT ID FORMAT VALIDATION ---
    function validateStudentId() {
        const idPattern = /^\d{2}-\d{4,5}$/;
        const ok = idPattern.test(studentIdInput.value.trim());

        if (!ok) {
        toggleRegisterButton(false);
        return false;
        }
        toggleRegisterButton();
        return true;
    }

    // --- UNIQUE STUDENT ID CHECK (AJAX) ---
    let lastCheckedId = "";
    studentIdInput.addEventListener("blur", () => {
        const idnum = studentIdInput.value.trim();
        if (idnum === "" || idnum === lastCheckedId) return;

        lastCheckedId = idnum;

        fetch(`/check-id/${encodeURIComponent(idnum)}`)
        .then((res) => res.json())
        .then((data) => {
            if (data.exists) {
            showModal("This Student ID is already registered or used by a faculty.");
            registerBtn.disabled = true;
            } else {
            toggleRegisterButton();
            }
        })
        .catch(() => console.log("ID check failed."));
    });

    // --- TOGGLE REGISTER BUTTON ---
    function toggleRegisterButton(forceEnable) {
        const isPasswordValid = strongPassword.test(passwordInput.value);
        const isConfirmValid = passwordInput.value === confirmPasswordInput.value;

        const isIdValid = /^\d{2}-\d{4,5}$/.test(studentIdInput.value.trim());

        if (!registerBtn) return;

        if (forceEnable !== undefined) {
        registerBtn.disabled = !forceEnable;
        return;
        }

        registerBtn.disabled = !(
        isPasswordValid &&
        isConfirmValid &&
        isIdValid
        );
    }

    // --- NAME SECURITY VALIDATION (STUDENT) ---
    function validateNameMatchesEmail() {
        const email = (studentEmailInput?.value || "").trim().toLowerCase();

        if (!email.endsWith("@libris.qsu.edu.ph")) {
        showModal("Your email must end with @libris.qsu.edu.ph");
        return false;
        }

        const firstNameRaw = form.querySelector('input[name="first_name"]').value.trim().toLowerCase();
        const lastNameRaw  = form.querySelector('input[name="last_name"]').value.trim().toLowerCase();
        const suffixRaw    = form.querySelector('input[name="suffix"]')?.value.trim().toLowerCase() || "";

        // Normalize: remove spaces/dots/hyphens
        const firstName = firstNameRaw.split(/\s+/)[0].replace(/[.\s-]/g, "");
        const lastName  = lastNameRaw.replace(/[.\s-]/g, "");

        // normalize email prefix
        const emailPrefix = email.split("@")[0];              // juan.delacruz / juandelacruz / juan.delacruzjr
        const emailNorm   = emailPrefix.replace(/[._-]/g, "").replace(/\d+/g, "");

        // optional suffix check
        const suffix = suffixRaw.replace(/[.\s-]/g, "");
        const knownSuffixes = ["jr", "sr", "ii", "iii", "iv"];

        if (suffix && knownSuffixes.includes(suffix) && !emailNorm.includes(suffix)) {
        showModal("Your suffix (e.g., Jr/Sr/II/III/IV) must match your email.");
        return false;
        }

        // Must contain both first + last names in the email prefix
        const hasFirst = emailNorm.includes(firstName);
        const hasLast  = emailNorm.includes(lastName);

        if (!hasFirst || !hasLast) {
        showModal(
            "Your First Name and Last Name must appear in your Libris email.\n\n" +
            "Examples:\n" +
            "juan.delacruz@libris.qsu.edu.ph\n" +
            "juandelacruz@libris.qsu.edu.ph\n" +
            "juan.delacruzjr@libris.qsu.edu.ph"
        );
        return false;
        }

        return true;
    }

    // --- EVENT LISTENERS ---
    passwordInput.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validateConfirmPassword);
    studentIdInput.addEventListener("input", validateStudentId);
    agreePrivacy?.addEventListener("change", toggleRegisterButton);

    privacyLink?.addEventListener("click", (e) => {
        e.preventDefault();
        if (privacyModal) privacyModal.style.display = "flex";
    });

    closePrivacyModal?.addEventListener("click", () => {
        if (privacyModal) privacyModal.style.display = "none";
    });

    // --- FORM SUBMISSION ---
    form.addEventListener("submit", function (e) {
        const isPasswordValid = validatePassword();
        const isConfirmValid = validateConfirmPassword();
        const isPrivacyChecked = agreePrivacy ? agreePrivacy.checked : true;
        const isIdValid = validateStudentId();
        const isNameValid = validateNameMatchesEmail();

        if (!isPasswordValid || !isConfirmValid || !isPrivacyChecked || !isIdValid || !isNameValid) {
        e.preventDefault();

        if (!isPrivacyChecked) {
            showModal("You must agree to the Data Privacy Policy before registering.");
            return false;
        }

        if (!isIdValid) {
            showModal("Student ID must be in the correct format, e.g., 23-3456 or 21-12345.");
            return false;
        }
        return;
        }
    });
});



document.addEventListener('DOMContentLoaded', () => {
    // --- FACULTY EMAIL & OTP ---
    const facultyEmail = document.getElementById('facultyEmail');
    const sendOtpBtnFaculty = document.getElementById('sendOtpBtnFaculty');
    const resendOtpBtnFaculty = document.getElementById('resendOtpBtnFaculty');
    const verifyOtpBtnFaculty = document.getElementById('verifyOtpBtnFaculty');
    const otpSectionFaculty = document.getElementById('otpSectionFaculty');
    const registrationFieldsFaculty = document.getElementById('registrationFieldsFaculty');
    const emailVerificationFaculty = document.getElementById('facultyEmailVerification');

    async function sendOtp(button) {
        const email = facultyEmail.value.trim();

        if (!email.endsWith("@qsu.edu.ph")) {
            showModal("Use official QSU email.");
            facultyEmail.focus();
            return;
        }

        // prevent double click
        if (button.dataset.locked === "1") return;
        button.dataset.locked = "1";

        // save original text (used by cooldown)
        if (!button.dataset.originalText) {
            button.dataset.originalText = button.textContent;
        }

        const originalText = button.dataset.originalText;
        button.disabled = true;
        button.textContent = "Sending...";

        try {
            const checkRes = await fetch("{{ route('faculty.checkEmail') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ email, client_type: "faculty" })
            });

            const checkData = await checkRes.json();

            if (checkData.exists) {
            showModal("This Libris account is already registered.");

            button.disabled = false;
            button.textContent = originalText;
            button.dataset.locked = "0";
            return;
            }

            otpSectionFaculty.style.display = "block";
            document.getElementById("otpInputFaculty").focus();

            const sendRes = await fetch(button.dataset.sendOtp, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": button.dataset.csrf
            },
            body: JSON.stringify({ email })
            });

            const sendData = await sendRes.json();
            showModal(sendData.message || "OTP sent");

            button.textContent = "Sent ✓";

            if (button.id === "resendOtpBtnFaculty") {
            cooldown(button, 30); // change to 60 if you want 1 min
            }

        } catch (err) {
            console.error(err);
            showModal("Failed to send OTP. Please try again.");

            // unlock on failure
            button.disabled = false;
            button.textContent = originalText;
            button.dataset.locked = "0";
        }
    }

    sendOtpBtnFaculty.addEventListener('click', e => { e.preventDefault(); sendOtp(sendOtpBtnFaculty); });
    resendOtpBtnFaculty.addEventListener('click', e => { e.preventDefault(); sendOtp(resendOtpBtnFaculty); });

    function cooldown(button, seconds = 30) {
        let remaining = seconds;
        const original = button.dataset.originalText || button.textContent;

        button.disabled = true;

        const timer = setInterval(() => {
            button.textContent = `Resend (${remaining}s)`;
            remaining--;
            if (remaining < 0) {
            clearInterval(timer);
            button.disabled = false;
            button.textContent = original;
            button.dataset.locked = "0";
            }
        }, 1000);
    }

    verifyOtpBtnFaculty.addEventListener('click', e => {
        e.preventDefault();
        const otpValue = document.getElementById('otpInputFaculty').value.trim();
        if(!otpValue){ showModal('Enter OTP'); return; }

        fetch("{{ route('faculty.verifyOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: facultyEmail.value, otp: otpValue })
        })
        .then(res => res.json())
        .then(data => {
            showModal(data.message || 'Verification failed');
            if(data.success){
                emailVerificationFaculty.style.display = 'none';
                registrationFieldsFaculty.style.display = 'block';
                registrationFieldsFaculty.querySelector('input[name="first_name"]').focus();
            }
        });
    });

    // --- FACULTY FORM VALIDATION ---
    const form = document.getElementById('form-faculty');
    const facultyIdInput = form.querySelector('input[name="facultyId"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmPasswordInput = form.querySelector('input[name="password_confirmation"]');
    const passwordError = document.getElementById('passwordErrorFaculty');
    const confirmPasswordError = document.getElementById('confirmPasswordErrorFaculty');
    const agreePrivacy = document.getElementById('agreePrivacyFaculty');
    const registerBtn = document.getElementById('registerBtnFaculty');
    const privacyLink = document.getElementById('privacyLinkFaculty');
    const privacyModal = document.getElementById('privacyModalFaculty');
    const closePrivacyModal = document.getElementById('closePrivacyModalFaculty');

    registerBtn.disabled = true;

    // --- PASSWORD VALIDATION ---
    const strongPassword = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    function validatePassword() {
        if (!strongPassword.test(passwordInput.value)) {
            passwordError.textContent = "Password must have at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.";
            passwordError.style.display = 'block';
            toggleRegisterButton();
            return false;
        } else { passwordError.style.display = 'none'; toggleRegisterButton(); return true; }
    }

    function validateConfirmPassword() {
        if(passwordInput.value !== confirmPasswordInput.value){
            confirmPasswordError.textContent = "Passwords do not match.";
            confirmPasswordError.style.display = 'block';
            toggleRegisterButton();
            return false;
        } else { confirmPasswordError.style.display = 'none'; toggleRegisterButton(); return true; }
    }

    // --- FACULTY ID VALIDATION ---
    facultyIdInput.addEventListener('input', () => {
        let v = facultyIdInput.value.toUpperCase().replace(/[^D0-9-]/g, '');
        if (!v.startsWith('D')) v = 'D' + v.replace(/^D*/, '');
        if (!v.startsWith('D-')) v = 'D-' + v.replace(/^D-*/, '');
        facultyIdInput.value = v;
        validateFacultyId();
    });

    // --- UNIQUE FACULTY ID CHECK ---
    let lastCheckedId = "";
    facultyIdInput.addEventListener('blur', () => {
        const idnum = facultyIdInput.value.trim();
        if(idnum === "" || idnum === lastCheckedId) return;
        lastCheckedId = idnum;

        fetch(`/check-id/${idnum}`)
        .then(res => res.json())
        .then(data => {
            if(data.exists){
                showModal("This Faculty ID is already registered or used by a student.");
                registerBtn.disabled = true;
            } else { toggleRegisterButton(); }
        })
        .catch(() => console.log("ID check failed."));
    });

    // --- NAME SECURITY VALIDATION ---
    function validateNameMatchesEmail() {
        const email = document.getElementById("facultyEmail").value.trim().toLowerCase();

        const firstNameRaw = form.querySelector('input[name="first_name"]').value.trim().toLowerCase();
        const lastNameRaw  = form.querySelector('input[name="last_name"]').value.trim().toLowerCase();
        const suffixRaw    = form.querySelector('input[name="suffix"]')?.value.trim().toLowerCase() || "";

        if (!email.endsWith("@qsu.edu.ph")) {
            showModal("Use official QSU email (@qsu.edu.ph).");
            return false;
        }

        const emailPrefix = email.split("@")[0]; // e.g. juandelacruzjr OR juan.delacruz OR juanjr.delacruz

        // Normalize email prefix: remove separators and digits
        const emailNorm = emailPrefix.replace(/[._-]/g, "").replace(/\d+/g, "");

        // Normalize name: remove spaces, dots, hyphens
        const firstName = firstNameRaw.split(/\s+/)[0].replace(/[.\s-]/g, "");
        const lastName  = lastNameRaw.replace(/[.\s-]/g, "");

        // Normalize suffix: allow Jr, Sr, II, III, IV (optional)
        const suffix = suffixRaw.replace(/[.\s-]/g, "");
        const knownSuffixes = ["jr", "sr", "ii", "iii", "iv"];

        // If user typed suffix, it must exist in email too (optional strictness)
        if (suffix && knownSuffixes.includes(suffix)) {
            if (!emailNorm.includes(suffix)) {
                showModal("Your suffix (e.g., Jr/Sr/II/III/IV) must match your email.");
                return false;
            }
        }
        const hasFirst = emailNorm.includes(firstName);
        const hasLast  = emailNorm.includes(lastName);

        if (!hasFirst || !hasLast) {
            showModal(
                "Your First Name and Last Name must appear in your email.\n\n" +
                "Allowed examples:\n" +
                "JuanDelaCruz@qsu.edu.ph\n" +
                "JuanDelaCruzJr@qsu.edu.ph\n" +
                "Juan.DelaCruz@qsu.edu.ph\n" +
                "Juan.DelaCruzJr@qsu.edu.ph\n" +
                "JuanJr.DelaCruz@qsu.edu.ph"
            );
            return false;
        }

        return true;
    }


    function validateFacultyId() {
        const isValid = /^D-\d{4,5}$/i.test(facultyIdInput.value.trim());
        if (!isValid) {
            registerBtn.disabled = true;
        } else {
            toggleRegisterButton();
        }
        return isValid;
    }

    // --- TOGGLE REGISTER BUTTON ---
    function toggleRegisterButton(forceEnable){
        const isPasswordValid = strongPassword.test(passwordInput.value);
        const isConfirmValid = passwordInput.value === confirmPasswordInput.value;
        const isIdValid = /^D-\d{4,5}$/i.test(facultyIdInput.value.trim());

        if(forceEnable !== undefined) registerBtn.disabled = !forceEnable;
        else registerBtn.disabled = !(isPasswordValid && isConfirmValid && isIdValid);
    }

    // --- EVENT LISTENERS ---
    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);
    facultyIdInput.addEventListener('input', validateFacultyId);
    agreePrivacy.addEventListener('change', toggleRegisterButton);
    privacyLink.addEventListener('click', e => { e.preventDefault(); privacyModal.style.display = 'flex'; });
    closePrivacyModal.addEventListener('click', () => privacyModal.style.display = 'none');

    form.addEventListener('submit', e => {
        const isPasswordValid = validatePassword();
        const isConfirmValid = validateConfirmPassword();
        const isPrivacyChecked = agreePrivacy.checked;
        const isIdValid = validateFacultyId();
        const isNameValid = validateNameMatchesEmail();

        if (!isPasswordValid || !isConfirmValid || !isPrivacyChecked || !isIdValid || !isNameValid) {

            e.preventDefault();

            if (!isPrivacyChecked) {
                showModal("You must agree to the Data Privacy Policy before registering.");
                return false;
            }

            if (!isIdValid) {
                showModal("Faculty ID must be in the correct format, e.g., D-1234 or D-12345.");
                return false;
            }

            return;
        }
    });

    // --- DEPARTMENT SELECT LOGIC ---
    const departmentSelect = document.getElementById('departmentSelect');
    const otherInput = document.getElementById('otherDepartmentInput');

    departmentSelect.addEventListener('change', () => {
        if(departmentSelect.value === 'Other'){
            otherInput.style.display = 'block';
            otherInput.required = true;
            otherInput.focus();
        } else {
            otherInput.style.display = 'none';
            otherInput.required = false;
        }
    });

    form.addEventListener('submit', e => {
        if(departmentSelect.value === 'Other'){
            const otherValue = otherInput.value.trim();
            if(!otherValue){
                e.preventDefault();
                showModal("Please specify your department/unit.");
                otherInput.focus();
                return false;
            }
            const newOption = document.createElement('option');
            newOption.value = otherValue;
            newOption.text = otherValue;
            newOption.selected = true;
            departmentSelect.appendChild(newOption);
        }
    });
});


document.addEventListener('DOMContentLoaded', () => {
    // ---------- ELEMENTS ----------
    const alumniEmail = document.getElementById('alumniEmail');
    const sendOtpBtn = document.getElementById('sendOtpBtnAlumni');
    const resendOtpBtn = document.getElementById('resendOtpBtnAlumni');
    const verifyOtpBtn = document.getElementById('verifyOtpBtnAlumni');
    const otpSection = document.getElementById('otpSectionAlumni');
    const registrationFields = document.getElementById('registrationFieldsAlumni');
    const emailVerificationDiv = document.getElementById('alumniEmailVerification');
    const emailVerifiedInput = document.getElementById('emailVerifiedAlumni');

    const form = document.getElementById('form-alumni');
    const firstNameInput = form.querySelector('input[name="first_name"]');
    const lastNameInput = form.querySelector('input[name="last_name"]');
    const passwordInput = document.getElementById('alumniPassword');
    const confirmPasswordInput = document.getElementById('alumniPasswordConfirm');
    const passwordError = document.getElementById('passwordErrorAlumni');
    const confirmError = document.getElementById('confirmPasswordErrorAlumni');
    const agreePrivacy = document.getElementById('agreePrivacyAlumni');
    const registerBtn = document.getElementById('registerBtnAlumni');

    const courseSelect = document.getElementById('courseSelectAlumni');
    const otherCourseInput = document.getElementById('otherCourseInputAlumni');

    const privacyLink = document.getElementById('privacyLinkAlumni');
    const privacyModal = document.getElementById('privacyModalAlumni');
    const closeModal = document.getElementById('closePrivacyModalAlumni');

    // ---------- OTP FUNCTIONS ----------
    async function sendOtp(button) {
        const email = alumniEmail.value.trim();

        if (!email.endsWith("@libris.qsu.edu.ph")) {
            showModal("Use a Libris account.");
            alumniEmail.focus();
            return;
        }

        // prevent double click
        if (button.dataset.locked === "1") return;
        button.dataset.locked = "1";

        // save original label (used by cooldown)
        if (!button.dataset.originalText) {
            button.dataset.originalText = button.textContent;
        }

        const originalText = button.dataset.originalText;
        button.disabled = true;
        button.textContent = "Sending...";

        try {
            // 1) check if already registered
            const checkRes = await fetch("{{ route('alumni.checkEmail') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ email, client_type: "alumni" })
            });

            const checkData = await checkRes.json();

            if (checkData.exists) {
            showModal("This Libris is already registered.");

            // unlock since nothing was sent
            button.disabled = false;
            button.textContent = originalText;
            button.dataset.locked = "0";
            return;
            }

            // 2) show OTP UI
            otpSection.style.display = "block";
            document.getElementById("otpInputAlumni").focus();

            // 3) send OTP
            const sendRes = await fetch(button.dataset.sendOtp, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": button.dataset.csrf
            },
            body: JSON.stringify({ email })
            });

            const sendData = await sendRes.json();
            showModal(sendData.message || "OTP sent");

            // success UI
            button.textContent = "Sent ✓";

            // cooldown only for RESEND button
            if (button.id === "resendOtpBtnAlumni") {
            cooldown(button, 30); // change to 60 if you want 60s
            }

            // if it's the FIRST send button, keep disabled permanently
            // (do nothing else)

        } catch (err) {
            console.error(err);
            showModal("Failed to send OTP. Please try again.");

            // unlock on failure
            button.disabled = false;
            button.textContent = originalText;
            button.dataset.locked = "0";
        }
    }

    sendOtpBtn.addEventListener('click', e => { e.preventDefault(); sendOtp(sendOtpBtn); });
    resendOtpBtn.addEventListener('click', e => { e.preventDefault(); sendOtp(resendOtpBtn); });

    function cooldown(button, seconds = 30) {
        let remaining = seconds;
        const original = button.dataset.originalText || button.textContent;

        button.disabled = true;

        const timer = setInterval(() => {
            button.textContent = `Resend (${remaining}s)`;
            remaining--;
            if (remaining < 0) {
            clearInterval(timer);
            button.disabled = false;
            button.textContent = original;
            button.dataset.locked = "0";
            }
        }, 1000);
    }

    verifyOtpBtn.addEventListener('click', e => {
        e.preventDefault();
        const otpValue = document.getElementById('otpInputAlumni').value.trim();
        if (!otpValue) { showModal("Enter OTP"); return; }

        fetch("{{ route('alumni.verifyOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: alumniEmail.value, otp: otpValue })
        })
        .then(res => res.json())
        .then(data => {
            showModal(data.message || 'Verification failed');
            if (data.success) {
                emailVerifiedInput.value = "1";
                emailVerificationDiv.style.display = 'none';
                registrationFields.style.display = 'block';
                firstNameInput.focus();
            }
        });
    });

    // ---------- PASSWORD VALIDATION ----------
    const strongPassword = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    function validatePassword() {
        if (!strongPassword.test(passwordInput.value)) {
            passwordError.textContent = "Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character (8+ characters).";
            passwordError.style.display = 'block';
            return false;
        }
        passwordError.style.display = 'none';
        return true;
    }

    function validateConfirmPassword() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmError.textContent = "Passwords do not match.";
            confirmError.style.display = 'block';
            return false;
        }
        confirmError.style.display = 'none';
        return true;
    }

    passwordInput.addEventListener('input', () => { validatePassword(); if(confirmPasswordInput.value) validateConfirmPassword(); });
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);

    // ---------- NAME MATCH EMAIL VALIDATION ----------
    function validateNameMatchesEmail() {
    const email = alumniEmail.value.trim().toLowerCase();
    let firstNameRaw = firstNameInput.value.trim().toLowerCase();
    let lastName = lastNameInput.value.trim().toLowerCase();

        let firstName = firstNameRaw.split(/\s+/)[0];

        const suffixRegex = /\b(jr|sr|ii|iii|iv)\b/g;
        firstName = firstName.replace(suffixRegex, '').trim();
        lastName = lastName.replace(suffixRegex, '').trim();

        const emailPrefix = email.split('@')[0];

        const emailParts = emailPrefix.split(/[._-]/);

        const hasFirstName = emailParts.some(p =>
            p.replace(/\d+/g, '').startsWith(firstName)
        );

        const hasLastName = emailParts.some(p =>
            p.replace(/\d+/g, '').startsWith(lastName)
        );

        if (!hasFirstName && !hasLastName) {
            showModal(
                `Your name must appear in your email.\n\nExample:\njuan@libris.qsu.edu.ph\njuan.delacruz@libris.qsu.edu.ph`
            );
            return false;
        }

        return true;
    }





    // ---------- COURSE "OTHER" ----------
    function toggleOtherCourse() {
        if (courseSelect.value === 'Other') {
            otherCourseInput.style.display = 'block';
            otherCourseInput.required = true;
            otherCourseInput.focus();
        } else {
            otherCourseInput.style.display = 'none';
            otherCourseInput.required = false;
            otherCourseInput.value = '';
        }
    }

    // Run on change
    courseSelect.addEventListener('change', toggleOtherCourse);

    // Run once after page load in case "Other" was pre-selected
    window.addEventListener('DOMContentLoaded', toggleOtherCourse);


    // ---------- FORM SUBMISSION ----------
    registerBtn.disabled = false;
    agreePrivacy.addEventListener('change', () => registerBtn.disabled = false);

    form.addEventListener('submit', e => {
        if (emailVerifiedInput.value !== "1") {
            e.preventDefault();
            showModal("Please verify your email before registering.");
            return;
        }

        if (!validatePassword() || !validateConfirmPassword() || !agreePrivacy.checked || !validateNameMatchesEmail()) {
            e.preventDefault();
            if (!agreePrivacy.checked) showModal("You must agree to the Data Privacy Policy.");
            return;
        }

        // Handle "Other" course properly
        if (courseSelect.value === 'Other') {
            const otherVal = otherCourseInput.value.trim();
            if (!otherVal) {
                e.preventDefault();
                showModal("Please specify your course.");
                otherCourseInput.focus();
                return;
            }
            // Create new option dynamically
            let existing = Array.from(courseSelect.options).find(o => o.value === otherVal);
            if (!existing) {
                const newOption = document.createElement('option');
                newOption.value = otherVal;
                newOption.text = otherVal;
                courseSelect.appendChild(newOption);
            }
            courseSelect.value = otherVal; // THIS ensures Laravel sees a valid value
        }

    });

    // ---------- PRIVACY MODAL ----------
    privacyLink.addEventListener('click', e => { e.preventDefault(); privacyModal.style.display = 'flex'; });
    closeModal.addEventListener('click', () => privacyModal.style.display = 'none');

});


document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // 1) OPEN "OTHERS REGISTER" AFTER FB CALLBACK
    // supports:
    // - /inquiries?open=register&clientType=others
    // - /inquiries#_=_  (facebook hash)
    // - /inquiries#others-register (optional)
    // =========================
    function openOthersRegisterUI() {
        // hide modal (if exists)
        const modal = document.getElementById('clientTypeModal');
        if (modal) modal.style.display = 'none';

        // show container/card if hidden
        const loginForms = document.getElementById('loginForms');
        if (loginForms) loginForms.classList.remove('hidden');

        // select Others in dropdown (if exists)
        const selector = document.getElementById('clientTypeSelector');
        if (selector) {
            selector.value = 'others';
            selector.dispatchEvent(new Event('change'));
        }

        // show the others form
        const formOthers = document.getElementById('form-others');
        if (formOthers) {
            formOthers.classList.remove('hidden');
            formOthers.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // optional: if you also have others login form, hide it
        const othersLoginForm = document.getElementById('othersLoginForm');
        if (othersLoginForm) othersLoginForm.classList.add('hidden');
    }

    const params = new URLSearchParams(window.location.search);
    const hash = window.location.hash || '';

    const fromQuery =
        params.get('open') === 'register' &&
        params.get('clientType') === 'others';

    // Facebook often appends #_=_ after redirect
    const fromFacebookHash = hash === '#_=_';

    // optional anchor support
    const fromAnchor = hash.includes('others-register');

    if (fromQuery || fromFacebookHash || fromAnchor) {
        openOthersRegisterUI();

        // clean URL (remove query + #_=_ without reloading)
        try {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        } catch (e) {}
    }




    // =========================
    // 3) PRIVACY MODAL (OTHERS)
    // =========================
    const privacyLinkOthers = document.getElementById('privacyLinkOthers');
    const privacyModalOthers = document.getElementById('privacyModalOthers');
    const closePrivacyModalOthers = document.getElementById('closePrivacyModalOthers');

    if (privacyLinkOthers && privacyModalOthers) {
        privacyLinkOthers.addEventListener('click', (e) => {
            e.preventDefault();
            privacyModalOthers.style.display = 'flex';
        });
    }

    if (closePrivacyModalOthers && privacyModalOthers) {
        closePrivacyModalOthers.addEventListener('click', () => {
            privacyModalOthers.style.display = 'none';
        });
    }


    document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const open = params.get('open');
    const clientType = params.get('clientType');

    const shouldOpenOthersStep2 = (open === 'others-register' && clientType === 'others');

    if (!shouldOpenOthersStep2) return;

    // hide client type modal
    const modal = document.getElementById('clientTypeModal');
    if (modal) modal.style.display = 'none';

    // show container/card
    const loginForms = document.getElementById('loginForms');
    if (loginForms) loginForms.classList.remove('hidden');

    // select Others in dropdown
    const selector = document.getElementById('clientTypeSelector');
    if (selector) {
        selector.value = 'others';
        selector.dispatchEvent(new Event('change'));
    }

    // show the others form
    const formOthers = document.getElementById('form-others');
    if (formOthers) formOthers.classList.remove('hidden');

    // FORCE Step 2 (registration fields)
    const step1 = document.getElementById('othersFacebookVerification');
    const step2 = document.getElementById('registrationFieldsOthers');

    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'block';

    step2?.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // clean URL
    window.history.replaceState({}, document.title, window.location.pathname);
});



    // ---------- FORM SUBMISSION ----------
    registerBtn.disabled = false;
    agreePrivacy.addEventListener('change', () => registerBtn.disabled = false);

    form.addEventListener('submit', e => {
        if (emailVerifiedInput.value !== "1") {
            e.preventDefault();
            showModal("Please verify your email before registering.");
            return;
        }

        if (!validatePassword() || !validateConfirmPassword() || !agreePrivacy.checked || !validateNameMatchesEmail()) {
            e.preventDefault();
            if (!agreePrivacy.checked) showModal("You must agree to the Data Privacy Policy.");
            return;
        }
    });

    // ---------- PRIVACY MODAL ----------
    privacyLink.addEventListener('click', e => {
        e.preventDefault();
        privacyModal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => privacyModal.style.display = 'none');
});

</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.getElementById('menu-btn');
  const navbar  = document.getElementById('navbar');

  if (!menuBtn || !navbar) return;

  menuBtn.addEventListener('click', (e) => {
    e.preventDefault();
    navbar.classList.toggle('active');
  });

  // Optional: close menu when tapping outside
  document.addEventListener('click', (e) => {
    if (!navbar.contains(e.target) && !menuBtn.contains(e.target)) {
      navbar.classList.remove('active');
    }
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form[id^="form-"]');

  function isVisible(el) {
    return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
  }

  function getNoticeText(field) {
    if (field.type === 'checkbox') return 'This field is required.';
    if (field.tagName === 'SELECT') return 'Please select an option.';
    return 'Please fill out this field.';
  }

  function getFieldLabel(field) {
    const id = field.id ? field.id.toLowerCase() : '';
    const name = field.name ? field.name.toLowerCase() : '';
    const placeholder = field.getAttribute('placeholder');
    const type = field.type ? field.type.toLowerCase() : '';

    if (type === 'checkbox' && (id.includes('agreeprivacy') || name.includes('agreeprivacy'))) {
      return 'Please agree to the Data Privacy Policy.';
    }

    if (name === 'idnumber' || id.includes('studentid')) return 'Student ID number is required.';
    if (name === 'facultyid' || id.includes('facultyid')) return 'Faculty ID is required.';
    if (name === 'course_year' || id === 'courseyearinput') return 'Please select both course and year.';
    if (name === 'email' || type === 'email') return 'Email address is required.';
    if (name.includes('password_confirmation')) return 'Confirm Password is required.';
    if (name === 'password') return 'Password is required.';

    if (placeholder) {
      return `${placeholder.replace(/\*/g, '').trim()} is required.`;
    }

    return 'Please complete all required fields.';
  }

  function showValidationModal(messages) {
    const unique = [...new Set(messages)];
    const text = `Please complete the following:\n\n- ${unique.join('\n- ')}`;

    if (typeof window.showModal === 'function') {
      window.showModal(text);
      return;
    }
    alert(text);
  }

  function removeNotice(field) {
    field.classList.remove('required-missing');
    field.removeAttribute('aria-invalid');

    const next = field.nextElementSibling;
    if (next && next.classList.contains('field-required-note')) {
      next.remove();
    }
  }

  function showNotice(field) {
    removeNotice(field);
    field.classList.add('required-missing');
    field.setAttribute('aria-invalid', 'true');

    const note = document.createElement('small');
    note.className = 'field-required-note';
    note.textContent = getNoticeText(field);
    field.insertAdjacentElement('afterend', note);
  }

  function validateRequired(form) {
    let firstInvalid = null;
    const missingMessages = [];

    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach((field) => {
      if (field.disabled) return;
      const isHidden = field.type === 'hidden' || !isVisible(field);

      const invalid = !field.checkValidity();
      if (invalid) {
        if (!isHidden) showNotice(field);
        missingMessages.push(getFieldLabel(field));
        if (!firstInvalid && !isHidden) firstInvalid = field;
      } else {
        if (!isHidden) removeNotice(field);
      }
    });

    // Privacy checkboxes are not marked as required in markup,
    // so enforce them explicitly per form.
    const privacyCheckboxes = form.querySelectorAll('input[type="checkbox"][id^="agreePrivacy"]');
    privacyCheckboxes.forEach((field) => {
      if (field.disabled) return;
      if (!isVisible(field)) return;
      if (field.checked) {
        removeNotice(field);
        return;
      }

      showNotice(field);
      missingMessages.push(getFieldLabel(field));
      if (!firstInvalid) firstInvalid = field;
    });

    return { firstInvalid, missingMessages };
  }

  forms.forEach((form) => {
    form.setAttribute('novalidate', 'novalidate');

    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach((field) => {
      field.addEventListener('input', () => {
        if (field.checkValidity()) removeNotice(field);
      });
      field.addEventListener('change', () => {
        if (field.checkValidity()) removeNotice(field);
      });
    });

    form.addEventListener('submit', (e) => {
      const { firstInvalid, missingMessages } = validateRequired(form);
      if (missingMessages.length) {
        e.preventDefault();
        if (firstInvalid) firstInvalid.focus();
        showValidationModal(missingMessages);
      }
    }, true);
  });
});
</script>
<style>
.required-missing {
  border: 1px solid #d93025 !important;
  box-shadow: 0 0 0 2px rgba(217, 48, 37, 0.15) !important;
}

.field-required-note {
  display: block;
  margin-top: 4px;
  color: #d93025;
  font-size: 0.78rem;
  line-height: 1.2;
}
</style>

</body>
</html>
