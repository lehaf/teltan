const UserAdsManager = function () {
    this.settings = {
        'elementsGetSelector': '#user_ads',
        'elementsPutSelector': '#user_ads',
    }

    this.$loader = document.querySelector('div.preloader');
    this.$typeBtns = document.querySelectorAll('.status-announcement div.form_radio_btn');
    this.init();
}

UserAdsManager.prototype.init = function () {
    this.setEventListener();
}

UserAdsManager.prototype.setEventListener = function () {
    const _this = this;

    if (this.$typeBtns) {
        this.$typeBtns.forEach((typeBtn) => {
            typeBtn.onclick = () => {
                document.querySelector('.status-announcement div.form_radio_btn.active').classList.remove('active');
                typeBtn.classList.add('active');
                const type = typeBtn.getAttribute('data-active');
                _this.showLoader();
                _this.sendData({'isAjax': 'y', 'active': type});
            }
        });
    }
}

UserAdsManager.prototype.showLoader = function () {
    if (this.$loader) {
        this.$loader.style.position = 'fixed';
        this.$loader.style.opacity = '1';
        this.$loader.style.zIndex = '100';
    }
}

UserAdsManager.prototype.hideLoader = function () {
    if (this.$loader) {
        this.$loader.removeAttribute('style');
    }
}

UserAdsManager.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

UserAdsManager.prototype.sendData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        let response = _this.getDomElementsFromString(text);
        let newData = response.querySelector(_this.settings.elementsGetSelector);
        let curContainer = document.querySelector(_this.settings.elementsPutSelector);
        if (data.active === 'N') {
            document.querySelector('#user_ads').classList.add('inactive');
        } else {
            document.querySelector('#user_ads').classList.remove('inactive');
        }
        curContainer.innerHTML = newData.innerHTML;
        _this.hideLoader();
        // reinit lazy-load
        if (window.ImageDefer) window.ImageDefer.init();
        // reinit button edit
        if (window.EditBtn) window.EditBtn.init();
        // reinit button boost
        if (window.BoostBtn) window.BoostBtn.init();
    }).catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded', () => {
    new UserAdsManager();
});
