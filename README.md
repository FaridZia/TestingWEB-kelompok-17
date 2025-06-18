# TestingWEB-kelompok-17
Website Stock Barang telah diuji menggunakan tiga jenis pendekatan pengujian: White Box Testing, Black Box Testing, dan Grey Box Testing. Pengujian dilakukan untuk memastikan keluar masuk barang. fungsi Website menginput kebutuhan stock opname.

<h3>1. White Box Testing (Pengujian dari sisi pengembang)</h3>
Fokus pada struktur kode, alur logika, dan fungsi-fungsi internal dari aplikasi.

Menguji setiap cabang logika dan fungsi secara detail.

Dilakukan langsung terhadap kode program, terutama bagian:

* CRUD Barang (module/stokbarang/)
* CRUD Penjualan (module/penjualan/)

________________________________________________________________________________________
  
<h3>2. Black Box Testing (Pengujian dari sisi pengguna)</h3>
Fokus pada fungsi aplikasi dari sisi CRUD.

Menggunakan skenario uji berdasarkan input dan output:

* Input valid dan tidak valid untuk form Barang.
* Simulasi terhadap stok barang serta cek total barang dan nama.

Tools: Manual testing via browser.

Dokumentasi uji tersedia di folder: 📁 /blackbox/ 📸 Disertai screenshot hasil uji.

________________________________________________________________________________________

⚫ <h3>3. Grey Box Testing (Pengujian dari sisi integrasi logika & antarmuka)
Menggabungkan pendekatan Black Box dan White Box.</h3>

Menguji alur antar modul dan dependensi, seperti:

* Integrasi form input barang → penyimpanan di database.
* Data laporan ditarik dari stok.
* Validasi input pengguna yang juga diverifikasi di backend.
