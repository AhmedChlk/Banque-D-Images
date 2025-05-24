document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".tab");
  const loginForm = document.getElementById("form-login");
  const registerForm = document.getElementById("form-register");

  function activateTab(tabName) {
    tabs.forEach(t => t.classList.remove("active"));
    if (tabName === "login") {
      tabs[0].classList.add("active");
      loginForm.classList.remove("hidden");
      registerForm.classList.add("hidden");
    } else {
      tabs[1].classList.add("active");
      loginForm.classList.add("hidden");
      registerForm.classList.remove("hidden");
    }
  }

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      activateTab(tab.dataset.tab);
    });
  });

  if (typeof initialTab !== "undefined") {
    activateTab(initialTab);
  }
});
