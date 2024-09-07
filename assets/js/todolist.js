const removeTodoBtns = document.querySelectorAll(".remove-todo-btn");
const editTodoBtns = document.querySelectorAll(".edit-todo-btn");
const saveChangesBtn = document.querySelector(".save-changes");
const editTodoInput = document.querySelector(".edit-todo-input");
const editTodoDescription = document.querySelector(".edit-todo-description");
const checkboxes = document.querySelectorAll(".todo-checkbox");
const editTodoModal = document.getElementById("editTodoModal");
const addTodoModal = document.getElementById("addTodoModal");
const addTodoTitle = document.querySelector(".add-todo-title");
const addTodoDescription = document.querySelector(".add-todo-description");
const addTodoBtn = document.querySelector(".add-todo-btn");
const searchInput = document.querySelector(".search-input");
const todoItems = document.querySelectorAll(".todo");
const myTasksHeader = document.querySelector(".my-tasks-header");
const searchBox = document.querySelector(".search-box");

let todoId = null;

const setTaskCounter = () => {
  const taskCounter = document.querySelector(".task-counter");

  const tasksAmount = todoItems.length;

  if (tasksAmount >= 2) {
    taskCounter.innerHTML = `Masz ${todoItems.length} zadania do zrobienia`;
    myTasksHeader.classList.remove("d-none");
    searchBox.classList.remove("d-none");
  } else if (tasksAmount === 1) {
    taskCounter.innerHTML = `Masz jedno zadanie do zrobienia`;
    myTasksHeader.classList.remove("d-none");
    searchBox.classList.remove("d-none");
  } else {
    taskCounter.innerHTML = `Nie masz żadnych zadań do zrobienia`;
  }
};

setTaskCounter();

const searchTodoHandler = () => {
  const searchValue = searchInput.value.toLowerCase();

  todoItems.forEach((todo) => {
    const todoTitle = todo
      .querySelector(".todo-title")
      .textContent.toLocaleLowerCase();

    if (todoTitle.includes(searchValue)) {
      todo.classList.add("d-flex");
      todo.classList.remove("d-none");
    } else {
      todo.classList.add("d-none");
      todo.classList.remove("d-flex");
    }
  });
};

const removeTodo = (e) => {
  e.stopPropagation();
  const id = e.currentTarget.getAttribute("data-todo-id");
  const todoDiv = document.getElementById(id);
  const tasksAmount = todoItems.length;

  fetch("/api/remove-todo", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "id=" + id,
  })
    .then(todoDiv.remove())
    .catch((error) => {
      console.error("Wystąpił błąd:", error);
    });
  setTaskCounter();

  if (tasksAmount <= 1) {
    myTasksHeader.classList.add("d-none");
    searchBox.classList.add("d-none");
  }
};

const setEditTitleError = () => {
  editTodoInput.classList.add("error");
  const errorParagraph = editTodoInput.nextElementSibling;
  errorParagraph.classList.remove("d-none");
};

const clearEditTitleError = () => {
  editTodoInput.classList.remove("error");
  const errorParagraph = editTodoInput.nextElementSibling;
  errorParagraph.classList.add("d-none");
};

const updateTodo = (todoId, title = null, description = null) => {
  if (title === "") {
    setEditTitleError();
    return;
  } else {
    const params = new URLSearchParams();
    params.append("id", todoId);
    params.append("title", title);
    params.append("description", description);

    fetch("/api/edit-todo", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: params.toString(),
    })
      .then(() => location.reload())
      .catch((error) => {
        console.error("Wystąpił błąd:", error);
      });
  }
};

const setAddTodoTitleError = () => {
  addTodoTitle.classList.add("error");
  const errorParagraph = addTodoTitle.nextElementSibling;
  errorParagraph.classList.remove("d-none");
};

const clearAddTodoError = () => {
  addTodoTitle.classList.remove("error");
  const errorParagraph = addTodoTitle.nextElementSibling;
  errorParagraph.classList.add("d-none");
};

const toggleCompleteTodo = (e) => {
  const id = e.currentTarget.getAttribute("data-todo-id");

  const todoDiv = document.getElementById(id);
  if (todoDiv.classList.contains("todo-done")) {
    todoDiv.classList.remove("todo-done");
  } else {
    todoDiv.classList.add("todo-done");
  }

  fetch("/api/check-todo", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "id=" + id,
  }).catch((error) => {
    console.error("Wystąpił błąd:", error);
  });
};

const setEditInputs = (e) => {
  todoId = e.currentTarget.getAttribute("data-todo-id");

  const titleParagraph = document.querySelector(
    `.todo-title[data-todo-id="${todoId}"]`
  );
  const descriptionParagraph = document.querySelector(
    `.todo-description[data-todo-id="${todoId}"]`
  );

  editTodoInput.value = titleParagraph.textContent;
  editTodoDescription.value = descriptionParagraph.textContent;
};

// addEventListener'y

editTodoModal.addEventListener("hidden.bs.modal", function () {
  editTodoInput.value = "";
  editTodoDescription.value = "";
  todoId = null;
  clearEditTitleError();
});

addTodoModal.addEventListener("hidden.bs.modal", function () {
  addTodoTitle.value = "";
  addTodoDescription.value = "";
  clearAddTodoError();
});

addTodoBtn.addEventListener("click", (e) => {
  if (addTodoTitle.value === "") {
    e.preventDefault();
    setAddTodoTitleError();
  } else {
    return;
  }
});

searchInput.addEventListener("input", searchTodoHandler);

addTodoTitle.addEventListener("input", clearAddTodoError);

removeTodoBtns.forEach((btn) => {
  btn.addEventListener("click", removeTodo);
});
editTodoBtns.forEach((btn) => {
  btn.addEventListener("click", setEditInputs);
});
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener("click", toggleCompleteTodo);
});

editTodoInput.addEventListener("input", clearEditTitleError);

saveChangesBtn.addEventListener("click", () => {
  if (todoId) {
    const title = editTodoInput.value;
    const description = editTodoDescription.value;
    updateTodo(todoId, title, description);
  }
});
