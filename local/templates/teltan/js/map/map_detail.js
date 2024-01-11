$(document).ready(function () {

    mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';

    const jsonMark = document.querySelector('div#mapMini').getAttribute('data-map-mark');
    const mark = JSON.parse(jsonMark);
    const markCoordinates = mark.geometry.coordinates;

    // МИНИКАРТА В ДЕТАЛКЕ
    if ($('#mapMini').length > 0) {
        // Центрируем карту по метке

        const map = new mapboxgl.Map({
            container: 'mapMini',
            style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
            center: markCoordinates,
            zoom: 7
        });

        map.on('load', () => {
            map.addSource('earthquakes', {
                type: 'geojson',
                data: {
                    "type":"FeatureCollection",
                    'features': [mark]
                },
                cluster: false,
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

            map.on('mouseenter', 'point', (e) => {
                const coordinates = e.features[0].geometry.coordinates.slice();
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
            });

            // Простые объявления
            map.on('mouseenter', () => {
                map.getCanvas().style.cursor = 'pointer';
            });
        });

    }

    if ($('#mapFullSize').length > 0) {

        const map = new mapboxgl.Map({
            container: 'mapFullSize',
            style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
            center: markCoordinates, // Центрируем карту по метке
            zoom: 7
        });

        map.on('load', () => {

            map.addSource('earthquakes', {
                type: 'geojson',
                data: {
                    "type":"FeatureCollection",
                    'features': [mark]
                },
                cluster: false,
                generateId: true // автоматическая генерация id
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

            map.on('mouseenter', 'point', (e) => {
                const coordinates = e.features[0].geometry.coordinates.slice();
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
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
                    let uniqueFeatures = [];
                    e.features.forEach((feature) => {
                        uniqueFeatures[feature.id] = feature;
                    });

                    if (uniqueFeatures.length > 0) {
                        let description = '';
                        let i = 0;
                        uniqueFeatures.forEach(function (feature) {
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
                                            <div class="font-weight-bold">${feature.properties.title}</div>`
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

        $("#itemMapFullSize").on('shown.bs.modal', function () {
            map.resize();
        })
    }
});
