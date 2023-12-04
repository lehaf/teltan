const SortPanel = function () {
    this.settings = {
        'switcherViewSelector':'button.products-sort__button',
        'switcherSortSelector':'.menu-sort > .sort-item',
        'elementsGetSelector':'#target_container',
        'elementsPutSelector':'#target_container',
        'viewTypeAttr':'data-view',
        'sortTypeAttr':'data-sort',
    }

    this.$loader = document.querySelector('div.preloader');
    this.init();
}

SortPanel.prototype.init = function () {
    this.$allViews = document.querySelectorAll(this.settings.switcherViewSelector);
    this.$allSorts = document.querySelectorAll(this.settings.switcherSortSelector);

    this.setEventListener();
}

SortPanel.prototype.setEventListener = function () {
    const _this = this;

    if (this.$allViews) {
        this.$allViews.forEach((switcherBtn) => {
            switcherBtn.onclick = (e) => {
                e.preventDefault();
                if (!switcherBtn.classList.contains('active')) {
                    let typeOfView = switcherBtn.getAttribute(this.settings.viewTypeAttr);
                    _this.setActiveView(this.$allViews, switcherBtn, this.settings.viewTypeAttr);
                    _this.showLoader();
                    _this.sendData({'isAjax': 'y', 'typeOfView': typeOfView});
                }
            }
        });
    }

    if (this.$allSorts) {
        this.$allSorts.forEach((sortBtn) => {
            sortBtn.onclick = (e) => {
                e.preventDefault();
                if (!sortBtn.classList.contains('active')) {
                    let sortNumber = sortBtn.getAttribute(this.settings.sortTypeAttr);
                    _this.setActiveView(this.$allSorts, sortBtn, this.settings.sortTypeAttr);
                    document.querySelector('#sort-text').innerHTML = sortBtn.innerHTML;
                    _this.showLoader();
                    _this.sendData({'isAjax': 'y', 'sortNumber': sortNumber});
                }
            }
        });
    }
}

SortPanel.prototype.setActiveView = function (allElements, activeElement, attributeCompare) {
    activeElement.classList.add('active');
    const activeElementType = activeElement.getAttribute(attributeCompare);

    if (allElements) {
        allElements.forEach((el) => {
            const type = el.getAttribute(attributeCompare);
            if (activeElementType !== type && el.classList.contains('active')) el.classList.remove('active');
        });
    }
}

SortPanel.prototype.showLoader = function () {
    if (this.$loader) {
        this.$loader.classList.add('active');
    }
}

SortPanel.prototype.hideLoader = function () {
    if (this.$loader) {
        this.$loader.classList.remove('active');
    }
}

SortPanel.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

SortPanel.prototype.sendData = function (typeOfView) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(typeOfView)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        let response = _this.getDomElementsFromString(text);
        console.log(response);
        let newData = response.querySelector(_this.settings.elementsGetSelector);
        let curContainer = document.querySelector(_this.settings.elementsPutSelector);
        curContainer.innerHTML = newData.innerHTML;
        _this.hideLoader();
        // reinit sortpanel
        _this.init();
        // reinit lazy-load
        if (window.ImageDefer) window.ImageDefer.init();
        // reinit map
        if (document.querySelector('div#map')) window.mapInit()
    }).catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new SortPanel();
});