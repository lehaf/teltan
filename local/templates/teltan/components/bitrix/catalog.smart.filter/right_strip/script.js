function JCSmartFilter(ajaxURL, viewMode, params)
{
    this.ajaxURL = ajaxURL;
    this.form = null;
    this.timer = null;
    this.cacheKey = '';
    this.cache = [];
    this.viewMode = viewMode;

    if (params && params.SEF_SET_FILTER_URL)
    {
        this.bindUrlToButton('set_filter', params.SEF_SET_FILTER_URL);
        this.sef = true;
    }

    if (params && params.SEF_DEL_FILTER_URL)
    {
        this.bindUrlToButton('del_filter', params.SEF_DEL_FILTER_URL);
    }

}


JCSmartFilter.prototype.showLoader = function()
{
    $('.preloader').css({"z-index": "1", "opacity": "100", "position": "fixed", "dispaly": "block" });
};

JCSmartFilter.prototype.hideLoader = function ()
{
    $('.preloader').css({"z-index": "0", "opacity": "0", "position": "fixed", "dispaly": "none" });
}

JCSmartFilter.prototype.keyup = function(input)
{
    this.showLoader();
    if(!!this.timer)
    {
        clearTimeout(this.timer);
    }
    this.timer = setTimeout(BX.delegate(function(){
        this.reload(input);
    }, this), 500);

};

JCSmartFilter.prototype.click = function(checkbox)
{
    this.showLoader();
    if(!!this.timer)
    {
        clearTimeout(this.timer);
    }

    this.timer = setTimeout(BX.delegate(function(){
        this.reload(checkbox);
    }, this), 500);

};

JCSmartFilter.prototype.reload = function(input)
{
    if (this.cacheKey !== '')
    {
        //Postprone backend query
        if(!!this.timer)
        {
            clearTimeout(this.timer);
        }
        this.timer = setTimeout(BX.delegate(function(){
            this.reload(input);
        }, this), 1000);
        return;
    }
    this.cacheKey = '|';

    this.position = BX.pos(input, true);
    this.form = BX.findParent(input, {'tag':'form'});
    if (this.form)
    {
        var values = [];
        values[0] = {name: 'ajax', value: 'y'};
        this.gatherInputsValues(values, BX.findChildren(this.form, {'tag': new RegExp('^(input|select)$', 'i')}, true));

        for (var i = 0; i < values.length; i++)
            this.cacheKey += values[i].name + ':' + values[i].value + '|';

        if (this.cache[this.cacheKey])
        {
            this.curFilterinput = input;
            this.postHandler(this.cache[this.cacheKey], true);
        }
        else
        {
            if (this.sef)
            {
                var set_filter = BX('set_filter');
                set_filter.disabled = true;
            }

            this.curFilterinput = input;

            BX.ajax.loadJSON(
                this.ajaxURL,
                this.values2post(values),
                BX.delegate(this.postHandler, this)
            );
        }
    }

};

JCSmartFilter.prototype.updateItem = function (PID, arItem)
{
    if (arItem.PROPERTY_TYPE === 'N' || arItem.PRICE)
    {
        var trackBar = window['trackBar' + PID];
        if (!trackBar && arItem.ENCODED_ID)
            trackBar = window['trackBar' + arItem.ENCODED_ID];

        if (trackBar && arItem.VALUES)
        {
            if (arItem.VALUES.MIN && arItem.VALUES.MIN.FILTERED_VALUE)
            {
                trackBar.setMinFilteredValue(arItem.VALUES.MIN.FILTERED_VALUE);
            }

            if (arItem.VALUES.MAX && arItem.VALUES.MAX.FILTERED_VALUE)
            {
                trackBar.setMaxFilteredValue(arItem.VALUES.MAX.FILTERED_VALUE);
            }
        }
    }
    else if (arItem.VALUES)
    {
        for (var i in arItem.VALUES)
        {
            if (arItem.VALUES.hasOwnProperty(i))
            {
                var value = arItem.VALUES[i];
                var control = BX(value.CONTROL_ID);

                if (!!control)
                {
                    var label = document.querySelector('[data-role="label_'+value.CONTROL_ID+'"]');
                    if (value.DISABLED)
                    {
                        if (label)
                            BX.addClass(label, 'disabled');
                        else
                            BX.addClass(control.parentNode, 'disabled');
                    }
                    else
                    {
                        if (label)
                            BX.removeClass(label, 'disabled');
                        else
                            BX.removeClass(control.parentNode, 'disabled');
                    }

                    if (value.hasOwnProperty('ELEMENT_COUNT'))
                    {
                        label = document.querySelector('[data-role="count_'+value.CONTROL_ID+'"]');
                        if (label)
                            label.innerHTML = value.ELEMENT_COUNT;
                    }
                }
            }
        }
    }
};

