// ===============================
// USERS MANAGEMENT - FRONTEND JS
// REMS Admin Panel
// ===============================

document.addEventListener("DOMContentLoaded", function () {

  // Edit user buttons
  document.querySelectorAll(".btn-warning").forEach(btn => {
    btn.addEventListener("click", function () {
      new bootstrap.Modal(
        document.getElementById("editUserModal")
      ).show();
    });
  });

  // Delete user buttons
  document.querySelectorAll(".btn-danger").forEach(btn => {
    btn.addEventListener("click", function () {
      new bootstrap.Modal(
        document.getElementById("deleteUserModal")
      ).show();
    });
  });

});
