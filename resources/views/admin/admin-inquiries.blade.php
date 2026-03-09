@extends('layouts.inquiries')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Admin Inquiries')

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

<input type="checkbox" id="menu-toggle" hidden>
<div class="sidebar">
    <div class="side-content">
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
                <li><a href="{{ route('admin.complaints.index') }}"><span class="fa-regular fa-envelope"></span><small>Complaints</small></a></li>
                <li>
                    <a href="{{ route('admin.inquiries.index') }}" class="active inquiries-menu-link d-flex justify-content-between align-items-center" aria-current="page">
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

<div class="main-content">
    <header>
        <label for="menu-toggle" class="menu-toggle d-lg-none">
            <i class="fa-solid fa-bars"></i>
        </label>
        <div class="header-content"></div>
    </header>
    <main class="p-3 epacd-inq">
        <div class="page-header mb-3">
            <h1>Inquiries</h1>
            <small>Home / Inquiries</small>
        </div>

       <div class="chat-container epacd-card d-flex" style="height: 75vh; overflow: hidden;">

            {{-- Sidebar with clients --}}
            <div class="clients-list d-flex flex-column border-end" style="width: 30%; overflow-y: auto;">
                <div class="p-3 border-bottom bg-light">
                    <h5 class="m-0 fw-bold">Chats</h5>
                </div>
                <div class="list-group list-group-flush flex-grow-1">
                    @foreach($clients->sortByDesc('last_message_at') as $client)
                        <a href="#"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center client-link {{ $client->total_unread > 0 ? 'fw-bold' : '' }}"
                        data-client-id="{{ $client->client_id }}"
                        data-client-type="{{ strtolower($client->client_type) }}">
                            
                            <span class="client-name">
                                {{ ucfirst($client->client_type) }} / {{ $client->display_name }}
                            </span>

                            
                            @if($client->total_unread > 0)
                                <span class="badge bg-danger unread-badge">{{ $client->total_unread }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Chat box --}}
            <div class="chat-box d-flex flex-column flex-grow-1 bg-white">

                 
                {{-- Header for selected client --}}
                <div class="chat-header p-3 border-bottom bg-light" id="chatHeader">
                    <h6 class="m-0 text-uppercase text-muted" id="clientTypeName">Select a client</h6>
                </div>

                <!-- Search Bar -->
                <div class="chat-search">
                    <input type="text" id="chat-search" placeholder="Search conversation...">

                    <div class="search-controls">
                        <button id="prev-match" title="Previous">↑</button>
                        <button id="next-match" title="Next">↓</button>
                        <span id="match-counter">0</span>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="messages epacd-messages flex-grow-1 p-3 overflow-auto" id="chatMessages">
                    <p class="text-muted">Select a client to start chatting.</p>
                </div>

                

                {{-- Reply form --}}
                <form id="replyForm" class="epacd-reply d-flex p-2" style="display: none;" autocomplete="off">
                    @csrf
                    <input type="hidden" name="client_id" id="clientId">
                    <input type="hidden" name="client_type" id="clientType">
                    <input type="hidden" name="sender" value="admin">
                    <input type="text" name="message" id="messageInput" class="form-control me-2" placeholder="Type your reply..." required autocomplete="off">
                    <button type="submit" class="btn epacd-send-btn">
                        <i class="fa-solid fa-paper-plane me-1"></i> Send
                    </button>
                </form>

                {{-- Preset Solve Button --}}
                <div class="p-2 border-top">
                    <button id="markSolvedBtn" class="btn epacd-solved-btn w-100">
                        <i class="fa-solid fa-circle-check me-1"></i> Mark as Solved / Client Satisfied
                    </button>
                </div>

            </div>

        </div>
    </main>
</div>

<!-- Custom Notification Modal -->
    <div id="customModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <p id="customModalMessage">System:</p>
            <div id="customConfirmButtons" style="display:none; justify-content:center; gap:10px; margin-top:15px;">
                <button id="confirmYes" class="btn btn-success">Yes</button>
                <button id="confirmNo" class="btn btn-secondary">No</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
// --- CUSTOM MODAL FUNCTIONS ---
    const customModal = document.getElementById("customModal");
    const customModalMessage = document.getElementById("customModalMessage");
    const customClose = document.querySelector(".custom-close");

    function showModal(message) {
        customModalMessage.textContent = message;
        customModal.style.display = "block";
    }

    customClose.addEventListener("click", () => {
        customModal.style.display = "none";
    });

    window.addEventListener("click", (event) => {
        if (event.target == customModal) {
            customModal.style.display = "none";
        }
    });
    
