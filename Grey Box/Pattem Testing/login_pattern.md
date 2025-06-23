# 🔐 Pattern Testing – Fitur Login

## Tujuan Pengujian
Menguji pola input umum yang bisa menyebabkan login gagal, celah keamanan, atau validasi yang tidak memadai.

## Skema Uji Pola

| No. | Input Username         | Input Password         | Pola Pengujian                   | Hasil yang Diharapkan               |
|-----|------------------------|------------------------|----------------------------------|-------------------------------------|
| 1   | admin                  | admin               | ✅ Input valid                    | Login berhasil                      |
| 2   | dududu           | duar123                 | ❌ SQL Injection                  | Login gagal, input ditolak          |
| 3   | <script>alert(1)</script> | test123              | ❌ XSS Injection                 | Login gagal, input divalidasi       |
