/* Main Js Start */

(function ($) {
  "use strict";

  $(document).ready(function () {

    // odometer init
    if ($(".odometer").length) {
      var odo = $(".odometer");
      odo.each(function () {
        $(this).appear(function () {
          var countNumber = $(this).attr("data-count");
          $(this).html(countNumber);
        });
      });
    }

    // sidebar dropdown
    $(".has-dropdown > a").click(function (e) {
      e.preventDefault();
      var $submenu = $(this).next(".sidebar-submenu");
      var $parent = $(this).parent();
      if ($submenu.css("display") === "block") {
        $submenu.slideUp(200);
        $parent.removeClass("active");
      } else {
        $(".sidebar-submenu").not($submenu).slideUp(200);
        $(".has-dropdown.active").removeClass("active");
        $parent.addClass("active");
        $submenu.slideDown(200);
      }
    });


    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass('show-sidebar');
      $(".sidebar-overlay").addClass('show');
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass('show-sidebar');
      $(".sidebar-overlay").removeClass('show');
    });

    $(".counterup-item").each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
            var el = document.querySelectorAll('.odometer')[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });


    $(".add").on("click", function () {
      if ($(this).prev().val() < 999) {
        $(this)
          .prev()
          .val(+$(this).prev().val() + 1);
      }
    });

    $(".sub").on("click", function () {
      if ($(this).next().val() > 1) {
        if ($(this).next().val() > 1)
          $(this)
            .next()
            .val(+$(this).next().val() - 1);
      }
    });



  });



  // sticky header
  $(window).on('scroll', function () {
    if ($(window).scrollTop() >= 60) {
      $('.header').addClass('fixed-header');
    }
    else {
      $('.header').removeClass('fixed-header');
    }
  });


  var btn = $('.scroll-top');

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, '300');
  });



  $('.sidebar-overlay, .close-hide-show').on('click', function () {
    $('.sidebar-menu-wrapper').removeClass('show');
    $(".sidebar-overlay").removeClass('show');
  });
  
  // Add class to product description table for dynamic content
  $('.product-description table').addClass('table table-striped table-bordered');



  // tap to top with progress

  if ($('.scroll-top').length > 0) {
    var $scrollTopBtn = $('.scroll-top');
    var $progressPath = $('.scroll-top path');
    var pathLength = $progressPath[0].getTotalLength();

    $progressPath.css({
      transition: 'none',
      strokeDasharray: pathLength + ' ' + pathLength,
      strokeDashoffset: pathLength,
    });

    $progressPath[0].getBoundingClientRect();
    $progressPath.css({
      transition: 'stroke-dashoffset 10ms linear'
    });

    var updateProgress = function () {
      var scroll = $(window).scrollTop();
      var height = $(document).height() - $(window).height();
      var progress = pathLength - (scroll * pathLength / height);
      $progressPath.css('strokeDashoffset', progress);
    };

    updateProgress();

    $(window).on('scroll', updateProgress);

    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 50) {
        $scrollTopBtn.addClass('show');
      } else {
        $scrollTopBtn.removeClass('show');
      }
    });

    $scrollTopBtn.on('click', function (event) {
      event.preventDefault();
      $('html, body').animate({ scrollTop: 0 }, 800);
      return false;
    });
  }



