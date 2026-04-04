document.addEventListener("DOMContentLoaded", function () {

  // Delete buttons
  document.querySelectorAll(".delete").forEach(btn => {
    btn.addEventListener("click", () => {
      if (confirm("Are you sure you want to delete this property?")) {
        alert("Property deleted (Demo)");
      }
    });
  });

  // Add Property Modal
  const addBtn = document.getElementById("addPropertyBtn");
  const addModal = new bootstrap.Modal(
    document.getElementById("addPropertyModal")
  );

  addBtn.addEventListener("click", function () {
    addModal.show();
  });

});

// Edit Property
function openEditModal() {
  new bootstrap.Modal(document.getElementById("editPropertyModal")).show();
}

// Delete Property (Modal version if needed later)
function openDeleteModal() {
  new bootstrap.Modal(document.getElementById("deletePropertyModal")).show();
}
