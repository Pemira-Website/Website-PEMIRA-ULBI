# PEMIRA Release Checklist & Monitoring Runbook

Dokumen ini dipakai untuk Step 14: release aman + monitoring pasca deploy.

## 1) Pre-Deploy Gate (Wajib Lulus)

- [ ] Branch release sudah freeze, tidak ada perubahan mendadak.
- [ ] Backup database terbaru tersedia.
- [ ] File `.env` production terisi untuk variabel PEMIRA (lihat `.env.example`).
- [ ] Queue worker aktif dan supervisor disiapkan.
- [ ] Test kritis lulus:

```bash
php artisan test --filter=VoteFlowTest
```

## 2) Deploy Sequence

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
```

Catatan:
- Jalankan deploy di jam operasional panitia, jangan saat puncak voting jika tidak darurat.
- Setelah `queue:restart`, pastikan worker benar-benar up kembali.

## 3) Immediate Verification (0-5 menit)

1. Health endpoint:

```bash
curl -i https://YOUR_DOMAIN/up
```

2. Monitoring command:

```bash
php artisan pemira:monitor --fail-on-alert
```

3. Smoke flow manual:
- Login pemilih test.
- Buka halaman paslon.
- Submit satu vote valid.
- Pastikan muncul feedback sukses/pending.
- Pastikan status berubah sesuai proses queue.

## 4) Observability Window (5-60 menit)

Jalankan berkala:

```bash
php artisan pemira:monitor --json
```

Metric yang wajib dipantau:
- `pending_votes_total`
- `failed_votes_total`
- `audit_stale_processing`
- `jobs_backlog` (jika pakai queue database)

## 5) Alert Trigger & Tindakan

Trigger rollback/incident jika:
- `failed_votes_total` naik cepat dan menembus threshold.
- `audit_stale_processing > 0` terus menerus.
- `jobs_backlog` terus naik tanpa turun.
- User melaporkan vote sukses di UI tapi status tidak bergerak.

Tindakan awal:
1. Cek worker queue dan log aplikasi.
2. Jalankan ulang `php artisan queue:restart`.
3. Jika tidak pulih cepat, rollback ke release terakhir stabil.

## 6) Post-Deploy Closure

- [ ] Tidak ada alert kritis selama minimal 1 jam.
- [ ] Panitia menerima status release "stabil".
- [ ] Catatan deploy + waktu + operator terdokumentasi.
