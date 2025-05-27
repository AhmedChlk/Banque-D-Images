document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.getElementById("menu-toggle");
  const menuOptions = document.getElementById("menu-options");

  if (menuToggle && menuOptions) {
    menuToggle.addEventListener("click", () => {
      menuOptions.classList.toggle("hidden");
    });
  }

  const addContactBtn = document.getElementById("add-contact-btn");
  const addContactForm = document.getElementById("add-contact-form");
  if (addContactBtn && addContactForm) {
    addContactBtn.addEventListener("click", () => {
      addContactForm.classList.toggle("hidden");
    });
  }
});
