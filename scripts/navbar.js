// Get hamburger icon and navigation bar
const hamburger = document.getElementById("hamburger");
const navMenu = document.getElementById("nav-menu");

// Manage menu click events
document.addEventListener('mouseup', function(e) {
    // Open/Close menu on click
    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
    }); 

    // Hide menu when clicking outside of it
    if (!navMenu.contains(e.target)) {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
    }

    // Close hamburger menu when an item is clicked
    document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
    }));
});

// Show current tab on navbar
var activePage =  window.location.pathname;
var navLinks = document.querySelectorAll("nav a").
forEach(link => {
    if (link.href.includes(`${activePage}`)) {
        link.classList.add('active');
    }
})