JCSmartFilter.prototype.postHandler = function (result, fromCache)
{
    const _this = this;
    var hrefFILTER, url, curProp;
    var modef = BX('modef');
    var modef_num = BX('modef_num');


    if (!!result && !!result.ITEMS)
    {
        for(var PID in result.ITEMS)
        {
            if (result.ITEMS.hasOwnProperty(PID))
            {
                this.updateItem(PID, result.ITEMS[PID]);
            }
        }

        if (!!modef && !!modef_num)
        {
            modef_num.innerHTML = result.ELEMENT_COUNT;
            hrefFILTER = BX.findChildren(modef, {tag: 'A'}, true);

            if (result.FILTER_URL && hrefFILTER)
            {
                hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL);
            }

            if (result.FILTER_AJAX_URL && result.COMPONENT_CONTAINER_ID)
            {
                BX.bind(hrefFILTER[0], 'click', function(e)
                {
                    url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
                    BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
                    return BX.PreventDefault(e);
                });
            }

            if (result.INSTANT_RELOAD && result.COMPONENT_CONTAINER_ID)
            {
                url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
                BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
            }
            else
            {
                if (modef.style.display === 'none')
                {

                    modef.style.display = 'inline-block';
                }


                if (this.viewMode == "vertical")
                {
                    curProp = BX.findChild(BX.findParent(this.curFilterinput, {'class':'bx_filter_parameters_box'}), {'class':'bx_filter_container_modef'}, true, false);
                    curProp.appendChild(modef);
                }

                if (result.SEF_SET_FILTER_URL)
                {
                    this.bindUrlToButton('set_filter', result.SEF_SET_FILTER_URL);
                }
            }
        }
    }

    if (this.sef)
    {
        var set_filter = BX('set_filter');
        set_filter.disabled = false;
    }

    if (!fromCache && this.cacheKey !== '')
    {
        this.cache[this.cacheKey] = result;
    }
    this.cacheKey = '';
    let ajax_url = result.FILTER_URL;
    ajax_url = ajax_url.replace(/&amp;/g, "&");
    history.pushState(null, null, ajax_url);
    $.ajax({
        url: ajax_url,
        method: 'get',
        dataType: 'html',
        success: function(data){
        $('#target_container').html($(data).find('#target_container').html());
            $('#target_container').find('.products-sort__button').each(function (index) {
                $(this).attr('href' , ajax_url)
            });
            $('#target_container').find('.pagination').find('a').each(function (index) {
                if($(this).attr('href') !== undefined){
                    let url = $(this).attr('href');
                    let params = ajax_url;
                    let urlObj = new URL(url, window.location.origin + window.location.pathname);
                    let paramsObj = new URLSearchParams(params);
                    for (let [key, value] of paramsObj) {
                        let index = key.indexOf('?')
                        if (index !== -1) {
                            key = key.substring(index + 1);
                        }
                        urlObj.searchParams.set(key, value);
                    }
                    $(this).attr('href' , urlObj.href);
                }

            })

            $('.dropdown-menu').find('.dropdown-item').each(function(){

                if (!$(this).hasClass('border-bottom')) {
                    if($(this).attr('href') !== undefined){
                        let url = $(this).attr('href');
                        let params = ajax_url;
                        let urlObj = new URL(url, window.location.origin + window.location.pathname);
                        let paramsObj = new URLSearchParams(params);

                        for (let [key, value] of paramsObj) {
                            let index = key.indexOf('?')
                            if (index !== -1) {
                                key = key.substring(index + 1);
                            }
                            urlObj.searchParams.set(key, value);
                        }

                        $(this).attr('href' , urlObj.search);
                    }
                }
            });
            // reinit lazy-load
            if (window.ImageDefer) window.ImageDefer.init();
            _this.hideLoader();
        }
    });
};

