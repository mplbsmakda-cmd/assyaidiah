# Blueprint Proyek

## Ikhtisar

Proyek ini adalah sistem informasi untuk mengelola data santri dan wali santri di Pondok Pesantren Assyaidiah. Aplikasi ini dibangun dengan Laravel dan dirancang untuk menyediakan antarmuka yang bersih dan fungsional bagi administrator, serta halaman pendaftaran publik yang modern dan mudah digunakan.

**Perubahan Arsitektur Utama:** Aplikasi ini sekarang menggunakan **Google Firestore** sebagai database utamanya, beralih dari model database relasional tradisional. Semua interaksi data (CRUD) ditangani melalui Firebase SDK, bukan Eloquent ORM.

## Gaya, Desain, dan Fitur yang Diimplementasikan

### Halaman Publik
*   **Tata Letak (Layout) Konsisten**: Menggunakan `layouts/public.blade.php` untuk tampilan yang seragam di semua halaman publik.
    *   Navigasi modern dengan efek *blur* (`backdrop-blur-md`) dan bayangan lembut.
    *   Latar belakang dengan pola SVG subtil untuk memberikan tekstur.
    *   *Footer* informatif dengan detail kontak.
*   **Halaman Utama (`welcome.blade.php`)**:
    *   *Header* dengan gradien (`hero-gradient`) dan ajakan untuk bertindak (CTA) yang menonjol.
    *   Bagian "Program Unggulan" menggunakan kartu dengan ikon dari Font Awesome dan efek *hover*.
    *   Galeri gambar dengan efek *hover* yang memperbesar gambar.
*   **Halaman Pendaftaran (`students/register.blade.php`)**:
    *   Formulir pendaftaran yang bersih dan modern dalam tata letak kartu dengan bayangan.
    *   Menggunakan ikon dari Font Awesome di setiap kolom input untuk kejelasan.
    *   Umpan balik validasi yang jelas dan tombol CTA dengan efek transisi.

### Dasbor Admin
*   **Tata Letak (Layout) Admin**: Menggunakan `layouts/app.blade.php` untuk area admin yang terlindungi.
*   **Halaman Dasbor (`dashboard.blade.php`)**:
    *   Menampilkan kartu statistik (Total Santri, Wali, Santri Aktif, Lulus) dengan desain premium.
    *   Setiap kartu memiliki ikon berwarna, bayangan, dan efek *hover*.
    *   Grafik batang (`Chart.js`) untuk memvisualisasikan perbandingan jumlah santri dan wali.
    *   Daftar "Santri Terbaru" dengan foto profil atau inisial.

### Fungsionalitas Backend
*   **Penyimpanan File**: Menggunakan **Firebase Storage** untuk mengunggah dan mengelola foto santri.
*   **Database**: Menggunakan **Firebase Firestore** untuk semua operasi data (CRUD).

## Rencana Perubahan Saat Ini: Migrasi Penuh ke Firebase Firestore

*   **Tujuan**: Mengubah arsitektur aplikasi secara fundamental untuk menggunakan Firebase Firestore sebagai database utama, menggantikan model relasional (MySQL/PostgreSQL) dan Eloquent ORM.

*   **Langkah-langkah**:
    1.  **Hapus Konfigurasi Database SQL**: Memperbarui `render.yaml` untuk menghapus definisi database PostgreSQL dan variabel lingkungan terkait (`DB_HOST`, `DB_DATABASE`, dll.).
    2.  **Perluas `FirebaseService`**: Menambahkan metode baru ke `app/Services/FirebaseService.php` untuk menangani operasi CRUD (Create, Read, Update, Delete) di Firestore. Ini akan menjadi satu-satunya titik interaksi dengan database.
    3.  **Refactor Controller**: Mengubah *controller* (dimulai dengan `StudentController` dan `WaliSantriController`) untuk menggunakan `FirebaseService` yang baru. Semua panggilan ke model Eloquent (seperti `Santri::all()`, `WaliSantri::create()`) akan diganti dengan panggilan ke layanan Firebase.
    4.  **Hapus Kode Usang**: Menghapus file migrasi database dari direktori `database/migrations` karena tidak lagi relevan.
    5.  **Perbarui Variabel Lingkungan**: Menambahkan variabel `FIREBASE_PROJECT_ID` dan `FIREBASE_CREDENTIALS` ke `render.yaml` untuk memastikan koneksi ke Firebase saat di-deploy.
