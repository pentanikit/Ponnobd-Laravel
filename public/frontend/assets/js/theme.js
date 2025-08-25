$(document).ready(function() {

    $("a").on('click', function(event) {

        if (this.hash !== "") {

            event.preventDefault();
            var hash = this.hash;

            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function() {
                window.location.hash = hash;
            });
        }
    });
});
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:35,
    responsiveClass:true,
    responsive:{
        0:{
            items:3,
            nav:true
        },
        600:{
            items:4,
            nav:true
        },
        1000:{
            items:7,
            nav:true,
            loop:false
        }
    }
})

$( document ).ready(function () {
    $(".moreBox").slice(0, 8).show();
      if ($(".blogBox:hidden").length != 0) {
        $("#loadmore").show();
      }
      $("#loadmore").on('click', function (e) {
        e.preventDefault();
        $(".moreBox:hidden").slice(0, 4).slideDown();
        if ($(".moreBox:hidden").length == 0) {
          $("#loadmore").fadeOut('slow');
        }
      });
});
