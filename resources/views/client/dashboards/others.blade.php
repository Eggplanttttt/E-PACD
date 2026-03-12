@extends('layouts.client')


@section('title', 'Others Dashboard')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-custom">
  <div class="container-fluid">
    {{-- Brand --}}
    <a class="navbar-brand d-none d-lg-inline" href="">Electronic Public Assistance & Complaints Desk</a>
    <a class="navbar-brand d-inline d-lg-none" href="">E-PACD</a>

    <ul class="navbar-nav ms-auto flex-row align-items-center gap-2">

  {{-- Complaint --}}
  <li class="nav-item order-1 order-sm-0 me-0">
    <button
      type="button"
      id="complaintBtn"
      class="btn vd-complaint-btn"
      data-bs-toggle="modal"
      data-bs-target="#complaintModal">
      <i class="fas fa-bullhorn" aria-hidden="true"></i>
      <span class="d-none d-sm-inline">Complaint</span>
    </button>
  </li>

  {{-- Account --}}
  <li class="nav-item dropdown order-0 order-sm-1">
    <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" role="button"
       data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-user-circle me-1"></i> Account
      <span id="accountNotifBadge"
            class="badge rounded-pill bg-danger"
            style="{{ ($unreadNotifications ?? 0) > 0 ? '' : 'display:none;' }}">
        {{ $unreadNotifications ?? 0 }}
      </span>
    </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="accountDropdownMenu">
          <li id="faq-mobile-placeholder" class="d-lg-none"></li>


          <li class="position-relative" id="notifWrap">
            <button type="button"
                    class="dropdown-item d-flex justify-content-between align-items-center"
                    id="notifBtn">
              <span class="d-flex align-items-center gap-2">
                <i class="fas fa-bell"></i>
                Notifications
              </span>

              <span id="notifBadge"
                    class="badge rounded-pill bg-danger"
                    style="{{ ($unreadNotifications ?? 0) > 0 ? '' : 'display:none;' }}">
                {{ $unreadNotifications ?? 0 }}
              </span>
            </button>

            {{-- NOTIF PANEL (appears under button) --}}
            <div id="notifPanel" class="notif-panel shadow-sm" style="display:none;">
              <div class="notif-panel__header">
                <div class="d-flex align-items-center gap-2">
                  <i class="fas fa-bell"></i>
                  <strong class="small">Notifications</strong>
                </div>
                <button type="button" class="btn btn-sm btn-light" id="notifCloseBtn" title="Close">
                  <i class="fas fa-times"></i>
                </button>
              </div>

              <div id="notifList" class="notif-panel__list">
                <div class="notif-empty">Loading...</div>
              </div>

              <div class="notif-panel__footer">
                <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="notifMarkReadBtn">
                  <i class="fas fa-check me-1"></i> Mark all read
                </button>

                <button type="button" class="btn btn-sm btn-outline-danger w-100" id="notifDeleteReadBtn">
                  <i class="fas fa-trash me-1"></i> Delete read
                </button>

                <button type="button" class="btn btn-sm btn-outline-primary w-100" id="notifRefreshBtn">
                  <i class="fas fa-rotate me-1"></i> Refresh
                </button>
              </div>
            </div>
          </li>
          {{-- Settings --}}
          <li>
            <a class="dropdown-item" href="{{ route('others.settings') }}">
              <i class="fas fa-cog me-1"></i> Settings
            </a>
          </li>

          <li><hr class="dropdown-divider"></li>

          {{-- Logout --}}
          <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<div class="modal fade" id="complaintModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content vd-complaint-modal">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-bullhorn me-1"></i> Write your complaint here
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
         <div class="vd-form-surface">
        {{-- SUCCESS / ERRORS --}}
        @if(session('success'))
          <div class="alert alert-success mb-3">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger mb-3">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- COMPLAINT FORM --}}
        <form id="complaintForm" class="vd-form" action="{{ route('others.complaints.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- Department --}}
          <div class="mb-3">
            <label class="form-label">Department of the Person You Are Reporting</label>
            <select name="department" id="departmentSelector" class="form-select  vd-input"" required>
              <option value="" disabled selected hidden>Department of the Person You Are Reporting</option>
              <option value="Office of the President">Office of the President</option>
              <option value="Office of the Board Secretary">Office of the Board Secretary</option>
              <option value="Office of the Vice President for Administration and Finance">Office of the Vice President for Administration and Finance</option>
              <option value="Office of the Vice President for Academic, Research and Extension">Office of the Vice President for Academic, Research and Extension</option>
              <option value="Planning Unit">Planning Unit</option>
              <option value="Information Unit">Information Unit</option>
              <option value="Information Communication Technology Unit">Information Communication Technology Unit</option>
              <option value="Internal Audit Unit">Internal Audit Unit</option>
              <option value="Legal Unit">Legal Unit</option>
              <option value="International Relations Unit">International Relations Unit</option>
              <option value="Project Management Unit">Project Management Unit</option>
              <option value="Quality Assurance Unit">Quality Assurance Unit</option>
              <option value="Gender and Development Unit">Gender and Development Unit</option>
              <option value="Alumni Affairs Unit">Alumni Affairs Unit</option>
              <option value="Security Services">Security Services</option>
              <option value="Human Resources Management Unit">Human Resources Management Unit</option>
              <option value="General Services Unit">General Services Unit</option>
              <option value="Supply and Property Management Unit">Supply and Property Management Unit</option>
              <option value="Procurement Management Unit">Procurement Management Unit</option>
              <option value="Records Unit">Records Unit</option>
              <option value="Medical and Dental Services">Medical and Dental Services</option>
              <option value="Cashiering Unit">Cashiering Unit</option>
              <option value="Budget Unit">Budget Unit</option>
              <option value="Accounting Unit and Men’s Dormitory">Accounting Unit and Men’s Dormitory</option>
              <option value="Auxiliary and Enterprise Development">Auxiliary and Enterprise Development</option>
              <option value="Research and Development">Research and Development</option>
              <option value="Extension and Training Services">Extension and Training Services</option>
              <option value="Knowledge Center">Knowledge Center</option>
              <option value="Office of the University Registrar">Office of the University Registrar</option>
              <option value="NSTP">NSTP</option>
              <option value="Bachelor of Elementary Education (BEEd)">Bachelor of Elementary Education (BEEd)</option>
              <option value="Bachelor of Secondary Education (BSE)">Bachelor of Secondary Education (BSE)</option>
              <option value="Bachelor of Technology and Livelihood Education (BTLED)">Bachelor of Technology and Livelihood Education (BTLED)</option>
              <option value="Bachelor of Science in Criminology (BSC) and Student Tribunal">Bachelor of Science in Criminology (BSC) and Student Tribunal</option>
              <option value="Bachelor of Science in Hospitality Management (BSHM)">Bachelor of Science in Hospitality Management (BSHM)</option>
              <option value="Bachelor of Science in Tourism Management (BSTM)">Bachelor of Science in Tourism Management (BSTM)</option>
              <option value="Bachelor of Science in Nutrition and Dietetics (BSND)">Bachelor of Science in Nutrition and Dietetics (BSND)</option>
              <option value="Bachelor of Science in Office Administration (BSOA)">Bachelor of Science in Office Administration (BSOA)</option>
              <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
              <option value="Bachelor of Science in Agriculture (BSA)">Bachelor of Science in Agriculture (BSA)</option>
              <option value="Bachelor of Science in Forestry (BSF)">Bachelor of Science in Forestry (BSF)</option>
              <option value="Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)">Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)</option>
              <option value="Student Affairs and Services">Student Affairs and Services</option>
              <option value="Student Publications">Student Publications</option>
              <option value="Ladies Dormitory">Ladies Dormitory</option>
              <option value="Guidance and Counselling Services">Guidance and Counselling Services</option>
              <option value="Registered Student Organizations and Student Economic Enterprise Development">RSO and Student Economic Enterprise Development</option>
              <option value="UNIFAST and Scholarship Services">UNIFAST and Scholarship Services</option>
              <option value="Socio-Cultural Affairs">Socio-Cultural Affairs</option>
              <option value="Sports Development">Sports Development</option>
              <option value="Multi-Faith Services">Multi-Faith Services</option>
              <option value="Student Government">Student Government</option>
              <option value="Internal Audit Unit-Secretariat">Internal Audit Unit-Secretariat</option>
            </select>
          </div>

          @php
          $others = auth('others')->user();
          $fullName = $others
              ? trim(implode(' ', array_filter([
                  $others->first_name ?? '',
                  $others->middle_initial ?? '',
                  $others->last_name ?? '',
                  $others->suffix ?? ''
              ])))
              : 'Anonymous';
        @endphp

        {{-- Display name preference --}}
        <div class="mb-3">
          <label class="form-label d-block">Name Display</label>

          {{-- Hidden field that will be submitted --}}
          <input type="hidden" name="name" id="finalNameInput" value="Anonymous">

          <div class="d-flex flex-wrap gap-3">
            <label class="form-check d-flex align-items-center gap-2 m-0">
              <input class="form-check-input" type="radio" name="name_mode" id="nameModeAnonymous" value="anonymous" checked>
              <span class="form-check-label">Submit anonymously</span>
            </label>

            <label class="form-check d-flex align-items-center gap-2 m-0">
              <input class="form-check-input" type="radio" name="name_mode" id="nameModeReal" value="real">
              <span class="form-check-label">
                Use my name
                <small class="text-muted">({{ $fullName }})</small>
              </span>
            </label>
          </div>

          <small class="text-muted d-block mt-2">
            You can choose to hide your identity. If anonymous is selected, your name will be stored as “Anonymous”.
          </small>
        </div>

          {{-- Contact --}}
          <div class="mb-3">
            <label class="form-label">Contact Number *</label>
            <input type="text" name="contact" class="form-control vd-input""
                   placeholder="Contact Number *" autocomplete="off" required
                   pattern="\d{11}" maxlength="11" minlength="11"
                   oninput="this.value=this.value.replace(/[^0-9]/g,'');">
          </div>

          {{-- Message --}}
          <div class="mb-3">
            <label class="form-label">Complaint *</label>
            <textarea name="message" class="form-control vd-input"" rows="5"
                      placeholder="Please write your complaint here *"
                      autocomplete="off" required></textarea>
          </div>

          {{-- Image Upload --}}
          <div class="mb-3">
            <label class="form-label">Attach Image Proof (optional)</label>
            <input type="file" name="image" id="imageUpload" accept="image/*" class="form-control" onchange="previewImage(event)">

            <div class="mt-2" id="imageContainer" style="display:none;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="text-muted">Preview</small>
                <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeImage()">Remove</button>
              </div>
              <img id="imagePreview" src="#" alt="Image Preview" style="max-width:100%; border-radius:8px;" />
            </div>
          </div>

          {{-- Video Upload --}}
          <div class="mb-3">
            <label class="form-label">Attach Video Proof (optional)</label>
            <input type="file" name="video" id="videoUpload" accept="video/*" class="form-control" onchange="previewVideo(event)">

            <div class="mt-2" id="videoContainer" style="display:none;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="text-muted">Preview</small>
                <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeVideo()">Remove</button>
              </div>
              <video id="videoPreview" controls style="width:100%; border-radius:8px;"></video>
            </div>
          </div>

          {{-- Warning / Policy --}}
          <div class="vd-alert d-flex gap-2 align-items-start mt-3 mb-0" role="alert">
            <i class="fas fa-triangle-exclamation mt-1"></i>
            <div>
              <strong>Important:</strong>
              Please submit only truthful and serious complaints. Any report found to be false, misleading, or submitted as a joke may result in
              <strong>account suspension/ban</strong> and you may permanently lose access to this system.
            </div>
          </div>

          <div class="modal-footer px-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="submitbtn" class="btn btn-success">
              Submit <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>

    </div>
    </div>
  </div>
