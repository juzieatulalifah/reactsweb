function updateWordCount(textarea) {
	const maxLength = 400;
	const currentLength = textarea.value.length;
	const wordCountElement = document.getElementById('wordCount');
	wordCountElement.textContent = `${currentLength}/${maxLength} characters`;
}

document.addEventListener("DOMContentLoaded", function() {
    const formFields = document.querySelectorAll("fieldset");
    const nextButtons = document.querySelectorAll("input.next");
    const previousButtons = document.querySelectorAll("input.previous");
    const progressBarItems = document.querySelectorAll("#progressbar li");
    
    let currentStep = 0; // Menyimpan langkah aktif

    // Fungsi untuk memvalidasi setiap input di fieldset
    function validateFields(fieldset) {
        let isValid = true;
        const inputs = fieldset.querySelectorAll("input[required], textarea[required]");

        inputs.forEach(input => {
            input.classList.remove("error");
            const errorMessage = input.nextElementSibling;

            if (!input.value.trim()) {
                isValid = false;
                input.classList.add("error");
                if (errorMessage) errorMessage.textContent = "Field ini wajib diisi!";
            } else {
                if (errorMessage) errorMessage.textContent = "";
            }
        });

        return isValid;
    }

    // Fungsi untuk memperbarui tombol Next
    function updateNextButtonState(fieldset) {
        const nextButton = fieldset.querySelector("input.next");
        if (nextButton) {
            const isValid = validateFields(fieldset);
            nextButton.disabled = !isValid;
        }
    }

    // Fungsi untuk memperbarui progres bar
    function updateProgressBar() {
        progressBarItems.forEach((item, index) => {
            item.classList.remove("active");

            if (index < currentStep) {
                item.classList.add("completed");
            } else if (index === currentStep) {
                item.classList.add("active");
            }
        });
    }

    // Memvalidasi dan meng-update tombol Next ketika ada input yang berubah
    formFields.forEach(fieldset => {
        const inputs = fieldset.querySelectorAll("input[required], textarea[required]");
        
        inputs.forEach(input => {
            input.addEventListener("input", () => {
                updateNextButtonState(fieldset);
            });

            input.addEventListener("focus", () => {
                updateNextButtonState(fieldset);
            });
        });
    });

    // Menangani tombol Next untuk lanjut ke fieldset berikutnya
    nextButtons.forEach(button => {
        button.addEventListener("click", function() {
            const currentFieldset = this.closest("fieldset");
            const nextFieldset = currentFieldset.nextElementSibling;

            if (nextFieldset) {
                // Cek validasi di fieldset yang aktif sebelum lanjut
                const isValid = validateFields(currentFieldset);
                if (isValid) {
                    // Hanya lanjutkan ke fieldset berikutnya jika valid
                    currentFieldset.style.display = "none";
                    nextFieldset.style.display = "block";
                    currentStep++; // Perbarui langkah aktif
                    updateProgressBar(); // Perbarui progres bar
                    updateNextButtonState(nextFieldset); // Cek tombol Next pada fieldset berikutnya
                }
            }
        });
    });

    // Menangani tombol Previous untuk kembali ke fieldset sebelumnya
    previousButtons.forEach(button => {
        button.addEventListener("click", function() {
            const currentFieldset = this.closest("fieldset");
            const previousFieldset = currentFieldset.previousElementSibling;
            if (previousFieldset) {
                currentFieldset.style.display = "none";
                previousFieldset.style.display = "block";
                currentStep--; // Kurangi langkah aktif
                updateProgressBar(); // Perbarui progres bar
            }
        });
    });

    // Menampilkan fieldset pertama dan menyembunyikan yang lainnya saat halaman pertama kali dimuat
    formFields.forEach((fieldset, index) => {
        fieldset.style.display = index === 0 ? "block" : "none";
    });

    // Inisialisasi progres bar pada saat pertama kali halaman dimuat
    updateProgressBar();
});
