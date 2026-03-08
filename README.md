Sistem Manajemen Pencatatan Dana Desa Peturunan

Sistem Manajemen Pencatatan Dana Desa Peturunan merupakan aplikasi berbasis web menggunakan PHP dan MySQL yang digunakan untuk membantu pengelolaan keuangan dana desa secara terstruktur dan transparan.

Sistem ini memungkinkan kepala desa sebagai admin untuk melakukan pencatatan dan pengelolaan berbagai transaksi keuangan desa seperti:
-pembayaran iuran warga
-pemasukan dana tambahan
-pengeluaran dana desa
-histori transaksi
-laporan keuangan desa dalam format PDF

Aplikasi ini juga menerapkan konsep Object Oriented Programming (OOP) seperti:
-Interface
-Inheritance
-Polymorphism
-Namespace

Tentang Aplikasi
Sistem Manajemen Pencatatan Dana Desa Peturunan adalah sistem informasi berbasis web yang digunakan untuk membantu pengelolaan keuangan desa secara digital.

Dalam sistem ini Admin adalah Kepala Desa yang memiliki hak akses penuh untuk:
-Mengelola data kepala keluarga
-Mengelola pembayaran iuran warga
-Mencatat pemasukan dana tambahan
-Mencatat pengeluaran dana desa
-Melihat histori transaksi dana
-Menghasilkan laporan keuangan

Sistem ini dirancang agar pengelolaan dana desa dapat dilakukan secara:
-transparan
-terstruktur
-terdokumentasi dengan baik

Tujuan Sistem
Tujuan dibuatnya sistem ini adalah:
-Mencatat seluruh transaksi keuangan desa
-Mengurangi kesalahan pencatatan manual
-Menyediakan laporan keuangan desa secara otomatis
-Meningkatkan transparansi pengelolaan dana desa

Fitur Utama
1.Dashboard
Dashboard merupakan halaman utama sistem yang menampilkan ringkasan data keuangan desa.
Informasi yang ditampilkan:
-Total jumlah keluarga
-Total dana masuk
-Total pengeluaran
-Sisa saldo dana desa
-Status pembayaran iuran warga

Dashboard juga menyediakan fitur:
-Tambah data keluarga
-Tambah pemasukan dana
-Persetujuan pembayaran iuran
-Edit data keluarga
-Hapus data keluarga

2.Manajemen Iuran Warga
Sistem menyediakan fitur pengelolaan pembayaran iuran warga desa.
Fitur yang tersedia:
-Persetujuan pembayaran iuran
-Status pembayaran (Lunas / Belum Lunas)
-Reset otomatis iuran setiap bulan
-Besaran iuran per keluarga adalah Rp 50.000 per bulan

3.Pencatatan Pemasukan Dana
Admin dapat mencatat pemasukan dana tambahan selain iuran warga.
Contoh pemasukan:
-Donasi warga
-Bantuan desa
-Dana kegiatan

Data yang dicatat:
-tanggal
-jenis dana
-sumber dana
-keterangan
-jumlah dana

4.Pencatatan Pengeluaran Dana
Digunakan untuk mencatat penggunaan dana desa.
Data yang dicatat:
-tanggal pengeluaran
-keterangan penggunaan
-penanggung jawab
-jumlah dana
-Histori Dana
-Menu histori menampilkan riwayat transaksi dana desa yang telah terjadi.

Histori terdiri dari:
-Histori pembayaran iuran warga
-Histori pemasukan dana tambahan

5.Laporan Dana Desa
Menu laporan digunakan untuk menampilkan laporan keuangan desa secara lengkap.
Fitur laporan:
-filter laporan berdasarkan tanggal
-menampilkan laporan iuran
-menampilkan pemasukan tambahan
-menampilkan pengeluaran dana
-download laporan dalam format PDF

Teknologi yang Digunakan
-PHP
-MySQL	
-Bootstrap 5	
-FPDF	
-HTML	
-CSS

Cara Menjalankan Sistem
Sistem Manajemen Pencatatan Dana Desa Peturunan merupakan aplikasi berbasis PHP dan MySQL yang dijalankan menggunakan web server lokal seperti XAMPP.

