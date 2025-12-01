<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

<!-- Bootstrap Bundle JS (termasuk Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- include libraries(jQuery, bootstrap) -->
<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="summernote-bs5.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>


<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
    crossorigin="anonymous"></script>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi CKEditor untuk textarea di modal tambah
        CKEDITOR.replace('konten');

        // Ambil daftar ID berita dari elemen HTML
        var beritaIds = document.getElementById('berita-ids').dataset.ids.split(',');

        // Inisialisasi CKEditor untuk setiap ID berita
        beritaIds.forEach(function(id) {
            CKEDITOR.replace('konten' + id);
        });
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            for (const instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Saat modal edit ditutup, buka kembali modal rincian berita
        const modalEditElements = document.querySelectorAll('.modal');
        modalEditElements.forEach((modal) => {
            modal.addEventListener('hidden.bs.modal', function() {
                if (modal.id.startsWith('beritaModalEdit')) {
                    const modalRincianBerita = new bootstrap.Modal(document.getElementById('rincianBeritaModal'));
                    modalRincianBerita.show();
                }
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Saat modal hapus ditutup, buka kembali modal rincian berita
        const modalEditElements = document.querySelectorAll('.modal');
        modalEditElements.forEach((modal) => {
            modal.addEventListener('hidden.bs.modal', function() {
                if (modal.id.startsWith('beritaModalHapus')) {
                    const modalRincianBerita = new bootstrap.Modal(document.getElementById('rincianBeritaModal'));
                    modalRincianBerita.show();
                }
            });
        });
    });
</script>

<script>
    function navigateToDashboard() {
        // Mencegah default behavior (reload) dan menggantikan URL halaman saat ini dengan halaman admin dashboard
        event.preventDefault();
        window.location.replace("{{ route('admin_dashboard.index') }}");
    }
</script>

<script>
    // Modal Nilai Admin
    document.querySelectorAll('.btn-delete-nilai').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;

            // Update action form
            const deleteForm = document.querySelector('#deleteFormNilai');
            deleteForm.action = `/penilaian/${id}`;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('deleteModalNilai')).show();
        });
    });

    // Modal DPL Admin
    document.querySelectorAll('.btn-delete-dpl').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;

            // Update action form
            const deleteForm = document.querySelector('#deleteFormDpl');
            deleteForm.action = `/admin_dpl/${id}`;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('deleteModalDpl')).show();
        });
    });

    // Modal Mitra Admin
    document.querySelectorAll('.btn-delete-mitra').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;

            // Update action form
            const deleteForm = document.querySelector('#deleteFormMitra');
            deleteForm.action = `/admin_mitra/${id}`;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('deleteModalMitra')).show();
        });
    });

    // Email Error DPL
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil nilai dari input hidden
        let hasEmailError = document.getElementById('hasEmailError').value;

        // Jika ada error, tampilkan modal
        if (hasEmailError === 'true') {
            let emailDplModal = new bootstrap.Modal(document.getElementById('emailDplExistModal'));
            emailDplModal.show();
        }
    });

    // Email Error DPL
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil nilai dari input hidden
        let hasNikError = document.getElementById('hasNikError').value;

        // Jika ada error, tampilkan modal
        if (hasNikError === 'true') {
            let nikDplModal = new bootstrap.Modal(document.getElementById('nikDplExistModal'));
            nikDplModal.show();
        }
    });

    // Modal Sukses
    document.addEventListener('DOMContentLoaded', function() {
        // Modal sukses untuk create
        let successCreateMessage = document.getElementById('successCreateMessage');
        if (successCreateMessage && successCreateMessage.value === 'true') {
            let successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        }

        // Modal sukses untuk update
        let successUpdateMessage = document.getElementById('successUpdateMessage');
        if (successUpdateMessage && successUpdateMessage.value === 'true') {
            let successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        }

        let successDeleteMessage = document.getElementById('successDeleteMessage');
        if (successDeleteMessage && successDeleteMessage.value === 'true') {
            let successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        }
    });
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<script>
    // Mengecek jika ada error NIM, users_id, atau pesan sukses menggunakan elemen tersembunyi
    window.onload = function() {
        var nimError = document.getElementById('nimError');
        var usersIdError = document.getElementById('usersIdError');
        var nimKoordinatorAnggotaError = document.getElementById('nimKoordinatorAnggotaError'); // Elemen untuk NIM Koordinator/Aangota error
        var successMessage = document.getElementById('successMessage');

        if (nimError && nimError.value === 'true') {
            var myModal = new bootstrap.Modal(document.getElementById('nimExistModal'));
            myModal.show();
        }

        if (usersIdError && usersIdError.value === 'true') {
            var usersIdModal = new bootstrap.Modal(document.getElementById('usersIdExistModal'));
            usersIdModal.show();
        }

        if (nimKoordinatorAnggotaError && nimKoordinatorAnggotaError.value === 'true') { // Cek NIM Koordinator/Anggota error
            var nimKoordinatorAnggotaModal = new bootstrap.Modal(document.getElementById('nimKoordinatorAnggotaExistModal'));
            nimKoordinatorAnggotaModal.show();
        }

        if (successMessage && successMessage.value === 'true') {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        }
    };
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const form = emailInput.closest('form');

        form.addEventListener('submit', function(event) {
            const emailValue = emailInput.value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@students\.amikom\.ac\.id$/;

            // Jika email tidak sesuai pattern, cegah pengiriman form dan tampilkan pesan
            if (!emailPattern.test(emailValue)) {
                event.preventDefault(); // Mencegah form disubmit
                alert('Email harus diakhiri dengan @students.amikom.ac.id');
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil semua elemen dengan class 'nav-link'
        const sidebarLinks = document.querySelectorAll(".sidebar .nav-link");

        // Dapatkan URL saat ini
        const currentUrl = window.location.href;

        // Iterasi melalui setiap link sidebar
        sidebarLinks.forEach(link => {
            // Cek apakah URL link cocok dengan URL saat ini
            if (link.href === currentUrl) {
                // Tambahkan class 'active' ke elemen link
                link.classList.add("active");

                // Tambahkan class 'menu-open' pada parent 'nav-item' (opsional untuk treeview)
                const parentItem = link.closest(".nav-item");
                if (parentItem) {
                    parentItem.classList.add("menu-open");
                }
            }
        });
    });
</script>

<script>
    // Inisialisasi tooltip Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Inisialisasi popover Bootstrap
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>

<script>
    function hitungChar() {
        // Ambil nilai input
        var text = document.getElementById("deskripsi").value;
        console.log("Input Text: ", text);
        var count = text.length;
        var limit = 500;

        // Tampilkan jumlah karakter
        document.getElementById("charCount").innerHTML = count;
        console.log("Character Count: ", count);

        // Periksa apakah melebihi batas
        if (count > limit) {
            // Tampilkan peringatan dan potong teks
            document.getElementById("charLimit").style.display = "block";
            document.getElementById("deskripsi").value = text.substring(0, limit);
            document.getElementById("charCount").innerHTML = limit; // Update count sesuai batas
        } else {
            // Sembunyikan peringatan
            document.getElementById("charLimit").style.display = "none";
        }
    }
</script>

<!-- Countdown Script -->
<script>
    // Konstanta waktu awal countdown (120 hari dari sekarang)
    const initialDays = 120;
    const initialTime = initialDays * 24 * 60 * 60 * 1000; // dalam milidetik

    // Variabel untuk menyimpan sisa waktu
    let remainingTime = initialTime;

    // Fungsi untuk memulai countdown
    function startCountdown() {
        const now = new Date().getTime();
        const endDateTime = now + remainingTime;
        localStorage.setItem('endDateTime', endDateTime);
        localStorage.setItem('countdownActive', true);

        // Aktifkan tombol Stop dan nonaktifkan Start
        document.getElementById('startButton').disabled = true;
        document.getElementById('stopButton').disabled = false;
        document.getElementById('resumeButton').disabled = true;
        document.getElementById('resetButton').disabled = false;

        // Jalankan fungsi update countdown
        updateCountdown(endDateTime);
    }

    // Fungsi untuk menghentikan countdown (pause)
    function stopCountdown() {
        localStorage.setItem('countdownActive', false);

        // Hentikan timer
        clearInterval(window.countdownInterval);

        // Hitung sisa waktu
        const now = new Date().getTime();
        const endDateTime = parseInt(localStorage.getItem('endDateTime'));
        remainingTime = endDateTime - now;

        // Atur tombol
        document.getElementById('startButton').disabled = true;
        document.getElementById('stopButton').disabled = true;
        document.getElementById('resumeButton').disabled = false;
    }

    // Fungsi untuk melanjutkan countdown
    function resumeCountdown() {
        localStorage.setItem('countdownActive', true);

        // Aktifkan tombol Stop dan nonaktifkan Resume
        document.getElementById('startButton').disabled = true;
        document.getElementById('stopButton').disabled = false;
        document.getElementById('resumeButton').disabled = true;

        // Perbarui waktu akhir
        const now = new Date().getTime();
        const endDateTime = now + remainingTime;
        localStorage.setItem('endDateTime', endDateTime);

        // Jalankan fungsi update countdown
        updateCountdown(endDateTime);
    }

    // Fungsi untuk mereset countdown
    function resetCountdown() {
        localStorage.removeItem('endDateTime');
        localStorage.setItem('countdownActive', false);

        // Hentikan timer dan set ulang tampilan
        clearInterval(window.countdownInterval);
        document.getElementById('countdown').innerHTML = '120d 0h 0m 0s';
        remainingTime = initialTime;

        // Set ulang tombol
        document.getElementById('startButton').disabled = false;
        document.getElementById('stopButton').disabled = true;
        document.getElementById('resumeButton').disabled = true;
        document.getElementById('resetButton').disabled = true;
    }

    // Fungsi untuk memperbarui countdown
    function updateCountdown(endDateTime) {
        window.countdownInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endDateTime - now;

            if (distance < 0) {
                clearInterval(window.countdownInterval);
                document.getElementById('countdown').innerHTML = 'EXPIRED';
                document.getElementById('startButton').disabled = false;
                document.getElementById('stopButton').disabled = true;
                document.getElementById('resumeButton').disabled = true;
                document.getElementById('resetButton').disabled = false;
                return;
            }

            // Hitung hari, jam, menit, dan detik
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasilnya dalam elemen countdown
            document.getElementById('countdown').innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }, 1000);
    }

    // Periksa status countdown saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const endDateTime = localStorage.getItem('endDateTime');
        const countdownActive = localStorage.getItem('countdownActive') === 'true';

        if (countdownActive && endDateTime) {
            document.getElementById('startButton').disabled = true;
            document.getElementById('stopButton').disabled = false;
            document.getElementById('resumeButton').disabled = true;
            document.getElementById('resetButton').disabled = false;
            updateCountdown(parseInt(endDateTime));
        } else if (!countdownActive && endDateTime) {
            const now = new Date().getTime();
            const distance = parseInt(endDateTime) - now;
            if (distance > 0) {
                remainingTime = distance;
                document.getElementById('startButton').disabled = true;
                document.getElementById('stopButton').disabled = true;
                document.getElementById('resumeButton').disabled = false;
                document.getElementById('resetButton').disabled = false;
            }
        } else {
            document.getElementById('resetButton').disabled = true;
        }

        // Tambahkan event listener pada tombol
        document.getElementById('startButton').addEventListener('click', startCountdown);
        document.getElementById('stopButton').addEventListener('click', stopCountdown);
        document.getElementById('resumeButton').addEventListener('click', resumeCountdown);
        document.getElementById('resetButton').addEventListener('click', resetCountdown);
    });
</script>