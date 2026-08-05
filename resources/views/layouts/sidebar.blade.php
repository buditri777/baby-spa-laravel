@php $role = auth()->user()?->role; @endphp

{{-- Dashboard --}}
<li class="menu-header small text-uppercase"><span class="menu-header-text">Menu Utama</span></li>
<li class="menu-item {{ request()->is('parent/dashboard') || request()->is('owner/dashboard') || request()->is('therapist/jadwal') || request()->is('dashboard') ? 'active' : '' }}">
  <a href="{{ $role === 'PARENT' ? route('parent.dashboard') : ($role === 'THERAPIST' ? route('therapist.jadwal') : route('owner.dashboard')) }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:home"></span></span>
    <div class="menu-text">Dashboard</div>
  </a>
</li>

@if(in_array($role, ['PARENT']))
<li class="menu-header small text-uppercase"><span class="menu-header-text">Anak & Booking</span></li>
<li class="menu-item {{ request()->is('parent/anak*') ? 'active' : '' }}">
  <a href="{{ route('parent.anak.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:baby-carriage"></span></span>
    <div class="menu-text">Data Anak</div>
  </a>
</li>
<li class="menu-item {{ request()->is('parent/booking*') ? 'active' : '' }}">
  <a href="{{ route('parent.booking.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:calendar-check"></span></span>
    <div class="menu-text">Booking Saya</div>
  </a>
</li>
<li class="menu-item {{ request()->is('parent/jadwal') ? 'active' : '' }}">
  <a href="{{ route('parent.jadwal') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:calendar"></span></span>
    <div class="menu-text">Jadwal</div>
  </a>
</li>
<li class="menu-item {{ request()->is('parent/konsultasi*') ? 'active' : '' }}">
  <a href="{{ route('parent.konsultasi.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:message-circle"></span></span>
    <div class="menu-text">Tanya Terapis</div>
  </a>
</li>
@endif

@if(in_array($role, ['THERAPIST']))
<li class="menu-header small text-uppercase"><span class="menu-header-text">Terapis</span></li>
<li class="menu-item {{ request()->is('therapist/jadwal') ? 'active' : '' }}">
  <a href="{{ route('therapist.jadwal') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:calendar"></span></span>
    <div class="menu-text">Jadwal</div>
  </a>
</li>
<li class="menu-item {{ request()->is('therapist/pasien') ? 'active' : '' }}">
  <a href="{{ route('therapist.pasien') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:user"></span></span>
    <div class="menu-text">Pasien Saya</div>
  </a>
</li>
<li class="menu-item {{ request()->is('therapist/konsultasi') ? 'active' : '' }}">
  <a href="{{ route('therapist.konsultasi') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:message-dots"></span></span>
    <div class="menu-text">Konsultasi</div>
  </a>
</li>
<li class="menu-item {{ request()->is('therapist/presensi') ? 'active' : '' }}">
  <a href="{{ route('therapist.presensi') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:fingerprint"></span></span>
    <div class="menu-text">Presensi</div>
  </a>
</li>
<li class="menu-item {{ request()->is('therapist/pendapatan') ? 'active' : '' }}">
  <a href="{{ route('therapist.pendapatan') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:moneybag"></span></span>
    <div class="menu-text">Pendapatan</div>
  </a>
</li>
@endif

@if(in_array($role, ['OWNER','ADMIN','SUPER_ADMIN','DIREKTUR','RECEPTIONIST']))
<li class="menu-header small text-uppercase"><span class="menu-header-text">Operasional</span></li>
<li class="menu-item {{ request()->is('owner/dashboard') ? 'active' : '' }}">
  <a href="{{ route('owner.dashboard') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:layout-dashboard"></span></span>
    <div class="menu-text">Dasbor Utama</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/booking*') ? 'active' : '' }}">
  <a href="{{ route('owner.booking.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:calendar-check"></span></span>
    <div class="menu-text">Booking</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/walk-in*') ? 'active' : '' }}">
  <a href="{{ route('owner.walk-in.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:walk"></span></span>
    <div class="menu-text">Walk-in</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/calendar') ? 'active' : '' }}">
  <a href="{{ route('owner.calendar') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:calendar-event"></span></span>
    <div class="menu-text">Kalender</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/pasien*') ? 'active' : '' }}">
  <a href="{{ route('owner.pasien.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:users"></span></span>
    <div class="menu-text">Pasien</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/konsultasi') ? 'active' : '' }}">
  <a href="{{ route('owner.konsultasi') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:message-dots"></span></span>
    <div class="menu-text">Konsultasi</div>
  </a>
