const iconForm = document.getElementById("iconForm");
const inputFileImage = document.getElementById("image");
const currentPwdInput = document.getElementById("current-pwd-input");
const newPwdInput = document.getElementById("new-pwd-input");
const confirmPwdInput = document.getElementById("confirm-pwd-input");
const changePwdBtn = document.getElementById("change-pwd-btn");
const pwdChangeModal = document.getElementById("pwdChangeModal");
const changePwdModalForm = document.getElementById("changePwdModalForm");

const sendNewProfileIcon = () => {
  const file = inputFileImage.files[0];
  const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
  const maxFileSize = 100 * 1024;

  if (!allowedTypes.includes(file.type)) {
    window.alert(
      "Niewłaściwy typ pliku. Dopuszczalne rozszerzenia to: jpg, jpeg, png, webp"
    );
  } else if (file.size >= maxFileSize) {
    window.alert(
      "Wybrany przez Ciebie plik jest zbyt duży. Maksymalna dopuszczalna rozmiar wynosi 100 KB"
    );
  } else {
    iconForm.submit();
  }
};

const checkPwdInputs = () => {
  let error = false;
  if (currentPwdInput.value.length < 4) {
    error = true;
    const errorParagraph = currentPwdInput.nextElementSibling;
    currentPwdInput.classList.add("error");
    errorParagraph.classList.remove("d-none");
  }
  if (newPwdInput.value.length < 4) {
    error = true;
    const errorParagraph = newPwdInput.nextElementSibling;
    newPwdInput.classList.add("error");
    errorParagraph.classList.remove("d-none");
  }
  if (confirmPwdInput.value !== newPwdInput.value) {
    error = true;
    const errorParagraph = confirmPwdInput.nextElementSibling;
    confirmPwdInput.classList.add("error");
    errorParagraph.classList.remove("d-none");
  }

  return error;
};

const clearInputError = (e) => {
  const errorParagraph = e.target.nextElementSibling;

  e.target.classList.remove("error");
  errorParagraph.classList.add("d-none");
};

const clearErrors = () => {
  currentPwdInput.value = "";
  newPwdInput.value = "";
  confirmPwdInput.value = "";

  if (currentPwdInput.classList.contains("error")) {
    currentPwdInput.classList.remove("error");

    const errorParagraph = currentPwdInput.nextElementSibling;

    if (!errorParagraph.classList.contains("d-none")) {
      errorParagraph.classList.add("d-none");
    }
  }

  if (newPwdInput.classList.contains("error")) {
    newPwdInput.classList.remove("error");

    const errorParagraph = newPwdInput.nextElementSibling;

    if (!errorParagraph.classList.contains("d-none")) {
      errorParagraph.classList.add("d-none");
    }
  }

  if (confirmPwdInput.classList.contains("error")) {
    confirmPwdInput.classList.remove("error");

    const errorParagraph = confirmPwdInput.nextElementSibling;

    if (!errorParagraph.classList.contains("d-none")) {
      errorParagraph.classList.add("d-none");
    }
  }
};

const sendChangePwdRequest = (e) => {
  e.preventDefault();
  const isErrorExist = checkPwdInputs();
  if (isErrorExist) {
    return;
  } else {
    changePwdModalForm.submit();
  }
};

inputFileImage.addEventListener("change", sendNewProfileIcon);
changePwdBtn.addEventListener("click", sendChangePwdRequest);
currentPwdInput.addEventListener("input", clearInputError);
newPwdInput.addEventListener("input", clearInputError);
confirmPwdInput.addEventListener("input", clearInputError);
pwdChangeModal.addEventListener("hidden.bs.modal", clearErrors);
