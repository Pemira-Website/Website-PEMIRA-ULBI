# Pemira Business Rules (Step 1 Baseline)

Status: Draft terkunci untuk implementasi teknis, menunggu konfirmasi product owner.

## 1) Scope Pemilihan
- Presma: semua prodi bisa memilih.
- HIMA: hanya sesuai mapping prodi.
- Prodi khusus (`himabig`, `hicomlog`, `himamera`): hanya 1 vote (Presma saja).

## 2) Kuota Vote Per Pemilih
- Jalur reguler: maksimal 2 vote total (1 Presma + 1 HIMA).
- Jalur khusus: maksimal 1 vote total (Presma).

## 3) Mapping Prodi -> HIMA (Canonical)
- D3 Teknik Informatika -> himatif
- D4 Teknik Informatika -> himatif
- S1 Manajemen Logistik -> himagis
- D3 Administrasi Logistik -> himalogbis
- D4 Logistik Bisnis -> himalogbis
- S1 Manajemen Transportasi -> himaporta
- D3 Manajemen Pemasaran -> himanbis
- D4 Manajemen Perusahaan -> himanbis
- D3 Akuntansi -> hma
- D4 Akuntansi Keuangan -> hma
- S1 Bisnis Digital -> himabig (special)
- D4 Logistik Niaga-EL -> hicomlog (special)
- S1 Sains Data -> himasta
- S1 Manajemen Rekayasa -> himamera (special)
- D3 Manajemen Informatika -> hmmi

## 4) Login Rule
- Login voter memakai `npm + kode/password` yang tervalidasi hash.
- OTP/kode yang punya expiry harus ditolak jika lewat waktu.

## 5) Rule Integritas Vote
- Vote hanya boleh diproses untuk pemilih yang sedang login (berdasarkan session).
- `paslon_id` wajib cocok dengan `jenis_vote`.
- `jenis_vote` wajib termasuk hak pilih pemilih.
- Double-vote pada jenis yang sama wajib ditolak idempotent.

## 6) Rule Hasil Vote Publik
- Baseline rekomendasi: hasil publik tidak realtime saat pemungutan aktif.
- Opsi implementasi: mode konfigurasi `closed_until_end` atau `live_public`.

## 7) Rule Audit vs Privasi
- Sistem wajib memilih salah satu model:
- Model A (auditable): jejak internal menyimpan relasi pemilih-vote.
- Model B (strict anonymous): tidak ada relasi langsung pemilih-vote yang bisa direkonstruksi.
- Copy publik wajib konsisten dengan model yang dipilih.
- Mode implementasi aktif saat ini: `auditable`.

## 8) Rule UX Wajib
- Setelah submit vote, user selalu melihat status jelas: `pending/sukses/gagal`.
- Jika paslon kosong pada suatu jenis, tampilkan empty-state dengan CTA kembali.
- Tidak boleh ada dead-end page tanpa navigasi lanjut.

## 9) Rule Operasional
- Queue worker wajib aktif di environment produksi.
- Jika queue gagal, status vote harus terlihat `failed` dan bisa ditangani panitia.

## Konfirmasi Owner Yang Dibutuhkan
1. Setuju mapping canonical pada bagian 3.
2. Pilih mode hasil publik: `live_public`.