</li>

<li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen</span></li>
<li class="menu-item {{ request()->is('owner/terapis*') ? 'active' : '' }}">
  <a href="{{ route('owner.terapis.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:user-check"></span></span>
    <div class="menu-text">Terapis</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/jadwal-terapis') ? 'active' : '' }}">
  <a href="{{ route('owner.jadwal-terapis') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:clock"></span></span>
    <div class="menu-text">Jadwal Terapis</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/staf*') ? 'active' : '' }}">
  <a href="{{ route('owner.staf.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:id-badge-2"></span></span>
    <div class="menu-text">Staf</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/layanan*') ? 'active' : '' }}">
  <a href="{{ route('owner.layanan.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:spa"></span></span>
    <div class="menu-text">Layanan</div>
  </a>
</li>

@if(in_array($role, ['OWNER','ADMIN','SUPER_ADMIN']))
<li class="menu-item {{ request()->is('owner/pengeluaran*') ? 'active' : '' }}">
  <a href="{{ route('owner.pengeluaran.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:receipt"></span></span>
    <div class="menu-text">Pengeluaran</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/penggajian*') ? 'active' : '' }}">
  <a href="{{ route('owner.penggajian.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:cash"></span></span>
    <div class="menu-text">Penggajian</div>
  </a>
</li>

<li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>
<li class="menu-item {{ request()->is('owner/laporan/pendapatan') ? 'active' : '' }}">
  <a href="{{ route('owner.laporan.pendapatan') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:chart-line"></span></span>
    <div class="menu-text">Pendapatan</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/laporan/pembukuan') ? 'active' : '' }}">
  <a href="{{ route('owner.laporan.pembukuan') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:book"></span></span>
    <div class="menu-text">Pembukuan</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/laporan/pajak') ? 'active' : '' }}">
  <a href="{{ route('owner.laporan.pajak') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:file-invoice"></span></span>
    <div class="menu-text">Pajak</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/laporan/referral') ? 'active' : '' }}">
  <a href="{{ route('owner.laporan.referral') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:share"></span></span>
    <div class="menu-text">Referral</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/honor') ? 'active' : '' }}">
  <a href="{{ route('owner.honor') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:award"></span></span>
    <div class="menu-text">Honor Terapis</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/pusat') ? 'active' : '' }}">
  <a href="{{ route('owner.pusat') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:building"></span></span>
    <div class="menu-text">Dasbor Pusat</div>
  </a>
</li>

<li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
<li class="menu-item {{ request()->is('owner/cabang*') ? 'active' : '' }}">
  <a href="{{ route('owner.cabang.index') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:map-pin"></span></span>
    <div class="menu-text">Cabang</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/instagram') ? 'active' : '' }}">
  <a href="{{ route('owner.instagram') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:brand-instagram"></span></span>
    <div class="menu-text">Instagram</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/reservasi-ig') ? 'active' : '' }}">
  <a href="{{ route('owner.reservasi-ig') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:bookmark"></span></span>
    <div class="menu-text">Reservasi IG</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/landing') ? 'active' : '' }}">
  <a href="{{ route('owner.landing') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:device-desktop"></span></span>
    <div class="menu-text">Landing Page</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/audit') ? 'active' : '' }}">
  <a href="{{ route('owner.audit') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:list-check"></span></span>
    <div class="menu-text">Audit Log</div>
  </a>
</li>
<li class="menu-item {{ request()->is('owner/pengaturan') ? 'active' : '' }}">
  <a href="{{ route('owner.pengaturan') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:settings"></span></span>
    <div class="menu-text">Pengaturan</div>
  </a>
</li>
@endif {{-- OWNER/ADMIN/SUPER_ADMIN --}}
@endif {{-- Operational roles --}}

<li class="menu-header small text-uppercase"><span class="menu-header-text">Akun</span></li>
<li class="menu-item {{ request()->is('akun') ? 'active' : '' }}">
  <a href="{{ route('akun') }}" class="menu-link">
    <span class="menu-icon"><span class="iconify" data-icon="tabler:user-circle"></span></span>
    <div class="menu-text">Profil Saya</div>
  </a>
</li>
