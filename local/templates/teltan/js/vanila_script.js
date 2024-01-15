(function(){
    const $body = $('body');
    const $filterModalContetn = $('#filterModalContent')
    const $itemSlider =  $('#itemSlider');

    const $header = $(".header");
    const scroll = 0;
    const active = "active";
    let prevScrollTop = 0;

    $(window).scroll(function() {
        const scrollTop = $(window).scrollTop()

        if(prevScrollTop < scrollTop && prevScrollTop > 0){
            $header.addClass('hiddenSearch')
        } else if(prevScrollTop - 20 > scrollTop){
            $header.removeClass('hiddenSearch')
        }

        if (scrollTop > scroll) {
            $header.addClass(active);
        } else {
            $header.removeClass(active);
        }

        prevScrollTop = scrollTop;
    });

    // Handler mobile manu user
    $('.btnUserMenuProfile').on('click', (e) => {
        $('.user-profile-menu__header').toggleClass('active')
    })

    // MODALS start
    $('#registerModal').on('show.bs.modal', function () {
        $("#logInModal").modal('hide');
    });

    $("#registerModal").on('shown.bs.modal', function () {
        $body.addClass('modal-open');
    });
    // MODALS end

    // MOBILE MENU --START--
    $('.hamburger').on('click', () => {
        $('.mobile-menu').addClass('active')
        $body.addClass('overflow-h')
    })

    $('.mobile-menu .closer').on('click', (e) => {
        $('.mobile-menu').removeClass('active')
        $body.removeClass('overflow-h')
    })

    $('.menu__nav .nav-item').on('click', function (e) {
        e.preventDefault()
        const menuBtn = $(this).data('menu-btn')
        $(`.menu.submenu[data-submenu=${menuBtn}]`).addClass('active')
    })

    $('.menu__header .back-menu').on('click', function (e) {
        e.preventDefault()
        $('.menu.submenu').removeClass('active')
    })
    // MOBILE MENU --END--

    // MAPS START
    mapboxgl.accessToken = 'pk.eyJ1IjoiYS1rbGltb2YiLCJhIjoiY2themVqYzI4MGlrZDJxbWlvaDBlMzF6MyJ9.QXFKypM1BnCkQaUZKTuP0g';

    let mapCoordinate = [34.886226654052734, 31.95340028021316] //default coordinate map

    if($('#map').length > 0) {
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: mapCoordinate,
            zoom: 8
        });

        //  TODO вынести на бэк , добавть данные в обект для заполнения карточки при нажатии
        const obgGeoMap = {
            "type": "FeatureCollection",
            "features": [
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.65087890625, 31.765537409484374]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.7003173828125, 31.774877618507386]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.71130371093749, 31.779547369387327]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.7882080078125, 31.63467554954133]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [35.00244140625, 31.80756092262095]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92553710937499, 32.045332838858506]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.7882080078125, 32.06861069132688]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92073059082031, 32.045332838858506]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.91935729980469, 32.0464968721355]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92279052734375, 32.045332838858506]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.918670654296875, 32.04358676118635]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.924163818359375, 32.043004727893994]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92073059082031, 32.04824289429362]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.91729736328125, 32.0424226909009]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.9200439453125, 32.04358676118635]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.9200439453125, 32.03951245042539]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92279052734375, 32.04184065020709]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92485046386719, 32.040676557717454]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92759704589844, 32.04707888322257]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92759704589844, 32.04475081666863]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [35.00518798828125, 31.811062019751912]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [35.00175476074219, 31.812229022640704]
                    }
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [73.06531154518007, 50.76780433446321]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [3.898814937283852, 10.660424128644896]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [-161.97152116970247, -42.14928858341811]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [117.57086019036386, 1.852936137769725]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [-35.1186470645382, 56.09518644869263]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [-76.68509037371481, 12.759742078012613]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [-45.46191847357686, -13.969746388646316]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [118.93802702542163, 79.2524588864279]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [152.23337671740123, -59.4881940990748]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [121.90005119705127, -53.90886482261081]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [-151.5620636961228, 61.874505180674845]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "type": "Point",
                        "coordinates": [146.3612868342311, 62.94217372223176]
                    },
                    "properties": {}
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.904422760009766, 31.94757405383847]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.874725341796875, 31.93643036691345]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.87515449523926, 31.93686739969975]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.875497817993164, 31.93526493599139]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.875068664550774, 31.937377268657517]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90030288696289, 31.94808386339691]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90159034729004, 31.949103474027286]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.901161193847656, 31.948302352341695]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90184783935547, 31.947355563161757]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90124702453613, 31.948011033633165]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.902448654174805, 31.950050245194983]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90304946899414, 31.948593670126517]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.903221130371094, 31.946408764225453]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90021705627441, 31.950414385353824]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90313529968262, 31.950997006605856]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.898242950439446, 31.949977416990013]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.899702072143555, 31.947792543995604]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.89910125732422, 31.95019590143172]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.89901542663574, 31.949321960547344]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.89729881286621, 31.949758932028708]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90124702453613, 31.944733634515277]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.90553855895996, 31.946408764225453]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.9079418182373, 31.946918580249633]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.88991737365723, 31.944005307724854]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.892578125, 31.949686103592832]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.892492294311516, 31.957624063277]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.8896598815918, 31.96184765210256]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.87669944763183, 31.96075536326968]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.886226654052734, 31.95340028021316]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.89901542663574, 31.955220900178322]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.87360954284668, 31.95092417915142]
                    }
                }
            ]
        }

        const objBasePin = {
            "type": "FeatureCollection",
            "features": [
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.65087890625, 31.765537409484374]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.7003173828125, 31.774877618507386]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.71130371093749, 31.779547369387327]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.7882080078125, 31.63467554954133]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [35.00244140625, 31.80756092262095]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92553710937499, 32.045332838858506]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.7882080078125, 32.06861069132688]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92073059082031, 32.045332838858506]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.91935729980469, 32.0464968721355]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        'image': './img/room_01.png',
                        'price': '$27 600',
                        'title': 'Concert tickets for Alisher Morgenstern',
                        'addres': 'Tel Aviv-Yafo, Tel Aviv District, Israel',
                        'category': 'Sale of apartaments',
                        'views': '2531',
                        'date': 'Yesterday, 20:28',
                        'isVipCard': false,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [34.92279052734375, 32.045332838858506]
                    }
                }
            ]
        }

        map.on('load', () => {
            // Add a new source from our GeoJSON data and
            // set the 'cluster' option to true. GL-JS will
            // add the point_count property to your source data.
            map.addSource('earthquakes', {
                type: 'geojson',
                // Point to GeoJSON data
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

            // map.addSource('cityes', {
            //   type: 'geojson',
            //   data: objGeometryPolygon
            // });

            let hoveredStateId = null;

            map.addLayer({
                id: 'clusters',
                type: 'circle',
                source: 'earthquakes',
                filter: ['has', 'point_count'],
                paint: {
                    // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
                    // with three steps to implement three types of circles:
                    //   * Blue, 20px circles when point count is less than 100
                    //   * Yellow, 30px circles when point count is between 100 and 750
                    //   * Pink, 40px circles when point count is greater than or equal to 750
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

            // map.addLayer({
            //   'id': 'state-fills',
            //   'type': 'fill',
            //   'source': 'cityes',
            //   'layout': {},
            //   'paint': {
            //   'fill-color': '#ccc',
            //   'fill-opacity': [
            //   'case',
            //   ['boolean', ['feature-state', 'hover'], false], 1, 0.5]
            //   }
            // });

            //   map.addLayer({
            //   'id': 'state-borders',
            //   'type': 'line',
            //   'source': 'cityes',
            //   'layout': {},
            //   'paint': {
            //   'line-color': '#c0c0c0',
            //   'line-width': 1
            //   }
            // });

            // inspect a cluster on click
            map.on('click', 'clusters', (e) => {
                const features = map.queryRenderedFeatures(e.point, {
                    layers: ['clusters']
                });

                const clusterId = features[0].properties.cluster_id;

                map.getSource('earthquakes').getClusterChildren(clusterId, (error, features) => {

                    let pp = () => {
                        clearMapItemPLace();
                        features.forEach(e => target_container(e.properties));
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

            // When a click event occurs on a feature in
            // the unclustered-point layer, open a popup at
            // the location of the feature, with
            // description HTML from its properties.
            map.on('click', 'unclustered-point', (e) => {
                const coordinates = e.features[0].geometry.coordinates.slice();

                let paramItem = e.features[0].properties

                // Ensure that if the map is zoomed out such that
                // multiple copies of the feature are visible, the
                // popup appears over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                clearMapItemPLace();
                target_container(paramItem)
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
                popup.remove();
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

            map.on('mouseenter', 'unclustered-point', (e) => {
                const coordinates = e.features[0].geometry.coordinates.slice();
                const description = `
        <div class="d-flex popup-content">
          <div class="w-75 pr-3">
            <img src="${e.features[0].properties.image}">
          </div>

          <div class="d-flex flex-column text-right">
            <p class="font-weight-bold">${e.features[0].properties.title}</p>
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

    const mapItemRenderPlace = $('#target_container');

    const clearMapItemPLace = () => {
        mapItemRenderPlace.empty()
    }

    const target_container = (paramItem) => {
        let data = paramItem;

        mapItemRenderPlace.append(
            `<div class="my-4 card product-card product-line property-product-line" style="background-color: @@bg-color">
        <div class="card-link">
          <div class="image-block">
            <div class="i-box">
              <a href="#"><img src="${data.image}" alt="no-img"></a>
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
              <a href="#" class="mb-2 mb-lg-3 title">${data.title}</a>
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
                <span class="mr-0 mr-lg-2 views"><span>${data.views}views</span> <i class="icon-visibility"></i></span>
      
                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>
      
              <span class="date">${data.date}date</span>
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
              <a href="#"><img src="${data.image}" alt="no-img"></a>
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
              <a href="#" class="mb-2 mb-lg-3 title">${data.title}</a>
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
                <span class="mr-0 mr-lg-2 views"><span>${data.views}views</span> <i class="icon-visibility"></i></span>
      
                <span class="product-line__like">To favorites
                  <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                </span>
              </div>
      
              <span class="date">${data.date}date</span>
            </div>
          </div>
        </div>
      </div>`
        )
    }

    if($('#mapMini').length > 0) {
        const map = new mapboxgl.Map({
            container: 'mapMini',
            style: 'mapbox://styles/mapbox/streets-v11',
        });
    }

    if($('#mapFullSize').length > 0) {
        const map = new mapboxgl.Map({
            container: 'mapFullSize',
            style: 'mapbox://styles/mapbox/streets-v11',
        })

        $("#itemMapFullSize").on('shown.bs.modal', function () {
            map.resize();
        })
    }
    // MAPS END


    $('#closeNumberList').on('click', () => {
        $('.mobile-block-show-contacts').removeClass('show')
    })


    Element.prototype.remove = function() {
        this.parentElement.removeChild(this);
    }
    NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
        for(var i = this.length - 1; i >= 0; i--) {
            if(this[i] && this[i].parentElement) {
                this[i].parentElement.removeChild(this[i]);
            }
        }
    }

    $('.filterTogglerMobile').on('click', (e) => {
        e.preventDefault()
        $filterModalContetn.toggleClass('visible')

        if ($('#isMobileMenuFiltersOpen').hasClass('modal-backdrop fade show')) {
            $('#isMobileMenuFiltersOpen').remove();
            $body.removeClass('modal-open');
        } else {
            $filterModalContetn.css("z-index", "1050")
            $body.append(`<div id='isMobileMenuFiltersOpen' class="modal-backdrop fade show"></div>`)
            $body.addClass('modal-open')

            $('#isMobileMenuFiltersOpen').on('click', function(e) {
                $(this).remove();
                $filterModalContetn.toggleClass('visible')
                $body.removeClass('modal-open');
            })
        }

        $('.cord-container').removeClass('overlay')
    })



    $('.filterPropertyCloser').on('click', (e) => {
        e.preventDefault()
        $filterModalContetn.toggleClass('visible')

        $('.cord-container').removeClass('overlay')
    })

    $('.collaps-text-about-btn').on('click', function() {
        $(this).closest('.collaps-text-about').find('.collaps-text-about-text').toggleClass('show')
    })

    if ($("#btnShowMoreBodyTypes")) {
        $('#btnShowMoreBodyTypes').on('click', () => {
            $('.form_radio_btn').filter('.show-additionally').css("display", "inline-block");
            $('#btnShowMoreBodyTypes').css("display", "none")
        })
    }

    if ($(window).width() <= 748) {
        $('.fleamarket-mobile > .nav > .nav-link').on('click', () => {
            $('.fleamarket').addClass('show')
        })

        $('.btn-back').on('click', () => {
            $('.fleamarket').removeClass('show')
        })
    }

    // Dropdown cabinet item menu
    $('#dropdownMenuLink').on('click', (e) => {
        e.preventDefault()
        $('.accardion-wrap').toggleClass('active')
    })

    $('.user-product__btn-edit').on('click', (e) => {
        e.preventDefault()
        $('.edit-item-menu_item1').toggleClass('active')
    })

    $('.add-item-favorite').on('click', () => {
        $('.add-item-favorite').toggleClass('active')
    })

    $('.followThisItem').on('click', function() {
        $(this).toggleClass('active')
    })

    //Similar Contetn Sliders / VIP content slider
    $(document).ready(function(){
        $('.similar-products-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow: '<div class="prev"><img src="./assets/vip-item-arrow.svg" alt="prev"></div>',
            nextArrow: '<div class="next"><img src="./assets/vip-item-arrow.svg" alt="next"></div>',
            responsive: [
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                }, {
                    breakpoint: 540,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                }]
        });

        $('.vip-items-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow: '<div class="prev"><img src="./assets/vip-item-arrow.svg" alt="prev"></div>',
            nextArrow: '<div class="next"><img src="./assets/vip-item-arrow.svg" alt="next"></div>',
            responsive: [
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 786,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                }, {
                    breakpoint: 540,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                    }
                }]
        });

        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: '<div class="carousel-control-prev" data-slide="prev"><i class="icon-left-arrow rotate-180"></i><span class="sr-only">Previous</span></div>',
            nextArrow: '<div class="carousel-control-next" data-slide="next"><i class="icon-left-arrow"></i><span class="sr-only">Next</span></div>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    centerPadding: '7%',
                    centerMode: true,
                    arrows: false,
                }
            }]
        });

        $('.slider-nav div[data-slide]').click(function(e) {
            e.preventDefault();
            var slideno = $(this).data('slide');
            $('.slider-for').slick('slickGoTo', slideno);
        });

        $('.slider-for .slide').click(function(e) {
            e.preventDefault();

            let currentSliderNumber = e.delegateTarget.attributes['data-current-slider'].value

            // $('.mainItemSlider').slick('slickGoTo', currentSliderNumber);
            $('.navMainItemSlider').slick('slickGoTo', currentSliderNumber);
        });

        // ITEM SLITER on modal window
        let $status = $('.slider-counter-mobile');
        let $slickElement = $('.mainItemSlider');

        $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            // currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $status.text(i + '/' + slick.slideCount);
        });

        $('.mainItemSlider').slick({
            slidesToShow: 1,
            arrows: false,
            vertical: true,
            centerMode: true,
            verticalSwiping: true,
            centerPadding: '18%',
            asNavFor: '.navMainItemSlider',
            responsive: [{
                breakpoint: 856,
                settings: {
                    vertical: false,
                    centerPadding: '15%',
                    verticalSwiping: false,
                    centerPadding: 0,
                    centerMode: false,
                }
            }]
        });

        $('.navMainItemSlider').slick({
            slidesToShow: 9,
            slidesToScroll: 9,
            centerPadding: '24px',
            vertical: true,
            centerMode: true,
            focusOnSelect: true,
            prevArrow: '<div class="dots-arrow dots-arrow-prev"><i class="icon-left-arrow rotate-180"></i></div>',
            nextArrow: '<div class="dots-arrow dots-arrow-next"><i class="icon-left-arrow"></i></div>',
            asNavFor: '.mainItemSlider',
            responsive: [{
                breakpoint: 856,
                settings: "unslick",
            }]
        });

        $('.mainItemSlider').on('wheel', (function(e) {
            e.preventDefault();

            if (e.originalEvent.deltaY < 0) {
                $(this).slick('slickNext');
            } else {
                $(this).slick('slickPrev');
            }
        }));

        $('#modalFullSize').on('shown.bs.modal', function () {
            $('.mainItemSlider').slick('refresh');
            $('.navMainItemSlider').slick('refresh');
        })

        if ($(window).width() < 768) {
            $('#modalFullSize').on('shown.bs.modal', function () {
                $('body .modal-backdrop.show').css({"opacity": '1'})
                $(".item-slider > .add-item-favorite").css({'z-index': '2000', 'top': '-100%', 'right': '20px', 'left': 'auto'})
            })

            $('#modalFullSize').on('hide.bs.modal', function () {
                $('body .modal-backdrop.show').css({"opacity": '0.5'})
                $(".item-slider > .add-item-favorite").css({'z-index': '2', 'top': '20px', 'right': 'auto', 'left': '20px'})
            })
        } else {
            $('#modalFullSize').on('shown.bs.modal', function () {
                $('body .modal-backdrop.show').css({'opacity': '0.8', 'background-color' : '#d5d5d5'})
            })

            $('#modalFullSize').on('hide.bs.modal', function () {
                $('body .modal-backdrop.show').css({'opacity': '0.8', 'background-color' : '#d5d5d5'})
            })
        }
    });

    // Slider Counter
    $itemSlider.on('slid.bs.carousel', function (e) {
        $itemSlider.find('.current-slide-number').text(e.to + 1);
    })

    $('#modalSandMessage').on('show.bs.modal', () => {
        $('#modalFullSize').modal('hide')
    })

    $('#modalSandMessage').on('shown.bs.modal', () => {
        $body.addClass('modal-open')

        new FileUploader(
            // container where will images rendered (prepend method useing)
            '#fileUploaderRenderMessageContainer',
            // single input file element, all files will be merged there
            '#fileUploaderMessageFiles',
            // render image templte
            // {{example}} - placeholders for templateOptions render (dataUrl at lest required)
            // data-file-id - container
            // data-file-remove-id - data for remove btn (whould has the same as container value)

            `<div class="ml-3 d-flex align-items-center justify-content-center upload-file" data-file-id="{{name}}">
        <button type="button" class="mr-2 close" data-file-remove-id="{{name}}">
          <span>&times;</span>
        </button>
  
        <span class="upload-file__name">{{name}}</span>
      </div>`,
        )
    })

    /**
     * Filter
     */
    class Filter {
        filterData = {}

        constructor(formSelector) {
            const $form = $(formSelector)

            if (!$form) {
                return false
            }

            const $items = $(`[data-filter-for="${formSelector}"]`)

            $form.on('keyup change paste', 'input, select, textarea', (e) => {
                this.filterData = {...this.filterData, [e.target.name]:e.target.value}

                $items.each((_, el) => {
                    const $el = $(el);
                    let isFind = true;

                    Object.entries(this.filterData).map(([name, value]) => value).forEach((filterDataItem) => {
                        if (!$el.data('filter').includes(filterDataItem)) isFind = false
                    })

                    $el.toggleClass('d-none', !isFind);
                })
            });
        }
    }

    new Filter('#brandFilter')
    new Filter('#userItemFilter')
    new Filter('#nameFilter')

    /**
     * Wizard
     */
    class Wizard {
        options = {
            wrapperSelector: '#wizard',
            stepSelector: '.wizard-step',
            contentSelector: '.wizard-content',
            controlNextSelector: '.wizard-control-next',
            controlPrevSelector: '.wizard-control-prev',
            controlFinalSelector: '.wizard-control-final',
            activeClass: 'active',
            completedClass: 'completed'
        }

        activeStep = 0;

        afterSelectCb = () => {}

        constructor(options = {}, afterSelectCb) {
            this.options = {
                ...this.options,
                ...options,
            };

            this.afterSelectCb = afterSelectCb;

            this.steps = $(`${this.options.wrapperSelector} ${this.options.stepSelector}`);
            this.content = $(`${this.options.wrapperSelector} ${this.options.contentSelector}`);
            this.nextControl = $(`${this.options.wrapperSelector} ${this.options.controlNextSelector}`);
            this.prevControl = $(`${this.options.wrapperSelector} ${this.options.controlPrevSelector}`);
            this.finalControl = $(`${this.options.wrapperSelector} ${this.options.controlFinalSelector}`);

            this.nextControl.on('click', () => {
                this.selectStep(this.activeStep + 1);
            })

            this.prevControl.on('click', () => {
                this.selectStep(this.activeStep - 1);
            })

            this.selectStep(this.activeStep);
        }


        get stepsNumber() {
            return this.content.length;
        }

        selectStep = (index) => {
            const activeClass = this.options.activeClass;
            const completedClass = this.options.completedClass;

            if (this.stepsNumber <= index || index < 0) {
                return false
            }

            this.activeStep = index;

            this.nextControl.removeClass(activeClass)
            this.prevControl.removeClass(activeClass)
            this.finalControl.removeClass(activeClass)

            this.steps.removeClass(activeClass).each((_, el) => {
                if (Number($(el).data('wizardStep')) < index) {
                    $(el).addClass(completedClass)
                }

                if (Number($(el).data('wizardStep')) === index) {
                    $(el).addClass(activeClass)
                }
            })

            this.content.removeClass(activeClass)
            $(`[data-wizard-content="${index}"]`).addClass(activeClass)

            if (index === 0) {
                this.nextControl.addClass(activeClass)
            } else if (index !== this.stepsNumber - 1) {
                this.nextControl.addClass(activeClass)
                this.prevControl.addClass(activeClass)
            } else {
                this.prevControl.addClass(activeClass)
                this.finalControl.addClass(activeClass)
            }

            this.afterSelectCb(index)
        }
    }

    new Wizard({}, () => {
        if($('#map').length > 0) {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
            });
        }
    });

    /**
     * File uploader
     */
    class FileUploader {
        fileList = null

        template = ''

        templateOptions = {
            name: 'name',
        }

        constructor(renderContainerId, fileListId, template) {
            const self = this
            this.renderContainerId = renderContainerId
            this.fileListId = fileListId
            this.template = template

            $(fileListId).on('change', (e) => {
                this.addFiles(e.target.files)

                e.target.value = ''
            })

            $(document).on('click', '[data-file-remove-id]', function() {
                self.removeFile($(this).data('fileRemoveId'));
            })

            $(document).on('click', '.rotate-control', function() {
                const $rotateInput = $(this).find('input');
                const currentRotate = Number($rotateInput.val()) || 0;
                const newRotate = (currentRotate + 90) % 360;

                $(this).closest('[data-file-id]').find('.rotate-img')
                    .css({ 'transform': `rotate(${newRotate}deg)` })

                $rotateInput.val(newRotate)
            })
        }

        readFileAsync = (file) => {
            return new Promise((resolve, reject) => {
                let reader = new FileReader();

                reader.onload = () => {
                    resolve(reader.result);
                };

                reader.onerror = reject;

                reader.readAsDataURL(file);
            })
        }

        updateOutputInput = () => {
            const $fileListInput = $(this.fileListId)

            if ($fileListInput && this.fileList) {
                $fileListInput[0].files = this.fileList;
            }
        }

        addFiles = (files) => {
            const newFilesArr = Array.from(files)
            const allFiles = [...Array.from(this.fileList || []), ...newFilesArr]

            this.fileList = allFiles.reduce((dt, file) => {
                dt.items.add(file)

                return dt;
            }, new DataTransfer()).files;

            newFilesArr.forEach(async (file) => {
                const dataUrl  = await this.readFileAsync(file);

                const filledTemplate = Object.entries(this.templateOptions).reduce((tmp, [key, value]) => {
                    const output = tmp.replaceAll(`{{${key}}}`, file[value])

                    return output
                }, this.template.replace('{{dataUrl}}', dataUrl))

                $(this.renderContainerId).prepend(filledTemplate)
            })

            this.updateOutputInput()
        }

        removeFile = (fileId) => {
            const dt = new DataTransfer()
            // const filteredFiles = Array.from(this.fileList).filter((file) => file.name !== fileId)
            // filteredFiles.forEach((file) => dt.items.add(file))

            // this.fileList = dt.files

            // this.updateOutputInput()

            $(`[data-file-id="${fileId}"]`).remove()
        }
    }

    new FileUploader(
        // container where will images rendered (prepend method useing)
        '#fileUploaderRenderContainer',
        // single input file element, all files will be merged there
        '#fileUploaderFiles',
        // render image templte
        // {{example}} - placeholders for templateOptions render (dataUrl at lest required)
        // data-file-id - container
        // data-file-remove-id - data for remove btn (whould has the same as container value)
        // .rotate-control button to rotate image
        // .rotate-img - element for rotating
        `<div class="mb-4 col" data-file-id="{{name}}">
      <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="mb-3 d-flex justify-content-center align-items-center photo">
          <img src="{{dataUrl}}" class="rotate-img">
        </div>
        
        <label class="mb-2 p-0 btn text-center text-primary">
          <input type="radio" name="fileMain" value="{{name}}" class="d-none" />
          Set as main
        </label>
  
        <div class="d-flex justify-content-around">
          <div class="mr-3 d-flex justify-content-center align-items-center element-control" data-file-remove-id="{{name}}">
            <i class="mr-2 icon-clear"></i>
            <span class="d-none d-lg-inline-block">Delete</span>
          </div>
  
          <div class="d-flex justify-content-center align-items-center element-control rotate-control">
            <input type="hidden" name="rotate[{{name}}]" value="0" />
            <i class="mr-2 icon-replay"></i>
            <span class="d-none d-lg-inline-block">Rotate</span>
          </div>
        </div>
      </div>
    </div>`,
    )

    /**
     * Range sliders
     */
    class RangeSlider {
        constructor(elementId) {
            this.elementId = elementId;

            const element = document.getElementById(this.elementId);

            if (element) {
                this.element = element;

                this.init();
            }
        }

        init() {
            const { rangeMin = 0, rangeMax = 100 } = this.element.dataset;

            this.slider = noUiSlider.create(this.element, {
                start: [Number(rangeMin), Number(rangeMax)],
                connect: true,
                step: 1,
                direction: 'rtl',
                range: {
                    min: Number(rangeMin),
                    max: Number(rangeMax),
                },
                format: {
                    to: (value) => Math.round(value),
                    from: (value) => Number(value) || 0,
                },
            });

            const minInput = document.querySelector(`[data-range-min-connected="${this.elementId}"]`);
            const maxInput = document.querySelector(`[data-range-max-connected="${this.elementId}"]`);

            if (minInput && maxInput) {
                this.slider.on('update', () => {
                    const [minValue, maxValue] = this.slider.get();
                    minInput.value = minValue;
                    maxInput.value = maxValue;
                })

                minInput.addEventListener('change', (e) => {
                    this.slider.set([e.target.value, null])
                })

                maxInput.addEventListener('change', (e) => {
                    this.slider.set([null, e.target.value])
                })
            }

            const setters = document.querySelectorAll(`[data-range-connected="${this.elementId}"]`);

            if (setters.length) {
                setters.forEach((node) => {
                    node.addEventListener('click', (e) => {
                        this.slider.set(e.target.dataset.rangeSet.split(','))
                    })
                })
            }
        }
    }

    new RangeSlider('rangeSlider');
    new RangeSlider('rangeSliderMainFilterMobile');
})();


/**
 * Alerts
 */
$('#alertInformer').on('click', function () {
    $('.alert-informer').addClass('show');

    setTimeout(function () {
        $('.alert-informer').removeClass('show');
    }, 2500)
})

$('#alertConfirmation').on('click', function () {
    $('.alert-confirmation').addClass('show');
})

$('.allert .close').click(() => {
    $('.allert').removeClass('show')
})

// Dependense lists START
const btnFirstDropD = $(".first-drop");
const btnSecondDropD = $(".second-drop");
const countryList = $(".show-country");
const cityList = $(".show-city");

const placesList = {
    by: ["Minsk", "Grodno", "Gomel"],
    ru: ["Moskow", "SPB", "Samara"],
    pl: ["Warsawa", "Lublin", "Gdansk"]
};

countryList.on("click", function (e) {
    let target = e.target.value;
    let countryName = e.target.closest("label").textContent;

    showCityThisCountry(target);
    checkedElement(countryName, btnFirstDropD);

    countryList.removeClass("active");

    if (cityList.hasClass('active') === true) {
        cityList.toggleClass("active");
    }
});

cityList.on("click", function (e) {
    let target = e.target.closest("label").textContent;

    checkedElement(target, btnSecondDropD);

    cityList.toggleClass("active");

    if (countryList.hasClass('active') === true) {
        countryList.toggleClass("active");
    }
});

const showCityThisCountry = (countryName) => {
    if (placesList[countryName]) {
        cityList.empty();

        placesList[countryName].forEach((element) => {
            cityList.append(
                `<li><label for="city"><input name="city" value='${element}' type="radio">${element}</label></li>`
            );
        });

        checkedElement(placesList[countryName][0], btnSecondDropD);
    }
};

const checkedElement = (name, renderTo) => {
    renderTo.empty();
    renderTo.append(name);
};

btnFirstDropD.on("click", () => {
    countryList.toggleClass("active");
});

btnSecondDropD.on("click", () => {
    cityList.toggleClass("active");
});
// Dependense lists END

// Header property filters / dropdown
const dropdownElems = [$('.dropdown-prise'), $('.dropdown-room-number'), $('.dropdown-building-type'), $('.dropdown-area')]
const dropdownBtn = [$('.buttonShowPropertyFilterPrice'), $('.buttonShowPropertyFilterRoom'), $('.buttonShowPropertyFilterType'), $('.buttonShowPropertyFilterArea')]

$('.buttonShowPropertyFilterPrice').click(function(e) {
    $(this).toggleClass('active')
    remooveDropDownActiveMenu(dropdownElems[0])
})

$('.buttonShowPropertyFilterRoom').click(function() {
    $(this).toggleClass('active')
    remooveDropDownActiveMenu(dropdownElems[1])
})

$('.buttonShowPropertyFilterType').click(function() {
    $(this).toggleClass('active')
    remooveDropDownActiveMenu(dropdownElems[2])
})

$('.buttonShowPropertyFilterArea').click(function() {
    $(this).toggleClass('active')
    remooveDropDownActiveMenu(dropdownElems[3])
})

function remooveDropDownActiveMenu(elem) {
    elem.attr("class").split(/\s+/).forEach((item) => {
        if(item === 'active') {
            elem.removeClass('active')
        } else {
            dropdownElems.forEach(i => i.removeClass('active'));
            elem.addClass('active')
        }
    })
}

// Price filter
let userPrise = [0, 0];
let userAreaRange = [0, 0];
const showUserPrice = document.querySelector('.houseRentUserPrise');
const showUserPriceBuy = document.querySelector('.houseBuyUserPrise');
const showAreaRange = document.querySelector('.rentAreaCommerce');
const showAreaRangeBuy = document.querySelector('.buyAreaCommerce');

const typePropertyRentCommerce = document.querySelector('.typePropertyRentCommerce')
const typePropertyBuyCommerce = document.querySelector('.typePropertyBuyCommerce')
const typePropertyRent = document.querySelector('.typePropertyRent')
const typePropertyBuy = document.querySelector('.typePropertyBuy')


function howItPrice(priceElement) {
    if (userPrise[0] > 0) {
        priceElement.textContent = `от ${userPrise[0]}`
    }

    if (userPrise[0] > userPrise[1] && userPrise[1] > 1) {
        priceElement.textContent = `до ${userPrise[1]}`
    }

    if (userPrise[1] > 0) {
        priceElement.textContent = `до ${userPrise[1]}`
    }

    if (userPrise[0] > 0 && userPrise[1] > 0) {
        priceElement.textContent = `${userPrise[0]} - ${userPrise[1]}`
    }

    if (userPrise[0] === userPrise[1]) {
        priceElement.textContent = `от ${userPrise[0]}`
    }
}

function howItAreaRange(priceElement) {
    if (userAreaRange[0] > 0) {
        priceElement.textContent = `от ${userAreaRange[0]}`
    }

    if (userAreaRange[0] > userAreaRange[1] && userAreaRange[1] > 1) {
        priceElement.textContent = `до ${userAreaRange[1]}`
    }

    if (userAreaRange[1] > 0) {
        priceElement.textContent = `до ${userAreaRange[1]}`
    }

    if (userAreaRange[0] > 0 && userAreaRange[1] > 0) {
        priceElement.textContent = `${userAreaRange[0]} - ${userAreaRange[1]}`
    }

    if (userAreaRange[0] === userAreaRange[1]) {
        priceElement.textContent = `от ${userAreaRange[0]}`
    }
}

// PRICE RANGE
$('.priceMin').keyup(function () {
    userPrise[0] = this.value;

    if (data.category === 'rent') {
        howItPrice(showUserPrice);
    } else {
        howItPrice(showUserPriceBuy);
    }
})

$('.priceMax').keyup(function () {
    userPrise[1] = this.value;

    if (data.category === 'rent') {
        howItPrice(showUserPrice);
    } else {
        howItPrice(showUserPriceBuy);
    }
})

// AREA RANGE
$('.inputAreaMin').keyup(function () {
    userAreaRange[0] = this.value;

    if (data.category === 'rent') {
        howItAreaRange(showAreaRange);
    } else {
        howItAreaRange(showAreaRangeBuy);
    }
})

$('.inputAreaMax').keyup(function () {
    userAreaRange[1] = this.value;

    if (data.category === 'rent') {
        howItAreaRange(showAreaRange);
    } else {
        howItAreaRange(showAreaRangeBuy);
    }
})


const categorySelector = ".category";
const categoryMobileSelector = ".categoryMobile"
const rentForm = "#mainFiltersRent";
const buyForm = "#mainFiltersBuy";
const rentFormMobile = "#mainFiltersRentMobile";
const buyFormMobile = "#mainFiltersBuyMobile";
const roomNumer = $('.countRoomNumberFilter');
const priceFilter = $('.houseRentUserPrise');
const typeProperty = $('.typeProperty');

let data = {}

const categoryName = $(categorySelector).attr("name");
const categoryNameMobile = $(categoryMobileSelector).attr("name");

const forms = $(`${rentForm}, ${buyForm}, ${rentFormMobile}, ${buyFormMobile}`);

// Handler show full string with tags parametr filter
const hendleMoreTags = (dataArray) => {
    const nonEmptyCount = dataArray.reduce((acc, [_, value]) => value ? acc + 1 : acc, 0)

    if (nonEmptyCount <= 3) {
        $('.showAllTags').removeClass('active')
    } else {
        $('.showAllTags').addClass('active')
    }
}

// рендер тегов
const renderTags = () => {
    $(".tags .option-item").remove();

    const dataArray = Object.entries(data)

    dataArray.forEach(([name, value]) => {
        if (![categoryName].includes(name) && value) {
            const text = Array.isArray(value) ? value.join(", ") : value;

            switch (name) {
                case 'area':
                {
                    if (Array.isArray(value)) {
                        roomNumer.empty()

                        const valArea = value.reduce((acc, n, i, array) => {
                            if (i === 0 || i === array.length - 1) {
                                acc.push(n + (i === 0 && array.length > 1 ? '-' : ''));
                            } else {
                                let nextEl = array[i+1];

                                if (nextEl && nextEl - n > 0.5) {
                                    acc.push(n, ', ' , nextEl + (i + 1 === array.length - 1 ? '' : '-'));
                                }
                            }
                            return acc;
                        }, []).join('');

                        roomNumer.append(valArea);

                    } else if (value === '') {
                        roomNumer.empty()
                        roomNumer.append("Число комнат");
                    } else {
                        roomNumer.empty()
                        roomNumer.append(value);
                    }
                }
                    break;

                case 'check-in-date':
                {
                    if (value) {
                        $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} :Дата въезда</span></div>`)
                    }
                }
                    break;

                case 'price':
                case 'rentAreaCommerce':
                case 'buyAreaCommerce':
                    break;

                case 'fullAreaRent':
                case 'fullAreaBuy':
                {
                    if (value === '') {
                        $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title"><strong>м²</strong> от ${value} :Площадь общая</span></div>`)
                    } else {
                        $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title"><strong>м²</strong> от ${value[1]} до ${value[0]} :Площадь общая</span></div>`)
                    }
                }
                    break;

                case 'noFirstFloreRent':
                    $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} :Этаж</span></div>`)

                    break;

                case 'noLastFloreRent':
                    $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} :Этаж</span></div>`)
                    break;

                case 'fleatRent':
                case 'fleatBuy':
                {
                    if (Array.isArray(value)) {
                        $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value[0]} - ${value[1]} : Этаж</span></div>`)
                    } else {
                        $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} : Этаж</span></div>`)
                    }
                }
                    break;

                case 'equipment1Rent':
                case 'equipment2Rent':
                case 'equipment3Rent':
                case 'equipment4Rent':
                case 'equipment5Rent':

                    $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">Есть :${value}</span></div>`)
                    break;

                case 'areaTypeBuilduing':
                    if (Array.isArray(value)) {
                        typeProperty.empty()
                        typeProperty.append(data.areaTypeBuilduing.join(', '));
                    } else {
                        typeProperty.empty()
                        typeProperty.append(data.areaTypeBuilduing);
                    }

                    break;

                case 'paymentType':

                    $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} :Вид оплаты</span></div>`)
                    break;

                default:
                    // do this
                    $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${text}</span></div>`)
                    break;
            }
        }
    });

    hendleMoreTags(dataArray)
};

// сохранение данных в скрытую форму для отправки
const setDataToForm = (data) => {
    $("#allFilters").val(JSON.stringify(data));
};

// формирование и запись данных
const updateData = (values) => {
    const screenWidth = window.screen.width;

    data = {
        [categoryName]: $(`${categorySelector}:checked`).val(),
        ...values
    };


    if (screenWidth < 768) {
        data = {
            [categoryNameMobile]: $(`${categoryMobileSelector}:checked`).val(),
            ...values
        };
    }


    setDataToForm(data);
    renderTags();
};

const resetAllForms = () => {
    // ресет сохраненных данных
    updateData({});

    // ресет всех форм
    $(rentForm)[0].reset();
    $(buyForm)[0].reset();
    $(rentFormMobile)[0].reset();
    $(buyFormMobile)[0].reset();
}


// изменение категории
$(categorySelector).on("change", (e) => {
    $(".main-filters, .modals").toggleClass("hide");

    resetAllForms()
});

$(categoryMobileSelector).on("change", (e) => {
    $(".main-filters, .modals").toggleClass("hide");

    resetAllForms()
});

$('.ressetFilterAll').on('click', () => {
    resetAllForms()
})

// отправка форм на изменение филдов
forms.find("input").on("change", function () {
    $(this).parents().filter("form").submit();
});

// прерываем отправку формы и записываем данные
forms.submit(function (e) {
    e.preventDefault();

    const formData = $(this)
        .serializeArray()
        .reduce((acc, { name, value }) => {
            if (acc[name]) {
                if (Array.isArray(acc[name])) {
                    return { ...acc, [name]: [...acc[name], value] };
                } else {
                    return { ...acc, [name]: [acc[name], value] };
                }
            }

            return { ...acc, [name]: value };
        }, {});

    updateData(formData);
});

// удаление тега и очистка значений в формах по кликку на него
$(document).on("click", "[data-clear-name]", function (e) {
    const name = $(this).data("clearName");

    const form = $(this).parents().filter("form");

    form
        .find(`input[name="${name}"]`)
        .each(function () {
            switch ($(this).attr("type")) {
                case "checkbox":
                case "radio":
                    $(this).prop("checked", false);
                    break;

                default:
                    $(this).val("");
                    break;
            }
        })
        .submit();
});

// handling to the top property page
$(document).ready(function() {
    const btnToTheTop = $('#btnToTheTop');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btnToTheTop.addClass('show');
        } else {
            btnToTheTop.removeClass('show');
        }
    });

    btnToTheTop.on('click', function(e) {
        e.preventDefault();
        $(document).scrollTop(0)
    });
})
/*
     _ _      _       _
 ___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                   |__/

 Version: 1.8.0
  Author: Ken Wheeler
 Website: http://kenwheeler.github.io
    Docs: http://kenwheeler.github.io/slick
    Repo: http://github.com/kenwheeler/slick
  Issues: http://github.com/kenwheeler/slick/issues

 */
