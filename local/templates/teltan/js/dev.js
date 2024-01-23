$(document).ready(function () {

    $('.liParentItem').click(function () {
        $('#liTarget').find('li').hide()
        $('#liTarget').find('li[data-parent-id="' + this.id + '"]').show()

    })

    $('div.wizard-content *[id]').each(function() {
        var id = $(this).attr('id');
        var duplicates = $('div.wizard-content *[id="' + id + '"]');
        if (duplicates.length > 1) {
            if ($(this).parents('.additional').length === 0 && $(this).attr('id') != 'bs-select-22' && $(this).attr('id') != 'main-selector-photo'){
                $(this).parents('.mb-4').remove()
            }
        }
    });
    if( screen.width <= 480 ) {
        $('.m-0.font-weight-bold').each(function (index) {
            if ($(this).parents('.d-lg-block.col-2').length > 0){
                $(this).parents('.d-lg-block.col-2').addClass('col-js');
                $(this).parents('.d-lg-block.col-js').removeClass('col-2');
                $(this).parents('.d-lg-block.col-js').addClass('col-12');
            }
        })
    }
    $('.d-flex.justify-content-center.justify-content-lg-start.flex-wrap').each(function (index) {
     if ($(this).children('.additional').length > 0){
         $(this).removeClass('justify-content-lg-start');
         $(this).removeClass('flex-row-reverse');
         $(this).addClass('justify-content-lg-end');
     }
    })

    $('.dropdown-menu').on('click', '.dropdown-item', function(event) {
        if (!$(this).hasClass('border-bottom')) {
            var href = $('#target_dom').attr('href');
            var params = href.split('?');
            /*event.preventDefault();
            let search = window.location.search.split('&').slice(2).join('&');
            */

            if (params.length == 2) {
                let url = $(this).attr('href') + '&' + params[1].split('&').slice(2).join('&');
                $(this).attr('href',  url);
            } else {
                let url = $(this).attr('href')  + '&' + params[0].split('&').slice(2).join('&');
                $(this).attr('href',  url);
            }

        }
    });
    $('.btn-rm-data').click(function () {
        setTimeout(function() {
            $('#messageContent').val('');
            $('#fileUploaderRenderMessageContainer').find('.upload-file').each(function (index) {
                $(this).remove();
            });
        }, 500);
    });
    $('.parentClass').click(function () {
        $('.second-drop').html('')
    })
    $('.pop-up-cross').on('click', function () {
        this.closest(".pop-up").classList.remove("active");
    });

    $('.parentClass input').click(function (ev) {
        ev.stopPropagation();

        let parent = $(this).attr('id');
        $('.show-city').find('input').each(function () {

            $(this).parent('label').parent('li').hide()
            if ($(this).attr('data-parent-class') === parent) {

                $(this).parent('label').parent('li').show()

            } else {

                $(this).parent('label').parent('li').hide()
            }
        })
    })

    function renderCity(id) {
        let parent = id;
        $('.show-city').find('input').each(function () {

            $(this).parent('label').parent('li').hide()
            if ($(this).attr('data-parent-class') === parent) {
                $(this).parent('label').parent('li').show()
            } else {
                $(this).parent('label').parent('li').hide()
            }
        })
    }

    $(document).on("submit", "#signInUser", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/auth.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
                if (msg == true) {
                    window.location.reload();
                }
            }
        });
        //return false;
    });

    $(document).on("submit", "#forgot_pass", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/forgot_pass.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE']) {
                    $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
            }
        });
        //return false;
    });


    function NextInputNumber(arr) {
        arr.forEach((el, index) => {

            el.addEventListener("input", () => {

                if (el.value !== "" && index !== arr.length - 1) {
                    arr[index + 1].focus();
                }

            })
        })
    }

    $(document).on("submit", "#register", function (e) {
        e.preventDefault();

        let codeDataInput = document.querySelectorAll(".code-group__data");
        NextInputNumber(codeDataInput);

        $.ajax({
            type: "POST",
            url: "/ajax/register.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
                if (msg['OK'] == "Y") {
                    $('#confirmCode').modal('show');
                    $('#registerModal').modal('hide');
                    $('input[name=type_confirm]').val('register');
                    $('input[name=id_user]').val(msg['ID_USER']);
                    //window.location.reload();
                }
            }
        });
    });

    $(document).on("click", "#sendagainregister", function (e) {
        e.preventDefault();

        let codeDataInput = document.querySelectorAll(".code-group__data");
        NextInputNumber(codeDataInput);

        $.ajax({
            type: "POST",
            url: "/ajax/registerAgain.php",
            data: $('#register').serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
                if (msg['OK'] == "Y") {
                    $('#confirmCode').modal('show');
                    $('#registerModal').modal('hide');
                    $('input[name=type_confirm]').val('register');
                    $('input[name=id_user]').val(msg['ID_USER']);
                    //window.location.reload();
                }
            }
        });
    });

    $(document).on("submit", "#confirmCodeForm", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/check_confirm.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    $('span.error').empty().append(msg['MESSAGE']);
                }
                if (msg['OK'] == "Y") {
                    window.location.reload();
                }
            }
        });
    });

    $(document).on("click", ".like, .like_f, .product-line__like", function (e) {

        e.preventDefault();
        let like = $(this);
        let id = like.data('ad_id');
        let del = 'N';
        if (like.hasClass('active')) {
            del = 'Y';
        }


        $.ajax({
            type: "POST",
            url: "/ajax/favorites.php",
            data: {
                id: id,
                del: del
            },
            success: function (msg) {
                if (msg['OK'] == "Y") {
                    let count_f = Number($('.user-follows__counter span').text());
                    if (del == 'Y') {
                        like.removeClass('active');
                        count_f -= 1;
                        if (count_f <= 0) {
                            $('.user-follows__counter').removeClass('not-empty');
                            count_f = 0;
                        }

                        $('.user-follows__counter span').html(count_f);
                    } else {
                        like.addClass('active');
                        count_f += 1;
                        if (count_f > 99)
                            count_f = 99;
                        if (!$('.user-follows__counter').hasClass('not-empty'))
                            $('.user-follows__counter').addClass('not-empty');
                        $('.user-follows__counter span').html(count_f);
                    }

                }
            }
        });
    });


    $(document).on("submit", "#update_user", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/update_user.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                    $('.allert__text').html('השינויים התבצעו בהצלחה  </br>' + msg['MESSAGE']);

                    $('.del_all_in_chat').html('ok');
                    $('.alert-confirmation').addClass('show');
                }
                if (msg['TYPE'] == "POPUP") {

                    $('#confirmCode').modal('show');
                    $('#confirmCodeForm input[name=type_confirm]').val('update_phone');
                    $('#confirmCodeForm').append($('<input>', {
                        type: 'hidden',
                        name: 'number',
                        value: msg['NUMBER']
                    }));

                }

            }
        });
        //return false;
    });

    $(document).on("submit", "#change_pass", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/change_password.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    $('.pop-up').addClass('active');
                    $('.pop-up__text').html(msg['MESSAGE']);
                    $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
                if (msg['TYPE'] == "OK") {
                    $('.pop-up').addClass('active');
                    $('.pop-up__text').html('שינוי הסיסמה יתבצע בהצלחה');
                }

            }
        });
    });

   $(document).on("submit", "form[name=send_message]", function (e) {
        e.preventDefault();
       var a = 0;
       var $imgobject = {};
       $(this).find('.upload-file').each(function () {

           $imgobject['img'+ a] = $(this).data('src');
           a++;
       });
       var form = $(this);
       var $data2 = {};
       $data2['files'] = $imgobject;
       $data2['idAd'] = $('#idAd').val();
       $data2['messageContent'] = $('#messageContent').val();
        $.ajax({

            type: "POST",
            url: "/ajax/send_message.php",
            data: $data2,
            success: function (msg) {
                if (msg['TYPE'] == "ERROR") {
                    //$('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
                if (msg['TYPE'] == "OK") {
                    $('#messageContent').empty();
                    $('.alert-confirmation').addClass('show');
                    setTimeout(function () {
                        $('.alert-confirmation').removeClass('show');
                    }, 2000);
                    $('#modalSandMessage').modal('hide');
                    $('#modalFullSize').modal('hide');

                }
            }
        });
        //return false;
    });
    /*$(document).on("submit", "form[name=send_lk_mess]", function(e){

        var a = 0;
        var $imgobject = {};
        $(this).find('.upload-file__name').each(function () {

            $imgobject['img'+ a] = $(this).data('src');
            a++;
        });
        var $data2 = {};
        $data2['img'] = $imgobject;



        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/send_lk_mess.php",
            data: $data2,
            dataType: 'json',
            success: function(msg){
                if(msg['TYPE'] == "ERROR"){
                    //$('span.error_auth_mess').empty().append(msg['MESSAGE']);
                }
                if(msg['TYPE'] == "OK"){
                    let boxChat = '<div class="d-flex flex-column text-right message message-sand"><p class="user-info text-secondary"><span class="pr-3 mr-3 border-right">Сегодня, 01:28</span>  <span> grgrg445</span></p><p class="text">'+$('input[name=messageText]').val()+'</p><p class="mb-0 status">Отправлено</p></div>';

                    $('input[name=messageText]').val('');
                    $('#chatUploadFileBox').empty();
                    $('.chat__message-window').append(boxChat);
                }
            }
        });
    });*/

    $(document).on('click', '.del_all_chat', function () {
        $.ajax({
            type: "POST",
            url: "/ajax/del_all_chat.php",
            data: $(this).serialize(),
            success: function (msg) {
                if (msg['TYPE'] == "OK") {
                    $('.block_chats').empty().append('<div class="mb-4 card d-flex flex-column flex-lg-row w-100 justify-content-around no-message">\n' +
                        '                        <div class="mb-3 mb-0 d-flex flex-column align-items-center justify-content-center">\n' +
                        '                            <p class="mb-4">У вас пока что нет сообщений</p>\n' +
                        '                            <img src="/local/templates/teltan/assets/no-message.svg" alt="">\n' +
                        '                        </div>\n' +
                        '                    </div>');
                    $('.allert').removeClass('show');
                }
            }
        });
    });

    $(document).on('click', '.del_all_in_chat', function () {
        $('.allert__text').html('Вы действительно хотите удалить все сообщения?');
        $('.btn_confirm').addClass('del_all_in_chat');
        $('.btn_confirm').attr('data-pr1', $(this).data('ad'));
        $('.btn_confirm').attr('data-pr2', $(this).data('au'));
        $('.del_all_in_chat').html('Удалить');
        $('.alert-confirmation').addClass('show');
    })

    $(document).on('click', '.del_all_in_chat', function () {
        let adId = $(this).data('pr1');
        let recipientId = $(this).data('pr2');

        $.ajax({
            type: "POST",
            url: "/ajax/delchat.php",
            data: 'adId=' + adId + '&recipientId=' + recipientId + '',
            success: function (msg) {
                getCountMess();
                if (msg['TYPE'] == "OK") {
                    window.location.href = '/personal/messages/';
                }
            }
        });
    });

    function getCountMess() {
        $.ajax({
            type: "POST",
            url: "/ajax/count_mess.php",
            data: '',
            success: function (count) {
                if (count) {
                    $('.counter-user-message span').text(count);
                    $('.user-message__counter span').text(count);
                }
            }
        });
    }


    $(document).on('click', '.del_all_chats', function () {
        $('.allert__text').html('Вы действительно хотите удалить все чаты?');
        $('.btn_confirm').addClass('del_all_chat');
        $('.btn_confirm').removeClass('del_chat');
        $('.alert-confirmation').addClass('show');
    })

    $(document).on('click', '.deleteChatPopup', function () {
        $('.allert__text').html('Вы действительно хотите удалить чат?');
        $('.btn_confirm').addClass('del_chat');
        $('.btn_confirm').removeClass('del_all_chat');
        $('.btn_confirm').attr('data-pr1', $(this).data('ad'));
        $('.btn_confirm').attr('data-pr2', $(this).data('au'));
        $('.alert-confirmation').addClass('show');
    })

    $(document).on('click', '.del_chat', function () {
        let adId = $(this).attr('data-pr1');
        let recipientId = $(this).attr('data-pr2');

        $.ajax({
            type: "POST",
            url: "/ajax/delchat.php",
            data: 'adId=' + adId + '&recipientId=' + recipientId + '',
            success: function (msg) {
                if (msg['TYPE'] == "OK") {
                    getCountMess();
                    $('.deleteChatPopup[data-ad=' + adId + '][data-au=' + recipientId + ']').parent().parent().parent().parent().remove();
                    $('.allert').removeClass('show');
                }
            }
        });
    });

    $(document).on('click', '.btn-blocked', function () {
        $('.allert__text').html('Вы действительно хотите заблокировать пользователя?');
        $('.btn_confirm').addClass('block_user');
        $('.btn_confirm').removeClass('del_all_in_chat');
        $('.btn_confirm').attr('data-pr1', $(this).data('ad'));
        $('.btn_confirm').attr('data-pr2', $(this).data('au'));
        $('.block_user').html('Заблокировать');
        $('.alert-confirmation').addClass('show');
    })
    $(document).on('click', '.btn-unlocked', function () {
        $('.allert__text').html('Вы действительно хотите разблокировать пользователя?');
        $('.btn_confirm').addClass('block_user');
        $('.btn_confirm').removeClass('del_all_in_chat');
        $('.btn_confirm').attr('data-pr1', $(this).data('ad'));
        $('.btn_confirm').attr('data-pr2', $(this).data('au'));
        $('.block_user').html('Разблокировать');
        $('.alert-confirmation').addClass('show');
    })

    $(document).on('click', '.block_user', function () {
        let ad = $(this).data('pr1');
        let au = $(this).data('pr2');
        $.ajax({
            type: "POST",
            url: "/ajax/block_user.php",
            data: 'ad=' + ad + '&au=' + au + '',
            success: function (msg) {
                if (msg['TYPE'] == "OK") {
                    window.location.reload();
                }
                if (msg['TYPE'] == "RESET") {
                    window.location.reload();
                }
            }
        });
    });

    $(document).on('click', ".section_id_a", function () {
        let IDSection = $(this).data('id_section');

        $('input[name=section_id]').val(IDSection);

        $.ajax({
            type: "POST",
            url: "/ajax/show_props.php",
            data: 'section=' + IDSection,
            success: function (msg) {
                $('.section_props_user').empty().html(msg);
            }
        });
    })

    let radioBtn = document.querySelectorAll('form#mainForm div[data-wizard-content="0"] .form_radio_btn input[name="type"]');
    if (radioBtn.length > 0) {
        let clicked = false;
        radioBtn.forEach((radio) => {
            if (radio.checked === true) {
                radio.parentNode.querySelector('label').click();
                clicked = true;
            }
        });
        if (clicked === false) radioBtn[0].parentNode.querySelector('label').click();
    }

    //  $("#registerPhone").mask("0(999) 999-9999");
    $('#area1toogle').click(function () {
        $('.dropdown-filter').removeClass('active')
        $('.dropdown-room-number').removeClass('active')
        $('.dropdown-building-type').removeClass('active')
        $('.dropdown-filter').removeClass('active')
        $('.dropdown-building-area1').toggleClass('active');
    })
    $('.custom-btn-property').click(function () {
        if (!$(this).hasClass('custom-btn-property--new')) {
            $('.dropdown-building-area1').removeClass('active');
        }
    })
    $('.dropdown-card__content li').click(function () {
        // $(this).parents('.dropdown-card').slideToggle(300);
        // let data = $(this).find('input').attr('data-valued')
        //  $(this).parents('.dropdown-card').removeClass("active");
        // $(this).parents('.dropdown-block').find('.type').text(data);
        let data = $(this).closest('.dropdown-card__content').find('li input');
        let viewValue = [];
        data.each((index, input) => {
            if (input.checked === true) viewValue.push(input.getAttribute('data-valued'));
        });
        $(this).parents('.dropdown-block').find('.type').text(viewValue.join(', '));

        // if (Array.isArray(value)) {
        //     typeProperty.empty()
        //     typeProperty.append(data.areaTypeBuilduing.join(', '));
        // } else {
        //     typeProperty.empty()
        //     typeProperty.append(data.areaTypeBuilduing);
        // }
    });


    $('#area2toogle').click(function () {
        const listInput = document.querySelectorAll(".dropdown-building-area1 li input");
        let flag = false;
        listInput.forEach((el)=>{
            if(el.checked){
                flag = true;
                return flag
            }
        })
        if(flag){
            $('.dropdown-building-area2').toggleClass('active');
        }else{

            $('.dropdown-building-area1').toggleClass('active');
            $('.dropdown-building-area2').removeClass('active');
        }

    })


    $('.data-function').click(function () {
        let elems = $('.dropdown-building-area2').find('input');
        let parentElems = $('.dropdown-building-area1').find('input');
        let checked = $(this).prop("checked");
        let parentCheckedValue = []
        parentElems.each(function (index) {
            let checkedD = $(this).prop("checked");
            let dataD = $(this).data();
            if (checkedD) {
                parentCheckedValue.push(dataD.valued)
            }
        })


        elems.each(function (index) {
            let parentId = $(this).data();
            if (checked) {
                $('.dropdown-building-area2').addClass('active');
                if (parentCheckedValue.includes(parentId.parentItemId)) {
                    $(this).parent('label').parent('li').show()
                } else {
                    $(this).parent('label').parent('li').hide()
                }

            } else {
                if (!parentCheckedValue.includes(parentId.parentItemId)) {
                    $(this).parent('label').parent('li').hide()
                }
            }

        })
    });

    $(document).ready(() => {
        let elems = $('.dropdown-building-area2').find('input');
        let parentElems = $('.dropdown-building-area1').find('input');
        let checked = $(this).prop("checked");
        let parentCheckedValue = []
        parentElems.each(function (index) {
            let checkedD = $(this).prop("checked");
            let dataD = $(this).data();
            if (checkedD) {
                parentCheckedValue.push(dataD.valued)
            }
        })


        elems.each(function (index) {
            let parentId = $(this).data();
            if (checked) {
                $('.dropdown-building-area2').addClass('active');
                if (parentCheckedValue.includes(parentId.parentItemId)) {
                    $(this).parent('label').parent('li').show()
                } else {
                    $(this).parent('label').parent('li').hide()
                }

            } else {
                if (!parentCheckedValue.includes(parentId.parentItemId)) {
                    $(this).parent('label').parent('li').hide()
                }
            }

        })
    });

    setTimeout(function () {
        let name1 = '';
        var url = window.location.href;
        if (url.indexOf('set_filter=') >= 0) {

            $('.dropdown-building-area2').find('input').each(function (index) {
                let checked = $(this).prop("checked");

                if (checked) {
                    name1 = name1 + ' , ' + $(this).val()
                }

				if(name1.length > 4){
                $('.typeArea ').html(name1);
				}
            });
            let name = '';
            $('.dropdown-building-area1').find('input').each(function (index) {
                let checked = $(this).prop("checked");

                if (checked) {
                    name = name + ' , ' + $(this).val()
                }

                if(name.length > 4){
                    $('.typeRegion').html(name);
                }
            });
        }
    }, 2000);


    // Избранное
    if (typeof favorites !== "undefined") {
        if (favorites.length) {
            $(favorites).each(function (e, i) {
                $('.like[data-ad_id="' + i + '"]').addClass('active');
                $('.product-line__like[data-ad_id="' + i + '"]').addClass('active');
                $('.like_f[data-ad_id="' + i + '"]').addClass('active');
            })
        }
    }

    function getParams()
    {
        let params = window
            .location
            .search
            .replace('?','')
            .split('&')
            .reduce(
                function(p,e){
                    var a = e.split('=');
                    p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                    return p;
                },
                {}
            );

        return params;
    }


    $('.submit-btn-search').click(function (e) {
        let url = '';
        let prams = getParams();
        if (prams['view'] === 'maplist')  url += 'view=maplist&'
        url += 'set_filter=y';
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
                }else{

                    let data = $(this).data();
                    let val = $(this).val();
                    if (val !== '') {
                        let dateString = val;
                        let date = new Date(dateString);

                        let options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                        let formattedDate = date.toLocaleDateString('en-GB', options);
                        if (data.controlId !== undefined) {
                            url = url + '&' + data.controlId + '=' + formattedDate;
                        }
                    }
                }
            }
        })
        location.href = location.pathname + '?'+ url;
    })

    $('.submitFilterAll').click(function (e) {
        let url = 'set_filter=y';
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

                }else {
                    let data = $(this).data();
                    let val = $(this).val();
                    if (val !== '') {
                        let dateString = val;
                        let date = new Date(dateString);

                        let options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                        let formattedDate = date.toLocaleDateString('en-GB', options);
                        if (data.controlId !== undefined) {
                            url = url + '&' + data.controlId + '=' + formattedDate;
                        }
                    }
            }}
        })

        location.href = location.pathname + '?'+ url;
    });

    $('.btn-show-map').click(function (e) {
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
                }else {
                    let data = $(this).data();
                    let val = $(this).val();
                    if (val !== '') {
                        let dateString = val;
                        let date = new Date(dateString);

                        let options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                        let formattedDate = date.toLocaleDateString('en-GB', options);
                        if (data.controlId !== undefined) {
                            url = url + '&' + data.controlId + '=' + formattedDate;
                        }
                    }
                }
            }
        });

        location.href = location.pathname + '?'+ url;
    });

    $('.btn-show-catalog').click(function (e) {
        let url = 'set_filter=y';
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

                }else {
                    let data = $(this).data();
                    let val = $(this).val();

                    if (val !== '') {
                        let dateString = val;
                        let date = new Date(dateString);

                        let options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                        let formattedDate = date.toLocaleDateString('en-GB', options);
                        if (data.controlId !== undefined) {
                            url = url + '&' + data.controlId + '=' + formattedDate;
                        }
                    }
                }
            }
        })
        location.href = location.pathname + '?'+ url;
    })

    $('#categoryRentInput').parent('label').click(function () {
        $('#rent_modal_body').show()
        $('#buy_modal_body').hide()
    })
    $('#categoryBuyInput').parent('label').click(function () {
        $('#buy_modal_body').show()
        $('#rent_modal_body').hide()
    })
    $('.ressetFilterAll').click(function () {
        location.search = '';
    })
    switch (localStorage.getItem('FILTER_SECTION_ID')) {
        case '35':
            $('#rent_modal_body').hide()
            break;
        case '33':
            $('#rent_modal_body').hide()
            break;
        case '34':
            $('#buy_modal_body').hide()
            break;
        case '32':
            $('#buy_modal_body').hide()
            break;
    }


});

window.onload = function () {
    const screenWidth = window.screen.width
    if (screenWidth < 768) {
        $(window).scroll(function () {
            var st = $(this).scrollTop();
            if (st > 550) {
                $(".mobile-block-show-contacts").attr('style', 'display:flex');
            } else {
                $(".mobile-block-show-contacts").attr('style', 'display:none');
            }

        });
    }

};


