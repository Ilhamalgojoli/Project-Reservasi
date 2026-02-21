document.addEventListener("DOMContentLoaded", () => {
    var x = document.getElementById('lat');
    var y = document.getElementById('lng');

    document.querySelectorAll("[data-popup-target]").forEach(btn => {
        btn.addEventListener("click", () => {
            const popupId = btn.dataset.popupTarget;
            const popup = document.getElementById(popupId);

            if (popup) {
                popup.classList.remove("hidden");
            }

            x.innerHTML = '';
            y.innerHTML = '';

            var map = L.map('map-tambah').setView([-6.973007, 107.630403], 20);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            setTimeout(() => {
                map.invalidateSize();
            }, 200);

            var markersGroup = L.layerGroup();
            map.addLayer(markersGroup);
            var MARKERS_MAX = 1;

            map.on('click', function (e) {
                var markersCount = markersGroup.getLayers().length;

                if (markersCount < MARKERS_MAX) {
                    L.marker(e.latlng).addTo(markersGroup);
                    lat = e.latlng.lat;
                    lng = e.latlng.lng;
                    x.innerHTML = lat;
                    y.innerHTML = lng;

                    return;
                }

                markersGroup.clearLayers();
            });
        });
    });

    document.querySelectorAll(".popup-close").forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            btn.closest(".popup").classList.add("hidden");
            console.log("click");

            console.log(window.wrappers);
        });
    });

    document.querySelectorAll(".popup").forEach(popup => {
        popup.addEventListener("click", (e) => {
            if (e.target === popup) {
                popup.classList.add("hidden");
            }
        });
    });
});
