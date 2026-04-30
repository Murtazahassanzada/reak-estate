document.addEventListener("DOMContentLoaded", function () {

  const logoutModal = document.getElementById("logoutModal");

  if (logoutModal) {
    logoutModal.addEventListener('hidden.bs.modal', function () {

      // حذف بک‌دراپ تار
      document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

      // ریست body
      document.body.classList.remove('modal-open');
      document.body.style = "";

    });
  }

});
