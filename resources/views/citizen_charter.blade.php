<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quirino State University | "Electronic Public Assistance And Complaint Desk"</title>
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('../assets/fontawesome/css/all.min.css') }}">
     <link rel="stylesheet" href="{{ asset('css/citizen_charter.css') }}">
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
        <div id="menu-btn" aria-label="Open menu" role="button" tabindex="0">&#9776;</div>
    </div>
</header>

<div class="blur-bg-overlay"></div>
<div class="form-popup">
    <span class="close-btn fa-solid fa-xmark"></span>
    <div class="form-box">
        <div class="form-details"></div>
        <div class="form-content">
            <h2>ADMINISTRATOR</h2>

            @if(session('message'))
                <p style="color:red;">{{ session('message') }}</p>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="input-field">
                    <input type="email" id="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit">Login</button>
            </form>
            
        </div>
    </div>
</div>

 <!-- CITIZEN'S CHARTER SECTION -->
<section class="home" id="home">
  <h1 class="heading" data-bg="CITIZEN'S CHARTER"><span>Citizen's</span> Charter</h1>

  <div class="search-container">
    <input
      type="text"
      id="search"
      placeholder="Search... (You can use enter to go thru the next)"
      oninput="scrollToWord()"
      spellcheck="off"
      autocomplete="off"
    />

    <!-- FRONT LINERS MAIN DROPDOWN -->
    <div class="dropdown">
      <button class="dropdown-btn" onclick="toggleDropdown('frontLinersDropdown')">
        <i class="fa-solid fa-users"></i> Front Liners
      </button>

        <div class="dropdown-content" id="frontLinersOffices">
          <a href="#" data-office="officeRegistrar">Office of the Registrar</a>
          <a href="#" data-office="officeCashier">Office of the Cashier</a>
          <a href="#" data-office="knowledgeCenter">Knowledge Center</a>
          <a href="#" data-office="officeStudentAffairs">Office of Student Affairs Services</a>
          <a href="#" data-office="officeGuidance">Office of the Guidance Counselor</a>
          <a href="#" data-office="medicalServices">Medical Services</a>
          <a href="#" data-office="recordsCommunication">Records and Communication Office</a>
          <a href="#" data-office="alumni">Alumni</a>
        </div>
    </div>

    <!-- NON-FRONT LINERS MAIN DROPDOWN -->
    <div class="dropdown">
      <button class="dropdown-btn" onclick="toggleDropdown('nonFrontLinersDropdown')">
        <i class="fa-solid fa-briefcase"></i> Non – Front Liners
      </button>

      <div class="dropdown-content" id="nonFrontLinersDropdown">
        <a href="#" data-office="officeVPFinance">Office of the Vice President for Administration & Finance</a>
        <a href="#" data-office="procurementOffice">Procurement Office</a>
        <a href="#" data-office="supplyOffice">Supply Office</a>
        <a href="#" data-office="hrOffice">Human Resource Management Office</a>
        <a href="#" data-office="plantOffice">Physical Plant and Site Development Office</a>
        <a href="#" data-office="auxiliaryOffice">Auxiliary and Enterprise Development Office</a>
        <a href="#" data-office="misWebContent">Management Information System – Web Content</a>
        <a href="#" data-office="financeServices">Finance Services</a>
        <a href="#" data-office="researchDevelopment">Research & Development</a>
        <a href="#" data-office="extensionTraining">Extension & Training Services</a>
      </div>
    </div>
  </div>
    

    <div class="container" id="officeRegistrar">
        <h2>Office of the Registrar</h2>
        <h2>Internal / External Services</h2>
        
        <div style="overflow-y: auto; max-height: 500px;">
            <div class="accordion">
                <div class="accordion-header"><p>1. Registration of Students Seeking Enrollment</p></div>
                <div class="accordion-content">
                    <p>Pre-Registration/Registration Forms are documents showing the personal information, academic information where approved list of subjects, number of units, time schedule, room assignment and instructor’s name taken are indicated and finally assessed and validated through the Student Information and Accounting System (SIAS).</p>
                    <table>
                        <tr>
                            <th>
                                <strong>Office or Division:</strong> 
                                <td>Office of the University Registrar (applies to all Campuses)</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Classification:</strong> 
                                <td>Simple</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Type of Transaction:</strong> 
                                <td>Government to Client</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Who may avail:</strong> 
                                <td>Students seeking enrolment</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                            <th></th>
                            <th>WHERE TO SECURE</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td><strong>1. Pre-Registration/ Registration Forms</strong></td>
                            <td></td>
                            <td>Student Registration and Records Services</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Client Steps</th>
                            <th>Agency Actions</th>
                            <th>Fees</th>
                            <th>Processing Time</th>
                            <th>Person Responsible</th>
                        </tr>
                        <tr>
                            <td>
                                <strong>A. PRE- REGISTRATION </strong><br>
                                New Students, Transferees, Second Coursers:<br>
                                1. Presents documentary requirements (Form 138, Certificate of Good Moral Character, PSA, Certificate of Transfer Credential, Certification of Grades, College Admission Test and Entrance Interview Results, duly signed acceptance form by the College, Course Validating/Crediting Form (if applicable))
                            </td>
                            <td>1. Checks/ verifies presented documents</td>
                            <td></td>
                            <td>1 min</td>
                            <td>
                                <i>Office of the
                                University
                                Registrar personnel</i>
                            </td>
                        </tr>
                        <tr>
                            <td>2. Secure Pre-Registration/Registration Forms</td>
                            <td></td>
                            <td></td>
                            <td>3 sec</td>
                            <td><i>Register personnel</i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td>1 min 3 sec</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Old/Continuing Students<br>
                                1. Presents duly accomplished clearance
                            </td>
                            <td>1. Checks presented clearance</td>
                            <td></td>
                            <td>30 sec</td>
                            <td><i>OUR personnel</i></td>
                        </tr>
                        <tr>
                            <td>2. Secure Request for Document form for issuance of evaluation of grades, shifting form and course validating/crediting form (if applicable)</td>
                            <td>2. Issues assessed Request for Document Form</td>
                            <td>30.00/type of document</td>
                            <td>1 min</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td>1 min 30 sec</td>
                            <td></td>
                        </tr>
                        <tr>
                        <td>
                            <strong>B. REGISTRATION</strong><br> 
                            New, Transferees, Second Coursers<br>
                            1. Submits approved Pre-Registration/Registration Forms including attachments.
                        </td>
                        <td>
                            1.1. Rechecks completeness of attached documents<br>
                            1.2. Encodes approved subjects<br>
                            1.3. Issues computer generated assessment
                        </td>
                        <td>-</td>
                        <td>
                            10 sec<br>
                            5 min<br>
                            5 sec
                        </td>
                        <td><i>OUR personnel</i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td>5 min 15 sec</td>
                            <td></td>
                        </tr>
                        <td>
                            Old/Continuing Students<br> 
                            1. Submits approved Pre-
                            Registration/Registration form including duly accomplished shifting form, course validating/crediting form (if applicable)
                        </td>
                        <td>
                            1.1. Verifies completeness of attached documents<br>
                            1.2. Encodes approved subjects<br>
                            1.3. Issues computer generated assessment
                        </td>
                        <td>-</td>
                        <td>
                            10 sec<br>
                            5 min<br>
                            5 sec
                        </td>
                        <td>OUR Personel</td>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td>5 min 15 sec</td>
                            <td></td>
                        </tr>
                        <td>
                            <strong>C. ISSUANCE OF CLASS CARDS</strong><br>
                        </td>
                        <td>1.Counts number of subjects enrolled and issues class card</td>
                        <td></td>
                        <td>30 sec</td>
                        <td><i>OUR personnel</i></td>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td>30 sec</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </br>
        <p><strong>Summary:</strong> This process outlines the complete steps and requirements for new students, transferees, second coursers, and continuing to register or pre-register, submit documents, get assessed through SIAS, and receive their class cards at the Office of the University Registrar.</p>        
    </div>
