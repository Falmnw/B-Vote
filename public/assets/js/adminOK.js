

// ==== TAB MENU ADMIN ====
const tabButtons = document.querySelectorAll(".admin-tab");
const tabPanels = document.querySelectorAll(".admin-tab-panel");

tabButtons.forEach(btn => {
  btn.addEventListener("click", () => {
    const targetId = btn.getAttribute("data-target");

    // reset semua tab
    tabButtons.forEach(b => b.classList.remove("active"));
    tabPanels.forEach(panel => panel.classList.remove("active"));

    // aktifkan tab & panel yg dipilih
    btn.classList.add("active");
    document.getElementById(targetId).classList.add("active");
  });
});