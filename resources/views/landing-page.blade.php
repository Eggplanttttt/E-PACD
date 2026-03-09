@if(Auth::check())
    @php
        header("Location: " . route('admin.dashboard'));
        exit();
    @endphp
@endif 

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Quirino State University | Electronic Public Assistance And Complaint Desk</title>
    <link rel="stylesheet" href="{{ asset('css/landing-page.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
</head>
<body>
    

<header class="header"> 
  <div class="logo-container">
      <a href="https://www.bagongpilipinastayo.com/" target="_blank" rel="noopener noreferrer" title="Bagong Pilipinas"><img src="{{ asset('assets/bagong-pilipinas_logo.png')}}" alt="bagong_pilipinas" class="bagong_pilipinas"></a>
      <a href="https://www.gov.ph/" target="_blank" rel="noopener noreferrer" class="gov" title="GOV.PH">GOV.PH</a>
      <a href="https://arta.gov.ph/" target="_blank" rel="noopener noreferrer" title="ARTA"><img src="{{ asset('assets/arta_logo.png')}}" alt="Arta" class="arta"></a>
    </div>


    <div class="logo-nav-container" style="display: flex; align-items: center; gap: 30px;">
        <nav class="navbar">
        <a href="#home" title="Home Page">Home</a>
        <a href="#about" title="About Page">About</a>
        </nav>
  
    <div class="icon">
        <div class="login-btn fa-solid fa-user" id="login" title="Login"></div>
        <div class="fas fa-bars" id="menu-btn" title="Menu"></div>
    </div>
  </div>
</header>


<section class="home" id="home">
  <div class="content">
    <div class="logo-text-container">
        <a href="https://qsu.edu.ph/info/" target="_blank" rel="noopener noreferrer">
      <img src="{{ asset('assets/logoo.png') }}" alt="QSU Logo" class="logo"></a>
      <div class="text">
        <h4>Welcome to <span class="underline">E-PACD</span></h4>
        <p>Electronic Public Assistance and Complaint Desk of Quirino State University Information Office.
        </p>
      </div>
    </div>

    <!-- BUTTON ADDED HERE -->
    <div class="home-button">
      <!-- Tooltip Popup -->
        <div id="assistance-tooltip" class="assistance-tooltip">
            <p id="tooltip-text">If you have some question you are free to ask here!</p>
            <div class="tooltip-arrow"></div>
        </div>
        <a href="{{ route('inquiries.page', ['skipModal' => 1]) }}" class="tooltip-btn">
            Start Inquiry
            <span class="tooltip-text">Sign up here for Inquiries!</span>
        </a>
        <a href="{{ route('inquiries.page') }}" class="tooltip-btn" id="assistance-btn">Assistance
            <span class="tooltip-text">Assistance</span>
        </a>
         <a href="{{ route('citizen.charter') }}" class="tooltip-btn">Citizen's Charter
            <span class="tooltip-text">Citizen's Charter</span>
         </a>
        <a href="{{ url('/feedback') }}" class="tooltip-btn">Feedback
        <span class="tooltip-text">Feedback</span>
        </a>
    </div>

    <a href="#" class="register-tutorial-link" data-bs-toggle="modal" data-bs-target="#registerTutorialModal">
      Tutorial on how to register!
    </a>
         

    <!-- Floating PNG -->
    <div class="floating-logo">
        <img src="{{ asset('assets/E-PACD-logo.png') }}" alt="Floating Logo">
    </div>

    
  
  <a href="#" class="scroll-down-indicator" id="scrollBottom">
    <span>Scroll Down</span>
    <div class="arrow"></div>
  </a>
</div>
<div class="waves"></div>
</section>




<section class="about" id="about">
    <div class="row">
        <div class="image">
            <img src="{{ asset('assets/about-img.jpg') }}" alt="about-image">
        </div>
        <div class="content">
            <h3>About the Public Assistance and Complaint Desk (PACD)</h3>
            <p>The Electronic Public Assistance and Complaint Desk (E-PACD) at Quirino State University Diffun Main Campus serves as a central hub for addressing inquiries, concerns, and grievances from students, parents, and staff.</p>
            <p>Our goal is to provide timely assistance, resolve issues effectively, and ensure a supportive and transparent school environment. Whether you need guidance, have feedback, or wish to report an issue, the E-PACD is here to help.</p>
        </div>
    </div>
