<?php
// Leer el archivo JSON
$jsonData = file_get_contents('locations.json');

// Decodificar el JSON en un array asociativo
$places = json_decode($jsonData, true);

// Verificar si la decodificación fue exitosa
if ($places === null) {
    die("Error al decodificar el archivo JSON.");
}

// Obtener los datos del primer lugar
$firstPlace = $places['place'][0];
$img = $firstPlace['img'];
$name = $firstPlace['name'];
$description = $firstPlace['description'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geolocalizacion</title>
    <!-- Incluye el script de MarkerClusterer desde un CDN -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@googlemaps/markerclusterer@2.1.2/dist/markerclusterer.js"></script> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script>
        // Obtener las coordenadas lat y lng del primer lugar del JSON
        var initialLat = <?php echo $places['place'][0]['lat']; ?>;
        var initialLng = <?php echo $places['place'][0]['lon']; ?>;
    </script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    <script type="module" src="./map.js"></script>
</head>

<body>

    <header>
        <!-- Header -->
        <nav class="navbar bg-body-tertiary">

            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">LOCALIDADES</span>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Columna para la tarjeta -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <img src="<?php echo $img; ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $name; ?>
                        </h5>
                        <p class="card-text">
                            <?php echo $description; ?>
                        </p>
                        <button type="button" id="cambiarInfo" class="btn btn-primary">Cambiar la ubicación</button>
                    </div>
                </div>
            </div>
            <!-- Columna para el mapa -->
            <div class="col-12 col-md-8 col-sm-">
                <!-- El div que contendrá el mapa -->
                <div id="map"></div>
            </div>
        </div>
    </div>

    <!-- GOOGLE MAPS API URL-->
    <script>(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
            ({ key: "AIzaSyCp1GHx7r5x2HOHdckpcZeUjBZ7QUyMCoc", v: "beta" });
    </script>
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp1GHx7r5x2HOHdckpcZeUjBZ7QUyMCoc&callback=initMap&v=weekly"
      defer
    ></script> -->

    <script>
        var initialLat = <?php echo $places['place'][0]['lat']; ?>;
        var initialLng = <?php echo $places['place'][0]['lon']; ?>;

        var places = <?php echo json_encode($places['place']); ?>;
        var currentIndex = 0;

        function actualizarInformacion() {
            var placeJust = places[currentIndex];
            document.querySelector('.card-img-top').src = placeJust.img;
            document.querySelector('.card-title').textContent = placeJust.name;
            document.querySelector('.card-text').textContent = placeJust.description;
        }

        actualizarInformacion();
    </script>
</body>

</html>