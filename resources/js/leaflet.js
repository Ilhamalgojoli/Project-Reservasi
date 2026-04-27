import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

let map = null;
let markersGroup = null;

document.addEventListener('livewire:navigating', () => {
    if (map !== null) {
        map.remove();
        map = null;
    }
});

window.initMapCreate = function () {
    const x = document.getElementById('lat');
    const y = document.getElementById('lng');
    const showLat = document.getElementById('show-lat');
    const showLng = document.getElementById('show-lng');

    if (!x || !y)
        return;

    if (map !== null) {
        map.remove();
    }

    map = L.map('map').setView([-6.973007, 107.630403], 20);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(() => {
        map.invalidateSize();
    }, 200);

    markersGroup = L.layerGroup().addTo(map);

    const MARKERS_MAX = 1;

    map.on('click', function (e) {

        if (markersGroup.getLayers().length >= MARKERS_MAX) {
            markersGroup.clearLayers();
        }

        L.marker(e.latlng).addTo(markersGroup);

        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        x.value = lat;
        y.value = lng;
        showLat.innerHTML = lat;
        showLng.innerHTML = lng;

        x.dispatchEvent(new Event('input', { bubbles: true }));
        y.dispatchEvent(new Event('input', { bubbles: true }));
    });
}

window.initMapUpdate = function () {
    const x = document.getElementById('lat');
    const y = document.getElementById('lng');
    const showLat = document.getElementById('show-lat');
    const showLng = document.getElementById('show-lng');

    if (!x || !y) return;

    if (map !== null) {
        map.remove();
    }

    const lat = parseFloat(x.value);
    const lng = parseFloat(y.value);

    console.log('lat', lat);
    console.log('lng', lng);

    map = L.map('map').setView([lat, lng], 20);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(() => {
        map.invalidateSize();
    }, 200);

    markersGroup = L.layerGroup().addTo(map);

    if (!isNaN(lat) && !isNaN(lng)) {
        L.marker([lat, lng]).addTo(markersGroup);
    }

    const MARKERS_MAX = 1;

    map.on('click', function (e) {

        if (markersGroup.getLayers().length >= MARKERS_MAX) {
            markersGroup.clearLayers();
        }

        L.marker(e.latlng).addTo(markersGroup);

        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        x.value = lat;
        y.value = lng;
        showLat.innerHTML = lat;
        showLng.innerHTML = lng;

        x.dispatchEvent(new Event('input', { bubbles: true }));
        y.dispatchEvent(new Event('input', { bubbles: true }));
    });
}

window.initMap = function (argLat = null, argLng = null) {
    let lat = parseFloat(argLat);
    let lng = parseFloat(argLng);

    // Fallback: baca dari hidden input jika argumen tidak valid
    if (isNaN(lat) || isNaN(lng)) {
        const x = document.getElementById('lat-map');
        const y = document.getElementById('lng-map');
        if (x && y) {
            lat = parseFloat(x.value);
            lng = parseFloat(y.value);
        }
    }

    if (isNaN(lat) || isNaN(lng)) return;

    if (map !== null) {
        map.remove();
    }

    map = L.map('map').setView([lat, lng], 20);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(() => {
        map.invalidateSize();
    }, 200);

    markersGroup = L.layerGroup().addTo(map);

    L.marker([lat, lng]).addTo(markersGroup);
}
