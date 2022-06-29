// Get hamburger icon and navigation bar
const hamburger = document.getElementById("hamburger");
const navMenu = document.querySelector(".nav-menu");

// Hide menu when user clicks outside of it
document.addEventListener('mouseup', function(e) {
    // Hide menu when clicking outside of it
    if (!navMenu.contains(e.target)) {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
    }

    // Open menu on click
    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
    });
});

// Close hamburger menu when an item is clicked
document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}));
