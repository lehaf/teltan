const EditBtn = function () {
    this.init();
}

EditBtn.prototype.init = function () {
    this.$alertBtns = document.querySelectorAll('button.alert-confirmation-btn');
    this.$deleteBtns = document.querySelectorAll('button.delete-item-btn');
    this.$editBtns = document.querySelectorAll('button.item-edit-btn');
    this.$activateItemToggles = document.querySelectorAll('label.activate-item-toggle');

    this.setEventListener();
}

EditBtn.prototype.setEventListener = function () {
    // Открытие кнопки редактирования
    if (this.$editBtns.length > 0) {
        this.$editBtns.forEach((btn) => {
            btn.onclick = () => {
                const list =  btn.parentNode.querySelector('ul.edit-item-menu_item');

                if (list) {
                    let listClasses = list.classList;

                    if (listClasses.contains('active')) {
                        listClasses.remove('active');
                    } else {
                        listClasses.add('active');
                    }
                }
            }
        });
    }

    // Всплывашки
    if (this.$alertBtns.length > 0) {
        this.$alertBtns.forEach((btn) => {
            btn.onclick = () => {
                const adId = btn.getAttribute('data-ad-id');
                const dropdown = document.querySelector('div#alert-confirmationIdView'+adId);
                if (dropdown) {
                    let dropdownClasses = dropdown.classList;

                    if (dropdownClasses.contains('show')) {
                        dropdownClasses.remove('show');
                    } else {
                        dropdownClasses.add('show');
                    }
                }
            }
        });
    }

    // Удаление
    if (this.$deleteBtns.length > 0) {
        this.$deleteBtns.forEach((btn) => {
            const itemId = btn.getAttribute('data-item');
            btn.onclick = () => {
                $.ajax({
                    url: '/ajax/del_item.php',
                    method: 'post',
                    async: false,
                    data: {itemId:itemId},
                    success: function (data) {
                        window.location.reload();
                    }
                });
            }
        });
    }

    // Активация / Деактивация
    if (this.$activateItemToggles.length > 0) {
        this.$activateItemToggles.forEach((toggle) => {
            toggle.onclick = () => {
                let toggleColor = '';
                const itemId = toggle.getAttribute('data-item-id');
                const iblockId = toggle.getAttribute('data-iblock-id');
                const toggleInput = document.querySelector('input#activateItem'+itemId);

                if (toggleInput.checked) {
                    toggleColor = 'green';
                } else {
                    toggleColor = 'red';
                }

                $.ajax({
                    url: '/ajax/active_item.php',
                    method: 'post',
                    async: false,
                    data: {
                        itemId: itemId,
                        iblockId: iblockId,
                        value: toggleColor
                    },
                    success: function (data) {
                        $('.allert__text').html(data);
                        $('.del_all_in_chat').html('ok');
                        $('.alert-confirmation').addClass('show');
                    }
                });
            }
        });
    }
}


document.addEventListener('DOMContentLoaded', () => {
    window.EditBtn = new EditBtn();
});