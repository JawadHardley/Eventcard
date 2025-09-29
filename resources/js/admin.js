import '@tabler/core/dist/js/tabler.min.js';

const html = document.documentElement;
    const toggleBtn = document.getElementById("themeToggle");
    const themeIcon = document.getElementById("themeIcon");

    // Set initial theme from localStorage
    if (html && toggleBtn && themeIcon) {
        const storedTheme = localStorage.getItem("preferred-theme") || "light";
        html.setAttribute("data-bs-theme", storedTheme);
        updateIcon(storedTheme);

        toggleBtn.addEventListener("click", function () {
            const currentTheme = html.getAttribute("data-bs-theme");
            const newTheme = currentTheme === "dark" ? "light" : "dark";
            html.setAttribute("data-bs-theme", newTheme);
            localStorage.setItem("preferred-theme", newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            if (themeIcon) {
                if (theme === "dark") {
                    themeIcon.classList.remove("fa-moon");
                    themeIcon.classList.add("fa-sun");
                } else {
                    themeIcon.classList.remove("fa-sun");
                    themeIcon.classList.add("fa-moon");
                }
            }
        }
    }