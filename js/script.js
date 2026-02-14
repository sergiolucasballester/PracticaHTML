/*
  script.js — Manejo asíncrono de usuarios y SweetAlert2
  - Carga usuarios desde ws/getUsuario.php
  - Crea usuarios vía ws/crearUsuario2.php (FormData)
  - Modifica usuarios vía ws/modificarUsuario.php?id=ID
  - Elimina usuarios vía ws/deleteUsuario.php?id=ID
*/

const tableBody = document.getElementById("tableBody");
const filter = document.getElementById("filter");
let users = [];
let editingId = null;

// Construye una fila en la tabla a partir de un usuario
function createRowForUser(user) {
  const row = document.createElement("tr");

  const tdNombre = document.createElement("td");
  tdNombre.textContent = user.nombre || "";

  const tdApellidos = document.createElement("td");
  tdApellidos.textContent = user.apellidos || "";

  const tdTelefono = document.createElement("td");
  tdTelefono.textContent = user.telefono || "";

  const tdEmail = document.createElement("td");
  tdEmail.textContent = user.email || "";

  const tdSexo = document.createElement("td");
  tdSexo.textContent = user.sexo || "";

  const tdActions = document.createElement("td");

  const btnEdit = document.createElement("button");
  btnEdit.textContent = "Editar";
  btnEdit.addEventListener("click", () => openEditForm(user));

  const btnDelete = document.createElement("button");
  btnDelete.textContent = "Eliminar";
  btnDelete.addEventListener("click", () => confirmDeleteUser(user));

  tdActions.appendChild(btnEdit);
  tdActions.appendChild(btnDelete);
  row.append(tdNombre, tdApellidos, tdTelefono, tdEmail, tdSexo, tdActions);

  tableBody.appendChild(row);
}

function showUsers(list) {
  if (!tableBody) return;
  tableBody.innerHTML = "";
  list.forEach((u) => createRowForUser(u));
}

function filterUsers() {
  const textToFilter = filter.value.trim().toLowerCase();
  if (textToFilter.length < 3) {
    showUsers(users);
    return;
  }

  const results = users.filter(
    (user) =>
      (user.nombre && user.nombre.toLowerCase().includes(textToFilter)) ||
      (user.apellidos && user.apellidos.toLowerCase().includes(textToFilter)),
  );

  showUsers(results);
}

// Carga usuarios desde el endpoint
async function loadUsers() {
  try {
    const res = await fetch("ws/getUsuario.php");
    const json = await res.json();
    if (json.success) {
      users = Array.isArray(json.data) ? json.data : [];
      if (tableBody) {
        showUsers(users);
      }
    } else {
      if (typeof Swal !== "undefined") {
        Swal.fire(
          "Error",
          json.message || "No se pudieron cargar usuarios",
          "error",
        );
      }
    }
  } catch (err) {
    if (typeof Swal !== "undefined") {
      Swal.fire("Error", err.message || "Error de red", "error");
    }
  }
}

// --- Crear usuario (formulario) ---
const createForm = document.getElementById("createForm");
if (createForm) {
  createForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(createForm);

    // Validación básica de campos requeridos
    const nombre = formData.get("nombre")?.toString().trim();
    const apellidos = formData.get("apellidos")?.toString().trim();
    const password = formData.get("password")?.toString().trim();
    const fecha = formData.get("fecha_nacimiento")?.toString().trim();

    if (!nombre || !apellidos || !password || !fecha) {
      Swal.fire("Error", "Completa los campos requeridos", "warning");
      return;
    }

    const result = await Swal.fire({
      title: "Confirmar creación",
      text: `Crear usuario ${nombre} ${apellidos}?`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Crear",
    });

    if (!result.isConfirmed) return;

    try {
      const res = await fetch("ws/crearUsuario2.php", {
        method: "POST",
        body: formData,
      });
      const json = await res.json();
      if (json.success) {
        Swal.fire("Creado", json.message, "success");
        // Recargar lista
        loadUsers();
        createForm.reset();
      } else {
        Swal.fire("Error", json.message || "Error al crear", "error");
      }
    } catch (err) {
      Swal.fire("Error", err.message || "Error de red", "error");
    }
  });
}

// --- Editar usuario ---
function openEditForm(user) {
  editingId = user.id;
  document.getElementById("editName").value = user.nombre || "";
  document.getElementById("editSurname").value = user.apellidos || "";
  document.getElementById("editPhone").value = user.telefono || "";
  document.getElementById("editEmail").value = user.email || "";
  document.getElementById("editSex").value = user.sexo || "";
  document.getElementById("editFecha").value = user.fecha_nacimiento || "";
  document.getElementById("editModal").classList.add("show");
}

async function saveUserChanges() {
  if (!editingId) return;

  const formData = new FormData();
  const nombre = document.getElementById("editName").value.trim();
  const apellidos = document.getElementById("editSurname").value.trim();
  const password = document.getElementById("editPassword")
    ? document.getElementById("editPassword").value.trim()
    : "";
  const telefono = document.getElementById("editPhone").value.trim();
  const email = document.getElementById("editEmail").value.trim();
  const sexo = document.getElementById("editSex").value;
  const fecha = document.getElementById("editFecha")
    ? document.getElementById("editFecha").value.trim()
    : "";

  if (nombre) formData.append("nombre", nombre);
  if (apellidos) formData.append("apellidos", apellidos);
  if (password) formData.append("password", password);
  if (telefono) formData.append("telefono", telefono);
  if (email) formData.append("email", email);
  if (sexo) formData.append("sexo", sexo);
  if (fecha) formData.append("fecha_nacimiento", fecha);

  const result = await Swal.fire({
    title: "Confirmar modificación",
    text: `Modificar usuario ID ${editingId}?`,
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Modificar",
  });

  if (!result.isConfirmed) return;

  try {
    const res = await fetch(`ws/modificarUsuario.php?id=${editingId}`, {
      method: "POST",
      body: formData,
    });
    const json = await res.json();
    if (json.success) {
      Swal.fire("Modificado", json.message, "success");
      document.getElementById("editModal").classList.remove("show");
      editingId = null;
      loadUsers();
    } else {
      Swal.fire("Error", json.message || "Error al modificar", "error");
    }
  } catch (err) {
    Swal.fire("Error", err.message || "Error de red", "error");
  }
}

function closeEditForm() {
  document.getElementById("editModal").classList.remove("show");
  editingId = null;
}

// --- Eliminar usuario ---
async function confirmDeleteUser(user) {
  const result = await Swal.fire({
    title: "Confirmar eliminación",
    text: `Eliminar usuario ${user.nombre} ${user.apellidos}?`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Eliminar",
  });

  if (!result.isConfirmed) return;

  try {
    const res = await fetch(`ws/deleteUsuario.php?id=${user.id}`);
    const json = await res.json();
    if (json.success) {
      Swal.fire("Eliminado", json.message, "success");
      loadUsers();
    } else {
      Swal.fire("Error", json.message || "Error al eliminar", "error");
    }
  } catch (err) {
    Swal.fire("Error", err.message || "Error de red", "error");
  }
}

// Inicialización
window.addEventListener("load", () => {
  // Solo inicializar comportamientos de tabla si el elemento existe
  if (tableBody) {
    if (filter) filter.addEventListener("input", filterUsers);
    loadUsers();
  }
});
