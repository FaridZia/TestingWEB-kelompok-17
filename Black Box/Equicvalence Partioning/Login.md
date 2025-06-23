# Test Case: Login - Equivalence Class

| No | Kelas Equivalen                          | Username Input | Password Input | Valid / Invalid | Alasan                                  | Ekspektasi Aplikasi                 |
|----|------------------------------------------|----------------|----------------|------------------|------------------------------------------|-------------------------------------|
| 1  | Kombinasi benar                          | "admin"        | "admin"        | Valid            | Kombinasi cocok di database              | Login berhasil, masuk ke menu utama |
| 2  | Username benar, password salah           | "user123"      | "salahpass"    | Invalid          | Password tidak cocok                     | Login gagal, muncul pesan kesalahan |
| 3  | Username tidak terdaftar                 | "tidakadada"   | "pass12345"    | Invalid          | Username tidak valid                     | Login gagal, muncul pesan kesalahan |
| 4  | Username kosong                          | ""             | "pass12345"    | Invalid          | Field username wajib diisi               | Validasi input ditampilkan          |
| 5  | Password kosong                          | "user123"      | ""             | Invalid          | Field password wajib diisi               | Validasi input ditampilkan          |
| 6  | Keduanya kosong                          | ""             | ""             | Invalid          | Kedua field wajib diisi                  | Validasi input ditampilkan          |

