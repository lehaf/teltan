document.addEventListener('DOMContentLoaded', () => {
    $('.similar-products-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 4,
        prevArrow: '<div class="prev"><img src="/local/templates/teltan/assets/vip-item-arrow.svg" alt="prev"></div>',
        nextArrow: '<div class="next"><img src="/local/templates/teltan/assets/vip-item-arrow.svg" alt="next"></div>',
        responsive: [
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: false,
                }
            }, {
                breakpoint: 540,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: false,
                }
            }]
    });
});