</div>


<div class="dashboard-container">
    <header class="client-header text-center mb-4">
        @php
            $others = auth('others')->user();
            $fullName = $others 
                ? trim(implode(' ', array_filter([
                    $others->first_name ?? '',
                    $others->middle_initial ?? '',
                    $others->last_name ?? '',
                    $others->suffix ?? ''
                ]))) 
                : 'others';
        @endphp


        <h2>Welcome, {{ $fullName }}!</h2>
        <p>You're now connected to E-PACD Chat Support (Others)</p>
    </header>

    <!-- MOBILE FAQ (TOP, MOBILE ONLY) -->
    <div class="mobile-faq-toggle d-lg-none mb-3">
        <button class="btn btn-outline-success w-100"
                data-bs-toggle="collapse"
                data-bs-target="#mobileFaq">
            <i class="fas fa-question-circle me-1"></i> Need Help / FAQs
        </button>

        <div class="collapse mt-2" id="mobileFaq">
            <div class="faq-sidebar">
                <ul class="faq-list">
                    <li data-question="What are your office hours?">What are your office hours?</li>
                    <li data-question="Where is the registrar's office?">Where is the registrar's office?</li>
                    <li data-question="Can I still enroll late?">Can I still enroll late?</li>
                    <li data-question="What are the requirements for enrolling as a freshman or transferee?">What are the requirements for enrolling as a freshman or transferee?</li>
                    <li data-question="What courses or degree programs are offered at this university?">What courses or degree programs are offered at this university?</li>
                    <li data-question="Do I need to take an entrance exam? ">Do I need to take an entrance exam? </li>
                    <li data-question="How do I register for the entrance exam? ">How do I register for the entrance exam? </li>
                    <li data-question="Does the Guidance Office conduct orientations for new students?">Does the Guidance Office conduct orientations for new students?</li>
                    <li data-question="How do I apply for a job at QSU? ">How do I apply for a job at QSU? </li>
                    <li data-question="Where are job vacancies posted? ">Where are job vacancies posted?  </li>
                    <li data-question="What is the recruitment process? ">What is the recruitment process? </li>
                    <li data-question="Can I apply as part-time or job-order staff? ">Can I apply as part-time or job-order staff? </li>
                </ul>
            </div>
        </div>
    </div>

    
    <div class="messenger-layout">
        <div class="chat-box">

          <!-- Search Bar -->
          <div class="chat-search">
              <input type="text" id="chat-search" placeholder="Search conversation...">

              <div class="search-controls">
                  <button id="prev-match" title="Previous">↑</button>
                  <button id="next-match" title="Next">↓</button>
                  <span id="match-counter">0</span>
              </div>
          </div>

            <div id="chat-messages" class="chat-messages"></div>

            <form id="chat-form" class="chat-form" autocomplete="off">
                @csrf
                <input type="text" id="chat-input" placeholder="Type your message..." autocomplete="off" spellcheck="false">
                <input type="file" id="chat-attachment" name="attachment" class="d-none" accept=".jpg,.jpeg,.png,.gif,.webp,.mp4,.mov,.avi,.wmv,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                <button type="button" id="attachment-btn" title="Attach image, video, or document"><i class="fas fa-paperclip"></i></button>
                <button type="button" id="clear-attachment-btn" title="Remove attachment" style="display:none;"><i class="fas fa-times"></i></button>
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
            <small id="attachment-name" class="text-muted d-block mt-2"></small>
        </div>

        {{-- FAQ Sidebar --}}
        <div class="faq-sidebar d-none d-lg-block" id="faq-list-desktop">
            <h3>Need Help?</h3>
            <ul class="faq-list">
                <li data-question="What are your office hours?">What are your office hours?</li>
                <li data-question="Where is the registrar's office?">Where is the registrar's office?</li>
                <li data-question="Can I still enroll late?">Can I still enroll late?</li>
                <li data-question="What are the requirements for enrolling as a freshman or transferee?">What are the requirements for enrolling as a freshman or transferee?</li>
                <li data-question="What courses or degree programs are offered at this university?">What courses or degree programs are offered at this university?</li>
                <li data-question="Do I need to take an entrance exam? ">Do I need to take an entrance exam? </li>
                <li data-question="How do I register for the entrance exam? ">How do I register for the entrance exam? </li>
                <li data-question="Does the Guidance Office conduct orientations for new students?">Does the Guidance Office conduct orientations for new students?</li>
                <li data-question="How do I apply for a job at QSU? ">How do I apply for a job at QSU? </li>
                <li data-question="Where are job vacancies posted? ">Where are job vacancies posted?  </li>
                <li data-question="What is the recruitment process? ">What is the recruitment process? </li>
                <li data-question="Can I apply as part-time or job-order staff? ">Can I apply as part-time or job-order staff? </li>
            </ul>
        </div>
    </div>
