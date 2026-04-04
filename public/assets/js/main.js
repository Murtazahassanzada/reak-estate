/*document.querySelector(".logout-btn").addEventListener("click", function () {
  if (confirm("Are you sure you want to logout?")) {
    window.location.href = "login.html";
  }
});*/
document.addEventListener("DOMContentLoaded", function () {

  /* =========================
     MOBILE THREE-DOTS MENU
  ========================= */

  const menuDots = document.querySelector(".menu-dots");
  const mainMenu = document.querySelector("#mainMenu");

  if (menuDots && mainMenu) {
    menuDots.addEventListener("click", function () {
      mainMenu.classList.toggle("show");
    });
  }

  /* =========================
     SEARCH BUTTON (MOBILE UX)
     ✅ اصلاح شده: حذف alert و اجازه submit به فرم
  ========================= */

  // اگر نیاز به رفتار موبایل داری می‌توانی event اضافی اضافه کنی
  // اما فعلاً چیزی حذف شد تا فرم واقعی submit شود
  // const searchBtn = document.querySelector(".hero-search button");
  // if (searchBtn) {
  //   searchBtn.addEventListener("click", function () {
  //     alert("Search functionality will be connected to backend later.");
  //   });
  // }

  /* =========================
     ACTIVE MENU LINK
  ========================= */

  const navLinks = document.querySelectorAll(".navbar .nav-link");

  navLinks.forEach(link => {
    link.addEventListener("click", function () {
      navLinks.forEach(l => l.classList.remove("active"));
      this.classList.add("active");
    });
  });

});
