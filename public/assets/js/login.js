document.addEventListener("DOMContentLoaded", function () {

  const loginForm = document.getElementById("loginForm");

  if (!loginForm) return;

  loginForm.addEventListener("submit", function () {
    console.log("Form submitted...");
    // ❌ preventDefault نداریم → فرم به Laravel می‌رود
  });

});
