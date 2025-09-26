// Function to toggle light/dark mode
function toggleTheme() {
    const body = document.body;
    // Toggle the class between light-mode and dark-mode
    body.classList.toggle("light-mode");
    body.classList.toggle("dark-mode");

    // Change the button icon text
    const toggleButton = document.querySelector('.theme-toggle-btn');
    if (body.classList.contains("dark-mode")) {
        toggleButton.textContent = "🌙"; // Moon icon for dark mode
    } else {
        toggleButton.textContent = "☀️"; // Sun icon for light mode
    }
}

// Check local storage to apply the theme that was last used (if any)
window.onload = () => {
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        document.querySelector('.theme-toggle-btn').textContent = '🌙';
    } else {
        document.body.classList.add('light-mode');
        document.querySelector('.theme-toggle-btn').textContent = '☀️';
    }
};

// Save the theme preference in localStorage
window.onbeforeunload = () => {
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
};





// JS FOR CLASSES page HTML//

// Optional: Add interactivity for navigation or hover effects
document.querySelectorAll('.class-box').forEach((box) => {
    box.addEventListener('mouseover', () => {
        box.style.transform = 'scale(1.05)';
        box.style.transition = 'transform 0.3s';
    });
    box.addEventListener('mouseout', () => {
        box.style.transform = 'scale(1)';
    });
});

//  Highlight interactivity Classes-Instructors Section
document.querySelectorAll('.highlight-item img, .instructor-item img').forEach((item) => {
    item.addEventListener('mouseover', () => {
        item.style.filter = 'brightness(1.2)';
    });
    item.addEventListener('mouseout', () => {
        item.style.filter = 'brightness(1)';
    });
});