</section>


<section class="feedback-section" id="feedback">
  <h1 class="heading">Feedback Form</h1>

  <div class="feedback-container">
    <div class="map-container">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.4157359339683!2d121.50378707412277!3d16.600721124992518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33900c24ef6ec685%3A0x2735a7478afb177!2sQuirino%20State%20University%2C%20Main%20Campus!5e1!3m2!1sen!2sph!4v1732026606353!5m2!1sen!2sph"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </div>

    <div class="image-container">
      <a href="{{ url('/feedback') }}">
        <img src="{{ asset('assets/csm.png') }}" alt="Feedback">
      </a>
    </div>
  </div>
</section>


<section class="footer">
    <a href="" class="logo">
        <img src="{{ asset('assets/logo.png') }}" alt="QSU">
    </a>

    <div class="share">
        <a href="https://www.facebook.com/QSUOfficial" class="fab fa-facebook-f" title="Facebook"></a>
        <a href="https://qsu.edu.ph/info/" class="fas fa-envelope" title="Email"></a>
        <a href="#footer" class="fas fa-phone" title="0968-749-1111"></a>
        <a href="#footer" class="fab fa-whatsapp" title="+63-926-743-8144"></a>
    </div>

    <div class="credit">Created By: <span>Florante Agustine, Ezekiel Cadiz, John Clyde FLores, Elene Homerez</span> | All Rights Reserved Copyright © 2026.</div>
</section>

<div class="form-popup">
    <button type="button" class="close-btn fa-solid fa-xmark" aria-label="Close"></button>

    <div class="form-box">
        <!-- LEFT: VISUAL -->
        <div class="form-details">
            <div class="vd-details-inner">
                <div class="vd-badge">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3>Secure Admin Access</h3>
                <p>Select your role and sign in to continue.</p>

                <ul class="vd-bullets">
                    <li><i class="fa-solid fa-check"></i> Role-based login</li>
                    <li><i class="fa-solid fa-check"></i> Audit-friendly access</li>
                    <li><i class="fa-solid fa-check"></i> Protected credentials</li>
                </ul>
            </div>
        </div>

        <!-- RIGHT: FORM -->
        <div class="form-content">
            <div class="vd-form-head">
                <h2>Administrator Login</h2>
                <p>Please enter your credentials to proceed.</p>
            </div>

            <form action="{{ route('admin.login.post') }}" method="POST" class="vd-form">
                @csrf

                <!-- ROLE DROPDOWN -->
                <div class="input-field select-field" id="roleField">
                    <select name="role" id="role" required>
                    <option value="" disabled selected hidden></option>
                    <option value="super_admin">Super Admin</option>
                    <option value="io">Information Office (IO)</option>
                    <option value="audit">Audit</option>
                </select>
                <label for="role">Select Role</label>
                <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                </div>

                <div class="input-field">
                    <input type="email" id="email" name="email" autocomplete="off" required placeholder>
                    <label>Email</label>
                </div>

                <div class="input-field">
                    <input type="password" id="password" name="password" autocomplete="current-password" required placeholder>
                    <label for="password">Password</label>

                    <button type="button" class="vd-eye" id="togglePassword" aria-label="Toggle password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="vd-btn">
                    <span>Login</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <div class="vd-help">
                    <i class="fa-solid fa-circle-info"></i>
                    <small>Make sure you selected the correct role before logging in.</small>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- ROLE SELECT -->
                    {{-- <div  class="input-field">
                        <select id="roleselect" name="role" required>
                            <option value="" disabled selected hidden>Select Role</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="io">IO</option>
                            <option value="audit">Audit</option>
                        </select>
                    </div> --}}

<!-- Bootstrap Modal for Login Failed -->
<div class="modal fade" id="loginFailedModal" tabindex="-1" aria-labelledby="loginFailedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-m modal-top"> <!-- smaller and top positioned -->
    <div class="modal-content custom-login-failed-modal">
      <div class="modal-header bg-danger text-white py-3">
        <h5 class="modal-title w-100 text-center fs-2" id="loginFailedModalLabel">
          Login Failed!
        </h5>
      </div>
      <div class="modal-body text-center py-3 fs-3">
        Invalid email or password! <br>Please try again.
      </div>
      <div class="modal-footer justify-content-center py-2">
        <button type="button" class="btn btn-danger btn-md px-5 fs-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Registration Tutorial Modal -->
