@extends('layouts.complaints-management')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Solved Complaints')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/audit-complaint.css') }}">
@endsection

@section('content')

<input type="checkbox" id="menu-toggle">

<div class="sidebar">
    <div class="side-content">
        <div class="profile">
            <div class="profile-image">
                <img src="{{ asset('assets/logoo.png') }}" class="rounded-circle" width="100" height="100" alt="Logo">
            </div>
            <h4>E-PACD</h4>
            <small>Audit</small>
        </div>

        <div class="side-menu">
            <ul>
                {{-- NOTE: Adjust these route names if your audit routes differ --}}
                <li>
                    <a href="{{ route('audit.dashboard') }}">
                        <span class="fa-solid fa-house"></span><small>Dashboard</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audit.profile') }}">
                        <span class="fa-regular fa-user"></span><small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audit.complaints.index') }}" class="active" aria-current="page">
                        <span class="fa-regular fa-envelope"></span><small>Complaints</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audit.feedback.index') }}">
                        <span class="fa-solid fa-comments"></span><small>Feedback</small>
                    </a>
                </li>
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
    <div class="vd-page">
        <div class="vd-top">
            <div>
                <div class="vd-breadcrumb">Audit / Complaints / Addressed</div>
                <h1 class="vd-title">
                    Addressed Complaints
                    <span class="vd-title-icon"><i class="fa-solid fa-user-check"></i></span>
                </h1>
                <div class="vd-subtitle">View addressed complaints and export/print reports</div>
            </div>

            <div class="vd-actions d-flex gap-2 flex-wrap justify-content-end">
                <div class="dropdown">
                    <button class="btn vd-btn vd-btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Complaint Actions
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('audit.complaints.index') }}">
                                Complaints <i class="fa-solid fa-comments ms-1"></i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('audit.complaints.rejected') }}">
                                Spams <i class="fa-solid fa-file-circle-exclamation ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <button type="button" class="btn vd-btn vd-btn-outline vd-btn-sm" id="btnExportXlsx">
                    <i class="fa-solid fa-file-excel me-1"></i> Export Excel
                </button>

                <button class="btn vd-btn vd-btn-outline vd-btn-sm print-button" onclick="printTable()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
            </div>
        </div>

        {{-- Stats --}}
        <div class="vd-stats">
            <div class="vd-stat">
                <div class="vd-stat-label">Total Addressed</div>
                <div class="vd-stat-value">{{ $solvedComplaints->count() }}</div>
            </div>
            <div class="vd-stat">
                <div class="vd-stat-label">Today</div>
                <div class="vd-stat-value">
                    {{ $solvedComplaints->where('created_at','>=', now()->startOfDay())->count() }}
                </div>
            </div>
            <div class="vd-stat">
                <div class="vd-stat-label">This Week</div>
                <div class="vd-stat-value">
                    {{ $solvedComplaints->where('created_at','>=', now()->startOfWeek())->count() }}
                </div>
            </div>
        </div>

        <div class="vd-card">
            <div class="vd-card-head">
                <div class="vd-card-title">
                    <i class="fa-solid fa-table-list me-2"></i> Addressed Records
                </div>

                <div class="vd-tools">
                    <div class="vd-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input id="feedbackFilter" type="text" placeholder="Search name, client type, date...">
                    </div>
                </div>
            </div>

            <div class="vd-card-body" id="print-section">

                <div class="print-header d-none">
                    <div style="text-align: center;">
                        <img src="{{ asset('assets/shortcut_logo.png') }}" alt="Logo" style="height: 80px;">
                        <h4>Quirino State University</h4>
                        <h5>Addressed Complaints Report</h5>
                        <p>Date: <script>document.write(new Date().toLocaleDateString());</script></p>
                        <hr>
                    </div>
                </div>
                <h2 class="print-section">Addressed Complaints</h2>

                {{-- IMPORTANT: remove table-striped, use vd-table --}}
                <table id="table-solved" class="table vd-table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>Client Type</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($solvedComplaints as $complaint)
                        <tr>
                            <td class="row-id"></td>
                            <td>{{ $complaint->name ?? '-' }}</td>
                            <td>{{ $complaint->client_type }}</td>
                            <td data-order="{{ strtotime($complaint->created_at) }}">
                                {{ $complaint->created_at }}
                            </td>
                            <td class="message-cell">
                                {{-- Print: message only --}}
                                <span class="d-none d-print-block">{{ $complaint->message }}</span>

                                {{-- Excel export: full message --}}
                                <span class="d-none export-message">{{ $complaint->message }}</span>

                                {{-- Screen only: View button --}}
                                <button type="button"
                                        class="btn vd-btn vd-btn-outline vd-btn-sm d-print-none"
                                        data-bs-toggle="modal"
                                        data-bs-target="#complaintModal{{ $complaint->id }}">
                                    View
                                </button>
                            </td>
                        </tr>

                        {{-- Modal --}}
                        <div class="modal fade" id="complaintModal{{ $complaint->id }}" tabindex="-1" aria-labelledby="complaintModalLabel{{ $complaint->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="complaintModalLabel{{ $complaint->id }}">Complaint Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <strong>Name:</strong> {{ $complaint->name }} <br>
                                        <strong>Email:</strong> {{ $complaint->email }} <br>
                                        <strong>Client Type:</strong> {{ $complaint->client_type }} <br>
                                        <strong>Department:</strong> {{ $complaint->department }} <br>
                                        <strong>Contact Number:</strong> {{ $complaint->contact_number }} <br>

                                        <strong>Message:</strong>
                                        <div class="complaint-message mb-3">{{ $complaint->message }}</div>

                                        @if($complaint->image)
                                            <strong>Attached Image:</strong><br>
                                            <img
                                                src="{{ asset('storage/' . $complaint->image) }}"
                                                alt="Uploaded Image"
                                                class="img-fluid rounded mb-3"
                                                style="max-height: 300px;"
                                            >
                                        @endif

                                        @if($complaint->video)
                                            <strong>Attached Video:</strong><br>
                                            <video controls class="w-100 rounded mb-3" style="max-height: 300px;">
                                                <source src="{{ asset('storage/' . $complaint->video) }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>

                <footer class="print-only">
                    <p>&copy; {{ date('Y') }} QSU E-PACD</p>
                </footer>
            </div>
        </div>
    </div>
