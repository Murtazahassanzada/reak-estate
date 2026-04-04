document.addEventListener("DOMContentLoaded", function () {

  const data = JSON.parse(localStorage.getItem("viewProperty"));

  if (!data) {
    alert("No property selected");
    window.location.href = "User.html";
    return;
  }

  document.getElementById("propertyName").innerText = data.name;
  document.getElementById("propertyType").innerText = data.type;
  document.getElementById("propertyLocation").innerText = data.location;
  document.getElementById("propertyPrice").innerText = data.price;

});
