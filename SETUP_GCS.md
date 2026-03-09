# Step-by-Step Setup Google Cloud Storage untuk PEMIRA 2026

## Prerequisites
- Akun Google Cloud dengan billing aktif
- `gcloud` CLI terinstall ([install](https://cloud.google.com/sdk/docs/install))
- Akses ke GCP Console: https://console.cloud.google.com

---

## Step 1: Login & Set Project

```bash
# Login ke Google Cloud
gcloud auth login

# Set project (ganti dengan project ID kamu)
gcloud config set project YOUR_PROJECT_ID

# Verifikasi
gcloud config get-value project
```

---

## Step 2: Buat Bucket GCS

```bash
# Buat bucket di region Asia Southeast 1 (Jakarta)
# Ganti YOUR_BUCKET_NAME dengan nama unik (misal: pemira-26-storage)
gcloud storage buckets create gs://YOUR_BUCKET_NAME \
  --location=asia-southeast1 \
  --default-storage-class=STANDARD \
  --uniform-bucket-level-access
```

> **PENTING**: Flag `--uniform-bucket-level-access` WAJIB ada. Kode aplikasi sudah dikonfigurasi untuk mode ini (menggunakan `UniformBucketLevelAccessVisibility`).

### Verifikasi bucket sudah dibuat:
```bash
gcloud storage buckets describe gs://YOUR_BUCKET_NAME --format="value(iamConfiguration.uniformBucketLevelAccess.enabled)"
# Output harus: True
```

---

## Step 3: Set Public Access (Biar Foto Paslon Bisa Dilihat)

```bash
# Berikan akses baca publik ke semua object di bucket
gcloud storage buckets add-iam-policy-binding gs://YOUR_BUCKET_NAME \
  --member=allUsers \
  --role=roles/storage.objectViewer
```

### Verifikasi:
```bash
# Cek IAM policy
gcloud storage buckets get-iam-policy gs://YOUR_BUCKET_NAME
```

Pastikan ada entry:
```
- members:
  - allUsers
  role: roles/storage.objectViewer
```

---

## Step 4: Buat Service Account untuk Aplikasi

```bash
# Buat service account
gcloud iam service-accounts create pemira-gcs-sa \
  --display-name="PEMIRA GCS Service Account"

# Berikan role Storage Object Admin (bisa upload, delete, list)
gcloud storage buckets add-iam-policy-binding gs://YOUR_BUCKET_NAME \
  --member=serviceAccount:pemira-gcs-sa@YOUR_PROJECT_ID.iam.gserviceaccount.com \
  --role=roles/storage.objectAdmin
```

---

## Step 5: Generate Service Account Key (JSON)

```bash
# Generate key file
gcloud iam service-accounts keys create gcs-credentials.json \
  --iam-account=pemira-gcs-sa@YOUR_PROJECT_ID.iam.gserviceaccount.com

# Key akan disimpan di file gcs-credentials.json di directory saat ini
```

> **⚠️ JANGAN commit file ini ke Git!** File ini berisi private key.

---

## Step 6: Set CORS (Supaya Upload dari Browser Bisa Jalan)

Buat file `cors.json`:

```json
[
  {
    "origin": [
      "https://pemira.renzip.my.id",
      "http://localhost:8000",
      "http://localhost"
    ],
    "method": ["GET", "PUT", "POST", "DELETE", "HEAD"],
    "responseHeader": [
      "Content-Type",
      "x-goog-resumable",
      "Content-Length",
      "Content-Range"
    ],
    "maxAgeSeconds": 3600
  }
]
```

Apply ke bucket:
```bash
gcloud storage buckets update gs://YOUR_BUCKET_NAME --cors-file=cors.json
```

### Verifikasi CORS:
```bash
gcloud storage buckets describe gs://YOUR_BUCKET_NAME --format="json(cors_config)"
```

---

## Step 7: Setup Environment Variables

### A. Untuk Development Lokal (.env)

```dotenv
FILESYSTEM_DISK=gcs
GOOGLE_CLOUD_PROJECT_ID=YOUR_PROJECT_ID
GOOGLE_CLOUD_STORAGE_BUCKET=YOUR_BUCKET_NAME
GOOGLE_CLOUD_STORAGE_PATH_PREFIX=pemira

# Paste ISI file gcs-credentials.json dalam 1 baris (escape double quotes)
# Cara convert: buka gcs-credentials.json, minify jadi 1 line
GOOGLE_CLOUD_CREDENTIALS={"type":"service_account","project_id":"YOUR_PROJECT_ID","private_key_id":"...","private_key":"-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n","client_email":"pemira-gcs-sa@YOUR_PROJECT_ID.iam.gserviceaccount.com",...}
```

**Tips minify JSON:**
```bash
# Di terminal, convert file JSON ke 1 baris:
cat gcs-credentials.json | jq -c .
```

### B. Untuk Production (GitHub Secrets)

Buka repo GitHub → **Settings** → **Secrets and variables** → **Actions**, tambahkan:

| Secret Name | Value |
|-------------|-------|
| `GCP_PROJECT_ID` | `YOUR_PROJECT_ID` |
| `GCS_BUCKET` | `YOUR_BUCKET_NAME` |
| `GCP_SA_KEY` | Isi lengkap file `gcs-credentials.json` (copy-paste isi file) |

> Secrets ini sudah di-referensi oleh `.github/workflows/deploy.yml`. Deployment otomatis akan set env vars di Cloud Run.

---

## Step 8: Test Upload Lokal

```bash
# Clear config cache
php artisan config:clear

# Jalankan server
php artisan serve

# Buka http://localhost:8000/admin
# Login ke Filament admin panel
# Coba edit paslon → upload foto → Save
```

### Test via Tinker (opsional):
```bash
php artisan tinker
```
```php
// Test upload
Storage::disk('gcs')->put('test/hello.txt', 'Hello from PEMIRA!');

// Test URL generation
Storage::disk('gcs')->url('test/hello.txt');
// Expected: https://storage.googleapis.com/YOUR_BUCKET_NAME/pemira/test/hello.txt

// Test read
Storage::disk('gcs')->get('test/hello.txt');
// Expected: "Hello from PEMIRA!"

// Cleanup
Storage::disk('gcs')->delete('test/hello.txt');
```

---

## Step 9: Deploy ke Production

```bash
# Commit & push perubahan kode
git add -A
git commit -m "fix: GCS uniform bucket-level access + Filament FileUpload"
git push origin main
```

GitHub Actions akan otomatis:
1. Run tests
2. Build Docker image
3. Deploy ke Cloud Run dengan env vars dari secrets

---

## Step 10: Verifikasi Production

1. Buka `https://pemira.renzip.my.id/admin`
2. Login ke admin panel
3. Buka **Paslon** → klik **Edit** pada salah satu paslon
4. Upload foto baru → klik **Save**
5. Pastikan tidak ada 500 error
6. Cek foto bisa diakses publik: `https://storage.googleapis.com/YOUR_BUCKET_NAME/pemira/paslon/NAMA_FILE.jpg`

---

## Troubleshooting

### Error: "Could not establish connection"
- Pastikan `GOOGLE_CLOUD_CREDENTIALS` terisi dengan benar di env
- Pastikan JSON credentials valid (bukan truncated)
- Cek apakah service account key belum expired/revoked

### Error: "Access denied" saat upload
- Cek service account punya role `roles/storage.objectAdmin` pada bucket
- Verifikasi: `gcloud storage buckets get-iam-policy gs://YOUR_BUCKET_NAME`

### Error: "Uniform bucket-level access" related
- Pastikan bucket pakai uniform access: `gcloud storage buckets describe gs://YOUR_BUCKET_NAME --format="value(iamConfiguration.uniformBucketLevelAccess.enabled)"`
- Harus output `True`

### Foto tidak bisa diakses (403)
- Pastikan `allUsers` punya role `roles/storage.objectViewer`
- Test langsung: `curl -I https://storage.googleapis.com/YOUR_BUCKET_NAME/pemira/paslon/NAMA_FILE.jpg`

### Upload gagal dari browser (CORS error)
- Pastikan CORS sudah di-set (Step 6)
- Origin harus match persis (termasuk `https://`)

### Config cache stale
```bash
# Lokal
php artisan config:clear

# Production (Cloud Run) - redeploy atau:
# Cloud Run otomatis fresh setiap deploy, jadi push ulang saja
```

---

## Ringkasan Architecture

```
Browser (Filament Admin)
    │
    ▼ Upload via Livewire
Laravel App (Cloud Run)
    │
    ├─ FileUpload component → disk('gcs') → GCS Adapter
    │   └─ UniformBucketLevelAccessVisibility (skip ACL)
    │
    ▼ Store file
Google Cloud Storage Bucket
    ├─ Uniform Bucket-Level Access: ON
    ├─ allUsers: objectViewer (public read)
    └─ pemira-gcs-sa: objectAdmin (read/write/delete)
    
    │
    ▼ Public URL
https://storage.googleapis.com/{bucket}/pemira/paslon/{file}
    │
    ▼ Displayed in
Blade Views (paslon.blade.php, chart components)
```
