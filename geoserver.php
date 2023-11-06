<!DOCTYPE html>
<html lang="en">

<head>
    <title>Leaflet Map with MySQL Data</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div id="map" style="height: 100vh;"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        /* Initial Map */
        var map = L.map('map').setView([-7.794760241050732, 110.36718249219427], 10); //lat, long, zoom
        /* Tile Basemap */
        var basemap1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="DIVSIG UGM" target="_blank">DIVSIG UGM</a>' //menambahkan nama//
        });
        var basemap2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{ z } / { y } / { x }',
            {
                attribution: 'Tiles &copy; Esri | <a href="Latihan WebGIS" target="_blank">DIVSIG UGM</a>'
            });
        var basemap3 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{ z } / { y } / { x }',
            {
                attribution: 'Tiles &copy; Esri | <a href="Lathan WebGIS" target="_blank">DIVSIG UGM</a>'
            });
        var basemap4 = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptile s.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
        });
        basemap1.addTo(map);

/* Control Layer */
var baseMaps = {
            "OpenStreetMap": basemap1,
            "Esri World Street": basemap2,
            "Esri Imagery": basemap3,
            "Stadia Dark Mode": basemap4
        };
        var overlayMaps = {
            // "Gedung B DIVSIG UGM": marker1,
            // "RS.Akademik UGM": marker2,
        };
        L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

        /* Scale Bar */
        L.control.scale({
            maxWidth: 150, position: 'bottomright'
        }).addTo(map); 


        var wfsgeoserver1 = L.geoJson(null, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {
                    icon: L.icon({
                        // iconUrl: "data:image/png;base64,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",
                        iconSize: [32, 32],
                        iconAnchor: [16, 32],
                        popupAnchor: [0, -32],
                        tooltipAnchor: [16, -20]
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                var content = "Kecamatan : " + feature.properties.kecamatan + "<br>" +
                    "Jumlah Penduduk : " + feature.properties.jumlah + "<br>" 
                    // "Telepon : " + feature.properties.telp +
                    // "<img src='data:image/png;base64,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" + feature.properties.photo + "' width='300'>";

                layer.on({
                    click: function (e) {
                        wfsgeoserver1.bindPopup(content);
                    },
                    mouseover: function (e) {
                        wfsgeoserver1.bindTooltip(feature.properties.kecamatan);
                    },
                    mouseout: function (e) {
                        wfsgeoserver1.closePopup();
                    }
                });
            }
        });

        $.getJSON("wfsgeoserver1.php", function (data) {
            wfsgeoserver1.addData(data);
            map.addLayer(wfsgeoserver1);
            // map.fitBounds(wfsgeoserver1.getBounds());
        });
        

        /* Control Layer */
        var baseMaps = {
            "OpenStreetMap": basemap1,
            "Esri World Street": basemap2,
            "Esri Imagery": basemap3,
            "Stadia Dark Mode": basemap4
        };

        var overlayMaps = {
            "Gedung B DIVSIG UGM": marker1,
            "RS.Akademik UGM": marker2,
        };

        L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

        /* Scale Bar */
        L.control.scale({
            maxWidth: 150, position: 'bottomright'
        }).addTo(map);

    </script>
</body>

</html>