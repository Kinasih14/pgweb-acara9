<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet JS</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
    
    <style>
    html, body, #map {
        height: 100%;
        width: 100%;
        margin: 0px;
    }
    </style>
</head>
<body>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
    <div id="map"></div>

    <script>
        /* Initial Map */ 
        var map = L.map('map').setView([-7.77, 110.37], 14); //lat, long, zoom
        
        /* Define Basemaps */
        var basemap1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="DIVSIG UGM" target="_blank">DIVSIG UGM</a>'
        });

        var basemap2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri | <a href="Latihan WebGIS" target="_blank">DIVSIG UGM</a>'
        });

        var basemap3 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri | <a href="Lathan WebGIS" target="_blank">DIVSIG UGM</a>'
        });

        var basemap4 = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
        });
        
        // Add Basemaps to Layer Control
        var baseMaps = {
            "OpenStreetMap": basemap1,
            "Esri World Street": basemap2,
            "Esri Imagery": basemap3,
            "Stadia Dark Mode": basemap4
        };

        // Add Layer Control to Map
        L.control.layers(baseMaps).addTo(map);

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pgweb-acara8";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM kec_sleman";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $lat = $row["Latitude"];
                $long = $row["Longtitude"];
                $info = $row["Kecamatan"];
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('$info');";
            }
        }
        else {
            echo "0 results";
        }

        $conn->close();
        ?>


    </script>
</body>
</html>
