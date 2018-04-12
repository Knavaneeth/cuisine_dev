
$(document).ready(function(){
	// Sticky Blocks
	var toffset = $(".site-header-wrapper").height() + 70;
	var soffset = $(".site-header-wrapper").height() + 89;
	var goffset = $(".site-header-wrapper").height() + 19;
	var boffset = $(".site-footer").height() + 90;
	if($(window).width() > 767 ){
	if($(".tsticky").length >0 )
		$(".tsticky").sticky({topSpacing:toffset});
		//$(".tbsticky").sticky({topSpacing:soffset, bottomSpacing: boffset});
		//$(".tbssticky").sticky({topSpacing:goffset, bottomSpacing: boffset});
	}
	
	$('.dropdown-toggle.selectpicker').on("click",function(e){
		$('.bootstrap-select .dropdown-menu').css("visibility", "visible");
		e.preventDefault;
	});
});

function testTheiaStickySidebars() {
    var me = {};
    me.scrollTopStep = 1;
    me.currentScrollTop = 0;
    me.values = null;

    window.scrollTo(0, 1);
    window.scrollTo(0, 0);

    $(window).scroll(function(me) {
        return function(event) {
            var newValues = [];
            
            // Get sidebar offsets.
            $('.theiaStickySidebar').each(function() {
                newValues.push($(this).offset().top);
            });
            
            if (me.values != null) {
                var ok = true;
                
                for (var j = 0; j < newValues.length; j++) {
                    var diff = Math.abs(newValues[j] - me.values[j]);
                    if (diff > 1) {
                        ok = false;
                        
                        console.log('Offset difference for sidebar #' + (j + 1) + ' is ' + diff + 'px');
                        
                        // Highlight sidebar.
                        $($('.theiaStickySidebar')[j]).css('background', 'yellow');
                    }
                }
                
                if (ok == false) {                    
                    // Stop test.
                    $(this).unbind(event);
                    
                    alert('Bummer. Offset difference is bigger than 1px for some sidebars, which will be highlighted in yellow. Check the logs. Aborting.');
                    
                    return;
                }
            }
            
            me.values = newValues;
            
            // Scroll to bottom. We don't cache ($(document).height() - $(window).height()) since it may change (e.g. after images are loaded).
            if (me.currentScrollTop < ($(document).height() - $(window).height()) && me.scrollTopStep == 1) {
                me.currentScrollTop += me.scrollTopStep;
                window.scrollTo(0, me.currentScrollTop);
            }
            // Then back up.
            else if (me.currentScrollTop > 0) {
                me.scrollTopStep = -1;
                me.currentScrollTop += me.scrollTopStep;
                window.scrollTo(0, me.currentScrollTop);
            }
            // Then stop.
            else {                    
                $(this).unbind(event);
                
                alert("Great success!");
            }
        };
    }(me));
}



var owlCarouselSelector = $('.owl-carousel');
jQuery(function($) {
	
	
	/*
	| ----------------------------------------------------------------------------------
	| Initialize carousel
	| ----------------------------------------------------------------------------------
	*/
	$('.carousel-wrapper').each(function() {
		var $this = $(this), new_max;
		var configs = new Array();
		configs['autoplay'] = $this.data('autoplay') == true;
		configs['loop'] = $this.data('loop') == true;
		configs['width'] = $this.data('width');
		configs['minItems'] = $this.data('minitems');
		configs['maxItems'] = $this.data('maxitems');
		configs['slideshowspeed'] = $this.data('slideshow-speed');
		configs['speed'] = $this.data('speed');
		
		new_max = configs['maxItems'];
		var sliderW = $this.width();
		if ( sliderW >= 980 )
		{
			if ( configs['maxItems'] > 4 ) new_max = 4;
		}
		else if ( sliderW < 980 && sliderW >= 768 )
		{
			if ( configs['maxItems'] > 3 ) new_max = 3;
		}
		else if ( sliderW < 768 && sliderW >= 640 )
		{
			if ( configs['maxItems'] > 2 ) new_max = 2;
		}
		else if ( sliderW < 640 && sliderW >= 480 )
		{
			if ( configs['maxItems'] > 2 ) new_max = 2;
		}
		else
		{
			new_max = 1;
		}
		
		configs['minWidth'] = ( isNaN(configs['width']) || configs['width'] == 'undefined' ) ? sliderW / new_max : configs['width'];
	});
	
	function carousel_height( $this )
	{
		/*$this.imagesLoaded(function() {
			var max = 0;
			$this.find('li').each(function() {
				if ( $(this).outerHeight() > max )
				{
					max = $(this).outerHeight();
				}
			});
			$this.find('.carousel-list, .caroufredsel_wrapper').css( 'height', max + 'px' );
		});*/
	}
	
	
	var windowHeight = $(window).height();
    handleMobileMenu();

    // Mobile Menu Handler
    function handleMobileMenu() {
        var phoneMenuWrapper = $('.mobile-menu-wrapper');
        var phoneSubmenuWrapper = $('.mobile-submenu-wrapper');

        phoneMenuWrapper.css({
            display: 'none'
        });

        phoneSubmenuWrapper.css({
            display: 'none'
        });

        $('.mobile-menu-toggle').click(function() {

            phoneMenuWrapper.slideToggle(300);

            return false;
        });

        $('.menu-toggle').click(function() {

            $(this).parents('li').children('.mobile-submenu-wrapper').slideToggle(300);

            return false;
        });
    }
});






