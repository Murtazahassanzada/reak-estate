document.addEventListener("DOMContentLoaded", function () {

  const cards = document.querySelectorAll(".stat-card");

  if (!cards.length) return;

  cards.forEach(card => {

    card.addEventListener("click", function () {

      // گرفتن متن امن
      const value = this.querySelector("h2")?.innerText || "";
      const label = this.querySelector("p")?.innerText || "Report";

      // به جای alert → UX بهتر
      showToast(label + ": " + value);

    });

  });

});


// ✅ Toast حرفه‌ای
function showToast(message) {

  let toast = document.createElement("div");
  toast.className = "custom-toast";
  toast.innerText = message;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("show");
  }, 100);

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}