<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Owner\BookingController;
use App\Http\Controllers\Web\Owner\PasienController;
use App\Http\Controllers\Web\Owner\TerapisController;
use App\Http\Controllers\Web\Owner\LayananController;
use App\Http\Controllers\Web\Owner\PengeluaranController;
use App\Http\Controllers\Web\Owner\PenggajianController;
use App\Http\Controllers\Web\Owner\LaporanController;
use App\Http\Controllers\Web\Owner\KonsultasiController;
use App\Http\Controllers\Web\Owner\CabangController;
use App\Http\Controllers\Web\Owner\StafController;
use App\Http\Controllers\Web\Owner\AuditController;
use App\Http\Controllers\Web\Owner\SosmedController;
use App\Http\Controllers\Web\Owner\InstagramController;
use App\Http\Controllers\Web\Owner\ReservasiIgController;
use App\Http\Controllers\Web\Owner\LandingController;
use App\Http\Controllers\Web\Owner\HonorController;
use App\Http\Controllers\Web\Owner\KalenderController;
use App\Http\Controllers\Web\Owner\PusatController;
use App\Http\Controllers\Web\Owner\AkunPasienController;
use App\Http\Controllers\Web\Owner\MilestoneController;
use App\Http\Controllers\Web\Owner\JadwalTerapisController;
use App\Http\Controllers\Web\Owner\WalkInController;
use App\Http\Controllers\Web\Owner\PengaturanController;
use App\Http\Controllers\Web\Therapist\TherapistController;
use App\Http\Controllers\Web\Parent\ParentController;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/privacy', fn() => view('privacy'))->name('privacy');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',       [LoginController::class,    'showLogin'])->name('login');
    Route::post('/login',      [LoginController::class,    'login']);
    Route::get('/signup',      [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/signup',     [RegisterController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated ────────────────────────────────────
Route::middleware(['auth','active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/akun',      [DashboardController::class, 'akun'])->name('akun');
    Route::put('/akun',      [DashboardController::class, 'updateAkun']);

    // Anak (PARENT)
    Route::prefix('anak')->name('anak.')->group(function () {
        Route::get('/',           [ParentController::class, 'anakIndex'])->name('index');
        Route::get('/baru',       [ParentController::class, 'anakCreate'])->name('create');
        Route::post('/',          [ParentController::class, 'anakStore'])->name('store');
        Route::get('/{id}',       [ParentController::class, 'anakShow'])->name('show');
        Route::get('/{id}/edit',  [ParentController::class, 'anakEdit'])->name('edit');
        Route::put('/{id}',       [ParentController::class, 'anakUpdate'])->name('update');
        Route::get('/{id}/tumbuh-kembang', [ParentController::class, 'tumbuhKembang'])->name('tumbuh');
        Route::get('/{id}/latihan-rumah',  [ParentController::class, 'latihanRumah'])->name('latihan');
    });

    // Booking (PARENT)
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/baru',      [ParentController::class, 'bookingCreate'])->name('create');
        Route::post('/',         [ParentController::class, 'bookingStore'])->name('store');
        Route::get('/{id}/sukses', [ParentController::class, 'bookingSukses'])->name('sukses');
    });

    // Jadwal & Layanan & Konsultasi (PARENT/shared)
    Route::get('/jadwal',       [ParentController::class, 'jadwal'])->name('jadwal');
    Route::get('/layanan',      [ParentController::class, 'layanan'])->name('layanan');
    Route::get('/konsultasi',            [ParentController::class, 'konsultasiIndex'])->name('konsultasi.index');
    Route::get('/konsultasi/baru',       [ParentController::class, 'konsultasiBaru'])->name('konsultasi.create');
    Route::post('/konsultasi',           [ParentController::class, 'konsultasiStore'])->name('konsultasi.store');
    Route::get('/konsultasi/{id}',       [ParentController::class, 'konsultasiShow'])->name('konsultasi.show');

    // ── OWNER / ADMIN / DIREKTUR ─────────────────────
    Route::middleware('role:OWNER,ADMIN,SUPER_ADMIN,DIREKTUR,RECEPTIONIST')
        ->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard',     [DashboardController::class, 'ownerDashboard'])->name('dashboard');
        Route::get('/pusat',         [PusatController::class, 'index'])->name('pusat');
        Route::resource('booking',   BookingController::class);
        Route::post('/walk-in',      [WalkInController::class, 'store'])->name('walk-in.store');
        Route::get('/walk-in',       [WalkInController::class, 'index'])->name('walk-in.index');
        Route::resource('pasien',    PasienController::class);
        Route::resource('terapis',   TerapisController::class);
        Route::get('/terapis/{id}/ulasan', [TerapisController::class, 'ulasan'])->name('terapis.ulasan');
        Route::resource('layanan',   LayananController::class);
        Route::resource('pengeluaran', PengeluaranController::class);
        Route::resource('penggajian',  PenggajianController::class);
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/pendapatan', [LaporanController::class, 'pendapatan'])->name('pendapatan');
            Route::get('/advanced',   [LaporanController::class, 'advanced'])->name('advanced');
            Route::get('/pembukuan',  [LaporanController::class, 'pembukuan'])->name('pembukuan');
            Route::get('/pajak',      [LaporanController::class, 'pajak'])->name('pajak');
            Route::get('/referral',   [LaporanController::class, 'referral'])->name('referral');
        });
        Route::get('/calendar',       [KalenderController::class,   'index'])->name('calendar');
        Route::get('/honor',          [HonorController::class,      'index'])->name('honor');
        Route::get('/konsultasi',     [KonsultasiController::class,  'index'])->name('konsultasi');
        Route::get('/jadwal-terapis', [JadwalTerapisController::class,'index'])->name('jadwal-terapis');
        Route::get('/akun-pasien',    [AkunPasienController::class,  'index'])->name('akun-pasien');
        Route::get('/milestone',      [MilestoneController::class,   'index'])->name('milestone');
        Route::resource('cabang',     CabangController::class);
        Route::resource('staf',       StafController::class);
        Route::resource('users',      \App\Http\Controllers\Web\Owner\UserController::class);
        Route::get('/audit',          [AuditController::class,       'index'])->name('audit');
        Route::get('/sosmed',         [SosmedController::class,      'index'])->name('sosmed');
        Route::put('/sosmed',         [SosmedController::class,      'update']);
        Route::get('/instagram',      [InstagramController::class,   'index'])->name('instagram');
        Route::get('/reservasi-ig',   [ReservasiIgController::class, 'index'])->name('reservasi-ig');
        Route::get('/landing',        [LandingController::class,     'index'])->name('landing');
        Route::post('/landing',       [LandingController::class,     'update']);
        Route::get('/pengaturan',     [PengaturanController::class,  'index'])->name('pengaturan');
        Route::post('/pengaturan',    [PengaturanController::class,  'update']);
    });

    // ── THERAPIST ────────────────────────────────────
    Route::middleware('role:THERAPIST,SUPER_ADMIN')
        ->prefix('therapist')->name('therapist.')->group(function () {
        Route::get('/jadwal',      [TherapistController::class, 'jadwal'])->name('jadwal');
        Route::get('/pasien',      [TherapistController::class, 'pasien'])->name('pasien');
        Route::get('/konsultasi',  [TherapistController::class, 'konsultasi'])->name('konsultasi');
        Route::get('/pendapatan',  [TherapistController::class, 'pendapatan'])->name('pendapatan');
        Route::get('/presensi',    [TherapistController::class, 'presensi'])->name('presensi');
        Route::post('/presensi',   [TherapistController::class, 'togglePresensi']);
        Route::post('/presensi/homecare/{bookingId}', [TherapistController::class, 'toggleHomecarePresensi']);
        Route::get('/sesi/{bookingId}', [TherapistController::class, 'sesi'])->name('sesi');
        Route::post('/sesi/{bookingId}',[TherapistController::class, 'updateSesi']);
    });
});
