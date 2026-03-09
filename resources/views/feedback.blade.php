<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quirino State University | "Electronic Public Assistance And Complaint Desk"</title>
    <link rel="icon" href="{{ asset('../assets/shortcut_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('../assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/feedback.css') }}">
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

<div class="csm-container">
    <form action="{{ route('feedback.submit') }}" method="POST" class="csm-form">
        @csrf
        <div class="csm-header">
            <img src="{{ asset('assets/shortcut_logo.png') }}" alt="Logo" class="csm-logo">
            <div class="csm-header-text">
                <p>Republic of the Philippines</p>
                <p class="bold">QUIRINO STATE UNIVERSITY</p>
                <p>Diffun, Quirino</p>
                <p class="italic">Molding Minds, Shaping Future</p>
            </div>
        </div>

        <h2 class="form-title">Client Satisfaction Measurement (CSM)</h2>
        <h4 class="form-subtitle">HELP US SERVE YOU BETTER!</h4><br>
        <p class="form-description">
            This Client Satisfaction Measurement (CSM) tracks the customer experience of government offices. Your feedback on your <span style="text-decoration: underline;">recently concluded transaction</span> will help this office provide a better service. Personal Information shared will be kept confidential and you always have the option to not this form.
        </p><br>

        <div class="radio-group client-type">
            <p><strong>Client Type:</strong></p>
            <label><input type="radio" name="client_type" value="Student" required> Student</label>
            <label><input type="radio" name="client_type" value="Faculty" required> Faculty</label>
            <label><input type="radio" name="client_type" value="Staff" required> Staff</label>
            <label><input type="radio" name="client_type" value="Government (another agency)" required> Government (another agency)</label>
            <label><input type="radio" name="client_type" value="Guest" required> Guest</label>
            <label><input type="radio" name="client_type" value="Alumni" required> Alumni</label>
            <label><input type="radio" name="client_type" value="Supplier" required> Supplier</label>

            <p><strong>Date:</strong> 
                <input type="date" name="date" class="date-input" required>
            </p> 
        </div>

        <div class="info-row">   
            <p><strong>Campus Transacted:</strong> <u class="input-line">Diffun - Campus</u></p>
            <div class="radio-group">
                <p><strong>Sex:</strong></p>
                <label><input type="radio" name="sex_type" value="Male"> Male</label>
                <label><input type="radio" name="sex_type" value="Female"> Female</label>
            </div>
            <p><strong>Age:</strong> 
                <input 
                    type="text" 
                    name="age" 
                    class="age-input-line" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    title="Please enter a valid number."
                    autocomplete="off"
                />
            </p>  
            
            <p><strong>Contact No.:</strong> 
                <input 
                    type="tel" 
                    name="contact_no" 
                    class="input-line"
                    minlength="11" 
                    maxlength="11" 
                    pattern="[0-9]{11}" 
                    title="Please enter exactly 11 digits."
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    autocomplete="off"
                />
            </p>
        </div>

        <div class="info-row">
            <p><strong>Service Availed (Write only the code):</strong> 
                <input type="text" name="service_availed" class="input-line" autocomplete="off" />
            </p>
        </div>
        
        <p class="note">(*Select the code of service availed posted in front of the office transacted.)</p><br><br>

        <p class="form-instruction">
            INSTRUCTION: <strong>Choose </strong> your answer to the <strong>Citizen's Charter(CC)</strong> questions.The Citizen's Charter is an official document that reflects the service of a government agency/office including its requirements, fees, and processing times among others.
        </p><br>

        <div class="question-group">
            <p class="cc1">CC1</p>
            <div class="question-block">
                <p>Which of the following best describes your awareness of a CC?</p>
                <label><input type="radio" name="CC1" value="1" required> 1. I know what a CC is and I saw this office's CC.</label><br>
                <label><input type="radio" name="CC1" value="2" required> 2. I know what a CC is but NOT see this office's CC.</label><br>
                <label><input type="radio" name="CC1" value="3" required> 3. I learned of the CC only when I saw this offices's CC.</label><br>
                <label><input type="radio" name="CC1" value="4" required> 4. I do not know what a CC is and I did not see one in the office.</label>
            </div>
        </div>

        <div class="question-group">
            <p class="cc2">CC2</p>
            <div class="question-block">
                <p>If aware of CC (answered 1-3 on CC1), would you say that the CC of this office was ...?</p>
                <label><input type="radio" name="CC2" value="1" required> 1. Easy to see</label><br>
                <label><input type="radio" name="CC2" value="2" required> 2. Somewhat easy to see</label><br>
                <label><input type="radio" name="CC2" value="3" required> 3. Difficult to see</label><br>
                <label><input type="radio" name="CC2" value="4" required> 4. Not visible at all</label><br>
                <label><input type="radio" name="CC2" value="5" required> 5. N/A</label>
            </div>
        </div>

        <div class="question-group">
            <p class="cc3">CC3</p>
            <div class="question-block">
                <p>If aware of CC (answered 1-3 on CC1), how much did the CC help you in your transaction?</p>
                <label><input type="radio" name="CC3" value="1"> 1. Helped very much</label><br>
                <label><input type="radio" name="CC3" value="2"> 2. Somewhat helped</label><br>
                <label><input type="radio" name="CC3" value="3"> 3. Did not help</label><br>
                <label><input type="radio" name="CC3" value="4"> 4. N/A</label>
            </div>
        </div>

        <br>

        <p class="form-instruction"><strong>INSTRUCTIONS:</strong></p>
        <p class="note">For SQD 0-8, please <strong>choose</strong> on the column that best corresponds to your answer.</p>

        <table class="survey-table">
            <thead>
            <tr>
                <th>Criteria</th>
                @php
                    $icons = [
                        ['icon' => 'fa-face-angry', 'color' => 'text-danger', 'label' => 'Strongly Disagree'],
                        ['icon' => 'fa-frown', 'color' => 'text-warning', 'label' => 'Disagree'],
                        ['icon' => 'fa-meh', 'color' => 'text-secondary', 'label' => 'Neither Agree nor Disagree'],
                        ['icon' => 'fa-smile', 'color' => 'text-success', 'label' => 'Agree'],
                        ['icon' => 'fa-laugh', 'color' => 'text-primary', 'label' => 'Strongly Agree']
                    ];
                @endphp

                @foreach($icons as $icon)
                    <th style="text-align:center;">
                        <i class="fa-solid {{ $icon['icon'] }} {{ $icon['color'] }}" style="font-size:20px;"></i><br>
                        <span class="rating-label">{{ $icon['label'] }}</span>
                    </th>
                @endforeach
            </tr>
        </thead>

            
            <tbody>
                @php
                    $questions = [
                        "I am satisfied with the service that I availed. (Satisfaction)",
                        "I spent a reasonable amount of time for my transaction. (Responsive)",
                        "The office followed the transaction's requirements and steps based on the information provided. (Reliability)",
                        "The steps (including payment) I needed to do for my transaction were easy and simple. (Access and Facilities)",
                        "I easily found information about my transaction from the office or its website. (Communication)",
                        "I paid a reasonable amount of fees for my transaction. (Cost)",
                        "I feel the office was fair to everyone, or 'walang palakasan', during my transaction. (Integrity)",
                        "I was treated courteously by the staff, and (if asked for help) the staff was helpful. (Assurance)",
                        "I got what I needed from the government office, or (if denied) denial of request was sufficiently explained to me. (Outcome)"
                    ];
                @endphp
        
                @foreach ($questions as $index => $question)
                    <tr style="font-size: 16px;">
                        <td style="text-align: left; padding: 10px;">
                            <strong>SQD{{ $index }}.</strong> {{ $question }}
                        </td>
                        @for ($i = 1; $i <= 5; $i++)
                            <td style="text-align: center; vertical-align: middle;">
                                <input 
                                    type="radio" 
                                    name="sqd_answers[{{ $index }}]" 
                                    value="{{ $i }}" 
                                    style="transform: scale(1.5); margin: 5px;"
                                    @if($i == 1) required @endif
                                >
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>

        <label for="comments"><strong>Suggestions on how we can further improve our services (optional):</strong></label><br>
        <textarea name="comments" class="textarea-line" autocomplete="off"></textarea><br>

        <label for="email_address"><strong>Email address :</strong></label><br>
        <input type="email" name="email_address" id="email_address" class="email-input-line" autocomplete="off" required />

        <!-- Button to open Gmail chooser modal -->
        <a href="javascript:void(0);" id="chooseGmailBtnOthers" class="google-btn">
            <i class="fab fa-google"></i> Choose Gmail
        </a><br><br>

        <h2 class="form-title">THANK YOU!</h2>

        <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>
