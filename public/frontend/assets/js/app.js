function adjustTableWidth() {
    if ($(window).width() <= 595) {

        $('.detailcontent table').css('width', '200px');

        $('.detailcontent table').removeAttr('width');

        $('.detailcontent table thead tr td').removeAttr('width');
        $('.detailcontent table tbody tr td').removeAttr('width');
        $('.detailcontent table tbody tr td').removeAttr('colspan');
        $('.detailcontent table thead tr td').removeAttr('colspan');
    }
}


adjustTableWidth();


$(window).resize(function () {
    adjustTableWidth();
});





function showAlert(e, i) {
    Swal.mixin({
        toast: !0,
        position: "top",
        showConfirmButton: !1,
        timer: 3e3,
        timerProgressBar: !0,
        didOpen: e => {
            e.addEventListener("mouseenter", Swal.stopTimer), e.addEventListener("mouseleave", Swal.resumeTimer)
        }
    }).fire({
        icon: e,
        title: i
    })
}

function setThumbnail(e) {
    $(".imgwrp img").attr("src", $(e).attr("src"))
}
window.addEventListener("livewire:navigated", (() => {
    window.scrollTo({
        top: 0
    })
})), Livewire.on("alert", (e => {
    showAlert(e[0].type, e[0].message)
})), $("#create-account").on("click", (function () {
    $(this).is(":checked") ? $(".password-field").show() : $(".password-field").hide()
})), $("#different_address_check").on("click", (function () {
    $(this).is(":checked") ? $(".different-address").show() : $(".different-address").hide()
})), $(".product-rating").starRating({
    starSize: 1.5,
    showInfo: !0
}), $(".main-menu").superfish();









$(document).ready(function () {

    $(".detailcontent td").each(function () {

        if ($(this).html().includes("&nbsp;")) {

            $(this).remove();
        }
    });
});