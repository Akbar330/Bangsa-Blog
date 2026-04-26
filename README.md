# BANGSA BLOG - Professional News Portal System

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/License-Proprietary-blue.svg)](LICENSE)

**BANGSA BLOG** adalah platform manajemen konten (CMS) blog dan portal berita profesional yang dibangun dengan Laravel. Didesain dengan estetika modern yang terinspirasi dari portal berita nasional terkemuka, sistem ini menawarkan performa tinggi, keamanan role-based, dan pengalaman pengguna yang luar biasa.

## 🚀 Fitur Utama

- **Multi-User Role System**: 
    - **Admin**: Kontrol penuh atas seluruh sistem.
    - **Editor**: Manajemen konten dan kategori.
    - **Writer**: Menulis dan mengelola artikel sendiri.
    - **Reader/User**: Member terdaftar yang bisa berinteraksi (komentar).
- **Rich Content Management**:
    - Full CRUD Artikel dengan **CKEditor 5**.
    - Sistem Tagging dan Kategori Hirarkis.
    - Optimasi Gambar (Auto-resize & Optimization).
    - Draft & Scheduling System.
- **Editorial Workflow**:
    - Statistik Dashboard yang real-time.
    - Tracking view artikel untuk algoritma trending.
- **Modern UI/UX**:
    - Desain premium terinspirasi dari IDNTimes.
    - Mobile-First & Responsive Layout.
    - Elegant Auth UI (Login/Register).
- **Interaction**:
    - Nested Comment System (Diskusikan berita secara mendalam).
    - Search engine internal yang cepat.
- **SEO Ready**:
    - SEO Friendly Slugs.
    - Meta tags dinamis untuk setiap artikel.
- **Security**:
    - Middleware protection.
    - Role-based Access Control (RBAC) via Spatie Permissions.

## 🛠️ Stack Teknologi

- **Backend**: Laravel 13
- **Database**: MySQL / MariaDB
- **Frontend**: Blade, Tailwind CSS, Alpine.js
- **Assets**: Vite
- **Editors**: CKEditor 5
- **Icons**: Heroicons

## 📦 Instalasi

1. **Clone project:**
   ```bash
   git clone https://github.com/Akbar330/Bangsa-Blog.git
   cd Bangsa-Blog
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database:**
   Edit `.env` dan sesuaikan koneksi database kamu.

5. **Migrate & Seed:**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Storage Link:**
   ```bash
   php artisan storage:link
   ```

7. **Run server:**
   ```bash
   npm run dev
   php artisan serve
   ```

## ⚖️ Lisensi (License)

Project ini memiliki lisensi **Proprietary**. 
- **Boleh**: Diperbolehkan untuk di-clone untuk tujuan pembelajaran dan pengembangan lokal (personal).
- **Dilarang**: Penggunaan untuk tujuan **KOMERSIAL** (bisnis, dijual kembali, atau monetisasi) dilarang keras tanpa izin tertulis dari **Bangsa Tech Dev**.

---
*Dibuat dengan ❤️ oleh Bang Jhon & Bangsa Tech Dev*
