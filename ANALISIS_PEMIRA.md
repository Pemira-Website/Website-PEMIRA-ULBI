# Analisis Aplikasi PEMIRA 2026

**Tanggal Analisis**: 5 Maret 2026  
**Metode**: Code review manual + Context7 (Laravel 11.x docs) + Laravel Expert Skill  
**Stack**: Laravel 11, Filament, Livewire, Redis Queue, Google Cloud Storage, Tailwind CSS

---

## Deskripsi Aplikasi

Aplikasi **PEMIRA (Pemilihan Raya)** KEMA ULBI adalah sistem e-voting untuk mahasiswa yang mencakup:

- **Pemilihan Presiden Mahasiswa (Presma)** — diikuti seluruh prodi
- **Pemilihan Ketua HIMA** — per himpunan (himatif, himagis, himalogbis, himaporta, himanbis, hma, himasta, hmmi, himabig, hicomlog, himamera)

### Alur Aplikasi

```
Login (NPM + OTP) → Menu Vote (Presma + HIMA) → Pilih Paslon → Vote (Queue) → Live Chart
```

1. Admin generate kode OTP via Filament panel
2. Mahasiswa login dengan NPM + OTP
3. Masuk ke menu vote sesuai prodi (max 2 vote: 1 Presma + 1 HIMA)
4. Prodi khusus (himabig, hicomlog, himamera) hanya bisa vote Presma (max 1 vote)
5. Vote di-dispatch ke Redis queue → `ProcessVote` job memproses dengan atomic lock
6. Hasil real-time via Livewire polling chart

---

## A. Logic yang Sudah Berjalan Benar

| # | Area | Detail | Status |
|---|------|--------|--------|
| 1 | **Alur Login** | Autentikasi via NPM + password (hashed), session-based | ✅ |
| 2 | **CSRF Protection** | Semua form menggunakan `@csrf` Blade directive | ✅ |
| 3 | **Password Hashing** | Login `Hash::check()`, OTP generate `Hash::make()` | ✅ |
| 4 | **Vote Queue** | `ProcessVote::dispatch()` ke Redis queue untuk high throughput | ✅ |
| 5 | **Race Condition Prevention** | Redis atomic lock `Cache::lock("vote_{id}_{jenis}", 5)` di job | ✅ |
| 6 | **DB Transaction** | Vote write operation dibungkus `DB::transaction()` | ✅ |
| 7 | **Double Vote Prevention** | Check `pml_presma`/`pml_hima` sebelum increment di job & controller | ✅ |
| 8 | **Rate Limiting** | Custom throttle 1 req/3 detik per NPM di `VoteController` | ✅ |
| 9 | **Audit Logging** | Setiap vote tercatat di `audit_logs` (IP, user agent, status) | ✅ |
| 10 | **Prodi Access Control** | `PaslonController` validasi prodi pemilih vs jenis pemilihan | ✅ |
| 11 | **Live Chart** | Livewire polling 3 detik + cache 5 detik, dynamic color palette | ✅ |
| 12 | **OTP System** | 6-digit alphanumeric, hashed, expire 30 menit via `GenerateKodePage` | ✅ |
| 13 | **Mass Assignment** | Semua model menggunakan `$fillable` dengan benar | ✅ |
| 14 | **GCS Storage** | File upload paslon ke Google Cloud Storage via custom Flysystem adapter | ✅ |
| 15 | **Special Program Logic** | himabig/hicomlog/himamera hanya bisa vote presma (max 1 vote) | ✅ |

---

## B. Masalah & Bug yang Ditemukan

### 🔴 CRITICAL

#### 1. Route Tidak Dilindungi Middleware Auth

**File**: `routes/web.php`

Semua route voting (`/menuvote`, `/vote`, `/hasilvote`) **tidak menggunakan middleware auth** di route level. Hanya bergantung pada manual `Session::has()` check di controller.

**Kondisi saat ini**:
```php
Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
Route::post('/vote/{npm}', [VoteController::class, 'addVote'])->name('vote.add');
```

**Seharusnya (menurut Laravel 11.x docs)**:
```php
Route::middleware(['web'])->group(function () {
    // Route yang butuh autentikasi session
    Route::middleware(['auth.session'])->group(function () {
        Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
        Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
        Route::post('/vote/{npm}', [VoteController::class, 'addVote'])->name('vote.add');
    });
});
```

Atau minimal buat custom middleware yang cek `Session::has('npm')`.