JCSmartFilter.prototype.bindUrlToButton = function (buttonId, url)
{
    var button = BX(buttonId);
    if (button)
    {
        var proxy = function(j, func)
        {
            return function()
            {
                return func(j);
            }
        };

        if (button.type == 'submit')
            button.type = 'button';

        BX.bind(button, 'click', proxy(url, function(url)
        {
            return false;
        }));
    }

};

JCSmartFilter.prototype.gatherInputsValues = function (values, elements)
{
    if(elements)
    {
        for(var i = 0; i < elements.length; i++)
        {
            var el = elements[i];
            if (el.disabled || !el.type)
                continue;

            switch(el.type.toLowerCase())
            {
                case 'text':
                case 'textarea':
                case 'password':
                case 'hidden':
                case 'select-one':
                    if(el.value.length)
                        values[values.length] = {name : el.name, value : el.value};
                    break;
                case 'radio':
                case 'checkbox':
                    if(el.checked)
                        values[values.length] = {name : el.name, value : el.value};
                    break;
                case 'select-multiple':
                    for (var j = 0; j < el.options.length; j++)
                    {
                        if (el.options[j].selected)
                            values[values.length] = {name : el.name, value : el.options[j].value};
                    }
                    break;
                default:
                    break;
            }
        }
    }
};

JCSmartFilter.prototype.values2post = function (values)
{
    var post = [];
    var current = post;
    var i = 0;

    while(i < values.length)
    {
        var p = values[i].name.indexOf('[');
        if(p == -1)
        {
            current[values[i].name] = values[i].value;
            current = post;
            i++;
        }
        else
        {
            var name = values[i].name.substring(0, p);
            var rest = values[i].name.substring(p+1);
            if(!current[name])
                current[name] = [];

            var pp = rest.indexOf(']');
            if(pp == -1)
            {
                //Error - not balanced brackets
                current = post;
                i++;
            }
            else if(pp == 0)
            {
                //No index specified - so take the next integer
                current = current[name];
                values[i].name = '' + current.length;
            }
            else
            {
                //Now index name becomes and name and we go deeper into the array
                current = current[name];
                values[i].name = rest.substring(0, pp) + rest.substring(pp+1);
            }
        }
    }
    return post;
};

JCSmartFilter.prototype.hideFilterProps = function(element)
{
    var easing;
    var obj = element.parentNode;
    var filterBlock = BX.findChild(obj, {className:"bx_filter_block"}, true, false);

    if(BX.hasClass(obj, "active"))
    {
        easing = new BX.easing({
            duration : 300,
            start : { opacity: 1,  height: filterBlock.offsetHeight },
            finish : { opacity: 0, height:0 },
            transition : BX.easing.transitions.quart,
            step : function(state){
                filterBlock.style.opacity = state.opacity;
                filterBlock.style.height = state.height + "px";
            },
            complete : function() {
                filterBlock.setAttribute("style", "");
                BX.removeClass(obj, "active");
            }
        });
        easing.animate();
    }
    else
    {
        filterBlock.style.display = "block";
        filterBlock.style.opacity = 0;
        filterBlock.style.height = "auto";

        var obj_children_height = filterBlock.offsetHeight;
        filterBlock.style.height = 0;

        easing = new BX.easing({
            duration : 300,
            start : { opacity: 0,  height: 0 },
            finish : { opacity: 1, height: obj_children_height },
            transition : BX.easing.transitions.quart,
            step : function(state){
                filterBlock.style.opacity = state.opacity;
                filterBlock.style.height = state.height + "px";
            },
            complete : function() {
            }
        });
        easing.animate();
        BX.addClass(obj, "active");
    }
};

JCSmartFilter.prototype.showDropDownPopup = function(element, popupId)
{
    var contentNode = element.querySelector('[data-role="dropdownContent"]');
    BX.PopupWindowManager.create("smartFilterDropDown"+popupId, element, {
        autoHide: true,
        offsetLeft: 0,
        offsetTop: 3,
        zIndex: 1060,
        overlay : false,
        draggable: {restrict:true},
        closeByEsc: true,
        content: contentNode
    }).show();
    $('.popup-window').css("z-index", "1070")
};

