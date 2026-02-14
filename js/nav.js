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
      highlightCurrentNav();
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

window.addEventListener("load", loadNav);
