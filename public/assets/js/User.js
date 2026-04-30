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
                <button class="btn btn-sm btn-danger" onclick="removeFromCompare(${id})">✕</button>
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
// GO TO COMPARE PAGE
// ==========================
function goToCompare() {
    const query = compareList.join(',');
    window.location.href = `/compare-properties?ids=${query}`;
}

// ==========================
// TOAST SYSTEM
// ==========================
function showToast(message, type = "info") {
    let bg = "bg-primary";
    if (type === "error") bg = "bg-danger";
    if (type === "warning") bg = "bg-warning";
    if (type === "success") bg = "bg-success";

    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-white ${bg} border-0 show position-fixed bottom-0 end-0 m-3`;
    toast.style.zIndex = 9999;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.minWidth = '250px';
    toast.style.borderRadius = '8px';

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"></button>
        </div>
    `;

    document.body.appendChild(toast);
    const closeBtn = toast.querySelector('.btn-close');
    if (closeBtn) closeBtn.addEventListener('click', () => toast.remove());
    setTimeout(() => { if (toast && toast.remove) toast.remove(); }, 3000);
}

// ==========================
// ✅ FIX: جلوگیری از redirect در مودال‌ها
// ==========================
document.addEventListener("DOMContentLoaded", function() {
    
    // ===== 1. جلوگیری از submit عادی در تمام فرم‌های داخل مودال =====
    const allModals = document.querySelectorAll('.modal');
    
    allModals.forEach(modal => {
        const forms = modal.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const formData = new FormData(this);
                const actionUrl = this.action;
                const method = this.method || 'POST';
                const submitBtn = this.querySelector('button[type="submit"], .btn-save, .btn-publish, .btn-danger');
                const originalText = submitBtn ? submitBtn.innerHTML : 'Saving...';
                
                // تغییر متن دکمه
                if (submitBtn) {
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
                    submitBtn.disabled = true;
                }
                
                // ارسال درخواست AJAX
                fetch(actionUrl, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message || 'Operation successful!', 'success');
                        // بستن مودال
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) bsModal.hide();
                        // رفرش صفحه بعد از 1 ثانیه
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Something went wrong!', 'error');
                        if (submitBtn) {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Network error! Please try again.', 'error');
                    if (submitBtn) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
            });
        });
    });
    
    // ===== 2. دکمه‌های Add Property و Edit =====
    const addPropertyBtn = document.querySelector('[data-bs-target="#userAddPropertyModal"]');
    if (addPropertyBtn) {
        addPropertyBtn.addEventListener('click', function(e) {
            // فقط مودال باز شود، هیچ redirect ای نیست
            const modalEl = document.getElementById('userAddPropertyModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    }
    
    // ===== 3. دکمه‌های Edit =====
    const editBtns = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target*="editUserProperty"]');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const modalEl = document.querySelector(targetId);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    });
    
    // ===== 4. دکمه‌های Delete =====
    const deleteBtns = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target*="deleteUserProperty"]');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const modalEl = document.querySelector(targetId);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    });
});

// ==========================
// TABS (ALL / FAVORITES) - FIXED
// ==========================
document.addEventListener("DOMContentLoaded", function () {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const favoritesSection = document.getElementById('favoritesSection');
    const allPropertiesSection = document.getElementById('allPropertiesSection');
    
    if (!favoritesSection || !allPropertiesSection) return;
    
    function showAllProperties() {
        favoritesSection.style.display = 'none';
        allPropertiesSection.style.display = 'block';
    }
    
    function showFavoritesOnly() {
        favoritesSection.style.display = 'block';
        allPropertiesSection.style.display = 'none';
    }
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            if (this.dataset.tab === 'all') {
                showAllProperties();
            } else if (this.dataset.tab === 'fav') {
                showFavoritesOnly();
            }
        });
    });
    
    const activeTab = document.querySelector('.tab-btn.active');
    if (activeTab && activeTab.dataset.tab === 'fav') {
        showFavoritesOnly();
    } else {
        showAllProperties();
    }
});

// ==========================
// LOGOUT MODAL
// ==========================
document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("userLogoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (e) {
            e.preventDefault();
            const modalElement = document.getElementById("userLogoutModal");
            if (modalElement) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.show();
            }
        });
    }
});

// ==========================
// FAVORITE TOGGLE - AJAX
// ==========================
document.addEventListener("DOMContentLoaded", function() {
    const favoriteForms = document.querySelectorAll('.favorite-form');
    
    favoriteForms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const button = this.querySelector('button');
            const originalText = button ? button.innerHTML : '';
            
            if (button) {
                button.innerHTML = '⏳ Processing...';
                button.disabled = true;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        showToast(result.message || 'Favorite updated!', 'success');
                        setTimeout(() => window.location.reload(), 800);
                    } else {
                        showToast(result.message || 'Error updating favorite', 'error');
                        if (button) {
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }
                    }
                } else {
                    showToast('Error updating favorite', 'error');
                    if (button) {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Network error. Please try again.', 'error');
                if (button) {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            }
        });
    });
});

// ==========================
// CAROUSEL REINITIALIZATION
// ==========================
function reinitializeCarousels() {
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
            new bootstrap.Carousel(carousel, { ride: false, interval: 3000 });
        }
    });
}