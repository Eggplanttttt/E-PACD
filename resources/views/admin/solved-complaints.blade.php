@extends('layouts.complaints-management')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Solved Complaints')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-solved.css') }}">
@endsection

@section('content')
{{-- @auth
    @php
        $firstName = Auth::user()->firstname ?? '';
        $middleName = Auth::user()->middlename ?? '';
        $lastName = Auth::user()->lastname ?? '';
        $middleInitial = $middleName ? strtoupper(substr($middleName, 0, 1)) . '.' : '';
        $name = trim($firstName . ' ' . $middleInitial . ' ' . $lastName);
        $name = $name ?: "Administrator";

        $image = Auth::user()->image ?? 'default-avatar.png';
    @endphp
@endauth --}}

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
            <small>Admin</small>
        </div>
        <div class="side-menu">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}"><span class="fa-solid fa-house"></span><small>Dashboard</small></a></li>
                <li><a href="{{ route('admin.profile') }}"><span class="fa-regular fa-user"></span><small>Profile</small></a></li>
                <li><a href="{{ route('admin.complaints.index') }}" class="active" aria-current="page"><span class="fa-regular fa-envelope"></span><small>Complaints</small></a></li>
                <li>
                    <a href="{{ route('admin.inquiries.index') }}" class="d-flex justify-content-between align-items-center inquiries-menu-link">
                        <span class="inquiries-menu-main">
                            <span class="fa-solid fa-question-circle inquiries-menu-icon"></span>
                            <small>Inquiries</small>
                        </span>
                        <span id="inquiriesUnreadBadge" class="badge bg-danger ms-2" style="display:none;">0</span>
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


    <main>
    <div class="vd-page">

        {{-- top header (same style as pending) --}}
        <div class="vd-top">
        <div>
            <div class="vd-breadcrumb">Admin / Complaints / Addressed</div>

            <h1 class="vd-title">
            Addressed Complaints
            <span class="vd-title-icon"><i class="fa-solid fa-user-check"></i></span>
            </h1>

            <div class="vd-subtitle">View Addressed complaints and export/print reports</div>
        </div>

        <div class="vd-actions d-flex gap-2 align-items-center">
            {{-- dropdown actions --}}
            <div class="dropdown">
            <button class="btn vd-btn vd-btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Complaint Actions
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.complaints.index') }}">Complaints <i class="fa-solid fa-comments ms-1"></i></a></li>
                <li><a class="dropdown-item" href="{{ route('admin.complaints.rejected') }}">Spam List <i class="fa-solid fa-file-circle-exclamation ms-1"></i></a></li>
            </ul>
            </div>

            {{-- export + print (right side like pending style) --}}
            <button type="button" class="btn vd-btn vd-btn-outline vd-btn-sm" id="btnExportXlsx">
            <i class="fa-solid fa-file-excel me-1"></i> Export Excel
            </button>

            <button class="btn vd-btn vd-btn-outline vd-btn-sm" onclick="printTable()">
            <i class="bi bi-printer me-1"></i> Print
            </button>
        </div>
        </div>

        {{-- optional stats row (like pending) --}}
        <div class="vd-stats">
        <div class="vd-stat">
            <div class="vd-stat-label">Total Addressed</div>
            <div class="vd-stat-value">{{ $solvedComplaints->count() }}</div>
        </div>
        <div class="vd-stat">
            <div class="vd-stat-label">Today</div>
            <div class="vd-stat-value">{{ $solvedComplaints->where('created_at','>=', now()->startOfDay())->count() }}</div>
        </div>
        <div class="vd-stat">
            <div class="vd-stat-label">This Week</div>
            <div class="vd-stat-value">{{ $solvedComplaints->where('created_at','>=', now()->startOfWeek())->count() }}</div>
        </div>
        </div>

        {{-- modern card --}}
        <div class="vd-card">
        <div class="vd-card-head">
            <div class="vd-card-title">
            <i class="fa-solid fa-table-list me-2"></i> Addressed Records
            </div>

            {{-- search pill (like pending) --}}
            <div class="vd-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="solvedFilter" type="text" placeholder="Search name, client type, date...">
            </div>
        </div>

        <div class="vd-card-body">

            <div class="print-header d-none">
                <div style="text-align: center;">
                    <img src="{{ asset('assets/shortcut_logo.png') }}" alt="Logo" style="height: 80px;">
                    <h4>Quirino State University</h4>
                    <h5>Addressed Complaints Report</h5>
                    <p>Date: <script>document.write(new Date().toLocaleDateString());</script></p>
                    <hr>
                </div>
            </div>

            <div id="print-section">
            <h2 class="print-section">Addressed Complaints</h2>

            {{-- IMPORTANT: use vd-table, remove table-striped --}}
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
                    <td data-label="ID">{{ $loop->iteration }}</td>
                    <td data-label="Name">{{ $complaint->name ?? '-' }}</td>
                    <td data-label="Client Type">{{ $complaint->client_type }}</td>
                    <td data-label="Date">{{ $complaint->created_at }}</td>

                    <td class="message-cell" data-label="Details">
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

                    {{-- modal stays the same --}}
                    <div class="modal fade" id="complaintModal{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Complaint Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                            <img src="{{ asset('storage/' . $complaint->image) }}" class="img-fluid rounded mb-3" style="max-height: 300px;">
                            @endif

                            @if($complaint->video)
                            <strong>Attached Video:</strong><br>
                            <video controls class="w-100 rounded mb-3" style="max-height: 300px;">
                                <source src="{{ asset('storage/' . $complaint->video) }}">
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

    </div>
    </main>
    </div>
    </div>


<link rel="stylesheet" href="{{ asset('css/bootstrap/jquery.dataTables.min.css') }}">
<script src="{{ asset('js/datatables/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
<!-- Print Script -->
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

$(document).ready(function() {
  $('#table-solved').DataTable({
    pageLength: 10,
    lengthChange: false,
    dom: 'rtip' 
  });

// connect custom search box (if you have it)
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
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
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
