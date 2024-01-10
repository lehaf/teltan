<?php
/** @var array $mapArray */
/** @var array $mapArrayVip */
?>
<script>
     window.mapInit = function ()
    {
        // MAPS START
        mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';
        let mapCoordinate = [34.886226654052734, 31.95340028021316]; //default coordinate map
        const simpleAdsPoints = <?=json_encode($mapArray)?>;
        const vipAdsPoints = <?=json_encode($mapArrayVip)?>; // vip**

        // МИНИКАРТА В ДЕТАЛКЕ
        if ($('#mapMini').length > 0) {
            // Центрируем карту по метке
            const markCoordinates = simpleAdsPoints !== null ?
                simpleAdsPoints.features[0].geometry.coordinates : vipAdsPoints.features[0].geometry.coordinates;

            const map = new mapboxgl.Map({
                container: 'mapMini',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: markCoordinates,
                zoom: 7
            });

            map.on('load', () => {

                map.addSource('earthquakes', {
                    type: 'geojson',
                    data: simpleAdsPoints,
                    cluster: false,
                });

                map.addSource('vipPoint', {
                    type: 'geojson',
                    data: vipAdsPoints,
                    cluster: false,
                });

                map.addLayer({
                    id: 'unclustered-point',
                    type: 'circle',
                    source: 'earthquakes',
                    filter: ['!', ['has', 'point_count']],
                    paint: {
                        'circle-color': '#73b387',
                        'circle-radius': 5,
                        'circle-stroke-width': 1,
                        'circle-stroke-color': '#fff',
                    }
                });

                map.addLayer({
                    id: 'unclustered-vipPoint',
                    type: 'circle',
                    source: 'vipPoint',
                    filter: ['!', ['has', 'point_count']],
                    paint: {
                        'circle-color': '#FF5900',
                        'circle-radius': 5,
                        'circle-stroke-width': 1,
                        'circle-stroke-color': '#fff',
                    }
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: true
                });

                map.on('mouseenter', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                });

                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                });

                // Простые объявления
                map.on('mouseenter', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = '';
                    if (popup) popup.remove();
                });

                map.on('mouseover', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = `
                    <div class="d-flex popup-content">
                      <div class="w-75 pr-3">
                        <img src="${e.features[0].properties.image}">
                      </div>

                      <div class="d-flex flex-column text-right">
                        <span class="font-weight-bold">${e.features[0].properties.title}</span>
                        <p class="p-0 text-primary font-weight-bold">${e.features[0].properties.price}</p>
                      </div>
                    </div>`;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });

                // VIP объявления
                map.on('mouseenter', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = '';
                    if (popup) popup.remove();
                });

                map.on('mouseover', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = `
                    <div class="d-flex popup-content">
                      <div class="w-75 pr-3">
                        <img src="${e.features[0].properties.image}">
                      </div>

                      <div class="d-flex flex-column text-right">
                        <span class="font-weight-bold">${e.features[0].properties.title}</span>
                        <p class="p-0 text-primary font-weight-bold">${e.features[0].properties.price}</p>
                      </div>
                    </div>`;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });
            });

        }

        if ($('#mapFullSize').length > 0) {

            // Центрируем карту по метке
            const markCoordinates = simpleAdsPoints !== null ?
                simpleAdsPoints.features[0].geometry.coordinates : vipAdsPoints.features[0].geometry.coordinates;

            const map = new mapboxgl.Map({
                container: 'mapFullSize',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: markCoordinates,
                zoom: 7
            });

            map.on('load', () => {

                map.addSource('earthquakes', {
                    type: 'geojson',
                    data: simpleAdsPoints,
                    cluster: false,
                });

                map.addSource('vipPoint', {
                    type: 'geojson',
                    data: vipAdsPoints,
                    cluster: false,
                });

                map.addLayer({
                    id: 'unclustered-point',
                    type: 'circle',
                    source: 'earthquakes',
                    filter: ['!', ['has', 'point_count']],
                    paint: {
                        'circle-color': '#73b387',
                        'circle-radius': 5,
                        'circle-stroke-width': 1,
                        'circle-stroke-color': '#fff',
                    }
                });

                map.addLayer({
                    id: 'unclustered-vipPoint',
                    type: 'circle',
                    source: 'vipPoint',
                    filter: ['!', ['has', 'point_count']],
                    paint: {
                        'circle-color': '#FF5900',
                        'circle-radius': 5,
                        'circle-stroke-width': 1,
                        'circle-stroke-color': '#fff',
                    }
                });

                map.on('mouseenter', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                });
                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                });

                map.on('mouseenter', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });
                map.on('mouseleave', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = '';
                });
                map.on('mouseenter', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = '';
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: true
                });

                map.on('click', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = `
                    <div class="d-flex popup-content">
                      <div class="w-75 pr-3">
                        <img src="${e.features[0].properties.image}">
                      </div>

                      <div class="d-flex flex-column text-right">
                        <span class="font-weight-bold">${e.features[0].properties.title}</span>
                        <p class="p-0 text-primary font-weight-bold">${e.features[0].properties.price}</p>
                      </div>
                    </div>`;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });

                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = `
                    <div class="d-flex popup-content">
                      <div class="w-75 pr-3">
                        <img src="${e.features[0].properties.image}">
                      </div>

                      <div class="d-flex flex-column text-right">
                        <span class="font-weight-bold">${e.features[0].properties.title}</span>
                        <p class="p-0 text-primary font-weight-bold">${e.features[0].properties.price}</p>
                      </div>
                    </div>`;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });
            });

            $("#itemMapFullSize").on('shown.bs.modal', function () {
                map.resize();
            })
        }
    }
    // MAPS END
    $(document).ready(function () {
        window.mapInit();
    });
</script>