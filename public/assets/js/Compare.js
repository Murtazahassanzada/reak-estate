document.addEventListener("DOMContentLoaded", function () {

  const compareIds = JSON.parse(localStorage.getItem("compareList")) || [];
  const container = document.getElementById("compareContainer");

  if (!container) return;

  if (compareIds.length < 2) {
    container.innerHTML = `
      <div class="col-12 text-center text-danger">
        <p>${window.trans.need_two}</p>
      </div>
    `;
    return;
  }

  fetch("/compare/data", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    },
    body: JSON.stringify({ ids: compareIds })
  })
  .then(res => res.json())
  .then(data => {

    container.innerHTML = "";

    data.forEach(item => {

      const card = `
        <div class="col-md-6">
          <div class="card compare-card h-100 text-center">

            <div class="card-body">
              <h5 class="fw-bold">${item.name}</h5>

              <p><strong>${window.trans.type}:</strong> ${item.type}</p>

              <p><strong>${window.trans.price}:</strong> $${item.price}</p>

            </div>

          </div>
        </div>
      `;

      container.insertAdjacentHTML("beforeend", card);
    });

    localStorage.removeItem("compareList");

  })
  .catch(() => {
    container.innerHTML = `
      <div class="col-12 text-center text-danger">
        <p>${window.trans.error}</p>
      </div>
    `;
  });

});