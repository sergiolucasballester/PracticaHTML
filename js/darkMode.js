// darkMode.js - Gestión de modo oscuro persistente
(function () {
  // Función para aplicar el modo oscuro
  function applyDarkMode(isDark) {
    const html = document.documentElement;
    if (isDark) {
      html.classList.add("dark");
      localStorage.setItem("darkMode", "true");
    } else {
      html.classList.remove("dark");
      localStorage.setItem("darkMode", "false");
    }
  }

  // Leer preferencia guardada
  function initDarkMode() {
    const savedDarkMode = localStorage.getItem("darkMode");
    const prefersDark =
      window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;

    const isDark = savedDarkMode === "true" || (savedDarkMode === null && prefersDark);
    applyDarkMode(isDark);
  }

  // Exponer función global para cambiar modo
  window.toggleDarkMode = function () {
    const html = document.documentElement;
    const isDark = html.classList.contains("dark");
    applyDarkMode(!isDark);
  };

  // Inicializar al cargar
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initDarkMode);
  } else {
    initDarkMode();
  }
})();