</div>


<div id="privacyModal" class="privacy-modal" aria-hidden="true">
  <div class="privacy-dialog" role="dialog" aria-modal="true" aria-labelledby="privacyTitle">
    <div class="privacy-header">
      <div class="privacy-title-wrap">
        <div class="privacy-icon" aria-hidden="true">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div>
          <h2 id="privacyTitle" class="privacy-title">Privacy Notice</h2>
          <p class="privacy-subtitle">Before submitting a complaint, please review and agree.</p>
        </div>
      </div>

      <button type="button" class="privacy-close" aria-label="Close">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="privacy-body">
      <p class="privacy-text">
        We collect your personal information and complaint details for the purpose of processing and responding to your concern.
        Your data will be handled confidentially, stored securely, and accessed only by authorized personnel.
      </p>

      <div class="privacy-bullets">
        <div class="privacy-bullet">
          <i class="fas fa-lock"></i>
          <span>Your information is treated as confidential.</span>
        </div>
        <div class="privacy-bullet">
          <i class="fas fa-user-shield"></i>
          <span>Only authorized staff can access the report.</span>
        </div>
        <div class="privacy-bullet">
          <i class="fas fa-file-alt"></i>
          <span>Used only to process and resolve your complaint.</span>
        </div>
      </div>

      <label class="privacy-check">
        <input type="checkbox" id="agreeCheckbox">
        <span>
          I have read and agree to the <strong>Privacy Notice</strong>.
        </span>
      </label>
    </div>

    <div class="privacy-footer">
      <button type="button" class="btn btn-light privacy-cancel">Cancel</button>
      <button type="button" id="acceptBtn" class="btn btn-success privacy-proceed" disabled>
        Proceed <i class="fas fa-arrow-right ms-1"></i>
      </button>
    </div>
  </div>
