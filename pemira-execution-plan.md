# Pemira Execution Plan (Step 1-14)

## Goal
Menjalankan perbaikan logic flow PEMIRA secara bertahap, aman, dan terverifikasi.

## Steps
- [x] Step 1: Lock aturan bisnis final dalam dokumen keputusan -> Verify: file `pemira-business-rules.md` tersedia dan siap konfirmasi owner.
- [x] Step 2: Buat single source of truth mapping `prodi -> hima` -> Verify: `config/pemira.php` + accessor `app/Support/PemiraConfig.php` tersedia.
- [x] Step 3: Hardening endpoint vote (hapus npm dari URL, pakai session) -> Verify: route vote menjadi `POST /vote` dan controller resolve pemilih dari session.
- [x] Step 4: Tambahkan validasi Form Request lintas-field (`paslon_id` harus cocok `jenis_vote`) -> Verify: `StoreVoteRequest` aktif dan dipakai di `VoteController`.
- [x] Step 5: Sinkronkan controller, seeder, Filament, dan view ke mapping pusat -> Verify: modul utama baca mapping dari `PemiraConfig`/`config/pemira.php`.
- [x] Step 6: Tambahkan state voting yang eksplisit (`not_voted/pending/completed/failed`) -> Verify: kolom status + transisi controller/job aktif.
- [x] Step 7: Perbaiki UX feedback pasca vote (success/error/next action) -> Verify: user selalu mendapat status yang jelas.
- [x] Step 8: Tangani empty state dan dead-end flow -> Verify: tidak ada halaman kosong tanpa arahan.
- [x] Step 9: Selaraskan kebijakan anonimitas vs auditability -> Verify: copy publik sesuai implementasi teknis.
- [x] Step 10: Hardening panel admin (password/code handling, input consistency) -> Verify: tidak ada plain password flow dan opsi data konsisten.
- [x] Step 11: Optimasi live chart dan kebijakan hasil publik -> Verify: beban polling turun dan mode publik sesuai kebijakan.
- [x] Step 12: Data cleanup + normalisasi nilai lama -> Verify: data lama tidak bentrok dengan rule baru.
- [x] Step 13: Tambah test feature untuk path kritis -> Verify: test skenario tampered, race, mismatch lulus.
- [x] Step 14: Release checklist + monitoring pasca deploy -> Verify: deploy aman dengan observability aktif.

## Done When
- [x] Semua step selesai dan diverifikasi.
- [ ] Tidak ada celah logic kritis pada voting flow.
