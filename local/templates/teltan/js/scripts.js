$(document).ready(function () {
    const $body = $('body');
    const $filterModalContetn = $('#filterModalContent')
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
    });

    $('.cityClassSelector').click(function () {
        $('.second-drop').html($(this).find('input').val())
        $(".show-country").addClass("selected");
        $(".show-city").addClass("selected");
    });
    // Dependense lists END

    // Header property filters / dropdown
    const dropdownElems = [$('.dropdown-prise'), $('.dropdown-room-number'), $('.dropdown-building-type'), $('.dropdown-area')]

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
    const showAreaRange = document.querySelector('.rentAreaCommerce');

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
    const typeProperty = $('.typeProperty');

    let data = {}

    const categoryName = $(categorySelector).attr("name");
    const categoryNameMobile = $(categoryMobileSelector).attr("name");

    const forms = $(`${rentForm}, ${buyForm}, ${rentFormMobile}, ${buyFormMobile}, ${formModalNew}`);


    // Handler show full string with tags parameter filter
    const hendleMoreTags = (dataArray) => {
        const nonEmptyCount = dataArray.reduce((acc, [_, value]) => value ? acc + 1 : acc, 0)
        if (nonEmptyCount <= 3) {
            $('.showAllTags').removeClass('active')
        } else {
            $('.showAllTags').addClass('active')
        }
    }

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