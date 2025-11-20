// --- File: public/js/session-form.js ---

// HARUS ADA: Deklarasi variabel global di awal file
let candidateIndex = 0; 

function addCandidate() {
    const wrapper = document.getElementById('candidate-wrapper');

    // Gunakan candidateIndex saat ini untuk ID dan name array
    const index = candidateIndex;
    candidateIndex++; // Naikkan counter untuk kandidat berikutnya

    const candidateBlock = document.createElement('div');
    candidateBlock.classList.add('candidate-block', 'clearfix');
    candidateBlock.id = `candidate-${index}`;

    candidateBlock.innerHTML = `
        <button type="button" class="btn-delete" onclick="removeCandidate(${index})">❌ Hapus Kandidat</button>
        <h4>Kandidat #${index + 1}</h4>

        <div class="form-group">
            <label for="name-${index}">Nama Kandidat:</label>
            <input type="text" id="name-${index}" name="candidates[${index}][name]" required>
        </div>

        <div class="form-group">
            <label for="email-${index}">Email Kandidat (Opsional):</label>
            <input type="email" id="email-${index}" name="candidates[${index}][email]">
        </div>

        <div class="form-group">
            <label for="picture-${index}">Foto/Gambar:</label>
            <input type="file" id="picture-${index}" name="candidates[${index}][picture]" accept="image/*">
        </div>

        <div class="form-group">
            <label for="visi-${index}">Visi:</label>
            <textarea id="visi-${index}" name="candidates[${index}][visi]" required></textarea>
        </div>

        <div class="form-group">
            <label for="misi-${index}">Misi:</label>
            <textarea id="misi-${index}" name="candidates[${index}][misi]" required></textarea>
        </div>

        <hr>
    `;

    wrapper.appendChild(candidateBlock);
}

function removeCandidate(index) {
    const candidateBlock = document.getElementById(`candidate-${index}`);
    if (candidateBlock) {
        candidateBlock.remove();
    }
}

// INISIALISASI: Panggil fungsi sekali saat DOM selesai dimuat
window.addEventListener('DOMContentLoaded', () => {
    addCandidate();
});