// ==========================
// STATE MANAGEMENT
// ==========================
let compareList = [];
const MAX_COMPARE = 2;

// ==========================
// COMPARE SYSTEM (PRODUCTION)
// ==========================
function addToCompare(id) {

    id = parseInt(id);

    // جلوگیری از تکرار
    if (compareList.includes(id)) {
        showToast("Already selected", "warning");
        return;
    }

    // محدودیت
    if (compareList.length >= MAX_COMPARE) {
        showToast("Only 2 properties allowed", "error");
        return;
    }

    compareList.push(id);

    updateCompareUI();
    openCompareModal();
}

// ==========================
// UPDATE MODAL UI
// ==========================
function updateCompareUI() {

    const container = document.getElementById("compareListContainer");
    const btn = document.getElementById("compareNowBtn");

    if (!container || !btn) return;

    container.innerHTML = "";

    compareList.forEach(id => {
        container.innerHTML += `
            <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                <span>Property #${id}</span>

                <button class="btn btn-sm btn-danger"
                        onclick="removeFromCompare(${id})">
                    ✕
                </button>
            </div>
        `;
    });

    btn.disabled = compareList.length !== 2;

    if (compareList.length === 2) {
        btn.onclick = goToCompare;
    }
}

// ==========================
// REMOVE ITEM
// ==========================
function removeFromCompare(id) {

    compareList = compareList.filter(item => item !== id);

    updateCompareUI();
}

// ==========================
// OPEN MODAL
// ==========================
function openCompareModal() {
    const modalEl = document.getElementById('compareModal');
    if (!modalEl) return;

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

// ==========================
// GO TO COMPARE PAGE (AJAX READY)
// ==========================
function goToCompare() {

    const query = compareList.join(',');

    // نسخه ساده (فعلاً)
   window.location.href = `/compare-properties?compare[]=${compareList.join("&compare[]=")}`;
}

// ==========================
// TOAST SYSTEM (PRODUCTION READY)
// ==========================
function showToast(message, type = "info") {

    let bg = "bg-primary";

    if (type === "error") bg = "bg-danger";
    if (type === "warning") bg = "bg-warning";
    if (type === "success") bg = "bg-success";

    const toast = document.createElement("div");

    toast.className = `toast align-items-center text-white ${bg} border-0 show position-fixed bottom-0 end-0 m-3`;
    toast.style.zIndex = 9999;

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"></button>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2500);
}

// ==========================
// LOGOUT MODAL
// ==========================
document.addEventListener("DOMContentLoaded", function () {

    const logoutBtn = document.getElementById("userLogoutBtn");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function () {

            const modal = bootstrap.Modal.getOrCreateInstance(
                document.getElementById("userLogoutModal")
            );

            modal.show();
        });
    }
});
// ======================
// TAB SYSTEM: ALL / FAVORITES
// No HTML changes required – works with your current structure
// ======================

// ======================
// TAB SYSTEM: ALL / FAVORITES (FIXED)
// ======================
document.addEventListener('DOMContentLoaded', function () {

    // TAB BUTTONS
    const allTab = document.querySelector('[data-tab="all"]');
    const favTab = document.querySelector('[data-tab="fav"]');

    // SECTIONS
    const favoritesSection = document.querySelector('.favorites-section');
    const propertiesSection = document.querySelector('.properties-wrapper');

    // STOP IF NOT FOUND
    if (!allTab || !favTab || !propertiesSection) {
        return;
    }

    // =========================
    // DEFAULT STATE
    // =========================
    propertiesSection.style.display = '';

    if (favoritesSection) {
        favoritesSection.style.display = 'none';
    }

    // =========================
    // ALL TAB
    // =========================
    allTab.addEventListener('click', function (e) {

        e.preventDefault();

        // active classes
        allTab.classList.add('active');
        favTab.classList.remove('active');

        // show properties
        propertiesSection.style.display = '';

        // hide favorites
        if (favoritesSection) {
            favoritesSection.style.display = 'none';
        }

    });

    // =========================
    // FAVORITES TAB
    // =========================
    favTab.addEventListener('click', function (e) {

        e.preventDefault();

        // active classes
        favTab.classList.add('active');
        allTab.classList.remove('active');

        // hide properties
        propertiesSection.style.display = 'none';

        // show favorites
        if (favoritesSection) {
            favoritesSection.style.display = '';
        }

    });

});
