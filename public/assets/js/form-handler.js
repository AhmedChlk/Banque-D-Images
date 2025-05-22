document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".tab");
  const loginForm = document.getElementById("form-login");
  const registerForm = document.getElementById("form-register");

  // Gestion des tabs
  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      if (tab.dataset.tab === "login") {
        loginForm.classList.remove("hidden");
        registerForm.classList.add("hidden");
      } else {
        loginForm.classList.add("hidden");
        registerForm.classList.remove("hidden");
      }
    });
  });

})
