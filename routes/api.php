<?php
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AnakController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\KonsultasiController;
use App\Http\Controllers\Api\V1\SesiController;
use App\Http\Controllers\Api\V1\TerapisController;
use App\Http\Controllers\Api\V1\LaporanController;
use App\Http\Controllers\Api\V1\OwnerController;
use App\Http\Controllers\Api\V1\WilayahController;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────
Route::prefix('v1')->group(function () {
    Route::post('auth/login',    [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::get('app/version',    fn() => response()->json(['version_code' => 0]));

    // ── Authenticated ────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {
        // Me
        Route::get('me',             [AuthController::class, 'me']);
        Route::put('me',             [AuthController::class, 'updateMe']);
        Route::post('me/fcm-token',  [AuthController::class, 'updateFcmToken']);

        // Anak
        Route::apiResource('anak', AnakController::class)->only(['index','store','show','update']);
        Route::get('anak/{id}/growth',    [AnakController::class, 'growth']);
        Route::get('anak/{id}/milestone', [AnakController::class, 'milestones']);
        Route::get('anak/{id}/exercise',  [AnakController::class, 'exercises']);
        Route::get('anak/{id}/ringkasan', [AnakController::class, 'ringkasan']);

        // Booking
        Route::get('booking',              [BookingController::class, 'index']);
        Route::post('booking',             [BookingController::class, 'store']);
        Route::post('booking/walk-in',     [BookingController::class, 'walkIn']);
        Route::post('booking/{id}/homecare', [BookingController::class, 'homecarePresence']);

        // Sesi
        Route::get('sesi/{bookingId}',         [SesiController::class, 'show']);
        Route::post('sesi/{bookingId}',        [SesiController::class, 'upsert']);
        Route::post('sesi/{bookingId}/media',  [SesiController::class, 'storeMedia']);

        // Konsultasi
        Route::get('konsultasi',                    [KonsultasiController::class, 'index']);
        Route::post('konsultasi',                   [KonsultasiController::class, 'store']);
        Route::get('konsultasi/{id}/messages',      [KonsultasiController::class, 'messages']);
        Route::post('konsultasi/{id}/messages',     [KonsultasiController::class, 'sendMessage']);
        Route::post('konsultasi/{id}/claim',        [KonsultasiController::class, 'claim']);
        Route::post('konsultasi/{id}/close',        [KonsultasiController::class, 'close']);
        Route::post('konsultasi/{id}/read',         [KonsultasiController::class, 'markRead']);

        // Terapis
        Route::get('therapist/jadwal',     [TerapisController::class, 'jadwal']);
        Route::get('therapist/pasien',     [TerapisController::class, 'pasien']);
        Route::get('therapist/pendapatan', [TerapisController::class, 'pendapatan']);
        Route::post('attendance',          [TerapisController::class, 'presensi']);

        // Laporan
        Route::middleware('role:OWNER,ADMIN,SUPER_ADMIN,DIREKTUR')->group(function () {
            Route::get('laporan/pendapatan', [LaporanController::class, 'pendapatan']);
            Route::get('laporan/advanced',   [LaporanController::class, 'advanced']);
            Route::get('laporan/pembukuan',  [LaporanController::class, 'pembukuan']);
            Route::get('laporan/pajak',      [LaporanController::class, 'pajak']);
            Route::get('laporan/referral',   [LaporanController::class, 'referral']);
        });

        // Owner ops
        Route::middleware('role:OWNER,ADMIN,SUPER_ADMIN')->group(function () {
            Route::post('owner/staff',                       [OwnerController::class, 'storeStaff']);
            Route::get('owner/patients',                     [OwnerController::class, 'patients']);
            Route::post('owner/patients/{id}/reset-password',[OwnerController::class, 'resetPatientPassword']);
            Route::post('owner/payroll/generate',            [OwnerController::class, 'generatePayroll']);
            Route::post('owner/payroll/{id}/finalize',       [OwnerController::class, 'finalizePayroll']);
            Route::get('owner/payroll/rates',                [OwnerController::class, 'payrollRates']);
            Route::post('owner/therapist-active',            [OwnerController::class, 'storeTherapistActive']);
            Route::get('owner/reservasi-ig',                 [OwnerController::class, 'reservasiIg']);
            Route::get('owner/hours',                        [OwnerController::class, 'hours']);
        });

        Route::get('dashboard/pusat', [OwnerController::class, 'dashboardPusat']);

        // Wilayah proxy
        Route::get('wilayah/provinces',            [WilayahController::class, 'provinces']);
        Route::get('wilayah/regencies/{code}',     [WilayahController::class, 'regencies']);
        Route::get('wilayah/districts/{code}',     [WilayahController::class, 'districts']);
        Route::get('wilayah/villages/{code}',      [WilayahController::class, 'villages']);

        // Layanan + Branch + Wilayah (public read)
        Route::get('layanan',  fn() => response()->json(\App\Models\Service::where('is_active',true)->get()));
        Route::get('branch',   fn() => response()->json(\App\Models\Branch::where('is_active',true)->get()));
        Route::get('terapis',  fn() => response()->json(\App\Models\User::where('role','THERAPIST')->where('is_active',true)->with('therapistProfile')->get()));
        Route::get('honor',    fn() => response()->json(\App\Models\Payslip::with('therapist','period')->paginate(20)));
    });
});