<div class="modal fade tutorial-modal" id="registerTutorialModal" tabindex="-1" aria-labelledby="registerTutorialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content tutorial-modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerTutorialModalLabel">Tutorial: How to Register (New Clients)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="tutorial-intro">
          Follow these steps to register before using the Assistance form.
        </p>

        <div class="tutorial-steps">
          <div class="tutorial-step">
            <h6>Step 1: Start Inquiry</h6>
            <p>From the landing page, click <strong>Start Inquiry</strong>.</p>
            <img src="{{ asset('assets/step1.png') }}" alt="Step 1 - Start Inquiry button" loading="lazy">
          </div>

          <div class="tutorial-step">
            <h6>Step 2: Select Client Type</h6>
            <p>Choose your client type from the dropdown (Student, Faculty/Staff, Alumni, or Others).</p>
            <img src="{{ asset('assets/step2.png') }}" alt="Step 2 - Client type dropdown" loading="lazy">
          </div>

          <div class="tutorial-step">
            <h6>Step 3: Enter Email and Send OTP</h6>
            <p>Enter your email and click <strong>Send OTP</strong>. Check your email inbox for the code.</p>
            <img src="{{ asset('assets/step3.png') }}" alt="Step 3 - Send OTP" loading="lazy">
            <img src="{{ asset('assets/step3.1.png') }}" alt="Step 3 - Send OTP" loading="lazy">
          </div>

          <div class="tutorial-step">
            <h6>Step 4: Verify OTP</h6>
            <p>Input the OTP in the verify field, then click <strong>Verify OTP</strong>.</p>
            <img src="{{ asset('assets/step4.png') }}" alt="Step 4 - Verify OTP input" loading="lazy">
          </div>

          <div class="tutorial-step">
            <h6>Step 5: Fill Out Registration Form</h6>
            <p>After verification, complete all required registration fields.</p>
            <img src="{{ asset('assets/step5.png') }}" alt="Step 5 - Registration form" loading="lazy">
          </div>

          <div class="tutorial-step">
            <h6>Step 6: Accept Data Privacy and Register</h6>
            <p>Read and accept the Data Privacy Policy, then click <strong>Register</strong>.</p>
            <img src="{{ asset('assets/step6.png') }}" alt="Step 6 - Data privacy and register button" loading="lazy">
          </div>

          <div class="tutorial-step">
            <h6>Step 7: Continue to Login</h6>
            <p>Once successfully registered, log in from <strong>Assistance</strong> on the landing page or from the login form directly.</p>
            <img src="{{ asset('assets/step7.png') }}" alt="Step 7 - Successful registration and login" loading="lazy">
            <img src="{{ asset('assets/step8.png') }}" alt="Step 7 - Successful registration and login" loading="lazy">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="{{ route('inquiries.page', ['skipModal' => 1]) }}" class="btn btn-success">Start Inquiry Now</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- FLOATING FAQ BUTTON -->
<div id="faqButton" class="tooltip-btn">💬<span class="tooltip-text">FAQ</span></div>
<button id="scrollTopBtn" type="button" aria-label="Scroll to top" title="Scroll to top">
    <i class="fa-solid fa-arrow-up"></i>
</button>

<!-- FAQ CHAT BOX -->
<div id="faqChatBox">
    <div class="faq-header">
        FAQ Assistant
        <span id="faqClose" style="cursor:pointer;">&times;</span>
    </div>

    <div class="faq-body" id="faqBody">
    </div>

    <div class="faq-input">
        <input type="text" id="faqInput" placeholder="Type here..." />
    </div>
</div>




<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@if(session('login_failed'))
<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ===============================
       ROLE SELECT FLOAT LABEL (FIXED)
    =============================== */
    const role = document.getElementById("role");
    const roleField = document.getElementById("roleField");

    function updateRoleUI() {
        if (!role || !roleField) return;

        // Filled when NOT the first option
        const isFilled = role.selectedIndex > 0 && role.value !== "";
        roleField.classList.toggle("filled", isFilled);
    }

    // Update on everything relevant
    role?.addEventListener("change", () => {
        updateRoleUI();
        // some browsers update selectedIndex/value a beat later
        setTimeout(updateRoleUI, 0);
    });
    role?.addEventListener("blur", updateRoleUI);
    role?.addEventListener("input", updateRoleUI);

    // Initial check on load
    updateRoleUI();



