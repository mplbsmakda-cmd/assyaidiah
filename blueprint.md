# Blueprint Proyek

## Ikhtisar

Proyek ini adalah sistem informasi untuk mengelola data santri dan wali santri di Pondok Pesantren Assyaidiah. Aplikasi ini dibangun dengan Laravel dan dirancang untuk menyediakan antarmuka yang bersih dan fungsional bagi administrator, serta halaman pendaftaran publik yang modern dan mudah digunakan.

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
*   **Pendaftaran Publik**: `StudentController` memiliki metode `createPublic` dan `storePublic` untuk menangani pendaftaran dari halaman publik.
*   **NIS Otomatis**: Nomor Induk Santri (NIS) dibuat secara otomatis saat pendaftaran publik.
*   **Manajemen Data**: Fungsionalitas CRUD penuh untuk data santri dan wali santri.
*   **Penyimpanan File**: Menggunakan Firebase Storage untuk mengunggah dan mengelola foto santri.

## Rencana Perubahan Saat Ini: Peningkatan UI/UX dan Persiapan Deployment

### 1. Peningkatan UI/UX (Selesai)

*   **Tujuan**: Memberikan pengalaman pengguna yang lebih modern, menarik, dan premium di seluruh aplikasi.
*   **Langkah-langkah**:
    *   **Tata Letak Publik**: Menyempurnakan `layouts/public.blade.php` dengan transisi, bayangan *header*, dan skema warna yang lebih harmonis.
    *   **Halaman Utama**: Memperbarui `welcome.blade.php` dengan ikon, efek *hover* pada galeri, dan tipografi dinamis.
    *   **Halaman Pendaftaran**: Menyempurnakan `students/register.blade.php` dengan status fokus pada *input* dan umpan balik visual yang lebih baik.
    *   **Dasbor Admin**: Mempercantik `dashboard.blade.php` dengan latar belakang ikon, bayangan kartu, dan efek "glow" pada elemen interaktif.

### 2. Persiapan Deployment Vercel (Selesai)

*   **Tujuan**: Mengonfigurasi proyek agar dapat di-*deploy* dan berjalan dengan lancar di platform Vercel.
*   **Langkah-langkah**:
    *   **Membuat `vercel.json`**: Menambahkan file konfigurasi untuk Vercel yang mendefinisikan *runtime* PHP, *builds*, dan *routes* agar kompatibel dengan arsitektur *serverless*.
    *   **Membuat `api/index.php`**: Membuat *entrypoint* untuk Vercel agar dapat menjalankan aplikasi Laravel.
    *   **Membuat `.vercelignore`**: Menambahkan file untuk mengecualikan direktori dan file yang tidak perlu (seperti `node_modules`, `storage/logs`) dari proses *deployment* untuk efisiensi.
