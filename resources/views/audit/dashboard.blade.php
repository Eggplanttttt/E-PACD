@extends('layouts.app')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Audit Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/audit-dashboard.css') }}">
@endsection

@section('content')

<input type="checkbox" id="menu-toggle" hidden>

<div class="sidebar">
    <div class="side-content">
        <div class="profile">
            <div class="profile-image">
                <img src="{{ asset('assets/logoo.png') }}" class="rounded-circle" width="100" height="100" alt="Logo">
            </div>
            <h4>E-PACD</h4>
            <small>Audit Office</small>
        </div>

        <div class="side-menu">
            <ul>
                <li><a href="{{ route('audit.dashboard') }}" class="active" aria-current="page"><span class="fa-solid fa-house"></span><small>Dashboard</small></a></li>
                <li><a href="{{ route('audit.profile') }}"><span class="fa-regular fa-user"></span><small>Profile</small></a></li>
                <li><a href="{{ route('audit.complaints.index') }}"><span class="fa-regular fa-envelope"></span><small>Complaints</small></a></li>
                <li><a href="{{ route('audit.feedback.index') }}"><span class="fa-solid fa-comments"></span><small>Feedback</small></a></li>
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

<div class="main-content">
    <header>
        <label for="menu-toggle" class="menu-toggle d-lg-none">
            <i class="fa-solid fa-bars"></i>
        </label>
        <div class="header-content"></div>
    </header>

    <main>
    {{-- Page Title --}}
    <div class="page-header vd-page-header">
        <div class="vd-page-title">
            <h1 class="mb-0">Dashboard</h1>
            <small class="text-muted">Home / Audit Dashboard</small>
        </div>
    </div>

    {{-- Content --}}
    <div class="page-content vd-page-content">
        <div class="vd-container">

            {{-- Top row --}}
            <div class="row g-3">

                {{-- Complaints Card --}}
                <div class="col-12">
    <div class="card h-100 p-3 analytics-card vd-card">
        <div class="vd-card-head">
            <h6 class="mb-0 text-uppercase small fw-bold">Complaints</h6>
            <span class="vd-pill">Overview</span>
        </div>

        <div class="vd-split">
            <div class="vd-chart">
                <canvas id="complaintDoughnut"></canvas>
            </div>

            <div class="vd-table">
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

        {{-- NEW: Bottom context (fills the space nicely) --}}
        @php
            $p = (int)($pendingCount ?? 0);
            $s = (int)($solvedCount ?? 0);
            $x = (int)($spammedCount ?? 0);
            $t = $p + $s + $x;

            $pendingRate = $t > 0 ? round(($p / $t) * 100) : 0;
            $solvedRate  = $t > 0 ? round(($s / $t) * 100) : 0;

            // Optional: top department if you already pass $deptLabels, $deptCounts
            $topDept = (isset($deptLabels[0]) && isset($deptCounts[0])) ? $deptLabels[0] : null;
            $topDeptCount = (isset($deptCounts[0])) ? $deptCounts[0] : null;
        @endphp

        <div class="vd-insights">
            <div class="vd-insight-grid">
                <div class="vd-kpi">
                    <div class="vd-kpi-label">Pending rate</div>
                    <div class="vd-kpi-value">{{ $pendingRate }}%</div>
                </div>
                <div class="vd-kpi">
                    <div class="vd-kpi-label">Solved rate</div>
                    <div class="vd-kpi-value">{{ $solvedRate }}%</div>
                </div>
            </div>

            @if($topDept)
                <div class="vd-mini">
                    <div class="vd-mini-title">Most reported department</div>
                    <div class="vd-mini-body">
                        <strong>{{ $topDept }}</strong>
                        <span class="text-muted">({{ $topDeptCount }} reports)</span>
                    </div>
                </div>
            @else
                <div class="vd-mini">
                    <div class="vd-mini-title">Quick note</div>
                    <div class="vd-mini-body">
                        This snapshot helps you spot workload faster—focus on Pending when it spikes.
                    </div>
                </div>
            @endif

            <div class="vd-hint">
                <i class="fa-regular fa-lightbulb me-1"></i>
                Tip: If Pending rate is above 50%, prioritize newest complaints first for faster resolution.
            </div>
        </div>

    </div>
