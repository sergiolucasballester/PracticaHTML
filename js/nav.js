function loadNav() {
  console.log("Loading navigation...");
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "nav.html", true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const navContainer = document.createElement("div");
      navContainer.innerHTML = xhr.responseText;
      const body = document.body;
      const header = body.querySelector("header");
      if (header) {
        header.insertAdjacentElement(
          "afterend",
          navContainer.firstElementChild,
        );
      } else {
        body.insertBefore(navContainer.firstElementChild, body.firstChild);
      }
      
      // Ahora que el nav está en el DOM, configurar sus funcionalidades
      highlightCurrentNav();
      setupDarkModeButton();
      updateDarkModeIcon();
    }
  };
  xhr.send();
}

function highlightCurrentNav() {
  const currentPage = window.location.pathname.split("/").pop() || "index.html";
  const navLinks = document.querySelectorAll("nav a");
  navLinks.forEach((link) => {
    const href = link.getAttribute("href");
    if (href === currentPage) {
      link.classList.add("active");
    }
  });
}

// Función para actualizar el icono del dark mode
function updateDarkModeIcon() {
  const html = document.documentElement;
  const sunIcon = document.getElementById('sunIcon');
  const moonIcon = document.getElementById('moonIcon');
  
  if (sunIcon && moonIcon) {
    const isDark = html.classList.contains('dark');
    sunIcon.style.display = isDark ? 'block' : 'none';
    moonIcon.style.display = isDark ? 'none' : 'block';
  }
}

// Función para configurar el botón del dark mode
function setupDarkModeButton() {
  const btn = document.getElementById('darkModeToggle');
  if (btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      // Ejecutar toggleDarkMode si está disponible
      if (window.toggleDarkMode && typeof window.toggleDarkMode === 'function') {
        window.toggleDarkMode();
      }
    });
  }
}

// Escuchar cambios de dark mode
document.addEventListener('darkModeChanged', updateDarkModeIcon);

// Observar cambios en la clase dark del html
new MutationObserver(updateDarkModeIcon).observe(document.documentElement, {
  attributes: true,
  attributeFilter: ['class']
});

window.addEventListener("load", loadNav);
