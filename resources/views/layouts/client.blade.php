<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Client Panel')</title>
  <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/client-dashboard.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css')}}">

  @yield('styles')
</head>
<body>


{{-- Offcanvas FAQ Sidebar for Mobile --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="faqSidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Need Help?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="faq-list"></ul>
  </div>
</div>

<div id="logoutRatingModal" class="custom-modal">
  <div class="custom-modal-content logout-rating-modal">
    <h4>Rate Your Chat Experience</h4>
    <p>Before logging out, you can leave a quick 5-star rating for E-PACD chat support.</p>

    <div class="logout-rating-stars" id="logoutRatingStars" aria-label="Chat rating">
      @for ($star = 1; $star <= 5; $star++)
        <button type="button" class="logout-rating-star" data-value="{{ $star }}" aria-label="{{ $star }} star">
          <i class="fa-solid fa-star"></i>
        </button>
      @endfor
    </div>

    <small id="logoutRatingHelpText" class="logout-rating-help">Select a star rating, or choose Later / Never mind to continue logout.</small>

    <div class="logout-rating-actions">
      <button type="button" id="submitLogoutRatingBtn" class="btn btn-success">Submit & Logout</button>
      <button type="button" id="logoutLaterBtn" class="btn btn-outline-secondary">Later</button>
      <button type="button" id="logoutNeverMindBtn" class="btn btn-outline-dark">Never mind</button>
    </div>
  </div>
</div>

{{-- Main Page Content --}}
<main >
  @yield('content')
</main>

{{-- JS --}}
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
{{-- 
<script>
document.addEventListener('DOMContentLoaded', () => {
  const accountDropdownMenu = document.getElementById('accountDropdownMenu');
  const faqSidebar = new bootstrap.Offcanvas(document.getElementById('faqSidebar'));

  function updateDropdownForMobile() {
    const isMobile = window.innerWidth < 992; // Bootstrap lg breakpoint
    const placeholder = document.getElementById('faq-mobile-placeholder');

    if (isMobile && !document.getElementById('toggleFaqBtn')) {
      placeholder.innerHTML = `
        <button class="dropdown-item btn text-start" id="toggleFaqBtn">
          <i class="fas fa-question-circle me-2"></i> FAQ
        </button>
      `;
      document.getElementById('toggleFaqBtn').addEventListener('click', () => faqSidebar.show());
    } else if (!isMobile && placeholder) {
      placeholder.innerHTML = '';
    }
  }

  // Initial check
  updateDropdownForMobile();

  // Update on resize
  window.addEventListener('resize', updateDropdownForMobile);
});

window.addEventListener('pageshow', function(event) {
  const currentUrl = window.location.pathname;
  if (event.persisted && !currentUrl.includes('/settings')) {
    window.location.reload();
  }
});
</script> --}}

<script>
document.addEventListener('DOMContentLoaded', () => {
  const logoutForms = Array.from(document.querySelectorAll('form#logout-form'));
  const ratingModal = document.getElementById('logoutRatingModal');
  const submitRatingBtn = document.getElementById('submitLogoutRatingBtn');
  const laterBtn = document.getElementById('logoutLaterBtn');
  const neverMindBtn = document.getElementById('logoutNeverMindBtn');
  const helpText = document.getElementById('logoutRatingHelpText');
  const ratingStars = Array.from(document.querySelectorAll('.logout-rating-star'));

  if (!logoutForms.length || !ratingModal) return;

  let selectedStars = 0;
  let pendingLogoutForm = null;

  function setSelectedStars(value) {
    selectedStars = value;

    ratingStars.forEach(star => {
      const starValue = Number(star.dataset.value || 0);
      star.classList.toggle('active', starValue <= value);
    });

    helpText.classList.remove('text-danger');
    helpText.textContent = value > 0
      ? `You selected ${value} star${value > 1 ? 's' : ''}.`
      : 'Select a star rating, or choose Later / Never mind to continue logout.';
  }

  function openRatingModal(form) {
    pendingLogoutForm = form;
    setSelectedStars(0);
    ratingModal.style.display = 'flex';
  }

  function closeRatingModal() {
    ratingModal.style.display = 'none';
  }

  function submitLogout(form) {
    if (!form) return;

    closeRatingModal();
    form.dataset.ratingHandled = 'true';
    form.submit();
  }

  async function submitRatingAndLogout() {
    if (!pendingLogoutForm) return;

    if (!selectedStars) {
      helpText.textContent = 'Please select a star rating first, or choose Later / Never mind.';
      helpText.classList.add('text-danger');
      return;
    }

    submitRatingBtn.disabled = true;
    submitRatingBtn.textContent = 'Submitting...';

    try {
      const response = await fetch("{{ route('client.chatRatings.store') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}",
        },
        body: JSON.stringify({ stars: selectedStars }),
      });

      const result = await response.json();

      if (!response.ok || !result.success) {
        helpText.textContent = result.message || 'Failed to submit your rating. You can choose Later or Never mind.';
        helpText.classList.add('text-danger');
        return;
      }

      submitLogout(pendingLogoutForm);
    } catch (error) {
      helpText.textContent = 'Failed to submit your rating. You can choose Later or Never mind.';
      helpText.classList.add('text-danger');
    } finally {
      submitRatingBtn.disabled = false;
      submitRatingBtn.textContent = 'Submit & Logout';
    }
  }

  logoutForms.forEach(form => {
    form.addEventListener('submit', event => {
      if (form.dataset.ratingHandled === 'true') {
        delete form.dataset.ratingHandled;
        return;
      }

      event.preventDefault();
      openRatingModal(form);
    });
  });

  ratingStars.forEach(star => {
    star.addEventListener('click', () => setSelectedStars(Number(star.dataset.value || 0)));
  });

  submitRatingBtn.addEventListener('click', submitRatingAndLogout);
  laterBtn.addEventListener('click', () => submitLogout(pendingLogoutForm));
  neverMindBtn.addEventListener('click', () => submitLogout(pendingLogoutForm));

  ratingModal.addEventListener('click', event => {
    if (event.target === ratingModal) {
      closeRatingModal();
    }
  });
});
</script>

@yield('scripts')
</body>
</html>
