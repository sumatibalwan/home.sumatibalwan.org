function includeHTML() {
  const includes = document.querySelectorAll("[data-include]");

  includes.forEach(async (element) => {
    let file = element.getAttribute("data-include");

    if (file) {
      try {
        file = `/lib/html/${file}`;

        const response = await fetch(file);
        if (response.ok) {
          const content = await response.text();
          element.innerHTML = content;

          highlightActiveNav();
          setMenuToggle();
        } else {
          console.error(`Failed to load ${file}: ${response.statusText}`);
        }
      } catch (error) {
        console.error(`Error loading file ${file}:`, error);
      }
    }
  });
}

function highlightActiveNav() {
  const currentPage = window.location.pathname.split("/").pop();

  const navLinks = document.querySelectorAll(".navigation-item");

  navLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active");
    } else {
      link.classList.remove("active"); // Remove active class from non-matching links
    }
  });
}

function setMenuToggle() {
  const menuToggle = document.querySelector(".menu-toggle");
  const navItems = document.querySelectorAll(".navigation-item-container");

  menuToggle.addEventListener("click", () => {
    console.log("click on menu toggle");

    navItems.forEach((item) => {
      item.classList.toggle("show");
    });
  });
}
document.addEventListener("DOMContentLoaded", includeHTML);