</div>

{{-- Custom Notification Modal --}}
<div id="customModal" class="custom-modal" style="display:none;">
  <div class="custom-modal-content">
    <span class="custom-close">&times;</span>
    <p id="customModalMessage">System:</p>
  </div>
</div>


<div id="notifPopoverTemplate" class="d-none">
  <div class="notif-pop">
    <div class="notif-pop__header">
      <div class="notif-pop__title">
        <i class="fas fa-bell"></i>
        <span>Notifications</span>
      </div>
      <button type="button" class="btn btn-sm btn-light notif-close-btn" title="Close">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div id="notifPopoverList" class="notif-pop__list">
      <div class="notif-empty">Loading...</div>
    </div>

    <div class="notif-pop__footer">
      <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="notifMarkReadBtn">
        <i class="fas fa-check me-1"></i> Mark all as read
      </button>

      <button type="button" class="btn btn-sm btn-outline-danger w-100" id="notifDeleteReadBtn">
        <i class="fas fa-trash me-1"></i> Delete read
      </button>

      <button type="button" class="btn btn-sm btn-outline-primary w-100" id="notifRefreshBtn">
        <i class="fas fa-rotate me-1"></i> Refresh
      </button>
    </div>
  </div>
</div>
@endsection

@section('scripts')


<script>
document.addEventListener('DOMContentLoaded', () => {
  const chatMessages = document.getElementById('chat-messages');
  const chatForm = document.getElementById('chat-form');
  const chatInput = document.getElementById('chat-input');
  const faqDesktop = document.getElementById('faq-list-desktop');
  const faqMobilePlaceholder = document.getElementById('faq-mobile-placeholder');
  const csrfToken = document.querySelector('input[name="_token"]').value;
  const attachmentInput = document.getElementById('chat-attachment');
  const attachmentBtn = document.getElementById('attachment-btn');
  const clearAttachmentBtn = document.getElementById('clear-attachment-btn');
  const attachmentName = document.getElementById('attachment-name');
  const customModal = document.getElementById('customModal');
  const customModalMessage = document.getElementById('customModalMessage');
  const customClose = document.querySelector('.custom-close');
  const MAX_ATTACHMENT_BYTES = 25 * 1024 * 1024;
  const ALLOWED_ATTACHMENT_TYPES = [
    'image/jpeg', 'image/png', 'image/gif', 'image/webp',
    'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv',
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'text/plain'
  ];

  let searchActive = false;

  function showStatusModal(message) {
    if (!customModal || !customModalMessage) return alert(message);
    customModalMessage.textContent = message;
    customModal.style.display = 'flex';
  }

  customClose?.addEventListener('click', () => {
    customModal.style.display = 'none';
  });

  window.addEventListener('click', (event) => {
    if (event.target === customModal) {
      customModal.style.display = 'none';
    }
  });

  function getErrorMessage(result) {
    if (result?.errors) {
      const firstError = Object.values(result.errors).flat()[0];
      if (firstError) return firstError;
    }

    return result?.error || result?.message || 'Failed to send message.';
  }

  // Only create mobile FAQ if it doesn't already exist
    if (faqDesktop && faqMobilePlaceholder && !document.getElementById('faq-list-mobile')) {
        const faqClone = faqDesktop.cloneNode(true);
        faqClone.id = 'faq-list-mobile';
        faqClone.classList.add('dropdown-faq-list');

        const wrapper = document.createElement('div');
        wrapper.classList.add('px-3');
        wrapper.appendChild(faqClone);

        faqMobilePlaceholder.appendChild(wrapper);
    }

    // Bind FAQ clicks to **all current items**, mobile + desktop
    function bindFaqClicks() {
        document.querySelectorAll('.faq-list li').forEach(item => {
            // Remove previous click to prevent duplicate events
            item.replaceWith(item.cloneNode(true));
        });

        document.querySelectorAll('.faq-list li').forEach(item => {
            item.addEventListener('click', () => {
                const faqMessage = item.getAttribute('data-question');
                sendMessage(faqMessage, 1);
            });
        });
    }

    bindFaqClicks();

  function isAnyVideoPlaying() {
    return Array.from(chatMessages.querySelectorAll('video')).some(video => !video.paused && !video.ended);
  }

  function formatAttachment(messageObj) {
    if (!messageObj?.attachment_url) return '';

    if (messageObj.attachment_type === 'image') {
      return `<div class="mt-2"><a href="${messageObj.attachment_url}" target="_blank" rel="noopener noreferrer"><img src="${messageObj.attachment_url}" alt="${messageObj.attachment_name || 'Attachment'}" style="max-width:220px; border-radius:10px;"></a></div>`;
    }

    if (messageObj.attachment_type === 'video') {
      return `<div class="mt-2" style="width:220px; max-width:100%;"><video controls preload="metadata" playsinline style="display:block; width:100%; aspect-ratio:16 / 9; background:#000; object-fit:contain; border-radius:10px;"><source src="${messageObj.attachment_url}" type="${messageObj.attachment_mime || 'video/mp4'}"></video></div>`;
    }

    return `<div class="mt-2"><a href="${messageObj.attachment_url}" target="_blank" rel="noopener noreferrer"><i class="fas fa-file me-1"></i>${messageObj.attachment_name || 'Attachment'}</a></div>`;
  }

  function updateAttachmentLabel() {
    const file = attachmentInput.files[0];
    attachmentName.textContent = file ? `Selected: ${file.name}` : '';
    clearAttachmentBtn.style.display = file ? 'inline-flex' : 'none';
  }

  function validateAttachmentFile(file) {
    if (!file) return true;

    if (file.size > MAX_ATTACHMENT_BYTES) {
      showStatusModal('The selected file is too large. Maximum allowed size is 25 MB.');
      attachmentInput.value = '';
      updateAttachmentLabel();
      return false;
    }

    if (file.type && !ALLOWED_ATTACHMENT_TYPES.includes(file.type)) {
      showStatusModal('Only images, videos, and common document files are allowed.');
      attachmentInput.value = '';
      updateAttachmentLabel();
      return false;
    }

    return true;
  }

  attachmentBtn.addEventListener('click', () => attachmentInput.click());
  attachmentInput.addEventListener('change', () => {
    const file = attachmentInput.files[0];
    if (!validateAttachmentFile(file)) return;
    updateAttachmentLabel();
  });
  clearAttachmentBtn.addEventListener('click', () => {
    attachmentInput.value = '';
    updateAttachmentLabel();
  });

  chatMessages.addEventListener('play', event => {
    if (event.target.tagName !== 'VIDEO') return;

    chatMessages.querySelectorAll('video').forEach(video => {
      if (video !== event.target) video.pause();
    });
  }, true);

  function appendMessage(messageObj) {
    const sender = messageObj.sender || '';
    const message = messageObj.message || '';
    const msg = document.createElement('div');
    msg.classList.add('chat-message');
    const attachmentHtml = formatAttachment(messageObj);

    if (sender.toLowerCase().startsWith('others/')) {
      msg.classList.add('message-user');
      msg.innerHTML = `<strong>You:</strong> ${message}${attachmentHtml}`;
    } else {
      msg.classList.add('message-system');
      msg.innerHTML = `<strong>${sender}:</strong> ${message}${attachmentHtml}`;
    }

    chatMessages.appendChild(msg);
  }

  async function fetchMessages() {
    try {
      if (isAnyVideoPlaying()) return;

      const res = await fetch('/others/messages');
      const data = await res.json();

      // detect if user is near bottom BEFORE update
      const isNearBottom =
        chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight < 80;

      chatMessages.innerHTML = '';

      if (data.success) {
        data.messages.forEach(msg => appendMessage(msg));
      }

      // wait for DOM paint so height is correct
      if (isNearBottom && !isAnyVideoPlaying()) {
        setTimeout(() => {
          if (!isAnyVideoPlaying()) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
          }
        }, 50);
      }

    } catch (err) {
      console.error("Fetch error:", err);
    }
  }


  async function sendMessage(message, fromFaq = 0) {
    const file = attachmentInput.files[0];
    if (!message && !file) return;

    // Append immediately
    appendMessage({
      sender: 'others/You',
      message,
      attachment_url: file ? URL.createObjectURL(file) : null,
      attachment_name: file ? file.name : null,
      attachment_type: file ? (file.type.startsWith('image/') ? 'image' : (file.type.startsWith('video/') ? 'video' : 'document')) : null,
      attachment_mime: file ? file.type : null,
    });

    // scroll immediately for user's own message
    chatMessages.scrollTop = chatMessages.scrollHeight;

    chatInput.value = '';
    attachmentInput.value = '';
    updateAttachmentLabel();

    try {
      const formData = new FormData();
      formData.append('message', message);
      formData.append('from_faq', fromFaq);
      if (file) formData.append('attachment', file);

      const res = await fetch('/others/messages', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: formData
      });

      const result = await res.json();
      if (!res.ok || !result.success) {
        fetchMessages();
        showStatusModal(getErrorMessage(result));
        return console.error("Message failed:", result.error || result);
      }

      fetchMessages();
    } catch (err) {
      fetchMessages();
      showStatusModal('Failed to send message. Please try again.');
      console.error("Send error:", err);
    }
  }

  chatForm.addEventListener('submit', e => {
    e.preventDefault();
    sendMessage(chatInput.value.trim());
  });

  // faqItems.forEach(item => {
  //   item.addEventListener('click', () => {
  //     const faqMessage = item.getAttribute('data-question');
  //     sendMessage(faqMessage, 1);
  //   });
  // });

  // Poll for new messages every 2 seconds
  setInterval(() => {
        if (!searchActive) fetchMessages();
    }, 2000);

  // Initial fetch
  fetchMessages();
  const searchInput = document.getElementById('chat-search');
    const nextBtn = document.getElementById('next-match');
    const prevBtn = document.getElementById('prev-match');
    const counter = document.getElementById('match-counter');


    let matches = [];
    let currentIndex = -1;

    // Highlight matches
    function performSearch() {
        const term = searchInput.value.toLowerCase();
        const messages = document.querySelectorAll('.chat-message');

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

            const text = original.toLowerCase();

            if (text.includes(term)) {
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




// Redirect if page is loaded from bfcache
window.addEventListener('pageshow', function(event) {
  if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
    window.location.href = "{{ route('login') }}";
  }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const notifBtn = document.getElementById('notifBtn');
  const notifPanel = document.getElementById('notifPanel');
  const notifList = document.getElementById('notifList');
  const notifBadge = document.getElementById('notifBadge');
  const accountNotifBadge = document.getElementById('accountNotifBadge');

  const closeBtn = document.getElementById('notifCloseBtn');
  const markReadBtn = document.getElementById('notifMarkReadBtn');
  const deleteReadBtn = document.getElementById('notifDeleteReadBtn');
  const refreshBtn = document.getElementById('notifRefreshBtn');

  if (!notifBtn || !notifPanel || !notifList) return;

  function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, (m) => ({
      "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;"
    }[m]));
  }

  function formatDate(dateStr) {
    const d = new Date(dateStr);
    return Number.isNaN(d.getTime()) ? '' : d.toLocaleString();
  }

  function setBadge(count){
    const badges = [notifBadge, accountNotifBadge];
    badges.forEach((badge) => {
      if (!badge) return;
      if (count > 0){
        badge.style.display = 'inline-block';
        badge.textContent = count;
      } else {
        badge.style.display = 'none';
        badge.textContent = '0';
      }
    });
  }

  async function refreshUnreadCount(){
    try{
      const res = await fetch("{{ route('others.notifications') }}", {
        headers: { "Accept": "application/json" }
      });
      const data = await res.json();
      if (data?.success) setBadge(data.unread_count || 0);
    }catch(e){}
  }

  // Realtime badge update immediately on load and then continuously.
  refreshUnreadCount();
  setInterval(refreshUnreadCount, 3000);

  if (accountNotifBadge) {
    accountNotifBadge.style.position = 'absolute';
    accountNotifBadge.style.top = '-4px';
    accountNotifBadge.style.right = '-10px';
    accountNotifBadge.style.fontSize = '0.72rem';
    accountNotifBadge.style.minWidth = '20px';
    accountNotifBadge.style.lineHeight = '1';
    accountNotifBadge.style.padding = '0.28rem 0.35rem';
    accountNotifBadge.style.pointerEvents = 'none';
  }

  if (notifBadge) {
    notifBadge.style.minWidth = '20px';
    notifBadge.style.lineHeight = '1';
    notifBadge.style.padding = '0.28rem 0.35rem';
  }

  if (window.innerWidth < 576 && accountNotifBadge) {
    accountNotifBadge.style.right = '-6px';
    accountNotifBadge.style.top = '-3px';
  }

  window.addEventListener('resize', () => {
    if (!accountNotifBadge) return;
    if (window.innerWidth < 576) {
      accountNotifBadge.style.right = '-6px';
      accountNotifBadge.style.top = '-3px';
    } else {
      accountNotifBadge.style.right = '-10px';
      accountNotifBadge.style.top = '-4px';
    }
  });

  async function loadNotifications(){
    notifList.innerHTML = `<div class="notif-empty">Loading...</div>`;

    let data;
    try{
      const res = await fetch("{{ route('others.notifications') }}", {
        headers: { "Accept": "application/json" }
      });
      data = await res.json();
    }catch(e){
      notifList.innerHTML = `<div class="notif-empty text-danger">Failed to load notifications.</div>`;
      return;
    }

    if (!data?.success){
      notifList.innerHTML = `<div class="notif-empty text-danger">Failed to load notifications.</div>`;
      return;
    }

    setBadge(data.unread_count || 0);

    if (!data.notifications?.length){
      notifList.innerHTML = `<div class="notif-empty">No notifications yet.</div>`;
      return;
    }

    notifList.innerHTML = data.notifications.map(n => {
      const unread = !n.is_read;
      return `
        <div class="notif-item ${unread ? 'unread' : ''}">
          <div class="notif-title">${escapeHtml(n.title || 'Notification')}</div>
          <div class="notif-msg">${escapeHtml(n.message || '')}</div>
          <div class="notif-time">${formatDate(n.created_at)}</div>
        </div>
      `;
    }).join('');
  }

  function positionPanel(){
    // make sure panel can be positioned
    const rect = notifBtn.getBoundingClientRect();
    const panelWidth = Math.min(420, window.innerWidth - 16);
    const gap = 8;

    let top = rect.bottom + gap;
    let left = rect.right - panelWidth;

    left = Math.max(8, Math.min(left, window.innerWidth - panelWidth - 8));

    notifPanel.style.top = `${top}px`;
    notifPanel.style.left = `${left}px`;
    notifPanel.style.width = `${panelWidth}px`;
  }

  function openPanel(){
    notifPanel.style.display = 'block';
    positionPanel();
    loadNotifications(); 
  }

  function closePanel(){
    notifPanel.style.display = 'none';
  }

  window.addEventListener('resize', () => {
    if (notifPanel.style.display === 'block') positionPanel();
  });

  window.addEventListener('scroll', (e) => {
    // ignore scroll events coming from inside the notif panel/list
    if (notifPanel.contains(e.target)) return;

    if (notifPanel.style.display === 'block') positionPanel();
  }, { passive: true });


  // Toggle panel
  notifBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    e.stopPropagation();
    const isOpen = notifPanel.style.display === 'block';
    if (isOpen) closePanel();
    else openPanel();
  });

  closeBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    closePanel();
  });

  // close when clicking outside (but keep dropdown behavior safe)
  document.addEventListener('click', (e) => {
    if (!notifPanel.contains(e.target) && e.target !== notifBtn) closePanel();
  });

  // Actions
  markReadBtn?.addEventListener('click', async (e) => {
    e.preventDefault(); e.stopPropagation();
    await fetch("{{ route('others.notifications.markRead') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json"
      },
      body: JSON.stringify({})
    });
    await loadNotifications();
  });

  deleteReadBtn?.addEventListener('click', async (e) => {
    e.preventDefault(); e.stopPropagation();

    // optional confirm
    if(!confirm("Delete all read notifications?")) return;

    await fetch("{{ route('others.notifications.deleteRead') }}", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json"
      }
    });

    await loadNotifications();
  });

  refreshBtn?.addEventListener('click', async (e) => {
    e.preventDefault(); e.stopPropagation();
    await loadNotifications();
  });


});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {

  // ===== Privacy modal logic (professional UX) =====
  const complaintModalEl = document.getElementById("complaintModal");
  const privacyModal = document.getElementById("privacyModal");
  const agreeCheckbox = document.getElementById("agreeCheckbox");
  const acceptBtn = document.getElementById("acceptBtn");

  const closeBtn = document.querySelector(".privacy-close");
  const cancelBtn = document.querySelector(".privacy-cancel");

  function showPrivacy() {
    if (!privacyModal) return;
    privacyModal.classList.add("show");
    privacyModal.setAttribute("aria-hidden", "false");
    if (agreeCheckbox) agreeCheckbox.checked = false;
    if (acceptBtn) acceptBtn.disabled = true;
  }

  function hidePrivacy() {
    if (!privacyModal) return;
    privacyModal.classList.remove("show");
    privacyModal.setAttribute("aria-hidden", "true");
  }

  function closeComplaintModal() {
    if (!complaintModalEl) return;
    const bsModal = bootstrap.Modal.getInstance(complaintModalEl) || new bootstrap.Modal(complaintModalEl);
    bsModal.hide();
  }

  // Open privacy whenever complaint modal opens
  complaintModalEl?.addEventListener("shown.bs.modal", showPrivacy);

  // Cleanup when complaint modal closes
  complaintModalEl?.addEventListener("hidden.bs.modal", hidePrivacy);

  // enable proceed when checked
  agreeCheckbox?.addEventListener("change", () => {
    if (!acceptBtn) return;
    acceptBtn.disabled = !agreeCheckbox.checked;
  });

  // Proceed
  acceptBtn?.addEventListener("click", () => {
    if (!agreeCheckbox?.checked) return;
    hidePrivacy();
  });

  // Close buttons (X / Cancel) -> close complaint too
  closeBtn?.addEventListener("click", () => { hidePrivacy(); closeComplaintModal(); });
  cancelBtn?.addEventListener("click", () => { hidePrivacy(); closeComplaintModal(); });

  // clicking the dimmed background closes complaint too (optional)
  privacyModal?.addEventListener("click", (e) => {
    if (e.target === privacyModal) {
      hidePrivacy();
      closeComplaintModal();
    }
  });

  // ===== Name mode: anonymous vs real =====
  const nameModeAnonymous = document.getElementById("nameModeAnonymous");
  const nameModeReal = document.getElementById("nameModeReal");
  const finalNameInput = document.getElementById("finalNameInput");

  const loggedFullName = @json($fullName);

  function syncFinalName() {
    if (!finalNameInput) return;

    if (nameModeReal && nameModeReal.checked) {
      finalNameInput.value = loggedFullName || "Anonymous";
    } else {
      finalNameInput.value = "Anonymous";
    }
  }

  nameModeAnonymous?.addEventListener("change", syncFinalName);
  nameModeReal?.addEventListener("change", syncFinalName);

  // Set initial value on load
  syncFinalName();

  // Reset to anonymous each time the complaint modal opens
  complaintModalEl?.addEventListener("shown.bs.modal", () => {
    if (nameModeAnonymous) nameModeAnonymous.checked = true;
    syncFinalName();
  });

  // ===== Image preview =====
  const imageUpload = document.getElementById("imageUpload");
  const imagePreview = document.getElementById("imagePreview");
  const imageContainer = document.getElementById("imageContainer");

  window.previewImage = function (event) {
    if (!event.target.files?.[0]) return;
    if (!imagePreview || !imageContainer) return;

    imagePreview.src = URL.createObjectURL(event.target.files[0]);
    imageContainer.style.display = "block";
  };

  window.removeImage = function () {
    if (imageUpload) imageUpload.value = "";
    if (imagePreview) imagePreview.src = "#";
    if (imageContainer) imageContainer.style.display = "none";
  };

  // ===== Video preview =====
  const videoUpload = document.getElementById("videoUpload");
  const videoPreview = document.getElementById("videoPreview");
  const videoContainer = document.getElementById("videoContainer");

  window.previewVideo = function (event) {
    if (!event.target.files?.[0]) return;
    if (!videoPreview || !videoContainer) return;

    videoPreview.src = URL.createObjectURL(event.target.files[0]);
    videoContainer.style.display = "block";
  };

  window.removeVideo = function () {
    if (videoUpload) videoUpload.value = "";
    if (videoPreview) {
      videoPreview.pause();
      videoPreview.removeAttribute("src");
      videoPreview.load();
    }
    if (videoContainer) videoContainer.style.display = "none";
  };

  // ===== Form submit block (privacy only) =====
  const form = document.getElementById("complaintForm");
  form?.addEventListener("submit", (e) => {
    if (privacyModal && privacyModal.classList.contains("show")) {
      e.preventDefault();
      // showCustom?.("Please accept the Privacy Notice before submitting.");
      alert("Please accept the Privacy Notice before submitting.");
      return;
    }
  });

});
</script>

<script>
  /* Mobile: complaint inside account dropdown */
document.addEventListener("click", function(e){

  const menu = document.getElementById("accountDropdownMenu");
  if(!menu) return;

  const rect = menu.getBoundingClientRect();
  const clickY = e.clientY;

  // detect click on the "fake" last item
  if(window.innerWidth <= 576){
    if(e.target.closest("#accountDropdownMenu") &&
       clickY > rect.bottom - 45){   // bottom area = fake item
       
        const modal = new bootstrap.Modal(document.getElementById('complaintModal'));
        modal.show();
    }
  }
});
</script>

@endsection
