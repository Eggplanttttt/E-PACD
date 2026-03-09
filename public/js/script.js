let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
};

window.onscroll = () => {
    navbar.classList.remove('active');
};

// Show login form popup (safe check)
const showPopupBtn = document.querySelector(".login-btn");
const hidePopupBtn = document.querySelector(".form-popup .close-btn");

if (showPopupBtn) {
    showPopupBtn.addEventListener("click", () => {
        document.body.classList.toggle("show-popup");
    });
}

if (hidePopupBtn && showPopupBtn) {
    hidePopupBtn.addEventListener("click", () => showPopupBtn.click());
}

// ================= SEARCH HIGHLIGHT FUNCTION =================
function scrollToWord() {
    let searchText = document.getElementById("search").value.trim().toLowerCase();
    let elements = document.querySelectorAll("h1, h2, h3, p, td, span, div");

    // Remove previous highlights
    document.querySelectorAll(".highlight").forEach(el => {
        let parent = el.parentNode;
        parent.replaceChild(document.createTextNode(el.textContent), el);
    });

    if (searchText === "") return;

    let matches = [];
    let currentIndex = 0;

    elements.forEach(element => {
        let textNodes = Array.from(element.childNodes).filter(node => node.nodeType === Node.TEXT_NODE);

        textNodes.forEach(textNode => {
            let regex = new RegExp(`\\b(${searchText})\\b`, "gi");
            let text = textNode.textContent;

            if (text.toLowerCase().includes(searchText)) {
                let newHTML = text.replace(regex, `<span class="highlight">$1</span>`);
                let wrapper = document.createElement("span");
                wrapper.innerHTML = newHTML;

                let highlightSpans = wrapper.querySelectorAll(".highlight");
                textNode.replaceWith(...wrapper.childNodes);
                highlightSpans.forEach(span => matches.push(span));
            }
        });
    });

    if (matches.length > 0) {
        matches[currentIndex].scrollIntoView({ behavior: "smooth", block: "center" });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Enter" && matches.length > 0) {
            event.preventDefault();
            currentIndex = (currentIndex + 1) % matches.length;
            matches[currentIndex].scrollIntoView({ behavior: "smooth", block: "center" });
        }
    });
}

// ================= DROPDOWN HANDLING =================
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    if (dropdown) dropdown.classList.toggle("show");
}

// Close dropdown when clicking outside
window.onclick = function (event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-content.show').forEach(menu => {
            menu.classList.remove('show');
        });
    }
};

// ================= OFFICE TOGGLER (NO CLASSES, JUST IDS) =================
document.addEventListener('DOMContentLoaded', () => {
  const dropdownLinks = document.querySelectorAll('.dropdown-content a[data-office]');

  // Only hide known office sections — NOT all .container elements
  const officeIds = [
    'officeCashier',
    'knowledgeCenter',
    'medicalServices',
    'alumni',
    'officeRegistrar',
    'officeDean',
    'officeLibrary'
  ];

  function hideAllOffices() {
    officeIds.forEach(id => {
      const section = document.getElementById(id);
      if (section) section.style.display = 'none';
    });
  }

  function showOffice(officeId) {
    hideAllOffices();
    const target = document.getElementById(officeId);
    if (target) {
      target.style.display = 'block';
      console.log('Showing:', officeId);
    } else {
      console.warn(`Office not found: ${officeId}`);
    }
  }

  dropdownLinks.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const officeId = link.dataset.office;
      if (officeId) showOffice(officeId);
    });
  });

  // Hide all initially
  hideAllOffices();
});




// ================= ACCORDION =================
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', function () {
        this.parentElement.classList.toggle('active');
    });
});

// ================= HEADER SCROLL EFFECT =================
window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// ================= ACTIVE NAV LINK ON SCROLL =================
const navLinks = document.querySelectorAll('.header .navbar a');

function onScroll() {
    const scrollPos = window.scrollY + 100;

    navLinks.forEach(link => {
        if (!link.hash) return;

        const section = document.querySelector(link.hash);
        if (!section) return;

        const top = section.offsetTop;
        const bottom = top + section.offsetHeight;

        if (scrollPos >= top && scrollPos < bottom) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

window.addEventListener('scroll', onScroll);
window.addEventListener('load', onScroll);
