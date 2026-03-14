@extends('layouts.app')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp


@section('title', 'Admin Dashboard')

@section('content')

<div class="sidebar" id="mobileSidebar">
    <div class="side-content">
        <button type="button" class="menu-close d-lg-none" aria-label="Close menu" onclick="closeMobileMenu()" onpointerup="closeMobileMenu()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="profile">
            <div class="profile-image">
                <img src="{{ asset('assets/logoo.png') }}" class="rounded-circle" width="100" height="100">
            </div>
            <h4>E-PACD</h4>
            <small>Super Admin</small>
        </div>
        <div class="side-menu">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="active" aria-current="page"><span class="fa-solid fa-house"></span><small>Dashboard</small></a></li>
                <li><a href="{{ route('admin.profile') }}"><span class="fa-regular fa-user"></span><small>Profile</small></a></li>
                <li><a href="{{ route('admin.complaints.index') }}"><span class="fa-regular fa-envelope"></span><small>Complaints</small></a></li>
                <li>
                    <a href="{{ route('admin.inquiries.index') }}" class="d-flex justify-content-between align-items-center inquiries-menu-link">
                        <div class="d-flex flex-column align-items-center inquiries-menu-main">
                            <span class="fa-solid fa-question-circle inquiries-menu-icon"></span><small>Inquiries</small>
                        </div>
                        <span id="inquiriesUnreadBadge" class="badge bg-danger ms-2" style="display:none; font-size:0.85rem; line-height:1; min-width:22px;">0</span>
                    </a>
                </li>
                <li><a href="{{ route('admin.feedback.index') }}"><span class="fa-solid fa-comments"></span><small>Feedback</small></a></li>
                <li>
                    <button type="button" id="themeToggleBtn" class="theme-toggle-btn">
                        <span id="themeToggleIcon" class="fa-regular fa-moon"></span>
                        <small id="themeToggleText">Dark Mode</small>
                    </button>
                </li>
                <li class="sidebar-logout">
                    <form action="{{ route('admin.logout') }}" method="POST">
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
</div>

    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Home / Dashboard</small>
        </div>
        <div class="page-content">
    <div class="row g-3"> <!-- Bootstrap grid with gap -->

        {{-- Complaints Card --}}
        <div class="col-lg-6">
            <div class="card h-100 p-3 analytics-card">

                <h6 class="mb-3 text-uppercase small fw-bold">Complaints</h6>

                <div class="d-flex flex-row align-items-center justify-content-start gap-3">

                    {{-- Doughnut --}}
                    <div class="chart-container">
                        <canvas id="complaintDoughnut"></canvas>
                    </div>

                    {{-- List --}}
                    <table class="table table-sm complaints-table mb-0">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-end">Count</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><span class="dot pending"></span> Pending</td>
                                <td class="text-end" id="pendingCount">{{ $pendingCount ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><span class="dot solved"></span> Addressed</td>
                                <td class="text-end" id="solvedCount">{{ $solvedCount ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><span class="dot spammed"></span> Spams</td>
                                <td class="text-end" id="spammedCount">{{ $spammedCount ?? 0 }}</td>
                            </tr>

                            <tr class="fw-bold border-top">
                                <td>Total</td>
                                <td class="text-end">
                                    {{ ($pendingCount ?? 0) + ($solvedCount ?? 0) + ($spammedCount ?? 0) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

        {{-- Client Accounts Card --}}
        <div class="col-lg-6">
            <div class="card h-100 p-3 analytics-card">

                <h6 class="mb-3 text-uppercase small fw-bold">Client Accounts</h6>

                <div class="d-flex flex-row align-items-center justify-content-start gap-3">

                    {{-- Pie Chart --}}
                    <div class="chart-container" style="width:120px; height:120px;">
                        <canvas id="clientPie"></canvas>
                    </div>

                    {{-- List of Client Types --}}
                    <table class="table table-sm clients-card-table mb-0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th class="text-end">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="dot" style="background:#2196F3;"></span> Student</td>
                                <td class="text-end" id="studentCount">0</td>
                            </tr>
                            <tr>
                                <td><span class="dot" style="background:#4CAF50;"></span> Faculty</td>
                                <td class="text-end" id="facultyCount">0</td>
                            </tr>
                            <tr>
                                <td><span class="dot" style="background:#FF9800;"></span> Alumni</td>
                                <td class="text-end" id="alumniCount">0</td>
                            </tr>
                            <tr>
                                <td><span class="dot" style="background:#9E9E9E;"></span> Other</td>
                                <td class="text-end" id="otherCount">0</td>
                            </tr>
                            <tr class="fw-bold border-top">
                                <td>Total</td>
                                <td class="text-end" id="totalCount">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Addressed Inquiries Card --}}
        <div class="col-lg-6">
            <div class="card text-white h-100 p-3 analytics-card addressed-inquiries-card">
                <h6 class="mb-3 text-uppercase small fw-bold">Addressed Inquiries</h6>

                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                    <h1 class="fw-bold display-2 m-0 text-center" id="clientChatsCount">
                        {{ $clientChatsCount ?? 0 }}
                    </h1>
                    <small class="mt-2 opacity-75">Resolved inquiry threads</small>
                </div>
            </div>
        </div>

        {{-- Sample Customer Reviews Card --}}
        <div class="col-lg-6">
            <div class="card h-100 p-3 analytics-card customer-reviews-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1 fw-bold">Clients reviews</h6>
                        <div class="sample-stars mb-1">
                            @php
                                $fullStars = floor($chatRatingsAverage ?? 0);
                                $hasHalfStar = (($chatRatingsAverage ?? 0) - $fullStars) >= 0.5;
                            @endphp

                            @for ($star = 1; $star <= 5; $star++)
                                @if ($star <= $fullStars)
                                    <i class="fa-solid fa-star"></i>
                                @elseif ($star === $fullStars + 1 && $hasHalfStar)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="small text-muted">{{ number_format($chatRatingsTotal ?? 0) }} global ratings</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold fs-5">{{ number_format($chatRatingsAverage ?? 0, 1) }} out of 5</div>
                        <small class="text-muted">Based on chat-ratings</small>
                    </div>
                </div>

                <div class="reviews-breakdown">
                    @php
                        $reviewBreakdown = [];

                        for ($star = 5; $star >= 1; $star--) {
                            $count = $chatRatingCounts[$star] ?? 0;
                            $percent = ($chatRatingsTotal ?? 0) > 0
                                ? round(($count / $chatRatingsTotal) * 100)
                                : 0;

                            $reviewBreakdown[] = [
                                'label' => "{$star} star",
                                'percent' => $percent,
                                'count' => $count,
                            ];
                        }
                    @endphp

                    @if (($chatRatingsTotal ?? 0) > 0)
                        @foreach($reviewBreakdown as $review)
                            <div class="review-row">
                                <span class="review-label">{{ $review['label'] }}</span>
                                <div class="review-bar-track">
                                    <div class="review-bar-fill" style="width: {{ $review['percent'] }}%;"></div>
                                </div>
                                <span class="review-value">{{ $review['percent'] }}%</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted small">No chat ratings yet.</div>
                    @endif
                </div>

                <details class="ratings-explainer mt-3">
                    <summary>How are ratings calculated?</summary>
                    <div class="ratings-explainer-body">
                        The percentages are based on all records saved in our <code>database</code>.
                        Each row uses this formula:
                        <code>(star count / total chat ratings) x 100</code>.
                        With {{ number_format($chatRatingsTotal ?? 0) }} total rating{{ ($chatRatingsTotal ?? 0) == 1 ? '' : 's' }},
                        the dashboard currently counts
                        5-star: {{ $chatRatingCounts[5] ?? 0 }},
                        4-star: {{ $chatRatingCounts[4] ?? 0 }},
                        3-star: {{ $chatRatingCounts[3] ?? 0 }},
                        2-star: {{ $chatRatingCounts[2] ?? 0 }},
                        1-star: {{ $chatRatingCounts[1] ?? 0 }}.
                    </div>
                </details>
            </div>
        </div>

        
        @php
            $ratingMap = [
                5 => 'Strongly Agree',
                4 => 'Agree',
                3 => 'Neutral',
                2 => 'Disagree',
                1 => 'Strongly Disagree'
            ];

            // Prepare summary: client type => count of each rating (ONE COUNT PER FEEDBACK)
            $summary = [];
            foreach ($feedbacks as $fb) {
                $client = $fb->client_type;
                if (!isset($summary[$client])) {
                    $summary[$client] = [
                        'Strongly Agree' => 0,
                        'Agree' => 0,
                        'Neutral' => 0,
                        'Disagree' => 0,
                        'Strongly Disagree' => 0,
                    ];
                }
                
                // Calculate the average rating for this feedback
                $answers = json_decode($fb->sqd_answers, true) ?? [];
                $total = array_sum($answers);
                $average = count($answers) > 0 ? $total / count($answers) : 0;
                
                // Convert average to rating category (ONE CATEGORY PER FEEDBACK)
                if ($average >= 4.5) {
                    $summary[$client]['Strongly Agree']++;
                } elseif ($average >= 3.5) {
                    $summary[$client]['Agree']++;
                } elseif ($average >= 2.5) {
                    $summary[$client]['Neutral']++;
                } elseif ($average >= 1.5) {
                    $summary[$client]['Disagree']++;
                } else {
                    $summary[$client]['Strongly Disagree']++;
                }
            }
            
            // DEBUG: Show what we're counting
            $totalCount = 0;
            foreach($summary as $clientType => $ratings) {
                $clientTotal = array_sum($ratings);
                $totalCount += $clientTotal;
            }
        @endphp

        <!-- Client Satisfaction Charts -->
        <div class="container mt-4">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <h4 class="mb-0 me-2">Client Satisfaction Charts</h4>
                <button id="toggleCharts" class="btn btn-link p-0">
                    <span id="chartsIcon" class="fa-solid fa-angle-down"></span>
                </button>
            </div>

            
            <div id="chartsContent">
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <h5 class="text-center">Average Rating by Client Type</h5>
                        <div id="avgRatingChart" style="width:100%; height:400px;"></div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-center">Rating Distribution per Client Type</h5>
                        <div id="ratingDistChart" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
    <div class="card h-100 p-3 analytics-card" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h6 class="mb-3 text-uppercase small fw-bold">Top 10 Complaint Departments</h6>

        <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
            <canvas id="deptBarChart"></canvas>
        </div>
    </div>
</div>





    </div> <!-- row -->
</div> <!-- page-content -->

    </div>

    </main>
</div>

@endsection
<!---Complaints Card-->

@section('styles')
<style>
    .addressed-inquiries-card {
        background: linear-gradient(135deg, #1ea54b 0%, #16853b 100%);
        min-height: 220px;
        border-radius: 12px;
    }

    .customer-reviews-card {
        min-height: 220px;
        border-radius: 12px;
    }

    .sample-stars {
        color: #f59e0b;
        letter-spacing: 0.08rem;
    }

    .reviews-breakdown {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .review-row {
        display: grid;
        grid-template-columns: 70px 1fr 42px;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
    }

    .review-label,
    .review-value {
        color: #dbe3ec;
        white-space: nowrap;
    }

    body:not(.dark-mode) .review-label,
    body:not(.dark-mode) .review-value,
    body:not(.dark-mode) .customer-reviews-card .text-muted {
        color: #4b5563 !important;
    }

    .review-bar-track {
        position: relative;
        height: 12px;
        border-radius: 3px;
        background: #e5e7eb;
        overflow: hidden;
        width: 100%;
    }

    .review-bar-fill {
        height: 100%;
        min-width: 6px;
        border-radius: 3px;
        background: #f59e0b;
    }

    body.dark-mode .review-bar-track {
        background: #d1d5db;
    }

    .ratings-explainer {
        font-size: 0.9rem;
    }

    .ratings-explainer summary {
        cursor: pointer;
        color: #6b7280;
        font-weight: 600;
        list-style: none;
        user-select: none;
    }

    .ratings-explainer summary::-webkit-details-marker {
        display: none;
    }

    .ratings-explainer summary::before {
        content: '\f0d7';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-right: 0.4rem;
        font-size: 0.75rem;
    }

    .ratings-explainer[open] summary::before {
        content: '\f0d8';
    }

    .ratings-explainer-body {
        margin-top: 0.6rem;
        color: #6b7280;
        line-height: 1.5;
        font-size: 0.85rem;
    }

    .ratings-explainer-body code {
        color: inherit;
        background: rgba(148, 163, 184, 0.18);
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
    }

    body.dark-mode .ratings-explainer summary,
    body.dark-mode .ratings-explainer-body {
        color: #9ca3af;
    }

    body.dark-mode .ratings-explainer-body code {
        background: rgba(148, 163, 184, 0.12);
    }

    @media (max-width: 767.98px) {
        .addressed-inquiries-card,
        .customer-reviews-card {
            min-height: auto;
        }

        .review-row {
            grid-template-columns: 60px 1fr 38px;
            gap: 0.5rem;
            font-size: 0.82rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

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

document.addEventListener('DOMContentLoaded', function () {
    const pending = parseInt(document.getElementById('pendingCount').textContent) || 0;
    const solved = parseInt(document.getElementById('solvedCount').textContent) || 0;
    const spammed = parseInt(document.getElementById('spammedCount').textContent) || 0;

    const ctx = document.getElementById('complaintDoughnut').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Addressed', 'Spams'],
            datasets: [{
                data: [pending, solved, spammed],
                backgroundColor: ['#FF9800', '#4CAF50', '#F44336'],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '65%',
            plugins: { legend: { display: false } },
            onClick: (event, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    switch(index){
                        case 0:
                            window.location.href = "{{ route('admin.complaints.index') }}";
                            break;
                        case 1:
                            window.location.href = "{{ route('admin.complaints.solved') }}";
                            break;
                        case 2:
                            window.location.href = "{{ route('admin.complaints.rejected') }}";
                            break;
                    }
                }
            }
        }
    });
});
</script>

<!---Clients Account-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const clients = @json($clients);

    const counts = {
        student: clients.filter(c => c.client_type.toLowerCase() === 'student').length,
        faculty: clients.filter(c => c.client_type.toLowerCase() === 'faculty').length,
        alumni: clients.filter(c => c.client_type.toLowerCase() === 'alumni').length,
        other: clients.filter(c => c.client_type.toLowerCase() === 'other').length
    };

    document.getElementById('studentCount').textContent = counts.student;
    document.getElementById('facultyCount').textContent = counts.faculty;
    document.getElementById('alumniCount').textContent = counts.alumni;
    document.getElementById('otherCount').textContent = counts.other;
    document.getElementById('totalCount').textContent = counts.student + counts.faculty + counts.alumni + counts.other;

    const ctxPie = document.getElementById('clientPie').getContext('2d');

    if (window.clientPieChart) window.clientPieChart.destroy();

    window.clientPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Student', 'Faculty', 'Alumni', 'Other'],
            datasets: [{
                data: [counts.student, counts.faculty, counts.alumni, counts.other],
                backgroundColor: ['#2196F3', '#4CAF50', '#FF9800', '#9E9E9E'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { display: false } // hide default legend
            }
        }
    });
});
</script>

<!---Satifaction Graph-->
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    const summary = @json($summary);
    const isDark = document.body.classList.contains('dark-mode');
    const axisTextColor = isDark ? '#dbe3ec' : '#222';
    const gridColor = isDark ? '#324052' : '#d9d9d9';
    const chartBg = isDark ? '#161b22' : '#ffffff';
    const titleColor = isDark ? '#e6edf3' : '#111';
    const annotationColor = isDark ? '#e6edf3' : '#000';

    // DEBUG: Check what data we're actually getting
    console.log("Summary data:", summary);
    console.log("Total feedback records in chart data:", 
        Object.values(summary).reduce((total, client) => 
            total + Object.values(client).reduce((sum, count) => sum + count, 0), 0
        )
    );
    const ratingMap = {5:'Strongly Agree',4:'Agree',3:'Neutral',2:'Disagree',1:'Strongly Disagree'};
    const colors = ['#4beb0b', '#0ac0e0', '#ecd507', '#e05a0d', '#dd1010'];

    // --- Average Rating per Client Type WITH LABELS ---
    let avgData = [['Client Type','Average Rating',{ role: 'style' }, { role: 'annotation' }]];

    for (const client in summary) {
        let total = 0, count = 0;
        for (const rating in summary[client]) {
            const num = parseInt(Object.keys(ratingMap).find(key => ratingMap[key] === rating));
            total += num * summary[client][rating];
            count += summary[client][rating];
        }
        let avg = count > 0 ? total / count : 0;
        avgData.push([client, avg, '#06e7b7', avg.toFixed(1)]); // last value is annotation
    }

    let avgChart = google.visualization.arrayToDataTable(avgData);

    new google.visualization.ColumnChart(document.getElementById('avgRatingChart')).draw(avgChart, {
        title: 'Average Rating by Client Type',
        backgroundColor: chartBg,
        titleTextStyle: { color: titleColor, bold: true, fontSize: 16 },
        legend: { position: 'none' },
        vAxis: {
            minValue: 0,
            maxValue: 5,
            title: 'Rating',
            titleTextStyle: { color: axisTextColor, italic: true },
            textStyle: { color: axisTextColor },
            gridlines: { color: gridColor }
        },
        hAxis: {
            title: 'Client Type',
            titleTextStyle: { color: axisTextColor, italic: true },
            textStyle: { color: axisTextColor }
        },
        chartArea: { width: '80%', height: '70%' },
        annotations: {
            alwaysOutside: true, // ensures labels are on top
            textStyle: {
                fontSize: 12,
                bold: true,
                color: annotationColor
            }
        }
    });


    // --- Rating Distribution per Client Type - ACTUAL COUNTS ---
    let distData = [
        ['Client Type', 'Strongly Agree', 'Agree', 'Neutral', 'Disagree', 'Strongly Disagree']
    ];
    
    // Get all client types
    const clientTypes = Object.keys(summary);
    
    clientTypes.forEach(clientType => {
        const row = [clientType];
        
        // Push actual counts for each rating category
        row.push(summary[clientType]['Strongly Agree'] || 0);
        row.push(summary[clientType]['Agree'] || 0);
        row.push(summary[clientType]['Neutral'] || 0);
        row.push(summary[clientType]['Disagree'] || 0);
        row.push(summary[clientType]['Strongly Disagree'] || 0);
        
        distData.push(row);
    });

    let distChartData = google.visualization.arrayToDataTable(distData);
    
    let totalCount = 0;

    for (let i = 0; i < distChartData.getNumberOfRows(); i++) {
        for (let j = 1; j < distChartData.getNumberOfColumns(); j++) {
            totalCount += distChartData.getValue(i, j);
        }
    }

    //total count
    new google.visualization.ColumnChart(document.getElementById('ratingDistChart')).draw(distChartData, {
        title: `Rating Distribution per Client Type (Total Surveys: ${totalCount})`,
        isStacked: true,
        backgroundColor: chartBg,
        titleTextStyle: { color: titleColor, bold: true, fontSize: 16 },
        colors: colors,
        vAxis: {
            title: 'Client Type',
            titleTextStyle: { color: axisTextColor, italic: true },
            textStyle: { color: axisTextColor },
            gridlines: { color: gridColor }
        },
        hAxis: { 
            title: 'Number of Clients',
            titleTextStyle: { color: axisTextColor, italic: true },
            textStyle: { color: axisTextColor },
            viewWindow: { min: 0 } // Ensure it starts from 0
        },
        chartArea: { width: '80%', height: '70%' },
        legend: { position: 'top', textStyle: { color: axisTextColor } }
    });

}
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const deptLabels = @json($deptLabels);
    const deptCounts = @json($deptCounts);

    const ctx = document.getElementById('deptBarChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: deptLabels,
            datasets: [{
                label: 'Number of Complaints',
                data: deptCounts,
                backgroundColor: '#e8340c', 
                borderColor: '#e8340c',
                borderWidth: 1,
                borderRadius: 6, 
                barPercentage: 0.6, 
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { 
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                },
                y: {
                    ticks: { 
                        font: { size: 14 } 
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#333',
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    padding: 10
                },
                datalabels: {
                    anchor: 'end',     
                    align: 'left',     
                    color: '#fff',      
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value) => value // display the value
                }
            }
        },
        plugins: [ChartDataLabels] // make sure to register the plugin
    });
});