'use strict';

// Cache
//var body = $('body');
var featuredProductsCarousel = $('#featured-products-carousel');
var owlCarouselSelector = $('.owl-carousel');
var toTop = $('#to-top');


jQuery(document).ready(function () {
    // Prevent empty links
    // ---------------------------------------------------------------------------------------
    $('a[href=#]').click(function (event) {
        event.preventDefault();
    });
    // Scroll totop button
    // ---------------------------------------------------------------------------------------
    $(window).scroll(function () {
        if ($(this).scrollTop() > 1) {
            toTop.css({bottom: '15px'});
        } else {
            toTop.css({bottom: '-100px'});
        }
    });
    toTop.click(function () {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });
    // Sliders
    // ---------------------------------------------------------------------------------------
    if ($().owlCarousel) {
        var owl = $('.owl-carousel');
        owl.on('changed.owl.carousel', function(e) {
            // update prettyPhoto
            if ($().prettyPhoto) {
                $("a[data-gal^='prettyPhoto']").prettyPhoto({
                    theme: 'dark_square'
                });
            }
        });

        // Featured products carousel
        if (featuredProductsCarousel.length) {
            featuredProductsCarousel.owlCarousel({
                autoplay: false,
                loop: true,
                margin: 30,
                dots: false,
                nav: true,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsive: {
                    0: {items: 1},
                    480: {items: 2},
                    768: {items: 3},
                    992: {items: 4},
                    1024: {items: 4},
					1280: {items: 4}
                }
            });
        }
    }

jQuery(window).resize(function () {
    // Refresh owl carousels/sliders
    owlCarouselSelector.trigger('refresh');
    owlCarouselSelector.trigger('refresh.owl.carousel');
    // Refresh isotope
    if ($().isotope) {
        isotopeContainer.isotope('reLayout'); // layout/relayout on window resize
    }
    if ($().sticky) {
        $('.header.fixed').sticky('update');
    }
});

jQuery(window).scroll(function () {
    // Refresh owl carousels/sliders
    owlCarouselSelector.trigger('refresh');
    owlCarouselSelector.trigger('refresh.owl.carousel');
    if ($().sticky) {
        $('.header.fixed').sticky('update');
    }
});

var modalUniqueClass = ".modal";
$('.modal').on('show.bs.modal', function(e) {
  var $element = $(this);
  var $uniques = $(modalUniqueClass + ':visible').not($(this));
  if ($uniques.length) {
    $uniques.modal('hide');
    $uniques.one('hidden.bs.modal', function(e) {
      $element.modal('show');
    });
    return false;
  }
});

$( document ).ready(function() {
 
  $(".flexnav").flexNav({
  'animationSpeed':     250,            // default for drop down animation speed
  'transitionOpacity':  true,           // default for opacity animation
  'buttonSelector':     '.menu-button', // default menu button class name
  'hoverIntent':        false,          // Change to true for use with hoverIntent plugin
  'hoverIntentTimeout': 150,            // hoverIntent default timeout
  'calcItemWidths':     false,          // dynamically calcs top level nav item widths
  'hover':              true            // would you like hover support?      
});

    
});

		
$(function () {	
		$('a[data-toggle="collapse"]').on('click',function(){
	
	var objectID=$(this).attr('href');
	
	if($(objectID).hasClass('in'))
	{
						$(objectID).collapse('hide');
	}
	
	else{
						$(objectID).collapse('show');
	}
		});
		
});
  
$(document).ready(function() {
if($(".leftsidebar").length >0 || $(".rightsidebar").length >0){
	$('.leftsidebar, .rightsidebar')
		.theiaStickySidebar({
			additionalMarginTop: 100
		});
		}
});
	

	//HERO DIMENSTION AND CENTER
$(function () {	
	    function heroInit(){
	       var hero = jQuery('.hero'),
				ww = jQuery(window).width(),
				wh = jQuery(window).height(),
				heroHeight = wh;

			hero.css({
				height: heroHeight+"px",
			});

			var heroContent = jQuery('.hero .content'),
				contentHeight = heroContent.height(),
				parentHeight = hero.height(),
				topMargin = (parentHeight - contentHeight) / 2;

			heroContent.css({
				"margin-top" : topMargin+"px"
			});
	    }

	    jQuery(window).on("resize", heroInit);
	    jQuery(document).on("ready", heroInit);
	});
	})