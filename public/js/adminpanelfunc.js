function toggleAddTourForm() {
  const form = document.getElementById("add-tour-form");
  const renameForm = document.getElementById("rename-tour-form");
  const deleteForm = document.getElementById("delete-tour-form");

  form.style.display = form.style.display === "none" ? "block" : "none";
  renameForm.style.display = "none"; // Скрыть форму изменения
  deleteForm.style.display = "none"; // Скрыть форму удаления
}

function toggleDeleteTourForm() {
  const form = document.getElementById("delete-tour-form");
  const addForm = document.getElementById("add-tour-form");
  const renameForm = document.getElementById("rename-tour-form");

  form.style.display = form.style.display === "none" ? "block" : "none";
  addForm.style.display = "none"; // Скрыть форму добавления
  renameForm.style.display = "none"; // Скрыть форму изменения
}

function editTour(id, name, description, price) {
  document.getElementById("edit-tour-id").value = id;
  document.getElementById("edit-tour-name").value = name;
  document.getElementById("edit-tour-description").value = description;
  document.getElementById("edit-tour-price").value = price;

  document.getElementById("rename-tour-form").style.display = "block"; // Показать форму изменения
  document.getElementById("add-tour-form").style.display = "none"; // Скрыть форму добавления
  document.getElementById("delete-tour-form").style.display = "none"; // Скрыть форму удаления
}