//     /* ===============================
//        PASSWORD SHOW / HIDE TOGGLE
//     =============================== */
//     const pw = document.getElementById("password");
//     const toggle = document.getElementById("togglePassword");

//     toggle?.addEventListener("click", function () {
//         if (!pw) return;

//         const isPw = pw.type === "password";
//         pw.type = isPw ? "text" : "password";

//         const icon = toggle.querySelector("i");
//         if (icon) icon.className = isPw ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
//     });

});


</script>
@endif

<script src="{{ asset('js/script.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  /* === ABOUT SECTION === */
  const aboutSection = document.querySelector('.about');
  if (aboutSection) {
    const aboutImage = aboutSection.querySelector('.image');
    const aboutContent = aboutSection.querySelector('.content');

    function revealAboutSection() {
      const triggerBottom = window.innerHeight * 0.85;
      const sectionTop = aboutSection.getBoundingClientRect().top;

      if (sectionTop < triggerBottom) {
        aboutImage.classList.add('show');
        setTimeout(() => aboutContent.classList.add('show'), 300);
        window.removeEventListener('scroll', revealAboutSection);
      }
    }

    window.addEventListener('scroll', revealAboutSection);
    revealAboutSection();
  }

  /* === FEEDBACK SECTION === */
  const feedbackSection = document.querySelector('.feedback-section');
  if (feedbackSection) {
    const heading = feedbackSection.querySelector('.heading');
    const map = feedbackSection.querySelector('.map-container iframe');
    const image = feedbackSection.querySelector('.image-container img');

    function revealFeedbackSection() {
      const triggerBottom = window.innerHeight * 0.85;
      const sectionTop = feedbackSection.getBoundingClientRect().top;

      if (sectionTop < triggerBottom) {
        heading.classList.add('show');
        setTimeout(() => map.classList.add('show'), 200);  // map from left
        setTimeout(() => image.classList.add('show'), 400); // image from right
        window.removeEventListener('scroll', revealFeedbackSection);
      }
    }

    window.addEventListener('scroll', revealFeedbackSection);
    revealFeedbackSection();
  }
});

/* === PASSWORD TOGGLE === */
// document.addEventListener('DOMContentLoaded', function() {
//   const passwordInput = document.getElementById('password');
//   const togglePassword = document.getElementById('togglePassword');

//   if (passwordInput && togglePassword) {
//     togglePassword.addEventListener('click', function() {
//       const isPassword = passwordInput.type === 'password';
//       passwordInput.type = isPassword ? 'text' : 'password';
//       this.classList.toggle('fa-eye');
//       this.classList.toggle('fa-eye-slash');
//     });
//   }
// });

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('assistance-btn'); 
    const tooltip = document.getElementById('assistance-tooltip');

    const messages = [
        "If you have some question you are free to ask here!",
        "If you have a problem we can assist you here!",
        "Need guidance? We are here to help!",
        "Questions or concerns? Click here!",
        "Having trouble? Let us guide you!",
        "We can help with inquiries and complaints!",
        "Feel free to ask anything you need assistance with!",
        "Our team is ready to assist you anytime!",
        "Need support? Start here!",
        "Your issues matter—let us help!",
        "Click here for quick assistance!",
        "We're here to answer your questions!",
        "Problems? We’re just a click away!",
        "Looking for help? We’ve got you covered!",
        "Assistance is available here—reach out!"
    ];

    let index = 0;

    function positionTooltip() {
        const rect = btn.getBoundingClientRect();
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const scrollLeft = window.scrollX || document.documentElement.scrollLeft;

        // Position tooltip above the button and centered
        tooltip.style.top = scrollTop + rect.top - tooltip.offsetHeight - 10 + 'px';
        tooltip.style.left = scrollLeft + rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + 'px';
    }

    function showTooltip() {
        tooltip.querySelector('#tooltip-text').textContent = messages[index];

        tooltip.classList.add('show');
        tooltip.classList.remove('hide');

        // Position after it becomes visible
        requestAnimationFrame(() => {
            positionTooltip();
        });

        // Hide after 5 seconds
        setTimeout(() => {
            tooltip.classList.add('hide');
            tooltip.classList.remove('show');
        }, 5000);

        index = (index + 1) % messages.length;
    }

    // Initial show and rotate every 15 seconds
    showTooltip();
    setInterval(showTooltip, 15000);

    // Reposition on scroll or resize
    window.addEventListener('scroll', positionTooltip);
    window.addEventListener('resize', positionTooltip);
});

