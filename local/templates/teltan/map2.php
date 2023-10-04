
<script>

    $(document).ready(function () {
        // MAPS START

        mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';

        let mapCoordinate = [34.886226654052734, 31.95340028021316] //default coordinate map

        if ($('#map').length > 0) {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: mapCoordinate,
                zoom: 7
            });
            let hoveredStateId = null;

            const obgGeoMap = <?=json_encode($mapArray)?>

            const objBasePin = <?=json_encode($mapArrayVip)?>
            // ** vip

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
                    // Point to GeoJSON data
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
                })
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
                })
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
                })
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
                })

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
                })
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
                })
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
                })
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
                const stateDataLayer = map.getLayer('abu-gosh');

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

                    map.getSource('earthquakes').getClusterChildren(clusterId, (error, features) => {

                        let pp = () => {
                            clearMapItemPLace();
                            features.forEach(e => rendorMapItemCard(e.properties));
                        }

                        features.find(x => !x.properties.cluster ? pp() : console.log('the cluster'));
                    });
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


                /*        map.on('mousemove', (e) => {
                            const features = map.queryRenderedFeatures(e.point);

        // Limit the number of properties we're displaying for
        // legibility and performance
                            const displayProperties = [
                                'type',
                                'properties',
                                'id',
                                'layer',
                                'source',
                                'sourceLayer',
                                'state'
                            ];

                            const displayFeatures = features.map((feat) => {
                                const displayFeat = {};
                                displayProperties.forEach((prop) => {
                                    displayFeat[prop] = feat[prop];
                                });
                                return displayFeat;
                            });

                        });*/


                // When a click event occurs on a feature in
                // the unclustered-point layer, open a popup at
                // the location of the feature, with
                // description HTML from its properties.
                map.on('mouseenter', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();

                    let paramItem = e.features[0].properties

                    // Ensure that if the map is zoomed out such that
                    // multiple copies of the feature are visible, the
                    // popup appears over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    clearMapItemPLace();
                    rendorMapItemCard(paramItem)
                });

                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();

                    let paramItem = e.features[0].properties;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    clearMapItemPLace();
                    rendorMapVipItemCard(paramItem)
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
                    // popup.remove();
                    clearMapItemPLace();
                });

                map.on('mouseenter', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = '';
                    popup.remove();
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
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
            });
        }

        const mapItemRenderPlace = $('.databefore');

        const clearMapItemPLace = () => {
            //mapItemRenderPlace.empty()
            $('div.databeforeinsert').remove()
        }

        const rendorMapItemCard = (paramItem) => {
            let data = paramItem;

            mapItemRenderPlace.before(
                `<div class="my-4 card product-card product-line property-product-line databeforeinsert" style="background-color: @@bg-color">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="${data.href}"><img src="${data.image}" alt="no-img"></a>
            </div>
          </div>

          <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
            <p class="mb-0 like followThisItem">
              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
            </p>

            <p class="mb-0 price">${data.price}</p>
          </div>

          <div class="px-2 px-lg-3 content-block">
            <div class="text-right">
              <a href="${data.href}" class="mb-2 mb-lg-3 title">${data.title}</a>
              <p class="mb-2 mb-lg-3 location">
                <span class="addres">${data.addres}</span>
                  <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                    <g>
                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                    </g>
                  </svg>
              </p>
              <p class="mb-2 mb-lg-3 category">${data.category}</p>
            </div>

            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
              <div class="d-flex">
                <span class="mr-0 mr-lg-2 views"><span>${data.views}</span> <i class="icon-visibility"></i></span>

                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>

              <span class="date">${data.date}</span>
            </div>
          </div>
        </div>
      </div>`
            )
        }
        const rendorMapVipItemCard = (paramItem) => {
            let data = paramItem;

            mapItemRenderPlace.append(
                `<div class="my-4 card product-card product-line product-line-vip property-vip" style="background-color: #FFF5D9">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="${data.href}"><img src="${data.image}" alt="no-img"></a>
            </div>
          </div>

          <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
            <p class="mb-0 like followThisItem">
              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
            </p>

            <p class="mb-0 price">${data.price}</p>
          </div>

          <div class="px-2 px-lg-3 content-block">
            <div class="text-right">
              <a href="${data.href}" class="mb-2 mb-lg-3 title">${data.title}</a>
              <p class="mb-2 mb-lg-3 location">
                <span class="addres">${data.addres}</span>
                  <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                    <g>
                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                    </g>
                  </svg>
              </p>
              <p class="mb-2 mb-lg-3 category">${data.category}</p>
            </div>

            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
              <div class="d-flex">
                <span class="mr-0 mr-lg-2 views"><span>${data.views}</span> <i class="icon-visibility"></i></span>

                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>

              <span class="date">${data.date}</span>
            </div>
          </div>
        </div>
      </div>`
            )
        }

        if ($('#mapMini').length > 0) {
            const map = new mapboxgl.Map({
                container: 'mapMini',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: mapCoordinate,
                zoom: 7
            });
            let hoveredStateId = null;

            const obgGeoMap = <?=json_encode($mapArray)?>

            const objBasePin = <?=json_encode($mapArrayVip)?>
            // ** vip

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
                    // Point to GeoJSON data
                    data: objBasePin,
                    cluster: false,
                });



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
                const stateDataLayer = map.getLayer('abu-gosh');

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

                    map.getSource('earthquakes').getClusterChildren(clusterId, (error, features) => {

                        let pp = () => {
                            clearMapItemPLace();
                            features.forEach(e => rendorMapItemCard(e.properties));
                        }

                        features.find(x => !x.properties.cluster ? pp() : console.log('the cluster'));
                    });
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
                map.on('mouseenter', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();

                    let paramItem = e.features[0].properties

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    clearMapItemPLace();
                    rendorMapItemCard(paramItem)
                });

                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();

                    let paramItem = e.features[0].properties;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    clearMapItemPLace();
                    rendorMapVipItemCard(paramItem)
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
                    // popup.remove();
                    clearMapItemPLace();
                });

                map.on('mouseenter', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = '';
                    popup.remove();
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
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
            });
            const mapItemRenderPlace = $('.databefore');

            const clearMapItemPLace = () => {
                //mapItemRenderPlace.empty()
                $('div.databeforeinsert').remove()
            }

            const rendorMapItemCard = (paramItem) => {
                let data = paramItem;

                mapItemRenderPlace.before(
                    `<div class="my-4 card product-card product-line property-product-line databeforeinsert" style="background-color: @@bg-color">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="${data.href}"><img src="${data.image}" alt="no-img"></a>
            </div>
          </div>

          <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
            <p class="mb-0 like followThisItem">
              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
            </p>

            <p class="mb-0 price">${data.price}</p>
          </div>

          <div class="px-2 px-lg-3 content-block">
            <div class="text-right">
              <a href="${data.href}" class="mb-2 mb-lg-3 title">${data.title}</a>
              <p class="mb-2 mb-lg-3 location">
                <span class="addres">${data.addres}</span>
                  <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                    <g>
                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                    </g>
                  </svg>
              </p>
              <p class="mb-2 mb-lg-3 category">${data.category}</p>
            </div>

            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
              <div class="d-flex">
                <span class="mr-0 mr-lg-2 views"><span>${data.views}</span> <i class="icon-visibility"></i></span>

                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>

              <span class="date">${data.date}</span>
            </div>
          </div>
        </div>
      </div>`
                )
            }
            const rendorMapVipItemCard = (paramItem) => {
                let data = paramItem;

                mapItemRenderPlace.append(
                    `<div class="my-4 card product-card product-line product-line-vip property-vip" style="background-color: #FFF5D9">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="${data.href}"><img src="${data.image}" alt="no-img"></a>
            </div>
          </div>

          <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
            <p class="mb-0 like followThisItem">
              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
            </p>

            <p class="mb-0 price">${data.price}</p>
          </div>

          <div class="px-2 px-lg-3 content-block">
            <div class="text-right">
              <a href="${data.href}" class="mb-2 mb-lg-3 title">${data.title}</a>
              <p class="mb-2 mb-lg-3 location">
                <span class="addres">${data.addres}</span>
                  <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                    <g>
                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                    </g>
                  </svg>
              </p>
              <p class="mb-2 mb-lg-3 category">${data.category}</p>
            </div>

            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
              <div class="d-flex">
                <span class="mr-0 mr-lg-2 views"><span>${data.views}</span> <i class="icon-visibility"></i></span>

                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>

              <span class="date">${data.date}</span>
            </div>
          </div>
        </div>
      </div>`
                )
            }
        }

        if ($('#mapFullSize').length > 0) {
            const map = new mapboxgl.Map({
                container: 'mapFullSize',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: mapCoordinate,
                zoom: 7
            });
            let hoveredStateId = null;

            const obgGeoMap = <?=json_encode($mapArray)?>

            const objBasePin = <?=json_encode($mapArrayVip)?>
            // ** vip

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
                    // Point to GeoJSON data
                    data: objBasePin,
                    cluster: false,
                });
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
                const stateDataLayer = map.getLayer('abu-gosh');
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

                    map.getSource('earthquakes').getClusterChildren(clusterId, (error, features) => {

                        let pp = () => {
                            clearMapItemPLace();
                            features.forEach(e => rendorMapItemCard(e.properties));
                        }

                        features.find(x => !x.properties.cluster ? pp() : console.log('the cluster'));
                    });
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
                map.on('mouseenter', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    let paramItem = e.features[0].properties
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                    clearMapItemPLace();
                    rendorMapItemCard(paramItem)
                });
                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    let paramItem = e.features[0].properties;
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                    clearMapItemPLace();
                    rendorMapVipItemCard(paramItem)
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
                    clearMapItemPLace();
                });
                map.on('mouseenter', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                map.on('mouseleave', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = '';
                    popup.remove();
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
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
            });

            $("#itemMapFullSize").on('shown.bs.modal', function () {
                map.resize();
            })
            const mapItemRenderPlace = $('.databefore');

            const clearMapItemPLace = () => {
                //mapItemRenderPlace.empty()
                $('div.databeforeinsert').remove()
            }

            const rendorMapItemCard = (paramItem) => {
                let data = paramItem;

                mapItemRenderPlace.before(
                    `<div class="my-4 card product-card product-line property-product-line databeforeinsert" style="background-color: @@bg-color">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="${data.href}"><img src="${data.image}" alt="no-img"></a>
            </div>
          </div>

          <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
            <p class="mb-0 like followThisItem">
              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
            </p>

            <p class="mb-0 price">${data.price}</p>
          </div>

          <div class="px-2 px-lg-3 content-block">
            <div class="text-right">
              <a href="${data.href}" class="mb-2 mb-lg-3 title">${data.title}</a>
              <p class="mb-2 mb-lg-3 location">
                <span class="addres">${data.addres}</span>
                  <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                    <g>
                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                    </g>
                  </svg>
              </p>
              <p class="mb-2 mb-lg-3 category">${data.category}</p>
            </div>

            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
              <div class="d-flex">
                <span class="mr-0 mr-lg-2 views"><span>${data.views}</span> <i class="icon-visibility"></i></span>

                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>

              <span class="date">${data.date}</span>
            </div>
          </div>
        </div>
      </div>`
                )
            }
            const rendorMapVipItemCard = (paramItem) => {
                let data = paramItem;

                mapItemRenderPlace.append(
                    `<div class="my-4 card product-card product-line product-line-vip property-vip" style="background-color: #FFF5D9">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="${data.href}"><img src="${data.image}" alt="no-img"></a>
            </div>
          </div>

          <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
            <p class="mb-0 like followThisItem">
              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
            </p>

            <p class="mb-0 price">${data.price}</p>
          </div>

          <div class="px-2 px-lg-3 content-block">
            <div class="text-right">
              <a href="${data.href}" class="mb-2 mb-lg-3 title">${data.title}</a>
              <p class="mb-2 mb-lg-3 location">
                <span class="addres">${data.addres}</span>
                  <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                    <g>
                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                    </g>
                  </svg>
              </p>
              <p class="mb-2 mb-lg-3 category">${data.category}</p>
            </div>

            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
              <div class="d-flex">
                <span class="mr-0 mr-lg-2 views"><span>${data.views}</span> <i class="icon-visibility"></i></span>

                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>

              <span class="date">${data.date}</span>
            </div>
          </div>
        </div>
      </div>`
                )
            }
        }
    });
    // MAPS END
</script>