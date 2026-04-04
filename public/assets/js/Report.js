// ===============================
// REPORT PAGE - FRONTEND JS
// REMS ADMIN PANEL
// ===============================

document.addEventListener("DOMContentLoaded", function () {

  // Card click demo
  document.querySelectorAll(".stat-card").forEach(card => {
    card.addEventListener("click", function () {
      const title = this.querySelector("h5").innerText;
      alert(title + " report clicked (Demo)");
    });
  });

});