Berikut langkah-langkah untuk menjalankan sistem:
1.Install XAMPP
Install aplikasi XAMPP yang berfungsi sebagai server lokal untuk menjalankan aplikasi PHP dan database MySQL.
XAMPP dapat diunduh melalui:
https://www.apachefriends.org
Setelah selesai menginstall, jalankan aplikasi XAMPP Control Panel.

Aktifkan layanan berikut:
-Apache
-MySQL

2.Menyiapkan Folder Project
Salin folder project Peturunan ke dalam folder:
xampp/htdocs/
Contoh struktur folder:
xampp
 └── htdocs
      └── Peturunan
           ├── html
           └── php

3.Membuat Database
Buka browser dan akses phpMyAdmin melalui alamat berikut:
http://localhost/phpmyadmin
Kemudian lakukan langkah berikut:
-Klik New
Buat database baru dengan nama:
-iuran_desa

4.Import Database
Setelah database dibuat, lakukan import database.
Langkah-langkah:
-Klik database iuran_desa
-Pilih menu Import
-Klik Choose File

Pilih file:
-iuran_desa.sql
-Klik Go

Setelah proses selesai, tabel berikut akan muncul di database:
-admin
-keluarga
-pembayaran
-pemasukan
-pengeluaran

5.Menjalankan Sistem
Buka browser kemudian akses alamat berikut:
http://localhost/Peturunan/html/public/login.php
Halaman login sistem akan muncul.

6.Login ke Sistem
Gunakan akun admin berikut untuk login:
Username : desa
Password : admin123
Admin pada sistem ini adalah Kepala Desa yang memiliki hak akses penuh untuk mengelola dana desa.

7.Sistem Siap Digunakan
Setelah login berhasil, admin dapat menggunakan fitur sistem seperti:
-Mengelola data kepala keluarga
-Menyetujui pembayaran iuran warga
-Menambahkan pemasukan dana tambahan
-Mencatat pengeluaran dana desa
-Melihat histori transaksi dana
-Mengunduh laporan dana desa dalam format PDF

Struktur Proyek 
Peturunan
│
├── html
│   └── public
│       ├── dashboard.php          <- (View / Interface) menampilkan dashboard sistem
│       ├── histori.php            <- (View / Interface) menampilkan histori transaksi dana
│       ├── laporan.php            <- (View / Interface) menampilkan laporan dana desa
│       ├── pengeluaran.php        <- (View / Interface) halaman pencatatan pengeluaran dana
│       └── login.php              <- (View / Interface) halaman login admin (kepala desa)
│
├── php
│
│   ├── config
│   │   ├── koneksi.php            <- (Database Configuration) menghubungkan sistem dengan database MySQL
│   │   └── iuran_desa.sql         <- (Database Structure) file SQL untuk membuat database dan tabel sistem
│
│   ├── controller
│   │   ├── approve_pembayaran.php     <- (Controller) menyetujui pembayaran iuran warga
│   │   ├── download_laporan.php       <- (Controller) membuat laporan dana desa dalam bentuk PDF
│   │   ├── hapus_keluarga.php         <- (Controller) menghapus data keluarga dari database
│   │   ├── logout.php                 <- (Controller) menghapus session login admin
│   │   ├── proses_login.php           <- (Controller) memproses login admin
│   │   ├── proses_pemasukan.php       <- (Controller) menyimpan data pemasukan dana tambahan
│   │   ├── proses_pengeluaran.php     <- (Controller) menyimpan data pengeluaran dana desa
│   │   ├── proses_tambah_keluarga.php <- (Controller) menambahkan data kepala keluarga
│   │   ├── reset_iuran.php            <- (Controller + OOP) menjalankan proses reset pembayaran iuran bulanan
│   │   └── update_keluarga.php        <- (Controller) memperbarui data kepala keluarga
│
│   ├── interfaceandmodel
│   │   ├── functions.php          <- (Namespace + Helper Functions) berisi fungsi bantuan seperti format rupiah dan status pembayaran
│   │   ├── manajemen_dana.php     <- (Namespace + OOP Model) berisi class pengelolaan dana desa menggunakan konsep OOP (interface, inheritance, polymorphism)
│   │   └── ResetPembayaran.php    <- (OOP Model) berisi class untuk melakukan reset pembayaran iuran setiap bulan
│
│   └── fpdf
│       └── fpdf.php               <- (External Library) library FPDF yang digunakan untuk membuat laporan dalam format PDF


