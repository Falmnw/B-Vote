const avatarImage = document.getElementById("avatarImage");
// id di HTML = avatarInput → pakai ini
const avatarUpload = document.getElementById("avatarInput");
const taglineEl = document.getElementById("profileTagline");

const editProfileBtn = document.getElementById("editProfileBtn");

const form = document.getElementById("profileForm");
const taglineInput = document.getElementById("taglineInput");
const saveBtn = document.getElementById("saveProfileBtn");
const cancelBtn = document.getElementById("cancelEditBtn");

let uploadedImageURL = null; // untuk simpan URL gambar sementara

/* === OPEN FORM === */
function openForm() {
  // isi input dengan tagline yang sekarang
  taglineInput.value = taglineEl.textContent.trim();
  form.classList.remove("hidden");
  taglineInput.focus();
}

if (editProfileBtn) {
  editProfileBtn.addEventListener("click", openForm);
}

/* === HANDLE UPLOAD FOTO === */
if (avatarUpload) {
  avatarUpload.addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
      uploadedImageURL = e.target.result;
      avatarImage.src = uploadedImageURL; // preview langsung
    };
    reader.readAsDataURL(file);
  });
}

/* === SIMPAN === */
if (saveBtn) {
  saveBtn.addEventListener("click", () => {
    taglineEl.textContent =
      taglineInput.value.trim() || "Tambahkan tagline singkat Anda di sini.";

    // avatar sudah berubah otomatis lewat preview di atas
    form.classList.add("hidden");
  });
}

/* === BATAL === */
if (cancelBtn) {
  cancelBtn.addEventListener("click", () => {
    form.classList.add("hidden");
  });
}





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