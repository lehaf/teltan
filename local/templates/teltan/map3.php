<script>
    $(document).ready(function () {
        // MAPS START
        function getLink(elem) {
            $(this).trigger('click')
            let SECTION_ID = localStorage.getItem('FILTER_SECTION_ID');
            if ($('#categoryRentInput').is(':checked')) {
                switch (SECTION_ID) {
                    case '35':
                        var sectionUrl = '/property/zhilaya/snyat-j/'
                        break;
                    case '33':
                        var sectionUrl = '/property/kommercheskaya/snyat-kom/'
                        break;
                    case '34':
                        var sectionUrl = '/property/zhilaya/snyat-j/'
                        break;
                    case '32':
                        var sectionUrl = '/property/kommercheskaya/snyat-kom/'
                        break;
                }
            } else {
                switch (SECTION_ID) {
                    case '35':
                        var sectionUrl = '/property/zhilaya/kupit-j/'
                        break;
                    case '33':
                        var sectionUrl = '/property/kommercheskaya/kupit-kom/'
                        break;
                    case '34':
                        var sectionUrl = '/property/zhilaya/kupit-j/'
                        break;
                    case '32':
                        var sectionUrl = '/property/kommercheskaya/kupit-kom/'
                        break;
                }
            }
            let url = 'set_filter=y&view=maplist';
            $('#mainFiltersRent').find('input').each(function (index) {
                if ($(this).is(':checkbox')) {
                    if ($(this).is(':checked')) {
                        let data = $(this).data();
                        if (data.controlId !== undefined) {
                            url = url + '&' + data.controlId + '=' + data.htmlValue
                        }
                    }
                } else {
                    if ($(this).is(':text')) {
                        let data = $(this).data();
                        let val = $(this).val();
                        if (data.controlId !== undefined) {
                            url = url + '&' + data.controlId + '=' + val
                        }
                    } else {
                        let data = $(this).data();
                        let val = $(this).val();
                        if (val !== '') {
                            if (data.controlId !== undefined) {
                                url = url + '&' + data.controlId + '=' + val;
                            }
                        }
                    }
                }
            })
            $.ajax({
                type: "GET",
                dataType: "html",
                url: sectionUrl + '?' + url,
                success: function (data) {
                    $('#rendorMapItemCard').replaceWith($(data).find('#rendorMapItemCard'));
                }
            });
        }

        mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';

        let mapCoordinate = [34.886226654052734, 31.95340028021316] //default coordinate map

        if ($('#map').length > 0) {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/roottest123/cl6erwd1b000w14papxnk52l0',
                center: mapCoordinate,
                zoom: 6
            });
            let hoveredStateId = null;
            let hoveredStateId1 = null;
            let hoveredStateId2 = null;
            let hoveredStateId3 = null;
            let hoveredStateId4 = null;
            let hoveredStateId5 = null;
            let hoveredStateId6 = null;
            let hoveredStateId7 = null;
            let hoveredStateId8 = null;
            let hoveredStateId9 = null;

            const obgGeoMap = <?=json_encode($mapArray)?>;
            const objBasePin = <?=json_encode($mapArrayVip)?>; // ** vip

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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area8") {
                        if (features.length > 0) {
                            if (hoveredStateId8 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-8', sourceLayer: '8', id: hoveredStateId8},
                                    {hover: false}
                                );
                            }

                            hoveredStateId8 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-8', sourceLayer: '8', id: hoveredStateId8},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area8', () => {

                    map.setFeatureState(
                        {source: '1_source-8', sourceLayer: '8', id: hoveredStateId8},
                        {hover: false}
                    );

                    hoveredStateI8 = null;
                });

                map.on('click', '1-level-area8', (e) => {

                    map.flyTo({center: {lat: 30.792293462499828, lng: 34.88696429992865}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {
                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                                getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }

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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area7") {
                        if (features.length > 0) {
                            if (hoveredStateId7 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-7', sourceLayer: '7', id: hoveredStateId7},
                                    {hover: false}
                                );
                            }

                            hoveredStateId7 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-7', sourceLayer: '7', id: hoveredStateId7},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area7', () => {

                    map.setFeatureState(
                        {source: '1_source-7', sourceLayer: '7', id: hoveredStateId7},
                        {hover: false}
                    );

                    hoveredStateId7 = null;
                });

                map.on('click', '1-level-area7', (e) => {

                    map.flyTo({center: {lng: 34.68506737325703, lat: 31.616011520099917}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {

                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                                getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }
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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area6") {
                        if (features.length > 0) {
                            if (hoveredStateId6 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-6', sourceLayer: '6', id: hoveredStateId6},
                                    {hover: false}
                                );
                            }

                            hoveredStateId6 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-6', sourceLayer: '6', id: hoveredStateId6},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area6', () => {

                    map.setFeatureState(
                        {source: '1_source-6', sourceLayer: '6', id: hoveredStateId6},
                        {hover: false}
                    );

                    hoveredStateId6 = null;
                });

                map.on('click', '1-level-area6', (e) => {

                    map.flyTo({center: {lng: 34.98752305903815, lat: 31.6928666963656}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {

                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                                getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }

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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area5") {
                        if (features.length > 0) {
                            if (hoveredStateId5 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-5', sourceLayer: '5', id: hoveredStateId5},
                                    {hover: false}
                                );
                            }

                            hoveredStateId5 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-5', sourceLayer: '5', id: hoveredStateId5},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area5', () => {

                    map.setFeatureState(
                        {source: '1_source-5', sourceLayer: '5', id: hoveredStateId5},
                        {hover: false}
                    );

                    hoveredStateId5 = null;
                });

                map.on('click', '1-level-area5', (e) => {

                    map.flyTo({center: {lng: 34.903915804879404, lat: 32.05794313480354}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {

                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                                getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }

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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area3") {
                        if (features.length > 0) {
                            if (hoveredStateId3 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-3', sourceLayer: '3', id: hoveredStateId3},
                                    {hover: false}
                                );
                            }

                            hoveredStateId3 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-3', sourceLayer: '3', id: hoveredStateId3},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area3', () => {

                    map.setFeatureState(
                        {source: '1_source-3', sourceLayer: '3', id: hoveredStateId3},
                        {hover: false}
                    );

                    hoveredStateId3 = null;
                });

                map.on('click', '1-level-area3', (e) => {

                    map.flyTo({center: {lng: 35.346581583016246, lat: 31.954594298007592}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {

                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                               getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }

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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area2") {
                        if (features.length > 0) {
                            if (hoveredStateId2 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-2', sourceLayer: '2', id: hoveredStateId2},
                                    {hover: false}
                                );
                            }

                            hoveredStateId2 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-2', sourceLayer: '2', id: hoveredStateId2},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area2', () => {

                    map.setFeatureState(
                        {source: '1_source-2', sourceLayer: '2', id: hoveredStateId2},
                        {hover: false}
                    );

                    hoveredStateId2 = null;
                });

                map.on('click', '1-level-area2', (e) => {

                    map.flyTo({center: {lng: 35.24984065244277, lat: 32.59322837411284}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {

                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                                getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }

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
                    let features = map.queryRenderedFeatures(e.point);

                    if (features[0].layer.id === "1-level-area1") {
                        if (features.length > 0) {
                            if (hoveredStateId1 !== null) {
                                map.setFeatureState(
                                    {source: '1_source-1', sourceLayer: '1', id: hoveredStateId1},
                                    {hover: false}
                                );
                            }

                            hoveredStateId1 = features[0].id;
                            map.setFeatureState(
                                {source: '1_source-1', sourceLayer: '1', id: hoveredStateId1},
                                {hover: true}
                            );
                        }
                    }
                });

                map.on('mouseleave', '1-level-area1', () => {

                    map.setFeatureState(
                        {source: '1_source-1', sourceLayer: '1', id: hoveredStateId1},
                        {hover: false}
                    );

                    hoveredStateId1 = null;
                });

                map.on('click', '1-level-area1', (e) => {

                    map.flyTo({center: {lng: 35.4259031056865, lat: 32.90573889477902}, zoom: 8});
                    let features = map.queryRenderedFeatures(e.point);

                    $('.preloader').addClass('preloader-visible');
                    let elems = $('.dropdown-building-area1').find('input');
                    let count = 0;
                    elems.each(function (index) {

                        let data = $(this).data()
                        if ($(this).prop("checked")) {
                            if (data.valued !== features[0]['properties']['MUN_HE']) {
                                $(this).trigger('click')

                            } else {
                                if (data.valued === features[0]['properties']['MUN_HE']) {
                                    $(this).trigger('click')
                                }
                            }
                        }
                        if (data.valued === features[0]['properties']['MUN_HE']) {
                            count++;
                            $(this).trigger('click')
                            let item = this;
                            let link = setTimeout(function () {
                                getLink(item);
                            }, 1000);


                        }

                    })
                    if (count === 0) {
                        $('.preloader').removeClass('preloader-visible');
                    }
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
                    let features = map.queryRenderedFeatures(e.point);

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
                    //   map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 12});
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
                    let features = map.queryRenderedFeatures(e.point, {
                        layers: ['clusters']
                    });

                    const clusterId = features[0].properties.cluster_id;

                    map.getSource('earthquakes').getClusterChildren(clusterId, (error, features) => {

                        let pp = () => {
                            // clearMapItemPLace();
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

                    // Ensure that if the map is zoomed out such that
                    // multiple copies of the feature are visible, the
                    // popup appears over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    clearMapItemPLace();


                });

                map.on('click', 'unclustered-vipPoint', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    let description = '';
                    let middleIndex = Math.floor(e.features.length / 2);
                    e.features.splice(middleIndex);
                    let i = 0;
                    e.features.forEach(function (index) {
                        if (i < 1) {
                            description = description + `
        <div class="d-flex popup-content">
          <div class="w-75 pr-3">
            <img src="${index.properties.image}">
          </div>

          <div class="d-flex flex-column text-right">
            <a href="${index.properties.href}" class="font-weight-bold">${index.properties.title}</a>
            <p class="p-0 text-primary font-weight-bold">${index.properties.price}</p>
          </div>
        <div class="cross" style="display: inline-block; margin-left: 10px; padding-right: 20px; cursor: pointer; width: 20px; height: 20px; background-color: #ccc; border-radius: 50%; position: relative;">
            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 2px; background-color: #fff; transform: rotate(45deg);"></span>
                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 2px; background-color: #fff; transform: rotate(-45deg);"></span>
        </div>
        </div>`
                        }else {
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
                        i = i + 1;
                    })
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                    $('.cross').click(function () {
                        popup.remove();
                    })

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
                    //   clearMapItemPLace();
                });

                map.on('mouseleave', 'unclustered-vipPoint', () => {
                    map.getCanvas().style.cursor = '';
                    // popup.remove();
                    clearMapItemPLace();
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
                });

                map.on('click', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    let description = '';
                    let middleIndex = Math.floor(e.features.length / 2);
                    e.features.splice(middleIndex);
                    let i = 0;
                    e.features.forEach(function (index) {
                        if (i < 1) {
                            description = description + `
        <div class="d-flex popup-content">
          <div class="w-75 pr-3">
            <img src="${index.properties.image}">
          </div>

          <div class="d-flex flex-column text-right">
            <a href="${index.properties.href}" class="font-weight-bold">${index.properties.title}</a>
            <p class="p-0 text-primary font-weight-bold">${index.properties.price}</p>
          </div>
        <div class="cross" style="display: inline-block; margin-left: 10px; padding-right: 20px; cursor: pointer; width: 20px; height: 20px; background-color: #ccc; border-radius: 50%; position: relative;">
            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 2px; background-color: #fff; transform: rotate(45deg);"></span>
                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 2px; background-color: #fff; transform: rotate(-45deg);"></span>
        </div>
        </div>`
                        }else {
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
                        i = i + 1;
                    })
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                    $('.cross').click(function () {
                        popup.remove();
                    })

                });

            });
            const geocoder = new MapboxGeocoder({
                mapboxgl: mapboxgl,
                language: 'he-HE',
                accessToken: mapboxgl.accessToken,
                marker: false
            })
            map.addControl(geocoder)
        }

        const mapItemRenderPlace = $('.databefore');

        const clearMapItemPLace = () => {
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

            <p class="mb-0 price">${data.price}₪</p>
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
                style: 'mapbox://styles/mapbox/streets-v11',
            });
        }

        if ($('#mapFullSize').length > 0) {
            const map = new mapboxgl.Map({
                container: 'mapFullSize',
                style: 'mapbox://styles/mapbox/streets-v11',
            })

            $("#itemMapFullSize").on('shown.bs.modal', function () {
                map.resize();
            })
        }
    });
    // MAPS END

</script>