</div>

                {{-- Client Satisfaction (Collapsible Card) --}}
                <div class="col-12">
                    <div class="card h-100 p-3 analytics-card vd-card">
                        <div class="vd-card-head vd-card-head--toggle">
                            <div>
                                <h6 class="mb-0 text-uppercase small fw-bold">Client Satisfaction</h6>
                                <small class="text-muted">Average rating & distribution by client type</small>
                            </div>

                            <button id="toggleCharts" class="btn btn-sm btn-light vd-toggle-btn" type="button">
                                <span class="me-2">Toggle</span>
                                <span id="chartsIcon" class="fa-solid fa-angle-down"></span>
                            </button>
                        </div>

                        <div id="chartsContent" class="vd-collapse">
                            <div class="row g-3 mt-2">
                                <div class="col-12 col-xl-6">
                                    <div class="vd-panel">
                                        <h6 class="vd-panel-title">Average Rating by Client Type</h6>
                                        <div id="avgRatingChart" class="vd-google-chart"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <div class="vd-panel">
                                        <h6 class="vd-panel-title">Rating Distribution per Client Type</h6>
                                        <div id="ratingDistChart" class="vd-google-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Top 10 Complaint Departments --}}
                <div class="col-12">
                    <div class="card p-3 analytics-card vd-card">
                        <div class="vd-card-head">
                            <h6 class="mb-0 text-uppercase small fw-bold">Top 10 Complaint Departments</h6>
                            <span class="vd-pill vd-pill--danger">Top</span>
                        </div>

                        <div class="vd-barwrap">
                            <canvas id="deptBarChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>{{-- row --}}
        </div>{{-- vd-container --}}
    </div>{{-- page-content --}}
</main>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pending = parseInt(document.getElementById('pendingCount')?.textContent) || 0;
    const solved = parseInt(document.getElementById('solvedCount')?.textContent) || 0;
    const spammed = parseInt(document.getElementById('spammedCount')?.textContent) || 0;

    const doughnutEl = document.getElementById('complaintDoughnut');
    if (!doughnutEl) return;

    const ctx = doughnutEl.getContext('2d');

    function renderComplaintDoughnut() {
        const isDark = document.body.classList.contains('dark-mode');
        const ringBorder = isDark ? '#161b22' : '#ffffff';

        if (window.complaintDoughnutChart) {
            window.complaintDoughnutChart.destroy();
        }

        window.complaintDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Addressed', 'Spams'],
                datasets: [{
                    data: [pending, solved, spammed],
                    backgroundColor: ['#FF9800', '#4CAF50', '#F44336'],
                    borderColor: ringBorder,
                    borderWidth: 2
                }]
            },
            options: {
                cutout: '65%',
                plugins: { legend: { display: false } },
                onClick: () => {} // Audit dashboard view-only
            }
        });
    }

    renderComplaintDoughnut();
    window.addEventListener('themechange', renderComplaintDoughnut);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const clients = @json($clients ?? []);

    const counts = {
        student: clients.filter(c => (c.client_type || '').toLowerCase() === 'student').length,
        faculty: clients.filter(c => (c.client_type || '').toLowerCase() === 'faculty').length,
        alumni: clients.filter(c => (c.client_type || '').toLowerCase() === 'alumni').length,
        other: clients.filter(c => (c.client_type || '').toLowerCase() === 'other').length
    };

    document.getElementById('studentCount').textContent = counts.student;
    document.getElementById('facultyCount').textContent = counts.faculty;
    document.getElementById('alumniCount').textContent = counts.alumni;
    document.getElementById('otherCount').textContent = counts.other;
    document.getElementById('totalCount').textContent = counts.student + counts.faculty + counts.alumni + counts.other;

    const pieEl = document.getElementById('clientPie');
    if (!pieEl) return;

    const ctxPie = pieEl.getContext('2d');
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
        options: { plugins: { legend: { display: false } } }
    });
});
</script>

