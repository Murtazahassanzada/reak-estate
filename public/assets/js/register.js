document.addEventListener("DOMContentLoaded", function () {

  const form = document.getElementById("registerForm");

  if (!form) return;

  form.addEventListener("submit", function () {
    console.log("Register form submitted...");
    // فرم مستقیم به Laravel می‌رود
  });

});