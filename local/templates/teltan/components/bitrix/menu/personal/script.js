const PersonalMenu = function () {
    this.settings = {
        'messageCounterSelector':'div.counter-user-message > span#count_user_messages',
    }

    this.$counterSelector = document.querySelector(this.settings.messageCounterSelector);

    this.getUserMessages();
}

PersonalMenu.prototype.setUserMessages = function (countMessages) {
    if (this.$counterSelector) {
        this.$counterSelector.innerHTML = '+'+countMessages;
        if (this.$counterSelector.parentNode.classList.contains('hide'))
            this.$counterSelector.parentNode.classList.remove('hide');
    }
}

PersonalMenu.prototype.getUserMessages = function () {
    const _this = this;
    fetch('/ajax/user_messages.php', {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    }).then((response) => response.json())
    .then((countMessages) => {
        if (countMessages > 0) {
            _this.setUserMessages(countMessages);
        }
    }).catch((error) => {
        console.log(error);
    });
}

addEventListener('DOMContentLoaded',() => {
    new PersonalMenu();
});