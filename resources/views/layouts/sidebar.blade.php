@php $role = auth()->user()?->role; @endphp

{{-- Dashboard --}}
<li class="menu-header">Menu Utama</li>
<li class="menu-item">
  <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <i class='bx bx-home-circle'></i> Dashboard
  </a>
</li>

@if(in_array($role, ['PARENT']))
<li class="menu-header">Anak & Booking</li>
<li class="menu-item">
  <a href="{{ route('anak.index') }}" class="{{ request()->is('anak*') ? 'active' : '' }}">
    <i class='bx bx-child'></i> Data Anak
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('booking.create') }}" class="{{ request()->is('booking*') ? 'active' : '' }}">
    <i class='bx bx-calendar-plus'></i> Buat Booking
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('konsultasi.index') }}" class="{{ request()->is('konsultasi*') ? 'active' : '' }}">
    <i class='bx bx-chat'></i> Tanya Terapis
  </a>
</li>
@endif

@if(in_array($role, ['THERAPIST']))
<li class="menu-header">Terapis</li>
<li class="menu-item">
  <a href="{{ route('therapist.jadwal') }}" class="{{ request()->is('therapist/jadwal') ? 'active' : '' }}">
    <i class='bx bx-calendar'></i> Jadwal
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('therapist.pasien') }}" class="{{ request()->is('therapist/pasien') ? 'active' : '' }}">
    <i class='bx bx-user'></i> Pasien Saya
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('therapist.konsultasi') }}" class="{{ request()->is('therapist/konsultasi') ? 'active' : '' }}">
    <i class='bx bx-chat'></i> Konsultasi
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('therapist.presensi') }}" class="{{ request()->is('therapist/presensi') ? 'active' : '' }}">
    <i class='bx bx-fingerprint'></i> Presensi
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('therapist.pendapatan') }}" class="{{ request()->is('therapist/pendapatan') ? 'active' : '' }}">
    <i class='bx bx-money'></i> Pendapatan
  </a>
</li>
@endif

@if(in_array($role, ['OWNER','ADMIN','SUPER_ADMIN','DIREKTUR','RECEPTIONIST']))
<li class="menu-header">Operasional</li>
<li class="menu-item">
  <a href="{{ route('owner.dashboard') }}" class="{{ request()->is('owner/dashboard') ? 'active' : '' }}">
    <i class='bx bx-grid-alt'></i> Dasbor Utama
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.booking.index') }}" class="{{ request()->is('owner/booking*') ? 'active' : '' }}">
    <i class='bx bx-calendar-check'></i> Booking
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.walk-in.index') }}" class="{{ request()->is('owner/walk-in*') ? 'active' : '' }}">
    <i class='bx bx-walk'></i> Walk-in
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.calendar') }}" class="{{ request()->is('owner/calendar') ? 'active' : '' }}">
    <i class='bx bx-calendar'></i> Kalender
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.pasien.index') }}" class="{{ request()->is('owner/pasien*') ? 'active' : '' }}">
    <i class='bx bx-group'></i> Pasien
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.konsultasi') }}" class="{{ request()->is('owner/konsultasi') ? 'active' : '' }}">
    <i class='bx bx-message-square-dots'></i> Konsultasi
  </a>
</li>
<li class="menu-header">Manajemen</li>
<li class="menu-item">
  <a href="{{ route('owner.terapis.index') }}" class="{{ request()->is('owner/terapis*') ? 'active' : '' }}">
    <i class='bx bx-user-check'></i> Terapis
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.jadwal-terapis') }}" class="{{ request()->is('owner/jadwal-terapis') ? 'active' : '' }}">
    <i class='bx bx-time'></i> Jadwal Terapis
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.staf.index') }}" class="{{ request()->is('owner/staf*') ? 'active' : '' }}">
    <i class='bx bx-id-card'></i> Staf
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.layanan.index') }}" class="{{ request()->is('owner/layanan*') ? 'active' : '' }}">
    <i class='bx bx-spa'></i> Layanan
  </a>
</li>
@if(in_array($role, ['OWNER','ADMIN','SUPER_ADMIN']))
<li class="menu-item">
  <a href="{{ route('owner.pengeluaran.index') }}" class="{{ request()->is('owner/pengeluaran*') ? 'active' : '' }}">
    <i class='bx bx-receipt'></i> Pengeluaran
  </a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.penggajian.index') }}" class="{{ request()->is('owner/penggajian*') ? 'active' : '' }}">
    <i class='bx bx-money-withdraw'></i> Penggajian
  </a>
</li>
<li class="menu-header">Laporan</li>
<li class="menu-item">
  <a href="{{ route('owner.laporan.pendapatan') }}"><i class='bx bx-line-chart'></i> Pendapatan</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.laporan.pembukuan') }}"><i class='bx bx-book'></i> Pembukuan</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.laporan.pajak') }}"><i class='bx bx-file'></i> Pajak</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.laporan.referral') }}"><i class='bx bx-share-alt'></i> Referral</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.honor') }}"><i class='bx bx-award'></i> Honor Terapis</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.pusat') }}"><i class='bx bx-building'></i> Dasbor Pusat</a>
</li>
<li class="menu-header">Pengaturan</li>
<li class="menu-item">
  <a href="{{ route('owner.cabang.index') }}"><i class='bx bx-map'></i> Cabang</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.instagram') }}"><i class='bx bxl-instagram'></i> Instagram</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.reservasi-ig') }}"><i class='bx bx-bookmark'></i> Reservasi IG</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.landing') }}"><i class='bx bx-desktop'></i> Landing Page</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.audit') }}"><i class='bx bx-list-check'></i> Audit Log</a>
</li>
<li class="menu-item">
  <a href="{{ route('owner.pengaturan') }}"><i class='bx bx-cog'></i> Pengaturan</a>
</li>
@endif
@endif

<li class="menu-header">Akun</li>
<li class="menu-item">
  <a href="{{ route('akun') }}"><i class='bx bx-user-circle'></i> Profil Saya</a>
</li>