</main>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap/jquery.dataTables.min.css') }}">
<script src="{{ asset('js/datatables/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/xlsx.full.min.js') }}"></script>

<!-- Print Script -->
<script>
function printTable() {
  const dt = $('#table-solved').DataTable();
  const originalLen = dt.page.len();

  // show ALL rows so they exist in the DOM for printing
  dt.page.len(-1).draw();

  setTimeout(() => {
    const titleHtml = document.querySelector("#print-section .print-section")?.outerHTML || "";
    const tableHtml = document.getElementById("table-solved")?.outerHTML || "";

    const headerEl = document.querySelector(".print-header");
    const headerHtml = headerEl ? headerEl.innerHTML : "";

    const cssLinks = Array.from(document.querySelectorAll('link[rel="stylesheet"]'))
      .map(link => `<link rel="stylesheet" href="${link.href}">`)
      .join("\n");

    const styleTags = Array.from(document.querySelectorAll("style"))
      .map(s => s.outerHTML)
      .join("\n");

    const today = new Date().toLocaleDateString();

    const fixedHeader = headerHtml.includes("Date:")
      ? headerHtml.replace(/<p>\s*Date:.*?<\/p>/i, `<p>Date: ${today}</p>`)
      : (headerHtml + `<p>Date: ${today}</p>`);

    const w = window.open("", "", "width=1200,height=800");

    w.document.write(`
    <html>
        <head>
        <title>Print - Solved Complaints</title>
        ${cssLinks}
        ${styleTags}
        <style>
            body { background:#fff; margin:0; padding:0; }
            .print-header { display:block !important; text-align:center; margin-bottom:10px; }

            table { width:100% !important; border-collapse:collapse !important; font-size:12px !important; }
            th, td { border:1px solid #000 !important; padding:6px !important; vertical-align:top !important; }
            tr, td, th { page-break-inside:avoid !important; }

            .d-none { display:none !important; }
            .d-print-block { display:block !important; }
            .d-print-none { display:none !important; }

            button, .btn { display:none !important; }

            .table-striped > tbody > tr:nth-of-type(odd) > * {
            --bs-table-accent-bg: transparent !important;
            }
        </style>
        </head>
        <body>
        <div class="print-header">${fixedHeader}</div>
        ${titleHtml}
        ${tableHtml}
        </body>
    </html>
    `);

    w.document.close();
    w.focus();
    w.print();
    w.close();

    // restore original paging
    dt.page.len(originalLen).draw();
  }, 200);
}
</script>