JCSmartFilter.prototype.selectDropDownItem = function(element, controlId , selector)
{
    this.keyup(BX(controlId));
    $(selector).html($(element).html())
    var wrapContainer = BX.findParent(BX(controlId), {className:"bx_filter_select_container"}, false);

    // Проставляем активность элементам select после ajax
    const allLiOptions = element.parentNode.parentNode.querySelectorAll('li');
    if (allLiOptions.length > 0) {
        allLiOptions.forEach((li) => {
            if (li.classList.contains('selected')) li.classList.remove('selected');
        });
    }
    if (!element.parentNode.classList.contains('selected')) element.parentNode.classList.add('selected');

    var currentOption = wrapContainer.querySelector('[data-role="currentOption"]');
    currentOption.innerHTML = element.innerHTML;
    BX.PopupWindowManager.getCurrentPopup().close();
};

BX.namespace("BX.Iblock.SmartFilter");
BX.Iblock.SmartFilter = (function()
{
    var SmartFilter = function(arParams)
    {
        if (typeof arParams === 'object')
        {
            this.leftSlider = BX(arParams.leftSlider);
            this.rightSlider = BX(arParams.rightSlider);
            this.tracker = BX(arParams.tracker);
            this.trackerWrap = BX(arParams.trackerWrap);

            this.minInput = BX(arParams.minInputId);
            this.maxInput = BX(arParams.maxInputId);

            this.minPrice = parseFloat(arParams.minPrice);
            this.maxPrice = parseFloat(arParams.maxPrice);

            this.curMinPrice = parseFloat(arParams.curMinPrice);
            this.curMaxPrice = parseFloat(arParams.curMaxPrice);

            this.fltMinPrice = arParams.fltMinPrice ? parseFloat(arParams.fltMinPrice) : parseFloat(arParams.curMinPrice);
            this.fltMaxPrice = arParams.fltMaxPrice ? parseFloat(arParams.fltMaxPrice) : parseFloat(arParams.curMaxPrice);

            this.precision = arParams.precision || 0;

            this.priceDiff = this.maxPrice - this.minPrice;

            this.leftPercent = 0;
            this.rightPercent = 0;

            this.fltMinPercent = 0;
            this.fltMaxPercent = 0;

            this.colorUnavailableActive = BX(arParams.colorUnavailableActive);//gray
            this.colorAvailableActive = BX(arParams.colorAvailableActive);//blue
            this.colorAvailableInactive = BX(arParams.colorAvailableInactive);//light blue

            this.isTouch = false;

            this.init();

            if ('ontouchstart' in document.documentElement)
            {
                this.isTouch = true;

                BX.bind(this.leftSlider, "touchstart", BX.proxy(function(event){
                    this.onMoveLeftSlider(event)
                }, this));

                BX.bind(this.rightSlider, "touchstart", BX.proxy(function(event){
                    this.onMoveRightSlider(event)
                }, this));
            }
            else
            {
                BX.bind(this.leftSlider, "mousedown", BX.proxy(function(event){
                    this.onMoveLeftSlider(event)
                }, this));

                BX.bind(this.rightSlider, "mousedown", BX.proxy(function(event){
                    this.onMoveRightSlider(event)
                }, this));
            }

            BX.bind(this.minInput, "keyup", BX.proxy(function(event){
                this.onInputChange();
            }, this));

            BX.bind(this.maxInput, "keyup", BX.proxy(function(event){
                this.onInputChange();
            }, this));
        }
    };

    SmartFilter.prototype.init = function()
    {
        var priceDiff;

        if (this.curMinPrice > this.minPrice)
        {
            priceDiff = this.curMinPrice - this.minPrice;
            this.leftPercent = (priceDiff*100)/this.priceDiff;

            this.leftSlider.style.left = this.leftPercent + "%";
            this.colorUnavailableActive.style.left = this.leftPercent + "%";
        }

        this.setMinFilteredValue(this.fltMinPrice);

        if (this.curMaxPrice < this.maxPrice)
        {
            priceDiff = this.maxPrice - this.curMaxPrice;
            this.rightPercent = (priceDiff*100)/this.priceDiff;

            this.rightSlider.style.right = this.rightPercent + "%";
            this.colorUnavailableActive.style.right = this.rightPercent + "%";
        }

        this.setMaxFilteredValue(this.fltMaxPrice);
    };

    SmartFilter.prototype.setMinFilteredValue = function (fltMinPrice)
    {
        this.fltMinPrice = parseFloat(fltMinPrice);
        if (this.fltMinPrice >= this.minPrice)
        {
            var priceDiff = this.fltMinPrice - this.minPrice;
            this.fltMinPercent = (priceDiff*100)/this.priceDiff;

            if (this.leftPercent > this.fltMinPercent)
                this.colorAvailableActive.style.left = this.leftPercent + "%";
            else
                this.colorAvailableActive.style.left = this.fltMinPercent + "%";

            this.colorAvailableInactive.style.left = this.fltMinPercent + "%";
        }
        else
        {
            this.colorAvailableActive.style.left = "0%";
            this.colorAvailableInactive.style.left = "0%";
        }
    };

    SmartFilter.prototype.setMaxFilteredValue = function (fltMaxPrice)
    {
        this.fltMaxPrice = parseFloat(fltMaxPrice);
        if (this.fltMaxPrice <= this.maxPrice)
        {
            var priceDiff = this.maxPrice - this.fltMaxPrice;
            this.fltMaxPercent = (priceDiff*100)/this.priceDiff;

            if (this.rightPercent > this.fltMaxPercent)
                this.colorAvailableActive.style.right = this.rightPercent + "%";
            else
                this.colorAvailableActive.style.right = this.fltMaxPercent + "%";

            this.colorAvailableInactive.style.right = this.fltMaxPercent + "%";
        }
        else
        {
            this.colorAvailableActive.style.right = "0%";
            this.colorAvailableInactive.style.right = "0%";
        }
    };

    SmartFilter.prototype.getXCoord = function(elem)
    {
        var box = elem.getBoundingClientRect();
        var body = document.body;
        var docElem = document.documentElement;

        var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft;
        var clientLeft = docElem.clientLeft || body.clientLeft || 0;
        var left = box.left + scrollLeft - clientLeft;

        return Math.round(left);
    };

    SmartFilter.prototype.getPageX = function(e)
    {
        e = e || window.event;
        var pageX = null;

        if (this.isTouch && event.targetTouches[0] != null)
        {
            pageX = e.targetTouches[0].pageX;
        }
        else if (e.pageX != null)
        {
            pageX = e.pageX;
        }
        else if (e.clientX != null)
        {
            var html = document.documentElement;
            var body = document.body;

            pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
            pageX -= html.clientLeft || 0;
        }

        return pageX;
    };

    SmartFilter.prototype.recountMinPrice = function()
    {
        var newMinPrice = (this.priceDiff*this.leftPercent)/100;
        newMinPrice = (this.minPrice + newMinPrice).toFixed(this.precision);

        if (newMinPrice != this.minPrice)
            this.minInput.value = newMinPrice;
        else
            this.minInput.value = "";
        smartFilter.keyup(this.minInput);
    };

    SmartFilter.prototype.recountMaxPrice = function()
    {
        var newMaxPrice = (this.priceDiff*this.rightPercent)/100;
        newMaxPrice = (this.maxPrice - newMaxPrice).toFixed(this.precision);

        if (newMaxPrice != this.maxPrice)
            this.maxInput.value = newMaxPrice;
        else
            this.maxInput.value = "";
        smartFilter.keyup(this.maxInput);
    };

    SmartFilter.prototype.onInputChange = function ()
    {
        var priceDiff;
        if (this.minInput.value)
        {
            var leftInputValue = this.minInput.value;
            if (leftInputValue < this.minPrice)
                leftInputValue = this.minPrice;

            if (leftInputValue > this.maxPrice)
                leftInputValue = this.maxPrice;

            priceDiff = leftInputValue - this.minPrice;
            this.leftPercent = (priceDiff*100)/this.priceDiff;

            this.makeLeftSliderMove(false);
        }

        if (this.maxInput.value)
        {
            var rightInputValue = this.maxInput.value;
            if (rightInputValue < this.minPrice)
                rightInputValue = this.minPrice;

            if (rightInputValue > this.maxPrice)
                rightInputValue = this.maxPrice;

            priceDiff = this.maxPrice - rightInputValue;
            this.rightPercent = (priceDiff*100)/this.priceDiff;

            this.makeRightSliderMove(false);
        }
    };

    SmartFilter.prototype.makeLeftSliderMove = function(recountPrice)
    {
        recountPrice = (recountPrice !== false);

        this.leftSlider.style.left = this.leftPercent + "%";
        this.colorUnavailableActive.style.left = this.leftPercent + "%";

        var areBothSlidersMoving = false;
        if (this.leftPercent + this.rightPercent >= 100)
        {
            areBothSlidersMoving = true;
            this.rightPercent = 100 - this.leftPercent;
            this.rightSlider.style.right = this.rightPercent + "%";
            this.colorUnavailableActive.style.right = this.rightPercent + "%";
        }

        if (this.leftPercent >= this.fltMinPercent && this.leftPercent <= (100-this.fltMaxPercent))
        {
            this.colorAvailableActive.style.left = this.leftPercent + "%";
            if (areBothSlidersMoving)
            {
                this.colorAvailableActive.style.right = 100 - this.leftPercent + "%";
            }
        }
        else if(this.leftPercent <= this.fltMinPercent)
        {
            this.colorAvailableActive.style.left = this.fltMinPercent + "%";
            if (areBothSlidersMoving)
            {
                this.colorAvailableActive.style.right = 100 - this.fltMinPercent + "%";
            }
        }
        else if(this.leftPercent >= this.fltMaxPercent)
        {
            this.colorAvailableActive.style.left = 100-this.fltMaxPercent + "%";
            if (areBothSlidersMoving)
            {
                this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
            }
        }

        if (recountPrice)
        {
            this.recountMinPrice();
            if (areBothSlidersMoving)
                this.recountMaxPrice();
        }
    };

    SmartFilter.prototype.countNewLeft = function(event)
    {
        var pageX = this.getPageX(event);

        var trackerXCoord = this.getXCoord(this.trackerWrap);
        var rightEdge = this.trackerWrap.offsetWidth;

        var newLeft = pageX - trackerXCoord;

        if (newLeft < 0)
            newLeft = 0;
        else if (newLeft > rightEdge)
            newLeft = rightEdge;

        return newLeft;
    };

    SmartFilter.prototype.onMoveLeftSlider = function(e)
    {
        if (!this.isTouch)
        {
            this.leftSlider.ondragstart = function() {
                return false;
            };
        }

        if (!this.isTouch)
        {
            document.onmousemove = BX.proxy(function(event) {
                this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
                this.makeLeftSliderMove();
            }, this);

            document.onmouseup = function() {
                document.onmousemove = document.onmouseup = null;
            };
        }
        else
        {
            document.ontouchmove = BX.proxy(function(event) {
                this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
                this.makeLeftSliderMove();
            }, this);

            document.ontouchend = function() {
                document.ontouchmove = document.touchend = null;
            };
        }

        return false;
    };

    SmartFilter.prototype.makeRightSliderMove = function(recountPrice)
    {
        recountPrice = (recountPrice !== false);

        this.rightSlider.style.right = this.rightPercent + "%";
        this.colorUnavailableActive.style.right = this.rightPercent + "%";

        var areBothSlidersMoving = false;
        if (this.leftPercent + this.rightPercent >= 100)
        {
            areBothSlidersMoving = true;
            this.leftPercent = 100 - this.rightPercent;
            this.leftSlider.style.left = this.leftPercent + "%";
            this.colorUnavailableActive.style.left = this.leftPercent + "%";
        }

        if ((100-this.rightPercent) >= this.fltMinPercent && this.rightPercent >= this.fltMaxPercent)
        {
            this.colorAvailableActive.style.right = this.rightPercent + "%";
            if (areBothSlidersMoving)
            {
                this.colorAvailableActive.style.left = 100 - this.rightPercent + "%";
            }
        }
        else if(this.rightPercent <= this.fltMaxPercent)
        {
            this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
            if (areBothSlidersMoving)
            {
                this.colorAvailableActive.style.left = 100 - this.fltMaxPercent + "%";
            }
        }
        else if((100-this.rightPercent) <= this.fltMinPercent)
        {
            this.colorAvailableActive.style.right = 100-this.fltMinPercent + "%";
            if (areBothSlidersMoving)
            {
                this.colorAvailableActive.style.left = this.fltMinPercent + "%";
            }
        }

        if (recountPrice)
        {
            this.recountMaxPrice();
            if (areBothSlidersMoving)
                this.recountMinPrice();
        }
    };

    SmartFilter.prototype.onMoveRightSlider = function(e)
    {
        if (!this.isTouch)
        {
            this.rightSlider.ondragstart = function() {
                return false;
            };
        }

        if (!this.isTouch)
        {
            document.onmousemove = BX.proxy(function(event) {
                this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
                this.makeRightSliderMove();
            }, this);

            document.onmouseup = function() {
                document.onmousemove = document.onmouseup = null;
            };
        }
        else
        {
            document.ontouchmove = BX.proxy(function(event) {
                this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
                this.makeRightSliderMove();
            }, this);

            document.ontouchend = function() {
                document.ontouchmove = document.ontouchend = null;
            };
        }

        return false;
    };

    return SmartFilter;
})();