Akun Demo 
+-----------+----------+----------------+
| Username  | Password | Hak Akses      |
+-----------+----------+----------------+
| desa      | admin123  | Kepala Desa   |
+-----------+----------+----------------+

Alur Penggunaan Sistem
-Kepala desa login ke sistem
-Sistem menampilkan dashboard
-Kepala desa menambahkan data keluarga
-Sistem membuat tagihan iuran bulanan
-Kepala desa menyetujui pembayaran iuran
-Kepala desa menambahkan pemasukan tambahan
-Kepala desa mencatat pengeluaran dana
-Semua transaksi tersimpan dalam histori
-Kepala desa dapat melihat laporan
-Kepala desa dapat mengunduh laporan PDF

Aturan Bisnis
-Setiap keluarga wajib membayar iuran setiap bulan
-Besaran iuran adalah Rp 50.000
-Pembayaran iuran harus disetujui oleh kepala desa
-Sistem melakukan reset pembayaran setiap bula
-Semua transaksi keuangan harus tercatat
-Laporan dapat difilter berdasarkan tanggal

Struktur Database
Tabel Admin
+-----------+-----------+-----------------------------+
| Field     | Tipe Data | Keterangan                  |
+-----------+-----------+-----------------------------+
| id_admin  | INT       | Primary Key                 |
| username  | VARCHAR   | Username untuk login admin  |
| password  | VARCHAR   | Password admin              |
+-----------+-----------+-----------------------------+

Tabel Keluarga
+-----------------------+-----------+--------------------------------+
| Field                 | Tipe Data | Keterangan                     |
+-----------------------+-----------+--------------------------------+
| id_keluarga           | INT       | Primary Key                    |
| nama_kepala_keluarga  | VARCHAR   | Nama kepala keluarga           |
| no_telepon            | VARCHAR   | Nomor telepon keluarga         |
+-----------------------+-----------+--------------------------------+

Tabel Pemasukan
+-------------+-----------+----------------------------------+
| Field       | Tipe Data | Keterangan                       |
+-------------+-----------+----------------------------------+
| id_pemasukan| INT       | Primary Key                      |
| tanggal     | DATE      | Tanggal pemasukan dana           |
| jenis_dana  | VARCHAR   | Jenis dana (pemasukan tambahan)  |
| sumber_dana | VARCHAR   | Sumber dana                      |
| keterangan  | TEXT      | Keterangan pemasukan             |
| jumlah      | INT       | Jumlah dana masuk                |
+-------------+-----------+----------------------------------+

Tabel Pembayaran
+----------------------+-----------+--------------------------------------+
| Field                | Tipe Data | Keterangan                           |
+----------------------+-----------+--------------------------------------+
| id_pembayaran        | INT       | Primary Key                          |
| id_keluarga          | INT       | Foreign Key dari tabel keluarga      |
| nama_kepala_keluarga | VARCHAR   | Nama kepala keluarga                 |
| bulan                | VARCHAR   | Bulan pembayaran iuran               |
| tahun                | VARCHAR   | Tahun pembayaran                     |
| jumlah               | INT       | Jumlah pembayaran                    |
| tanggal_bayar        | DATE      | Tanggal pembayaran                   |
| status               | VARCHAR   | Status pembayaran (Lunas / Belum)    |
+----------------------+-----------+--------------------------------------+

Tabel Pengeluaran
+------------------+-----------+------------------------------------+
| Field            | Tipe Data | Keterangan                         |
+------------------+-----------+------------------------------------+
| id_pengeluaran   | INT       | Primary Key                        |
| tanggal          | DATE      | Tanggal pengeluaran dana           |
| keterangan       | TEXT      | Keterangan penggunaan dana         |
| penanggung_jawab | VARCHAR   | Nama penanggung jawab              |
| jumlah           | INT       | Jumlah dana yang dikeluarkan       |
+------------------+-----------+------------------------------------+


