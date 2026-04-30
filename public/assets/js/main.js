document.addEventListener("DOMContentLoaded", function () {

    // 🔔 dropdown toggle
    let bell = document.getElementById("bellBtn");
    let dropdown = document.getElementById("notifDropdown");

    if(bell && dropdown){
        bell.addEventListener("click", function(e){
            e.preventDefault();
            dropdown.classList.toggle("d-none");
        });
    }

    // 📱 mobile menu
    const menuDots = document.querySelector(".menu-dots");
    const mainMenu = document.querySelector("#mainMenu");

    if (menuDots && mainMenu) {
        menuDots.addEventListener("click", function () {
            mainMenu.classList.toggle("show");
        });
    }

    // active menu
    const navLinks = document.querySelectorAll(".navbar .nav-link");

    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });

});

// ✅ mark all read
document.addEventListener("click", function(e){

    if(e.target.id === "markAllBtn"){

        fetch('/notifications/read-all', {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(() => {

            let badge = document.getElementById('notifCount');

            if(badge){
                badge.innerText = 0;
            }

        });

    }

});