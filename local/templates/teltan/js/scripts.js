$(document).ready(function () {
    const $body = $('body');
    const $filterModalContetn = $('#filterModalContent')
    const $itemSlider = $('#itemSlider');

    const scroll = 0;
    const active = "active";
    let prevScrollTop = 0;

    $(window).scroll(function () {

        const scrollTop = $(window).scrollTop()

        if (prevScrollTop < scrollTop && prevScrollTop > 0) {
            $(".header").addClass('hiddenSearch')
        } else if (prevScrollTop - 20 > scrollTop) {
            $(".header").removeClass('hiddenSearch')
        }

        if (scrollTop > scroll) {
            $(".header").addClass(active);
        } else {
            $(".header").removeClass(active);
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

    $('.menu__nav button.nav-item').on('click', function (e) {
        e.preventDefault()
        const menuBtn = $(this).data('menu-btn')
        $(`.menu.submenu[data-submenu=${menuBtn}]`).addClass('active')
    })

    $('.menu__header .back-menu').on('click', function (e) {
        e.preventDefault()
        $('.menu.submenu').removeClass('active')
    })
    // MOBILE MENU --END--


    $('#showListUserNumber').on('click', () => {
        $('.mobile-block-show-contacts').toggleClass('show')
    })

    $('#closeNumberList').on('click', () => {
        $('.mobile-block-show-contacts').removeClass('show')
    })


    Element.prototype.remove = function () {
        this.parentElement.removeChild(this);
    }
    NodeList.prototype.remove = HTMLCollection.prototype.remove = function () {
        for (var i = this.length - 1; i >= 0; i--) {
            if (this[i] && this[i].parentElement) {
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

            $('#isMobileMenuFiltersOpen').on('click', function (e) {
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

    $('.collaps-text-about-btn').on('click', function () {
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

    $('.btn-accelerate-sale').click(function () {

        $(this).next().toggleClass('active')
    })


    //Similar Contetn Sliders / VIP content slider
    $(document).ready(function () {
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

        $('.slider-nav div[data-slide]').click(function (e) {
            e.preventDefault();
            var slideno = $(this).data('slide');
            $('.slider-for').slick('slickGoTo', slideno);
        });

        $('.slider-for .slide').click(function (e) {
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
            rtl: false,
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

        $('.mainItemSlider').on('wheel', (function (e) {
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
                $(".item-slider > .add-item-favorite").css({
                    'z-index': '2000',
                    'top': '-100%',
                    'right': '20px',
                    'left': 'auto'
                })
            })

            $('#modalFullSize').on('hide.bs.modal', function () {
                $('body .modal-backdrop.show').css({"opacity": '0.5'})
                $(".item-slider > .add-item-favorite").css({
                    'z-index': '2',
                    'top': '20px',
                    'right': 'auto',
                    'left': '20px'
                })
            })
        } else {
            $('#modalFullSize').on('shown.bs.modal', function () {
                $('body .modal-backdrop.show').css({'opacity': '0.8', 'background-color': '#d5d5d5'})
            })

            $('#modalFullSize').on('hide.bs.modal', function () {
                $('body .modal-backdrop.show').css({'opacity': '0.8', 'background-color': '#d5d5d5'})
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

            `<div class="ml-3 d-flex align-items-center justify-content-center upload-file" data-src="{{dataUrl}}" data-file-id="{{name}}">
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
                this.filterData = {...this.filterData, [e.target.name]: e.target.value.toLowerCase()}
                $items.each((_, el) => {
                    const $el = $(el);
                    let isFind = true;
                    Object.entries(this.filterData).map(([name, value]) => value).forEach((filterDataItem) => {
                        let filterData = typeof $el.data('filter') === 'string' ? $el.data('filter') : $el.data('filter') + '';
                        if (!filterData.includes(filterDataItem)) isFind = false
                    })

                    $el.toggleClass('d-none', !isFind);
                })
            });
        }
    }

    new Filter('#brandFilter')
    new Filter('#userItemFilter')
    new Filter('#nameFilter')
    new Filter('.dropdown-menu-search')

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

        afterSelectCb = () => {
        }

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
                let elements = document.querySelectorAll('.d-flex.flex-row-reverse.justify-content-center.justify-content-lg-start.flex-wrap');
                for (let i = 0; i < elements.length; i++) {
                    let element = elements[i];
                    let hasAdditional = element.querySelector('.additional');
                    if (hasAdditional) {
                        element.classList.remove('flex-row-reverse');
                    }
                }
                if (document.location.pathname === '/add/rent/' || document.location.pathname === '/add/buy/') {
                    let typeNewBuildings = document.querySelector('#typeNewBuildings') && document.querySelector('#typeNewBuildings').checked === true;
                    let errors = 0;

                    if (!typeNewBuildings) {
                        let inputElements = document.querySelectorAll(`div[data-wizard-content="${this.activeStep}"] .div-req input[type="radio"]`);
                        if (inputElements.length > 0) {
                            errors = 1;
                            inputElements.forEach(input => {
                                if (input.hasAttribute('required') && !input.classList.contains('type-sections')) {
                                    if (input.checked === false) {
                                        $(input).addClass('error');
                                        $(input).siblings('label').addClass('error');
                                    } else {
                                        errors = 0;
                                    }
                                }
                            });

                            // Удаляем красную окантовку полей
                            if (errors === 0) {
                                inputElements.forEach(input => {
                                    if (input.hasAttribute('required')) { // !$(input).parent('div').is(':hidden')
                                        $(input).removeClass('error');
                                        $(input).siblings('label').removeClass('error');
                                    }
                                });
                            }
                        }
                    }

                    if (this.activeStep === 1 && window.mapError !== false) {
                        errors = 1;
                        $('.wizard-control-next').attr('disabled', 'disabled');
                        let errorContainer = document.querySelector('#mainForm div.map-error-message');
                        if (window.mapError === undefined) window.mapError = 'Установите метку на карте!';

                        if (errorContainer) {
                            errorContainer.innerText = window.mapError;
                        } else {
                            errorContainer = document.createElement('div');
                            errorContainer.classList.add('map-error-message');
                            errorContainer.innerText = window.mapError;
                            const h2Title = document.querySelector('#mainForm div.step-two h2');
                            h2Title.after(errorContainer);
                        }
                    } else {
                        if (document.querySelector('#mainForm div.map-error-message')) {
                            document.querySelector('#mainForm div.map-error-message').remove();
                        }
                    }

                    let curPropTypeSectionId = document.querySelector('div[data-wizard-content="0"] .property-type-radio input:checked').getAttribute('data-type-section-id');
                    let curStepInputs = document.querySelectorAll(`div.wizard-content.active div[data-parent-id="${curPropTypeSectionId}"] input`);
                    if (curStepInputs && this.activeStep > 1) {
                        let errorExist = false;
                        curStepInputs.forEach((input) => {
                            const req = input.getAttribute('data-req');
                            const type = input.getAttribute('type');
                            if (req === 'Y') {
                                switch (type) {
                                    case 'radio':
                                        const propRadioId = input.getAttribute('data-id_prop');
                                        const radioInputs = document.querySelectorAll('input[data-id_prop="' + propRadioId + '"]');
                                        if (radioInputs) {
                                            let checker = 1;
                                            radioInputs.forEach((radioInput) => {
                                                if (radioInput.checked === true) {
                                                    checker = 0;
                                                }
                                            });

                                            if (checker > 0) {
                                                radioInputs.forEach((radioInput) => {
                                                    radioInput.parentNode.querySelector('label').classList.add('error');
                                                });
                                                errorExist = true;
                                            } else {
                                                radioInputs.forEach((radioInput) => {
                                                    radioInput.parentNode.querySelector('label').classList.remove('error');
                                                });
                                            }
                                        }
                                        break;
                                    case 'checkbox':
                                        const propId = input.getAttribute('data-id_prop');
                                        const checkboxInputs = document.querySelectorAll('input[data-id_prop="' + propId + '"]');
                                        if (checkboxInputs) {
                                            let checker = 1;
                                            checkboxInputs.forEach((checkbox) => {
                                                if (checkbox.checked === true) {
                                                    checker = 0;
                                                }
                                            });

                                            if (checker > 0) {
                                                checkboxInputs.forEach((checkbox) => {
                                                    checkbox.parentNode.querySelector('label').classList.add('error');
                                                });
                                                errorExist = true;
                                            } else {
                                                checkboxInputs.forEach((checkbox) => {
                                                    checkbox.parentNode.querySelector('label').classList.remove('error');
                                                });
                                            }
                                        }
                                        break;
                                    default:
                                        if (input.value.length > 0) {
                                            input.classList.remove('error');
                                        } else {

                                            input.classList.add('error');
                                            errorExist = true;
                                        }
                                        break;
                                }

                                if (errorExist === true) {
                                    errors = 1;
                                } else {
                                    errors = 0;
                                }

                            }
                        });
                    }

                    if (errors === 0) {
                        if (this.activeStep === 0) {
                            $('.wizard-control-next').attr('disabled', 'disabled');
                        }
                        this.selectStep(this.activeStep + 1);
                        $('.wizard-control-next').attr('disabled', false);

                    }

                    console.log(errors);

                }


                let step = this.activeStep;
                if (document.location.pathname === '/add/auto/' || document.location.pathname === '/add/moto/' || document.location.pathname === '/add/scooter/') {
                    let errors = 0;
                    let errorsDiv = 0;
                    let skip = false;
                    $('#mainForm').find('.wizard-content').each(function (index) {
                        if ($(this).hasClass('active')) {
                            $(this).find('input').each(function () {
                                let inputData = $(this).data()
                                inputData.req = $(this).attr('data-req')
                                let value = $(this).val();
                                if (inputData.req === 'Y') {
                                    if ($(this).attr('type') == 'radio') {

                                    } else {
                                        if (value === '') {
                                            errors++;
                                            $(this).addClass('error');
                                            $(this).parent('label').addClass('error');
                                        } else {
                                            $(this).removeClass('error');
                                            $(this).parent('label').removeClass('error');
                                        }
                                    }
                                }
                                if (step == 1 || step == 2) {
                                    if (inputData.req === 'Y') {
                                        if ($(this).is(':checked') != false)
                                            skip = true;

                                    }
                                }
                            });
                            let thisdiv = 0;
                            $(this).find('.div-req').each(function () {
                                errorsDiv++;
                                thisdiv++;
                                $(this).find('input').each(function (index) {
                                    if ($(this).attr('data-cc') === 'dateRadioSelector') {
                                        if ($(this).is(':checked') != false) {
                                            errorsDiv--;
                                            thisdiv = 0;
                                        }
                                        let dateSelectSelectorVal = $('#dateSelectSelector').val()
                                        if (thisdiv > 0) {
                                            if (dateSelectSelectorVal !== 'no-value') {
                                                errorsDiv--;
                                                thisdiv = 0;
                                            }
                                        }
                                    } else {
                                        if ($(this).is(':checked') != false) {
                                            errorsDiv--;
                                            thisdiv = 0;
                                        }
                                    }
                                });

                                if (thisdiv > 0) {
                                    $(this).find('label').each(function (index) {
                                        $(this).addClass('error')
                                    })
                                } else {
                                    $(this).find('label').each(function (index) {
                                        $(this).removeClass('error')
                                    })
                                }
                            });
                            $(this).find('select').each(function () {
                                let inputData = $(this).data()
                                let value = $(this).val()
                                if (inputData.req === 'Y') {
                                    if (value === '' || value === 'Nothing selected') {
                                        errors++;
                                        $(this).addClass('error');
                                        $(this).parent('div').children('button').addClass('error');
                                    } else {
                                        $(this).removeClass('error');
                                        $(this).parent('div').children('button').removeClass('error');
                                    }

                                }
                            });


                            if ($('#PROP_ENGIEN_NEW').val() == 0 && step === 3) {


                                errors++;
                                $('#PROP_ENGIEN_NEW').addClass('error');

                            } else if (step === 3) {

                                $('#PROP_ENGIEN_NEW').removeClass('error');
                            }
                            if ($('#millage').val() == 0 && step === 3) {
                                errors++;
                                $('#millage').addClass('error');

                            } else if (step === 3) {

                                $('#millage').removeClass('error');
                            }
                        }
                    })

                    if (step === 3) {

                    }
                    if ($('#userItemPrice').val() == '' && step === 5) {
                        errors = 1;
                        if (errors < 1) {
                            errors = 1;
                        } else if (step === 5) {
                            errors = errors + 1;
                        }
                    } else if (step === 5) {

                    }
                    if (errors < 1 || skip === true) {
                        if (errorsDiv < 1) {
                            this.selectStep(this.activeStep + 1);
                        }
                    }
                } else {
                    // if (document.location.pathname === '/add/rent/' || document.location.pathname === '/add/buy/') {
                    //     // if (rowSkip === true) {
                    //     //
                    //     // } else {
                    //     //     // this.selectStep(this.activeStep + 1);
                    //     //
                    //     // }
                    // } else {
                    //     // this.selectStep(this.activeStep + 1);
                    // }
                }

            })

            this.prevControl.on('click', () => {
                this.selectStep(this.activeStep - 1);
                if (document.location.pathname === '/add/rent/' || document.location.pathname === '/add/buy/') {
                    $('.wizard-control-next').removeAttr('disabled');
                }
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
                if (document.location.pathname === '/add/auto/' || document.location.pathname === '/add/moto/' || document.location.pathname === '/add/scooter/' || document.location.pathname === '/add/rent/' || document.location.pathname === '/add/buy/') {
                    this.finalControl.addClass(activeClass)
                }
            }

            this.afterSelectCb(index)
        }
    }

    new Wizard({}, () => {
        /*if ($('#map').length > 0) {

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/roottest123/cl4dzlo1n004u14midfqcmla4',
                center: mapCoordinate,
                zoom: 8
            });


            map.on('load', () => {

                let hoveredStateId = null;


                const stateDataLayer = map.getLayer('abu-gosh');

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

                map.addLayer({
                    'id': '1-level-area7',
                    'type': 'fill',
                    'source': '1_source-7',

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

                map.addLayer({
                    'id': '1-level-area6',
                    'type': 'fill',
                    'source': '1_source-6',

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

                map.addLayer({
                    'id': '1-level-area5',
                    'type': 'fill',
                    'source': '1_source-5',

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

                /!*
        map.addLayer({
            'id': '1-level-area4',
            'type': 'fill',
            'source': '1_source-4',

            'source-layer': '44',
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
        map.on('mousemove', '1-level-area4', (e) => {
            const features = map.queryRenderedFeatures(e.point);

            if (features[0].layer.id === "1-level-area4") {
                if (features.length > 0) {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            {source: '1_source-4', sourceLayer: '44', id: hoveredStateId},
                            {hover: false}
                        );
                    }

                    hoveredStateId = features[0].id;
                    map.setFeatureState(
                        {source: '1_source-4', sourceLayer: '44', id: hoveredStateId},
                        {hover: true}
                    );
                }
            }
        });

        map.on('mouseleave', '1-level-area4', () => {
            if (hoveredStateId !== null) {
                map.setFeatureState(
                    {source: '1_source-4', sourceLayer: '44', id: hoveredStateId},
                    {hover: false}
                );
            }
            hoveredStateId = null;
        });

        map.on('click', '1-level-area4', (e) => {

            map.flyTo({center: e.features[0].geometry.coordinates[0][0], zoom: 10});
        })

         *!/
                map.addLayer({
                    'id': '1-level-area3',
                    'type': 'fill',
                    'source': '1_source-3',

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

                map.addLayer({
                    'id': '1-level-area2',
                    'type': 'fill',
                    'source': '1_source-2',

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

                map.addLayer({
                    'id': '1-level-area1',
                    'type': 'fill',
                    'source': '1_source-1',

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


                const geocoder = new MapboxGeocoder({
                    language: 'he-HE',
                    mapboxgl: mapboxgl,
                    accessToken: mapboxgl.accessToken,
                    marker: false
                })

                geocoder.on('result', e => {
                    const marker = new mapboxgl.Marker({
                        draggable: true
                    })
                        .setLngLat(e.result.center)
                        .addTo(map)


                    var geocoder_point = map.project([e.result.center[0], e.result.center[1]]);
                    const features = map.queryRenderedFeatures(geocoder_point);
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
                    markerData = displayFeatures;

                    markerData.forEach(function (item, i, mapResult) {
                        if (item.sourceLayer == "abu_gosh") {
                            dataFor = item;
                        } else {
                            if (item.sourceLayer != "building" && item.sourceLayer != "road") {
                                if (item.properties.MUN_HE != undefined) {
                                    dataFor = item;
                                }
                            }
                        }
                    });
                    let layer = markerData[1];

                    if (layer == undefined) {
                        $('.wizard-control-next').attr('disabled', 'disabled');
                    } else if (layer.sourceLayer === "abu_gosh" && layer !== undefined) {
                        $('.wizard-control-next').removeAttr('disabled');

                    } else {

                        $('.wizard-control-next').attr('disabled', 'disabled');
                    }
                    localStorage.setItem('markerData', JSON.stringify(markerData))
                    localStorage.setItem('locationDataPosition', JSON.stringify(geocoder_point))
                    localStorage.setItem('locationDataLatLng', JSON.stringify(e.result.center))


                    marker.on('dragend', function (e) {
                        const features = map.queryRenderedFeatures(e.target._pos);
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
                        markerData = displayFeatures;
                        markerData.forEach(function (item, i, mapResult) {
                            if (item.sourceLayer == "abu_gosh") {
                                dataFor = item;
                            } else {
                                if (item.sourceLayer != "building" && item.sourceLayer != "road") {
                                    if (item.properties.MUN_HE != undefined) {
                                        dataFor = item;
                                    }
                                }
                            }
                        });
                        let layer = markerData[1];

                        if (layer == undefined) {
                            $('.wizard-control-next').attr('disabled', 'disabled');
                        } else if (layer.sourceLayer === "abu_gosh" && layer !== undefined) {
                            $('.wizard-control-next').removeAttr('disabled');

                        } else {

                            $('.wizard-control-next').attr('disabled', 'disabled');
                        }
                        localStorage.setItem('markerData', JSON.stringify(markerData))
                        localStorage.setItem('locationDataPosition', JSON.stringify(e.target._pos))
                        localStorage.setItem('locationDataLatLng', JSON.stringify(e.target._lngLat))

                    })
                })

                map.addControl(geocoder)


                map.on('click', 'unclustered-point', (e) => {
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
            const mapItemRenderPlace = $('#rendorMapItemCard');

            const clearMapItemPLace = () => {
                mapItemRenderPlace.empty()
            }

            const rendorMapItemCard = (paramItem) => {
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
        }*/
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
                if (e !== undefined) {
                    this.addFiles(e.target.files)
                    e.target.value = ''
                }
            })

            $(document).on('click', '[data-file-remove-id]', function () {
                self.removeFile($(this).data('fileRemoveId'));
            })

            $(document).on('click', '.rotate-control', function () {
                const $rotateInput = $(this).find('input');
                const currentRotate = Number($rotateInput.val()) || 0;
                const newRotate = currentRotate;
                $(this).closest('[data-file-id]').find('.rotate-img')
                    .css({'transform': `rotate(${newRotate}deg)`})

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
                const dataUrl = await this.readFileAsync(file);

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


    /**
     * Alerts
     */
    $('#alertInformer').on('click', function () {
        $('.alert-informer').addClass('show');

        setTimeout(function () {
            $('.alert-informer').removeClass('show');
        }, 2500)
    })


    $('.allert .close').click(() => {
        $('.allert').removeClass('show')
    })

    function countRiseBuy() {
        alert('ok')
    }

    // Dependense lists START


    $(document).on("click", 'body', function (event) {
        let target = event.target

        if (target.classList.contains('second-drop')) {

        } else if (target.classList.contains('first-drop')) {

        } else {
            $(".show-country").removeClass("active");
            $(".show-city").removeClass("active");
        }

    })


    /*$(document).on("click", ".show-country", function (e) {
    let target = e.target.value;
    let countryName = e.target.closest("label").textContent;

    showCityThisCountry(target);
    checkedElement(countryName, $(".first-drop"));

    $(".show-country").removeClass("active");

    if ($(".show-city").hasClass('active') === true) {
      $(".show-city").toggleClass("active");
    }
  });

  $(document).on("click", ".show-city", function (e) {

    /!*$('input[name=c_country]').val();
    $('input[name=c_city]').val();*!/
    let target = e.target.closest("label").textContent;

    checkedElement(target, $(".second-drop"));

    $(".show-city").toggleClass("active");

    if ($(".show-country").hasClass('active') === true) {
      $(".show-country").toggleClass("active");
    }
  });*/


    const showCityThisCountry = (countryName) => {
        /*if (placesList[countryName]) {
            $(".show-city").empty();

            placesList[countryName].forEach((element) => {
                $(".show-city").append(
                    `<li><label for="city"><input name="city" value='${element}' type="radio">${element}</label></li>`
                );
            });

            checkedElement(placesList[countryName][0], $(".second-drop"));
        }*/
    };

    const checkedElement = (name, renderTo) => {
        renderTo.empty();
        renderTo.append(name);
    };


    $(document).on("click", '.first-drop', function () {
        $(".show-country").toggleClass("active");
        $(".show-city").removeClass("active");
    });
    $(document).on("click", ".second-drop", function () {
        if ($(".show-country").hasClass('selected')) {
            $(".show-city").toggleClass("active");
            $(".show-country").removeClass("active");
            $(".show-city").addClass("selected");
        } else {
            $(".show-city").removeClass("selected");
            $(".show-country").toggleClass("active");
        }
    });
    $('.regionClassSelector').click(function () {
        $('.first-drop').html($(this).find('input').val())
        $(".show-country").addClass("selected");
        $(".show-city").removeClass("selected");
    })
    $('.cityClassSelector').click(function () {
        $('.second-drop').html($(this).find('input').val())
        $(".show-country").addClass("selected");
        $(".show-city").addClass("selected");
    })
    // Dependense lists END

// Header property filters / dropdown
    const dropdownElems = [$('.dropdown-prise'), $('.dropdown-room-number'), $('.dropdown-building-type'), $('.dropdown-area')]
    const dropdownBtn = [$('.buttonShowPropertyFilterPrice'), $('.buttonShowPropertyFilterRoom'), $('.buttonShowPropertyFilterType'), $('.buttonShowPropertyFilterArea')]

    $('.buttonShowPropertyFilterPrice').click(function (e) {
        $(this).toggleClass('active')
        $('.dropdown-building-area2').removeClass('active');
        remooveDropDownActiveMenu(dropdownElems[0])
    })

    $('.buttonShowPropertyFilterRoom').click(function () {
        $(this).toggleClass('active')
        $('.dropdown-building-area2').removeClass('active');
        remooveDropDownActiveMenu(dropdownElems[1])
    })

    $('.buttonShowPropertyFilterType').click(function () {
        $(this).toggleClass('active')
        $('.dropdown-building-area2').removeClass('active');
        remooveDropDownActiveMenu(dropdownElems[2])
    })
    $('.buttonShowPropertyFilterArea').click(function () {
        $(this).toggleClass('active')
        $('.dropdown-building-area2').removeClass('active');
        remooveDropDownActiveMenu(dropdownElems[3])
    })

    function remooveDropDownActiveMenu(elem) {
        elem.attr("class").split(/\s+/).forEach((item) => {
            if (item === 'active') {
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
        howItPrice(showUserPrice);
    })

    $('.priceMax').keyup(function () {
        userPrise[1] = this.value;
        howItPrice(showUserPrice);
    })

    // AREA RANGE
    $('.inputAreaMin').keyup(function () {
        userAreaRange[0] = this.value;
        howItAreaRange(showAreaRange);
    })

    $('.inputAreaMax').keyup(function () {
        userAreaRange[1] = this.value;
        howItAreaRange(showAreaRange);
    })


    const categorySelector = ".category";
    const categoryMobileSelector = ".categoryMobile"
    const rentForm = "#mainFiltersRent";
    const buyForm = "#mainFiltersRent";
    const formModalNew = '#modalFormId';
    const rentFormMobile = "#mainFiltersRentMobile";
    const buyFormMobile = "#mainFiltersRentMobile";
    const roomNumer = $('.countRoomNumberFilter');
    const priceFilter = $('.houseRentUserPrise');
    const typeProperty = $('.typeProperty');
    const typeArea = $('.typeArea');
    const typeRegion = $('.typeRegion');

    let data = {}

    const categoryName = $(categorySelector).attr("name");
    const categoryNameMobile = $(categoryMobileSelector).attr("name");

    const forms = $(`${rentForm}, ${buyForm}, ${rentFormMobile}, ${buyFormMobile}, ${formModalNew}`);
    const formsOld = $(`${rentForm}, ${buyForm}, ${rentFormMobile}, ${buyFormMobile}`);

    // Handler show full string with tags parameter filter
    const hendleMoreTags = (dataArray) => {
        const nonEmptyCount = dataArray.reduce((acc, [_, value]) => value ? acc + 1 : acc, 0)
        if (nonEmptyCount <= 3) {
            $('.showAllTags').removeClass('active')
        } else {
            $('.showAllTags').addClass('active')
        }
    }


    /*const renderTags = () => {
        $(".tags .option-item").remove();

        const dataArray = Object.entries(data)

        dataArray.forEach(([name, value]) => {
            valueNew = $('#' + name).data()
            if (valueNew != undefined) {
                value = valueNew.valued
            }    //  value = valueNew.value

            if (value && !Array.isArray(value) && value !== 'buy' && value != 'rent') {
                const text = Array.isArray(value) ? value.join(", ") : value;

                switch (name) {
                    case 'area': {
                        if (Array.isArray(value)) {
                            roomNumer.empty()

                            const valArea = value.reduce((acc, n, i, array) => {
                                if (i === 0 || i === array.length - 1) {
                                    acc.push(n + (i === 0 && array.length > 1 ? '-' : ''));
                                } else {
                                    let nextEl = array[i + 1];

                                    if (nextEl && nextEl - n > 0.5) {
                                        acc.push(n, ', ', nextEl + (i + 1 === array.length - 1 ? '' : '-'));
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

                    case 'check-in-date': {
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
                    case 'fullAreaBuy': {
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
                    case 'fleatBuy': {
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


                    case 'arrFilter_61_MAX':

                        $(".tags").append(`<div class="option-item"><button onclick="$(this).parent('div').remove()" type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} ₪ max</span></div>`)
                        break;


                    case 'arrFilter_61_MIN':

                        $(".tags").append(`<div class="option-item"><button onclick="$(this).parent('div').remove()" type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${value} ₪ min</span></div>`)
                        break;

                    default:
                        // do this
                        $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${text}</span></div>`)
                        break;
                }
            }
        });

        hendleMoreTags(dataArray)
    };*/
    const renderTags = () => {
        $(".tags .option-item").remove();

        const dataArray = Object.entries(data)
        let tagProps = [];
        dataArray.forEach(([name, value]) => {
            if (![categoryName].includes(name) && value) {
                const text = Array.isArray(value) ? value.join(", ") : value;
                const reg = /^arrFilter/u;
                const notTagPropListCodes = [
                    'price',
                    'area',
                    'input-studio-rent',
                    'input-free-layout-rent',
                    'areaTypeBuilduing',
                ];

                if (!reg.test(name) && !notTagPropListCodes.includes(name)) {
                    tagProps.push([name, value]);
                }

                switch (name) {
                    case 'area': {
                        if (Array.isArray(value)) {
                            roomNumer.empty()

                            const valArea = value.reduce((acc, n, i, array) => {
                                if (i === 0 || i === array.length - 1) {
                                    acc.push(n + (i === 0 && array.length > 1 ? '-' : ''));
                                } else {
                                    let nextEl = array[i + 1];

                                    if (nextEl && nextEl - n > 0.5) {
                                        acc.push(n, ', ', nextEl + (i + 1 === array.length - 1 ? '' : '-'));
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

                    case 'check-in-date': {
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
                    case 'fullAreaBuy': {
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
                    case 'fleatBuy': {
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

                    /* default:
                         // do this
                         $(".tags").append(`<div class="option-item"><button type="button" data-clear-name="${name}" class="closer" ><span aria-hidden="true">&times;</span></button><span class="title">${text}</span></div>`)
                         break;*/
                }
            }
        });

        hendleMoreTags(tagProps)
    };
    // сохранение данных в скрытую форму для отправки
    const setDataToForm = (data) => {
        $("#mainFiltersRent").val(JSON.stringify(data));
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
        //  $(rentForm)[0].reset();
        //  $(buyForm)[0].reset();
        //  $(rentFormMobile)[0].reset();
        //  $(buyFormMobile)[0].reset();
    }

    // изменение категории
    $(categorySelector).on("change", (e) => {
        // $(".main-filters, .modals").toggleClass("hide");

        resetAllForms()
    });

    $(categoryMobileSelector).on("change", (e) => {
        //  $(".main-filters, .modals").toggleClass("hide");
        resetAllForms()
    });

    $('.ressetFilterAll').on('click', () => {
        resetAllForms()
    })

    // отправка форм на изменение филдов
    let loc = document.location.pathname
    if (loc.includes('/property/')) {
        if (loc.search.length) {
            const formData = $(forms)
                .serializeArray()
                .reduce((acc, {name, value}) => {
                    if (acc[name]) {
                        if (Array.isArray(acc[name])) {
                            return {...acc, [name]: [...acc[name], value]};
                        } else {
                            return {...acc, [name]: [acc[name], value]};
                        }
                    }

                    return {...acc, [name]: value};
                }, {});
            let allData = $('#mainFiltersRent').find('input');
            updateData(formData);
        }
    }
    forms.find("input").on("change", function () {

        $(this).parents().filter("form").submit();
    });

// прерываем отправку формы и записываем данные
    forms.submit(function (e) {
        e.preventDefault();

        const formData = $(forms)
            .serializeArray()
            .reduce((acc, {name, value}) => {
                if (acc[name]) {
                    if (Array.isArray(acc[name])) {
                        return {...acc, [name]: [...acc[name], value]};
                    } else {
                        return {...acc, [name]: [acc[name], value]};
                    }
                }

                return {...acc, [name]: value};
            }, {});
        let allData = $('#mainFiltersRent').find('input');
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
    $(document).ready(function () {
        const btnToTheTop = $('#btnToTheTop');

        $(window).scroll(function () {
            if ($(window).scrollTop() > 1300) {
                btnToTheTop.addClass('show');
            } else {
                btnToTheTop.removeClass('show');
            }
        });

        btnToTheTop.on('click', function (e) {
            e.preventDefault();
            $(document).scrollTop(0)
        });
    })
})

$(document).ready(function () {

    $('.smart-filter-dropdown-next').on('click', function () {
        $(".smart-filter-dropdown-popup-new").toggleClass("active");
        let target = event.target
        if (target.classList.contains("smart-filter-dropdown-label")) {
            $(".filter-dropdown-next-text").text(target.innerText);
        }


    });


    const listChoice = document.querySelectorAll(".smart-filter-choice");
    const listNew = document.querySelector("#smartFilterChoiceNew");
    window.onload = selectCountry;
    listChoice.forEach((el) => {
        el.addEventListener("click", () => {
            let item = el.getAttribute("data-name");
            //  selectCountry(item)
        })
    })

    function selectCountry(ev) {

        var c = ev;
        /*  for(let i = 0; i < listsArr[c].length; i++){
              let li = document.createElement('li');
              li.innerHTML = `<label class="smart-filter-dropdown-label">${(listsArr[c][i])}</label>`;
              listNew.appendChild(li);
          };*/
    }

    let allRadioDateBtn = document.querySelectorAll('div#dateRadioSelector input[type="radio"]');
    if (allRadioDateBtn.length > 1) {
        allRadioDateBtn.forEach((dateBtn) => {
            dateBtn.onclick = () => {
                let allOptions = document.querySelectorAll('select#dateSelectSelector > option');
                if (allOptions.length > 0) {
                    allOptions[0].selected = true;
                }
            }
        });
    }
});

function resetActiveYears () {
    let allRadioDateBtn = document.querySelectorAll('div#dateRadioSelector input[type="radio"]');
    if (allRadioDateBtn.length > 1) {
        allRadioDateBtn.forEach((dateBtn) => {
            if (dateBtn.checked) {
                dateBtn.checked = false;
            }
        });
    }
}