document.addEventListener('DOMContentLoaded', async () => {
    const chatMessages = document.getElementById('chatMessages');
    const replyForm = document.getElementById('replyForm');
    const clientIdInput = document.getElementById('clientId');
    const clientTypeInput = document.getElementById('clientType');
    const messageInput = document.getElementById('messageInput');
    const chatHeader = document.getElementById('clientTypeName');
    const clientsListContainer = document.querySelector('.clients-list .list-group');
    const markSolvedBtn = document.getElementById('markSolvedBtn');
    const BASE_URL = '/admin/inquiries';
    const CLIENTS_URL = '/clients';

    let searchActive = false;

    let activeClientLink = null;
    let isSyncingClients = false;
    let lastAdminMessageTime = null; 
    let autoReplySent = false;       
    const AUTO_REPLY_DELAY = 3000;  
    let displayedMessageIds = new Set();

    function appendMessage(msg) {
        if (displayedMessageIds.has(msg.id)) return;
        displayedMessageIds.add(msg.id);

        const sender = (msg.sender || '').toLowerCase();
        let senderName = msg.sender_name || 'Unknown';
        let messageClass = 'bg-light';
        let justifyClass = 'justify-content-start';

        if (sender === 'admin') {
            senderName = 'Admin';
            messageClass = 'bg-primary text-white';
            justifyClass = 'justify-content-end';
            lastAdminMessageTime = Date.now(); 
            autoReplySent = false;             
        } else if (sender === 'system') {
            senderName = 'System';
            messageClass = 'bg-info text-white fst-italic';
            justifyClass = 'justify-content-end';
        }

        const createdAt = msg.created_at || new Date().toISOString();

        const div = document.createElement('div');
        div.className = `d-flex mb-2 ${justifyClass}`;
        div.innerHTML = `
            <div class="p-2 rounded ${messageClass} ${msg.unread_for_admin ? 'border border-danger' : ''}" style="max-width: 70%;">
                <small class="d-block fw-bold">${senderName}</small>
                ${msg.message}
                <div class="text-muted small mt-1">${new Date(createdAt).toLocaleString()}</div>
            </div>
        `;
        chatMessages.appendChild(div);

        if (searchActive) performSearch();

        chatMessages.scrollTop = chatMessages.scrollHeight;

    }

    // Auto-reply system if admin doesn't respond within 30 seconds
    function checkAutoReply() {
        if (!activeClientLink) return;
        if (!lastAdminMessageTime || autoReplySent) return;

        const now = Date.now();
        if (now - lastAdminMessageTime >= AUTO_REPLY_DELAY) {
            const clientId = clientIdInput.value;
            const clientType = clientTypeInput.value;

            fetch(`${BASE_URL}/send-system-message`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ client_id: clientId, client_type: clientType })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    appendMessage(data.system_message);
                    autoReplySent = true;
                }
            })
            .catch(err => console.error('Auto-reply error:', err));
        }
    }

    // Run auto-reply check every 5 seconds
    setInterval(checkAutoReply, 5000);

    // Mark messages as read
    async function markAsRead(clientType, clientId) {
        try {
            await fetch(`${BASE_URL}/mark-as-read/${clientType}/${clientId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (err) {
            console.error('Failed to mark messages as read:', err);
        }
    }

    // Load messages for a selected client
    async function loadMessages(clientId, clientType, link) {
        displayedMessageIds.clear();
        chatMessages.innerHTML = '<p class="text-muted">Loading messages...</p>';
        try {
            const res = await fetch(`${BASE_URL}/messages/${clientType}/${clientId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            chatMessages.innerHTML = '';
            if (data.success && Array.isArray(data.messages) && data.messages.length > 0) {
                data.messages.forEach(msg => appendMessage(msg));
            } else {
                chatMessages.innerHTML = '<p class="text-muted">No messages found.</p>';
            }

            markAsRead(clientType, clientId);
            link.querySelector('.unread-badge')?.remove();
            link.querySelector('.client-name').classList.remove('fw-bold');
            fetchUnreadCounts();
        } catch (err) {
            console.error('Failed to load messages:', err);
            chatMessages.innerHTML = '<p class="text-danger">Failed to load messages.</p>';
        }
    }

    function escapeHtml(value = '') {
        return value
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatClientLabel(clientType, displayName) {
        return `${clientType.charAt(0).toUpperCase()}${clientType.slice(1)} / ${displayName}`;
    }

    function bindClientLinkEvents() {
        document.querySelectorAll('.client-link').forEach(link => {
            if (link.dataset.bound === '1') return;
            link.dataset.bound = '1';
            link.addEventListener('click', e => {
                e.preventDefault();
                activateClient(link);
            });
        });
    }

    function updateClientList(clients) {
        if (!clientsListContainer) return;

        const activeClientId = clientIdInput.value;
        const activeClientType = clientTypeInput.value;

        clientsListContainer.innerHTML = '';

        clients.forEach(client => {
            const key = `${client.client_type}-${client.client_id}`;
            const isActive = activeClientId === String(client.client_id) && activeClientType === client.client_type;
            const isUnread = Number(client.unread || 0) > 0;
            const label = formatClientLabel(client.client_type, client.display_name || `Client #${client.client_id}`);

            const link = document.createElement('a');
            link.href = '#';
            link.className = `list-group-item list-group-item-action d-flex justify-content-between align-items-center client-link ${isActive ? 'active' : ''} ${isUnread ? 'fw-bold' : ''}`;
            link.dataset.clientId = String(client.client_id);
            link.dataset.clientType = client.client_type;
            link.innerHTML = `
                <span class="client-name">${escapeHtml(label)}</span>
                ${isUnread ? `<span class="badge bg-danger unread-badge">${client.unread}</span>` : ''}
            `;

            clientsListContainer.appendChild(link);

            if (isActive) activeClientLink = link;
        });

        bindClientLinkEvents();
    }

    async function syncClientList() {
        if (isSyncingClients) return;
        isSyncingClients = true;

        try {
            const res = await fetch(CLIENTS_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success && Array.isArray(data.clients)) {
                updateClientList(data.clients);
            }
        } catch (err) {
            console.error('Failed to sync clients:', err);
        } finally {
            isSyncingClients = false;
        }
    }

    // Fetch unread counts
    async function fetchUnreadCounts() {
        try {
            const res = await fetch(`${BASE_URL}/unread-counts`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success && data.unreadCounts) {
                document.querySelectorAll('.client-link').forEach(link => {
                    const clientId = link.dataset.clientId;
                    const clientType = link.dataset.clientType;
                    const key = `${clientType}-${clientId}`;
                    const unread = data.unreadCounts[key] || 0;

                    let badge = link.querySelector('.unread-badge');
                    if (unread > 0) {
                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'badge bg-danger unread-badge ms-2';
                            link.appendChild(badge);
                        }
                        badge.textContent = unread;
                        link.querySelector('.client-name').classList.add('fw-bold');
                    } else {
                        badge?.remove();
                        link.querySelector('.client-name').classList.remove('fw-bold');
                    }
                });
            }
        } catch (err) {
            console.error('Failed to fetch unread counts:', err);
        }
    }

    // Poll only new messages
    async function pollNewMessages() {
        if (!activeClientLink) return;
        const clientId = clientIdInput.value;
        const clientType = clientTypeInput.value;

        try {
            const res = await fetch(`${BASE_URL}/messages/${clientType}/${clientId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            if (data.success && Array.isArray(data.messages)) {
                data.messages.forEach(msg => {
                    if (!displayedMessageIds.has(msg.id)) {
                        appendMessage(msg);
                    }
                });
            }
        } catch (err) {
            console.error('Failed to poll messages:', err);
        }
    }

    setInterval(pollNewMessages, 1000);
    setInterval(syncClientList, 1000);
    setInterval(fetchUnreadCounts, 2000);

    // Activate client
    function activateClient(link) {
        const clientId = link.dataset.clientId;
        const clientType = link.dataset.clientType;
        clientIdInput.value = clientId;
        clientTypeInput.value = clientType;
        replyForm.style.display = 'flex';
        chatHeader.innerHTML = `<strong>${clientType.toUpperCase()} - ${link.querySelector('.client-name').textContent.split(' / ')[1]}</strong>`;
        activeClientLink = link;
        loadMessages(clientId, clientType, link);
        document.querySelectorAll('.client-link').forEach(c => c.classList.remove('active'));
        link.classList.add('active');
    }

    bindClientLinkEvents();

    // Send message
    replyForm.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(replyForm);
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch(`${BASE_URL}/send`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                appendMessage(data.message);
                messageInput.value = '';
                activeClientLink.querySelector('.unread-badge')?.remove();
                activeClientLink.querySelector('.client-name').classList.remove('fw-bold');
                markAsRead(clientTypeInput.value, clientIdInput.value);
                fetchUnreadCounts();
            } else showModal('Failed to send message.');
        } catch (err) {
            console.error('Error sending message:', err);
            showModal('Error sending message.');
        }
    });

    // MARK AS SOLVED
   markSolvedBtn.addEventListener('click', () => {
    if (!activeClientLink) return showModal('Select a client first.');

    // SHOW CUSTOM CONFIRM MODAL INSTEAD OF confirm()
    customModalMessage.textContent = 'Are you sure you want to mark this inquiry as solved?';

    // Show YES/NO buttons
    const confirmButtons = document.getElementById('customConfirmButtons');
    confirmButtons.style.display = 'flex';

    customModal.style.display = 'block';

    // Clear old click handlers
    document.getElementById('confirmYes').onclick = null;
    document.getElementById('confirmNo').onclick = null;

    // YES button
    document.getElementById('confirmYes').onclick = async () => {
        customModal.style.display = 'none';
        confirmButtons.style.display = 'none';

        // --------- ORIGINAL CODE GOES HERE ---------
        const clientId = clientIdInput.value;
        const clientType = clientTypeInput.value;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch(`${BASE_URL}/mark-solved`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ client_id: clientId, client_type: clientType })
            });
            const data = await res.json();

            if (data.success) {
                showModal('Inquiry marked as solved. A preset message was sent to the client.');
                if (activeClientLink) activeClientLink.remove();
                chatMessages.innerHTML = '<p class="text-muted">Select a client to start chatting.</p>';
                replyForm.style.display = 'none';
                clientIdInput.value = '';
                clientTypeInput.value = '';
                activeClientLink = null;
            } else {
                showModal(data.message || 'Failed to mark as solved.');
            }
        } catch (err) {
            console.error('Mark as solved error:', err);
            showModal('An error occurred while marking as solved.');
        }
        // ------------------------------------------
    };

    // NO button
    document.getElementById('confirmNo').onclick = () => {
        customModal.style.display = 'none';
        confirmButtons.style.display = 'none';
    };
});


    // Load latest client automatically
    await syncClientList();
    await fetchUnreadCounts();
    const latestClient = document.querySelector('.client-link');
    if (latestClient) activateClient(latestClient);


    const searchInput = document.getElementById('chat-search');
    const nextBtn = document.getElementById('next-match');
    const prevBtn = document.getElementById('prev-match');
    const counter = document.getElementById('match-counter');


    let matches = [];
    let currentIndex = -1;

    // Highlight matches
    function performSearch() {
    const term = searchInput.value.toLowerCase();
    const messages = chatMessages.querySelectorAll('#chatMessages .p-2.rounded');

    matches = [];
    currentIndex = -1;

    messages.forEach(msg => {
        const original = msg.getAttribute('data-original') || msg.innerHTML;
        msg.setAttribute('data-original', original);

        msg.classList.remove('active-match');

        if (!term) {
            msg.innerHTML = original;
            return;
        }

        if (original.toLowerCase().includes(term)) {
            const regex = new RegExp(`(${term})`, 'gi');
            msg.innerHTML = original.replace(regex, '<mark>$1</mark>');
            matches.push(msg);
        } else {
            msg.innerHTML = original;
        }
    });

    if (matches.length > 0) {
        currentIndex = 0;
        focusMatch();
    } else {
        counter.textContent = "0";
    }
}


// Scroll & focus match
function focusMatch() {
    matches.forEach(m => m.classList.remove('active-match'));

    if (matches[currentIndex]) {
        const el = matches[currentIndex];
        el.classList.add('active-match');

        el.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        counter.textContent = (currentIndex + 1) + " of " + matches.length;
    }
}


// Next match
nextBtn.addEventListener('click', () => {
    if (!matches.length) return;
    currentIndex = (currentIndex + 1) % matches.length;
    focusMatch();
});

// Previous match
prevBtn.addEventListener('click', () => {
    if (!matches.length) return;
    currentIndex = (currentIndex - 1 + matches.length) % matches.length;
    focusMatch();
});

// // Clear search
// clearBtn.addEventListener('click', () => {
//     searchInput.value = '';
//     performSearch();
// });

// Trigger search while typing
searchInput.addEventListener('input', () => {
    searchActive = searchInput.value.trim() !== '';
    performSearch();

    if (!searchActive) {
        counter.textContent = "0";
    }
});
});


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
                badge.style.display = 'inline-flex';
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

    const THEME_KEY = 'admin_theme';
    const toggleBtn = document.getElementById('themeToggleBtn');
    const icon = document.getElementById('themeToggleIcon');
    const text = document.getElementById('themeToggleText');

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
