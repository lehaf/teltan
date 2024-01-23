window.mapInit = function ()
{
    mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';
    let mapCoordinate = [34.886226654052734, 31.95340028021316]; //default coordinate map

    const jsonMarks = document.querySelector('div.property-map').getAttribute('data-map-marks');
    const marks = JSON.parse(jsonMarks);

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
                data: {
                    "type":"FeatureCollection",
                    'features':marks
                },
                generateId: true, // автоматическая генерация id
                cluster: true,
                clusterMaxZoom: 10, // Max zoom to cluster point on
                clusterRadius: 38 // Radius of each cluster when clustering point (defaults to 50)
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

                // map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 12});
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
                id: 'point',
                type: 'circle',
                source: 'earthquakes',
                filter: ['!', ['has', 'point_count']],
                paint: {
                    'circle-color': [ // красим точки в зависимости от свойства isVip
                        'case',
                        ['==', ['get', 'isVip'], true],
                        '#FF5900',
                        '#73b387'
                    ],
                    'circle-radius': 5,
                    'circle-stroke-width': 1,
                    'circle-stroke-color': '#fff',
                },
                "layout": {
                    'circle-sort-key': [ // задаем сортировочный ключ 1 для isVip и 0 для всех остальных (что бы VIP точки всегда были выше обычных)
                        'case',
                        ['==', ['get', 'isVip'], true],
                        1,
                        0
                    ]
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
            // the point layer, open a popup at
            // the location of the feature, with
            // description HTML from its properties.
            map.on('mouseenter', 'point', (e) => {
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

            map.on('mouseenter', 'point', () => {
                map.getCanvas().style.cursor = 'pointer';
            });

            map.on('mouseleave', 'point', () => {
                map.getCanvas().style.cursor = '';
            });
            
            const popup = new mapboxgl.Popup({
                closeButton: false,
                closeOnClick: true
            });


            // Клик на метку
            map.on('click', 'point', (e) => {
                if (e.features.length > 0) {
                    let vipAds = [];
                    let commonAds = [];
                    e.features.forEach((feature) => {
                        if (feature.properties.isVip == true) {
                            vipAds[feature.id] = feature;
                        } else {
                            commonAds[feature.id] = feature;
                        }
                    });

                    const uniqueFeatures = vipAds.concat(commonAds);

                    if (uniqueFeatures.length > 0) {
                        let description = '';
                        let i = 0;
                        uniqueFeatures.forEach(function (feature) {
                            if (i === 0) {
                                description += `
                                            <div class="cross" style="display: inline-block; margin-left: 10px; padding-right: 20px; cursor: pointer; width: 20px; height: 20px; background-color: #ccc; border-radius: 50%; position: relative;">
                                                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 2px; background-color: #fff; transform: rotate(45deg);"></span>
                                                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 2px; background-color: #fff; transform: rotate(-45deg);"></span>
                                            </div>
                                            <div class="d-flex popup-content">
                                              <div class="w-75 pr-3">
                                                <img src="${feature.properties.image}">
                                              </div>

                                              <div class="d-flex flex-column text-right">
                                                <a href="${feature.properties.href}" class="font-weight-bold">${feature.properties.title}</a>`
                                if (feature.properties.isVip == true) {
                                    description += `<div class="vip-marker">
                                                        <div class="mr-2 icon">
                                                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z" fill="#F50000"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="text">vip</span>
                                                    </div>`
                                }
                                description +=  `<p class="p-0 text-primary font-weight-bold">${feature.properties.price}</p>
                                              </div>
                                            </div>`
                            } else {
                                description += `
                                            <div class="d-flex popup-content">
                                              <div class="w-75 pr-3">
                                                <img src="${feature.properties.image}">
                                              </div>

                                              <div class="d-flex flex-column text-right">
                                                <a href="${feature.properties.href}" class="font-weight-bold">${feature.properties.title}</a>`
                                if (feature.properties.isVip === true) {
                                    description +=  `<div class="vip-marker">
                                                        <div class="mr-2 icon">
                                                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z" fill="#F50000"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="text">vip</span>
                                                    </div>`
                                }
                                description +=  `<p class="p-0 text-primary font-weight-bold">${feature.properties.price}</p>
                                              </div>
                                            </div>`
                            }
                            i = i + 1;
                        });


                        const keys = Object.keys(uniqueFeatures);
                        const coordinates = uniqueFeatures[keys[0]].geometry.coordinates;

                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }

                        popup.setLngLat(coordinates).setHTML(description).addTo(map);
                        $('.cross').click(() => popup.remove());
                    }
                }
            });

        });
    }

}

$(document).ready(function () {
    window.mapInit();
});
