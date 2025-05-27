document.addEventListener("DOMContentLoaded", () => {
  const toast = document.getElementById("success-toast");
  if (toast) {
    setTimeout(() => {
      toast.style.opacity = "0";
      toast.style.transform = "translateY(-20px)";
      setTimeout(() => toast.remove(), 500);
    }, 3000); // 3 secondes avant disparition
  }
});
