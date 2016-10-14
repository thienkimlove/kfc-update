(function($){
  var statusSearch = 0;
  $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
  var timeSearch = null;
  var delaySearch = 5000;

  var setMenuMobile = function(){
    $("#btn-menu").on("click",function(){
      if($("body").hasClass("show-menu")){
        closeMenuMobile();
      }else{
        $("body").addClass("show-menu");
        var height_device = $(window).height();
//                var width_device = $(window).width();
var padding_menu = 30;
               /* if(width_device < 640){
                    padding_menu = 45;
                  }*/
                  var height_menu = $("#menu-left .inner").height() + padding_menu;
                /*if(height_menu <= height_device){
                    height_menu = height_device;
                  }*/
                  $("#wrapper").css({height: height_menu});
                  $("#overlay").css({display: "block"});
                }
              });
  };

  var resetMenuMobile = function(){
    $("#overlay").on("click",function(){
      closeMenuMobile();
    });
  };
  var closeMenuMobile = function(){
    $("body").removeClass("show-menu");
    $("#wrapper").removeAttr("style");
    $("#overlay").css({display: "none"});
  };

  var checkSearch = function(){
    if(statusSearch == 0){
      window.clearTimeout(timeSearch);
      timeSearch = window.setTimeout(function(){
        $("#box-find").stop().animate({width: 210});
      },0);
    }else{
      window.clearTimeout(timeSearch);
      timeSearch = window.setTimeout(function(){
        $("#box-find").stop().animate({width: 30});
      },delaySearch);
    }
  };

  var changeSearch = function(){
    $("#box-find").hover(function(){
      checkSearch();
      statusSearch = 1;
    },function(){
      checkSearch();
      statusSearch = 0;
    });
  };

  var slideHomepage = function(){
    $('#slide-homepage').owlCarousel({
      loop:true,
      margin:0,
      autoplay: true,
      autoplayTimeout: 5000,
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:true,
          dots: false
        },
        640:{
          items:1,
          nav:true,
          dots: false
        },
        1000:{
          items:1,
          nav:true,
          loop:true,
          dots: true
        }
      }
    });
  };

  var slideCompany = function(){
    $('#slide-company').owlCarousel({
      loop:true,
      margin:20,
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:true,
          dots: false
        },
        640:{
          items:2,
          nav:true,
          dots: false
        },
        1000:{
          items:4,
          nav:true,
          loop:true,
          dots: false
        }
      }
    });
  };

  var slideLink = function(){
    $('#slide-link').owlCarousel({
      loop:true,
      margin:20,
      responsiveClass:true,
      responsive:{
        0:{
          items:2,
          nav:false,
          dots: false
        },
        640:{
          items:4,
          nav:false,
          dots: false
        },
        1000:{
          items:6,
          nav:false,
          loop:true,
          dots: false
        }
      }
    });
  };

  var slideProduct = function(){
    $('#slide-product').owlCarousel({
      loop:true,
      margin:20,
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:true,
          dots: false
        },
        640:{
          items:2,
          nav:true,
          dots: false
        },
        1000:{
          items:4,
          nav:true,
          loop:true,
          dots: false
        }
      }
    });
  };

  var slidePartner = function(){
    $('#slide-partner').owlCarousel({
      loop:true,
      margin:20,
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:false,
          dots: false
        },
        640:{
          items:2,
          nav:false,
          dots: false
        },
        1000:{
          items:4,
          nav:false,
          loop:false,
          dots: false
        }
      }
    });
  };

  var slideProject = function(){
    $('#slide-project').owlCarousel({
      loop:true,
      margin:30,
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:false
        },
        640:{
          items:2,
          nav:false
        },
        1000:{
          items:3,
          nav:false,
          loop:true
        }
      }
    });
  };

  var equalHeight = function(selector) {
    minheight = 0;
    $(selector).each(function() {
      thisheight = $(this).height();
      if (thisheight > minheight) {
        minheight = thisheight
      }
    });
    minheight = minheight + 2;
    $(selector).css("min-height", minheight)
  };

  var tabContent = function(){
    $("a[data-type='tab']").on('click',function(e){
      e.preventDefault();
      var parent = $(this).data('parent');
      var content = $(this).data('content');
      var reset = $(this).data('reset');
      $("." + parent + " li").removeClass('active');
      $(this).parent("li").addClass('active');
      $("."+reset).css({display:"none"});
      $("#"+content).css({display:"block"});
    });
  };
    //popup
    // bind our function to the tabs
    $('#tabs-nav ul li a').click(function(e){
      // remove the active state from all links
      $('#tabs-nav ul li a').removeClass("active");
      // add the active state to the clicked link
      $(this).addClass("active");
      // fade out the current container
      $('.profile').fadeOut(600, function(){
        // fade in the clicked container
        $('#' + profileID).fadeIn(600);
      });
      // define our current profile variable
      var profileID = $(this).attr("data-id");
    });
    //----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
      var targeted_popup_class = jQuery(this).attr('data-popup-open');
      $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
      
      e.preventDefault();
    });
    
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
      var targeted_popup_class = jQuery(this).attr('data-popup-close');
      $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
      
      e.preventDefault();
    });
    //end
    
    jQuery(document).ready(function() {
      changeSearch();
      slideCompany();
      slideHomepage();
      slideProduct();
      slideProject();
      slideLink();
      slidePartner();
      tabContent();
      equalHeight(".box-member .data .item");
      setMenuMobile();
      resetMenuMobile();
    });
  })(jQuery);

