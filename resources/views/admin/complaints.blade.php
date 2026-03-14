@extends('layouts.complaints-management')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Complaints')

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
        <button type="button" class="menu-close d-lg-none" aria-label="Close menu" onclick="document.body.classList.remove('menu-open'); document.getElementById('mobileSidebar').style.transform='translateX(-100%)'; document.getElementById('menuOverlay').style.display='none';">
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
<button type="button" id="menuOverlay" class="menu-overlay d-lg-none" aria-label="Close menu" onclick="document.body.classList.remove('menu-open'); document.getElementById('mobileSidebar').style.transform='translateX(-100%)'; this.style.display='none';"></button>

<div class="main-content">
    <header>
        <div class="header-content">
            <button type="button" class="menu-toggle d-lg-none" aria-label="Open menu" onclick="(function(){ const sidebar = document.getElementById('mobileSidebar'); const overlay = document.getElementById('menuOverlay'); const isOpen = document.body.classList.toggle('menu-open'); if (sidebar) { sidebar.style.display='block'; sidebar.style.transform = isOpen ? 'translateX(0)' : 'translateX(-100%)'; } if (overlay) { overlay.style.display = isOpen ? 'block' : 'none'; } })()">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <main>
        <div class="vd-page">
            <div class="vd-top">
                <div>
                    <div class="vd-breadcrumb">Admin / Complaints</div>
                    <h1 class="vd-title">
                        Complaints <span class="vd-title-icon"><i class="fa-solid fa-comments"></i></span>
                    </h1>
                    <div class="vd-subtitle">Review, Addressed, or Mark as Spam Complaints</div>
                </div>

                <div class="vd-actions">
                    <div class="dropdown">
                        <button class="btn vd-btn vd-btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Complaint Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.complaints.solved') }}">Addressed <i class="fa-solid fa-user-check ms-1"></i></a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.complaints.rejected') }}">Spams<i class="fa-solid fa-file-circle-exclamation ms-1"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- quick stats (optional but looks pro) --}}
            <div class="vd-stats">
                <div class="vd-stat">
                    <div class="vd-stat-label">Total</div>
                    <div class="vd-stat-value">{{ $complaints->count() }}</div>
                </div>
                <div class="vd-stat">
                    <div class="vd-stat-label">Pending</div>
                    <div class="vd-stat-value">
                        {{ $complaints->where('status','Pending')->count() }}
                    </div>
                </div>
                <div class="vd-stat">
                    <div class="vd-stat-label">Today</div>
                    <div class="vd-stat-value">
                        {{ $complaints->where('created_at','>=', now()->startOfDay())->count() }}
                    </div>
                </div>
            </div>

            <div class="vd-card">
                <div class="vd-card-head">
                    <div class="vd-card-title">
                        <i class="fa-solid fa-table-list me-2"></i> Complaint Records
                    </div>

                    <div class="vd-tools">
                        <div class="vd-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input id="feedbackFilter" type="text" placeholder="Search name, type, status...">
                        </div>
                    </div>
                </div>

                <div class="vd-card-body">
                    <table id="table-complaint" class="table vd-table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th>Client Type</th>
                                <th>Date</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                    @foreach($complaints as $complaint)
                                        <tr>
                                            <td data-label="ID">{{ $loop->iteration }}</td>
                                             <td data-label="Name">{{ $complaint->name ?? '-' }}</td>
                                            <td data-label="Client Type">{{ $complaint->client_type }}</td>
                                            <td data-label="Date">{{ $complaint->created_at }}</td>
                                            <td data-label="Message">
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#complaintModal{{ $complaint->id }}">
                                                    View
                                                </button>
                                            </td>
                                            <td data-label="Status">
                                                @php
                                                    $status = strtolower($complaint->status ?? 'pending');
                                                    $badge = $status === 'pending' ? 'vd-badge-warning' : 'vd-badge-success';
                                                @endphp
                                                <span class="vd-badge {{ $badge }}">{{ $complaint->status }}</span>
                                            </td>
                                            <td class="text-end vd-actions-cell" data-label="Actions">
                                                @if($complaint->status == 'Pending')
                                                    <div class="vd-row-actions">
                                                        <button type="button"
                                                                class="btn vd-btn vd-btn-primary vd-btn-sm solve-btn"
                                                                data-id="{{ $complaint->id }}"
                                                                data-name="{{ $complaint->name }}">
                                                            <i class="fa-solid fa-check me-1"></i> Solve
                                                        </button>

                                                        <button type="button"
                                                                class="btn vd-btn vd-btn-danger vd-btn-sm spam-btn"
                                                                data-id="{{ $complaint->id }}"
                                                                data-name="{{ $complaint->name }}">
                                                            <i class="fa-solid fa-ban me-1"></i> Spam
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No Actions</span>
                                                @endif
                                            </td>
                                        </tr>
                        
                                       <!-- Modal for Complaint Details -->
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
                                                        <strong>Department:</strong> {{ $complaint->department}} <br>
                                                        <strong>Contact Number:</strong> {{ $complaint->contact_number }} <br>
                                                        <strong>Message:</strong>
                                                        <div class="complaint-message mb-3">
                                                            {{ $complaint->message }}
                                                        </div>

                                                       {{-- Image Preview --}}
                                                        @if($complaint->image)
                                                            <strong>Image Proof:</strong><br>

                                                            <!-- Clickable image -->
                                                            <img 
                                                                src="{{ asset('storage/' . $complaint->image) }}" 
                                                                alt="Complaint Image" 
                                                                class="img-fluid rounded mb-3 zoomable-image" 
                                                                data-modal-id="imageModal{{ $complaint->id }}"
                                                                style="max-height: 300px; cursor: pointer;"
                                                            >

                                                            <!-- Fullscreen modal -->
                                                            <div id="imageModal{{ $complaint->id }}" class="image-modal">
                                                                <span class="image-close">&times;</span>
                                                                <img class="image-modal-content" id="fullImage{{ $complaint->id }}">
                                                            </div>
                                                        @endif

                                                        {{-- Video Preview --}}
                                                        @if($complaint->video)
                                                            <strong>Video Proof:</strong><br>
                                                            <video controls class="w-100 rounded mb-3" style="max-height: 300px;">
                                                                <source src="{{ asset('storage/' . $complaint->video) }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @endif
                                                        <br>
                                                        <strong>Status:</strong> {{ $complaint->status }}
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
                            </div>
                        </div>
                    </div>

                            <!-- SOLVE COMPLAINT MODAL -->
                            <div class="modal fade" id="solveModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="solveForm" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Mark Complaint as Solved</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p>Complaint by <strong id="solveUserName"></strong></p>

                                                <!-- WHERE SENT -->
                                                <div class="mb-3">
                                                    <label class="form-label">Where was the complaint sent?</label>
                                                    <input
                                                        type="text"
                                                        name="sent_to"
                                                        id="solveSentTo"
                                                        class="form-control"
                                                        placeholder="e.g., Registrar / Guidance Office / Dean"
                                                        required
                                                    >
                                                </div>

                                                <!-- DATE SENT -->
                                                <div class="mb-3">
                                                    <label class="form-label">Date complaint was sent</label>
                                                    <input
                                                        type="date"
                                                        name="sent_date"
                                                        id="solveSentDate"
                                                        class="form-control"
                                                        required
                                                    >
                                                </div>

                                                <!-- ACTION TAKEN -->
                                                <div class="mb-3">
                                                    <label class="form-label">Action taken / How was it solved?</label>
                                                    <textarea
                                                        name="action_taken"
                                                        id="solveActionTaken"
                                                        class="form-control"
                                                        rows="4"
                                                        placeholder="Describe what you did to resolve the complaint..."
                                                        required
                                                    ></textarea>
                                                </div>

                                                <!-- DATE ACTION -->
                                                <div class="mb-2">
                                                    <label class="form-label">Date action was completed</label>
                                                    <input
                                                        type="date"
                                                        name="action_date"
                                                        id="solveActionDate"
                                                        class="form-control"
                                                        required
                                                    >
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            
                            <!-- SPAM CONFIRMATION MODAL -->
                            <div class="modal fade" id="spamConfirmModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mark as Spam?</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p>Are you sure you want to move <strong id="spamUserName"></strong>'s complaint to the spam list?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">No, cancel</button>
                                            <button class="btn btn-danger" id="proceedSpamReason">Yes, continue</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- SPAM REASON MODAL -->
                            <div class="modal fade" id="spamReasonModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="spamReasonForm" method="POST">
                                            @csrf
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reason for Marking as Spam</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <label class="form-label">Select Reason</label>
                                                <select class="form-select" name="reason" id="spamReasonSelect" required>
                                                    <option value="" selected disabled>Choose...</option>
                                                    <option>Unrelated Complaint</option>

                                                    <option disabled>─────────</option>

                                                    <option value="other">Other (Specify)</option>
                                                </select>

                                                <div id="otherReasonWrapper" class="mt-3" style="display:none;">
                                                    <label class="form-label">Specify</label>
                                                    <input type="text" name="other_reason" class="form-control">
                                                </div>

                                                <div class="mt-3">
                                                <label class="form-label">Message to user (will be emailed + notified)</label>
                                                <textarea
                                                    class="form-control"
                                                    name="admin_message"
                                                    rows="4"
                                                    placeholder="Explain why it was marked as spam, and the penalty (ex: 1 week ban)..."
                                                    required
                                                ></textarea>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <footer class="print-only">
                                <p>&copy; {{ date('Y') }} QSU E-PACD</p>
                            </footer>
                        </div>
                    </div>  
                 </div>
             </div>
        </main>
    </div>

