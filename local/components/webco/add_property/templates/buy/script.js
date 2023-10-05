const AdditionalProps = function () {
    this.settings = {
        'mainSectionsSelector' : '.step-one input[name="type"]',
        'dataSectionId' : 'data-section-id',
        'dataParentSectionId' : 'data-type-section-id',
        'dataIblockId' : 'data-iblock-id',
        'wizardSelector' : 'div#wizard',
        'addFieldsContainer' : 'div[data-wizard-content="2"] div.step-three',
        'addFieldsContainerH1' : 'div[data-wizard-content="2"] div.step-three h3',
    };

    this.$sections = document.querySelectorAll(this.settings.mainSectionsSelector);
    this.$iblockId = document.querySelector(this.settings.wizardSelector).getAttribute(this.settings.dataIblockId);
    this.$contaner = document.querySelector(this.settings.addFieldsContainer);
    this.$elementAfter = document.querySelector(this.settings.addFieldsContainerH1);

    this.init();
}

AdditionalProps.prototype.init = function() {
    this.setSectionsEvent();
}

AdditionalProps.prototype.getParams = function() {
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

AdditionalProps.prototype.setSectionsEvent = function() {
    const _this = this;
    if (this.$sections) {
        this.$sections.forEach((inputSection) => {
            inputSection.onclick = () => {
                let sectionId = inputSection.getAttribute(_this.settings.dataSectionId);
                let parentSectionId = inputSection.getAttribute(_this.settings.dataParentSectionId);
                let data = {
                    'iblockId':_this.$iblockId,
                    'sectionId':sectionId,
                    'parentSectionId':parentSectionId,
                    'get_fields':'y'
                };

                let getParams = _this.getParams();
                if (getParams['EDIT'] === 'Y' && getParams['ID']) {
                    data['edit'] = 'y';
                    data['itemId'] = getParams['ID'];
                }
                _this.sendData(data);
            }
        });
    }
}

AdditionalProps.prototype.sendData = function (data) {
    const _this = this;
    fetch('/ajax/add_fields.php', {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With':'XMLHttpRequest',
        },
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        let existAddFields = _this.$contaner.querySelectorAll('.additional-prop');
        if (existAddFields.length > 0) existAddFields.remove();

        if (text) {
            let addProps = new DOMParser().parseFromString(text, "text/html")
                .querySelectorAll('.additional-prop');
            addProps.forEach((field) => {
                _this.$contaner.insertBefore(field, _this.$elementAfter.nextSibling);
            });
        }
    }).catch(error => {
        console.log(error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    new AdditionalProps();
});