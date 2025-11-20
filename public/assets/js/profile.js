const avatarImage = document.getElementById("avatarImage");
// id di HTML = avatarInput → pakai ini
const avatarUpload = document.getElementById("avatarInput");
const taglineEl = document.getElementById("profileTagline");

const editProfileBtn = document.getElementById("editProfileBtn");

const form = document.getElementById("profileForm");
const taglineInput = document.getElementById("taglineInput");
const saveBtn = document.getElementById("saveProfileBtn");
const cancelBtn = document.getElementById("cancelEditBtn");

let uploadedImageURL = null;



document.body.addEventListener('change', function(event) {
    if (event.target && event.target.id === 'orgSelect') {
        const orgSelect = event.target;
        const selectedOrganizationId = orgSelect.value;
        const userSelect = document.getElementById('roleEmailSelect');
        const populateUserSelect = (users) => {
            // Kosongkan semua opsi yang ada, kecuali opsi default
            userSelect.innerHTML = '<option value="">-- Pilih User --</option>'; 

            // Tambahkan opsi user baru
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.email; // Menampilkan email sebagai teks opsi
                userSelect.appendChild(option);
            });
            console.log(`✅ ${users.length} user berhasil dimasukkan ke dalam select.`);
        };
        if (selectedOrganizationId !== "") {
                console.log('Mengambil data untuk ID Organisasi:', selectedOrganizationId);
                const url = `/viewUserRole/${selectedOrganizationId}`;
                fetch(url, {
                    method: 'GET', 
                    headers: {   
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data organisasi: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    populateUserSelect(data.users);
                    console.log('Data yang diterima:', data);
                    console.log('Daftar Users:', data.users);   
                })
                .catch(error => {
                    
                    console.error('Terjadi kesalahan AJAX:', error);
                });

            } else {
                console.log('⚠️ Tidak ada organisasi yang dipilih. Permintaan AJAX dibatalkan.');
            }
        }
});


function openForm() {

  taglineInput.value = taglineEl.textContent.trim();
  form.classList.remove("hidden");
  taglineInput.focus();
}

if (editProfileBtn) {
  editProfileBtn.addEventListener("click", openForm);
}

if (avatarUpload) {
  avatarUpload.addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
      uploadedImageURL = e.target.result;
      avatarImage.src = uploadedImageURL;
    };
    reader.readAsDataURL(file);
  });
}

if (saveBtn) {
    saveBtn.addEventListener("click", () => {
    taglineEl.textContent =
    taglineInput.value.trim() || "Tambahkan tagline singkat Anda di sini.";
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



// Dropdown Email
// ==== EMAIL LIST / DROPDOWN LOGIC ====

// "Database" sementara di memory
const emailList = [];

// DOM elements
const emailForm = document.getElementById("emailForm");
const emailInput = document.getElementById("emailInput");
const emailStatus = document.getElementById("emailStatus");
const roleEmailSelect = document.getElementById("roleEmailSelect");

function updateEmailDropdown() {
  if (!roleEmailSelect) return;

  // hapus semua option kecuali yang pertama ("Pilih email...")
  while (roleEmailSelect.options.length > 1) {
    roleEmailSelect.remove(1);
  }

  emailList.forEach(email => {
    const opt = document.createElement("option");
    opt.value = email;
    opt.textContent = email;
    roleEmailSelect.appendChild(opt);
  });
}

