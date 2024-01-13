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
    this.setEventTabs();
    this.setEventPagination();
}

UserAdsManager.prototype.setEventTabs = function () {
    const _this = this;

    if (this.$typeBtns.length > 0) {
        this.$typeBtns.forEach((typeBtn) => {
            typeBtn.onclick = () => {
                document.querySelector('.status-announcement div.form_radio_btn.active').classList.remove('active');
                typeBtn.classList.add('active');
                const type = typeBtn.getAttribute('data-active');
                _this.showLoader();
                _this.sendData({'isAjax': 'y', 'active': type}, location.pathname);
            }
        });
    }
}

UserAdsManager.prototype.setEventPagination = function () {
    const _this = this;
    this.$paginationLinks = document.querySelectorAll('nav a');

    if (this.$paginationLinks.length > 0) {
        this.$paginationLinks.forEach((link) => {
            link.onclick = (e) => {
                e.preventDefault();
                _this.showLoader();
                const type = document.querySelector('.status-announcement div.form_radio_btn.active').getAttribute('data-active');
                _this.sendData({'isAjax': 'y', 'active': type}, link.getAttribute('href'));
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

UserAdsManager.prototype.sendData = function (data, link = location.href) {
    const _this = this;
    fetch(link, {
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
        _this.setEventPagination();
        _this.hideLoader();

        window.history.replaceState(null, null, link);

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
