

document.addEventListener('DOMContentLoaded', () => {
      const params = new URLSearchParams(window.location.search);

  // ✅ if coming from facebook others flow, DO NOT show the client type modal
  if (params.get('open') === 'others-register' && params.get('clientType') === 'others') {
    const modal = document.getElementById('clientTypeModal');
    if (modal) modal.style.display = 'none';
  }

    const modal = document.getElementById('clientTypeModal');
    const continueBtn = document.getElementById('continueBtn');
    const modalSelect = document.getElementById('clientTypeSelect');
    const inlineSelect = document.getElementById('clientTypeSelector');
    const registerSection = document.querySelector('.registerButton');
    const formsContainer = document.getElementById('loginForms');
    const clientTypeDropdown = document.getElementById('clienttype');

    // Login Forms
    const forms = {
        student: document.getElementById('studentLoginForm'),
        faculty: document.getElementById('facultyLoginForm'),
        alumni: document.getElementById('alumniLoginForm'),
        others: document.getElementById('othersLoginForm'),
    };

    // Registration Forms
    const registerForms = {
        student: document.getElementById('form-student'),
        faculty: document.getElementById('form-faculty'),
        alumni: document.getElementById('form-alumni'),
        others: document.getElementById('form-others'),
    };

    function hideAllForms(){
        Object.values(forms).forEach(f => f.classList.add('hidden'));
        Object.values(registerForms).forEach(f => f.classList.add('hidden'));
    }

    function showRegistrationForm(type){
        hideAllForms();
        formsContainer.classList.remove('hidden');
        if(clientTypeDropdown) clientTypeDropdown.style.display = 'block';
        if(registerForms[type]) registerForms[type].classList.remove('hidden');
        if(inlineSelect) inlineSelect.value = type;

        // Special logic for alumni: populate grad years
        if(type === 'alumni'){
            const gradSelect = document.getElementById('gradYearSelect');
            if(gradSelect && gradSelect.options.length <= 1){ // only populate once
                const currentYear = new Date().getFullYear();
                for(let y=currentYear; y>=1950; y--){
                    const opt = document.createElement('option');
                    opt.value = y;
                    opt.textContent = y;
                    gradSelect.appendChild(opt);
                }
            }
        }
    }

    // Dropdown listener
    if(inlineSelect){
        inlineSelect.addEventListener('change', function(){
            const type = this.value;
            showRegistrationForm(type);
        });
    }

    // Modal logic
    const urlParams = new URLSearchParams(window.location.search);
    const skipModal = urlParams.get('skipModal');

    if(modal && skipModal !== "1"){
        modal.style.display = 'flex';
        formsContainer.classList.add('hidden');
        hideAllForms();
        if(clientTypeDropdown) clientTypeDropdown.style.display = 'none';
    } else {
        if(registerSection) registerSection.style.display = 'block';
        const defaultType = inlineSelect?.value || 'student';
        showRegistrationForm(defaultType);
        if(inlineSelect) inlineSelect.scrollIntoView({behavior: "smooth", block: "center"});
    }

    // Modal continue button
    if(continueBtn && modalSelect){
        continueBtn.addEventListener('click', () => {
            const selectedValue = modalSelect.value;
            if(!selectedValue){
                showwModal("Please select your client type.");
                return;
            }
            modal.style.display = 'none';
            if(selectedValue === 'register'){
                showRegistrationForm('student');
            } else {
                formsContainer.classList.remove('hidden');
                if(forms[selectedValue]) forms[selectedValue].classList.remove('hidden');
                if(clientTypeDropdown) clientTypeDropdown.style.display = 'none';
            }
        });
    }

    // Back to client type modal
    window.goBackToClientType = function(){
        Object.values(forms).forEach(f => f.classList.add('hidden'));
        Object.values(registerForms).forEach(f => f.classList.add('hidden'));
        if(formsContainer) formsContainer.classList.add('hidden');
        if(modal) modal.style.display = 'flex';
        if(registerSection) registerSection.style.display = 'block';
    };

    window.closeModal = function(modalId){
        const modalToClose = document.getElementById(modalId);
        if(modalToClose) modalToClose.style.display = 'none';
    };

    // --- Alumni: Other Course (optional) ---
    const alumniCourseSelect = document.getElementById('courseSelect');
    const otherCourseInput = document.getElementById('otherCourseInput'); // add this input in your HTML

    if(alumniCourseSelect && otherCourseInput){
        alumniCourseSelect.addEventListener('change', () => {
            if(alumniCourseSelect.value === 'Other'){
                otherCourseInput.style.display = 'block';
                otherCourseInput.required = true;
                otherCourseInput.focus();
            } else {
                otherCourseInput.style.display = 'none';
                otherCourseInput.required = false;
            }
        });

        registerForms.alumni.addEventListener('submit', (e) => {
            if(alumniCourseSelect.value === 'Other'){
                const val = otherCourseInput.value.trim();
                if(!val){
                    e.preventDefault();
                    showwModal("Please specify your course.");
                    otherCourseInput.focus();
                    return false;
                }
                alumniCourseSelect.value = val; // copy the other course into select
            }
        });
    }

});