**Risiko**: Seseorang bisa langsung hit `POST /vote/{npm}` tanpa session. `Session::get('jenis_pemilihan')` akan `null`, berpotensi bypass logic vote.

---

#### 2. OTP Expiry Tidak Divalidasi Saat Login

**File**: `app/Http/Controllers/AuthController.php` (line 39-41)

Login hanya mengecek password:
```php
if ($user && Hash::check($password, $user->password)) {
    // ... langsung masuk
}
```

**Tidak ada pengecekan `otp_expires_at`**, sehingga OTP yang sudah expired tetap bisa dipakai login.

**Seharusnya**:
```php
if ($user && Hash::check($password, $user->password)) {
    // Cek apakah OTP sudah expired
    if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
        return redirect()->back()->withErrors(['error' => 'Kode OTP sudah expired. Silakan minta kode baru.']);
    }
    // ... lanjut login
}
```

---

### 🟠 HIGH

#### 3. Typo di Namespace Import

**File**: `routes/web.php` (line 6)

```php
use App\Http\COntrollers\VoteController;  // ❌ "COntrollers"
```

Seharusnya:
```php
use App\Http\Controllers\VoteController;  // ✅ "Controllers"
```

**Dampak**: Akan menyebabkan **class not found error** di production (Linux/Cloud Run menggunakan case-sensitive filesystem). Di Windows development bisa jalan karena case-insensitive.

---

#### 4. Password Tersimpan Plain Text di Filament Action

**File**: `app/Filament/Resources/PemilihResource.php` (line 161-168)

Action `generateKode` di table Filament menyimpan password **tanpa hash**:
```php
->action(function ($record) {
    $password = substr($record->npm, -4);
    $record->update(['password' => $password]); // ❌ PLAIN TEXT!
})
```

Sementara `GenerateKodePage.php` sudah benar menggunakan `Hash::make()`. Akibatnya, password yang di-generate dari action ini **tidak bisa di-verify** oleh `Hash::check()` di `AuthController`.

**Fix**:
```php
$record->update(['password' => \Illuminate\Support\Facades\Hash::make($password)]);
```

---

#### 5. Middleware `User.php` Tidak Berfungsi (Dead Code)

**File**: `app/Http/Middleware/User.php`

Middleware ini hanya mem-forward request tanpa validasi apapun dan **tidak dipakai di route manapun**:
```php
public function handle(Request $request, Closure $next): Response
{
    return $next($request); // Tidak ada logic
}
```

**Rekomendasi**: Hapus atau implementasikan sebagai session-based auth checker.

---

### 🟡 MEDIUM

#### 6. Model `Accounts` Tidak Digunakan (Dead Code)

**File**: `app/Models/Accounts.php`

Model ini tampaknya duplikat/legacy dari `Pemilih`. Tidak ada migration untuk table `Accounts` dan tidak di-reference dari controller/route manapun.

**Rekomendasi**: Hapus untuk menghindari kebingungan.

---

#### 7. Relasi Model Paslon-Pemilih Tidak Akurat

**File**: `app/Models/Paslon.php` (line 44-47)

```php
public function pemilih()
{
    return $this->hasMany(Pemilih::class, 'jenis_pemilihan', 'jenis_pemilihan');
}
```

Field `jenis_pemilihan` di `Pemilih` berisi comma-separated values (contoh: `"presma,himatif"`), bukan single FK. Relasi `hasMany` **tidak akan match** karena Eloquent membandingkan exact string, bukan `LIKE` atau `FIND_IN_SET`.

Relasi `belongsTo` di `Pemilih` model memiliki masalah yang sama.

**Rekomendasi**: Gunakan pivot table atau `whereRaw('FIND_IN_SET(?, jenis_pemilihan)', [$this->jenis_pemilihan])` sebagai scope.

---

#### 8. Menu Vote Tidak Menampilkan himabig/hicomlog/himamera

**File**: `resources/views/hima/hima.blade.php`

Blade ini hanya punya mapping untuk prodi reguler. Prodi khusus tidak punya branch:

| Prodi | HIMA | Ada di blade? |
|-------|------|:---:|
| S1 Bisnis Digital | himabig | ❌ |
| D4 Logistik Niaga-EL | hicomlog | ❌ |
| S1 Manajemen Rekayasa | himamera | ❌ |

Mahasiswa dari prodi ini **hanya melihat tombol Presma** di menu vote. Meskipun secara logic memang hanya bisa vote Presma, blade partial `himabig.blade.php`, `hicomlog.blade.php`, dan `himamera.blade.php` sudah ada tapi tidak di-include.

