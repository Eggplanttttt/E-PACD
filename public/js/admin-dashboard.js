function toggleDropdown() {
    var menu = document.getElementById("dropdownMenu");
    menu.classList.toggle("show");
}

// Close dropdown when clicking outside
document.addEventListener("click", function(event) {
    var dropdown = document.getElementById("dropdownMenu");
    var button = document.querySelector(".profile-btn");

    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
        dropdown.classList.remove("show");
    }
});