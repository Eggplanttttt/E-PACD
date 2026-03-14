@extends('layouts.admin-profile')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Admin Profile')

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
@else
    <script>window.location = "{{ route('home') }}";</script>
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
            <small>Super Admin</small>
        </div>
        <div class="side-menu">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}"><span class="fa-solid fa-house"></span><small>Dashboard</small></a></li>
                <li><a href="{{ route('admin.profile') }}" class="active" aria-current="page"><span class="fa-regular fa-user"></span><small>Profile</small></a></li>
                <li><a href="{{ route('admin.complaints.index') }}"><span class="fa-regular fa-envelope"></span><small>Complaints</small></a></li>
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
</div>

    <main>
        <div class="page-header">
            <h1>Admin Accounts <i class="fa-solid fa-users"></i></h1>
            <small>Home / Profile</small>
        </div>

        <div class="container-fluid mt-3">
            <div class="admin-toolbar mb-3">
                <div>
                    <p class="admin-sub mb-0">Manage administrator accounts</p>
                </div>

                <button type="button" class="btn btn-success admin-add-btn" data-bs-toggle="modal" data-bs-target="#addAdmin">
                    <i class="bi bi-person-plus"></i> Add Admin
                </button>
            </div>

            <!-- Admin Cards -->
            <div class="row">
                @foreach($admins as $admin)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card admin-card border-0">
                        <div class="admin-card-body">
                            <div class="admin-avatar-wrap">
                                <img src="{{ asset('storage/uploaded_img/' . ($admin->image ?? 'default-avatar.png')) }}"
                                    class="admin-avatar" alt="Admin Image">
                            </div>

                            <div class="admin-name">
                                {{ $admin->firstname }}
                                @if($admin->middlename)
                                    {{ strtoupper(substr($admin->middlename, 0, 1)) }}.
                                @endif
                                {{ $admin->lastname }}
                                @if($admin->suffix && $admin->suffix !== 'N.A')
                                    , {{ $admin->suffix }}
                                @endif
                            </div>

                            <div class="admin-meta">
                                <span class="admin-role badge text-uppercase">{{ $admin->role ?? 'admin' }}</span>
                                <div class="admin-email">{{ $admin->email }}</div>
                            </div>

                            <div class="admin-actions">
                                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $admin->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $admin->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit-{{ $admin->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('admin.profile.edit', $admin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h4 class="modal-title">Update Account</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 mt-3">
                                        <label>First Name:</label>
                                        <input type="text" class="form-control" name="firstname" value="{{ $admin->firstname }}" autocomplete="off" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label>Middle Name:</label>
                                        <input type="text" class="form-control" name="middlename" value="{{ $admin->middlename }}" autocomplete="off">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label>Last Name:</label>
                                        <input type="text" class="form-control" name="lastname" value="{{ $admin->lastname }}" autocomplete="off" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Suffix Name:</label>
                                        <select class="form-select" id="editSuffixSelect_{{ $admin->id }}" name="suffix"  data-current-suffix="{{ $admin->suffix }}">
                                            <option value="" disabled {{ !$admin->suffix ? 'selected' : '' }}>Select Suffix</option>
                                            <option value="Jr." {{ $admin->suffix == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                            <option value="Sr." {{ $admin->suffix == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                            <option value="I" {{ $admin->suffix == 'I' ? 'selected' : '' }}>I</option>
                                            <option value="II" {{ $admin->suffix == 'II' ? 'selected' : '' }}>II</option>
                                            <option value="III" {{ $admin->suffix == 'III' ? 'selected' : '' }}>III</option>
                                            <option value="IV" {{ $admin->suffix == 'IV' ? 'selected' : '' }}>IV</option>
                                            <option value="V" {{ $admin->suffix == 'V' ? 'selected' : '' }}>V</option>
                                            <option value="VI" {{ $admin->suffix == 'VI' ? 'selected' : '' }}>VI</option>
                                            <option value="VII" {{ $admin->suffix == 'VII' ? 'selected' : '' }}>VII</option>
                                            <option value="VIII" {{ $admin->suffix == 'VIII' ? 'selected' : '' }}>VIII</option>
                                            <option value="IX" {{ $admin->suffix == 'IX' ? 'selected' : '' }}>IX</option>
                                            <option value="X" {{ $admin->suffix == 'X' ? 'selected' : '' }}>X</option>
                                            <option value="PhD" {{ $admin->suffix == 'PhD' ? 'selected' : '' }}>PhD</option>
                                            <option value="MD" {{ $admin->suffix == 'MD' ? 'selected' : '' }}>MD</option>
                                            <option value="CPA" {{ $admin->suffix == 'CPA' ? 'selected' : '' }}>CPA</option>
                                            <option value="JD" {{ $admin->suffix == 'JD' ? 'selected' : '' }}>JD</option>
                                            <option value="N.A" {{ $admin->suffix == 'N.A' ? 'selected' : '' }}>N.A</option>
                                            <option value="Other"
                                                {{ ($admin->suffix && !in_array($admin->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>

                                        <!-- Input shown only if "Other" or unknown suffix -->
                                        <input 
                                            type="text" 
                                            class="form-control mt-2" 
                                            id="editOtherSuffixInput_{{ $admin->id }}" 
                                            name="other_suffix" 
                                            placeholder="Please specify your suffix"
                                            value="{{ ($admin->suffix && !in_array($admin->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? $admin->suffix : '' }}"
                                            style="{{ ($admin->suffix && !in_array($admin->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? 'display: block;' : 'display: none;' }}"
                                            autocomplete="off"
                                        >
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Role:</label>
                                        <select class="form-select" name="role" required>
                                            <option value="io" {{ $admin->role === 'io' ? 'selected' : '' }}>IO</option>
                                            <option value="audit" {{ $admin->role === 'audit' ? 'selected' : '' }}>Audit</option>
                                            <option value="super_admin" {{ $admin->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>New Password:</label>
                                        <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                                    </div>
                                    <div class="mb-3">
                                        <label>Confirm Password:</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Leave blank to keep current">
                                    </div>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text">Image</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="delete-{{ $admin->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <form id="deleteForm-{{ $admin->id }}" action="{{ route('admin.profile.delete', $admin->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                        <h4 class="modal-title">Delete Account</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                        <p>Are you sure you want to delete this account?</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger confirm-delete-btn" data-id="{{ $admin->id }}">Yes</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>

                <!-- Snackbar / Toast -->
                <div id="undo-toast" class="undo-toast">
                <span id="undo-message">Account deleted.</span>
                <button id="undo-button" class="undo-btn">Undo</button>
                </div>

                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.profile.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add New Admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3">
                        <label>First Name:</label>
                        <input type="text" class="form-control" name="firstname" placeholder="Enter First Name" autocomplete="off" pattern="[A-Za-z\s]+" title="Only letters are allowed" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label>Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" placeholder="Enter Middle Name" autocomplete="off">
                    </div>
                    <div class="mb-3 mt-3">
                        <label>Last Name:</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name" autocomplete="off" required>
                    </div>

                    <!-- Fixed Suffix Section -->
                    <div class="mb-3 mt-3">
                        <label class="form-label">Suffix Name:</label>
                        <select class="form-select" id="suffixSelect" name="suffix">
                            <option value="" disabled selected hidden>Select Suffix</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                            <option value="VII">VII</option>
                            <option value="VIII">VIII</option>
                            <option value="IX">IX</option>
                            <option value="X">X</option>
                            <option value="PhD">PhD</option>
                            <option value="MD">MD</option>
                            <option value="CPA">CPA</option>
                            <option value="JD">JD</option>
                            <option value="Other">Other</option>
                            <option value="N.A">N.A</option>
                        </select>

                        <input 
                            type="text" 
                            class="form-control mt-2" 
                            id="otherSuffixInput" 
                            name="other_suffix" 
                            placeholder="Please specify your suffix"
                            style="display: none;"
                            autocomplete="off"
                        >
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Role:</label>
                        <select class="form-select" name="role" required>
                            <option value="" disabled selected hidden>Select Role</option>
                            <option value="io">IO</option>
                            <option value="audit">Audit</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password:</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Upload</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    function handleSuffix(select, otherInput) {
    // Show/hide "Other" input based on selection
    select.addEventListener('change', function() {
        if (this.value === 'Other') {
            otherInput.style.display = 'block';
            otherInput.required = true; // Only required if user selects "Other"
        } else {
            otherInput.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
        }
    });

    // On form submit, always save suffix
    select.closest('form').addEventListener('submit', function(e) {
        let finalSuffix = select.value;

        if (select.value === 'Other' && otherInput.value.trim() !== '') {
            finalSuffix = otherInput.value.trim();
        } else if (!finalSuffix) {
            // If edit modal and user didn't change, keep original value
            finalSuffix = select.getAttribute('data-current-suffix') || '';
        }

        // Remove any existing hidden input first
        const existingHidden = this.querySelector('input[name="suffix"][type="hidden"]');
        if (existingHidden) existingHidden.remove();

        // Append hidden input with the final suffix
        const hiddenSuffix = document.createElement('input');
        hiddenSuffix.type = 'hidden';
        hiddenSuffix.name = 'suffix';
        hiddenSuffix.value = finalSuffix;
        this.appendChild(hiddenSuffix);
    });
}


    // Add Admin Modal
    const suffixSelect = document.getElementById('suffixSelect');
    const otherSuffixInput = document.getElementById('otherSuffixInput');
    if (suffixSelect && otherSuffixInput) handleSuffix(suffixSelect, otherSuffixInput);

    // Edit Admin Modals
    document.querySelectorAll('[id^="editSuffixSelect_"]').forEach(select => {
        const adminId = select.id.split('_')[1];
        const otherInput = document.getElementById(`editOtherSuffixInput_${adminId}`);
        if (!otherInput) return;
        handleSuffix(select, otherInput);
    });

    // Auto-generate email in Add Admin Modal
    const addAdminModal = document.getElementById('addAdmin');
    if (addAdminModal) {
        addAdminModal.addEventListener('shown.bs.modal', function() {
            const firstNameInput = addAdminModal.querySelector('input[name="firstname"]');
            const lastNameInput = addAdminModal.querySelector('input[name="lastname"]');
            const emailInput = addAdminModal.querySelector('input[name="email"]');

            if (firstNameInput && lastNameInput && emailInput) {
                function generateEmail() {
                    const first = firstNameInput.value.trim().toLowerCase().replace(/\s+/g, '');
                    const last = lastNameInput.value.trim().toLowerCase().replace(/\s+/g, '');
                    emailInput.value = first && last ? `${first}.${last}@qsu.edu.ph` : '';
                }
                firstNameInput.addEventListener('input', generateEmail);
                lastNameInput.addEventListener('input', generateEmail);
            }
        });
    }

    // Delete Undo Toast
    let deleteTimeout = null;
    let formToSubmit = null;

    document.querySelectorAll('.confirm-delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const adminId = this.getAttribute('data-id');
            formToSubmit = document.getElementById(`deleteForm-${adminId}`);

            const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
            modal.hide();

            const toast = document.getElementById('undo-toast');
            toast.classList.add('show');

            deleteTimeout = setTimeout(() => {
                if (formToSubmit) formToSubmit.submit();
            }, 10000);
        });
    });

    document.getElementById('undo-button').addEventListener('click', function () {
        clearTimeout(deleteTimeout);
        document.getElementById('undo-toast').classList.remove('show');
        formToSubmit = null;
    });

    // Enable submenu toggle
    document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const submenu = this.nextElementSibling;
            submenu.classList.toggle('show');
        });
    });

    // Inquiries unread badge
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

});
</script>

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
