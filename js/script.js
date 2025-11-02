const users = [
    {
        name: "Sergio",
        surname: "Lucas Ballester",
        phone: "+34695363636",
        email: "sergiolucasballester@gmail.com",
        sex: "Masculino"
    },
    {
        name: "Lola",
        surname: "Pérez Pérez",
        phone: "+34695363636",
        email: "lolaperez@gmail.com",
        sex: "Femenino"
    },
    {
        name: "Antonio",
        surname: "Martínez Martínez",
        phone: "+34695363636",
        email: "antoniomartinez@gmail.com",
        sex: "Masculino"
    },
]
const tableBody = document.getElementById("tableBody");

const filter = document.getElementById("filter");

function createRowForUser(user) {
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
    const btnDelete = document.createElement("button");
    btnDelete.textContent = "X";

    btnDelete.addEventListener("click", () => {
        row.remove();
    });

    tdActions.appendChild(btnDelete);
    row.append(tdName, tdSurname, tdPhone, tdEmail, tdSex, tdActions);

    tableBody.appendChild(row);
}
function showUsers(users) {
    tableBody.innerHTML = "";
    users.forEach(user => createRowForUser(user));
}
function filterUsers() {
    const textToFilter = filter.value.trim().toLowerCase();
    if (textToFilter.length < 3) {
        showUsers(users);
        return;
    }

    const results = users.filter(user => user.name.toLowerCase().includes(textToFilter) || user.surname.toLowerCase().includes(textToFilter));

    showUsers(results);
}

window.onload = () => showUsers(users);

filter.addEventListener("input", filterUsers);