@extends("layouts.app")
@section("title","Pengaturan")
@section("page-title","Pengaturan Klinik")
@section("content")

<div class="page-header">
  <h4>Pengaturan Klinik</h4>
  <p class="page-sub">Informasi dan lokasi Sofia Baby Spa.</p>
</div>

<form method="POST" action="{{ route("owner.pengaturan") }}">
@csrf @method("PUT")
<div class="row g-4">

  {{-- Informasi Klinik --}}
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:building"></span>Informasi Klinik
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Nama Klinik</label>
            <input type="text" name="klinik_name" class="form-control"
                   value="{{ $settings["klinik_name"] ?? "" }}">
          </div>
          <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="klinik_address" class="form-control" rows="2">{{ $settings["klinik_address"] ?? "" }}</textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label">Telepon</label>
            <input type="text" name="klinik_phone" class="form-control"
                   value="{{ $settings["klinik_phone"] ?? "" }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="klinik_email" class="form-control"
                   value="{{ $settings["klinik_email"] ?? "" }}">
          </div>
          <div class="col-12">
            <label class="form-label">WhatsApp CS</label>
            <div class="input-group">
              <span class="input-group-text">
                <span class="iconify" data-icon="tabler:brand-whatsapp"></span>
              </span>
              <input type="text" name="klinik_wa" class="form-control"
                     value="{{ $settings["klinik_wa"] ?? "" }}" placeholder="628xxxxxxxxxx">
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="klinik_description" class="form-control" rows="3">{{ $settings["klinik_description"] ?? "" }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Lokasi --}}
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:map-pin"></span>Lokasi Klinik
      </div>
      <div class="card-body">
        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label">Latitude</label>
            <input type="text" name="klinik_latitude" id="lat" class="form-control form-control-sm"
                   value="{{ $settings["klinik_latitude"] ?? "" }}" placeholder="-7.123456">
          </div>
          <div class="col-6">
            <label class="form-label">Longitude</label>
            <input type="text" name="klinik_longitude" id="lng" class="form-control form-control-sm"
                   value="{{ $settings["klinik_longitude"] ?? "" }}" placeholder="110.123456">
          </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="gpsBtn">
          <span class="iconify me-1" data-icon="tabler:current-location"></span> Gunakan Lokasi Saya
        </button>
        <div id="map" style="height:260px;border-radius:.6rem;border:1px solid var(--border)"></div>
        @if(($settings["klinik_latitude"] ?? null) && ($settings["klinik_longitude"] ?? null))
        <a href="https://www.google.com/maps?q={{ $settings["klinik_latitude"] }},{{ $settings["klinik_longitude"] }}"
           target="_blank" class="btn btn-sm btn-outline-primary mt-2">
          <span class="iconify me-1" data-icon="tabler:map-2"></span> Lihat di Google Maps
        </a>
        @endif
      </div>
    </div>
  </div>

  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-pink">
      <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan Pengaturan
    </button>
  </div>
</div>
</form>

@if(in_array(auth()->user()->role, ["SUPER_ADMIN"]))
<div class="card mt-4">
  <div class="card-header">
    <span class="iconify me-2 text-primary" data-icon="tabler:shield-check"></span>Pengaturan RBAC
  </div>
  <div class="card-body">
    <p class="text-muted small mb-3">Kelola permission role secara dinamis dari database.</p>
    <a href="#" class="btn btn-sm btn-outline-primary">
      <span class="iconify me-1" data-icon="tabler:shield"></span> Kelola RBAC (coming soon)
    </a>
  </div>
</div>
@endif
@endsection

@push("styles")
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@push("scripts")
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const defaultLat = parseFloat(document.getElementById("lat").value) || -7.5755;
const defaultLng = parseFloat(document.getElementById("lng").value) || 110.8243;
const map = L.map("map").setView([defaultLat, defaultLng], 15);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap contributors"
}).addTo(map);
let marker = L.marker([defaultLat, defaultLng], {draggable:true}).addTo(map);
function updateInputs(lat, lng) {
  document.getElementById("lat").value = lat.toFixed(7);
  document.getElementById("lng").value = lng.toFixed(7);
}
marker.on("dragend", e => { const p = e.target.getLatLng(); updateInputs(p.lat, p.lng); });
map.on("click", e => { marker.setLatLng(e.latlng); updateInputs(e.latlng.lat, e.latlng.lng); });
["lat","lng"].forEach(id => {
  document.getElementById(id).addEventListener("change", () => {
    const lat = parseFloat(document.getElementById("lat").value);
    const lng = parseFloat(document.getElementById("lng").value);
    if (!isNaN(lat) && !isNaN(lng)) { marker.setLatLng([lat,lng]); map.setView([lat,lng],15); }
  });
});
document.getElementById("gpsBtn").addEventListener("click", () => {
  if (!navigator.geolocation) return alert("Geolocation tidak didukung browser ini.");
  navigator.geolocation.getCurrentPosition(pos => {
    const {latitude:lat, longitude:lng} = pos.coords;
    marker.setLatLng([lat,lng]); map.setView([lat,lng],17); updateInputs(lat,lng);
  }, () => alert("Gagal mendapatkan lokasi."));
});
</script>
@endpush