const faqs = [
    { q: "What are your office hours?", a: "Our office hours are 8:00 AM to 5:00 PM, Monday to Friday." },
    { q: "How to file a complaint?", a: "Go to Assistance → Complaints and submit details." },
    { q: "Where can I give feedback?", a: "You can submit feedback through the Feedback page." },
    { q: "Do I need to take an entrance exam?", a: "Yes, all incoming freshmen must take the QSU College Admission Test (QSU-CAT)." },
    { q: "What are the requirements for enrolling as a freshman or transferee?", a: "DOCUMENTARY REQUIREMENTS: Certificate of Transfer Credentials, Certificate of Grades, Certificate of Good Moral Character, PSA Birth Certificate, PSA Marriage Certificate (if married). Bring originals and photocopies, 4 pcs 2x2 ID picture, long brown folder." },
    { q: "What courses or degree programs are offered at this university?", a: "COLLEGE OF TEACHER EDUCATION: BEE, BSE, BTLED. COLLEGE OF AGRICULTURE, FORESTRY & ENGINEERING: CAS-BSA, BSABE, BS Forestry. COLLEGE OF IT & COMPUTING SCIENCES: BSIT, BS OA. COLLEGE OF PUBLIC SAFETY: BS Criminology. COLLEGE OF HEALTH SCIENCES: BS Nutrition and Dietetics, Caregiving NC II. COLLEGE OF HOSPITALITY & INDUSTRY MANAGEMENT: BS Hospitality, BS Tourism." }
];

const faqButton = document.getElementById("faqButton");
const faqChatBox = document.getElementById("faqChatBox");
const faqClose = document.getElementById("faqClose");
const faqBody = document.getElementById("faqBody");
const faqInput = document.getElementById("faqInput");

// Open/close chat
faqButton.onclick = () => openFaq();
faqClose.onclick = () => closeFaq();

function openFaq() {
    faqChatBox.style.display = "flex";
    faqButton.style.display = "none";
    faqBody.innerHTML = ""; // reset chat
    showTypingMessage("Can I help you?", 50, showYesNoOptions);
}

function closeFaq() {
    faqChatBox.style.display = "none";
    faqButton.style.display = "flex";
    faqBody.innerHTML = "";
}

// Add message to chat
function addMessage(text, sender="bot") {
    const div = document.createElement("div");
    div.className = "faq-message " + sender;
    div.innerHTML = text;
    faqBody.appendChild(div);
    faqBody.scrollTop = faqBody.scrollHeight;
}

// Typing animation
function showTypingMessage(text, speed, callback, isHTML = false) {
    let i = 0;
    const msgDiv = document.createElement('div');
    msgDiv.classList.add('faq-message', 'bot');
    faqBody.appendChild(msgDiv);

    // If it's HTML, show it instantly (can't animate HTML safely character by character)
    if (isHTML) {
        msgDiv.innerHTML = text;
        faqBody.scrollTop = faqBody.scrollHeight;
        if (callback) callback();
        return;
    }

    // Typing animation for plain text
    const typingInterval = setInterval(() => {
        msgDiv.textContent += text[i];
        i++;
        faqBody.scrollTop = faqBody.scrollHeight;
        if (i >= text.length) {
            clearInterval(typingInterval);
            if (callback) callback();
        }
    }, speed);
}


// Show initial Yes/No buttons
function showYesNoOptions() {
    const optionsDiv = document.createElement("div");
    optionsDiv.className = "faq-options";
    optionsDiv.innerHTML = `
        <button onclick="faqStart(true)">Yes</button>
        <button onclick="faqStart(false)">No</button>
    `;
    faqBody.appendChild(optionsDiv);
    faqBody.scrollTop = faqBody.scrollHeight;
}

function faqStart(yes) {
    const options = document.querySelector(".faq-options");
    if (options) options.remove();

    if (!yes) {
        showTypingMessage("No problem 😊 If you need help later, just click me!");
        return;
    }

    showTypingMessage("Great! Please choose a topic below:", 30, showFaqButtons);
}

