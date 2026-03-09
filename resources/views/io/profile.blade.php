@extends('layouts.admin-profile')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'IO Profiles')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/io-profile.css') }}">
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
            <small>Information Office (IO)</small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="{{ route('io.dashboard') }}">
                        <span class="fa-solid fa-house"></span><small>Dashboard</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('io.profile') }}" class="active" aria-current="page">
                        <span class="fa-regular fa-user"></span><small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('io.inquiries.index') }}" class="d-flex justify-content-between align-items-center inquiries-menu-link">
                        <span class="inquiries-menu-main">
                            <span class="fa-solid fa-question-circle inquiries-menu-icon"></span>
                            <small>Inquiries</small>
                        </span>
                        <span id="inquiriesUnreadBadge" class="badge bg-danger ms-2" style="display:none;">0</span>
                    </a>
                </li>
                <li>
                    <button type="button" id="themeToggleBtn" class="theme-toggle-btn">
                        <span id="themeToggleIcon" class="fa-regular fa-moon"></span>
                        <small id="themeToggleText">Dark Mode</small>
                    </button>
                </li>
                <li class="sidebar-logout">
                    <form action="{{ route('io.logout') }}" method="POST">
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
        <div class="page-header">
            <h1>Information Office Accounts <i class="fa-solid fa-users"></i></h1>
            <small>Home / Information Office Profiles</small>
        </div>

        <div class="container-fluid mt-3">

            <div class="io-toolbar mb-3">
                <div>
                    <p class="io-sub mb-0">Manage information office accounts</p>
                </div>

                <button type="button" class="btn btn-success io-add-btn" data-bs-toggle="modal" data-bs-target="#addIO">
                    <i class="bi bi-person-plus"></i> Add Account
                </button>
            </div>

            <!-- IO Cards -->
            <div class="row">
                @foreach($ios as $io)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card io-card border-0">
                            <div class="io-card-body">
                                <div class="io-avatar-wrap">
                                    <img src="{{ asset('storage/uploaded_img/' . ($io->image ?? 'default-avatar.png')) }}"
                                        class="io-avatar" alt="Admin Image">
                                </div>

                                <div class="io-name">
                                    {{ $io->firstname }}
                                    @if($io->middlename)
                                        {{ strtoupper(substr($io->middlename, 0, 1)) }}.
                                    @endif
                                    {{ $io->lastname }}
                                    @if($io->suffix && $io->suffix !== 'N.A')
                                        , {{ $io->suffix }}
                                    @endif
                                </div>

                                <div class="admin-meta">
                                    <div class="io-email">{{ $io->email }}</div>
                                </div>

                                <div class="io-actions">
                                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $io->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $io->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit-{{ $io->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('io.profile.edit', $io->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h4 class="modal-title">Update IO Account</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3 mt-3">
                                            <label>First Name:</label>
                                            <input type="text" class="form-control" name="firstname" value="{{ $io->firstname }}" autocomplete="off" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label>Middle Name:</label>
                                            <input type="text" class="form-control" name="middlename" value="{{ $io->middlename }}" autocomplete="off">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label>Last Name:</label>
                                            <input type="text" class="form-control" name="lastname" value="{{ $io->lastname }}" autocomplete="off" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Suffix Name:</label>
                                            <select class="form-select" id="editSuffixSelect_{{ $io->id }}" name="suffix" data-current-suffix="{{ $io->suffix }}">
                                                <option value="" disabled {{ !$io->suffix ? 'selected' : '' }}>Select Suffix</option>
                                                <option value="Jr." {{ $io->suffix == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                                <option value="Sr." {{ $io->suffix == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                                <option value="I" {{ $io->suffix == 'I' ? 'selected' : '' }}>I</option>
                                                <option value="II" {{ $io->suffix == 'II' ? 'selected' : '' }}>II</option>
                                                <option value="III" {{ $io->suffix == 'III' ? 'selected' : '' }}>III</option>
                                                <option value="IV" {{ $io->suffix == 'IV' ? 'selected' : '' }}>IV</option>
                                                <option value="V" {{ $io->suffix == 'V' ? 'selected' : '' }}>V</option>
                                                <option value="VI" {{ $io->suffix == 'VI' ? 'selected' : '' }}>VI</option>
                                                <option value="VII" {{ $io->suffix == 'VII' ? 'selected' : '' }}>VII</option>
                                                <option value="VIII" {{ $io->suffix == 'VIII' ? 'selected' : '' }}>VIII</option>
                                                <option value="IX" {{ $io->suffix == 'IX' ? 'selected' : '' }}>IX</option>
                                                <option value="X" {{ $io->suffix == 'X' ? 'selected' : '' }}>X</option>
                                                <option value="PhD" {{ $io->suffix == 'PhD' ? 'selected' : '' }}>PhD</option>
                                                <option value="MD" {{ $io->suffix == 'MD' ? 'selected' : '' }}>MD</option>
                                                <option value="CPA" {{ $io->suffix == 'CPA' ? 'selected' : '' }}>CPA</option>
                                                <option value="JD" {{ $io->suffix == 'JD' ? 'selected' : '' }}>JD</option>
                                                <option value="N.A" {{ $io->suffix == 'N.A' ? 'selected' : '' }}>N.A</option>
                                                <option value="Other"
                                                    {{ ($io->suffix && !in_array($io->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>

                                            <input
                                                type="text"
                                                class="form-control mt-2"
                                                id="editOtherSuffixInput_{{ $io->id }}"
                                                name="other_suffix"
                                                placeholder="Please specify your suffix"
                                                value="{{ ($io->suffix && !in_array($io->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? $io->suffix : '' }}"
                                                style="{{ ($io->suffix && !in_array($io->suffix, ['Jr.','Sr.','I','II','III','IV','V','VI','VII','VIII','IX','X','PhD','MD','CPA','JD','N.A','Other'])) ? 'display: block;' : 'display: none;' }}"
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
                    <div class="modal fade" id="delete-{{ $io->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="deleteForm-{{ $io->id }}" action="{{ route('io.profile.delete', $io->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete IO Account</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this IO account?</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger confirm-delete-btn" data-id="{{ $io->id }}">Yes</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            <!-- Snackbar / Toast -->
            <div id="undo-toast" class="undo-toast">
                <span id="undo-message">Account deleted.</span>
                <button id="undo-button" class="undo-btn">Undo</button>
            </div>

        </div>
    </main>
</div>

<!-- Add IO Modal -->
<div class="modal fade" id="addIO" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('io.profile.add') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">Add New IO</h4>
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

                    {{-- If you want to FORCE role=io in backend, add this hidden field --}}
                    <input type="hidden" name="role" value="io">
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

    // Add IO Modal
    const suffixSelect = document.getElementById('suffixSelect');
    const otherSuffixInput = document.getElementById('otherSuffixInput');
    if (suffixSelect && otherSuffixInput) handleSuffix(suffixSelect, otherSuffixInput);

    // Edit IO Modals
    document.querySelectorAll('[id^="editSuffixSelect_"]').forEach(select => {
        const ioId = select.id.split('_')[1];
        const otherInput = document.getElementById(`editOtherSuffixInput_${ioId}`);
        if (!otherInput) return;
        handleSuffix(select, otherInput);
    });

    // Delete Undo Toast
    let deleteTimeout = null;
    let formToSubmit = null;

    document.querySelectorAll('.confirm-delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const ioId = this.getAttribute('data-id');
            formToSubmit = document.getElementById(`deleteForm-${ioId}`);

            const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
            modal.hide();

            const toast = document.getElementById('undo-toast');
            toast.classList.add('show');

            deleteTimeout = setTimeout(() => {
                if (formToSubmit) formToSubmit.submit();
            }, 10000);
        });
    });

    document.getElementById('undo-button')?.addEventListener('click', function () {
        clearTimeout(deleteTimeout);
        document.getElementById('undo-toast').classList.remove('show');
        formToSubmit = null;
    });

    // Inquiries unread badge (IO)
    async function updateInquiriesUnreadBadge() {
        try {
            const res = await fetch('/io/inquiries/unread-counts', {
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
        window.location.replace("{{ route('login') }}");
    };
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
