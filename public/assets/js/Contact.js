document.getElementById("contactForm").addEventListener("submit", function(e) {
  e.preventDefault();

  document.getElementById("successMsg").classList.remove("d-none");

  this.reset();
});
