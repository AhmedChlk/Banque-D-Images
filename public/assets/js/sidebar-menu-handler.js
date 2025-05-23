document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.getElementById("menu-toggle");
  const menuOptions = document.getElementById("menu-options");

  if (menuToggle && menuOptions) {
    menuToggle.addEventListener("click", () => {
      menuOptions.classList.toggle("hidden");
    });
  }
});