class RangeSlider {

    constructor(elementId) {
        this.elementId = elementId;
        const element = document.getElementById(this.elementId);
        this.element = element;
        this.init();
    }

    init() {
        const {rangeMin = 0, rangeMax = 100} = this.element.dataset;
        const minInput = document.querySelector(`[data-range-min-connected="${this.elementId}"]`);
        const maxInput = document.querySelector(`[data-range-max-connected="${this.elementId}"]`);

        this.slider = noUiSlider.create(this.element, {
            start: [
                Number(minInput.value),
                Number(maxInput.value)
            ],
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

const FilterCollapseManager = function () {
    this.settings = {
        'cookieName':'stripFilterCollapse',
        'collapseItemsIdAttrSelector':'p.filter-select__collapse-title[data-collapse-id]',
        'collapseAttr':'data-collapse-id',
    }

    this.$startPageCookie = this.getCookie(this.settings.cookieName).length > 0 ?
        JSON.parse(this.getCookie(this.settings.cookieName)) : null;
    this.$collapses = document.querySelectorAll(this.settings.collapseItemsIdAttrSelector);
    this.init();
}

FilterCollapseManager.prototype.init = function () {
    this.collapseManagerEvent();
}

FilterCollapseManager.prototype.setCookie = function (name, value, days) {
    // Установка куки
    let expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";

}

FilterCollapseManager.prototype.getCookie = function (cookieName) {
    const name = cookieName + "=";
    const cookieArray = document.cookie.split(';');
    for(let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}

FilterCollapseManager.prototype.collapseManagerEvent = function () {
    const _this = this;
    if (this.$collapses.length > 0) {
        this.$collapses.forEach((collapse) => {
            const collapseState = collapse.getAttribute('aria-expanded');
            const collapseId = collapse.getAttribute(_this.settings.collapseAttr);

            if (this.$startPageCookie) {
                const indexCollapse = this.$startPageCookie.indexOf(collapseId)
                if (indexCollapse !== -1) {
                    collapse.classList.add('collapsed');
                    collapse.parentNode.querySelector('div.collapse.show').classList.remove('show');
                }
            }

            collapse.onclick = () => {
                const stripFilterCollapse = this.getCookie(this.settings.cookieName);
                if (stripFilterCollapse.length > 0) {
                    let data = JSON.parse(stripFilterCollapse);
                    const index = data.indexOf(collapseId);

                    if (collapseState === 'true' && index === -1) {
                        data.push(collapseId);
                    } else {
                        if (index > -1) {
                            data.splice(index, 1);
                        }
                    }
                    console.log(data);
                    _this.setCookie(_this.settings.cookieName, JSON.stringify(data), 60);
                } else {
                    let data = [];

                    if (collapseState === 'true') data.push(collapseId);
                    console.log(data);
                    _this.setCookie(_this.settings.cookieName, JSON.stringify(data), 60);
                }
            }
        });
    }
}


document.addEventListener('DOMContentLoaded', () => {
    new FilterCollapseManager();
    new RangeSlider('rangeSlider');
    new RangeSlider('rangeSliderMainFilterMobile');
});