<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    const summary = @json($summary ?? []);
    const isDark = document.body.classList.contains('dark-mode');
    const axisColor = isDark ? '#dbe3ec' : '#111827';
    const gridColor = isDark ? '#2f3a4a' : '#d9dee5';
    const chartBg = isDark ? '#161b22' : '#ffffff';
    const textColor = isDark ? '#dbe3ec' : '#111827';

    const ratingMap = {5:'Strongly Agree',4:'Agree',3:'Neutral',2:'Disagree',1:'Strongly Disagree'};
    const colors = ['#4beb0b', '#0ac0e0', '#ecd507', '#e05a0d', '#dd1010'];

    let avgData = [['Client Type','Average Rating',{ role: 'style' }, { role: 'annotation' }]];

    for (const client in summary) {
        let total = 0, count = 0;
        for (const rating in summary[client]) {
            const num = parseInt(Object.keys(ratingMap).find(key => ratingMap[key] === rating));
            total += num * summary[client][rating];
            count += summary[client][rating];
        }
        let avg = count > 0 ? total / count : 0;
        avgData.push([client, avg, '#06e7b7', avg.toFixed(1)]);
    }

    let avgChart = google.visualization.arrayToDataTable(avgData);

    new google.visualization.ColumnChart(document.getElementById('avgRatingChart')).draw(avgChart, {
        title: 'Average Rating by Client Type',
        legend: { position: 'none' },
        backgroundColor: chartBg,
        vAxis: { minValue: 0, maxValue: 5, title: 'Rating', textStyle: { color: axisColor }, titleTextStyle: { color: axisColor }, gridlines: { color: gridColor } },
        hAxis: { title: 'Client Type', textStyle: { color: axisColor }, titleTextStyle: { color: axisColor } },
        chartArea: { width: '80%', height: '70%' },
        titleTextStyle: { color: textColor },
        annotations: { alwaysOutside: true, textStyle: { fontSize: 12, bold: true, color: axisColor } }
    });

    let distData = [['Client Type', 'Strongly Agree', 'Agree', 'Neutral', 'Disagree', 'Strongly Disagree']];
    const clientTypes = Object.keys(summary);

    clientTypes.forEach(clientType => {
        distData.push([
            clientType,
            summary[clientType]['Strongly Agree'] || 0,
            summary[clientType]['Agree'] || 0,
            summary[clientType]['Neutral'] || 0,
            summary[clientType]['Disagree'] || 0,
            summary[clientType]['Strongly Disagree'] || 0
        ]);
    });

    let distChartData = google.visualization.arrayToDataTable(distData);

    let totalCount = 0;
    for (let i = 0; i < distChartData.getNumberOfRows(); i++) {
        for (let j = 1; j < distChartData.getNumberOfColumns(); j++) {
            totalCount += distChartData.getValue(i, j);
        }
    }

    new google.visualization.ColumnChart(document.getElementById('ratingDistChart')).draw(distChartData, {
        title: `Rating Distribution per Client Type (Total Surveys: ${totalCount})`,
        isStacked: true,
        colors: colors,
        backgroundColor: chartBg,
        vAxis: { title: 'Client Type', textStyle: { color: axisColor }, titleTextStyle: { color: axisColor }, gridlines: { color: gridColor } },
        hAxis: { title: 'Number of Clients', viewWindow: { min: 0 }, textStyle: { color: axisColor }, titleTextStyle: { color: axisColor } },
        chartArea: { width: '80%', height: '70%' },
        legend: { position: 'top', textStyle: { color: textColor } },
        titleTextStyle: { color: textColor }
    });
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const deptLabels = @json($deptLabels ?? []);
    const deptCounts = @json($deptCounts ?? []);

    const el = document.getElementById('deptBarChart');
    if (!el) return;

    const ctx = el.getContext('2d');

    function renderDeptBarChart() {
        const isDark = document.body.classList.contains('dark-mode');
        const axisColor = isDark ? '#dbe3ec' : '#334155';
        const gridColor = isDark ? 'rgba(148, 163, 184, 0.16)' : 'rgba(15, 23, 42, 0.1)';

        if (window.deptBarChartRef) {
            window.deptBarChartRef.destroy();
        }

        window.deptBarChartRef = new Chart(ctx, {
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
                        ticks: { color: axisColor, font: { weight: '600' } },
                        grid: { color: gridColor, drawBorder: false }
                    },
                    y: {
                        ticks: { color: axisColor, font: { weight: '600' } },
                        grid: { color: gridColor, drawBorder: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'left',
                        color: '#fff',
                        font: { weight: 'bold', size: 14 },
                        formatter: (value) => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    renderDeptBarChart();
    window.addEventListener('themechange', renderDeptBarChart);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleCharts');
    const chartsContent = document.getElementById('chartsContent');
    const icon = document.getElementById('chartsIcon');

    if (!toggleBtn || !chartsContent || !icon) return;

    chartsContent.style.transition = "max-height 0.3s ease";
    chartsContent.style.overflow = "hidden";
    chartsContent.style.maxHeight = chartsContent.scrollHeight + "px";

    toggleBtn.addEventListener('click', () => {
        if (chartsContent.style.maxHeight === '0px') {
            chartsContent.style.maxHeight = chartsContent.scrollHeight + "px";
            icon.classList.remove('fa-angle-up');
            icon.classList.add('fa-angle-down');
        } else {
            chartsContent.style.maxHeight = '0';
            icon.classList.remove('fa-angle-down');
            icon.classList.add('fa-angle-up');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const THEME_KEY = 'admin_theme';
    const toggleBtn = document.getElementById('themeToggleBtn');
    const icon = document.getElementById('themeToggleIcon');
    const text = document.getElementById('themeToggleText');

    if (!toggleBtn || !icon || !text) return;

    function applyTheme(theme) {
        const isDark = theme === 'dark';
        document.body.classList.toggle('dark-mode', isDark);
        icon.className = isDark ? 'fa-regular fa-sun' : 'fa-regular fa-moon';
        text.textContent = isDark ? 'Light Mode' : 'Dark Mode';
        window.dispatchEvent(new Event('themechange'));
    }

    applyTheme(localStorage.getItem(THEME_KEY) || 'light');

    toggleBtn.addEventListener('click', () => {
        const next = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
        localStorage.setItem(THEME_KEY, next);
        applyTheme(next);
    });

    window.addEventListener('themechange', () => {
        if (window.google && google.visualization) drawCharts();
    });
});
</script>
@endsection
