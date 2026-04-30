document.addEventListener("DOMContentLoaded", function () {

  const form = document.getElementById("contactForm");

  if (form) {
    form.addEventListener("submit", function () {

      // loading button
      const btn = form.querySelector("button");
      btn.classList.add("btn-loading");
      btn.innerText = "Sending...";

      // ❗ مهم: preventDefault نداشته باش
      // چون می‌خواهیم فرم واقعاً submit شود

    });
  }

});