</div>


<div id="feedbackModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Notification</h5>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <p><strong>There was an error:</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

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
    document.addEventListener("DOMContentLoaded", function() {
    const menuBtn = document.getElementById("menu-btn");
    const navbar = document.getElementById("navbar");

    menuBtn.addEventListener("click", () => {
        navbar.classList.toggle("active");
    });
    });

    function closeModal() {
        document.getElementById("feedbackModal").style.display = "none";
    }
    
    // Show modal if there's a success message or errors
    window.onload = function () {
        @if (session('success') || $errors->any())
            document.getElementById("feedbackModal").style.display = "block";
        @endif
    };


    const gmailBtn = document.getElementById('chooseGmailBtnOthers');
const emailInput = document.getElementById('email_address');

gmailBtn.addEventListener('click', () => {
    const width = 500;
    const height = 600;
    const left = (screen.width/2)-(width/2);
    const top = (screen.height/2)-(height/2);

    const popup = window.open(
        "{{ route('google.login') }}?clientType=others",
        "GoogleLogin",
        `width=${width},height=${height},top=${top},left=${left}`
    );
});

// Listen for postMessage from popup
window.addEventListener('message', function(event) {
    if (event.data && event.data.google_email) {
        emailInput.value = event.data.google_email;
    }
}, false);
</script>
</body> 
</html>
