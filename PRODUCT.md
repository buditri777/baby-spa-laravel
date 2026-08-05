# Product

## Register

product

## Purpose

Dashboard operasional Sofia Baby Spa — manajemen booking, terapis, pasien, penggajian, laporan, dan konsultasi. Dipakai oleh owner, admin, resepsionis, direktur, terapis, dan orang tua pasien.

## Users

- **Owner / Admin / Direktur / Resepsionis**: staf klinik baby spa. Bekerja di meja atau tablet saat shift. Task utama: lihat booking hari ini, kelola jadwal terapis, input data, cetak laporan.
- **Terapis**: melihat jadwal harian, input presensi, catat sesi pasien, lihat pendapatan.
- **Orang tua (Parent)**: booking layanan, lihat tumbuh kembang anak, konsultasi dengan terapis.

## Brand Personality

Profesional, hangat, modern.

- Profesional: informasi jelas, hierarki visual kuat, tidak berantakan.
- Hangat: warna rose/pink klinik yang sudah ada dipertahankan — bukan dingin/korporat.
- Modern: tipografi bersih, spacing konsisten, tidak terasa lawas.

## Anti-References

- Jangan seperti admin panel generik Bootstrap plain (abu-abu semua, flat total).
- Jangan terlalu gelap atau terlalu "tech startup SaaS".
- Jangan ramai / dekoratif — ini tool kerja, bukan landing page.
- Jangan seperti sistem informasi rumah sakit tahun 2010.

## Design Principles

1. **Tool disappears into the task** — UI tidak menyita perhatian; staf bisa fokus pada data.
2. **Warm but credible** — pink brand dipakai purposeful (aksi utama, status, sidebar aktif), bukan dekorasi.
3. **Consistent vocabulary** — button, badge, tabel, form: satu gaya di semua halaman.
4. **Density when needed** — tabel padat OK; white space untuk heading/section, bukan per-row.

## Accessibility

- WCAG AA minimum (4.5:1 body text, 3:1 large text).
- Keyboard navigable form controls.
- Badge status harus tidak hanya mengandalkan warna (tambah label teks).

## Tech Stack

- Laravel Blade + Sneat Bootstrap template
- Brand color: `#e83e8c` (rose pink)
- Font: Public Sans
- Icons: Iconify (Tabler icons)
