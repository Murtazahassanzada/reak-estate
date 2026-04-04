document.addEventListener("DOMContentLoaded", function () {

  const loginForm = document.getElementById("loginForm");

  if (!loginForm) return;

  loginForm.addEventListener("submit", function () {
    // ❌ preventDefault را حذف کردیم
    // ✅ حالا فرم به Laravel ارسال می‌شود
  });

});

    // Admin credentials (frontend demo)
    /*if (username === "admin" && password === "12345") {

      // login state
      localStorage.setItem("isLoggedIn", "true");
      localStorage.setItem("userRole", "admin");

      // ✅ redirect ONLY to admin
      window.location.href = "Admin.html";

    } else {
      alert("Invalid username or password");
    }*/
/*if (username === "admin" && password === "1234") {
  localStorage.setItem("isLoggedIn", "true");
  localStorage.setItem("role", "admin");
  window.location.href = "/admin";
}*/
/*else {
  localStorage.setItem("isLoggedIn", "true");
  localStorage.setItem("role", "user");
  window.location.href = "/user";
}*/


