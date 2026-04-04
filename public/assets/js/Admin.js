// بررسی دسترسی ادمین (فرانت‌اند)
//if (localStorage.getItem("role") !== "admin") {
 // window.location.href = "dasboard.html";
//}
// Admin page JS (future use)
//console.log("Admin panel loaded");
document.addEventListener("DOMContentLoaded", function () {

  const logoutBtn = document.getElementById("logoutBtn");

  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();
      new bootstrap.Modal(
        document.getElementById("logoutModal")
      ).show();
    });
  }

});