<link rel="stylesheet" href="{{ asset('css/bootstrap/jquery.dataTables.min.css') }}">
<script src="{{ asset('js/datatables/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<!-- Print Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // === PRINT FUNCTION ===
    function printTable() {
        const printContents = document.getElementById("print-section").innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    // =========================
    // SOLVE MODAL wiring
    // =========================
    const solveModalEl = document.getElementById('solveModal');
    const solveModal = solveModalEl ? new bootstrap.Modal(solveModalEl) : null;

    const solveForm = document.getElementById('solveForm');
    const solveUserName = document.getElementById('solveUserName');
    const solveTypeSelect = document.getElementById('solveTypeSelect');
    const otherTypeWrapper = document.getElementById('otherTypeWrapper');
    const otherTypeInput = document.getElementById('otherTypeInput');

    document.querySelectorAll('.solve-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name || 'Client';

            if (solveUserName) solveUserName.textContent = name;

            // set form action to POST /audit/complaints/{id}/solve
            if (solveForm) solveForm.action = "{{ url('admin/complaints') }}/" + id + "/solve";

            // reset fields
            if (solveTypeSelect) solveTypeSelect.value = "";
            if (otherTypeInput) otherTypeInput.value = "";
            if (otherTypeWrapper) otherTypeWrapper.style.display = "none";

            solveModal && solveModal.show();
        });
    });

    if (solveTypeSelect) {
        solveTypeSelect.addEventListener('change', () => {
            const isOther = solveTypeSelect.value === 'other';
            if (otherTypeWrapper) otherTypeWrapper.style.display = isOther ? 'block' : 'none';
            if (otherTypeInput) otherTypeInput.required = isOther;
            if (!isOther && otherTypeInput) otherTypeInput.value = '';
        });
    }

    // When submitting solve, if type=other, replace with the specified text (so controller only needs "type")
    if (solveForm) {
        solveForm.addEventListener('submit', () => {
            if (solveTypeSelect && solveTypeSelect.value === 'other') {
                const val = (otherTypeInput?.value || '').trim();
                if (val.length > 0) {
                    solveTypeSelect.value = val;
                }
            }
        });
    }

    

    // =========================
    // SPAM MODAL wiring
    // =========================
    const spamConfirmEl = document.getElementById('spamConfirmModal');
    const spamConfirmModal = spamConfirmEl ? new bootstrap.Modal(spamConfirmEl) : null;

    const spamReasonEl = document.getElementById('spamReasonModal');
    const spamReasonModal = spamReasonEl ? new bootstrap.Modal(spamReasonEl) : null;

    const spamUserName = document.getElementById('spamUserName');
    const proceedSpamReason = document.getElementById('proceedSpamReason');

    const spamReasonForm = document.getElementById('spamReasonForm');
    const spamReasonSelect = document.getElementById('spamReasonSelect');
    const otherReasonWrapper = document.getElementById('otherReasonWrapper');
    const otherReasonInput = document.getElementById('otherReasonInput');

    let spamCurrentId = null;

    document.querySelectorAll('.spam-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            spamCurrentId = btn.dataset.id;
            const name = btn.dataset.name || 'Client';

            if (spamUserName) spamUserName.textContent = name;

            // reset reason form fields
            if (spamReasonSelect) spamReasonSelect.value = "";
            if (otherReasonInput) otherReasonInput.value = "";
            if (otherReasonWrapper) otherReasonWrapper.style.display = "none";

            spamConfirmModal && spamConfirmModal.show();
        });
    });

    if (proceedSpamReason) {
        proceedSpamReason.addEventListener('click', () => {
            spamConfirmModal && spamConfirmModal.hide();

            // set form action to POST /audit/complaints/{id}/reject
            if (spamReasonForm && spamCurrentId) {
                spamReasonForm.action = "{{ url('admin/complaints') }}/" + spamCurrentId + "/reject";
            }

            spamReasonModal && spamReasonModal.show();
        });
    }

    if (spamReasonSelect) {
        spamReasonSelect.addEventListener('change', () => {
            const isOther = spamReasonSelect.value === 'other';
            if (otherReasonWrapper) otherReasonWrapper.style.display = isOther ? 'block' : 'none';
            if (otherReasonInput) otherReasonInput.required = isOther;
            if (!isOther && otherReasonInput) otherReasonInput.value = '';
        });
    }
});

    // === IMAGE ZOOM MODAL ===
    document.querySelectorAll('.zoomable-image').forEach(img => {
        const modalId = img.dataset.modalId;
        const modal = document.getElementById(modalId);
        if(!modal) return;

        const modalImg = modal.querySelector('.image-modal-content');
        const closeBtn = modal.querySelector('.image-close');

        img.addEventListener('click', () => {
            modal.style.display = 'block';
            if(modalImg) modalImg.src = img.src;
        });

        if(closeBtn){
            closeBtn.addEventListener('click', () => modal.style.display = 'none');
        }

        modal.addEventListener('click', (event) => {
            if(event.target === modal) modal.style.display = 'none';
        });
    });

    // === SESSION CHECK ===
    if (!@json(Auth::check())) {
        window.location.href = "{{ route('home') }}";
    }

    // === BACK BUTTON PROTECTION ===
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = () => window.location.replace("{{ route('login') }}");

    // === FORM RESET ON UNLOAD ===
    window.addEventListener('beforeunload', () => {
        document.querySelectorAll('form').forEach(form => form.reset());
        const chatMessages = document.getElementById('chat-messages');
        if(chatMessages) chatMessages.innerHTML = '';
    });



$(document).ready(function() {
        const table = $('#table-complaint').DataTable({
            pageLength: 10,
            lengthChange: false,
             dom: 'rtip'
            // searching: false   // disable default search box
        });

        // connect custom search box
        $('#feedbackFilter').on('keyup', function () {
            table.search(this.value).draw();
        });
    });

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
        body.classList.toggle('menu-open', isOpen);
    }

    menuToggle?.addEventListener('click', () => {
        setMenuOpen(!body.classList.contains('menu-open'));
    });

    menuClose?.addEventListener('click', () => setMenuOpen(false));
    menuOverlay?.addEventListener('click', () => setMenuOpen(false));

    window.addEventListener('resize', () => {
        if (window.innerWidth > 992) {
            setMenuOpen(false);
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
