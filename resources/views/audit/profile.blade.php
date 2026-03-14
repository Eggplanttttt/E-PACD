@extends('layouts.admin-profile')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Audit Profiles')

@section('content')

<div class="sidebar" id="mobileSidebar">
    <div class="side-content">
        <button type="button" class="menu-close d-lg-none" aria-label="Close menu" onclick="closeMobileMenu()" onpointerup="closeMobileMenu()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="profile">
            <div class="profile-image">
                <img src="{{ asset('assets/logoo.png') }}" class="rounded-circle" width="100" height="100" alt="Logo">
            </div>
            <h4>E-PACD</h4>
            <small>Audit Office</small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="{{ route('audit.dashboard') }}">
                        <span class="fa-solid fa-house"></span><small>Dashboard</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audit.profile') }}" class="active" aria-current="page">
                        <span class="fa-regular fa-user"></span><small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audit.complaints.index') }}">
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
        <div class="page-header">
            <h1>Audit Accounts <i class="fa-solid fa-users"></i></h1>
            <small>Home / Audit Profiles</small>
        </div>

        <div class="container-fluid mt-3">

            <div class="audit-toolbar mb-3">
                <div>
                    <h1 class="audit-title mb-0">Audit Accounts</h1>
                </div>

                <button type="button" class="btn btn-success io-add-btn" data-bs-toggle="modal" data-bs-target="#addAudit">
                    <i class="bi bi-person-plus"></i> Add Account
                </button>
            </div>

            <!-- Audit Cards -->
            <div class="row">
                @foreach($audits as $audit)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card audit-card border-0">
                            <div class="audit-card-body">
                                <div class="audit-avatar-wrap">
                                    <img src="{{ asset('storage/uploaded_img/' . ($audit->image ?? 'default-avatar.png')) }}"
                                        class="audit-avatar" alt="Admin Image">
                                </div>

                                <div class="audit-name">
                                    {{ $audit->firstname }}
                                    @if($audit->middlename)
                                        {{ strtoupper(substr($audit->middlename, 0, 1)) }}.
                                    @endif
                                    {{ $audit->lastname }}
                                    @if($audit->suffix && $audit->suffix !== 'N.A')
                                        , {{ $audit->suffix }}
                                    @endif
                                </div>

                                <div class="admin-meta">
                                    <div class="audit-email">{{ $audit->email }}</div>
                                </div>

                                <div class="audit-actions">
                                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $audit->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $audit->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit-{{ $audit->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('audit.profile.edit', $audit->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h4 class="modal-title">Update Audit Account</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3 mt-3">
                                            <label>First Name:</label>
                                            <input type="text" class="form-control" name="firstname" value="{{ $audit->firstname }}" autocomplete="off" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label>Middle Name:</label>
                                            <input type="text" class="form-control" name="middlename" value="{{ $audit->middlename }}" autocomplete="off">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label>Last Name:</label>
                                            <input type="text" class="form-control" name="lastname" value="{{ $audit->lastname }}" autocomplete="off" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Suffix Name:</label>
                                            <select class="form-select" id="editSuffixSelect_{{ $audit->id }}" name="suffix" data-current-suffix="{{ $audit->suffix }}">
                                                <option value="" disabled {{ !$audit->suffix ? 'selected' : '' }}>Select Suffix</option>
                                                <option value="Jr." {{ $audit->suffix == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                                <option value="Sr." {{ $audit->suffix == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                                <option value="I" {{ $audit->suffix == 'I' ? 'selected' : '' }}>I</option>
                                                <option value="II" {{ $audit->suffix == 'II' ? 'selected' : '' }}>II</option>
                                                <option value="III" {{ $audit->suffix == 'III' ? 'selected' : '' }}>III</option>
                                                <option value="IV" {{ $audit->suffix == 'IV' ? 'selected' : '' }}>IV</option>
                                                <option value="V" {{ $audit->suffix == 'V' ? 'selected' : '' }}>V</option>
                                                <option value="VI" {{ $audit->suffix == 'VI' ? 'selected' : '' }}>VI</option>
                                                <option value="VII" {{ $audit->suffix == 'VII' ? 'selected' : '' }}>VII</option>
                                                <option value="VIII" {{ $audit->suffix == 'VIII' ? 'selected' : '' }}>VIII</option>
                                                <option value="IX" {{ $audit->suffix == 'IX' ? 'selected' : '' }}>IX</option>
                                                <option value="X" {{ $audit->suffix == 'X' ? 'selected' : '' }}>X</option>
                                                <option value="PhD" {{ $audit->suffix == 'PhD' ? 'selected' : '' }}>PhD</option>
                                                <option value="MD" {{ $audit->suffix == 'MD' ? 'selected' : '' }}>MD</option>
                                                <option value="CPA" {{ $audit->suffix == 'CPA' ? 'selected' : '' }}>CPA</option>
                                                <option value="JD" {{ $audit->suffix == 'JD' ? 'selected' : '' }}>JD</option>
                                                <option value="N.A" {{ $audit->suffix == 'N.A' ? 'selected' : '' }}>N.A</option>
                                                <option value="Other"
                                                    {{ ($audit->suffix && !in_array($audit->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>

                                            <input
                                                type="text"
                                                class="form-control mt-2"
                                                id="editOtherSuffixInput_{{ $audit->id }}"
                                                name="other_suffix"
                                                placeholder="Please specify your suffix"
                                                value="{{ ($audit->suffix && !in_array($audit->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? $audit->suffix : '' }}"
                                                style="{{ ($audit->suffix && !in_array($audit->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? 'display: block;' : 'display: none;' }}"
                                                autocomplete="off"
                                            >
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
                    <div class="modal fade" id="delete-{{ $audit->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="deleteForm-{{ $audit->id }}" action="{{ route('audit.profile.delete', $audit->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete Audit Account</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this Audit account?</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

        </div>
    </main>
</div>

<!-- Add Audit Modal -->
<div class="modal fade" id="addAudit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('audit.profile.add') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">Add New Audit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3 mt-3">
                        <label>First Name:</label>
                        <input type="text" class="form-control" name="firstname" placeholder="Enter First Name" autocomplete="off"
                               pattern="[A-Za-z\s]+" title="Only letters are allowed"
                               oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label>Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" placeholder="Enter Middle Name" autocomplete="off">
                    </div>

                    <div class="mb-3 mt-3">
                        <label>Last Name:</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name" autocomplete="off" required>
                    </div>

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
                            style="display:none;"
                            autocomplete="off"
                        >
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

                    <!-- Force role audit (even if user edits HTML, controller still forces it) -->
                    <input type="hidden" name="role" value="audit">
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

document.addEventListener('DOMContentLoaded', function() {

    function handleSuffix(select, otherInput) {
        select.addEventListener('change', function() {
            if (this.value === 'Other') {
                otherInput.style.display = 'block';
                otherInput.required = true;
            } else {
                otherInput.style.display = 'none';
                otherInput.required = false;
                otherInput.value = '';
            }
        });

        select.closest('form').addEventListener('submit', function() {
            let finalSuffix = select.value;

            if (select.value === 'Other' && otherInput.value.trim() !== '') {
                finalSuffix = otherInput.value.trim();
            } else if (!finalSuffix) {
                finalSuffix = select.getAttribute('data-current-suffix') || '';
            }

            const existingHidden = this.querySelector('input[name="suffix"][type="hidden"]');
            if (existingHidden) existingHidden.remove();

            const hiddenSuffix = document.createElement('input');
            hiddenSuffix.type = 'hidden';
            hiddenSuffix.name = 'suffix';
            hiddenSuffix.value = finalSuffix;
            this.appendChild(hiddenSuffix);
        });
    }

    // Add Modal
    const suffixSelect = document.getElementById('suffixSelect');
    const otherSuffixInput = document.getElementById('otherSuffixInput');
    if (suffixSelect && otherSuffixInput) handleSuffix(suffixSelect, otherSuffixInput);

    // Edit Modals
    document.querySelectorAll('[id^="editSuffixSelect_"]').forEach(select => {
        const id = select.id.split('_')[1];
        const otherInput = document.getElementById(`editOtherSuffixInput_${id}`);
        if (!otherInput) return;
        handleSuffix(select, otherInput);
    });

    // Redirect if session gone
    window.onload = function() {
        @if(!Auth::check())
            window.location.href = "{{ route('home') }}";
        @endif
    };
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