// slick
  $('.banner-slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 1500,
    responsive: [
      {
        breakpoint: 1100,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },

      {
        breakpoint: 780,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });





  // wow init
  new WOW().init();




  // for accordion
  $(document).ready(function () {

    function applyExpandedClassOnLoad() {
      $('#accordionFlushExample .accordion-item').each(function () {
        var $accordionItem = $(this);
        var $button = $accordionItem.find('.accordion-button');
        if ($button.attr('aria-expanded') === 'true') {
          $accordionItem.addClass('active');
        }
      });
    }

    applyExpandedClassOnLoad();

    $('#accordionFlushExample').on('shown.bs.collapse', function (e) {
      var $accordionItem = $(e.target).closest('.accordion-item');
      $accordionItem.addClass('active');
    });

    $('#accordionFlushExample').on('hidden.bs.collapse', function (e) {
      var $accordionItem = $(e.target).closest('.accordion-item');
      $accordionItem.removeClass('active');
    });
  });


// spliting js
  Splitting();


  // Toggle search
  $('.search-toggle--btn').click(function () {
    $('.search--form').toggleClass('search-form--active');
    $('.logo-wrapper').toggleClass('d-none');
  });

  function checkScreenSize() {
    if ($(window).width() > 530) {
      $('.search--form').removeClass('search-form--active');
      $('.logo-wrapper').removeClass('d-none');
    }
  }


  checkScreenSize();


  $(window).resize(function () {
    checkScreenSize();
  });

 
  // cart box
   $('.container .col-xxl-3.col-xl-4.col-lg-4.col-md-6.col-sm-6').addClass('col-6');
   
  $('.cart--btn,.request-link').on('click', function () {
    $('.cart-box').addClass('show-cart-box');
    $('.sidebar-overlay').addClass('show');
  });

  $('.close--btn, .sidebar-overlay').on('click', function () {
    $('.cart-box').removeClass('show-cart-box');
    $('.sidebar-overlay').removeClass('show');
  });


  // filter box
  $('.filter--btn').on('click', function () {
    $('.filter--box').addClass('show-cart-box');
    $('.sidebar-overlay').addClass('show');
  });

  $('.close--btn, .sidebar-overlay').on('click', function () {
    $('.filter--box').removeClass('show-cart-box');
    $('.sidebar-overlay').removeClass('show');
  });



  // note,coupon box
  $('.note--btn').on('click', function () {
    $('.note--box').addClass('show-note--box');
  });

  $('.coupon--btn').on('click', function () {
    $('.coupon--box').addClass('show-note--box');
  });

  $('.cancel--btn').on('click', function () {
    $('.note--box,.coupon--box').removeClass('show-note--box');
  });



  $('.sub-menu').hide();

  $('.menu-item').hover(
    function () {
      const itemId = $(this).attr('id');
      $(`#sub-menu-${itemId}`).stop(true, true).slideDown(300);
    },
    function () {
      $('.sub-menu').stop(true, true).slideUp(300);
    }
  );


  $('.sub-menu-item').hover(
    function () {
      const itemId = $(this).attr('id');
      $(`#inner-menu-${itemId}`).stop(true, true).slideDown(300);
    },
    function () {
      $('.inner-menu').stop(true, true).slideUp(300);
    }
  );

  $('.sub-menu').hover(
    function () {
      $(this).stop(true, true).show();
    },
    function () {
      $(this).stop(true, true).slideUp(300);
    }
  );


  $('.inner-menu').hover(
    function () {
      $(this).stop(true, true).show();
    },
    function () {
      $(this).stop(true, true).slideUp(300);
    }
  );




  $('.filter-group').on('click', function () {
    $(this).toggleClass('show');
  });



// new add 
$('.sub-menu-item').hover(
  function() {
    $('.sub-menu-item').removeClass('active'); 
    $(this).addClass('active');
  }
);


var observer = new MutationObserver(function(mutations) {
  mutations.forEach(function(mutation) {
    if ($(mutation.target).css('display') === 'none') {
      $('.sub-menu-item').removeClass('active'); 
    }
  });
});


observer.observe(document.getElementById('sub-menu-v-pills-menu-tab'), {
  attributes: true,
  attributeFilter: ['style']
});

observer.observe(document.getElementById('sub-menu-v-pills-menu-tab2'), {
  attributes: true,
  attributeFilter: ['style']
});
observer.observe(document.getElementById('sub-menu-v-pills-menu-tab3'), {
  attributes: true,
  attributeFilter: ['style']
});
observer.observe(document.getElementById('sub-menu-v-pills-menu-tab4'), {
  attributes: true,
  attributeFilter: ['style']
});
observer.observe(document.getElementById('sub-menu-v-pills-menu-tab5'), {
  attributes: true,
  attributeFilter: ['style']
});
observer.observe(document.getElementById('sub-menu-v-pills-menu-tab6'), {
  attributes: true,
  attributeFilter: ['style']
});
// new add 

})(jQuery);




// rang slider
const rangeInput = document.querySelectorAll(".range-input input");
priceInput = document.querySelectorAll(".price-input input");

progress = document.querySelector(".sliderr .progresss");

let priceGap = 100;


rangeInput.forEach(input => {
  input.addEventListener("input", e => {
    let minValue = parseInt(rangeInput[0].value)
    maxValue = parseInt(rangeInput[1].value)

    if (maxValue - minValue < priceGap) {
      if (e.target.className === "range-min") {
        rangeInput[0].value = maxValue - priceGap;
      } else {
        rangeInput[1].value = minValue + priceGap;
      }

    } else {
      priceInput[0].value = minValue;
      priceInput[1].value = maxValue;

      progress.style.left = (minValue / rangeInput[0].max) * 100 + "%";
      progress.style.right = 100 - (maxValue / rangeInput[1].max) * 100 + "%";
    }



    let percent = (minValue / rangeInput[0].max) * 100;
    console.log(percent)
  })
})

var mzOptions = {
  zoomWidth: '400',
  zoomHeight: '250'
};