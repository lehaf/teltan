<?php
/** @var array $mapArray */
/** @var array $mapArrayVip */
?>
<script>
    $(document).ready(function () {
        // MAPS START
        mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';
        let mapCoordinate = [34.886226654052734, 31.95340028021316]; //default coordinate map
        const obgGeoMap = <?=json_encode($mapArray)?>;
        const objBasePin = <?=json_encode($mapArrayVip)?>; // vip**

        if ($('#map').length > 0) {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: mapCoordinate,
                zoom: 4
            });

            let hoveredStateId = null;

            map.on('load', () => {

                map.addSource('earthquakes', {
                    type: 'geojson',
                    data: obgGeoMap,
                    cluster: true,
                    clusterMaxZoom: 10, // Max zoom to cluster points on
                    clusterRadius: 38 // Radius of each cluster when clustering points (defaults to 50)
                });

                map.addSource('vipPoint', {
                    type: 'geojson',
                    data: objBasePin,
                    cluster: false,
                });

                map.addSource('2_source', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl4dzsogf01p420r1z1eexmd8-190dy',
                    //   generateId: true,
                    promoteId: {"abu_gosh": "MUN_ENG"}
                });

                map.addSource('1_source-1', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6esciyp056n27n7bt6oa5lu-5jj6n',
                    //   generateId: true,
                    promoteId: {"1": "MUN_HE"}
                });

                map.addSource('1_source-2', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6gf5h6f04ui21lfk89oqcs8-5f9io',
                    //   generateId: true,
                    promoteId: {"2": "MUN_HE"}
                });

                map.addSource('1_source-3', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6lxgu4a0giv28lso1jlwefx-75mpl',
                    //   generateId: true,
                    promoteId: {"3": "MUN_HE"}
                });

                map.addSource('1_source-4', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6ly3jvs028d20plraodyris-13vuw',
                    //   generateId: true,
                    promoteId: {"44": "MUN_HE"}
                });

                map.addSource('1_source-5', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6pkuxw201py2pp621m2p2r0-8xh1n',
                    //   generateId: true,
                    promoteId: {"5": "MUN_HE"}
                });

                map.addSource('1_source-6', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6m08odf06n220nuyymbcj0w-986xe',
                    //   generateId: true,
                    promoteId: {"6": "MUN_HE"}
                });

                map.addSource('1_source-7', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6pmgk0l02412pp66ucshjvm-4kgrk',
                    generateId: true,

                });

                map.addSource('1_source-8', {
                    //  buffer: 0,
                    type: 'vector',
                    url: 'mapbox://roottest123.cl6pmqqmx01tt2jnsplwbhegs-7sgyg',
                    generateId: true,

                });

                map.addLayer({
                    'id': '1-level-area8',
                    'type': 'fill',
                    'source': '1_source-8',
                    'maxzoom': 8,
                    'source-layer': '8',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area8', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area8") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-8', sourceLayer: '8', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-8', sourceLayer: '8', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area8', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-8', sourceLayer: '8', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area8', (e) => {

                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': '1-level-area7',
                    'type': 'fill',
                    'source': '1_source-7',
                    'maxzoom': 8,
                    'source-layer': '7',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area7', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area7") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-7', sourceLayer: '7', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-7', sourceLayer: '7', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area7', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-7', sourceLayer: '7', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area7', (e) => {
                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': '1-level-area6',
                    'type': 'fill',
                    'source': '1_source-6',
                    'maxzoom': 8,
                    'source-layer': '6',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area6', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area6") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-6', sourceLayer: '6', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-6', sourceLayer: '6', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area6', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-6', sourceLayer: '6', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area6', (e) => {
                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': '1-level-area5',
                    'type': 'fill',
                    'source': '1_source-5',
                    'maxzoom': 8,
                    'source-layer': '5',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area5', (e) => {
                    const features = map.queryRenderedFeatures(e.point);
                    if (features[0].layer.id === "1-level-area5") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-5', sourceLayer: '5', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-5', sourceLayer: '5', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area5', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-5', sourceLayer: '5', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area5', (e) => {

                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': '1-level-area3',
                    'type': 'fill',
                    'source': '1_source-3',
                    'maxzoom': 8,
                    'source-layer': '3',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area3', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area3") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-3', sourceLayer: '3', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-3', sourceLayer: '3', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area3', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-3', sourceLayer: '3', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area3', (e) => {

                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': '1-level-area2',
                    'type': 'fill',
                    'source': '1_source-2',
                    'maxzoom': 8,
                    'source-layer': '2',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area2', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area2") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-2', sourceLayer: '2', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-2', sourceLayer: '2', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area2', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-2', sourceLayer: '2', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area2', (e) => {
                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': '1-level-area1',
                    'type': 'fill',
                    'source': '1_source-1',
                    'maxzoom': 8,
                    'source-layer': '1',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', '1-level-area1', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area1") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '1_source-1', sourceLayer: '1', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-1', sourceLayer: '1', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area1', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-1', sourceLayer: '1', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', '1-level-area1', (e) => {
                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                });

                map.addLayer({
                    'id': 'earthquakess-layer',
                    'type': 'fill',
                    'source': '2_source',
                    'minzoom': 8,
                    'source-layer': 'abu_gosh',
                    'paint': {
                        'fill-color': '#627BC1',
                        'fill-opacity': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            0.5,
                            0
                        ],
                        'fill-outline-color': [
                            'case',
                            ['boolean', ['feature-state', 'select'], false],
                            '#000000',
                            '#627BC1'
                        ]
                    }
                });

                map.on('mousemove', 'earthquakess-layer', (e) => {
                    const features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "earthquakess-layer") {
                        if (features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState(
                                    {source: '2_source', sourceLayer: 'abu_gosh', id: hoveredStateId},
                                    {hover: false}
                                );
                            }

                            hoveredStateId = features[0].id;
                            map.setFeatureState(
                                {source: '2_source', sourceLayer: 'abu_gosh', id: hoveredStateId},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', 'earthquakess-layer', () => {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '2_source', sourceLayer: 'abu_gosh', id: hoveredStateId},
                            {hover: false}
                        );
                    }
                    hoveredStateId = null;
                });

                map.on('click', 'earthquakess-layer', (e) => {
                    map.setFeatureState(
                        {source: '2_source', sourceLayer: 'abu_gosh', id: hoveredStateId},
                        {select: true}
                    );
                    map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 12});
                })

                map.addLayer({
                    id: 'clusters',
                    type: 'circle',
                    source: 'earthquakes',
                    filter: ['has', 'point_count'],
                    paint: {
                        'circle-color': [
                            'step',
                            ['get', 'point_count'], '#abce00', 50, '#719b25', 350, '#417d19', 500, '#2e6409'],
                        'circle-radius': [
                            'step',
                            ['get', 'point_count'], 15, 50, 25, 350, 35, 500, 45]
                    }
                });

                map.addLayer({
                    id: 'cluster-count',
                    type: 'symbol',
                    source: 'earthquakes',
                    filter: ['has', 'point_count'],
                    layout: {
                        'text-field': '{point_count_abbreviated}',
                        'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                        'text-size': 12
                    }
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

                // inspect a cluster on click
                map.on('click', 'clusters', (e) => {
                    const features = map.queryRenderedFeatures(e.point, {
                        layers: ['clusters']
                    });
                    const clusterId = features[0].properties.cluster_id;
                    map.getSource('earthquakes').getClusterExpansionZoom(
                        clusterId,
                        (err, zoom) => {
                            if (err) return;

                            map.easeTo({
                                center: features[0].geometry.coordinates,
                                zoom: zoom
                            });
                        }
                    );
                });

                // When a click event occurs on a feature in
                // the unclustered-point layer, open a popup at
                // the location of the feature, with
                // description HTML from its properties.
                map.on('mouseenter', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                });

                map.on('mouseenter', 'clusters', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'clusters', () => {
                    map.getCanvas().style.cursor = '';
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
                    let description = '';
                    let adsNames = [];
                    e.features.forEach(function (index) {
                        if (!adsNames.includes(index.properties.addres)) {
                            adsNames.push(index.properties.addres);
                            description = description + `
                                <div class="d-flex popup-content">
                                  <div class="w-75 pr-3">
                                    <img src="${index.properties.image}">
                                  </div>

                                  <div class="d-flex flex-column text-right">
                                    <a href="${index.properties.href}" class="font-weight-bold">${index.properties.title}</a>
                                    <p class="p-0 text-primary font-weight-bold">${index.properties.price}</p>
                                  </div>
                                </div>`
                        }
                    });

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });

                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    let description = '';
                    let adsNames = [];
                    e.features.forEach(function (index) {
                        if (!adsNames.includes(index.properties.addres)) {
                            adsNames.push(index.properties.addres);
                            description = description + `
                                <div class="d-flex popup-content">
                                  <div class="w-75 pr-3">
                                    <img src="${index.properties.image}">
                                  </div>

                                  <div class="d-flex flex-column text-right">
                                    <a href="${index.properties.href}" class="font-weight-bold">${index.properties.title}</a>
                                    <p class="p-0 text-primary font-weight-bold">${index.properties.price}</p>
                                  </div>
                                </div>`
                        }
                    });

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });

            });
        }



        // МИНИКАРТА В ДЕТАЛКЕ
        if ($('#mapMini').length > 0) {

            // Центрируем карту по метке
            const markCoordinates = obgGeoMap !== null ?
                obgGeoMap.features[0].geometry.coordinates : objBasePin.features[0].geometry.coordinates;

            const map = new mapboxgl.Map({
                container: 'mapMini',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: markCoordinates,
                zoom: 7
            });

            map.on('load', () => {

                map.addSource('earthquakes', {
                    type: 'geojson',
                    data: obgGeoMap,
                    cluster: false,
                });

                map.addSource('vipPoint', {
                    type: 'geojson',
                    data: objBasePin,
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
                            <a href="${e.features[0].properties.href}" class="font-weight-bold">${e.features[0].properties.title}</a>
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
                            <a href="${e.features[0].properties.href}" class="font-weight-bold">${e.features[0].properties.title}</a>
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
            const markCoordinates = obgGeoMap !== null ?
                obgGeoMap.features[0].geometry.coordinates : objBasePin.features[0].geometry.coordinates;

            const map = new mapboxgl.Map({
                container: 'mapFullSize',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: markCoordinates,
                zoom: 7
            });

            map.on('load', () => {

                map.addSource('earthquakes', {
                    type: 'geojson',
                    data: obgGeoMap,
                    cluster: false,
                });

                map.addSource('vipPoint', {
                    type: 'geojson',
                    data: objBasePin,
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
                            <a href="${e.features[0].properties.href}" class="font-weight-bold">${e.features[0].properties.title}</a>
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
                            <a href="${e.features[0].properties.href}" class="font-weight-bold">${e.features[0].properties.title}</a>
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
    });
    // MAPS END
</script>