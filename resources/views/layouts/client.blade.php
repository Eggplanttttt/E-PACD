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

@yield('scripts')
</body>
</html>
