@extends("layouts.app")
@section("title","Pengaturan")
@section("page-title","Pengaturan Klinik")
@section("content")
<form method="POST" action="{{ route("owner.pengaturan") }}">
@csrf @method("PUT")
<div class="row g-3">
  <div class="col-md-6">
    <div class="card shadow-sm h-100">
      <div class="card-header bg-white fw-semibold">Informasi Klinik</div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-12"><label class="form-label">Nama Klinik</label>
            <input type="text" name="klinik_name" class="form-control" value="{{ $settings["klinik_name"] ?? "" }}"></div>
          <div class="col-12"><label class="form-label">Alamat</label>
            <textarea name="klinik_address" class="form-control" rows="2">{{ $settings["klinik_address"] ?? "" }}</textarea></div>
          <div class="col-md-6"><label class="form-label">Telepon</label>
            <input type="text" name="klinik_phone" class="form-control" value="{{ $settings["klinik_phone"] ?? "" }}"></div>
          <div class="col-md-6"><label class="form-label">Email</label>
            <input type="email" name="klinik_email" class="form-control" value="{{ $settings["klinik_email"] ?? "" }}"></div>
          <div class="col-12"><label class="form-label">WhatsApp CS</label>
            <input type="text" name="klinik_wa" class="form-control" value="{{ $settings["klinik_wa"] ?? "" }}" placeholder="628xxxxxxxxxx"></div>
          <div class="col-12"><label class="form-label">Deskripsi</label>
            <textarea name="klinik_description" class="form-control" rows="3">{{ $settings["klinik_description"] ?? "" }}</textarea></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm h-100">
      <div class="card-header bg-white fw-semibold">Lokasi Klinik (OpenStreetMap)</div>
      <div class="card-body">
        <div class="row g-2 mb-2">
          <div class="col-6"><label class="form-label small">Latitude</label>
            <input type="text" name="klinik_latitude" id="lat" class="form-control form-control-sm" value="{{ $settings["klinik_latitude"] ?? "" }}" placeholder="-7.123456"></div>
          <div class="col-6"><label class="form-label small">Longitude</label>
            <input type="text" name="klinik_longitude" id="lng" class="form-control form-control-sm" value="{{ $settings["klinik_longitude"] ?? "" }}" placeholder="110.123456"></div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mb-2" id="gpsBtn"><i class="bx bx-current-location"></i> Gunakan Lokasi Saya</button>
        <div id="map" style="height:280px;border-radius:.5rem;border:1px solid #dee2e6"></div>
        @if(($settings["klinik_latitude"] ?? null) && ($settings["klinik_longitude"] ?? null))
        <a href="https://www.google.com/maps?q={{ $settings["klinik_latitude"] }},{{ $settings["klinik_longitude"] }}" target="_blank" class="btn btn-sm btn-outline-info mt-2"><i class="bx bx-map-alt"></i> Lihat di Google Maps</a>
        @endif
      </div>
    </div>
  </div>
  <div class="col-12 d-flex gap-2 justify-content-end">
    <button type="submit" class="btn btn-pink"><i class="bx bx-save"></i> Simpan Pengaturan</button>
  </div>
</div>
</form>

@if(in_array(auth()->user()->role, ["SUPER_ADMIN"]))
<div class="card shadow-sm mt-3">
  <div class="card-header bg-white fw-semibold">Pengaturan RBAC</div>
  <div class="card-body">
    <p class="text-muted small mb-2">Kelola permission role secara dinamis dari database.</p>
    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bx bx-shield"></i> Kelola RBAC (coming soon)</a>
  </div>
</div>
@endif
@endsection

@push("styles")
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>
@endpush

@push("scripts")
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const defaultLat = parseFloat(document.getElementById("lat").value) || -7.5755;
const defaultLng = parseFloat(document.getElementById("lng").value) || 110.8243;
const map    = L.map("map").setView([defaultLat, defaultLng], 15);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap contributors"
}).addTo(map);
let marker = L.marker([defaultLat, defaultLng], {draggable:true}).addTo(map);
function updateInputs(lat, lng) {
  document.getElementById("lat").value = lat.toFixed(7);
  document.getElementById("lng").value = lng.toFixed(7);
}
marker.on("dragend", e => {
  const p = e.target.getLatLng();
  updateInputs(p.lat, p.lng);
});
map.on("click", e => {
  marker.setLatLng(e.latlng);
  updateInputs(e.latlng.lat, e.latlng.lng);
});
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