</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleCharts');
    const chartsContent = document.getElementById('chartsContent');
    const icon = document.getElementById('chartsIcon');

    // Initialize for smooth transition
    chartsContent.style.transition = "max-height 0.3s ease";
    chartsContent.style.overflow = "hidden";
    chartsContent.style.maxHeight = chartsContent.scrollHeight + "px";

    toggleBtn.addEventListener('click', () => {
        if (chartsContent.style.maxHeight === '0px') {
            // Expand
            chartsContent.style.maxHeight = chartsContent.scrollHeight + "px";
            icon.classList.remove('fa-angle-up');
            icon.classList.add('fa-angle-down');
        } else {
            // Collapse
            chartsContent.style.maxHeight = '0';
            icon.classList.remove('fa-angle-down');
            icon.classList.add('fa-angle-up');
        }
    });
});

// -----------------------------
// Client Chats Count
// -----------------------------
async function updateClientChatsCount() {
    try {
        const res = await fetch('/admin/solved-clients-count', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById('clientChatsCount').textContent = data.count;
        }
    } catch (err) {
        console.error('Failed to update solved clients count', err);
    }
}
updateClientChatsCount();
setInterval(updateClientChatsCount, 10000);

// -----------------------------
// Inquiries Unread Badge
// -----------------------------
async function updateInquiriesUnreadBadge() {
    try {
        const res = await fetch('/admin/inquiries/unread-counts', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();

        if (!data.success || !data.unreadCounts) return;

        const totalUnread = Object.values(data.unreadCounts)
            .reduce((sum, count) => sum + (parseInt(count, 10) || 0), 0);

        const badge = document.getElementById('inquiriesUnreadBadge');
        if (!badge) return;

        if (totalUnread > 0) {
            badge.textContent = totalUnread;
            badge.style.display = 'inline-block';
        } else {
            badge.textContent = '0';
            badge.style.display = 'none';
        }
    } catch (err) {
        console.error('Failed to update inquiries unread badge', err);
    }
}
updateInquiriesUnreadBadge();
setInterval(updateInquiriesUnreadBadge, 5000);

// -----------------------------
// Client Accounts Count
// -----------------------------
let selectedType = 'all';
const accounts = @json($clients);

function updateClientAccountsCount() {
    let count = accounts.filter(acc =>
        selectedType === 'all' || acc.client_type.toLowerCase() === selectedType
    ).length;

    document.getElementById('clientAccountsCount').textContent = count;
}

document.querySelectorAll('#clientTypeFilter .dropdown-item').forEach(item => {
    item.addEventListener('click', e => {
        e.preventDefault();
        selectedType = item.dataset.type;
        updateClientAccountsCount();
    });
});
updateClientAccountsCount();

// -----------------------------
// Page Redirect Protection
// -----------------------------
window.onload = function() {
    @if(!Auth::check())
        window.location.href = "{{ route('home') }}";
    @endif
};

window.onpopstate = function() {
    window.location.replace("{{ route('login') }}");
};

window.addEventListener('beforeunload', function() {
    document.querySelectorAll('form.contact-left').forEach(form => form.reset());
    const chatMessages = document.getElementById('chat-messages');
    if (chatMessages) chatMessages.innerHTML = '';
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const THEME_KEY = 'admin_theme';
    const toggleBtn = document.getElementById('themeToggleBtn');
    const icon = document.getElementById('themeToggleIcon');
    const text = document.getElementById('themeToggleText');
    const body = document.body;
    const menuToggle = document.querySelector('.menu-toggle');
    const menuClose = document.querySelector('.menu-close');
    const menuOverlay = document.querySelector('.menu-overlay');

    if (!toggleBtn || !icon || !text) return;

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
        icon.className = isDark ? 'fa-regular fa-sun' : 'fa-regular fa-moon';
        text.textContent = isDark ? 'Light Mode' : 'Dark Mode';
        window.dispatchEvent(new Event('themechange'));
    }

    const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
    applyTheme(savedTheme);

    toggleBtn.addEventListener('click', () => {
        const next = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
        localStorage.setItem(THEME_KEY, next);
        applyTheme(next);
    });

    window.addEventListener('themechange', () => {
        if (typeof drawCharts === 'function') {
            setTimeout(drawCharts, 50);
        }
    });
});
</script>
@endsection
