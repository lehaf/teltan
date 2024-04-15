<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

/** @var array $mapArray */

use Bitrix\Main\Loader;

$regions = [];
if (defined('MAP_REGIONS_HL_ID') && Loader::includeModule("highloadblock")) {
    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(MAP_REGIONS_HL_ID)->fetch();
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();

     $regions = $entityClass::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "ASC"),
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ]
    ))->fetchAll();
}
?>
<script>
    $(document).ready(function () {

        async function getGoogleCoordinates(address) {
            let res = {};
            const apiKey = 'AIzaSyBlz97ziXcVyIPIduUQh5nsc5WmnbSGPmE'; // Специальный API ключ от google
            address = encodeURIComponent(address);
            const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${apiKey}`;

            let data = await fetch(url).then(response => response.json());

            if (data.status === 'OK') {
                res = {
                    'lat': data.results[0].geometry.location.lat,
                    'lon': data.results[0].geometry.location.lng
                };
            } else {
                console.log('Ошибка при получении координат.');
            }


            return res;
        }


        // MAPS START
        mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';
        let mapCoordinate = [34.886226654052734, 31.95340028021316] //default coordinate map

        if ($('#map').length > 0) {

            const districtZoneId = 'earthquakess-layer';
            const layersId = [
                'earthquakess-layer',
                '1-level-area8',
                '1-level-area7',
                '1-level-area6',
                '1-level-area5',
                '1-level-area3',
                '1-level-area2',
                '1-level-area1',
            ];

            const displayProperties = [
                'type',
                'properties',
                'id',
                'layer',
                'source',
                'sourceLayer',
                'state'
            ];

            function getMapMark (features, locationDataPosition = null, locationDataLatLng = null) {
                if (features) {

                    let markerData = features.map((feat) => {
                        const displayFeat = {};
                        displayProperties.forEach((prop) => {
                            displayFeat[prop] = feat[prop];
                        });
                        return displayFeat;
                    });

                    let marker = markerData[0];
                    if (marker !== undefined && layersId.includes(marker.layer.id)) {
                        window.mapError = false;
                    } else {
                        window.mapError = 'Вы выбрали метку за пределами разрешенных зон страны Израиль';
                    }

                    let markZones = map.queryRenderedFeatures(locationDataPosition,{layers: layersId});
                    if (markZones.length > 0) {
                        for (const zone of markZones) {
                            // Получаем регион
                            if (zone.layer.id === districtZoneId) {
                                marker.districtName = zone.properties.MUN_HEB;
                            } else {
                                marker.regionName = zone.properties.MUN_HE;
                            }
                        }
                    }

                    // Проверка на зону
                    if (!window.mapError && !marker.districtName) window.mapError = 'Вы не выбрали район!';
                    if (!window.mapError && !marker.regionName) window.mapError = 'Вы не выбрали область!';

                    $('.wizard-control-next').removeAttr('disabled'); // снимаем блокировку с кнопки что бы пользователь мог проверить ошибку
                    localStorage.setItem('markerData', JSON.stringify(marker))
                    if (locationDataPosition !== null) localStorage.setItem('locationDataPosition', JSON.stringify(locationDataPosition))
                    if (locationDataLatLng !== null) localStorage.setItem('locationDataLatLng', JSON.stringify(locationDataLatLng))


                }
            }

            const regions = JSON.parse('<?=json_encode($regions)?>');
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: mapCoordinate,
                zoom: 7
            });

            // ** vip
            $(".wizard-control-next").on("click",()=>{
                map.resize();
            })

            $(".wizard-control-prev").on("click",()=>{
                map.resize();
            })

            const obgGeoMap = <?=json_encode($mapArray)?>

            map.on('load', (ep) => {
                window.mapError = 'Выберите метку на карте!';
                map.resize();
                let hoveredStateId = null;

                map.addSource('earthquakes', {
                    type: 'geojson',
                    data: obgGeoMap,
                    cluster: true,
                    clusterMaxZoom: 10, // Max zoom to cluster points on
                    clusterRadius: 38 // Radius of each cluster when clustering points (defaults to 50)
                });

                let dic = {};

                if (regions.length > 0) {
                    // Добавляем области на карту
                    for (const reg of regions) {
                        let promoteId = {};
                        promoteId[reg.UF_PROMOTE_ID] = "MUN_HE";
                        map.addSource(reg.UF_SOURCE, {
                            type: 'vector',
                            url: reg.UF_MAPBOX_URL,
                            promoteId: promoteId
                        });

                        map.addLayer({
                            'id': reg.UF_MAP_ID,
                            'type': 'fill',
                            'source': reg.UF_SOURCE,
                            'metadata': reg.UF_NAME,
                            'source-layer': reg.UF_PROMOTE_ID,
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

                        // Визуально скрываем область с карты
                        map.setLayoutProperty(reg.UF_MAP_ID, 'visibility', 'none');

                        dic[reg.ID] = null;
                        map.on('mousemove', reg.UF_MAP_ID, (e) => {
                            const features = map.queryRenderedFeatures(e.point);
                            if (features[0].layer.id === reg.UF_MAP_ID) {
                                if (features.length > 0) {
                                    if (dic[reg.ID] !== null) {
                                        map.setFeatureState(
                                            {source: reg.UF_SOURCE, sourceLayer: reg.UF_PROMOTE_ID, id: dic[reg.ID]},
                                            {hover: false}
                                        );
                                    }

                                    dic[reg.ID] = features[0].id;
                                    map.setFeatureState(
                                        {source: reg.UF_SOURCE, sourceLayer: reg.UF_PROMOTE_ID, id: dic[reg.ID]},
                                        {hover: true}
                                    );
                                }
                            }
                        });

                        map.on('mouseleave', reg.UF_MAP_ID, () => {
                            if (dic[reg.ID] !== null) {
                                map.setFeatureState(
                                    {source: reg.UF_SOURCE, sourceLayer: reg.UF_PROMOTE_ID, id: dic[reg.ID]},
                                    {hover: false}
                                );
                            }
                            dic[reg.ID] = null;
                        });

                        map.on('click', reg.UF_MAP_ID, (e) => {
                            map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
                        });
                    }
                }

                // Добавляем маленькие раены на карту
                map.addSource('2_source', {
                    type: 'vector',
                    url: 'mapbox://roottest123.cl4dzsogf01p420r1z1eexmd8-190dy',
                    promoteId: {"abu_gosh": "MUN_ENG"}
                });

                map.addLayer({
                    'id': 'earthquakess-layer',
                    'type': 'fill',
                    'source': '2_source',
                    'metadata': 'Abu-gosh',
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

                // Визуально скрыть раены с карты
                map.setLayoutProperty('earthquakess-layer', 'visibility', 'none');


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

                // const address = 'Shira Israeli physiotherapist, Helsinki 11th, Tel Aviv-Yafo';
                // getGoogleCoordinates(address);

                const geocoder = new MapboxGeocoder({
                    mapboxgl: mapboxgl,
                    language: 'he-HE',
                    accessToken: mapboxgl.accessToken,
                    marker: false,
                    autocomplete: false,
                    fuzzyMatch: false,
                    externalGeocoder: () => {},
                });

                let marker;
                let markerLong = false;
                let markerLat = false;

                document.querySelectorAll('.mapboxgl-ctrl-result').forEach((result) => {
                    result.style.display = 'none';
                });


                // После добавления маркера на карту
                geocoder.on('result',async e => {
                    const query = geocoder.inputString;
                    let googleCord = await getGoogleCoordinates(query);

                    if (marker) marker.remove();  // Удаляем предыдущий маркер

                    // Кординаты опрокидываются из гугла
                    markerLong = googleCord.lon;
                    markerLat = googleCord.lat;

                    marker = new mapboxgl.Marker({
                        draggable: true
                    }).setLngLat([markerLong, markerLat]).addTo(map)

                    // Получаем метку если камера не двигается
                    let geocoder_point = map.project([markerLong, markerLat]);
                    const features = map.queryRenderedFeatures(geocoder_point);
                    getMapMark(features,geocoder_point,[markerLong, markerLat]);

                    // Получаем метку если пользователь ее перенес вручную
                    marker.on('dragend', function (e) {
                        markerLong = e.target._lngLat.lng;
                        markerLat = e.target._lngLat.lat;
                        const features = map.queryRenderedFeatures(e.target._pos);
                        getMapMark(features, e.target._pos, [markerLong, markerLat]);
                    });

                    // Получаем метку если камера двигается
                    map.on('zoomend', function() {
                        let geocoder_point = map.project([markerLong, markerLat]);
                        const features = map.queryRenderedFeatures(geocoder_point);
                        getMapMark(features,geocoder_point,[markerLong, markerLat]);
                    });

                    // Плавный подкат к метке
                    map.flyTo({
                        center: [markerLong, markerLat], // координаты метки
                        zoom: 16, // зум после перемещения
                        speed: 1, // скорость перемещения (от 0 до 1)
                        curve: 1, // кривая перемещения (от 0 до 1)
                        essential: true // указывает, что это важное перемещение и не должно быть прервано другими анимациями
                    });
                });

                <?// Редактирование элемента?>
                <?if(!empty($_GET['ID']) && $_GET['EDIT'] == 'Y'):?>
                    // Событие полной отрисовки карты
                    map.once('idle', function() {
                        const markCoordinates = <?=$GLOBALS['MAP_EDIT_RESULT_CORDINATES']?>;
                        markerLong = markCoordinates['lng'] ? markCoordinates['lng'] : markCoordinates[0];
                        markerLat = markCoordinates['lat'] ? markCoordinates['lat'] : markCoordinates[1];
                        marker = new mapboxgl.Marker({
                            draggable: true
                        }).setLngLat([markerLong, markerLat]).addTo(map);
                        const features = map.queryRenderedFeatures(<?=$GLOBALS['MAP_EDIT_RESULT_POSITION']?>);
                        const geocoderPoint = map.project([markerLong, markerLat]);
                        // Полет к метке
                        map.flyTo({
                            center: [markerLong, markerLat], // координаты метки
                            zoom: 7, // зум после перемещения
                            speed: 0.3, // скорость перемещения (от 0 до 1)
                            curve: 1, // кривая перемещения (от 0 до 1)
                            essential: true // указывает, что это важное перемещение и не должно быть прервано другими анимациями
                        });

                        getMapMark(features, geocoderPoint, [markerLong, markerLat]);

                        marker.on('dragend', function (e) {
                            const features = map.queryRenderedFeatures(e.target._pos);
                            getMapMark(features, e.target._pos, e.target._lngLat);
                        })
                    });
                <?endif;?>

                map.addControl(geocoder);
            });
        }
    });
</script>