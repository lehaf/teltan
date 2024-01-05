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

document.addEventListener('DOMContentLoaded', () => (
    new Wizard({}, () => {})
));