// Show main FAQ buttons
function showFaqButtons() {
    const container = document.createElement("div");
    container.className = "faq-button-group";

    faqs.forEach(item => {
        const btn = document.createElement("button");
        btn.className = "faq-question-btn";
        btn.innerText = item.q;

        btn.onclick = () => {
            addMessage(item.q, "user");
            showTypingMessage(item.a, 30, showFollowUpOptions);
            container.remove();
        };

        container.appendChild(btn);
    });

    faqBody.appendChild(container);
    faqBody.scrollTop = faqBody.scrollHeight;
}

// Show follow-up options after answering
function showFollowUpOptions() {
    showTypingMessage("Do you have another question I can help with? 😊", 30, () => {
        const followUp = document.createElement("div");
        followUp.className = "faq-button-group";

        const anotherBtn = document.createElement("button");
        anotherBtn.className = "faq-question-btn";
        anotherBtn.innerText = "📌 View more FAQs";
        anotherBtn.onclick = () => {
            followUp.remove();
            showFaqButtons();
        };

        const signupBtn = document.createElement("button");
        signupBtn.className = "faq-question-btn signup-btn";
        signupBtn.innerText = "📝 Sign up for more assistance";
        signupBtn.onclick = () => {
            window.location.href = "/inquiries?skipModal=1";
        };

        followUp.appendChild(anotherBtn);
        followUp.appendChild(signupBtn);
        faqBody.appendChild(followUp);
        faqBody.scrollTop = faqBody.scrollHeight;
    });
}

// Handle input field Enter
faqInput.addEventListener("keypress", function(e) {
    if (e.key === "Enter" && this.value.trim() !== "") {
        addMessage(this.value, "user");
       showTypingMessage(
        'For more inquiries and to guide you more, please <a href="/inquiries?skipModal=1">sign up here</a>.',
        30,
        null,
        true // 👈 this tells it to render HTML
    );

        this.value = "";
    }
});

document.getElementById("scrollBottom").addEventListener("click", function(e) {
    e.preventDefault();

    const start = window.scrollY;
    const end = document.body.scrollHeight;
    const distance = end - start;
    const duration = 1400; // smaller = faster, larger = slower
    let startTime = null;

    function smoothScroll(timestamp) {
        if (!startTime) startTime = timestamp;
        const progress = timestamp - startTime;

        const ease = progress / duration;
        const easeInOut = ease < 0.5
            ? 2 * ease * ease
            : 1 - Math.pow(-2 * ease + 2, 2) / 2;

        window.scrollTo(0, start + distance * easeInOut);

        if (progress < duration) {
            requestAnimationFrame(smoothScroll);
        } else {
            window.scrollTo(0, end);
        }
    }

    requestAnimationFrame(smoothScroll);
});

const scrollTopBtn = document.getElementById("scrollTopBtn");
let isAutoScrollingUp = false;

function toggleScrollTopButton() {
    if (!scrollTopBtn) return;
    scrollTopBtn.classList.toggle("show", window.scrollY > 320);
}

window.addEventListener("scroll", toggleScrollTopButton);
window.addEventListener("load", toggleScrollTopButton);

scrollTopBtn?.addEventListener("click", function () {
    if (isAutoScrollingUp) return;

    const start = window.scrollY;
    const end = 0;
    const distance = end - start;
    const duration = 1400;
    let startTime = null;
    isAutoScrollingUp = true;

    function smoothScrollUp(timestamp) {
        if (!startTime) startTime = timestamp;
        const progress = timestamp - startTime;

        const ease = progress / duration;
        const easeInOut = ease < 0.5
            ? 2 * ease * ease
            : 1 - Math.pow(-2 * ease + 2, 2) / 2;

        window.scrollTo(0, start + distance * easeInOut);

        if (progress < duration) {
            requestAnimationFrame(smoothScrollUp);
        } else {
            window.scrollTo(0, end);
            isAutoScrollingUp = false;
        }
    }

    requestAnimationFrame(smoothScrollUp);
});
</script>


<script>
document.addEventListener("DOMContentLoaded", () => {
  const pw = document.getElementById("password");
  const toggle = document.getElementById("togglePassword");
  const icon = toggle?.querySelector("i");

  if (!pw || !toggle) return;

  toggle.addEventListener("click", () => {
    const show = pw.type === "password";
    pw.type = show ? "text" : "password";

    if (icon) {
      icon.classList.toggle("fa-eye", !show);
      icon.classList.toggle("fa-eye-slash", show);
    }
  });
});
</script>

</body>
</html>
