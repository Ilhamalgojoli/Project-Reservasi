import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

let map = null;
let markersGroup = null;

window.initMapCreateUpdate = function () {
    const x = document.getElementById('lat');
    const y = document.getElementById('lng');

    if (!x || !y) return;

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

        x.dispatchEvent(new Event('input', { bubbles: true }));
        y.dispatchEvent(new Event('input', { bubbles: true }));
    });
}

window.initMap = function () {
    const x = document.getElementById('lat-map');
    const y = document.getElementById('lng-map');

    const lat = parseFloat(x.value);
    const lng = parseFloat(y.value);

    if (isNaN(lat) || isNaN(lng)) return;

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

    L.marker([lat, lng]).addTo(markersGroup);
}
