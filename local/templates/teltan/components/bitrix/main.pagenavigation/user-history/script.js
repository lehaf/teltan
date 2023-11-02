// const Pagination = function () {
//     this.settings = {
//         'paginationLinkSelector':'div.history-pagenavigation nav a',
//         'paginationArrowRightClass':'div.history-pagenavigation nav a.next',
//         'paginationArrowLeftClass':'div.history-pagenavigation nav a.prev',
//         'elementsClass':'.purchase-history',
//         'elementsContainerClass':'.purchase-history',
//     }
//
//     // this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
//     this.init();
// }
//
// Pagination.prototype.init = function () {
//     this.setEventListener();
// }
//
// Pagination.prototype.setEventListener = function () {
//     const _this = this;
//     this.$arAllPaginationLinks = document.querySelectorAll(this.settings.paginationLinkSelector);
//
//     if (this.$arAllPaginationLinks.length > 0) {
//         this.$arAllPaginationLinks.forEach((paginationLink) => {
//             paginationLink.onclick = (e) => {
//                 e.preventDefault();
//                 if (!paginationLink.parentNode.classList.contains('active')) {
//                     let requestLink = paginationLink.getAttribute('href');
//                     // _this.setLoader();
//                     _this.sendData(requestLink,{'isAjax': 'Y',});
//                 }
//             }
//         });
//     }
// }
//
// Pagination.prototype.setLoader = function () {
//     this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
//     if (this.$loader && this.$loaderContainer && this.$blurContainer) {
//         this.$blurContainer.classList.add(this.settings.blurClass);
//         this.$loaderContainer.prepend(this.$loader);
//     }
// }
//
// Pagination.prototype.deleteLoader = function () {
//     this.$blurContainer.classList.remove(this.settings.blurClass);
//     document.querySelector('.'+this.settings.loaderClassName).remove();
// }
//
// Pagination.prototype.getDomElementsFromString = function (string) {
//     let obDomParser = new DOMParser();
//     return obDomParser.parseFromString(string, "text/html");
// }
//
// Pagination.prototype.sendData = function (link,data) {
//     const _this = this;
//     fetch(link, {
//         method: 'POST',
//         cache: 'no-cache',
//         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
//         body: new URLSearchParams(data)
//     }).then(function(response) {
//         return response.text()
//     }).then(function(text) {
//         let response = _this.getDomElementsFromString(text);
//         let nextElementsContainer = response.querySelector(_this.settings.elementsContainerClass);
//         let curContainer = document.querySelector(_this.settings.elementsContainerClass);
//         setTimeout(() => {
//             _this.deleteLoader();
//             curContainer.innerHTML = nextElementsContainer.innerHTML;
//             _this.setEventListener();
//             window.FavoriteManager.init();
//         },300);
//
//         window.history.replaceState(null, null, link);
//
//     }).catch(error => {
//         console.log(error);
//     });
// }
//
//
// addEventListener('DOMContentLoaded',() => {
//     new Pagination();
// });