$(document).ready(function () {

    $('.icon-sirting_block').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/catalog_ajax.php",
            data: {view: "block"}
        }).done(function (msg) {
            window.location.reload();
        });
    });

    $('.icon-sirting_line').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/catalog_ajax.php",
            data: {view: "list"}
        }).done(function (msg) {
            window.location.reload();
        });

    });
})