<script>
$(document).ready(function () {
  const table = $('#table-solved').DataTable({
    pageLength: 10,
    lengthChange: false,
    dom: 'rtip',
    order: [[3, 'asc']], // Date column (0=ID,1=Name,2=Client Type,3=Date)
    columnDefs: [
      { targets: 0, orderable: false, searchable: false } // ID col
    ]
  });

  // Fill the ID column every draw (pagination/search/sort)
  function renumber() {
    const info = table.page.info();
    table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
      cell.innerHTML = info.start + i + 1;
    });
  }

  renumber();
  table.on('draw.dt', renumber);

  // custom search
  $('#solvedFilter').on('keyup', function () {
    $('#table-solved').DataTable().search(this.value).draw();
});
});
</script>

<script>
document.getElementById("btnExportXlsx").addEventListener("click", function () {
  const dt = $('#table-solved').DataTable();
  const originalPageLen = dt.page.len();

  dt.page.len(-1).draw();

  setTimeout(() => {
    const today = new Date().toLocaleDateString();
    const data = [];

    data.push(["QUIRINO STATE UNIVERSITY"]);
    data.push(["E-PUBLIC ASSISTANCE AND COMPLAINT DESK (E-PACD)"]);
    data.push(["Solved Complaints Report"]);
    data.push([`Date: ${today}`]);
    data.push([]); 

    data.push(["ID", "Name", "Client Type", "Date", "Details"]);

    $('#table-solved tbody tr').each(function () {
      const tds = $(this).find('td');

      const id = $(tds[0]).text().trim();
      const name = $(tds[1]).text().trim();
      const clientType = $(tds[2]).text().trim();
      const date = $(tds[3]).text().trim();

      // column 4 is Details/Message
      const details = $(tds[4]).find('.export-message').text().trim()
                    || $(tds[4]).text().trim();

      data.push([id, name, clientType, date, details]);
    });

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(data);

    ws["!merges"] = [
      { s: { r: 0, c: 0 }, e: { r: 0, c: 4 } },
      { s: { r: 1, c: 0 }, e: { r: 1, c: 4 } },
      { s: { r: 2, c: 0 }, e: { r: 2, c: 4 } },
      { s: { r: 3, c: 0 }, e: { r: 3, c: 4 } },
    ];

    ws["!cols"] = [
      { wch: 6 },   // ID
      { wch: 22 },  // Name
      { wch: 16 },  // Client Type
      { wch: 22 },  // Date
      { wch: 70 },  // Details/Message
    ];

    XLSX.utils.book_append_sheet(wb, ws, "Solved Complaints");

    const filename = `solved-complaints-${new Date().toISOString().slice(0,19).replace(/[:T]/g,'-')}.xlsx`;
    XLSX.writeFile(wb, filename);

    dt.page.len(originalPageLen).draw();
  }, 120);
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
    }

    applyTheme(localStorage.getItem(THEME_KEY) || 'light');

    toggleBtn.addEventListener('click', () => {
        const next = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
        localStorage.setItem(THEME_KEY, next);
        applyTheme(next);
    });
});
</script>
@endsection
