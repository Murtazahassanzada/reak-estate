document.addEventListener("DOMContentLoaded", function () {

  const compareIds = JSON.parse(localStorage.getItem("compareList")) || [];
  const container = document.getElementById("compareContainer");

  // اگر کمتر از 2 آیتم بود
  if (compareIds.length < 2) {
    container.innerHTML = `
      <div class="col-12 text-center text-danger">
        <p>Please select two properties to compare.</p>
      </div>
    `;
    return;
  }

  // 🔥 AJAX → گرفتن دیتا از لاراول
  fetch("/compare/data", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    body: JSON.stringify({
      ids: compareIds
    })
  })
  .then(res => res.json())
  .then(data => {

    container.innerHTML = "";

    data.forEach(item => {
      container.innerHTML += `
        <div class="col-md-6">
          <div class="card compare-card h-100">
            <div class="card-body text-center">
              <h5 class="card-title">${item.name}</h5>
              <p><strong>Type:</strong> ${item.type}</p>
              <p><strong>Price:</strong> $${item.price}</p>
            </div>
          </div>
        </div>
      `;
    });

    // پاک کردن compare بعد از نمایش
    localStorage.removeItem("compareList");

  })
  .catch(error => {
    console.error("Compare error:", error);
    container.innerHTML = `
      <div class="col-12 text-center text-danger">
        <p>Error loading comparison data.</p>
      </div>
    `;
  });

});