**Catatan**: Ini mungkin **by design** (karena mereka memang hanya vote Presma), tapi perlu dikonfirmasi apakah UI-nya sudah sesuai harapan.

---

#### 9. PresmaLiveChart Hardcoded untuk 2 Paslon

**File**: `resources/views/livewire/presma-live-chart.blade.php`

```js
const labels = ['Paslon 1', 'Paslon 2'];  // Hardcoded
max: 3458,                                  // Hardcoded Y-axis
```

Jika jumlah paslon presma berubah, chart ini akan break. Component `LiveChart` yang lebih baru sudah dynamic dan mendukung N paslon.

**Rekomendasi**: Gunakan `LiveChart` component saja untuk semua jenis pemilihan, hapus `PresmaLiveChart`.

---

### 🟢 LOW

#### 10. Route `GET /logout` Seharusnya `POST`

**File**: `routes/web.php` (line 14)

```php
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
```

Menurut best practice Laravel, logout harus via `POST` untuk menghindari CSRF-based forced logout (attacker bisa embed `<img src="/logout">` di halaman lain).

**Fix**:
```php
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
```

---

#### 11. Chart Polling Tidak Efisien

**File**: `resources/views/livewire/live-chart.blade.php`

Semua Livewire chart melakukan polling tiap 3 detik:
```js
setInterval(() => @this.dispatch('ubahData'), 3000);
```

Dengan 12 jenis pemilihan di `/hasilvote`, ini menghasilkan ~4 AJAX request/detik ke server secara konstan.

**Rekomendasi**:
- Naikkan interval ke 10-15 detik
- Gunakan `wire:poll.10s` directive bawaan Livewire
- Atau implementasi WebSocket/Server-Sent Events untuk real push

---

#### 12. Potensi XSS di `paslon.blade.php`

**File**: `resources/views/vote/paslon.blade.php` (line 57-66)

Visi dan misi di-pass via JavaScript `onclick` dengan backtick:
```js
`{!! addslashes($paslon->visi) !!}`
```

`addslashes()` tidak cukup untuk JavaScript template literal context. Jika content berisi backtick (`` ` ``) atau `${}`, bisa terjadi code injection.

**Fix**: Gunakan `@json()` Blade directive:
```blade
onclick="showDetailModal(..., @json($paslon->visi), @json($paslon->misi))"
```

---

## C. Ringkasan

| Severity | Count | Detail |
|----------|:-----:|--------|
| 🔴 **CRITICAL** | 2 | Route tanpa middleware, OTP expiry tidak dicek |
| 🟠 **HIGH** | 3 | Typo namespace, plain-text password Filament, dead middleware |
| 🟡 **MEDIUM** | 4 | Dead model, relasi salah, missing hima includes, hardcoded chart |
| 🟢 **LOW** | 3 | GET logout, polling inefficient, XSS risk |

---

## D. Prioritas Perbaikan

### Harus Diperbaiki Sebelum Production

1. ✅ Tambah middleware auth di route voting
2. ✅ Validasi OTP expiry di `AuthController`
3. ✅ Fix typo namespace `COntrollers` → `Controllers`
4. ✅ Hash password di Filament `generateKode` action

### Sebaiknya Diperbaiki

5. Hapus dead code (`Accounts` model, `User` middleware)
6. Fix/hapus relasi Paslon-Pemilih yang salah
7. Gunakan `LiveChart` tunggal (hapus `PresmaLiveChart`)
8. Ubah `GET /logout` ke `POST /logout`

### Nice to Have

9. Optimasi polling interval
10. Fix XSS risk di paslon detail modal
11. Include blade himabig/hicomlog/himamera jika perlu

---

## E. Arsitektur & Pattern Assessment

### Sesuai Laravel Best Practice ✅

- Thin controllers, logic berat di Job (`ProcessVote`)
- Filament untuk admin panel (CRUD Paslon, Pemilih)
- Livewire untuk real-time chart tanpa full-page reload
- Queue + atomic lock untuk vote integrity
- Audit log untuk traceability
- GCS storage untuk production file serving
- Environment-based configuration (`.env`)

### Perlu Perbaikan ⚠️

- Tidak ada FormRequest class (validasi inline di controller)
- Tidak ada Middleware route group untuk auth
- Mixed authentication (session manual vs Laravel Auth)
- Tidak ada unit/feature test untuk voting logic
- Hardcoded prodi mapping di multiple places (controller + blade)

---

*Dokumen ini di-generate otomatis berdasarkan analisis kode sumber aplikasi PEMIRA 2026.*