</div>
    <br>
        <div class="accordion">
            <div class="accordion-header">2. Issuance of Request for Document Form</div>
                <div class="accordion-content">
                    <p><strong>The Request for Document Form</strong> is a form used in securing/ applying any type of transaction or services provided by the Student Registration and Records Services Office.</p>
                    <table>
                        <tr>
                            <th>
                                <strong>Office or Division:</strong> 
                                <td>Office of the University Registrar (applies to all Campuses)</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Classification:</strong> 
                                <td>Simple</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Type of Transaction:</strong> 
                                <td>Government to Client</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Who may avail:</strong> 
                                <td>Students securing Academic document</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                            <th></th>
                            <th>WHERE TO SECURE</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>1. QSU-REG-F014-Request for Documents</td>
                            <td></td>
                            <td>Student Registration and Records Services</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>CLIENT STEPS</th>
                            <th>AGENCY ACTIONS</th>
                            <th>FEES TO PAID</th>
                            <th>PROCESSING TIME</th>
                            <th>PERSON RESPONSIBLE</th>
                        </tr>
                        <tr>
                            <td>1. Logs in</td>
                            <td>1.Interviews client on reasons for securing Request for Document form</td>
                            <td></td>
                            <td>15 sec</td>
                            <td><i>OUR PERSONNEL</i></td>
                        </tr>
                        <tr>
                            <td>2. Secures and accomplishes Request for Document form and pay the assessed fee to the Cashier</td>
                            <td>2.Issues assessed Request for Document Form</td>
                            <td></td>
                            <td>5 sec</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3. Presents official receipt</td>
                            <td>3. Checks OR submitted and issue form</td>
                            <td></td>
                            <td>5 sec</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4. Presents duly accomplished form for document processing</td>
                            <td>4. Receives duly accomplished form and acts on service procedure requested</td>
                            <td></td>
                            <td>15 sec</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5. Waits for the issuance of the student copy of processed document</td>
                            <td>5. Provides client’s copy of the processed document</td>
                            <td></td>
                            <td>2 sec</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td><strong>42 sec</strong></td>
                            <td></td>
                        </tr>
                </table>
            </br>
                <p><strong>Summary:</strong>This process explains how students can obtain a Request for Document Form, complete the required steps, pay the necessary fees, and receive their processed academic document from the Office of the University Registrar.</p>
            </div>
        </div>
            <br>
                <div class="accordion">
                    <div class="accordion-header">3. Issuance of Change of Matriculation (Changing, Adding and Dropping of Subjects)</div>
                        <div class="accordion-content">
                            <p><strong>Change of Matriculation Form </strong> is a form accomplished by clients who are applying for a change, add or drop a subject/s.</p>
                            <table>
                            <tr>
                                <th>
                                    <strong>Office or Division:</strong> 
                                    <td>Office of the University Registrar (applies to all Campuses)</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <th>
                                        <strong>Classification:</strong> 
                                        <td>Simple</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <th>
                                        <strong>Type of Transaction:</strong> 
                                        <td>Government to Client</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <th>
                                        <strong>Who may avail:</strong> 
                                        <td>Students securing change of matriculation (changing, adding and dropping of subjects)</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-REG-F004-Change of Matriculation Forms</td>
                                    <td></td>
                                    <td>Student Registration and Records Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Logs in</td>
                                    <td>1.Interviews client on reasons for Change of Matriculation</td>
                                    <td></td>
                                    <td>1 min 2 sec</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2.Surrenders recent validated Assessment and secures and accomplishes Request for Document form for Change of Matriculation</td>
                                    <td></td>
                                    <td>5 sec</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Presents duly approved Change of Matriculation form & surrenders class cards in case of changing/dropping subjects</td>
                                    <td>3.Verifies approved Change of Matriculation form</td>
                                    <td>P 20.00</td>
                                    <td>10 sec</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Waits for the issuance of rectified assessment including copy of Change Matriculation form and additional classcard (in case of adding subjects)</td>
                                    <td>4. Re-issues Assessment Form including student’s copy of the Change Matriculation Form</td>
                                    <td></td>
                                    <td>5 min</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>6 min 17 sec</td>
                                    <td></td>
                                </tr>
                            </table>
                            </br>
                                <p><strong>Summary:</strong>This process guides students through requesting and completing a Change of Matriculation whether changing, adding, or dropping subjects by submitting required forms, paying applicable fees, and receiving an updated assessment from the Office of the University Registrar.</p>
                            </div>
                        </div>
                    <br>
                    <div class="accordion">
                        <div class="accordion-header">4. Issuance of Form for Withdrawal of Registration</div>
                            <div class="accordion-content">
                                <p><strong>Withdrawal of Registration  </strong> is a form used by the client who withdraws his/her registration from the University within the prescribed period of withdrawal.</p>
                                    <table>
                                    <tr>
                                        <th>
                                            <strong>Office or Division:</strong> 
                                            <td>Office of the University Registrar (applies to all Campuses)</td>
                                            </th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                            <tr>
                                            <th>
                                                <strong>Classification:</strong> 
                                                <td>Simple</td>
                                            </th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                            <tr>
                                            <th>
                                                <strong>Type of Transaction:</strong> 
                                                <td>Government to Client</td>
                                            </th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                            <tr>
                                            <th>
                                                <strong>Who may avail:</strong> 
                                                <td>Students requesting for withdrawal from registration</td>
                                            </th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                            <th></th>
                                            <th>WHERE TO SECURE</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>1. QSU-REG-F006-Form for Withdrawal of Registration</td>
                                            <td></td>
                                            <td>Student Registration and Records Services</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>CLIENT STEPS</th>
                                            <th>AGENCY ACTIONS</th>
                                            <th>FEES TO PAID</th>
                                            <th>PROCESSING TIME</th>
                                            <th>PERSON RESPONSIBLE</th>
                                        </tr>
                                        <tr>
                                            <td>1. Logs in</td>
                                            <td>1. Interviews client on reasons for withdrawal from registration</td>
                                            <td></td>
                                            <td>1 min 2 sec</td>
                                            <td><i>OUR personnel</i></td>
                                        </tr>
                                        <tr>
                                            <td>2.Secures and accomplishes Request for Document form for Withdrawal from Registration</td>
                                            <td>2. Checks official receipt and issues form for Withdrawal of Registration for the student to accomplish</td>
                                            <td>P 20.00</td>
                                            <td>5 sec</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>3.Presents duly approved Withdrawal of Registration form and surrenders recent Assessment form and class cards received</td>
                                            <td>3.Verifies signatures of concerned officials in the Withdrawal form</td>
                                            <td></td>
                                            <td>10 sec</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>4. Receives student copy of Withdrawal form including Admission requirement in case of Freshmen and Transferees</td>
                                            <td>4. Cancels/drops subjects enrolled by the students in the Student Information and Accounting System (SIAS)</td>
                                            <td></td>
                                            <td>5 min</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><strong>TOTAL:</strong></td>
                                            <td></td>
                                            <td>6 min 17 sec</td>
                                            <td></td>
                                        </tr>
                                </table>
                            </br>
                            <p><strong>Summary:</strong>This process outlines how students can formally withdraw their registration by securing the required form, submitting validated documents, paying the necessary fee, and having their enrolled subjects cancelled in the SIAS system.</p>
                            </div>
                        </div>
                    <br>
                    <div class="accordion">
                        <div class="accordion-header">5. Issuance of Shifting Form</div>
                            <div class="accordion-content">
                                <p><strong>Shifting form </strong> is a form used by a student who wishes to shift/ transfer from one program to another.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking for shifting of program</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F005-Shifitng Application Form</td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews client</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Secures and accomplishes Request for Document form for Shifting form</td>
                                        <td>2.Verifies official receipt and issues Shifting Form for the student to accomplish</td>
                                        <td>P 20.00</td>
                                        <td>2 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Presents duly approved Shifting form in 2 copies and surrenders current Assessment form and classcards received</td>
                                        <td>3.Checks and verifies if the student has undergone academic counseling and if shifting is consented by parent/guardian and approved by the concerned officials</td>
                                        <td></td>
                                        <td>4 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4. Waits for the issuance of rectified assessment including copy of Shifting form</td>
                                        <td>4. Re-issues Assessment form and student’s copy of the Shifting form</td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>10 min 2 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>This process outlines how students can request and complete a Shifting Form to transfer from one academic program to another, including submitting required documents, paying the fee, undergoing verification, and receiving an updated assessment and official shifting records.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">6. Issuance and Retrieval of Course Validating/Crediting Form</div>
                            <div class="accordion-content">
                                <p><strong>Course Validating/Crediting form </strong> is used by a student shifter or a transferee. It contains the subjects taken previously from another program/schools which may be credited to the course description offered by a certain program currently enrolled in the university. </p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students securing course validating/crediting form</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F008-Course Validating/Crediting Form</td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews client</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Secures and accomplishes Request for Document form for Course Validating/Crediting Form</td>
                                        <td>2. Issues Course Validating/Crediting Form for the student to accomplish</td>
                                        <td>P 30.00</td>
                                        <td>2 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3.Submit duly approved Course Validating/Crediting form in 4 copies</td>
                                        <td>3.Receives and verifies if the student has undergone academic evaluation and must be approved by the concerned officials</td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4. Waits for the issuance of Course Validating/Crediting Form</td>
                                        <td>4. Records and issues student’s copy of the Course Validating/Crediting Form</td>
                                        <td></td>
                                        <td>2 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>8 min 2 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                            <p><strong>Summary:</strong>This process explains how students can request and complete the Course Validating/Crediting Form to have previously taken subjects evaluated and credited, including securing the required form, paying the fee, submitting approved copies, undergoing verification, and receiving the issued validated/credited course record.</p>
                        </div>
                    </div>
                <br>
                <div class="accordion">
                    <div class="accordion-header">7. Issuance and Retrieval of Permit to Cross Enroll Application Form (For Outbound Cross-Enrollees)</div>
                        <div class="accordion-content">
                            <p><strong>Permit to Cross Enroll Application Form (For Outbound Cross-Enrollee) </strong> is granted for bonafide students who wish to cross-enroll in other state-owned or government recognized private educational institutions for a subject needed for graduation provided that the subject is not offered during that semester or is offered during the term but cannot be enrolled due to conflict in schedule and which cannot be resolved.</p>
                            <table>
                            <tr>
                                <th>
                                    <strong>Office or Division:</strong> 
                                    <td>Office of the University Registrar (applies to all Campuses)</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <th>
                                        <strong>Classification:</strong> 
                                        <td>Simple</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <th>
                                        <strong>Type of Transaction:</strong> 
                                        <td>Government to Client</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <th>
                                        <strong>Who may avail:</strong> 
                                        <td>Students seeking permit to Cross Enroll</td>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-REG-F013-B-Permit to Cross Enroll Application Form (For Outbound Cross Enrollees)<td>
                                    <td></td>
                                    <td>Student Registration and Records Services</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Logs in</td>
                                    <td>1. Interviews client</td>
                                    <td></td>
                                    <td>1 min</td>
                                    <td><i>OUR personnel</i></td>
                                </tr>
                                <tr>
                                    <td>2. Secures and accomplishes Request for Document form permit to cross enroll</td>
                                    <td>2. Issues Permit to Cross Enroll Application Form for the student to accomplish</td>
                                    <td>P 30.00</td>
                                    <td>2 sec</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3.Submits duly approved request for cross enrolment form</td>
                                    <td>3.Receives and verifies if the student has undergone academic evaluation and must be approved by the concerned officials</td>
                                    <td></td>
                                    <td>5 min</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Waits for the issuance of permit to cross enroll.</td>
                                    <td>4.Records and issues student’s copy of permit to cross enroll.</td>
                                    <td></td>
                                    <td>2 min</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>8 min 2 sec</td>
                                    <td></td>
                                </tr>
                        </table>
                    </br>
                        <p><strong>Summary:</strong>This process describes how students can request and obtain a Permit to Cross Enroll, which allows them to take subjects at another accredited institution when the needed course is unavailable or conflicts with their schedule. It includes securing the required form, paying the fee, submitting approved documents, undergoing academic verification, and receiving the issued cross-enrollment permit.</p>
                    </div>
                </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">8. Issuance and Retrieval of Application for Cross Enrollment (Inbound Cross-Enrollee)</div>
                            <div class="accordion-content">
                                <p><strong>Application for Cross Enrollment (For Inbound Cross-Enrollee)</strong> is allowed for students from other institutions who wish to cross-enroll at the university provided they have presented complete documents required for cross enrollment, understood and agreed that said cross enrollee binds himself to the same academic discipline and administrative policies and procedures governing students’ of QSU.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students securing Application for Cross Enrollment</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F013-A- Application For Cross-Enrollment (For Inbound Cross-Enrollees)<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews client</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Presents required documents (Letter of Recommendation from Dean of Home school and Cross Enrollment permit)</td>
                                        <td>2. Check and prepares Permit to Cross enroll (Inbound Application Form)</td>
                                        <td>P 30.00</td>
                                        <td>2 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Waits and receives Permit to Cross Enroll (Inbound Application Form)</td>
                                        <td>3. Issues Permit to Cross enroll application form</td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4. Submits duly approved Cross Enrollment Application form for filing and recording purposes</td>
                                        <td>4. Records and issues student’s copy of permit to cross enroll.</td>
                                        <td></td>
                                        <td>2 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>8 min 2 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>This process outlines how students from other institutions can apply to cross-enroll at the university by submitting the required documents, paying the fee, completing academic verification, and receiving the official inbound cross-enrollment permit, ensuring they adhere to the university’s academic and administrative policies.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">9. Issuance of Grade Completion Form</div>
                            <div class="accordion-content">
                                <p><strong>Grade Completion Form</strong> is a form used by students who incurred a grade of incomplete or an in-progress grade. This should be accomplished in triplicates and be submitted to the Registrar’s Office two (2) days from date of completion.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students securing grade completion form</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F017- Grade Completion Form<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews client</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Secures Request for Document form for Grade Completion Form</td>
                                        <td>2. Issues Grade Completion Form for the student to accomplish</td>
                                        <td>P 20.00</td>
                                        <td>5 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3.Presents official receipt and wait for the issuance of Grade Completion form</td>
                                        <td>3. Checks official receipt and issues number of grade completion form base from amount of receipts submitted</td>
                                        <td></td>
                                        <td>15 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Submits duly approved Cross Enrollment Application form for filing and recording purposes</td>
                                        <td>4.Checks official receipt and issues number of grade completion form base from amount of receipts submitted</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5. Submits duly signed grade completion form for posting</td>
                                        <td>4. Receives, post and issues student’s copy of duly approved grade completion form</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>2 min 20 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                            <p><strong>Summary:</strong>This process explains how students with an incomplete or in-progress grade can request and obtain a Grade Completion Form, including securing the required document, paying the fee, presenting the receipt, submitting the completed form for posting, and receiving the officially approved grade completion record.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">10.Issuance of Certification of Grades Certification of Grades Form is a document issued to students securing for a certification of grades for academic record or legal purposes.</div>
                            <div class="accordion-content">
                                <p><strong>Grade Completion Form</strong> is a form used by students who incurred a grade of incomplete or an in-progress grade. This should be accomplished in triplicates and be submitted to the Registrar’s Office two (2) days from date of completion.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking for certification of grades</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F022-B-Certification of Grade Form<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients and verifies grades posted</td>
                                        <td></td>
                                        <td>20 sec</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Presents clearance and accomplish Request for Document form and pay the assessed fee to the Cashier</td>
                                        <td>2. Verifies clearance and issues Request for Document Form</td>
                                        <td>P 30.00</td>
                                        <td>15 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Submit official receipt for currently enrolled students and clearance form and receipt of payment for inactive students</td>
                                        <td>3. Checks clearance form and official receipt submitted</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Wait for the issuance of the student certification of grade</td>
                                        <td>4.Encodes/prints/signs certification of grade</td>
                                        <td></td>
                                        <td>3 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5. Receives Certification of Grade</td>
                                        <td>5. Signs and issues certification of grades</td>
                                        <td></td>
                                        <td>10 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>4 min 45 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                            <p><strong>Summary:</strong>This process outlines how students can secure a Certification of Grades for academic or legal purposes, including verifying posted grades, presenting clearance, paying the required fee, submitting official receipts, and receiving the printed and signed certification of grades from the Registrar’s Office.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">11.Issuance of Certification of Enrolment, Graduation, Total Earned Units</div>
                            <div class="accordion-content">
                                <p>These certifications are issued to students securing certification that are officially enrolled during a particular term/s, determining total earned units and a certification of graduation for those who have completed a particular degree.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking for certifications</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F022-A-Certification of Enrolment<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2. QSU-REG-F022-D-Certification of Graduation</td>
                                        <td></td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>30 sec</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Secures clearance, accomplishes Request for Document form and pay the assessed fee to the Cashier</td>
                                        <td>2. Verifies clearance and official receipt submitted</td>
                                        <td>P 30.00</td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Submit clearance, official receipt and authorization of representative/proxy (if applicable)</td>
                                        <td>3. Checks clearance form, official receipt and authorization of representative/proxy</td>
                                        <td></td>
                                        <td>15 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Waits for the issuance of the student certification</td>
                                        <td>4. Encodes/prints type of certification requested</td>
                                        <td></td>
                                        <td>3 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5. Receives Certification</td>
                                        <td>5. Signs and issues certification</td>
                                        <td></td>
                                        <td>5 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>4 min 50 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                            <p><strong>Summary:</strong>The Office of the University Registrar provides certifications for officially enrolled students, graduates, and total earned units. This service is classified as Simple and is available to all students who need official school certifications.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">12. Issuance of Change of Information</div>
                            <div class="accordion-content">
                                <p><strong>Change of Information Form </strong>is accomplished by a student who applies and updates his personal information after satisfying requirements prescribed by the Student Registration and Records Services Office.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students securing change of information</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F015-Request for Change of Information<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2.Accomplishes Request for Document form for Change of Information, pay the assessed fee to the Cashier and comply with the requirements required</td>
                                        <td>2. Verifies official receipt, issues form and gives instructions on required documents</td>
                                        <td>P 60.00</td>
                                        <td>15 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Submits duly accomplished Change of Information including required documents</td>
                                        <td>3. Rectifies requested change of student information in the Student Information and Accounting System(SIAS)</td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Receives copy of duly accomplished Change of Information</td>
                                        <td>4. Signs and issues student copy of duly accomplished Change of Information form</td>
                                        <td></td>
                                        <td>10 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>6 min 25 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>Students may request updates or corrections to their personal information by submitting a Change of Information Form and fulfilling the requirements set by the Student Registration and Records Services.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">13. Issuance of Student Evaluation</div>
                            <div class="accordion-content">
                                <p><strong>Student Evaluation </strong>is issued to students who want to determine their academic standing or use for any legal purpose.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking academic record/evaluation of grade</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F024-Student Academic Record Evaluation Sheet<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2.Secure clearance for inactive students and accomplishes Request for Document form for the issuance of Evaluation Sheet and pay the assessed fee to the Cashier</td>
                                        <td>2. Receives duly accomplished clearance and Request for Document form for an Evaluation</td>
                                        <td>P 30.00</td>
                                        <td>5 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Submits completion form, duly accomplished clearance (for inactive students) and official receipt of payment</td>
                                        <td>3. Checks, verifies documents submitted, encodes completion of deficiencies as to grade posted and academic status of student and prepares for the Evaluation</td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Receives copy of evaluation form</td>
                                        <td>4. Signs, records and releases evaluation form</td>
                                        <td></td>
                                        <td>10 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>6 min 15 sec</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>This process covers how students can request a Student Evaluation, which provides an official review of their academic standing for personal reference or legal purposes.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">14. Issuance Certificate of Transfer Credentials</div>
                            <div class="accordion-content">
                                <p><strong>Certificate of Transfer Credential </strong>is granted to students who opted to change school provided they have to comply with all the requirements prescribed for transfer.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking certificate of transfer credentials</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F023-Certificate of Transfer Credentials<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td>OUR personnel</td>
                                    </tr>
                                    <tr>
                                        <td>2.Secure clearance and accomplishes Request for Document form for Certificate of Transfer Credential Form and complies with other requirements</td>
                                        <td>2.1. Receives duly accomplished clearance and Request for Document form for Certificate of Transfer Credential<br>
                                        2.2. Checks and prepares F137A/Official Transcript of Records which are part of the admission requirement<br>
                                        2.3. Notifies student as to his deficiencies or lacking requirements</td>
                                        <td></td>
                                        <td>10 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Submits duly accomplished clearance, official receipt of payment and other documents required</td>
                                        <td>3. Verifies document submitted</td>
                                        <td></td>
                                        <td>2 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Waits for the issuance of certificate of transfer credentials</td>
                                        <td>4. Prepares certificate of transfer credential accompanied by a certification of grades</td>
                                        <td>P 30.00</td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5. Receives duly accomplished certificate of transfer credentials (Honorable Dismissal)</td>
                                        <td>5. Signs, records and issues transfer credentials and certification of grades</td>
                                        <td></td>
                                        <td>2 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>20 min</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>This process outlines how students can request a Certificate of Transfer Credentials when transferring to another school, including complying with clearance requirements, submitting necessary documents, and receiving the officially issued transfer credentials with accompanying certification of grades.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">15. Issuance of Diploma/Certificate</div>
                            <div class="accordion-content">
                                <p><strong>Diploma/Certificate </strong>is an official certificate given to a student who has obtained a degree and graduated from a particular course of study.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students applying for diploma/certificate</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F026-Diploma Format<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2.Secure clearance, presents official receipt and school ID or other identification cards</td>
                                        <td>2. Receives duly accomplished clearance, official receipt and verifies submitted documents</td>
                                        <td>(prevailing fee)</td>
                                        <td>3 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Receives diploma/certificate</td>
                                        <td>3. Records and issues diploma/certificate</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                            <p><strong>Summary:</strong>This process outlines how graduates may request and receive their official Diploma or Certificate, which serves as formal proof of completing a degree or program after meeting all clearance and document requirements.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">16. Issuance	Official Transcript of Record (OTR)</div>
                            <div class="accordion-content">
                                <p><strong>Official Transcript of Record </strong>is an official certificate given to a student who has obtained a degree and graduated from a particular course of study.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking Official Transcript of Record</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F025-Official Transcript of Record<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>2 min</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2.Secure clearance, presents official receipt and school ID or other identification cards</td>
                                        <td>2. Receives duly accomplished clearance, official receipt and verifies submitted documents</td>
                                        <td>(prevailing fee)</td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Receives Official Transcript of Record</td>
                                        <td>3. Records and issues Officials Transcript of Record</td>
                                        <td></td>
                                        <td>15 working days</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td>15 days 7 min</td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>This process explains how students can request and receive their Official Transcript of Record (OTR), an authenticated document showing their complete academic history, issued after meeting all clearance and document requirements.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">17. Issuance	Certification, Authentication and Verification (CAV)</div>
                            <div class="accordion-content">
                                <p>This certification is issued to a client for submission to companies/agencies who want to ensure that an individual’s record and documents are indeed authentic and legal.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students securing Certification, Authentication and Verification (CAV)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. QSU-REG-F022-C-Certification, Authentication and Verification (CAV) of Student Record<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. 1. Interviews clients and verifies request</td>
                                        <td></td>
                                        <td>15 sec</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Secures and accomplishes Request for Document Form and pay assessed fee to the Cashier</td>
                                        <td>2. Receives and checks accomplished Request for Document Form</td>
                                        <td>P 80.00</td>
                                        <td>10 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. presents official receipt and original and photocopies of documents to be authenticated (acts on written/mailed request)</td>
                                        <td>3.1. Receives document presented and counterchecks payment made to that of requested no. of copies<br>
                                        3.2. Checks and verifies authenticity of document submitted</td>
                                        <td></td>
                                        <td>5 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4. Waits for release of applied document</td>
                                        <td>4. Prepares, authenticates and signs endorsement letter accompanied by the authenticated documents</td>
                                        <td></td>
                                        <td>15 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5. Receives requested document</td>
                                        <td>5. Records and releases requested documents</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td><strong>21 min 15 sec</strong></td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                            <p><strong>Summary:</strong>This process covers how students can request Certification, Authentication and Verification (CAV), a document required by institutions or agencies to validate the authenticity of a student's academic records.</p>
                        </div>
                    </div>
                <br>    
                    <div class="accordion">
                        <div class="accordion-header">18. Issuance	Certification for General Weighted Average (GWA)</div>
                            <div class="accordion-content">
                                <p><strong>Certification for General Weighted Average (GWA)</strong>is requested by a client to determine their academic standing/ rank for employment or any other purposes.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking certification for General Weighted Average(GWA)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. None<td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. 1. Interviews clients</td>
                                        <td></td>
                                        <td>15 sec</td>
                                        <td>OUR personnel</td>
                                    </tr>
                                    <tr>
                                        <td>2. Secures and accomplishes Request for Document form for Certification of General Weighted Average (GWA) and pay the assessed fee to the Cashier</td>
                                        <td>2. Checks official receipt and Request for Document form submitted</td>
                                        <td></td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Submit official receipt and duly accomplish form for certification of General Weighted Average (GWA)</td>
                                        <td>3. Checks and receives official receipt and form for Certification</td>
                                        <td>P 30.00</td>
                                        <td>15 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.	Waits for the issuance of the certification requested</td>
                                        <td>4. Encodes/prints certification of General Weighted Average</td>
                                        <td></td>
                                        <td>4 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5. Receives Certification</td>
                                        <td>5. Signs and issue certification</td>
                                        <td></td>
                                        <td>5 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td><strong>5 min 35 sec</strong></td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>This process allows students to request a Certification for General Weighted Average (GWA) to determine their academic standing or rank, often needed for employment or other purposes.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">19. Issuance of Certification for Records Check confirming scholastic records of Students</div>
                            <div class="accordion-content">
                                <p>This certification is issued to requesting companies/agencies for records check/verification purposes confirming the scholastic records of a student/client.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking for Records Check verification</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. None<td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th>PERSON RESPONSIBLE</th>
                                    </tr>
                                    <tr>
                                        <td>1. Logs in</td>
                                        <td>1. Interviews clients</td>
                                        <td></td>
                                        <td>10 sec</td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td>2. Presents and submits endorsement letter</td>
                                        <td>2. Verifies submitted endorsement letter</td>
                                        <td>none</td>
                                        <td>1 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Waits for the issuance of the certification</td>
                                        <td>3. Encodes/prints certification</td>
                                        <td></td>
                                        <td>4 min</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4.Receives Certification</td>
                                        <td>4. Signs and issue certification</td>
                                        <td></td>
                                        <td>5 sec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td><strong>5 min 15 sec</strong></td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>Students can request a no-fee certification from the Office of the University Registrar to verify their scholastic records for companies or agencies, which is processed in about 5 minutes.</p>
                        </div>
                    </div>
                <br>
                    <div class="accordion">
                        <div class="accordion-header">20. Submission of Notarized List of Graduates to Professional Regulation Commission (PRC)</div>
                            <div class="accordion-content">
                                <p>This document is complied and submitted by the Office of Student Registration and Records Services on or before the scheduled deadline.</p>
                                <table>
                                <tr>
                                    <th>
                                        <strong>Office or Division:</strong> 
                                        <td>Office of the University Registrar (applies to all Campuses)</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Classification:</strong> 
                                            <td>Simple</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Type of Transaction:</strong> 
                                            <td>Government to Client</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                        <th>
                                            <strong>Who may avail:</strong> 
                                            <td>Students seeking for Records Check verification</td>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                        <th></th>
                                        <th>WHERE TO SECURE</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1. Notarized List of Graduates<td>
                                        <td></td>
                                        <td>Student Registration and Records Services</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>CLIENT STEPS</th>
                                        <th>AGENCY ACTIONS</th>
                                        <th>FEES TO PAID</th>
                                        <th>PROCESSING TIME</th>
                                        <th><i>PERSON RESPONSIBLE</i></th>
                                    </tr>
                                    <tr>
                                        <td>1. Issues Professional Regulation Commission Resolution No. 2019-1181</td>
                                        <td>1.1. Prepares hard copies of the List of Graduates using excel file format <br>
                                        1.2. Prints at least five (5) copies for signature of authorized school officials to be certified and Notarized by a Notary Public<br>
                                        1.3. Prepares digitized copies in addition to the hard or physical copies for submission to the PRC within 15 days from date of Commencement Exercises<br>
                                        1.4. E-mailed Certified and Notarized List of Graduates to PRC.<br>
                                        1.5. Submits physical and digitized copies of the Certified and notarized list of graduates.</td>
                                        <td>none</td>
                                        <td>7 days <br>  <br> <br> <br> 5 min </td>
                                        <td><i>OUR personnel</i></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL:</strong></td>
                                        <td></td>
                                        <td><strong>7 days 5 min</strong></td>
                                        <td></td>
                                    </tr>
                            </table>
                        </br>
                        <p><strong>Summary:</strong>The Office of the University Registrar prepares, notarizes, and submits both hard and digital copies of the List of Graduates to the Professional Regulation Commission within 7 days after commencement exercises, at no cost to students.</p>
                    </div>
                </div>
            </div>
        </div>



    <div class="container" id="officeCashier">
        <h2>Office of the Cashier</h2>
        <h2>Internal Services</h2>
        
        <div style="overflow-y: auto; max-height: 500px;">
       <div class="accordion">
                    <div class="accordion-header">1. Collection of Student Fees during Enrollment</div>
                    <div class="accordion-content">
                    <table>
                        <tr>
                            <th>
                                <strong>Office or Division:</strong> 
                                <td>Cashier Office</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Classification:</strong> 
                                <td>Simple</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Type of Transaction:</strong> 
                                <td>G2C – Government to Clients</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Who may avail:</strong> 
                                <td>Students</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                            <th></th>
                            <th>WHERE TO SECURE</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>1. Assessment Form</td>
                            <td></td>
                            <td>Registrar Office</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Client Steps</th>
                            <th>Agency Actions</th>
                            <th>Fees</th>
                            <th>Processing Time</th>
                            <th>Person Responsible</th>
                        </tr>
                        <tr>
                            <td>1. Presents accomplished Assessment Form</td>
                            <td>1. Receives assessment form and verifies student account records</td>
                            <td>Indicated on the assessment / enrollment form.</td>
                            <td>3 minutes</td>
                            <td><i>Josefina G. Luis Administrative Aide IV</i></td>
                        </tr>
                        <tr>
                            <td>2. Pays student fees</td>
                            <td>1. Receives assessment form and verifies student account records</td>
                            <td></td>
                            <td>2 minutes</td>
                            <td><i>Josefina G. Luis Administrative Aide IV</i></td>
                        </tr>
                        <tr>
                            <td>3. Receives OR </td>
                            <td> 
                                3. Updates <br><br>
                                student account records
                            </td>
                            <td></td>
                            <td>2 minutes</td>
                            <td><i>Josefina G. Luis Administrative Aide IV</i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td></td>
                            <td>7 minutes</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
        <tr>
            <div class="accordion">
                <div class="accordion-header">2. Issuance of Examination Permit</div>
                <div class="accordion-content">
                    <p>The test permit is required before students are allowed to take the examination.</p>
                    <table>
                        <tr>
                            <th>
                                <strong>Office or Division:</strong> 
                                <td>Cashier Office</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Classification:</strong> 
                                <td>Simple</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Type of Transaction:</strong> 
                                <td>G2C – Government to Clients</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr>
                            <th>
                                <strong>Who may avail:</strong> 
                                <td>Students</td>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                            <th></th>
                            <th>WHERE TO SECURE</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>1. Official Receipt</td>
                            <td></td>
                            <td>Cashier Office</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Client Steps</th>
                            <th>Agency Actions</th>
                            <th>Fees</th>
                            <th>Processing Time</th>
                            <th>Person Responsible</th>
                        </tr>
                        <tr>
                            <td>1. Fall in line & present Official Receipt</td>
                            <td>1. Receives Official Receipt</td>
                            <td>None</td>
                            <td>1 minutes</td>
                            <td><i>Josefina G. Luis Administrative Aide IV</i></td>
                        </tr>
                        <tr>
                            <td>2. Wait for the issuance of test permit</td>
                            <td>2. Verifies records</td>
                            <td>None</td>
                            <td>2 minutes</td>
                            <td><i>Josefina G. Luis Administrative Aide IV</i></td>
                        </tr>
                        <tr>
                            <td>3. Receives test permit</td>
                            <td>3. Issues test permit</td>
                            <td>None</td>
                            <td>1 minutes</td>
                            <td><i>Josefina G. Luis Administrative Aide IV</i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL:</strong></td>
                            <td>None</td>
                            <td>4 minutes</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>

            

        <div class="container" id="knowledgeCenter">
            <h2>Knowledge Center</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Library Registration for Students (During Enrolment)</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Students</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Pre-Registration Form</td>
                                    <td></td>
                                    <td>Registrar's Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Assessment Form</td>
                                    <td></td>
                                    <td>Registrar's Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Library Registration Form</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present Pre-Registration Form & Assessment Form</td>
                                    <td>1. Check and verify the forms presented</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Fill-out library registration form (Basic Information)</td>
                                    <td>2. Give the Student a library registration form</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>3. Take a photo</td>
                                    <td>3.	Register the filled-out library registration form and Input the photo of the Student for identification at the Library Utilization Monitoring System (LUMS)</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>4.	Wait for the account to be registered</td>
                                    <td>4.	Duly sign the Pre-Registration Form</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>5.	Receive the Pre-Registration Form & Assessment Form</td>
                                    <td>5.	Release the Pre-Registration Form & Assessment Form</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>6. Validate the account (Log-in as a student at the LUMS Attendance)</td>
                                    <td>6. Assist the Student during validation</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>8 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Library Registration for Faculty & Staff, and Admin Personnel</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty & Staff, and Admin Personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Library Registration Form</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Borrower’s ID</td>
                                    <td>Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Fill-out library registration form (Basic Information)</td>
                                    <td>1. Give the Faculty/ Staff or Admin Personnel a library registration form</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Take a photo</td>
                                    <td>2. Register the filled-out library registration and Input the photo of the Faculty/ Staff or Admin Personnel at the Library Utilization Monitoring System (LUMS)</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>3. Validate the account (Log-in as a Faculty/ Staff or Admin Personnel at the LUMS Attendance)</td>
                                    <td>3. Assist the	Faculty/ Staff or Admin Personnel during validation</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Signing of Clearance</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty & Staff, and Admin Personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Valid ID</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Clearance Form</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Library Manual</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in at the Library Utilization Monitoring System (LUMS)</td>
                                    <td>1. Verify the identity of the client</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Present Clearance Form from the Registrar's Office</td>
                                    <td>2. 2.	Check any library obligations in the Library Utilization Monitoring System (LUMS)</br></br>
                                    2.1. See the Library Manual about the obligations/overdue fines for immediate action and settlement</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>3. Settle obligations/ pay overdue fines</td>
                                    <td>3. Record Payment</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>4. Receive duly signed Clearance Form</td>
                                    <td>4. Release duly signed Clearance Form</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>6 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Issuance of Borrower’s Card</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty & Staff, and Admin Personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Assessment Form</td>
                                    <td></td>
                                    <td>Registrar’s Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Valid ID</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Must have the Assessment Form signed and stamped "OFFICIALLY ENROLLED."</td>
                                    <td>1. Give a new Borrower’s Card to the Student</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Properly fill-out the Borrower’s Card (Name, Course & Year, ID Number, etc.); </br></br>
                                        Attach 1x1 ID Picture; </br> </br>
                                        Give to the Librarian/Library Staff</td>
                                    <td>2. Check and verify accuracy of information indicated in the Borrower’s Card</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>3. Receive Borrower’s Card</td>
                                    <td>3. Issue Borrower’s Card with validation</td>
                                    <td>The first issue is for free, if lost pay Php 5.00</td>
                                    <td>1 minute</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>Php 5.00</td>
                                    <td>4 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 5 -->
                    <div class="accordion">
                        <div class="accordion-header">5. Borrowing Books</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty & Staff, and Admin Personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Valid ID</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Borrower's Card</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Must have the Borrower’s Card 
                                        </br></br>
                                        Log-in at the Library Utilization Monitoring System (LUMS) for Attendance</td>
                                    <td>1. Check and verify ID and the Borrower’s Card (should be validated)</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>2. Get the desired books from the shelves</td>
                                    <td>2. Assist the client, if not familiar with the library system and book collections </br> </br> 
                                        (See Library Manual for the borrowing entitlements of Library Clients) </br> </br> 
                                        Receive books to be checked-out</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>3. Fill-out book cards (Issued to) and present it to the library staff at the Circulation desk.</td>
                                    <td>3. Stamp with due date and sign book card; </br> 
                                        Scan barcode of the book to be checked-out under the borrower's account in the Library Utilization Monitoring System (LUMS);
                                    </br></br>
                                        Print receipt of books borrowed</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>4. Wait for the books to be checked-out</td>
                                    <td>4. Issue books to the borrower with the receipt</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>5.	Receive books</td>
                                    <td>5.	File the Borrower’s Card of the client plus the book cards</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>8 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 6 -->
                    <div class="accordion">
                        <div class="accordion-header">6. Borrowing Books</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty & Staff, and Admin Personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Valid ID</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Temporary Library Card</td>
                                    <td></td>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in at the Library Utilization Monitoring System for Attendance</td>
                                    <td>1. Check and verify ID (should be validated)</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>2. Present books for return/check-in</td>
                                    <td>2. Receive borrowed books for return/check-in; </br></br>
                                        Stamp returned into the book cards; </br></br>
                                        Return the books at the Library Utilization Monitoring System (LUMS) under the borrower's account</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>3. Pay the corresponding amount</td>
                                    <td>3. Check if the borrowed books are overdue</td>
                                    <td>Php 1.00 per hour</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>4. Affix signature at the collection record</td>
                                    <td>4. Write down payments at the Collection record (See the Library Manual for Renewals and Overdue Fines)</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td>5.	Get the Borrower’s Card</td>
                                    <td>5.	Return the Borrower’s Card to the Student</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Circulation Officer/Librarian</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>Php 1.00 per hour (for Students)</td>
                                    <td>6 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="officeStudentAffairs">
            <h2>Office of the Student Affairs Services</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Scholarship Application</div>
                        <div class="accordion-content">
                            <p>CHED-Tulong Dunong Program</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Student Affairs and Services</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Qualified Students</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Certificate of Registration (3 Copies)</td>
                                    <td></td>
                                    <td>Registrar's Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Certification of Grades (3 copies)</td>
                                    <td></td>
                                    <td>Registrar's Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Photocopy of ID (3 Copies)</td>
                                    <td></td>
                                    <td>Student</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submit documentary requirements</td>
                                    <td>1. Evaluate documentary requirements</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>OSAS Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>3 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            


            <div class="container" id="officeGuidance">
            <h2>Office of the Guidance Counselor</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Evaluation of Admission Documentary Requirements</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Guidance, Counseling and Admissions Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Student-applicants</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Application for Admission Form</td>
                                    <td></td>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. <b>New Student:</b> Form 138, GMRC </br>
                                        <b>Transferee:</b> OTR, Honorable Dismissal, GMRC</td>
                                    <td></td>
                                    <td>Last school attended</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Authenticated Birth Certificate</td>
                                    <td></td>
                                    <td>Municipal Registrar or Philippine Statistics Authority</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. 2X2 Recent I.D picture (white background with name tag)</td>
                                    <td></td>
                                    <td>Photo Studio</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submit documentary requirements</td>
                                    <td>1. Evaluate documentary requirements</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Psychometrician</i></td>
                                </tr>
                                <tr>
                                    <td>2. Fill-up Application for Admission and Personal Data Sheet Forms</td>
                                    <td>2. Check filled-up forms and conduct entrance interview assign date and time of examination</td>
                                    <td>None</td>
                                    <td>10 minutes</td>
                                    <td><i>Guidance Counselor</i></td>
                                </tr>
                                <tr>
                                    <td>3. Log in on Applicant’s Log Sheet.</td>
                                    <td>3.	Issue Test Permit and Claim Stub Form</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>4.	Wait for the account to be registered</td>
                                    <td>4.	Duly sign the Pre-Registration Form</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Guidance Counselor</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>16 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Administration of Admission Test</div>
                        <div class="accordion-content">
                            <p>A service administered to all incoming students to obtain adequate and reliable data of their intellectual abilities, capacities, personality and aptitudes.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Guidance, Counseling and Admissions Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Student-enrollee</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Test Permit</td>
                                    <td></td>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present test permit</td>
                                    <td>1. Check and validate test permit</td>
                                    <td>None</td>
                                    <td>10 minutes</td>
                                    <td><i>Psychometrician</i></td>
                                </tr>
                                <tr>
                                    <td>2. Log in on the Examinee’s Control List</td>
                                    <td>2. Administer test</td>
                                    <td>None</td>
                                    <td>3.5 hours</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>3. Psychometrician</td>
                                    <td>3. Assist the	Faculty/ Staff or Admin Personnel during validation</td>
                                    <td>None</td>
                                    <td>1 minutes</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>3 hrs & 40 mins.</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Interpretation of Test, Issuance of Test Result and Career Counseling </div>
                        <div class="accordion-content">
                            <p>A process that presents direct feedback to examinees that helps them understand their psychological and behavioral characteristics with its implications to their career plans and choice -</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:	Guidance, Counseling and Admissions Office</strong></th>
                                    <td>QSU Knowledge Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Highly Technical</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Student-enrollee</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Present claim stub</td>
                                    <td>1. Interpret, print, discuss and release test result</td>
                                    <td>None</td>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present claim stub</td>
                                    <td>1. Interpret, print, discuss and release test result</td>
                                    <td>None</td>
                                    <td>20 days</td>
                                    <td><i>Psychometrician</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>20 days</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Issuance of Good Moral Character Certificate</div>
                        <div class="accordion-content">
                            <p>A documentary requirement issued to the graduates and students for scholarship, government examination, transfer, and employment purposes.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Student-enrolleel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Graduates</br>
                                        ▪ 1st Request: Request Form </br>
                                        ▪ Succeeding Request: Receipt</td>
                                    <td></td>
                                    <td>Office of the Registrar </br>
                                        Office of the Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Students: Receipt</td>
                                    <td></td>
                                    <td>Office of the Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present Request Form/ Receipt</td>
                                    <td>1. Validate Client’s Personal Information, and conduct Interview</td>
                                    <td>₱30.00</td>
                                    <td>15 minutes</td>
                                    <td><i>Guidance Support Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>₱30.00</td>
                                    <td>15 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 5 -->
                    <div class="accordion">
                        <div class="accordion-header">5. Issuance of Good Moral Character Certificate</div>
                        <div class="accordion-content">
                            <p>A documentary requirement issued to the graduates and students for scholarship, government examination, transfer, and employment purposes.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty & Staff, and Admin Personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. 3. Graduates </br>
                                        ▪ 1st Request: Request Form</br>
                                        ▪ Succeeding Request: Receipt</td>
                                    <td></td>
                                    <td>Office of the Registrar </br>
                                        Office of the Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Students: Receipt</td>
                                    <td></td>
                                    <td>Office of the Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present Request Form/ Receipt</td>
                                    <td>2. Validate Client’s Personal Information, and conduct Interview</td>
                                    <td>₱30.00</td>
                                    <td>16 minutes</td>
                                    <td><i>Guidance Counselor</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>₱30.00</td>
                                    <td>16 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 6 -->
                    <div class="accordion">
                        <div class="accordion-header">6. Counseling and Referral Feedback</div>
                        <div class="accordion-content">
                            <p>The evaluative information about student’s condition that is technically transmitted to a person or a specialist concerned.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division</strong></th>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Student, Specialist, Faculty</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Referral Slip</td>
                                    <td></td>
                                    <td>Guidance, Counseling and Admissions Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Call Slip</td>
                                    <td></td>
                                    <td>Guidance, Counseling and Admissions Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present Referral Slip</td>
                                    <td>1. Invite and schedule session with the student referred and Issue referral feedback</td>
                                    <td>None</td>
                                    <td>10 minutes</td>
                                    <td><i>Guidance Counselor</i></td>
                                </tr>
                                <tr>
                                    <td>2. Present Call Slip</td>
                                    <td>2. Conduct Interview and Seek student’s consent for counseling</td>
                                    <td>None</td>
                                    <td>20 minutes</td>
                                    <td><i>Guidance Counselor</i></td>
                                </tr>
                                <tr>
                                    <td>3. Present Counseling Contacts Schedule</td>
                                    <td>3. Conduct counseling</td>
                                    <td>None</td>
                                    <td>Maximum of 1hr per session</td>
                                    <td><i>Guidance Counselor</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>1.5 hour</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="medicalServices">
            <h2>Medical Services</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Mouth Examination</div>
                        <div class="accordion-content">
                            <p>Oral examination comprises a uniform and consistent inspection of the head and neck and an intraoral evaluation of the hard and soft tissues in conjunction with a thorough dental history. The entire mouth should be inspected regardless of the patient’s chief complaint during the admission.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students seeking Admission/Enrolment at QSU-DIFFUN</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F003</td>
                                    <td></td>
                                    <td>Office of The Dental Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>None</td>
                                    <td>15 seconds</td>
                                    <td><i>Edgar A. Ulep, RM</i></td>
                                </tr>
                                <tr>
                                    <td>2. Client fills-up the Dental Health Record form (QSU-MED-F003)</td>
                                    <td>2. Health personnel check the completeness of the filled-up form</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Edgar A. Ulep, RM</i></td>
                                </tr>
                                <tr>
                                    <td>3. Clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>3. Preparation of instruments needed</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Librarian/Library Staff</i></td>
                                </tr>
                                <tr>
                                    <td>4. Open mouth for oral examination</td>
                                    <td>4. Duly sign the Pre-Registration Form</td>
                                    <td>None</td>
                                    <td>5 minute</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                 <tr>
                                    <td>5. Gargle</td>
                                    <td>5. Discuss proper oral hygiene to the patient and give recommendation</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                 <tr>
                                    <td>6. Proceed to the receiving area sign in the patient’s logbook.</td>
                                    <td>6.1. Record all services in the patient’s card and in the logbook. </br></br>
                                        6.2. Sign enrolment form </br></br> 
                                        6.3. Keep patient’s card in the file cabinet</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mayjuleth S. Ramos, DMD. </br></br> </br>
                                        Edgar A. Ulep, RM.</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>12 minutes and 15 seconds</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Tooth Extraction</div>
                        <div class="accordion-content">
                            <p>A dental extraction (also referred to as tooth extraction, exodontia, exodontics, or informally, tooth pulling) is the removal of teeth from the dental alveolus (socket) in the alveolar bone. It is done through appointment of students in every semester.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students, Employees, Immediate Dependents</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F003</td>
                                    <td></td>
                                    <td>Office of The Dental Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. QSU-MED-F007</td>
                                    <td></td>
                                    <td>Office of The Dental Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1.1. Log-in to the general logbook</td>
                                    <td>1.1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>None</td>
                                    <td>15 seconds</td>
                                    <td><i>Edgar A. Ulep, RM.</i></td>
                                </tr>
                                <tr>
                                    <td>t</td>
                                    <td>1.2. Interview the patient for proper diagnosis and record all data gathered</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td>2.clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>2.1. Health personnel shall pull out the dental record of the patient </br> 
                                        2.2. Preparation of instruments needed</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Edgar A. Ulep, RM.</i></td>
                                </tr>
                                <tr>
                                    <td>4. Gargle</td>
                                    <td>4.1. Application of topical anesthesia </br> 
                                    4.2. Localized injection of anesthetic solution 4.3. Retraction of gingiva </br> 
                                    4.4. Elevation of the tooth 
                                    4.5. Removal of tooth 
                                    4.6. Put cotton ball on the extraction area 
                                    4.7. Give post-operative instruction to the patient.</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td>5. Bite cotton ball for 30 minutes to stop bleeding</td>
                                    <td>5.1. Prescribe medicine, dosage and instruction for proper intake. (QSUMED-F007)</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td>6. Proceed to the receiving area sign in the patient’s logbook.</td>
                                    <td>> Record all services in the patient’s card and in the logbook.</br>
                                        > Educate and instruct patient for further care and precaution </br> 
                                        > Keep patient’s card in the file cabinet</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Edgar A. Ulep, RM</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>20 minutes and 15 seconds</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Dental Prohylaxis</div>
                        <div class="accordion-content">
                            <p>It removes tartar and plaque build-up from the surfaces of the teeth as well as those hidden in between and under the gums. It is done through appointment of students in every semester.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:	</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students, Employees, Immediate Dependents</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F003</td>
                                    <td></td>
                                    <td></td>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. QSU-MED-F007</td>
                                    <td></td>
                                    <td></td>
                                    <td>Office of The Dental Services</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1.1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</br></br>
                                        1.2. Interview the patient for proper diagnosis and record all data gathered</td>
                                    <td>None</td>
                                    <td>15 seconds</br></br>
                                    1 minute</td>
                                    <td><i>Edgar A. Ulep, RM.</br></br>
                                    Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td>2. Clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>2.1. Health personnel shall pull out the dental record of the patient</br>
                                        2.2. Preparation of instruments needed</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Edgar A. Ulep, RM.</i></td>
                                </tr>
                                <tr>
                                    <td>3. Open mouth for oral examination</td>
                                    <td>3.1. Removal of soft and hard deposit</td>
                                    <td>None</td>
                                    <td>15 minutes</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td>4. Gargle</td>
                                    <td>4.1. Suction of the saliva </br>
                                        4.2. Mechanical tooth brushing/Polishing</td>
                                    <td>None</td>
                                    <td>15 minutes</td>
                                    <td><i>Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td>5. Proceed to the receiving area sign in the patient’s logbook.</td>
                                    <td>5.1. Record all services in the patient’s card and in the logbook.</br> 
                                        5.2. Prescribe Vitamin C if necessary</br>
                                        5.3. Educate and Instruct patient for further care and precaution</br> 
                                        5.4. Keep patient’s card in the file cabinet</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Edgar A. Ulep, RM.</br></br>
                                    Mayjuleth S. Ramos, DMD.</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>20 minutes and 15 seconds</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Restoration of Tooth</div>
                        <div class="accordion-content">
                            <p>Dental filling is a treatment to restore the function, integrity, and morphology of missing tooth structure resulting from caries or external trauma as well as to the replacement of such structure supported by dental implants. It is done through appointment of students in every semester.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Guidance, Counseling and Admissions</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Student-enrolleel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Graduates</br>
                                        ▪ 1st Request: Request Form </br>
                                        ▪ Succeeding Request: Receipt</td>
                                    <td></td>
                                    <td>Office of the Registrar </br>
                                        Office of the Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Students: Receipt</td>
                                    <td></td>
                                    <td>Office of the Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present Request Form/ Receipt</td>
                                    <td>1. Validate Client’s Personal Information, and conduct Interview</td>
                                    <td>₱30.00</td>
                                    <td>15 minutes</td>
                                    <td>Guidance Support Staff</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>₱30.00</td>
                                    <td>15 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 5 -->
                    <div class="accordion">
                        <div class="accordion-header">5. Health Inspection/Gross Physical Examination</div>
                        <div class="accordion-content">
                            <p>Perform comprehensive health assessment; apply nursing procedures and psychomotor skills to techniques of physical assessment during admission.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students seeking Admission/Enrolment at QSU-DIFFUN</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F004</td>
                                    <td></td>
                                    <td>Office of The Health Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1.1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>1 minute</td>
                                    <td>16 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>2. Client fills-up the Student Health Record form (QSU-MED-F004)</td>
                                    <td>2.1. Health personnel check the completeness of the filled-up form</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>3. Clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>3.1. Health personnel perform gross physical examination, vital signs taking and health interview; results will be relayed to the client.</br>
                                        3.2. Fill up the form for the corresponding results.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>4. Client will sign the vital signs record book with corresponding results.</td>
                                    <td>4.1. Health personnel sign the enrolment form of the client.</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>12 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 6 -->
                    <div class="accordion">
                        <div class="accordion-header">6. Issuance of Medical Certificates</div>
                        <div class="accordion-content">
                            <p>It is issued to students for a variety of reasons, including attestation of a student’s illness, fitness to join an activity, or of a student’s recovery from a medical condition.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F001</td>
                                    <td></td>
                                    <td>Office of The Health Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. QSU-MED-F004</td>
                                    <td></td>
                                    <td>Office of The Health Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1.1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>2.1. Client present validated student’s ID. </br></br>
                                        2.2. Coordinators of OJT students, Fieldtrips and Coaches shall submit a letter of request for physical examination with complete list of students.</td>
                                    <td>2.1. Health personnel shall pull out the medical record of the client. </br>
                                        2.2. Health personnel shall schedule the conduct of medical check-up through response letter to coaches and coordinators.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>3. Clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>3.1. Health personnel perform gross physical examination, vital signs taking and health interview; results will be relayed to the client.</br>
                                        3.2. Fill up the form for the corresponding results.</td>
                                    <td>None</td>
                                    <td>15 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>4. Client will sign the vital signs record book with corresponding results.</td>
                                    <td>4.1. Medical certificate shall be encoded by the health personnel and shall be signed by the physician of the partner hospital.</td>
                                    <td>None</td>
                                    <td>4 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>25 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 7 -->
                    <div class="accordion">
                        <div class="accordion-header">7. Medical Consultation and Treatment</div>
                        <div class="accordion-content">
                            <p>Common goals include taking preventive measures to halt the development of various diseases particularly for patients who have risk factors, obtain a diagnosis for symptoms being experienced by the patient, or to reassess the patient's risk of various medical conditions.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students, Employees, Visitors and Community</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F002</td>
                                    <td></td>
                                    <td>Office of The Health Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. QSU-MED-F004</td>
                                    <td></td>
                                    <td>Office of The Health Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. QSU-MED-F005</td>
                                    <td></td>
                                    <td>Office of The Health Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>2. Client present validated student/employee’s ID</td>
                                    <td>2.1. Accommodate the client</br>
                                        2.2. Health personnel shall pull out the medical record of the client</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>3. Clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>3.1. Health personnel perform gross physical examination and vital signs taking.</br> 
                                        3.2. Health personnel shall carry out medical consultation and dispense over the counter medicine for treatment.</br> 
                                        3.3. Refer clients with medical problem to partner hospitals for further management.</td>
                                    <td>None</td>
                                    <td>30 minutes</td>
                                    <td><i>Physician Nurse Nurse Aid</i></td>
                                </tr>
                                <tr>
                                    <td>4. Client will sign the vital signs record book and inventory of medicine.</td>
                                    <td>4.1. Carry out over the counter medicines</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Nurse/Nurse Aid</i>r</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>40 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="recordsCommunication">
            <h2>Records and Communication Office</h2>
            <h2>Internal / External Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Submission of all incoming documents</div>
                        <div class="accordion-content">
                            <p>Submission of internal and external incoming documents to the authority.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Records Management and Communication</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Faculty and Staff/Students</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. None</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submission of external communication</td>
                                    <td>1.1 Accept and stamp “Receive” </br>
                                        1.2 Enter in the record book.</br>
                                        1.3 Forward to the Office of the President</td>
                                    <td>None</td>
                                    <td>3-5 minutes</td>
                                    <td><i>Board Secretary/Records Officer/Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Submission of internal communication, vouchers and requests</td>
                                    <td>2.1 Accept and stamp “Receive” </br>
                                        2.2 Enter in the record book. </br>
                                        2.3 Forward to the Office of the President</td>
                                    <td>None</td>
                                    <td>3-5 minutes</td>
                                    <td><i>Board Secretary/Records Officer/Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>10 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Receiving of all outgoing documents</div>
                        <div class="accordion-content">
                            <p>Receiving of internal and external outgoing documents from the authority.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Records Management and Communication</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2G, G2C, G2B</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Clients/Faculty and Staff/Students</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. None</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Receiving of internal communication/requ ests/vouchers.</td>
                                    <td>1.1 Released and have it received by the receiving party.</td>
                                    <td>None</td>
                                    <td>2-3 minutes</td>
                                    <td><i>Board Secretary/Records Officer/Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receiving of outgoing communications</td>
                                    <td>2.1.Sent through couriers </br>
                                        2.2.Sent through electronic mail</td>
                                    <td>Minimum of php100 to php200</br></br>
                                        None</td>
                                    <td>5-10 minutes </br></br>
                                        2 minutes</td>
                                    <td><i>Board Secretary/Records Officer/Staff /Liaison Officer</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>15 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Request for a copy of internal and/or external documents</div>
                        <div class="accordion-content">
                            <p>Request for a copy of internal and/or external documents from the authority.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Records Management and Communication</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2G, G2C, G2B</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Clients/Faculty and Staff/Students</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Document Requisition Slip (DRS)</td>
                                    <td></td>
                                    <td>Records Management Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Accomplish a Document Requisition Slip</td>
                                    <td>Retrieved /reproduce and have it received by the concerned/reque sting employee/client.</td>
                                    <td>None</td>
                                    <td>2-3 minutes</td>
                                    <td><i>Board Secretary/Records Officer/Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receiving of outgoing communications</td>
                                    <td>2.1.Sent through couriers </br>
                                        2.2.Sent through electronic mail</td>
                                    <td>10.00</td>
                                    <td>5 minutes</td>
                                    <td><i>Board Secretary/Records Officer/Staff /Liaison Officer</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>10.00</td>
                                    <td>5 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="alumni">
            <h2>Alumni Office</h2>
            <h2>Internal / External Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Clearance Signing</div>
                        <div class="accordion-content">
                            <p>Signing of graduate clearance</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Alumni Affairs</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All Graduates of QSU-Diffun (or their authorized representatives*)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Clearance Slip</td>
                                    <td></td>
                                    <td>Cashier’s Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Yearbook (if already available)/Master list of Graduates/Graduation Invitation/Program</td>
                                    <td></td>
                                    <td>Dean/Program Chair’s Office/Alumni Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Singing of the QSU Hymn</td>
                                    <td></td>
                                    <td>Copy of Graduation Invitation/Program</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Authorization letter and Identification Cards both of the Alumnus/Alumna and his/her authorized representative (only if applicable)</td>
                                    <td></td>
                                    <td>Alumnus/Alumna</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Secure clearance slip</td>
                                    <td>Generate clearance slip</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Cashier’s Office staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Present clearance slip</td>
                                    <td>Check for signature of Cashier, Program Chairman/Dean before signing</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Alumni Office staff</i></td>
                                </tr>
                                <tr>
                                    <td>3. Check yearbook/master list of graduates/ Graduation Invitation/Program for inclusion of name</td>
                                    <td>Search/Include name of the alumnus/alumna in the Yearbook/Graduation Invitation/Program /Alumni Tracer System</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Alumni Office staff</i></td>
                                </tr>
                                <tr>
                                    <td>4. Sing the QSU Hymn</td>
                                    <td>4.1. Remind the Oath of Membership to QSU Alumni Association and Loyalty to the Alma Mater</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Alumni Office staff</i></td>
                                </tr>
                                <tr>
                                    <td>5. Present authorization letter and IDs (only if applicable)</td>
                                    <td>5. Check for authenticity of IDs and honesty of authorization letter</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Alumni Office staff</i></td>
                                </tr>
                                <tr>
                                    <td>6. Receive duly signed clearance; then, sign in the Graduates Logbook</td>
                                    <td>6. Check data entered in the logbook</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Alumni Office staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>13 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Walk-In Alumni Data Gathering Process</div>
                        <div class="accordion-content">
                            <p>Gathering of Data from Alumni who Visit the Alumni Office</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Alumni Affairs</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All Alumni of QSU-Diffun (including graduates of the then QSC, QNAS, NNVNAS, and NNVHS) or their authorized representatives</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Graduate Questionnaire</td>
                                    <td></td>
                                    <td>Alumni Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Fill-up the Questionnaire</td>
                                    <td>Check questionnaire for completeness of information/data provided by the alumnus/alumna</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Alumnus/Alumna thru the assistance of the Alumni Coordinator</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!--------Non-Front Liners----->


            <div class="container" id="officeVPFinance">
            <h2>Office of the Vice President for Administration and Finance</h2>
            <h2>Internal / External Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Approval of Application of Leave of Absence (ALA) of staff personnel.</div>
                        <div class="accordion-content">
                            <p>Staff personnel and faculty with administrative designations equivalent to 12 and above Full Time Equivalence (FTE) earn 1.25 days VL and 1.25 SL credits per month of service while faculty without administrative designations earn service credits for authorized services rendered during the summer vacation, Christmas break and work overload during the regular semesters. 
                            </br></br>    
                            For the non-teaching personnel & faculty with administrative designations, leaves are deducted from accumulated sick and vacation leaves balances while leave of absences of faculty without administrative designations are deducted from earned service credits.</p>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Approval of Service Records, Certificate of Employment and Other Personnel Records.</div>
                        <div class="accordion-content">
                            <p>Employees and previous employees of the university may request the issuance of personnel records and employment related certifications to support loan applications, step increment, promotions, retirement, transfer to other agencies and for other legal purpose.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C – Government to Clients</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Employees and previous employees of the university</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Approved Request for Documents</td>
                                    <td></td>
                                    <td>FOI Document Controller</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Presents prepared Certifications, Service Records and/or another employee document.</td>
                                    <td>1. Verifies and validates purpose of documents and approves document</td>
                                    <td>P 10.00 per document</td>
                                    <td>2 minutes</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receives approved document</td>
                                    <td>2. Releases document</td>
                                    <td>P 10.00 per document</td>
                                    <td>1 minute</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>P 10.00</td>
                                    <td>3 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Verification of the legality of money claims and veracity of supporting documents.</div>
                        <div class="accordion-content">
                            <p>The Disbursement Vouchers are the required documents for the payment of money claims supported by complete valid and legal documents. Vouchers and supporting documents are verified as to legality of claims & veracity of supporting documents.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C – Government to Clients/G2G – Government to Government</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Employees and the transacting public</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>(same requirements in the voucher processing transaction)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submits Disbursement Vouchers complete with supporting documents.</td>
                                    <td>1. Verifies as to the legality of claims and veracity of supporting documents and signs documents.</td>
                                    <td>None</td>
                                    <td>2 minutes per voucher</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receives signed financial documents.</td>
                                    <td>2. Releases Disbursement Vouchers.</td>
                                    <td>None</td>
                                    <td>1 minute per voucher</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>3 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Approval of Locator Slips for Heads of Support Services Units.</div>
                        <div class="accordion-content">
                            <p>The Locator Slip serves as authority for personnel to leave the campus either for personal or official purposes. This covers a maximum time of one (1) hour. This is surrendered to the Gate Guard will indicate the exact time of departure and the exact time of arrival.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C – Government to Clients</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Subordinates</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. None</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Presents two (2) copies accomplished Locator Slips.</td>
                                    <td>1. Verifies reasons for going out of the campus as indicated in the Locator Slip. And approves Locator Slip.</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receives approved Locator Slip.</td>
                                    <td>2. Releases documents.</td>
                                    <td>None</td>
                                    <td></td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>2 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 5 -->
                    <div class="accordion">
                        <div class="accordion-header">5. Release of money for reimbursement of petty emergency purchases.</div>
                        <div class="accordion-content">
                            <p>The Petty Cash Fund is maintained for the purchase of routinary supplies such as fuel, janitorial supplies, courier services and other urgently needed items. This is replenished every time the fund is exhausted.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C – Government to Clients</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty and Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Petty Cash Voucher Official Receipts</td>
                                    <td></td>
                                    <td>Administrative Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Presents Official Receipts of purchased emergency items.</td>
                                    <td>1. Verifies purchased items, refunds amount of expenses and require personnel to sign in the “Cash/Reimburse ment Received” portion of the Petty Cash Voucher.</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Signs “Reimbursement Received” portion of the Petty Cash Voucher.</td>
                                    <td>2. Pays money claim of personnel.</td>
                                    <td>None</td>
                                    <td></td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>2 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 6 -->
                    <div class="accordion">
                        <div class="accordion-header">6. Management of university facilities.</div>
                        <div class="accordion-content">
                            <p>University facilities such as the gymnasium and Learning Resource Center are used by the different delivery units of the university for meetings, conferences and seminars. Same facilities are often used by outsiders as venues for weddings, seminars and birthdays at minimal rental fees.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C – Government to Clients</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty and Staff/Clients</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. None</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submits letter request for the use of university facilities.</td>
                                    <td>1.1. Inside Clients: Determines availability of facility and brief requesting party on policies on Solid Waste Management & approves request. </br> </br>
                                        1.2. Outside Clients: Determines availability of facility and brief requesting party on rental and Solid Waste Management policies.</td>
                                    <td>P3,000.00 for the LRC and P6,000.00 for the gymnasium per day of use</td>
                                    <td>5 minutes</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Wait for the approval of Letter Request</td>
                                    <td>2. Approves request & provides a copy to the requesting party.</td>
                                    <td></td>
                                    <td></td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>3. Use venue for meetings, seminars and/or conferences complying with agreed policies on solid waste management and payment of rentals. (outside Clients)</td>
                                    <td>3.1. Monitors utilization of facility & requires clients to fill up feedback forms. </br></br>
                                        3.2. Monitors payment of rental fees (outsideClients)</td>
                                    <td></td>
                                    <td></td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>3,000.00 – 6,000.00</td>
                                    <td>5 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 7 -->
                    <div class="accordion">
                        <div class="accordion-header">7. Approval of Request Vehicle for Official Travel.</div>
                        <div class="accordion-content">
                            <p>Approved Request for Vehicle is necessary for the preparation of Trip Tickets for official travels. The approved Trip Tickets serve as permit for the university vehicles to be brought out from the campus for official travels. The time-out and time-in of vehicles are indicated by the Gate Guard on the Trip Ticket. No vehicle is allowed to be brought out from the Campus without an approved Trip Ticket.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C – Government to Clients</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>QSU Faculty and Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Approved Travel Order</td>
                                    <td></td>
                                    <td>Office of the University President</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Presents accomplished Request for Vehicle Form 3 days before scheduled trip</td>
                                    <td>1. Determines necessity of service vehicle, confers with Motor Pool Supervisor on the condition of vehicle to be used, approves request and forward approved request to the concerned driver.</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Wait for the vehicle at the agreed take-off time at the take-off place.</td>
                                    <td>2.1. Prepares Trip Ticket and coordinates with travelling employees of the departure time.</br></br> 
                                        2.2. Requires signatures of passengers on the Trip Ticket before take-off.</br></br>  
                                        2.3. Conducts authorized passengers for official travels</td>
                                    <td>None</td>
                                    <td></td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td>3. Use venue for meetings, seminars and/or conferences complying with agreed policies on solid waste management and payment of rentals. (outside Clients)</td>
                                    <td>3.1. Monitors utilization of facility & requires clients to fill up feedback forms. </br></br>
                                        3.2. Monitors payment of rental fees (outsideClients)</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Dr. Florigold V. Saldaen (VP for Administration and Finance)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="procurementOffice">
            <h2>Procurement Office</h2>
            <h2>Internal / External Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Receipt of Purchase Request for Shopping and Small Value Procurement</div>
                        <div class="accordion-content">
                            <p>Submission of Purchase Request</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All QSU Faculty and Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Purchase Request Form</td>
                                    <td></td>
                                    <td>BAC Chairperson’s/Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submit the PR (hard and soft copies) with corresponding fund clusters at the Procurement Office</td>
                                    <td>1.1. Scrutiny of the submitted PR before accepting and receiving. Procurement of Goods shall be based on approved PPMP/APP.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. PRs will be sent to the HoPE for approval</td>
                                    <td>None</td>
                                    <td>5 minutes (depending on the availability of the HoPE)</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>10 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Agency Procurement Request Preparation</div>
                        <div class="accordion-content">
                            <p>Submission of APR to PS-DBM</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. APR Form</td>
                                    <td></td>
                                    <td>PS-PhilGEPS</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Download APR form, fill it out and submit to PS-DBM.</td>
                                    <td>1. 1.1. Approval of APR by the HoPE</td>
                                    <td>None</td>
                                    <td>5 minutes (depending on the availability of the HoPE)</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td>t</td>
                                    <td>1.2. PS-DBM submission thru email</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>6 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Request for Quotation/Canvass Preparation</div>
                        <div class="accordion-content">
                            <p>RFQ Invitation/Canvass dissemination</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Complex</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2B</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Procurement Office and All QSU Faculty and Staff End-Users</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. RFQ/Canvass Form</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. PhilGEPS account</td>
                                    <td></td>
                                    <td>PhilGEPS Website</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Fill out RFQ/Canvass Form</td>
                                    <td>1.1. Consolidate approved PRs</td>
                                    <td>None</td>
                                    <td>2 hours</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. PhilGEPS Postings</td>
                                    <td>None</td>
                                    <td>15 minutes</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.3. PhilGEPS posting ad</td>
                                    <td>None</td>
                                    <td>5 days</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.4. Canvass dissemination</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>6 day 2 hours 15 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Purchase Order and Abstract as Calculated/Abstract of Canvass Preparation</div>
                        <div class="accordion-content">
                            <p>Evaluation of Purchase Order and Abstract as Calculated/Abstract of Canvass</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2B/G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. PO Form</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Abstract as Calculated/Abstract of Canvass Form</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Fill Out form</td>
                                    <td>1.1 Evaluation of attached documents</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. Retrieve completely signed documents by all signatories</td>
                                    <td>None</td>
                                    <td>2 days (depending on the availability of signatories)</td>
                                    <td><i>Staff (Procurement Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>3 days</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 5 -->
                    <div class="accordion">
                        <div class="accordion-header">5. Pre-Procurement of Goods/Services Through Competitive Bidding</div>
                        <div class="accordion-content">
                            <p>Conduct of Pre-Procurement conference for Procurement readiness</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Office of the Vice President for Administration and Finance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>BAC, BAC Sec and All QSU Faculty and Staff End-Users</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. List of Items to be purchased</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Services to be rendered</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Program of Works (Civil works) CLIENT STEPS</td>
                                    <td></td>
                                    <td>Physical Plant and Site Development (PPSD) Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Participate in the Pre-Procurement</td>
                                    <td>1. Discuss relevant matters in preparation for Procurement</td>
                                    <td>None</td>
                                    <td>2 hours (highly depends on the technicality of goods/services)</td>
                                    <td><i>Bids and Awards Committee and TWG</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>2 hours</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 6 -->
                    <div class="accordion">
                        <div class="accordion-header">6. Preparation of Bidding Documents</div>
                        <div class="accordion-content">
                            <p>Review and Finalization of Bid Docs</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>BAC Sec</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Bid documents form</td>
                                    <td></td>
                                    <td>Government Procurement Policy Board website (GPPB)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. PhilGEPS account</td>
                                    <td></td>
                                    <td>PhilGEPS Website</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Prepare the bid documents for posting</td>
                                    <td>1.1. Review the bid documents</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>BAC, BAC Sec and TWG</i></td>
                                </tr>
                                <tr>
                                    <td>2. Fill out the necessary information for the Project to be bid</td>
                                    <td>2.1. Scrutinize and finalize detailed information</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>BAC, BAC Sec and TWG</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>2 days</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 7 -->
                    <div class="accordion">
                        <div class="accordion-header">7. Advertisement/Posting of the Invitation to Bid</div>
                        <div class="accordion-content">
                            <p>Public notice to all prospective bidders</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>BAC, BAC Sec and All QSU Faculty and Staff End-Users and Prospective Bidders</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. PhilGEPS account</td>
                                    <td></td>
                                    <td>PhilGEPS Website</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Secure bidding documents</td>
                                    <td>1.1. Advertise the Invitation to Bid thru PhilGEPS</td>
                                    <td>None</td>
                                    <td>15 minutes</td>
                                    <td><i>BAC Sec</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. PhilGEPS Postings</td>
                                    <td>None</td>
                                    <td>21 days</td>
                                    <td><i>BAC Sec</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>21 days 15 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 8 -->
                    <div class="accordion">
                        <div class="accordion-header">8. Pre-Bid Conference</div>
                        <div class="accordion-content">
                            <p>Conduct of Pre-Bid Conference</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>BAC, BAC Sec and TWG</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Attendance Sheet Form</td>
                                    <td></td>
                                    <td>BAC Sec</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Bid Documents</td>
                                    <td></td>
                                    <td>BAC Sec</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Participation in the Pre-Bid Conference</td>
                                    <td>1. Discuss, clarify and explain the details of the project to be bid.</td>
                                    <td>None</td>
                                    <td>2 hours (highly depends on the technicality of goods/services)</td>
                                    <td><i>BAC, BAC Sec and TWG</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>2 hours</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 9 -->
                    <div class="accordion">
                        <div class="accordion-header">9. Opening of Bids – Technical and Financial Proposals</div>
                        <div class="accordion-content">
                            <p>Opening, Examination and Inspection of Technical and Financial proposals</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>BAC, BAC Sec and All QSU Faculty and Staff End-Users and Prospective Bidders</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Technical and Financial Proposals</td>
                                    <td></td>
                                    <td>Procurement/BAC Sec Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Observe the opening of bid proposals</td>
                                    <td>1. Open, examine and inspect the technical and financial proposals of prospective bidders</td>
                                    <td>None</td>
                                    <td>1 hour (highly depends on the complexity of the project)</td>
                                    <td><i>BAC, BAC Sec and TWG</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>1 hour</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <div class="container" id="supplyOffice">
            <h2>Supply Office</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Inspection and Acceptance</div>
                        <div class="accordion-content">
                            <p>Strict implementation on actual and physical inspection of complete delivered items. Acceptance of complete delivered item upon complying all requirements and specifications in the Purchase Request and Purchase Order.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Supply Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Client</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Private and Public Supplier</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Approved Disbursement Voucher</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Copy of received Purchase Order from Procurement Office</td>
                                    <td></td>
                                    <td>Private and Public Supplier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Delivery Receipt/ Sales Invoice/ Statement of Delivery</td>
                                    <td></td>
                                    <td>Private and Public Supplier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Complete delivered Items (Supplies, Materials and Equipment)</td>
                                    <td></td>
                                    <td>Supply Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5. Inspection and Acceptance</td>
                                    <td></td>
                                    <td>Supply Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Coordinate the deliveries to Supply Office</td>
                                    <td>1. Check the completeness of documents (approved; Purchase Request, Canvass/Quotation and Purchase Order) attached in the Disbursement Voucher.</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Supply and Property Management Assistant</i></td>
                                </tr>
                                <tr>
                                    <td>2. Prepare/present the Delivery Receipt of delivered Items</td>
                                    <td>2. Check the inclusiveness of delivered items</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Supply and Property Management Assistant</i></td>
                                </tr>
                                <tr>
                                    <td>3. Complete delivery of Items</td>
                                    <td>3. Actual Inspection, Acceptance and Inventory of delivered Items</td>
                                    <td>None</td>
                                    <td>1 Hour</td>
                                    <td><i>Supply and Property Management Officer/ Inspection Officer</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>1 Hour and 8 Minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Issuance and Utilization</div>
                        <div class="accordion-content">
                            <p>Issuance of complete delivered items to End-User upon showing the approved Purchase Request. Direct inventory, monitoring and control of supplies, materials and equipment issued.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Supply Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Client</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>End-User (Faculty and Staff of the University)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Approved Disbursement Voucher (Purchase Request, Purchase Order and Delivery Receipt)</td>
                                    <td></td>
                                    <td>Procurement Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Copy of approved Purchase Request</td>
                                    <td></td>
                                    <td>End-User</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Delivered Items(Supplies, Materials and Equipment)</td>
                                    <td></td>
                                    <td>Supply Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present approved Purchase Request</td>
                                    <td>1. Check and verify the approved Purchase Request if included in the inventory and delivered items</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Supply and Property Management Assistant</i></td>
                                </tr>
                                <tr>
                                    <td>2. Inventory and Inspection the completeness and suitability of requested items</td>
                                    <td>2. Assistance in the Inventory and Inspection based in the Delivery Receipt and approved Purchase Order</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Inspection Officer</i></td>
                                </tr>
                                <tr>
                                    <td>3. Receive requested Items</td>
                                    <td>3.1 Prepare Receiving documents (Requisition and Issuance Slip (RIS), Inventory Custodian Slip (ICS) for semiexpendable Property, Plant and Equipment (PPE), Property Acknowledgement Receipt (PAR) for PPE).</br>
                                        3.2 Prepare requested items. </br>
                                        3.3 Record receiving documents for preparation of report.</br> 
                                        3.3 Approve by the Supply Custodian. </br>
                                        3.4 Issue/Release requested items.</td>
                                    <td>None</td>
                                    <td>1 hour</td>
                                    <td><i>Supply and Property Management Assistant, Inspection Officer and Supply and Property Management Officer/ Supply Custodian</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>1 Hour and 10 Minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="hrOffice">
            <h2>Human Resource Management Office</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Processing of Application for Rendition of Overtime Services for NonMonetary Renumeration</div>
                        <div class="accordion-content">
                            <p>This document aims to standardize a quality system procedure in the rendition of overtime services in the University. This procedure applies to regular faculty and staff including Contract of Service (COS) personnel.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Human Resource Management Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All Faculty and Staff including Contract of Service personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Request for the Rendition of Overtime Services (Request for Authority to Render Overtime Services Form)</td>
                                    <td></td>
                                    <td>Supervisor/HR Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Logbook/Biometrics</td>
                                    <td></td>
                                    <td>HR Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Certificate of Overtime Credit</td>
                                    <td></td>
                                    <td>HR Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Leave Form</td>
                                    <td></td>
                                    <td>HR Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Sign in the Client Logbook</td>
                                    <td>1. Entertains Client</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>HRMO Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Present the Approved Request for Authority to Render Overtime Services Form</td>
                                    <td>2. Received and Verifies document.</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>HRMO Staff</i></td>
                                </tr>
                                <tr>
                                    <td>2. Request for Biometric Printout and Certificate of Overtime Credit</td>
                                    <td>2.1. Received the Request; </br></br>
                                        2.2. Start Processing the Request;</br></br>
                                        2.3. Issue the Biometric Printout and Certificate of Overtime Credit signed by the HRMO;</td>
                                    <td>None</td>
                                    <td>45 minutes</td>
                                    <td><i>(HRMO Staff)</br></br> (HRMO Staff)</i></td>
                                </tr>
                                <tr>
                                    <td>3. Fill up and submit Leave Form (Form 6) and Make sure it is properly filled up and approved by Supervisors</td>
                                    <td>3. Receivedthe documents;</td>
                                    <td>None</td>
                                    <td>10 minutes</td>
                                    <td><i>(HRMO Staff)</i></td>
                                </tr>
                                <tr>
                                    <td>4. Submit Leave Form supportedly by the Certificate of Compensatory Overtime Credit. Request for the Redition of Overtime Form together with the Biometric at the HRM Office</td>
                                    <td>4. Record to Employee's Leave Card total numberofrendered</td>
                                    <td></td>
                                    <td></td>
                                    <td><i></i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>57 Minutes</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services (applies to all Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students, Employees, Immediate Dependents</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F003</td>
                                    <td></td>
                                    <td>Office of The Dental Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1.1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>None</td>
                                    <td>15 seconds</td>
                                    <td><i>Edgar A. Ulep, RM.</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. Interview the patient for proper diagnosis and record all data gathered</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mayjuleth S. Ramos,</i></td>
                                </tr>
                                <tr>
                                    <td>2. Clients will proceed to treatment area and follow procedures as instructed.</td>
                                    <td>2.1. Health personnel shall pull out the dental record of the patient 2.2. Preparation of</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Edgar A. Ulep, RM.</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Processing of Application for the Approval of Travel Order</div>
                        <div class="accordion-content">
                            <p>This document aims to standardize a quality system procedure in processing of Travel orders. This procedure applies to regular faculty and staff including Contract of Service (COS) personnel.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>HUMAN RESOURCE MANAGEMENT OFFICE</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All Faculty and Staff including Contract of Service personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Communication Letters/Memorandum</td>
                                    <td></td>
                                    <td>Supervisor</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Routing Slip for Approval</td>
                                    <td></td>
                                    <td>Office of the President</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. F11 Form (Travel Order Form) Properly Filled-up</td>
                                    <td></td>
                                    <td>HR Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Sign in the Client’s Logbook</td>
                                    <td>1. Entertains Client</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mary Ann Dela Cruz and Abigail Bongtayon (Office of the President)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Present and submit the Communication/M emorandum to the office of the President</td>
                                    <td>2. Received and Verifies document.</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>Mary Ann Dela Cruz and Abigail Bongtayon (Office of the President)</i></td>
                                </tr>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Medical Services(applies to Campuses)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students, Employess, Immediate Dependets</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. QSU-MED-F003</td>
                                    <td></td>
                                    <td>Office of The Dental Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Log-in to the general logbook</td>
                                    <td>1.1. Health personnel ask for the reason of clinic visit, and then give necessary forms.</td>
                                    <td>None</td>
                                    <td>15 seconds</td>
                                    <td><i>Edgar A. Ulep, RM.</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. Interview the patient for proper diagnosis and record all data gathered</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>MayjulethS. Ramos,</i></td>
                                </tr>
                                <tr>
                                    <td>2. Clients will proceed to treatment area and follow procedures as instructed</td>
                                    <td>2.1 Health personnel shall put out the dental record of the patient</br>
                                    2.2 Preparation of</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td>Edgar A. Ulep, RM.</td>
                                </tr>
                                <tr>
                                    <td>3. Properly Fill up and submit the F11 Form (Travel Order Form) signed by Immediate Supervisor</td>
                                    <td>3.1 Received the Request;</br></br>
                                        3.2 Start Processing the Request for the Approval of the University President;</br></br>
                                        3.3 Turn over the  Approved Travel order to the HR Office for Numbering and Recording</td>
                                    <td>None</td>
                                    <td>20 Minutes
                                        </br></br></br>
                                        1 Minute
                                    </td>
                                    <td>Mary Ann Dela Cruz and Abigail Bongtayon (Office of the President)</br></br></br>
                                    (HR Office)</td>
                                </tr>
                                <tr>
                                    <td>4. Receives Approved Travel order.</td>
                                    <td>4. Releases Travel order;</td>
                                    <td>None</td>
                                    <td>3 Minutes</td>
                                    <td>(HR Office)</td>
                                </tr>
                                <tr>
                                    <td>5. Sign in the Client’s Logbook.</td>
                                    <td>5. Record the Employee’s Travel for the updating of Employee’s Leave Card.</td>
                                    <td>None</td>
                                    <td>3 Minutes</td>
                                    <td>(HR Office)</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>26 Minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Processing of Service Records and Certificate of Employment and other Personnel Records</div>
                        <div class="accordion-content">
                            <p>This document aims to standardize a quality system procedure in processing request for the issuance of Service Records, Certificate of Employment and personnel records. This procedure applies to regular faculty and staff and previous employees including Contract of Service (COS) personnel.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>HUMAN RESOURCE MANAGEMENT OFFICE</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All Faculty and Staff, previous employees including Contract of Service personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Document Requisition Slip</td>
                                    <td></td>
                                    <td>Records Management Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Official Receipt</td>
                                    <td></td>
                                    <td>Cashier’s Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Sign in the Client’s Logbook</td>
                                    <td>1. Entertains Client</td>
                                    <td>None</td>
                                    <td>1 minute</td>
                                    <td><i>(HRMO – Staff)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Request Document Requisition Slip</td>
                                    <td>2. Releases Document Requisition Slip</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Ma. Elena D. Dupa (Board Secretary V) </br></br>
                                        (Cashier)</i></td>
                                </tr>
                                <tr>
                                    <td>3. Pay at the Cashier</td>
                                    <td>3. Releases Official Receipts</td>
                                    <td>10.00</td>
                                    <td></td>
                                    <td><i></i></td>
                                </tr>
                                <tr>
                                    <td>4. Present and submit the Document Requisition Slip and Official Receipt</td>
                                    <td>4. Receives and Prepares document for signing by the Chief Administrative Officer.</td>
                                    <td>None</td>
                                    <td>5 Minutes</td>
                                    <td><i>(HRMO Staff )</i></td>
                                </tr>
                                <tr>
                                    <td>5. Receives copy of the documents</td>
                                    <td>5. Releases the document;</td>
                                    <td>None</td>
                                    <td>1 Minute</td>
                                    <td><i>(HRMO Staff )</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>10.00</td>
                                    <td>10 Minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Processing of Application for Leave</div>
                        <div class="accordion-content">
                            <p>This document aims to standardize a quality system procedure in processing of Application for Leave. This procedure applies to regular faculty and staff including Contract of Service (COS) personnel.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>HUMAN RESOURCE MANAGEMENT OFFICE</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All Faculty and Staff, previous employees including Contract of Service personnel</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Form 6 (2 Copies)</td>
                                    <td></td>
                                    <td>Office of the Chief AO</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Medical Certificate (if necessary)</td>
                                    <td></td>
                                    <td>Cashier’s Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Fill up Form CSC Form 6</td>
                                    <td>1. Verifies Leave Balances</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Immediate Supervisor</br></br> 
                                        Dr. Cherry P. Collado (VP for Administration and Finance)/ (for Staff)</br></br>     
                                        Dr. Elizabeth T. Carig (VP for Academic)/ (for Faculty)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Wait for processing of document</td>
                                    <td>2.1. Interviews employee for reasons of leave</td>
                                    <td>None</td>
                                    <td>1 Minute</td>
                                    <td><i>HRMO Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>2.2. Indicates leave balances in the leave form</td>
                                    <td>None</td>
                                    <td>2 Minutes</td>
                                    <td><i>Dr. Cherry P. Collado VP for Administration and Finance/ (for Staff) </i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>2.3. Signs recommending approval portion</td>
                                    <td>None</td>
                                    <td>1 Minute</td>
                                    <td><i>Dr. Elizabeth T. Carig (VP for Academic) / (for Faculty) </i></td>
                                </tr>
                                <tr>
                                    <td>3. Receives Leave Form</td>
                                    <td>4. Receives and Prepares document for signing by the Chief Administrative Officer.</td>
                                    <td>None</td>
                                    <td>5 Minutes</td>
                                    <td><i>(HRMO Staff )</i></td>
                                </tr>
                                <tr>
                                    <td>3. Returns leave form for approval of approving Authority</td>
                                    <td>4. Receives and Records Approved ALA (Form 6)</td>
                                    <td>None</td>
                                    <td>1 Minute</td>
                                    <td><i>(HRMO Staff )</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>6 Minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="container" id="plantOffice">
            <h2>Physical Plant and Site Development Office</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Repair and Replacement of Facilities</div>
                        <div class="accordion-content">
                            <p>This covers the installation, inspection, replacement and repair of facilities.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Physical Plant and Site Development</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Complex</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C- Government to Client</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All QSU Faculty and Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Work Order Request Form (2 copies)</td>
                                    <td></td>
                                    <td>QSU - Physical Plant and Site Development</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Secure a work order request form</td>
                                    <td>1. Issue form to the employee of the University</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Maintenance and Construction Engineer detailed</i></td>
                                </tr>
                                <tr>
                                    <td>2. Submit a Work Order Request Form</td>
                                    <td>2. Accept and approve the work order request form</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Documentary custodian</i></td>
                                </tr>
                                <tr>
                                    <td>3. Accompany PPSD personnel for the inspection</td>
                                    <td>3. Inspect the reported facility</td>
                                    <td>None</td>
                                    <td>2 Hours</td>
                                    <td><i>Construction and Maintenance Engineer, Maintenance personnel, Quantity Surveyor/Draftsman</i></td>
                                </tr>
                                <tr>
                                    <td>4. Wait for the estimate of the assigned PPSD personnel</td>
                                    <td>4. Plan and estimate the request of the client</td>
                                    <td>None</td>
                                    <td>5 days</td>
                                    <td><i>PPSD Personnel</i></td>
                                </tr>
                                <tr>
                                    <td>5. Receive, sign, and accomplish the Purchase request of estimated materials and labor</td>
                                    <td>5. Submit the duly signed Purchase request to the Procurement office</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Project in charge</i></td>
                                </tr>
                                <tr>
                                    <td>6. Receive requested materials</td>
                                    <td>6. Inspect the delivered materials</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Project in charge, Construction and Maintenance Engineer</i></td>
                                </tr>
                                <tr>
                                    <td>7. Accompany the PPSD personnel for the inspection and acknowledgment of repair and replacement facility</td>
                                    <td>7. Inspect, acknowledge, and verify the repair/replaceme nt of facility</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>PPSD Director, Construction and Maintenance Engineer, Maintenance personnel, Quantity Surveyor/Draftsman</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>8 days, 2 hrs, 10 mins</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="auxiliaryOffice">
            <h2>Auxiliary and Enterprise Development Office</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. IGE Monthly Reports Submission</div>
                        <div class="accordion-content">
                            <p>Submission of monthly Income Generating Enterprise (IGE) reports every 10th day of next month.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>AED Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Complex</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2G (Government to Government)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>IGE Managers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. IGE Forms</td>
                                    <td></td>
                                    <td>AED Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. List of AR</td>
                                    <td></td>
                                    <td>Supply staff</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. List of sales receipts</td>
                                    <td></td>
                                    <td>Cashier’s office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. List of Expenses</td>
                                    <td></td>
                                    <td>Budget office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5. List of Collections</td>
                                    <td></td>
                                    <td>Accounting office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Secure IGE Forms</td>
                                    <td>1.1. Provide IGE forms</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Staff (AED Office)</i></td>
                                </tr>
                                <tr>
                                    <td>2. Secure list of AR, sales receipts, expenses, and collections</td>
                                    <td>2.1. Facilitate collection of records from different offices</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Staff (Supply, accounting, budget and cashier’s Office)</i></td>
                                </tr>
                                <tr>
                                    <td>3. Filling up and submission of IGE report forms</td>
                                    <td>3.1. Guide IGE managers </br>
                                        3.2. Check individual records </br>
                                        3.3 Receive completed forms </br>
                                        3.4 Consolidate the individual IGE report.</td>
                                    <td>None</td>
                                    <td>5 days</br></br></br>
                                        5 days</td>
                                    <td><i>IGE managers and AED Asst. Director and Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>12 days and 5 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="misWebContent">
            <h2>Management Information System – Web Content</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Add or Update Web Content Request Form</div>
                        <div class="accordion-content">
                            <p>Submission of Web Content Request Form</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Management Information System</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2G</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>All QSU Faculty and Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Web Content Request Form</td>
                                    <td></td>
                                    <td>Management Information System Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Softcopy of Content to be uploaded</td>
                                    <td></td>
                                    <td>The office requesting</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submit Web Content Request Form and the softcopy of the content</td>
                                    <td>1.1. Receive Web Content Request Form and the Data to be uploaded in the website.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Staff (MIS Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.2. Forward the form for approval to the MIS Officer.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>MIS Officer</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.3. Once approved, call the attention of the Web Master for the uploading. </br></br>
                                        1.3.1. Upload Content</td>
                                    <td>None</td>
                                    <td>5  minutes</td>
                                    <td><i>Web Master</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receives Notification</td>
                                    <td>2.1. Notify the requesting office once the content is uploaded.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Staff (MIS Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>20 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="financeServices">
            <h2>Finance Services</h2>
            <h2>Internal / External Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Processing of Disbursement Voucher</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Finance Department</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Complex</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Clients/Government to Government/Government to Business</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students/Faculty/Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Budget Utilization Request and Status</td>
                                    <td></td>
                                    <td>Budget Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Obligation Request and Status</td>
                                    <td></td>
                                    <td>Budget Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Disbursement Vouchers</td>
                                    <td></td>
                                    <td>Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Report of Checks Issued</td>
                                    <td></td>
                                    <td>Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1.	Submit the Voucher with attachments</td>
                                    <td>1.1. Receive and check the Disbursement Voucher with attachments for checking </br></br>
                                        1.2. Record/log the DV to the Logbook </br></br>
                                        1.3. shall attach checklist and routing slip</td>
                                    <td>None</td>
                                    <td>6 minutes</td>
                                    <td><i>Staff (Finance Division)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.4. Forward Disbursement Voucher to Budget Office for Obligation</td>
                                    <td>None/td>
                                    <td>5 minutes</td>
                                    <td><i>Staff (Finance Division)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.5. Fills up necessary data in the ORS/BURS system </br></br>
                                        1.6. Generates/Prints ORS/BURS from the system </br></br>
                                        1.7. Gives the ORS/BURS to Budget Officer for review</td>
                                    <td>None</td>
                                    <td>5 minutes (simple transactions) </br></br>
                                        10 minutes (complex transactions)</td>
                                    <td><i>Staff (Budget Office)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.8. Review ORS/BURS Signs the ORS/BURS</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Budget Officer</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.9. Fills up tracking slip for the release of the ORS/BURS </br></br>
                                        1.10. Forwards signed ORS/BURS to the VP- Admin. & Finance</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Staff (Budget Office)</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Collection and Deposit Process</div>
                        <div class="accordion-content">
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>Cashier’s Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Complex</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Client/Government to Government/Government to Business</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Students/Faculty/Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. SIAS Official Receipt</td>
                                    <td></td>
                                    <td>Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Deposit Slip (Land Bank Deposit Slip)</td>
                                    <td></td>
                                    <td>Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. SIAS Detailed Collection and Deposit</td>
                                    <td></td>
                                    <td>Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Cash Receipt Registry</td>
                                    <td></td>
                                    <td>Cashier</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Receipt of Cash or Check</td>
                                    <td>1.1. receive approved cash/check from payor representing collection, input the transaction in the SIAS and issues Official Receipt. </br></br>
                                        1.2. Collecting Officer shall also forwards the collection to the cashier.</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Collecting Officer</i></td>
                                </tr>
                                <tr>
                                    <td>2. Receipt of collections</td>
                                    <td>2.1. Receive collections, verify if the amount tally with the one appearing in the deposit it to the bank</td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>Cashier III</i></td>
                                </tr>
                                <tr>
                                    <td>3. Receipt of Deposit Slip</td>
                                    <td>3.1. Receive the deposit slip and input in the SIAS. </br></br>
                                        3.2. Generate details of the collection and deposit for the day and forwards to Cashier Staff II</td>
                                    <td>None</td>
                                    <td>2 minutes </br></br></br></br>2 minutes</td>
                                    <td><i>Collecting Officer</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>9 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="researchDevelopment">
            <h2>Research and Development Office</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Application and Endorsement for External Research Presentation</div>
                        <div class="accordion-content">
                            <p>Endorsement and approval process for research paper presentation in in-country research conference/colloquium/forum/congress</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>University Research and Development Office (URDO)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Client</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Faculty Researcher/Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Letter of Intent for External Research Presentation</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Abstract of the Paper</td>
                                    <td></td>
                                    <td>Faculty Researcher/Staff</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Acceptance Letter from Conference</td>
                                    <td></td>
                                    <td>External research conference/colloquium/forum/congress</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Completed Paper Certification Form</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5. Research Approval Form</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6. Endorsement Form for External Research Presentation</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present Letter of Intent for External research Presentation and other requirements</td>
                                    <td>1.1. Accepts Letter of Intent submitted by Faculty/Researcher. </br>
                                        1.2. Check if Letter of Intent is accompanied by the following documents: </br>
                                        1.3. Acceptance letter/invitation letter and program (if available) from the research conference/colloquiu m/forum/congress will be held.</br> &emsp; • Abstract/full paper</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Staff (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.4. Verify if the research output was presented in any of the University’s inhouse review or special research review conducted. If output was presented, KMS Coordinator will issue a certification that the research output was presented during the AIHR/special research review.</td>
                                    <td>None/td>
                                    <td>5 minutes</td>
                                    <td><i>KMS Coordinator (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.5. Review the application and if found sufficient, certifies that the application is complete. Forward the application to the VP RDET for endorsement.</td>
                                    <td>None</td>
                                    <td>3 days</td>
                                    <td><i>University Research Director (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.6. Review the application and determine if application is complete. If found meritorious, the faculty researcher is endorsed to the CHED-IAS for application and issuance of travel clearance (for offcountry presentation).</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Vice President, Research Development and Extension Training (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>5 Days and 8 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 2 -->
                    <div class="accordion">
                        <div class="accordion-header">2. Faculty Paper Presentation in the University In-House Review</div>
                        <div class="accordion-content">
                            <p>Procedure to be undertaken for paper presentation during annual University In-House Reviews</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C - Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Faculty Researchers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Full Paper</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. PowerPoint presentation</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3. Bio-note</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4. Rapporteur’s Report</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1. Prior to presentation proper, the facilitator will present and discuss the procedure for presentation. </br></br>
                                        Introduce the paper presenter as well as title of paper to be presented to the panel of evaluators</td>
                                    <td>None</td>
                                    <td>30 minutes</td>
                                    <td><i>URDO Staff</i></td>
                                </tr>
                                <tr>
                                    <td>1. Presents the study through PowerPoint presentation</td>
                                    <td>2.	The	faculty researcher shall be given minimum of 12 minutes but not more than 15 minutes to present his/her study. </br></br>
                                        The allotted time should be used on the following: </br> &emsp;
                                        • Discussion of thebackground/ rationale of the study </br> &emsp;
                                        • Discussion of the methodology employed in conducting the study </br> &emsp;
                                        • Presentation of the results and discussion of the study </br> &emsp;
                                        • Discussion of thefindings of the study visà-vis the objectives.</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Faculty Researcher</i></td>
                                </tr>
                                <tr>
                                    <td>2. Answer the question/s posed by the Evaluators</td>
                                    <td>3.	After	the presentation, the panel of evaluators shall be given ample time to ask questions or pose points	of clarifications to the presenter.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Evaluators (External)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>4. Note down the issues, questions and clarifications forwarded by the evaluators as well as the corresponding answer from the presenter. These issues, questions and clarifications as well as recommendations from the evaluators to improve the research output shall be included in the proceedings of the in-house review.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Documenter/Facilitator</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>5. Consolidate all the session reports and come up with a consolidated inhouse review proceedings. The report will be submitted to the URDO for dissemination	and filing.</td>
                                    <td>None</td>
                                    <td>20 minutes</td>
                                    <td><i>Documenter/Facilitator</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>6. Upon receipt of the consolidated report, URDO staff shall furnish a copy of the comments and recommendation made by the panel of evaluators for each presenter	to	serve as basis in improving the research manuscript.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>URDO Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>3 Days and 60 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 3 -->
                    <div class="accordion">
                        <div class="accordion-header">3. Research Publication Process</div>
                        <div class="accordion-content">
                            <p>Procedure for facilitating the publication of completed researches either online or print</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Highly Technical</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>G2C - Government to Citizen</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Faculty Researchers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Full Paper</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submit paper to the office for initial evaluation and editing</td>
                                    <td>1. Accepts paper for Publication and forward it to the Managing Editor.  </br></br>
                                        <i>Note: In-House Winners are priority.</i></td>
                                    <td>None</td>
                                    <td>2 minutes</td>
                                    <td><i>URDO Staff</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>2. Evaluates paper. Determine if the paper falls in any of the field mentioned in the research manual.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Managing Editor (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>3. Evaluate the merit of the paper for publication. If found suitable, the paper goes back to the Managing Editor</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Editorial Board (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>4. Managing Editor makes the initial editing, further evaluation and critiquing. After initial evaluation, the paper is forwarded to the University Statistician.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Managing Editor (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>5.	Review the methodology and statistical tool used in the analysis of data.</br>
                                        • The result of the review will be the basis in determining whether a paper is deemed suitable or not suitable for publication. Author/s of accepted or rejected papers are informed properly of the results via email or letter.</td>
                                    <td>None</td>
                                    <td>5 days</td>
                                    <td><i>University Statistician</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>6. Review, critiques and edits the paper. Checks if the paper followed the required	format.	If found in	order, paper is forwarded to the Editor in Chief. </br></br>
                                        If not in order, the paper returns to the Managing Editor for further improvement.</td>
                                    <td>None</td>
                                    <td>5 days</td>
                                    <td><i>Associate Editor (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>7. Review the paper and incorporate comments made by the Associate Editor.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Managing Editor (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>8. Do the final review and editing of the paper.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Editor-in-Chief (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>9. Do the lay outing, blueprinting and cover designing.</td>
                                    <td>None</td>
                                    <td>5 days</td>
                                    <td><i>Lay-out artists (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>10. If not in order, paper returns to the Associate Editor for further review in consultation with</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Associate Editor (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>the Managing Editor. </br></br>
                                        Reviewing/proofrea ding follows these stages: </br>
                                        a. Edited manuscript </br>
                                        b. Second proof. It is understood that the Associate Editor has made all final corrections and additions on the second stage of proofreading.</td>
                                    <td></td>
                                    <td></td>
                                    <td><i></i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>11. Does the final round of review for returned papers and submit to the lay-out artist	after completed. </br></br>
                                        Once the journal has been laid-out Papers are forwarded to External Technical Reviewers</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Editor-in-Chief(URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>12.	Review and check the corrected paper based on the recommendation of the technical reviewer.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Managing Editor, Associate Editor for proofreading (URDO) and Consultant (External)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>13. Finalizes the lay-outing. Once lay-outing	is completed, printing is done and copy is forwarded to the Editor-in-Chief.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Lay-out artists(URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> 14. Proofread the outline in consultation with the Associate Editor and Consultant. No major changes will be followed in the outline.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Editor-in-Chief(URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>15. After revisions are incorporated, Managing Editor coordinates with the publishing company and accounting department for the final printing of the journal.</td>
                                    <td>None</td>
                                    <td>2 days</td>
                                    <td><i>Managing Editor (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>37 Days and 2 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Accordion 4 -->
                    <div class="accordion">
                        <div class="accordion-header">4. Facilitation and Issuance of Cash Incentives</div>
                        <div class="accordion-content">
                            <p>Application and disbursement of RDE cash incentives for publications, best paper award during conferences, and approved patent/utility model for research outputs completed by faculty researcher/s.</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>University Research and Development Office (URDO)e</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Simple</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Client</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Faculty Researcher/Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1.	Letter of Intent for External Research Presentation Request Letter for Cash Incentives (Paper Presentation/Publication)</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Completed Paper Certification Form</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3.	Endorsement Form for Research Cash Incentives</td>
                                    <td></td>
                                    <td>University Research and Development Office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Present the application for RDE cash incentive</td>
                                    <td>1.1. Accepts the letter of intent for cash incentive with the necessary attachment, like copy of the certificate of recognition. </br>
                                        1.2. For publication, URDO staff ensures that research journals where output is published is indexed by Thomson ISI now Clarivate Analytics, Elsevier Scopus, CHED and other reputable journal.</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Staff (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.3. Verify if the research output was presented in any of the University’s inhouse review or special research review conducted. If output was presented, KMS Coordinator will issue a certification that the research output was presented during the AIHR/special research review.</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>KMS Coordinator (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.4. Review the application and if found sufficient, certifies that the application is complete. Forward the application to the VP RDET for endorsement.</td>
                                    <td>None</td>
                                    <td>3 days</td>
                                    <td><i>University Research Director (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.5. Sign and endorse the application to the Office of the President. OP staff shall return the approved application to the URDO.</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Vice President, Research Development and Extension Training (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1.6. Accepts the approved application. Inform the concerned faculty through call or text about the approval of the application</td>
                                    <td>None</td>
                                    <td>5 minutes</td>
                                    <td><i>Staff (URDO)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td></td>
                                    <td>4 Days and 13 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container" id="extensionTraining">
            <h2>Extension & Training Services</h2>
            <h2>Internal Services</h2>

                <div style="overflow-y: auto; max-height: 500px;">

                    <!-- Accordion 1 -->
                    <div class="accordion">
                        <div class="accordion-header">1. Conduct of Internally Funded Training</div>
                        <div class="accordion-content">
                            <p>Conduct of internally funded trainings from submission of proposal up to submission of required documents (refer to checklist of evaluation of end of training reports)</p>
                            <table>
                                <tr>
                                    <th><strong>Office or Division:</strong></th>
                                    <td>University Extension & Training Services</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Classification:</strong></th>
                                    <td>Complex</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Type of Transaction:</strong></th>
                                    <td>Government to Client</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Who may avail:</strong></th>
                                    <td>Faculty Extension worker/Extension Staff</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>CHECKLIST OF REQUIREMENTS:</strong></th>
                                    <th></th>
                                    <th>WHERE TO SECURE</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1. Training proposal</td>
                                    <td></td>
                                    <td>University Extension & Training Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2. Checklist of evaluation of end of training reports</td>
                                    <td></td>
                                    <td>University Extension & Training Services</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>CLIENT STEPS</th>
                                    <th>AGENCY ACTIONS</th>
                                    <th>FEES TO BE PAID</th>
                                    <th>PROCESSING TIME</th>
                                    <th>PERSON RESPONSIBLE</th>
                                </tr>
                                <tr>
                                    <td>1. Submit training proposal</td>
                                    <td>1. Receive training proposal</td>
                                    <td>None</td>
                                    <td>3 minutes</td>
                                    <td><i>Staff (UETS)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>2. Evaluate the training proposal</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Director for Extension & Training Services</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>3. Endorse the proposal to Vice President for RDET</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Director for Extension & Training Services</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>4. Notify the proponent to proceed</td>
                                    <td>None</td>
                                    <td>1 day</td>
                                    <td><i>Director for Extension & Training Services</i></td>
                                </tr>
                                <tr>
                                    <td>2. Prepare and conduct the training</td>
                                    <td>1. Facilitate the preparation up to conduct of the training</td>
                                    <td>None</td>
                                    <td>3 days</td>
                                    <td><i>Staff (UETS)</i></td>
                                </tr>
                                <tr>
                                    <td>3. Submit required documents</td>
                                    <td>1. Requires the proponent to submit documents after the conduct of training</td>
                                    <td>None</td>
                                    <td>3 days</td>
                                    <td><i>Staff (UETS)</i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>None</td>
                                    <td>9 days 3 minutes</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            

</section>

<section class="footer">
    <a href="" class="logo">
        <img src="../assets/logo.png" alt="QSU">
    </a>
    <div class="share">
        <a href="https://www.facebook.com/QSUOfficial" class="fab fa-facebook-f" title="Facebook"></a>
        <a href="https://qsu.edu.ph/info/" class="fas fa-envelope" title="Email"></a>
        <a href="#footer" class="fas fa-phone" title="0968-749-1111"></a>
        <a href="#footer" class="fab fa-whatsapp" title="+63-926-743-8144"></a>
    </div>
    <div class="credit">created by: <span>Florante Agustine, Ezekiel Cadiz, John Clyde FLores, Elene Homerez</span> | all rights reserved Copyright @2024.</div>
</section>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('search');

  const offices = [
    { id: 'officeRegistrar', name: 'Office of the Registrar' },
    { id: 'officeCashier', name: 'Office of the Cashier' },
    { id: 'knowledgeCenter', name: 'Knowledge Center' },
    { id: 'officeGuidance', name: 'Office of the Guidance Counselor' },
    { id: 'officeStudentAffairs', name: 'Office of Student Affairs Services' },
    { id: 'medicalServices', name: 'Medical Services' },
    { id: 'recordsCommunication', name: 'Records and Communication Office' },
    { id: 'alumni', name: 'Alumni' },
    { id: 'officeVPFinance', name: 'Office of the Vice President for Administration & Finance' },
    { id: 'procurementOffice', name: 'Procurement Office' },
    { id: 'supplyOffice', name: 'Supply Office' },
    { id: 'hrOffice', name: 'Human Resource Management Office' },
    { id: 'plantOffice', name: 'Physical Plant and Site Development Office' },
    { id: 'auxiliaryOffice', name: 'Auxiliary and Enterprise Development Office' },
    { id: 'misWebContent', name: 'Management Information System – Web Content' },
    { id: 'financeServices', name: 'Finance Services' },
    { id: 'researchDevelopment', name: 'Research & Development' },
    { id: 'extensionTraining', name: 'Extension & Training Services' }
  ];

  // Create suggestion box
  const suggestionBox = document.createElement('div');
  suggestionBox.className = 'suggestion-box';
  suggestionBox.style.position = 'absolute';
  suggestionBox.style.background = '#fff';
  suggestionBox.style.border = '1px solid #ccc';
  suggestionBox.style.width = '100%';
  suggestionBox.style.maxHeight = '200px';
  suggestionBox.style.overflowY = 'auto';
  suggestionBox.style.display = 'none';
  suggestionBox.style.zIndex = '1000';
  suggestionBox.style.borderRadius = '5px';
  suggestionBox.style.boxShadow = '0 2px 5px rgba(0,0,0,0.15)';
  searchInput.parentNode.appendChild(suggestionBox);

  function hideAllOffices() {
    offices.forEach(o => {
      const section = document.getElementById(o.id);
      if (section) section.style.display = 'none';
    });
  }

  function showOffice(id, shouldScroll = true) {
    hideAllOffices();
    const target = document.getElementById(id);
    if (target) {
      target.style.display = 'block';
      if (shouldScroll) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  }


    function handleOfficeLinkClick(event) {
        event.preventDefault(); 
        
        const officeId = event.currentTarget.getAttribute('data-office');
        
        if (officeId) {
            showOffice(officeId);
        }
    }

    const officeLinks = document.querySelectorAll('a[data-office]');


    officeLinks.forEach(link => {
        link.addEventListener('click', handleOfficeLinkClick);
    });

  // Function to show suggestions
  function showSuggestions(query) {
    const results = offices.filter(o => 
      o.name.toLowerCase().includes(query.toLowerCase())
    );

    suggestionBox.innerHTML = '';

    if (results.length === 0 || query.trim() === '') {
      suggestionBox.style.display = 'none';
      return;
    }

    results.forEach(result => {
      const item = document.createElement('div');
      item.textContent = result.name;
      item.style.padding = '10px';
      item.style.cursor = 'pointer';
      item.style.transition = 'background 0.2s';
      item.addEventListener('mouseover', () => item.style.background = '#f0f0f0');
      item.addEventListener('mouseout', () => item.style.background = 'white');
      item.addEventListener('click', () => {
        searchInput.value = result.name;
        suggestionBox.style.display = 'none';
        showOffice(result.id);
      });
      suggestionBox.appendChild(item);
    });

    suggestionBox.style.display = 'block';
  }

  // Typing event
  searchInput.addEventListener('input', e => {
    const query = e.target.value.trim();
    showSuggestions(query);
  });

  // Press Enter to go to closest match
  searchInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      const query = searchInput.value.trim().toLowerCase();
      const match = offices.find(o => o.name.toLowerCase().includes(query));
      if (match) {
        suggestionBox.style.display = 'none';
        showOffice(match.id);
      } else {
        alert('No office found matching "' + query + '".');
      }
    }
  });

  // Hide suggestions when clicking outside
  document.addEventListener('click', e => {
    if (!searchInput.contains(e.target) && !suggestionBox.contains(e.target)) {
      suggestionBox.style.display = 'none';
    }
  });

  // Show default office after DOM is ready and painted (without auto-scrolling down)
  setTimeout(() => {
    hideAllOffices();
    showOffice('officeRegistrar', false);
    window.scrollTo(0, 0);
    console.log("Default office shown: Registrar");
  }, 300);

});

document.querySelector('.my-element').innerHTML = '<i class="fa-solid fa-circle-plus"></i>';

</script>


<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>