/* global window, document, define, jQuery, setInterval, clearInterval */
;(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }

}(function($) {
    'use strict';
    var Slick = window.Slick || {};

    Slick = (function() {

        var instanceUid = 0;

        function Slick(element, settings) {

            var _ = this, dataSettings;

            _.defaults = {
                accessibility: true,
                adaptiveHeight: false,
                appendArrows: $(element),
                appendDots: $(element),
                arrows: true,
                asNavFor: null,
                prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                autoplay: false,
                autoplaySpeed: 3000,
                centerMode: false,
                centerPadding: '50px',
                cssEase: 'ease',
                customPaging: function(slider, i) {
                    return $('<button type="button" />').text(i + 1);
                },
                dots: false,
                dotsClass: 'slick-dots',
                draggable: true,
                easing: 'linear',
                edgeFriction: 0.35,
                fade: false,
                focusOnSelect: false,
                focusOnChange: false,
                infinite: true,
                initialSlide: 0,
                lazyLoad: 'ondemand',
                mobileFirst: false,
                pauseOnHover: true,
                pauseOnFocus: true,
                pauseOnDotsHover: false,
                respondTo: 'window',
                responsive: null,
                rows: 1,
                rtl: false,
                slide: '',
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: true,
                swipeToSlide: false,
                touchMove: true,
                touchThreshold: 5,
                useCSS: true,
                useTransform: true,
                variableWidth: false,
                vertical: false,
                verticalSwiping: false,
                waitForAnimate: true,
                zIndex: 1000
            };

            _.initials = {
                animating: false,
                dragging: false,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                scrolling: false,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: false,
                slideOffset: 0,
                swipeLeft: null,
                swiping: false,
                $list: null,
                touchObject: {},
                transformsEnabled: false,
                unslicked: false
            };

            $.extend(_, _.initials);

            _.activeBreakpoint = null;
            _.animType = null;
            _.animProp = null;
            _.breakpoints = [];
            _.breakpointSettings = [];
            _.cssTransitions = false;
            _.focussed = false;
            _.interrupted = false;
            _.hidden = 'hidden';
            _.paused = true;
            _.positionProp = null;
            _.respondTo = null;
            _.rowCount = 1;
            _.shouldClick = true;
            _.$slider = $(element);
            _.$slidesCache = null;
            _.transformType = null;
            _.transitionType = null;
            _.visibilityChange = 'visibilitychange';
            _.windowWidth = 0;
            _.windowTimer = null;

            dataSettings = $(element).data('slick') || {};

            _.options = $.extend({}, _.defaults, settings, dataSettings);

            _.currentSlide = _.options.initialSlide;

            _.originalSettings = _.options;

            if (typeof document.mozHidden !== 'undefined') {
                _.hidden = 'mozHidden';
                _.visibilityChange = 'mozvisibilitychange';
            } else if (typeof document.webkitHidden !== 'undefined') {
                _.hidden = 'webkitHidden';
                _.visibilityChange = 'webkitvisibilitychange';
            }

            _.autoPlay = $.proxy(_.autoPlay, _);
            _.autoPlayClear = $.proxy(_.autoPlayClear, _);
            _.autoPlayIterator = $.proxy(_.autoPlayIterator, _);
            _.changeSlide = $.proxy(_.changeSlide, _);
            _.clickHandler = $.proxy(_.clickHandler, _);
            _.selectHandler = $.proxy(_.selectHandler, _);
            _.setPosition = $.proxy(_.setPosition, _);
            _.swipeHandler = $.proxy(_.swipeHandler, _);
            _.dragHandler = $.proxy(_.dragHandler, _);
            _.keyHandler = $.proxy(_.keyHandler, _);

            _.instanceUid = instanceUid++;

            // A simple way to check for HTML strings
            // Strict HTML recognition (must start with <)
            // Extracted from jQuery v1.11 source
            _.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;


            _.registerBreakpoints();
            _.init(true);

        }

        return Slick;

    }());

    Slick.prototype.activateADA = function() {
        var _ = this;

        _.$slideTrack.find('.slick-active').attr({
            'aria-hidden': 'false'
        }).find('a, input, button, select').attr({
            'tabindex': '0'
        });

    };

    Slick.prototype.addSlide = Slick.prototype.slickAdd = function(markup, index, addBefore) {

        var _ = this;

        if (typeof(index) === 'boolean') {
            addBefore = index;
            index = null;
        } else if (index < 0 || (index >= _.slideCount)) {
            return false;
        }

        _.unload();

        if (typeof(index) === 'number') {
            if (index === 0 && _.$slides.length === 0) {
                $(markup).appendTo(_.$slideTrack);
            } else if (addBefore) {
                $(markup).insertBefore(_.$slides.eq(index));
            } else {
                $(markup).insertAfter(_.$slides.eq(index));
            }
        } else {
            if (addBefore === true) {
                $(markup).prependTo(_.$slideTrack);
            } else {
                $(markup).appendTo(_.$slideTrack);
            }
        }

        _.$slides = _.$slideTrack.children(this.options.slide);

        _.$slideTrack.children(this.options.slide).detach();

        _.$slideTrack.append(_.$slides);

        _.$slides.each(function(index, element) {
            $(element).attr('data-slick-index', index);
        });

        _.$slidesCache = _.$slides;

        _.reinit();

    };

    Slick.prototype.animateHeight = function() {
        var _ = this;
        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.animate({
                height: targetHeight
            }, _.options.speed);
        }
    };

    Slick.prototype.animateSlide = function(targetLeft, callback) {

        var animProps = {},
            _ = this;

        _.animateHeight();

        if (_.options.rtl === true && _.options.vertical === false) {
            targetLeft = -targetLeft;
        }
        if (_.transformsEnabled === false) {
            if (_.options.vertical === false) {
                _.$slideTrack.animate({
                    left: targetLeft
                }, _.options.speed, _.options.easing, callback);
            } else {
                _.$slideTrack.animate({
                    top: targetLeft
                }, _.options.speed, _.options.easing, callback);
            }

        } else {

            if (_.cssTransitions === false) {
                if (_.options.rtl === true) {
                    _.currentLeft = -(_.currentLeft);
                }
                $({
                    animStart: _.currentLeft
                }).animate({
                    animStart: targetLeft
                }, {
                    duration: _.options.speed,
                    easing: _.options.easing,
                    step: function(now) {
                        now = Math.ceil(now);
                        if (_.options.vertical === false) {
                            animProps[_.animType] = 'translate(' +
                                now + 'px, 0px)';
                            _.$slideTrack.css(animProps);
                        } else {
                            animProps[_.animType] = 'translate(0px,' +
                                now + 'px)';
                            _.$slideTrack.css(animProps);
                        }
                    },
                    complete: function() {
                        if (callback) {
                            callback.call();
                        }
                    }
                });

            } else {

                _.applyTransition();
                targetLeft = Math.ceil(targetLeft);

                if (_.options.vertical === false) {
                    animProps[_.animType] = 'translate3d(' + targetLeft + 'px, 0px, 0px)';
                } else {
                    animProps[_.animType] = 'translate3d(0px,' + targetLeft + 'px, 0px)';
                }
                _.$slideTrack.css(animProps);

                if (callback) {
                    setTimeout(function() {

                        _.disableTransition();

                        callback.call();
                    }, _.options.speed);
                }

            }

        }

    };

    Slick.prototype.getNavTarget = function() {

        var _ = this,
            asNavFor = _.options.asNavFor;

        if ( asNavFor && asNavFor !== null ) {
            asNavFor = $(asNavFor).not(_.$slider);
        }

        return asNavFor;

    };

    Slick.prototype.asNavFor = function(index) {

        var _ = this,
            asNavFor = _.getNavTarget();

        if ( asNavFor !== null && typeof asNavFor === 'object' ) {
            asNavFor.each(function() {
                var target = $(this).slick('getSlick');
                if(!target.unslicked) {
                    target.slideHandler(index, true);
                }
            });
        }

    };

    Slick.prototype.applyTransition = function(slide) {

        var _ = this,
            transition = {};

        if (_.options.fade === false) {
            transition[_.transitionType] = _.transformType + ' ' + _.options.speed + 'ms ' + _.options.cssEase;
        } else {
            transition[_.transitionType] = 'opacity ' + _.options.speed + 'ms ' + _.options.cssEase;
        }

        if (_.options.fade === false) {
            _.$slideTrack.css(transition);
        } else {
            _.$slides.eq(slide).css(transition);
        }

    };

    Slick.prototype.autoPlay = function() {

        var _ = this;

        _.autoPlayClear();

        if ( _.slideCount > _.options.slidesToShow ) {
            _.autoPlayTimer = setInterval( _.autoPlayIterator, _.options.autoplaySpeed );
        }

    };

    Slick.prototype.autoPlayClear = function() {

        var _ = this;

        if (_.autoPlayTimer) {
            clearInterval(_.autoPlayTimer);
        }

    };

    Slick.prototype.autoPlayIterator = function() {

        var _ = this,
            slideTo = _.currentSlide + _.options.slidesToScroll;

        if ( !_.paused && !_.interrupted && !_.focussed ) {

            if ( _.options.infinite === false ) {

                if ( _.direction === 1 && ( _.currentSlide + 1 ) === ( _.slideCount - 1 )) {
                    _.direction = 0;
                }

                else if ( _.direction === 0 ) {

                    slideTo = _.currentSlide - _.options.slidesToScroll;

                    if ( _.currentSlide - 1 === 0 ) {
                        _.direction = 1;
                    }

                }

            }

            _.slideHandler( slideTo );

        }

    };

    Slick.prototype.buildArrows = function() {

        var _ = this;

        if (_.options.arrows === true ) {

            _.$prevArrow = $(_.options.prevArrow).addClass('slick-arrow');
            _.$nextArrow = $(_.options.nextArrow).addClass('slick-arrow');

            if( _.slideCount > _.options.slidesToShow ) {

                _.$prevArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');
                _.$nextArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');

                if (_.htmlExpr.test(_.options.prevArrow)) {
                    _.$prevArrow.prependTo(_.options.appendArrows);
                }

                if (_.htmlExpr.test(_.options.nextArrow)) {
                    _.$nextArrow.appendTo(_.options.appendArrows);
                }

                if (_.options.infinite !== true) {
                    _.$prevArrow
                        .addClass('slick-disabled')
                        .attr('aria-disabled', 'true');
                }

            } else {

                _.$prevArrow.add( _.$nextArrow )

                    .addClass('slick-hidden')
                    .attr({
                        'aria-disabled': 'true',
                        'tabindex': '-1'
                    });

            }

        }

    };

    Slick.prototype.buildDots = function() {

        var _ = this,
            i, dot;

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$slider.addClass('slick-dotted');

            dot = $('<ul />').addClass(_.options.dotsClass);

            for (i = 0; i <= _.getDotCount(); i += 1) {
                dot.append($('<li />').append(_.options.customPaging.call(this, _, i)));
            }

            _.$dots = dot.appendTo(_.options.appendDots);

            _.$dots.find('li').first().addClass('slick-active');

        }

    };

    Slick.prototype.buildOut = function() {

        var _ = this;

        _.$slides =
            _.$slider
                .children( _.options.slide + ':not(.slick-cloned)')
                .addClass('slick-slide');

        _.slideCount = _.$slides.length;

        _.$slides.each(function(index, element) {
            $(element)
                .attr('data-slick-index', index)
                .data('originalStyling', $(element).attr('style') || '');
        });

        _.$slider.addClass('slick-slider');

        _.$slideTrack = (_.slideCount === 0) ?
            $('<div class="slick-track"/>').appendTo(_.$slider) :
            _.$slides.wrapAll('<div class="slick-track"/>').parent();

        _.$list = _.$slideTrack.wrap(
            '<div class="slick-list"/>').parent();
        _.$slideTrack.css('opacity', 0);

        if (_.options.centerMode === true || _.options.swipeToSlide === true) {
            _.options.slidesToScroll = 1;
        }

        $('img[data-lazy]', _.$slider).not('[src]').addClass('slick-loading');

        _.setupInfinite();

        _.buildArrows();

        _.buildDots();

        _.updateDots();


        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);

        if (_.options.draggable === true) {
            _.$list.addClass('draggable');
        }

    };

    Slick.prototype.buildRows = function() {

        var _ = this, a, b, c, newSlides, numOfSlides, originalSlides,slidesPerSection;

        newSlides = document.createDocumentFragment();
        originalSlides = _.$slider.children();

        if(_.options.rows > 0) {

            slidesPerSection = _.options.slidesPerRow * _.options.rows;
            numOfSlides = Math.ceil(
                originalSlides.length / slidesPerSection
            );

            for(a = 0; a < numOfSlides; a++){
                var slide = document.createElement('div');
                for(b = 0; b < _.options.rows; b++) {
                    var row = document.createElement('div');
                    for(c = 0; c < _.options.slidesPerRow; c++) {
                        var target = (a * slidesPerSection + ((b * _.options.slidesPerRow) + c));
                        if (originalSlides.get(target)) {
                            row.appendChild(originalSlides.get(target));
                        }
                    }
                    slide.appendChild(row);
                }
                newSlides.appendChild(slide);
            }

            _.$slider.empty().append(newSlides);
            _.$slider.children().children().children()
                .css({
                    'width':(100 / _.options.slidesPerRow) + '%',
                    'display': 'inline-block'
                });

        }

    };

    Slick.prototype.checkResponsive = function(initial, forceUpdate) {

        var _ = this,
            breakpoint, targetBreakpoint, respondToWidth, triggerBreakpoint = false;
        var sliderWidth = _.$slider.width();
        var windowWidth = window.innerWidth || $(window).width();

        if (_.respondTo === 'window') {
            respondToWidth = windowWidth;
        } else if (_.respondTo === 'slider') {
            respondToWidth = sliderWidth;
        } else if (_.respondTo === 'min') {
            respondToWidth = Math.min(windowWidth, sliderWidth);
        }

        if ( _.options.responsive &&
            _.options.responsive.length &&
            _.options.responsive !== null) {

            targetBreakpoint = null;

            for (breakpoint in _.breakpoints) {
                if (_.breakpoints.hasOwnProperty(breakpoint)) {
                    if (_.originalSettings.mobileFirst === false) {
                        if (respondToWidth < _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    } else {
                        if (respondToWidth > _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    }
                }
            }

            if (targetBreakpoint !== null) {
                if (_.activeBreakpoint !== null) {
                    if (targetBreakpoint !== _.activeBreakpoint || forceUpdate) {
                        _.activeBreakpoint =
                            targetBreakpoint;
                        if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                            _.unslick(targetBreakpoint);
                        } else {
                            _.options = $.extend({}, _.originalSettings,
                                _.breakpointSettings[
                                    targetBreakpoint]);
                            if (initial === true) {
                                _.currentSlide = _.options.initialSlide;
                            }
                            _.refresh(initial);
                        }
                        triggerBreakpoint = targetBreakpoint;
                    }
                } else {
                    _.activeBreakpoint = targetBreakpoint;
                    if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                        _.unslick(targetBreakpoint);
                    } else {
                        _.options = $.extend({}, _.originalSettings,
                            _.breakpointSettings[
                                targetBreakpoint]);
                        if (initial === true) {
                            _.currentSlide = _.options.initialSlide;
                        }
                        _.refresh(initial);
                    }
                    triggerBreakpoint = targetBreakpoint;
                }
            } else {
                if (_.activeBreakpoint !== null) {
                    _.activeBreakpoint = null;
                    _.options = _.originalSettings;
                    if (initial === true) {
                        _.currentSlide = _.options.initialSlide;
                    }
                    _.refresh(initial);
                    triggerBreakpoint = targetBreakpoint;
                }
            }

            // only trigger breakpoints during an actual break. not on initialize.
            if( !initial && triggerBreakpoint !== false ) {
                _.$slider.trigger('breakpoint', [_, triggerBreakpoint]);
            }
        }

    };

    Slick.prototype.changeSlide = function(event, dontAnimate) {

        var _ = this,
            $target = $(event.currentTarget),
            indexOffset, slideOffset, unevenOffset;

        // If target is a link, prevent default action.
        if($target.is('a')) {
            event.preventDefault();
        }

        // If target is not the <li> element (ie: a child), find the <li>.
        if(!$target.is('li')) {
            $target = $target.closest('li');
        }

        unevenOffset = (_.slideCount % _.options.slidesToScroll !== 0);
        indexOffset = unevenOffset ? 0 : (_.slideCount - _.currentSlide) % _.options.slidesToScroll;

        switch (event.data.message) {

            case 'previous':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : _.options.slidesToShow - indexOffset;
                if (_.slideCount > _.options.slidesToShow) {
                    _.slideHandler(_.currentSlide - slideOffset, false, dontAnimate);
                }
                break;

            case 'next':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : indexOffset;
                if (_.slideCount > _.options.slidesToShow) {
                    _.slideHandler(_.currentSlide + slideOffset, false, dontAnimate);
                }
                break;

            case 'index':
                var index = event.data.index === 0 ? 0 :
                    event.data.index || $target.index() * _.options.slidesToScroll;

                _.slideHandler(_.checkNavigable(index), false, dontAnimate);
                $target.children().trigger('focus');
                break;

            default:
                return;
        }

    };

    Slick.prototype.checkNavigable = function(index) {

        var _ = this,
            navigables, prevNavigable;

        navigables = _.getNavigableIndexes();
        prevNavigable = 0;
        if (index > navigables[navigables.length - 1]) {
            index = navigables[navigables.length - 1];
        } else {
            for (var n in navigables) {
                if (index < navigables[n]) {
                    index = prevNavigable;
                    break;
                }
                prevNavigable = navigables[n];
            }
        }

        return index;
    };

    Slick.prototype.cleanUpEvents = function() {

        var _ = this;

        if (_.options.dots && _.$dots !== null) {

            $('li', _.$dots)
                .off('click.slick', _.changeSlide)
                .off('mouseenter.slick', $.proxy(_.interrupt, _, true))
                .off('mouseleave.slick', $.proxy(_.interrupt, _, false));

            if (_.options.accessibility === true) {
                _.$dots.off('keydown.slick', _.keyHandler);
            }
        }

        _.$slider.off('focus.slick blur.slick');

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow && _.$prevArrow.off('click.slick', _.changeSlide);
            _.$nextArrow && _.$nextArrow.off('click.slick', _.changeSlide);

            if (_.options.accessibility === true) {
                _.$prevArrow && _.$prevArrow.off('keydown.slick', _.keyHandler);
                _.$nextArrow && _.$nextArrow.off('keydown.slick', _.keyHandler);
            }
        }

        _.$list.off('touchstart.slick mousedown.slick', _.swipeHandler);
        _.$list.off('touchmove.slick mousemove.slick', _.swipeHandler);
        _.$list.off('touchend.slick mouseup.slick', _.swipeHandler);
        _.$list.off('touchcancel.slick mouseleave.slick', _.swipeHandler);

        _.$list.off('click.slick', _.clickHandler);

        $(document).off(_.visibilityChange, _.visibility);

        _.cleanUpSlideEvents();

        if (_.options.accessibility === true) {
            _.$list.off('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().off('click.slick', _.selectHandler);
        }

        $(window).off('orientationchange.slick.slick-' + _.instanceUid, _.orientationChange);

        $(window).off('resize.slick.slick-' + _.instanceUid, _.resize);

        $('[draggable!=true]', _.$slideTrack).off('dragstart', _.preventDefault);

        $(window).off('load.slick.slick-' + _.instanceUid, _.setPosition);

    };

    Slick.prototype.cleanUpSlideEvents = function() {

        var _ = this;

        _.$list.off('mouseenter.slick', $.proxy(_.interrupt, _, true));
        _.$list.off('mouseleave.slick', $.proxy(_.interrupt, _, false));

    };

    Slick.prototype.cleanUpRows = function() {

        var _ = this, originalSlides;

        if(_.options.rows > 0) {
            originalSlides = _.$slides.children().children();
            originalSlides.removeAttr('style');
            _.$slider.empty().append(originalSlides);
        }

    };

    Slick.prototype.clickHandler = function(event) {

        var _ = this;

        if (_.shouldClick === false) {
            event.stopImmediatePropagation();
            event.stopPropagation();
            event.preventDefault();
        }

    };

    Slick.prototype.destroy = function(refresh) {

        var _ = this;

        _.autoPlayClear();

        _.touchObject = {};

        _.cleanUpEvents();

        $('.slick-cloned', _.$slider).detach();

        if (_.$dots) {
            _.$dots.remove();
        }

        if ( _.$prevArrow && _.$prevArrow.length ) {

            _.$prevArrow
                .removeClass('slick-disabled slick-arrow slick-hidden')
                .removeAttr('aria-hidden aria-disabled tabindex')
                .css('display','');

            if ( _.htmlExpr.test( _.options.prevArrow )) {
                _.$prevArrow.remove();
            }
        }

        if ( _.$nextArrow && _.$nextArrow.length ) {

            _.$nextArrow
                .removeClass('slick-disabled slick-arrow slick-hidden')
                .removeAttr('aria-hidden aria-disabled tabindex')
                .css('display','');

            if ( _.htmlExpr.test( _.options.nextArrow )) {
                _.$nextArrow.remove();
            }
        }


        if (_.$slides) {

            _.$slides
                .removeClass('slick-slide slick-active slick-center slick-visible slick-current')
                .removeAttr('aria-hidden')
                .removeAttr('data-slick-index')
                .each(function(){
                    $(this).attr('style', $(this).data('originalStyling'));
                });

            _.$slideTrack.children(this.options.slide).detach();

            _.$slideTrack.detach();

            _.$list.detach();

            _.$slider.append(_.$slides);
        }

        _.cleanUpRows();

        _.$slider.removeClass('slick-slider');
        _.$slider.removeClass('slick-initialized');
        _.$slider.removeClass('slick-dotted');

        _.unslicked = true;

        if(!refresh) {
            _.$slider.trigger('destroy', [_]);
        }

    };

    Slick.prototype.disableTransition = function(slide) {

        var _ = this,
            transition = {};

        transition[_.transitionType] = '';

        if (_.options.fade === false) {
            _.$slideTrack.css(transition);
        } else {
            _.$slides.eq(slide).css(transition);
        }

    };

    Slick.prototype.fadeSlide = function(slideIndex, callback) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$slides.eq(slideIndex).css({
                zIndex: _.options.zIndex
            });

            _.$slides.eq(slideIndex).animate({
                opacity: 1
            }, _.options.speed, _.options.easing, callback);

        } else {

            _.applyTransition(slideIndex);

            _.$slides.eq(slideIndex).css({
                opacity: 1,
                zIndex: _.options.zIndex
            });

            if (callback) {
                setTimeout(function() {

                    _.disableTransition(slideIndex);

                    callback.call();
                }, _.options.speed);
            }

        }

    };

    Slick.prototype.fadeSlideOut = function(slideIndex) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$slides.eq(slideIndex).animate({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            }, _.options.speed, _.options.easing);

        } else {

            _.applyTransition(slideIndex);

            _.$slides.eq(slideIndex).css({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            });

        }

    };

    Slick.prototype.filterSlides = Slick.prototype.slickFilter = function(filter) {

        var _ = this;

        if (filter !== null) {

            _.$slidesCache = _.$slides;

            _.unload();

            _.$slideTrack.children(this.options.slide).detach();

            _.$slidesCache.filter(filter).appendTo(_.$slideTrack);

            _.reinit();

        }

    };

    Slick.prototype.focusHandler = function() {

        var _ = this;

        _.$slider
            .off('focus.slick blur.slick')
            .on('focus.slick blur.slick', '*', function(event) {

                event.stopImmediatePropagation();
                var $sf = $(this);

                setTimeout(function() {

                    if( _.options.pauseOnFocus ) {
                        _.focussed = $sf.is(':focus');
                        _.autoPlay();
                    }

                }, 0);

            });
    };

    Slick.prototype.getCurrent = Slick.prototype.slickCurrentSlide = function() {

        var _ = this;
        return _.currentSlide;

    };

    Slick.prototype.getDotCount = function() {

        var _ = this;

        var breakPoint = 0;
        var counter = 0;
        var pagerQty = 0;

        if (_.options.infinite === true) {
            if (_.slideCount <= _.options.slidesToShow) {
                ++pagerQty;
            } else {
                while (breakPoint < _.slideCount) {
                    ++pagerQty;
                    breakPoint = counter + _.options.slidesToScroll;
                    counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
                }
            }
        } else if (_.options.centerMode === true) {
            pagerQty = _.slideCount;
        } else if(!_.options.asNavFor) {
            pagerQty = 1 + Math.ceil((_.slideCount - _.options.slidesToShow) / _.options.slidesToScroll);
        }else {
            while (breakPoint < _.slideCount) {
                ++pagerQty;
                breakPoint = counter + _.options.slidesToScroll;
                counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
            }
        }

        return pagerQty - 1;

    };

    Slick.prototype.getLeft = function(slideIndex) {

        var _ = this,
            targetLeft,
            verticalHeight,
            verticalOffset = 0,
            targetSlide,
            coef;

        _.slideOffset = 0;
        verticalHeight = _.$slides.first().outerHeight(true);

        if (_.options.infinite === true) {
            if (_.slideCount > _.options.slidesToShow) {
                _.slideOffset = (_.slideWidth * _.options.slidesToShow) * -1;
                coef = -1

                if (_.options.vertical === true && _.options.centerMode === true) {
                    if (_.options.slidesToShow === 2) {
                        coef = -1.5;
                    } else if (_.options.slidesToShow === 1) {
                        coef = -2
                    }
                }
                verticalOffset = (verticalHeight * _.options.slidesToShow) * coef;
            }
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                if (slideIndex + _.options.slidesToScroll > _.slideCount && _.slideCount > _.options.slidesToShow) {
                    if (slideIndex > _.slideCount) {
                        _.slideOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * _.slideWidth) * -1;
                        verticalOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * verticalHeight) * -1;
                    } else {
                        _.slideOffset = ((_.slideCount % _.options.slidesToScroll) * _.slideWidth) * -1;
                        verticalOffset = ((_.slideCount % _.options.slidesToScroll) * verticalHeight) * -1;
                    }
                }
            }
        } else {
            if (slideIndex + _.options.slidesToShow > _.slideCount) {
                _.slideOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * _.slideWidth;
                verticalOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * verticalHeight;
            }
        }

        if (_.slideCount <= _.options.slidesToShow) {
            _.slideOffset = 0;
            verticalOffset = 0;
        }

        if (_.options.centerMode === true && _.slideCount <= _.options.slidesToShow) {
            _.slideOffset = ((_.slideWidth * Math.floor(_.options.slidesToShow)) / 2) - ((_.slideWidth * _.slideCount) / 2);
        } else if (_.options.centerMode === true && _.options.infinite === true) {
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2) - _.slideWidth;
        } else if (_.options.centerMode === true) {
            _.slideOffset = 0;
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2);
        }

        if (_.options.vertical === false) {
            targetLeft = ((slideIndex * _.slideWidth) * -1) + _.slideOffset;
        } else {
            targetLeft = ((slideIndex * verticalHeight) * -1) + verticalOffset;
        }

        if (_.options.variableWidth === true) {

            if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
            } else {
                targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow);
            }

            if (_.options.rtl === true) {
                if (targetSlide[0]) {
                    targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1;
                } else {
                    targetLeft =  0;
                }
            } else {
                targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
            }

            if (_.options.centerMode === true) {
                if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                    targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
                } else {
                    targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow + 1);
                }

                if (_.options.rtl === true) {
                    if (targetSlide[0]) {
                        targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1;
                    } else {
                        targetLeft =  0;
                    }
                } else {
                    targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
                }

                targetLeft += (_.$list.width() - targetSlide.outerWidth()) / 2;
            }
        }

        return targetLeft;

    };

    Slick.prototype.getOption = Slick.prototype.slickGetOption = function(option) {

        var _ = this;

        return _.options[option];

    };

    Slick.prototype.getNavigableIndexes = function() {

        var _ = this,
            breakPoint = 0,
            counter = 0,
            indexes = [],
            max;

        if (_.options.infinite === false) {
            max = _.slideCount;
        } else {
            breakPoint = _.options.slidesToScroll * -1;
            counter = _.options.slidesToScroll * -1;
            max = _.slideCount * 2;
        }

        while (breakPoint < max) {
            indexes.push(breakPoint);
            breakPoint = counter + _.options.slidesToScroll;
            counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
        }

        return indexes;

    };

    Slick.prototype.getSlick = function() {

        return this;

    };

    Slick.prototype.getSlideCount = function() {

        var _ = this,
            slidesTraversed, swipedSlide, centerOffset;

        centerOffset = _.options.centerMode === true ? _.slideWidth * Math.floor(_.options.slidesToShow / 2) : 0;

        if (_.options.swipeToSlide === true) {
            _.$slideTrack.find('.slick-slide').each(function(index, slide) {
                if (slide.offsetLeft - centerOffset + ($(slide).outerWidth() / 2) > (_.swipeLeft * -1)) {
                    swipedSlide = slide;
                    return false;
                }
            });

            slidesTraversed = Math.abs($(swipedSlide).attr('data-slick-index') - _.currentSlide) || 1;

            return slidesTraversed;

        } else {
            return _.options.slidesToScroll;
        }

    };

    Slick.prototype.goTo = Slick.prototype.slickGoTo = function(slide, dontAnimate) {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'index',
                index: parseInt(slide)
            }
        }, dontAnimate);

    };

    Slick.prototype.init = function(creation) {

        var _ = this;

        if (!$(_.$slider).hasClass('slick-initialized')) {

            $(_.$slider).addClass('slick-initialized');

            _.buildRows();
            _.buildOut();
            _.setProps();
            _.startLoad();
            _.loadSlider();
            _.initializeEvents();
            _.updateArrows();
            _.updateDots();
            _.checkResponsive(true);
            _.focusHandler();

        }

        if (creation) {
            _.$slider.trigger('init', [_]);
        }

        if (_.options.accessibility === true) {
            _.initADA();
        }

        if ( _.options.autoplay ) {

            _.paused = false;
            _.autoPlay();

        }

    };

    Slick.prototype.initADA = function() {
        var _ = this,
            numDotGroups = Math.ceil(_.slideCount / _.options.slidesToShow),
            tabControlIndexes = _.getNavigableIndexes().filter(function(val) {
                return (val >= 0) && (val < _.slideCount);
            });

        _.$slides.add(_.$slideTrack.find('.slick-cloned')).attr({
            'aria-hidden': 'true',
            'tabindex': '-1'
        }).find('a, input, button, select').attr({
            'tabindex': '-1'
        });

        if (_.$dots !== null) {
            _.$slides.not(_.$slideTrack.find('.slick-cloned')).each(function(i) {
                var slideControlIndex = tabControlIndexes.indexOf(i);

                $(this).attr({
                    'role': 'tabpanel',
                    'id': 'slick-slide' + _.instanceUid + i,
                    'tabindex': -1
                });

                if (slideControlIndex !== -1) {
                    var ariaButtonControl = 'slick-slide-control' + _.instanceUid + slideControlIndex
                    if ($('#' + ariaButtonControl).length) {
                        $(this).attr({
                            'aria-describedby': ariaButtonControl
                        });
                    }
                }
            });

            _.$dots.attr('role', 'tablist').find('li').each(function(i) {
                var mappedSlideIndex = tabControlIndexes[i];

                $(this).attr({
                    'role': 'presentation'
                });

                $(this).find('button').first().attr({
                    'role': 'tab',
                    'id': 'slick-slide-control' + _.instanceUid + i,
                    'aria-controls': 'slick-slide' + _.instanceUid + mappedSlideIndex,
                    'aria-label': (i + 1) + ' of ' + numDotGroups,
                    'aria-selected': null,
                    'tabindex': '-1'
                });

            }).eq(_.currentSlide).find('button').attr({
                'aria-selected': 'true',
                'tabindex': '0'
            }).end();
        }

        for (var i=_.currentSlide, max=i+_.options.slidesToShow; i < max; i++) {
            if (_.options.focusOnChange) {
                _.$slides.eq(i).attr({'tabindex': '0'});
            } else {
                _.$slides.eq(i).removeAttr('tabindex');
            }
        }

        _.activateADA();

    };

    Slick.prototype.initArrowEvents = function() {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow
                .off('click.slick')
                .on('click.slick', {
                    message: 'previous'
                }, _.changeSlide);
            _.$nextArrow
                .off('click.slick')
                .on('click.slick', {
                    message: 'next'
                }, _.changeSlide);

            if (_.options.accessibility === true) {
                _.$prevArrow.on('keydown.slick', _.keyHandler);
                _.$nextArrow.on('keydown.slick', _.keyHandler);
            }
        }

    };

    Slick.prototype.initDotEvents = function() {

        var _ = this;

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {
            $('li', _.$dots).on('click.slick', {
                message: 'index'
            }, _.changeSlide);

            if (_.options.accessibility === true) {
                _.$dots.on('keydown.slick', _.keyHandler);
            }
        }

        if (_.options.dots === true && _.options.pauseOnDotsHover === true && _.slideCount > _.options.slidesToShow) {

            $('li', _.$dots)
                .on('mouseenter.slick', $.proxy(_.interrupt, _, true))
                .on('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

    };

    Slick.prototype.initSlideEvents = function() {

        var _ = this;

        if ( _.options.pauseOnHover ) {

            _.$list.on('mouseenter.slick', $.proxy(_.interrupt, _, true));
            _.$list.on('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

    };

    Slick.prototype.initializeEvents = function() {

        var _ = this;

        _.initArrowEvents();

        _.initDotEvents();
        _.initSlideEvents();

        _.$list.on('touchstart.slick mousedown.slick', {
            action: 'start'
        }, _.swipeHandler);
        _.$list.on('touchmove.slick mousemove.slick', {
            action: 'move'
        }, _.swipeHandler);
        _.$list.on('touchend.slick mouseup.slick', {
            action: 'end'
        }, _.swipeHandler);
        _.$list.on('touchcancel.slick mouseleave.slick', {
            action: 'end'
        }, _.swipeHandler);

        _.$list.on('click.slick', _.clickHandler);

        $(document).on(_.visibilityChange, $.proxy(_.visibility, _));

        if (_.options.accessibility === true) {
            _.$list.on('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().on('click.slick', _.selectHandler);
        }

        $(window).on('orientationchange.slick.slick-' + _.instanceUid, $.proxy(_.orientationChange, _));

        $(window).on('resize.slick.slick-' + _.instanceUid, $.proxy(_.resize, _));

        $('[draggable!=true]', _.$slideTrack).on('dragstart', _.preventDefault);

        $(window).on('load.slick.slick-' + _.instanceUid, _.setPosition);
        $(_.setPosition);

    };

    Slick.prototype.initUI = function() {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

            _.$prevArrow.show();
            _.$nextArrow.show();

        }

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$dots.show();

        }

    };

    Slick.prototype.keyHandler = function(event) {

        var _ = this;
        //Dont slide if the cursor is inside the form fields and arrow keys are pressed
        if(!event.target.tagName.match('TEXTAREA|INPUT|SELECT')) {
            if (event.keyCode === 37 && _.options.accessibility === true) {
                _.changeSlide({
                    data: {
                        message: _.options.rtl === true ? 'next' :  'previous'
                    }
                });
            } else if (event.keyCode === 39 && _.options.accessibility === true) {
                _.changeSlide({
                    data: {
                        message: _.options.rtl === true ? 'previous' : 'next'
                    }
                });
            }
        }

    };

    Slick.prototype.lazyLoad = function() {

        var _ = this,
            loadRange, cloneRange, rangeStart, rangeEnd;

        function loadImages(imagesScope) {

            $('img[data-lazy]', imagesScope).each(function() {

                var image = $(this),
                    imageSource = $(this).attr('data-lazy'),
                    imageSrcSet = $(this).attr('data-srcset'),
                    imageSizes  = $(this).attr('data-sizes') || _.$slider.attr('data-sizes'),
                    imageToLoad = document.createElement('img');

                imageToLoad.onload = function() {

                    image
                        .animate({ opacity: 0 }, 100, function() {

                            if (imageSrcSet) {
                                image
                                    .attr('srcset', imageSrcSet );

                                if (imageSizes) {
                                    image
                                        .attr('sizes', imageSizes );
                                }
                            }

                            image
                                .attr('src', imageSource)
                                .animate({ opacity: 1 }, 200, function() {
                                    image
                                        .removeAttr('data-lazy data-srcset data-sizes')
                                        .removeClass('slick-loading');
                                });
                            _.$slider.trigger('lazyLoaded', [_, image, imageSource]);
                        });

                };

                imageToLoad.onerror = function() {

                    image
                        .removeAttr( 'data-lazy' )
                        .removeClass( 'slick-loading' )
                        .addClass( 'slick-lazyload-error' );

                    _.$slider.trigger('lazyLoadError', [ _, image, imageSource ]);

                };

                imageToLoad.src = imageSource;

            });

        }

        if (_.options.centerMode === true) {
            if (_.options.infinite === true) {
                rangeStart = _.currentSlide + (_.options.slidesToShow / 2 + 1);
                rangeEnd = rangeStart + _.options.slidesToShow + 2;
            } else {
                rangeStart = Math.max(0, _.currentSlide - (_.options.slidesToShow / 2 + 1));
                rangeEnd = 2 + (_.options.slidesToShow / 2 + 1) + _.currentSlide;
            }
        } else {
            rangeStart = _.options.infinite ? _.options.slidesToShow + _.currentSlide : _.currentSlide;
            rangeEnd = Math.ceil(rangeStart + _.options.slidesToShow);
            if (_.options.fade === true) {
                if (rangeStart > 0) rangeStart--;
                if (rangeEnd <= _.slideCount) rangeEnd++;
            }
        }

        loadRange = _.$slider.find('.slick-slide').slice(rangeStart, rangeEnd);

        if (_.options.lazyLoad === 'anticipated') {
            var prevSlide = rangeStart - 1,
                nextSlide = rangeEnd,
                $slides = _.$slider.find('.slick-slide');

            for (var i = 0; i < _.options.slidesToScroll; i++) {
                if (prevSlide < 0) prevSlide = _.slideCount - 1;
                loadRange = loadRange.add($slides.eq(prevSlide));
                loadRange = loadRange.add($slides.eq(nextSlide));
                prevSlide--;
                nextSlide++;
            }
        }

        loadImages(loadRange);

        if (_.slideCount <= _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-slide');
            loadImages(cloneRange);
        } else
        if (_.currentSlide >= _.slideCount - _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-cloned').slice(0, _.options.slidesToShow);
            loadImages(cloneRange);
        } else if (_.currentSlide === 0) {
            cloneRange = _.$slider.find('.slick-cloned').slice(_.options.slidesToShow * -1);
            loadImages(cloneRange);
        }

    };

    Slick.prototype.loadSlider = function() {

        var _ = this;

        _.setPosition();

        _.$slideTrack.css({
            opacity: 1
        });

        _.$slider.removeClass('slick-loading');

        _.initUI();

        if (_.options.lazyLoad === 'progressive') {
            _.progressiveLazyLoad();
        }

    };

    Slick.prototype.next = Slick.prototype.slickNext = function() {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'next'
            }
        });

    };

    Slick.prototype.orientationChange = function() {

        var _ = this;

        _.checkResponsive();
        _.setPosition();

    };

    Slick.prototype.pause = Slick.prototype.slickPause = function() {

        var _ = this;

        _.autoPlayClear();
        _.paused = true;

    };

    Slick.prototype.play = Slick.prototype.slickPlay = function() {

        var _ = this;

        _.autoPlay();
        _.options.autoplay = true;
        _.paused = false;
        _.focussed = false;
        _.interrupted = false;

    };

    Slick.prototype.postSlide = function(index) {

        var _ = this;

        if( !_.unslicked ) {

            _.$slider.trigger('afterChange', [_, index]);

            _.animating = false;

            if (_.slideCount > _.options.slidesToShow) {
                _.setPosition();
            }

            _.swipeLeft = null;

            if ( _.options.autoplay ) {
                _.autoPlay();
            }

            if (_.options.accessibility === true) {
                _.initADA();

                if (_.options.focusOnChange) {
                    var $currentSlide = $(_.$slides.get(_.currentSlide));
                    $currentSlide.attr('tabindex', 0).focus();
                }
            }

        }

    };

    Slick.prototype.prev = Slick.prototype.slickPrev = function() {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'previous'
            }
        });

    };

    Slick.prototype.preventDefault = function(event) {

        event.preventDefault();

    };

    Slick.prototype.progressiveLazyLoad = function( tryCount ) {

        tryCount = tryCount || 1;

        var _ = this,
            $imgsToLoad = $( 'img[data-lazy]', _.$slider ),
            image,
            imageSource,
            imageSrcSet,
            imageSizes,
            imageToLoad;

        if ( $imgsToLoad.length ) {

            image = $imgsToLoad.first();
            imageSource = image.attr('data-lazy');
            imageSrcSet = image.attr('data-srcset');
            imageSizes  = image.attr('data-sizes') || _.$slider.attr('data-sizes');
            imageToLoad = document.createElement('img');

            imageToLoad.onload = function() {

                if (imageSrcSet) {
                    image
                        .attr('srcset', imageSrcSet );

                    if (imageSizes) {
                        image
                            .attr('sizes', imageSizes );
                    }
                }

                image
                    .attr( 'src', imageSource )
                    .removeAttr('data-lazy data-srcset data-sizes')
                    .removeClass('slick-loading');

                if ( _.options.adaptiveHeight === true ) {
                    _.setPosition();
                }

                _.$slider.trigger('lazyLoaded', [ _, image, imageSource ]);
                _.progressiveLazyLoad();

            };

            imageToLoad.onerror = function() {

                if ( tryCount < 3 ) {

                    /**
                     * try to load the image 3 times,
                     * leave a slight delay so we don't get
                     * servers blocking the request.
                     */
                    setTimeout( function() {
                        _.progressiveLazyLoad( tryCount + 1 );
                    }, 500 );

                } else {

                    image
                        .removeAttr( 'data-lazy' )
                        .removeClass( 'slick-loading' )
                        .addClass( 'slick-lazyload-error' );

                    _.$slider.trigger('lazyLoadError', [ _, image, imageSource ]);

                    _.progressiveLazyLoad();

                }

            };

            imageToLoad.src = imageSource;

        } else {

            _.$slider.trigger('allImagesLoaded', [ _ ]);

        }

    };

    Slick.prototype.refresh = function( initializing ) {

        var _ = this, currentSlide, lastVisibleIndex;

        lastVisibleIndex = _.slideCount - _.options.slidesToShow;

        // in non-infinite sliders, we don't want to go past the
        // last visible index.
        if( !_.options.infinite && ( _.currentSlide > lastVisibleIndex )) {
            _.currentSlide = lastVisibleIndex;
        }

        // if less slides than to show, go to start.
        if ( _.slideCount <= _.options.slidesToShow ) {
            _.currentSlide = 0;

        }

        currentSlide = _.currentSlide;

        _.destroy(true);

        $.extend(_, _.initials, { currentSlide: currentSlide });

        _.init();

        if( !initializing ) {

            _.changeSlide({
                data: {
                    message: 'index',
                    index: currentSlide
                }
            }, false);

        }

    };

    Slick.prototype.registerBreakpoints = function() {

        var _ = this, breakpoint, currentBreakpoint, l,
            responsiveSettings = _.options.responsive || null;

        if ( $.type(responsiveSettings) === 'array' && responsiveSettings.length ) {

            _.respondTo = _.options.respondTo || 'window';

            for ( breakpoint in responsiveSettings ) {

                l = _.breakpoints.length-1;

                if (responsiveSettings.hasOwnProperty(breakpoint)) {
                    currentBreakpoint = responsiveSettings[breakpoint].breakpoint;

                    // loop through the breakpoints and cut out any existing
                    // ones with the same breakpoint number, we don't want dupes.
                    while( l >= 0 ) {
                        if( _.breakpoints[l] && _.breakpoints[l] === currentBreakpoint ) {
                            _.breakpoints.splice(l,1);
                        }
                        l--;
                    }

                    _.breakpoints.push(currentBreakpoint);
                    _.breakpointSettings[currentBreakpoint] = responsiveSettings[breakpoint].settings;

                }

            }

            _.breakpoints.sort(function(a, b) {
                return ( _.options.mobileFirst ) ? a-b : b-a;
            });

        }

    };

    Slick.prototype.reinit = function() {

        var _ = this;

        _.$slides =
            _.$slideTrack
                .children(_.options.slide)
                .addClass('slick-slide');

        _.slideCount = _.$slides.length;

        if (_.currentSlide >= _.slideCount && _.currentSlide !== 0) {
            _.currentSlide = _.currentSlide - _.options.slidesToScroll;
        }

        if (_.slideCount <= _.options.slidesToShow) {
            _.currentSlide = 0;
        }

        _.registerBreakpoints();

        _.setProps();
        _.setupInfinite();
        _.buildArrows();
        _.updateArrows();
        _.initArrowEvents();
        _.buildDots();
        _.updateDots();
        _.initDotEvents();
        _.cleanUpSlideEvents();
        _.initSlideEvents();

        _.checkResponsive(false, true);

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().on('click.slick', _.selectHandler);
        }

        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);

        _.setPosition();
        _.focusHandler();

        _.paused = !_.options.autoplay;
        _.autoPlay();

        _.$slider.trigger('reInit', [_]);

    };

    Slick.prototype.resize = function() {

        var _ = this;

        if ($(window).width() !== _.windowWidth) {
            clearTimeout(_.windowDelay);
            _.windowDelay = window.setTimeout(function() {
                _.windowWidth = $(window).width();
                _.checkResponsive();
                if( !_.unslicked ) { _.setPosition(); }
            }, 50);
        }
    };

    Slick.prototype.removeSlide = Slick.prototype.slickRemove = function(index, removeBefore, removeAll) {

        var _ = this;

        if (typeof(index) === 'boolean') {
            removeBefore = index;
            index = removeBefore === true ? 0 : _.slideCount - 1;
        } else {
            index = removeBefore === true ? --index : index;
        }

        if (_.slideCount < 1 || index < 0 || index > _.slideCount - 1) {
            return false;
        }

        _.unload();

        if (removeAll === true) {
            _.$slideTrack.children().remove();
        } else {
            _.$slideTrack.children(this.options.slide).eq(index).remove();
        }

        _.$slides = _.$slideTrack.children(this.options.slide);

        _.$slideTrack.children(this.options.slide).detach();

        _.$slideTrack.append(_.$slides);

        _.$slidesCache = _.$slides;

        _.reinit();

    };

    Slick.prototype.setCSS = function(position) {

        var _ = this,
            positionProps = {},
            x, y;

        if (_.options.rtl === true) {
            position = -position;
        }
        x = _.positionProp == 'left' ? Math.ceil(position) + 'px' : '0px';
        y = _.positionProp == 'top' ? Math.ceil(position) + 'px' : '0px';

        positionProps[_.positionProp] = position;

        if (_.transformsEnabled === false) {
            _.$slideTrack.css(positionProps);
        } else {
            positionProps = {};
            if (_.cssTransitions === false) {
                positionProps[_.animType] = 'translate(' + x + ', ' + y + ')';
                _.$slideTrack.css(positionProps);
            } else {
                positionProps[_.animType] = 'translate3d(' + x + ', ' + y + ', 0px)';
                _.$slideTrack.css(positionProps);
            }
        }

    };

    Slick.prototype.setDimensions = function() {

        var _ = this;

        if (_.options.vertical === false) {
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: ('0px ' + _.options.centerPadding)
                });
            }
        } else {
            _.$list.height(_.$slides.first().outerHeight(true) * _.options.slidesToShow);
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: (_.options.centerPadding + ' 0px')
                });
            }
        }

        _.listWidth = _.$list.width();
        _.listHeight = _.$list.height();


        if (_.options.vertical === false && _.options.variableWidth === false) {
            _.slideWidth = Math.ceil(_.listWidth / _.options.slidesToShow);
            _.$slideTrack.width(Math.ceil((_.slideWidth * _.$slideTrack.children('.slick-slide').length)));

        } else if (_.options.variableWidth === true) {
            _.$slideTrack.width(5000 * _.slideCount);
        } else {
            _.slideWidth = Math.ceil(_.listWidth);
            _.$slideTrack.height(Math.ceil((_.$slides.first().outerHeight(true) * _.$slideTrack.children('.slick-slide').length)));
        }

        var offset = _.$slides.first().outerWidth(true) - _.$slides.first().width();
        if (_.options.variableWidth === false) _.$slideTrack.children('.slick-slide').width(_.slideWidth - offset);

    };

    Slick.prototype.setFade = function() {

        var _ = this,
            targetLeft;

        _.$slides.each(function(index, element) {
            targetLeft = (_.slideWidth * index) * -1;
            if (_.options.rtl === true) {
                $(element).css({
                    position: 'relative',
                    right: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            } else {
                $(element).css({
                    position: 'relative',
                    left: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            }
        });

        _.$slides.eq(_.currentSlide).css({
            zIndex: _.options.zIndex - 1,
            opacity: 1
        });

    };

    Slick.prototype.setHeight = function() {

        var _ = this;

        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.css('height', targetHeight);
        }

    };

    Slick.prototype.setOption =
        Slick.prototype.slickSetOption = function() {

            /**
             * accepts arguments in format of:
             *
             *  - for changing a single option's value:
             *     .slick("setOption", option, value, refresh )
             *
             *  - for changing a set of responsive options:
             *     .slick("setOption", 'responsive', [{}, ...], refresh )
             *
             *  - for updating multiple values at once (not responsive)
             *     .slick("setOption", { 'option': value, ... }, refresh )
             */

            var _ = this, l, item, option, value, refresh = false, type;

            if( $.type( arguments[0] ) === 'object' ) {

                option =  arguments[0];
                refresh = arguments[1];
                type = 'multiple';

            } else if ( $.type( arguments[0] ) === 'string' ) {

                option =  arguments[0];
                value = arguments[1];
                refresh = arguments[2];

                if ( arguments[0] === 'responsive' && $.type( arguments[1] ) === 'array' ) {

                    type = 'responsive';

                } else if ( typeof arguments[1] !== 'undefined' ) {

                    type = 'single';

                }

            }

            if ( type === 'single' ) {

                _.options[option] = value;


            } else if ( type === 'multiple' ) {

                $.each( option , function( opt, val ) {

                    _.options[opt] = val;

                });


            } else if ( type === 'responsive' ) {

                for ( item in value ) {

                    if( $.type( _.options.responsive ) !== 'array' ) {

                        _.options.responsive = [ value[item] ];

                    } else {

                        l = _.options.responsive.length-1;

                        // loop through the responsive object and splice out duplicates.
                        while( l >= 0 ) {

                            if( _.options.responsive[l].breakpoint === value[item].breakpoint ) {

                                _.options.responsive.splice(l,1);

                            }

                            l--;

                        }

                        _.options.responsive.push( value[item] );

                    }

                }

            }

            if ( refresh ) {

                _.unload();
                _.reinit();

            }

        };

    Slick.prototype.setPosition = function() {

        var _ = this;

        _.setDimensions();

        _.setHeight();

        if (_.options.fade === false) {
            _.setCSS(_.getLeft(_.currentSlide));
        } else {
            _.setFade();
        }

        _.$slider.trigger('setPosition', [_]);

    };

    Slick.prototype.setProps = function() {

        var _ = this,
            bodyStyle = document.body.style;

        _.positionProp = _.options.vertical === true ? 'top' : 'left';

        if (_.positionProp === 'top') {
            _.$slider.addClass('slick-vertical');
        } else {
            _.$slider.removeClass('slick-vertical');
        }

        if (bodyStyle.WebkitTransition !== undefined ||
            bodyStyle.MozTransition !== undefined ||
            bodyStyle.msTransition !== undefined) {
            if (_.options.useCSS === true) {
                _.cssTransitions = true;
            }
        }

        if ( _.options.fade ) {
            if ( typeof _.options.zIndex === 'number' ) {
                if( _.options.zIndex < 3 ) {
                    _.options.zIndex = 3;
                }
            } else {
                _.options.zIndex = _.defaults.zIndex;
            }
        }

        if (bodyStyle.OTransform !== undefined) {
            _.animType = 'OTransform';
            _.transformType = '-o-transform';
            _.transitionType = 'OTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.MozTransform !== undefined) {
            _.animType = 'MozTransform';
            _.transformType = '-moz-transform';
            _.transitionType = 'MozTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.MozPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.webkitTransform !== undefined) {
            _.animType = 'webkitTransform';
            _.transformType = '-webkit-transform';
            _.transitionType = 'webkitTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.msTransform !== undefined) {
            _.animType = 'msTransform';
            _.transformType = '-ms-transform';
            _.transitionType = 'msTransition';
            if (bodyStyle.msTransform === undefined) _.animType = false;
        }
        if (bodyStyle.transform !== undefined && _.animType !== false) {
            _.animType = 'transform';
            _.transformType = 'transform';
            _.transitionType = 'transition';
        }
        _.transformsEnabled = _.options.useTransform && (_.animType !== null && _.animType !== false);
    };


    Slick.prototype.setSlideClasses = function(index) {

        var _ = this,
            centerOffset, allSlides, indexOffset, remainder;

        allSlides = _.$slider
            .find('.slick-slide')
            .removeClass('slick-active slick-center slick-current')
            .attr('aria-hidden', 'true');

        _.$slides
            .eq(index)
            .addClass('slick-current');

        if (_.options.centerMode === true) {

            var evenCoef = _.options.slidesToShow % 2 === 0 ? 1 : 0;

            centerOffset = Math.floor(_.options.slidesToShow / 2);

            if (_.options.infinite === true) {

                if (index >= centerOffset && index <= (_.slideCount - 1) - centerOffset) {
                    _.$slides
                        .slice(index - centerOffset + evenCoef, index + centerOffset + 1)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                } else {

                    indexOffset = _.options.slidesToShow + index;
                    allSlides
                        .slice(indexOffset - centerOffset + 1 + evenCoef, indexOffset + centerOffset + 2)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                }

                if (index === 0) {

                    allSlides
                        .eq(allSlides.length - 1 - _.options.slidesToShow)
                        .addClass('slick-center');

                } else if (index === _.slideCount - 1) {

                    allSlides
                        .eq(_.options.slidesToShow)
                        .addClass('slick-center');

                }

            }

            _.$slides
                .eq(index)
                .addClass('slick-center');

        } else {

            if (index >= 0 && index <= (_.slideCount - _.options.slidesToShow)) {

                _.$slides
                    .slice(index, index + _.options.slidesToShow)
                    .addClass('slick-active')
                    .attr('aria-hidden', 'false');

            } else if (allSlides.length <= _.options.slidesToShow) {

                allSlides
                    .addClass('slick-active')
                    .attr('aria-hidden', 'false');

            } else {

                remainder = _.slideCount % _.options.slidesToShow;
                indexOffset = _.options.infinite === true ? _.options.slidesToShow + index : index;

                if (_.options.slidesToShow == _.options.slidesToScroll && (_.slideCount - index) < _.options.slidesToShow) {

                    allSlides
                        .slice(indexOffset - (_.options.slidesToShow - remainder), indexOffset + remainder)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                } else {

                    allSlides
                        .slice(indexOffset, indexOffset + _.options.slidesToShow)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                }

            }

        }

        if (_.options.lazyLoad === 'ondemand' || _.options.lazyLoad === 'anticipated') {
            _.lazyLoad();
        }
    };

    Slick.prototype.setupInfinite = function() {

        var _ = this,
            i, slideIndex, infiniteCount;

        if (_.options.fade === true) {
            _.options.centerMode = false;
        }

        if (_.options.infinite === true && _.options.fade === false) {

            slideIndex = null;

            if (_.slideCount > _.options.slidesToShow) {

                if (_.options.centerMode === true) {
                    infiniteCount = _.options.slidesToShow + 1;
                } else {
                    infiniteCount = _.options.slidesToShow;
                }

                for (i = _.slideCount; i > (_.slideCount -
                    infiniteCount); i -= 1) {
                    slideIndex = i - 1;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '')
                        .attr('data-slick-index', slideIndex - _.slideCount)
                        .prependTo(_.$slideTrack).addClass('slick-cloned');
                }
                for (i = 0; i < infiniteCount  + _.slideCount; i += 1) {
                    slideIndex = i;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '')
                        .attr('data-slick-index', slideIndex + _.slideCount)
                        .appendTo(_.$slideTrack).addClass('slick-cloned');
                }
                _.$slideTrack.find('.slick-cloned').find('[id]').each(function() {
                    $(this).attr('id', '');
                });

            }

        }

    };

    Slick.prototype.interrupt = function( toggle ) {

        var _ = this;

        if( !toggle ) {
            _.autoPlay();
        }
        _.interrupted = toggle;

    };

    Slick.prototype.selectHandler = function(event) {

        var _ = this;

        var targetElement =
            $(event.target).is('.slick-slide') ?
                $(event.target) :
                $(event.target).parents('.slick-slide');

        var index = parseInt(targetElement.attr('data-slick-index'));

        if (!index) index = 0;

        if (_.slideCount <= _.options.slidesToShow) {

            _.slideHandler(index, false, true);
            return;

        }

        _.slideHandler(index);

    };

    Slick.prototype.slideHandler = function(index, sync, dontAnimate) {

        var targetSlide, animSlide, oldSlide, slideLeft, targetLeft = null,
            _ = this, navTarget;

        sync = sync || false;

        if (_.animating === true && _.options.waitForAnimate === true) {
            return;
        }

        if (_.options.fade === true && _.currentSlide === index) {
            return;
        }

        if (sync === false) {
            _.asNavFor(index);
        }

        targetSlide = index;
        targetLeft = _.getLeft(targetSlide);
        slideLeft = _.getLeft(_.currentSlide);

        _.currentLeft = _.swipeLeft === null ? slideLeft : _.swipeLeft;

        if (_.options.infinite === false && _.options.centerMode === false && (index < 0 || index > _.getDotCount() * _.options.slidesToScroll)) {
            if (_.options.fade === false) {
                targetSlide = _.currentSlide;
                if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) {
                    _.animateSlide(slideLeft, function() {
                        _.postSlide(targetSlide);
                    });
                } else {
                    _.postSlide(targetSlide);
                }
            }
            return;
        } else if (_.options.infinite === false && _.options.centerMode === true && (index < 0 || index > (_.slideCount - _.options.slidesToScroll))) {
            if (_.options.fade === false) {
                targetSlide = _.currentSlide;
                if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) {
                    _.animateSlide(slideLeft, function() {
                        _.postSlide(targetSlide);
                    });
                } else {
                    _.postSlide(targetSlide);
                }
            }
            return;
        }

        if ( _.options.autoplay ) {
            clearInterval(_.autoPlayTimer);
        }

        if (targetSlide < 0) {
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                animSlide = _.slideCount - (_.slideCount % _.options.slidesToScroll);
            } else {
                animSlide = _.slideCount + targetSlide;
            }
        } else if (targetSlide >= _.slideCount) {
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                animSlide = 0;
            } else {
                animSlide = targetSlide - _.slideCount;
            }
        } else {
            animSlide = targetSlide;
        }

        _.animating = true;

        _.$slider.trigger('beforeChange', [_, _.currentSlide, animSlide]);

        oldSlide = _.currentSlide;
        _.currentSlide = animSlide;

        _.setSlideClasses(_.currentSlide);

        if ( _.options.asNavFor ) {

            navTarget = _.getNavTarget();
            navTarget = navTarget.slick('getSlick');

            if ( navTarget.slideCount <= navTarget.options.slidesToShow ) {
                navTarget.setSlideClasses(_.currentSlide);
            }

        }

        _.updateDots();
        _.updateArrows();

        if (_.options.fade === true) {
            if (dontAnimate !== true) {

                _.fadeSlideOut(oldSlide);

                _.fadeSlide(animSlide, function() {
                    _.postSlide(animSlide);
                });

            } else {
                _.postSlide(animSlide);
            }
            _.animateHeight();
            return;
        }

        if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) {
            _.animateSlide(targetLeft, function() {
                _.postSlide(animSlide);
            });
        } else {
            _.postSlide(animSlide);
        }

    };

    Slick.prototype.startLoad = function() {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

            _.$prevArrow.hide();
            _.$nextArrow.hide();

        }

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$dots.hide();

        }

        _.$slider.addClass('slick-loading');

    };

    Slick.prototype.swipeDirection = function() {

        var xDist, yDist, r, swipeAngle, _ = this;

        xDist = _.touchObject.startX - _.touchObject.curX;
        yDist = _.touchObject.startY - _.touchObject.curY;
        r = Math.atan2(yDist, xDist);

        swipeAngle = Math.round(r * 180 / Math.PI);
        if (swipeAngle < 0) {
            swipeAngle = 360 - Math.abs(swipeAngle);
        }

        if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
            return (_.options.rtl === false ? 'left' : 'right');
        }
        if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
            return (_.options.rtl === false ? 'left' : 'right');
        }
        if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
            return (_.options.rtl === false ? 'right' : 'left');
        }
        if (_.options.verticalSwiping === true) {
            if ((swipeAngle >= 35) && (swipeAngle <= 135)) {
                return 'down';
            } else {
                return 'up';
            }
        }

        return 'vertical';

    };

    Slick.prototype.swipeEnd = function(event) {

        var _ = this,
            slideCount,
            direction;

        _.dragging = false;
        _.swiping = false;

        if (_.scrolling) {
            _.scrolling = false;
            return false;
        }

        _.interrupted = false;
        _.shouldClick = ( _.touchObject.swipeLength > 10 ) ? false : true;

        if ( _.touchObject.curX === undefined ) {
            return false;
        }

        if ( _.touchObject.edgeHit === true ) {
            _.$slider.trigger('edge', [_, _.swipeDirection() ]);
        }

        if ( _.touchObject.swipeLength >= _.touchObject.minSwipe ) {

            direction = _.swipeDirection();

            switch ( direction ) {

                case 'left':
                case 'down':

                    slideCount =
                        _.options.swipeToSlide ?
                            _.checkNavigable( _.currentSlide + _.getSlideCount() ) :
                            _.currentSlide + _.getSlideCount();

                    _.currentDirection = 0;

                    break;

                case 'right':
                case 'up':

                    slideCount =
                        _.options.swipeToSlide ?
                            _.checkNavigable( _.currentSlide - _.getSlideCount() ) :
                            _.currentSlide - _.getSlideCount();

                    _.currentDirection = 1;

                    break;

                default:


            }

            if( direction != 'vertical' ) {

                _.slideHandler( slideCount );
                _.touchObject = {};
                _.$slider.trigger('swipe', [_, direction ]);

            }

        } else {

            if ( _.touchObject.startX !== _.touchObject.curX ) {

                _.slideHandler( _.currentSlide );
                _.touchObject = {};

            }

        }

    };

    Slick.prototype.swipeHandler = function(event) {

        var _ = this;

        if ((_.options.swipe === false) || ('ontouchend' in document && _.options.swipe === false)) {
            return;
        } else if (_.options.draggable === false && event.type.indexOf('mouse') !== -1) {
            return;
        }

        _.touchObject.fingerCount = event.originalEvent && event.originalEvent.touches !== undefined ?
            event.originalEvent.touches.length : 1;

        _.touchObject.minSwipe = _.listWidth / _.options
            .touchThreshold;

        if (_.options.verticalSwiping === true) {
            _.touchObject.minSwipe = _.listHeight / _.options
                .touchThreshold;
        }

        switch (event.data.action) {

            case 'start':
                _.swipeStart(event);
                break;

            case 'move':
                _.swipeMove(event);
                break;

            case 'end':
                _.swipeEnd(event);
                break;

        }

    };

    Slick.prototype.swipeMove = function(event) {

        var _ = this,
            edgeWasHit = false,
            curLeft, swipeDirection, swipeLength, positionOffset, touches, verticalSwipeLength;

        touches = event.originalEvent !== undefined ? event.originalEvent.touches : null;

        if (!_.dragging || _.scrolling || touches && touches.length !== 1) {
            return false;
        }

        curLeft = _.getLeft(_.currentSlide);

        _.touchObject.curX = touches !== undefined ? touches[0].pageX : event.clientX;
        _.touchObject.curY = touches !== undefined ? touches[0].pageY : event.clientY;

        _.touchObject.swipeLength = Math.round(Math.sqrt(
            Math.pow(_.touchObject.curX - _.touchObject.startX, 2)));

        verticalSwipeLength = Math.round(Math.sqrt(
            Math.pow(_.touchObject.curY - _.touchObject.startY, 2)));

        if (!_.options.verticalSwiping && !_.swiping && verticalSwipeLength > 4) {
            _.scrolling = true;
            return false;
        }

        if (_.options.verticalSwiping === true) {
            _.touchObject.swipeLength = verticalSwipeLength;
        }

        swipeDirection = _.swipeDirection();

        if (event.originalEvent !== undefined && _.touchObject.swipeLength > 4) {
            _.swiping = true;
            event.preventDefault();
        }

        positionOffset = (_.options.rtl === false ? 1 : -1) * (_.touchObject.curX > _.touchObject.startX ? 1 : -1);
        if (_.options.verticalSwiping === true) {
            positionOffset = _.touchObject.curY > _.touchObject.startY ? 1 : -1;
        }


        swipeLength = _.touchObject.swipeLength;

        _.touchObject.edgeHit = false;

        if (_.options.infinite === false) {
            if ((_.currentSlide === 0 && swipeDirection === 'right') || (_.currentSlide >= _.getDotCount() && swipeDirection === 'left')) {
                swipeLength = _.touchObject.swipeLength * _.options.edgeFriction;
                _.touchObject.edgeHit = true;
            }
        }

        if (_.options.vertical === false) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        } else {
            _.swipeLeft = curLeft + (swipeLength * (_.$list.height() / _.listWidth)) * positionOffset;
        }
        if (_.options.verticalSwiping === true) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        }

        if (_.options.fade === true || _.options.touchMove === false) {
            return false;
        }

        if (_.animating === true) {
            _.swipeLeft = null;
            return false;
        }

        _.setCSS(_.swipeLeft);

    };

    Slick.prototype.swipeStart = function(event) {

        var _ = this,
            touches;

        _.interrupted = true;

        if (_.touchObject.fingerCount !== 1 || _.slideCount <= _.options.slidesToShow) {
            _.touchObject = {};
            return false;
        }

        if (event.originalEvent !== undefined && event.originalEvent.touches !== undefined) {
            touches = event.originalEvent.touches[0];
        }

        _.touchObject.startX = _.touchObject.curX = touches !== undefined ? touches.pageX : event.clientX;
        _.touchObject.startY = _.touchObject.curY = touches !== undefined ? touches.pageY : event.clientY;

        _.dragging = true;

    };

    Slick.prototype.unfilterSlides = Slick.prototype.slickUnfilter = function() {

        var _ = this;

        if (_.$slidesCache !== null) {

            _.unload();

            _.$slideTrack.children(this.options.slide).detach();

            _.$slidesCache.appendTo(_.$slideTrack);

            _.reinit();

        }

    };

    Slick.prototype.unload = function() {

        var _ = this;

        $('.slick-cloned', _.$slider).remove();

        if (_.$dots) {
            _.$dots.remove();
        }

        if (_.$prevArrow && _.htmlExpr.test(_.options.prevArrow)) {
            _.$prevArrow.remove();
        }

        if (_.$nextArrow && _.htmlExpr.test(_.options.nextArrow)) {
            _.$nextArrow.remove();
        }

        _.$slides
            .removeClass('slick-slide slick-active slick-visible slick-current')
            .attr('aria-hidden', 'true')
            .css('width', '');

    };

    Slick.prototype.unslick = function(fromBreakpoint) {

        var _ = this;
        _.$slider.trigger('unslick', [_, fromBreakpoint]);
        _.destroy();

    };

    Slick.prototype.updateArrows = function() {

        var _ = this,
            centerOffset;

        centerOffset = Math.floor(_.options.slidesToShow / 2);

        if ( _.options.arrows === true &&
            _.slideCount > _.options.slidesToShow &&
            !_.options.infinite ) {

            _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            if (_.currentSlide === 0) {

                _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            } else if (_.currentSlide >= _.slideCount - _.options.slidesToShow && _.options.centerMode === false) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            } else if (_.currentSlide >= _.slideCount - 1 && _.options.centerMode === true) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            }

        }

    };

    Slick.prototype.updateDots = function() {

        var _ = this;

        if (_.$dots !== null) {

            _.$dots
                .find('li')
                .removeClass('slick-active')
                .end();

            _.$dots
                .find('li')
                .eq(Math.floor(_.currentSlide / _.options.slidesToScroll))
                .addClass('slick-active');

        }

    };

    Slick.prototype.visibility = function() {

        var _ = this;

        if ( _.options.autoplay ) {

            if ( document[_.hidden] ) {

                _.interrupted = true;

            } else {

                _.interrupted = false;

            }

        }

    };

    $.fn.slick = function() {
        var _ = this,
            opt = arguments[0],
            args = Array.prototype.slice.call(arguments, 1),
            l = _.length,
            i,
            ret;
        for (i = 0; i < l; i++) {
            if (typeof opt == 'object' || typeof opt == 'undefined')
                _[i].slick = new Slick(_[i], opt);
            else
                ret = _[i].slick[opt].apply(_[i].slick, args);
            if (typeof ret != 'undefined') return ret;
        }
        return _;
    };

}));
