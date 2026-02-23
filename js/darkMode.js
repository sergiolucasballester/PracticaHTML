// darkMode.js - Gestión de modo oscuro persistente
function applyDarkMode(isDark) {
  const html = document.documentElement;
  if (isDark) {
    html.classList.add("dark");
    localStorage.setItem("darkMode", "true");
  } else {
    html.classList.remove("dark");
    localStorage.setItem("darkMode", "false");
  }
  // Disparar evento personalizado para que otros scripts se enteren del cambio
  document.dispatchEvent(new CustomEvent("darkModeChanged", { detail: { isDark } }));
}

function initDarkMode() {
  const savedDarkMode = localStorage.getItem("darkMode");
  const prefersDark =
    window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;

  const isDark = savedDarkMode === "true" || (savedDarkMode === null && prefersDark);
  applyDarkMode(isDark);
}

function toggleDarkMode() {
  const html = document.documentElement;
  const isDark = html.classList.contains("dark");
  applyDarkMode(!isDark);
}

// Exponer función global
window.toggleDarkMode = toggleDarkMode;
window.applyDarkMode = applyDarkMode;

// Inicializar al cargar
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initDarkMode);
} else {
  initDarkMode();
}
