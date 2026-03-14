    @extends('layouts.feedback-management')

    @php
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
    @endphp

    @section('title', 'Audit Feedback')

    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/audit-feedback.css') }}">
    @endsection

    @section('content')

    {{-- SIDEBAR (Audit) --}}
    <div class="sidebar" id="mobileSidebar">
        <div class="side-content">
            <div class="profile">
                <div class="profile-image">
                    <img src="{{ asset('assets/logoo.png') }}" class="rounded-circle" width="100" height="100">
                </div>
                <h4>E-PACD</h4>
                <small>Audit</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li><a href="{{ route('audit.dashboard') }}"><span class="fa-solid fa-house"></span><small>Dashboard</small></a></li>
                    <li><a href="{{ route('audit.profile') }}"><span class="fa-regular fa-user"></span><small>Profile</small></a></li>
                    <li><a href="{{ route('audit.complaints.index') }}"><span class="fa-regular fa-envelope"></span><small>Complaints</small></a></li>
                    <li><a href="{{ route('audit.feedback.index') }}" class="active" aria-current="page"><span class="fa-solid fa-comments"></span><small>Feedback</small></a></li>
                    <li>
                        <button type="button" id="themeToggleBtn" class="theme-toggle-btn">
                            <span id="themeToggleIcon" class="fa-regular fa-moon"></span>
                            <small id="themeToggleText">Dark Mode</small>
                        </button>
                    </li>
                    <li class="sidebar-logout">
                        <form action="{{ route('audit.logout') }}" method="POST">
                            @csrf
                            <button type="submit">
                                <span class="fa-solid fa-sign-out-alt"></span>
                                <small>Logout</small>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <button type="button" id="menuOverlay" class="menu-overlay d-lg-none" aria-label="Close menu" onclick="closeMobileMenu()" onpointerup="closeMobileMenu()"></button>

    <div class="main-content">
        <header>
            <div class="header-content">
                <button type="button" class="menu-toggle d-lg-none" aria-label="Open menu" onclick="toggleMobileMenu()" onpointerup="toggleMobileMenu()">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </header>

        <main class="page-shell">

        <div class="page-top">
            <div class="page-title">
                <h1>Feedback</h1>
                <p>Manage and review client satisfaction submissions</p>
            </div>

            <div class="page-tools">
                @php
                    $defaultStartDate = request('start_date', now()->startOfMonth()->toDateString());
                    $defaultEndDate = request('end_date', now()->toDateString());
                @endphp
                <form method="GET" action="{{ route('audit.feedback.export.excel') }}" class="export-tools">
                    <div class="date-field">
                        <label for="startDate">From</label>
                        <input type="date" id="startDate" name="start_date" value="{{ $defaultStartDate }}" required>
                    </div>
                    <div class="date-field">
                        <label for="endDate">To</label>
                        <input type="date" id="endDate" name="end_date" value="{{ $defaultEndDate }}" required>
                    </div>
                    <button type="submit" class="btn-export-excel">
                        <i class="fa-solid fa-file-excel"></i> Export Excel
                    </button>
                </form>
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="feedbackFilter" placeholder="Search feedback…" />
                </div>
            </div>
        </div>

        <div class="page-card">
            <div class="card-head">
                <div class="card-head-left">
                    <h3>Chat Ratings</h3>
                    <small>Quick 5-star ratings submitted during client logout</small>
                </div>
            </div>

            <div class="table-wrap mb-4">
                <table class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>Client Type</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Stars</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chatRatings as $rating)
                            <tr>
                                <td data-label="Client Type"><div class="cell-strong">{{ $rating->client_type }}</div></td>
                                <td data-label="Name">{{ $rating->client_name ?? 'N/A' }}</td>
                                <td data-label="Email">{{ $rating->client_email ?? 'N/A' }}</td>
                                <td><span class="pill">{{ str_repeat('★', (int) $rating->stars) }}</span></td>
                                <td data-label="Date">{{ $rating->created_at?->format('Y-m-d h:i A') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No chat ratings yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-head">
                <div class="card-head-left">
                    <h3>Feedback Summary</h3>
                    <small>Client Type • Date • Average Rate</small>
                </div>
            </div>

            <div class="table-wrap">
                <table id="table-feedback" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>Client Type</th>
                            <th>Date</th>
                            <th>Average Rate</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- your existing tbody loop stays the same --}}
                        @php
                            $ratingMap = [
                                5 => 'Strongly Agree',
                                4 => 'Agree',
                                3 => 'Neutral',
                                2 => 'Disagree',
                                1 => 'Strongly Disagree'
                            ];
                        @endphp

                        @foreach($feedbacks as $feedback)
                            @php
                                $surveyAnswers = json_decode($feedback->sqd_answers, true) ?? [];
                                $total = array_sum($surveyAnswers);
                                $average = round($total / 9, 2);
                                $averageWord = $ratingMap[round($average)] ?? 'N/A';
                            @endphp
                            <tr>
                                <td data-label="Client Type">
                                    <div class="cell-strong">{{ $feedback->client_type }}</div>
                                </td>
                                <td data-label="Date">{{ $feedback->date }}</td>
                                <td data-label="Average Rate">
                                    <span class="pill">{{ $averageWord }}</span>
                                </td>
                                <td class="text-center" data-label="Actions">
                                    <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#view-{{ $feedback->id }}">
                                        <i class="fa-regular fa-eye me-1"></i> View
                                    </button>
                                </td>
                            </tr>

                            <!-- View Feedback Modal -->
                            <div class="modal fade" id="view-{{ $feedback->id }}" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" id="feedback-modal-{{ $feedback->id }}">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Feedback Details</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Client Type:</strong> {{ $feedback->client_type }}</p>
                                            <p><strong>Date:</strong> {{ $feedback->date }}</p>
                                            <p><strong>Sex:</strong> {{ $feedback->sex_type ?? 'N/A' }}</p>
                                            <p><strong>Age:</strong> {{ $feedback->age ?? 'N/A' }}</p>
                                            <p><strong>Campus Transacted:</strong> Diffun - Campus</p>
                                            <p><strong>Contact Number:</strong> {{ $feedback->contact_no ?? 'N/A' }}</p>
                                            <p><strong>Service Availed:</strong> {{ $feedback->service_availed ?? 'N/A' }}</p>
                                            <p><strong>CC1:</strong> {{ $feedback->CC1 ?? 'N/A' }}</p>
                                            <p><strong>CC2:</strong> {{ $feedback->CC2 ?? 'N/A' }}</p>
                                            <p><strong>CC3:</strong> {{ $feedback->CC3 ?? 'N/A' }}</p>
                                            <hr>
                                            <strong>Survey Answers:</strong>
                                            <ul>
                                                @foreach ($surveyAnswers as $index => $value)
                                                    @php
                                                        $questionNum = $index + 1;
                                                        $meaning = $ratingMap[$value] ?? 'N/A';
                                                    @endphp
                                                    <li><strong>SQD{{ $questionNum }}:</strong> {{ $meaning }} ({{ $value }})</li>
                                                @endforeach
                                            </ul>
                                            <p><strong>Survey Average:</strong> {{ $averageWord }}</p>
                                            <hr>
                                            <p><strong>Comments:</strong> {{ $feedback->comments ?? 'N/A' }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Print Button -->
                                            <button type="button" class="btn btn-secondary"
                                                onclick="generatePrintable({
                                                    id: '{{ $feedback->id }}',
                                                    client_type: '{{ $feedback->client_type }}',
                                                    date: '{{ $feedback->date }}',
                                                    sex_type: '{{ $feedback->sex_type }}',
                                                    age: '{{ $feedback->age }}',
                                                    campus: 'Diffun - Campus',
                                                    contact: '{{ $feedback->contact_no ?? 'N/A' }}',
                                                    service: '{{ $feedback->service_availed ?? 'N/A' }}',
                                                    cc1: '{{ $feedback->CC1 ?? '' }}',
                                                    cc2: '{{ $feedback->CC2 ?? '' }}',
                                                    cc3: '{{ $feedback->CC3 ?? '' }}',
                                                    survey: `{{ json_encode(json_decode($feedback->sqd_answers), JSON_PRETTY_PRINT) }}`,
                                                    average: '{{ $averageWord }}',
                                                    comments: '{{ $feedback->comments ?? 'N/A' }}'
                                                }, true)">
                                                <i class="fa-solid fa-print"></i> Print
                                            </button>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </main>


    <!-- PRINT TEMPLATE -->
    <div id="print-template" style="display:none; font-family: Arial, sans-serif; font-size: 12px;">

        <head>
            <style>
                @media print {
                    @page {
                        size: 8.5in 13in; /* long bond */
                        margin: 0.5in;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        color: #000;
                        background: #fff !important;
                    }
                    #print-template {
                        display: block !important;
                        width: 100%;
                    }
                    /* Logo */
                    #print-template img {
                        max-width: 90px;
                        margin: 0 auto 10px auto;
                        display: block;
                    }
                    /* Table */
                    table {
                        border-collapse: collapse;
                        width: 100%;
                        font-size: 12px;
                    }
                    table, th, td {
                        border: 1px solid #000;
                    }
                    th, td {
                        padding: 6px;
                        text-align: center;
                    }
                    th {
                        background: #f2f2f2;
                    }
                    th:first-child, td:first-child {
                        text-align: left;
                    }
                    /* Underline answer */
                    .underline {
                        display: inline-block;
                        min-width: 120px;
                        border-bottom: 1px solid #000;
                    }
                    /* Layout rows */
                    .client-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 5px;
                        font-size: 12px;
                    }

                    .client-row label {
                        margin-right: 3px;
                    }
                }
            </style>
        </head>

        <!-- Header -->
        <div style="display:flex; align-items:center; justify-content:center; margin-bottom:5px; margin-left:-30px;">
            @php
                $logoPath = public_path('assets/shortcut_logo.png');
                $logoData = base64_encode(file_get_contents($logoPath));
            @endphp
            
            <!-- Logo tight to text -->
            <div style="margin-right: 10px; margin-left: -60px;">
                <img src="data:image/png;base64,{{ $logoData }}" alt="Logo" style="max-width:120px; height:auto;">
            </div>

            <!-- University info right beside logo -->
            <div style="text-align: center; line-height:1.2; margin-left: -30px;">
                <p style="margin:0; font-size:13px;">Republic of the Philippines</p>
                <p style="margin:0; font-weight:bold; font-size:16px;">QUIRINO STATE UNIVERSITY</p>
                <p style="margin:0; font-size:13px;">Diffun, Quirino</p>
                <p style="margin:0; font-size:13px; font-style:italic;">Molding Minds, Shaping Future</p>
            </div>
        </div>

        <!-- Title below -->
        <h3 style="text-align:center; margin:5px 0;">Client Satisfaction Measurement (CSM)</h3>
        <p style="margin:0; font-size:12px; font-weight:bold; text-align:center;">HELP US SERVE YOU BETTER!</p>

        <p style="font-size:11px; text-align:justify;">
            This Client Satisfaction Measurement (CSM) tracks the customer experience of government offices. 
            Your feedback on your <u>recently concluded transaction</u> will help this office provide a better service. 
            Personal information shared will be kept confidential and you always have the option to not fill this form.
        </p>

        <!-- Client Info -->
        <div class="client-row" style="margin-top: 5px;">
            <div>
                <strong>Client Type:</strong>
                <label id="client-student">○ Student</label>
                <label id="client-faculty">○ Faculty</label>
                <label id="client-staff">○ Staff</label>
                <label id="client-government">○ Government(another agency)</label>
                <label id="client-guest">○ Guest</label>
                <label id="client-alumni">○ Alumni</label>
                <label id="client-supplier">○ Supplier</label>
            </div>
            <div style="display: inline-block; margin-left: -50px;">
                <strong>Date:</strong> 
                <span id="print-date" class="underline" style="min-width:100px;"></span>
            </div>
        </div>

        <div class="client-row">
            <div>
                <strong>Campus Transacted:</strong> 
                <span id="print-campus" class="underline" style="min-width:120px;"></span>
            </div>
            <div>
                <strong>Sex:</strong>
                <label id="sex-male">○ Male</label>
                <label id="sex-female">○ Female</label>
            </div>

            <div>
                <strong>Age:</strong> 
                <span id="print-age" class="underline" style="min-width:40px;"></span>
            </div>
            <div>
                <strong>Contact No.:</strong> 
                <span id="print-contact" class="underline" style="min-width:100px;"></span>
            </div>
        </div>

        <p><strong>Service Availed (Write only the code):</strong> <span id="print-service" class="underline"></span></p>
        <p style="font-size:11px; margin-top:-5px;">(*Select the code of service availed posted in front of the office transacted.)</p>

        <!-- CC Section -->
        <p><strong>INSTRUCTION:</strong> Choose your answer to the <strong>Citizen’s Charter (CC)</strong> questions.</p>

        <p><strong>CC1.</strong> Which of the following best describes your awareness of a CC?</p>
        <p style="margin-left:20px;">
            <label id="cc1-1">○ 1. I know what a CC is and I saw this office’s CC.</label><br>
            <label id="cc1-2">○ 2. I know what a CC is but NOT see this office’s CC.</label><br>
            <label id="cc1-3">○ 3. I learned of the CC only when I saw this office’s CC.</label><br>
            <label id="cc1-4">○ 4. I do not know what a CC is and I did not see one in the office.</label>
        </p>

        <p><strong>CC2.</strong> If aware of CC (answered 1–3 on CC1), would you say that the CC of this office was …?</p>
        <p style="margin-left:20px;">
            <label id="cc2-1">○ 1. Easy to see</label><br>
            <label id="cc2-2">○ 2. Somewhat easy to see</label><br>
            <label id="cc2-3">○ 3. Difficult to see</label><br>
            <label id="cc2-4">○ 4. Not visible at all</label><br>
            <label id="cc2-5">○ 5. N/A</label>
        </p>

        <p><strong>CC3.</strong> If aware of CC (answered 1–3 on CC1), how much did the CC help you in your transaction?</p>
        <p style="margin-left:20px;">
            <label id="cc3-1">○ 1. Helped very much</label><br>
            <label id="cc3-2">○ 2. Somewhat helped</label><br>
            <label id="cc3-3">○ 3. Did not help</label><br>
            <label id="cc3-4">○ 4. N/A</label>
        </p>

        <!-- Survey Table -->
        <p><strong>INSTRUCTIONS:</strong> For SQD0–8, please choose the column that best corresponds to your answer.</p>
        <table>
            <thead>
                <tr>
                    <th>Criteria</th>
                    <th>😠 Strongly Disagree</th>
                    <th>🙁 Disagree</th>
                    <th>😐 Neutral</th>
                    <th>🙂 Agree</th>
                    <th>😄 Strongly Agree</th>
                </tr>
            </thead>
            <tbody id="print-survey-table"></tbody>
        </table>

        <!-- Comments -->
        <p><strong>Suggestions:</strong> <span id="print-comments" class="underline"></span></p>

        <h3 style="text-align:center; margin-top:20px;">THANK YOU!</h3>
    </div>


    <link rel="stylesheet" href="{{ asset('css/bootstrap/jquery.dataTables.min.css') }}">
    <script src="{{ asset('js/datatables/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
    function openMobileMenu() {
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('menuOverlay');
        document.body.classList.add('menu-open');
        document.body.style.overflow = 'hidden';
        if (sidebar && window.innerWidth <= 992) {
            sidebar.style.display = 'block';
            sidebar.style.position = 'fixed';
            sidebar.style.left = '0';
            sidebar.style.top = '0';
            sidebar.style.bottom = '0';
            sidebar.style.height = '100%';
            sidebar.style.width = 'min(250px, calc(100vw - 88px))';
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.zIndex = '1050';
        }
        if (overlay && window.innerWidth <= 992) {
            overlay.style.display = 'block';
            overlay.style.position = 'fixed';
            overlay.style.inset = '58px 0 0 0';
            overlay.style.zIndex = '1049';
        }
    }

    function closeMobileMenu() {
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('menuOverlay');
        document.body.classList.remove('menu-open');
        document.body.style.overflow = '';
        if (sidebar && window.innerWidth <= 992) {
            sidebar.style.transform = 'translateX(-100%)';
        }
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    function toggleMobileMenu() {
        if (document.body.classList.contains('menu-open')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    //     document.getElementById('feedbackFilter').addEventListener('keyup', function () {
    //     let filter = this.value.toLowerCase();
    //     let rows = document.querySelectorAll('#table-feedback tbody tr');

    //     rows.forEach(row => {
    //         let text = row.textContent.toLowerCase();
    //         row.style.display = text.includes(filter) ? '' : 'none';
    //     });
    // });

    function generatePrintable(data, print = false) {
        console.log("PRINT DATA:", data); // Debug check

        // --- SEX ---
        if (!data.sex_type) {
            let sexInput = document.querySelector('input[name="sex"]:checked');
            data.sex_type = sexInput ? sexInput.value : "";
        }

        // --- AGE ---
        if (!data.age) {
            let ageInput = document.getElementById("age-input");
            data.age = ageInput ? ageInput.value : "";
        }

        // --- Client Type ---
        document.getElementById("client-student").innerHTML = "○ Student";
        document.getElementById("client-faculty").innerHTML = "○ Faculty";
        document.getElementById("client-staff").innerHTML = "○ Staff";
        document.getElementById("client-government").innerHTML = "○ Government(another agency)";
        document.getElementById("client-guest").innerHTML = "○ Guest";
        document.getElementById("client-alumni").innerHTML = "○ Alumni";
        document.getElementById("client-supplier").innerHTML = "○ Supplier";

        if (data.client_type) {
            let client = data.client_type.trim().toLowerCase();
            if (client === "student") document.getElementById("client-student").innerHTML = "● Student";
            else if (client === "faculty") document.getElementById("client-faculty").innerHTML = "● Faculty";
            else if (client === "staff") document.getElementById("client-staff").innerHTML = "● Staff";
            else if (client === "government") document.getElementById("client-government").innerHTML = "● Government(another agency)";
            else if (client === "guest") document.getElementById("client-guest").innerHTML = "● Guest";
            else if (client === "alumni") document.getElementById("client-alumni").innerHTML = "● Alumni";
            else if (client === "supplier") document.getElementById("client-supplier").innerHTML = "● Supplier";
        }

        // --- Sex display ---
        document.getElementById("sex-male").innerHTML = "○ Male";
        document.getElementById("sex-female").innerHTML = "○ Female";
        let sexValue = (data.sex_type || "").toString().trim().toLowerCase();
        if (sexValue === "male") {
            document.getElementById("sex-male").innerHTML = "● Male";
        } else if (sexValue === "female") {
            document.getElementById("sex-female").innerHTML = "● Female";
        }

        // --- Age ---
        let ageValue = data.age || "";
        document.getElementById("print-age").innerText = ageValue ? ageValue.trim() : "N/A";

        // --- Other fields ---
        document.getElementById("print-date").innerText = data.date || "";
        document.getElementById("print-campus").innerText = data.campus || "";
        document.getElementById("print-contact").innerText = data.contact || "";
        document.getElementById("print-service").innerText = data.service || "";
        document.getElementById("print-comments").innerText = data.comments || "";

        // --- CC1 ---
        ["cc1-1","cc1-2","cc1-3","cc1-4"].forEach(id => {
            if (document.getElementById(id)) {
                document.getElementById(id).innerHTML = document.getElementById(id).innerHTML.replace("●","○");
            }
        });
        if (data.cc1 && document.getElementById(`cc1-${data.cc1}`)) {
            document.getElementById(`cc1-${data.cc1}`).innerHTML = "● " + document.getElementById(`cc1-${data.cc1}`).innerHTML.slice(2);
        }

        // --- CC2 ---
        ["cc2-1","cc2-2","cc2-3","cc2-4","cc2-5"].forEach(id => {
            if (document.getElementById(id)) {
                document.getElementById(id).innerHTML = document.getElementById(id).innerHTML.replace("●","○");
            }
        });
        if (data.cc2 && document.getElementById(`cc2-${data.cc2}`)) {
            document.getElementById(`cc2-${data.cc2}`).innerHTML = "● " + document.getElementById(`cc2-${data.cc2}`).innerHTML.slice(2);
        }

        // --- CC3 ---
        ["cc3-1","cc3-2","cc3-3","cc3-4"].forEach(id => {
            if (document.getElementById(id)) {
                document.getElementById(id).innerHTML = document.getElementById(id).innerHTML.replace("●","○");
            }
        });
        if (data.cc3 && document.getElementById(`cc3-${data.cc3}`)) {
            document.getElementById(`cc3-${data.cc3}`).innerHTML = "● " + document.getElementById(`cc3-${data.cc3}`).innerHTML.slice(2);
        }

        // --- Survey answers ---
    let surveyData = JSON.parse(data.survey || "[]");
    const questions = [
        "SQD0. I am satisfied with the service that I availed.",
        "SQD1. I spent a reasonable amount of time for my transaction.",
        "SQD2. The office followed the transaction’s requirements.",
        "SQD3. Steps were easy and simple.",
        "SQD4. I easily found transaction info.",
        "SQD5. I paid a reasonable amount of fees.",
        "SQD6. Office was fair to everyone.",
        "SQD7. Staff was courteous and helpful.",
        "SQD8. I got what I needed / explanation given."
    ];

    let tbody = document.getElementById("print-survey-table");
    tbody.innerHTML = "";
    let total = 0, count = 0;

    questions.forEach((q, i) => {
        let ans = surveyData[i];
        let row = `<tr><td>${q}</td>`;
        for (let j = 1; j <= 4; j++) {
            row += `<td>${ans == j ? "●" : "○"}</td>`;
        }
        row += `<td>${ans === "NA" ? "●" : "○"}</td></tr>`;
        tbody.innerHTML += row;

        // Calculate numeric average ignoring N/A
        if (ans !== "NA") {
            total += Number(ans);
            count++;
        }
    });

    // Map numeric rating to words
    const ratingMap = {
        5: 'Strongly Agree',
        4: 'Agree',
        3: 'Neutral',
        2: 'Disagree',
        1: 'Strongly Disagree'
    };

    // --- Append Survey Average row ---
    let average = count > 0 ? (total / count).toFixed(2) : "N/A";
    let averageWord = "N/A";

    if (average !== "N/A") {
        // Round to nearest integer and get the word
        const rounded = Math.round(parseFloat(average));
        averageWord = ratingMap[rounded] || "N/A";
    }

    let avgRow = `<tr>
        <td style="font-weight:bold;">Survey Average</td>
        <td colspan="6" style="text-align:center; font-weight:bold;">${averageWord}</td>
    </tr>`;

    tbody.innerHTML += avgRow;


        // --- Print or Save PDF ---
        let element = document.getElementById("print-template");
        if (print) {
            let w = window.open('', '', 'width=900,height=650');
            w.document.write('<html><head><title>Feedback</title></head><body>');
            w.document.write(element.innerHTML);
            w.document.write('</body></html>');
            w.document.close();
            w.focus();
            w.print();
            w.onafterprint = function() {
                w.close();
            };
        } else {
            let clone = element.cloneNode(true);
            clone.style.display = "block";
            html2pdf().from(clone).save(`feedback-${data.id}.pdf`);
        }

    }

    // Redirect to landing page if session is gone
        window.onload = function() {
            @if(!Auth::check())
                window.location.href = "{{ route('home') }}";
            @endif
        };

        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function() {
            window.location.replace("{{ route('login') }}"); // send back to login
        };

        window.addEventListener('beforeunload', function() {
            // Reset all forms for all clients
            document.querySelectorAll('form.contact-left').forEach(form => form.reset());
            // Clear chat messages if applicable
            const chatMessages = document.getElementById('chat-messages');
            if(chatMessages) chatMessages.innerHTML = '';
        });

        $(document).ready(function() {
            const table = $('#table-feedback').DataTable({
                pageLength: 10,
                lengthChange: false,
                searching: true,
                dom: 't<"dt-footer"ip>', 
            });

            $('#feedbackFilter').on('keyup', function () {
                table.search(this.value).draw();
            });
        });

        const THEME_KEY = 'admin_theme';
        const toggleBtn = document.getElementById('themeToggleBtn');
        const icon = document.getElementById('themeToggleIcon');
        const text = document.getElementById('themeToggleText');
        const body = document.body;
        const menuToggle = document.querySelector('.menu-toggle');
        const menuClose = document.querySelector('.menu-close');
        const menuOverlay = document.querySelector('.menu-overlay');

        function setMenuOpen(isOpen) {
            if (isOpen) {
                openMobileMenu();
            } else {
                closeMobileMenu();
            }
        }

        menuToggle?.addEventListener('click', () => {
            setMenuOpen(!body.classList.contains('menu-open'));
        });

        menuClose?.addEventListener('click', () => setMenuOpen(false));
        menuOverlay?.addEventListener('click', () => setMenuOpen(false));

        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                setMenuOpen(false);
            } else {
                closeMobileMenu();
            }
        });

        function applyTheme(theme) {
            const isDark = theme === 'dark';
            document.body.classList.toggle('dark-mode', isDark);
            if (icon) icon.className = isDark ? 'fa-regular fa-sun' : 'fa-regular fa-moon';
            if (text) text.textContent = isDark ? 'Light Mode' : 'Dark Mode';
        }

        applyTheme(localStorage.getItem(THEME_KEY) || 'light');

        toggleBtn?.addEventListener('click', () => {
            const next = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
            localStorage.setItem(THEME_KEY, next);
            applyTheme(next);
        });

    </script>

    @endsection
