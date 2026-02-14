const users = [
  {
    name: "Sergio",
    surname: "Lucas Ballester",
    phone: "+34695363636",
    email: "sergiolucasballester@gmail.com",
    sex: "Masculino",
  },
  {
    name: "Lola",
    surname: "Pérez Pérez",
    phone: "+34695363636",
    email: "lolaperez@gmail.com",
    sex: "Femenino",
  },
  {
    name: "Antonio",
    surname: "Martínez Martínez",
    phone: "+34695363636",
    email: "antoniomartinez@gmail.com",
    sex: "Masculino",
  },
];
const tableBody = document.getElementById("tableBody");

const filter = document.getElementById("filter");

let editingIndex = null;

function createRowForUser(user, index) {
  const row = document.createElement("tr");

  const tdName = document.createElement("td");
  tdName.textContent = user.name;

  const tdSurname = document.createElement("td");
  tdSurname.textContent = user.surname;

  const tdPhone = document.createElement("td");
  tdPhone.textContent = user.phone;

  const tdEmail = document.createElement("td");
  tdEmail.textContent = user.email;

  const tdSex = document.createElement("td");
  tdSex.textContent = user.sex;

  const tdActions = document.createElement("td");

  const btnEdit = document.createElement("button");
  btnEdit.textContent = "Editar";
  btnEdit.addEventListener("click", () => {
    openEditForm(index, user);
  });

  const btnDelete = document.createElement("button");
  btnDelete.textContent = "X";

  btnDelete.addEventListener("click", () => {
    row.remove();
    users.splice(index, 1);
  });

  tdActions.appendChild(btnEdit);
  tdActions.appendChild(btnDelete);
  row.append(tdName, tdSurname, tdPhone, tdEmail, tdSex, tdActions);

  tableBody.appendChild(row);
}
function showUsers(users) {
  tableBody.innerHTML = "";
  users.forEach((user, index) => createRowForUser(user, index));
}
function filterUsers() {
  const textToFilter = filter.value.trim().toLowerCase();
  if (textToFilter.length < 3) {
    showUsers(users);
    return;
  }

  const results = users.filter(
    (user) =>
      user.name.toLowerCase().includes(textToFilter) ||
      user.surname.toLowerCase().includes(textToFilter),
  );

  showUsers(results);
}

function openEditForm(index, user) {
  editingIndex = index;
  document.getElementById("editName").value = user.name;
  document.getElementById("editSurname").value = user.surname;
  document.getElementById("editPhone").value = user.phone;
  document.getElementById("editEmail").value = user.email;
  document.getElementById("editSex").value = user.sex;
  document.getElementById("editModal").classList.add("show");
}

function closeEditForm() {
  document.getElementById("editModal").classList.remove("show");
  editingIndex = null;
}

function saveUserChanges() {
  if (editingIndex !== null) {
    users[editingIndex].name = document.getElementById("editName").value;
    users[editingIndex].surname = document.getElementById("editSurname").value;
    users[editingIndex].phone = document.getElementById("editPhone").value;
    users[editingIndex].email = document.getElementById("editEmail").value;
    users[editingIndex].sex = document.getElementById("editSex").value;
    showUsers(users);
    closeEditForm();
  }
}

window.onload = () => showUsers(users);

filter.addEventListener("input", filterUsers);
