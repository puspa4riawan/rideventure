var sm= 576;
var md= 768;
var lg= 992;
var xl= 1200;
var waitForEl = function(selector, callback) {
  if (jQuery(selector).length) {
    callback();
  } else {
    setTimeout(function() {
      waitForEl(selector, callback);
    }, 100);
  }
};

$.fn.toggleAttr = function(attr, val) {
  var test = $(this).attr(attr);
  if ( test ) { 
    // if attrib exists with ANY value, still remove it
    $(this).removeAttr(attr);
  } else {
    $(this).attr(attr, val);
  }
  return this;
};

// jquery toggle just the attribute value
$.fn.toggleAttrVal = function(attr, val1, val2) {
  var test = $(this).attr(attr);
  if ( test === val1) {
    $(this).attr(attr, val2);
    return this;
  }
  if ( test === val2) {
    $(this).attr(attr, val1);
    return this;
  }
  // default to val1 if neither
  $(this).attr(attr, val1);
  return this;
};


function setupWindow(){
	$('body').css({"min-height": $(window).height() });
	var outerHeight = 0;
	$('footer').each(function() {
	  outerHeight += $(this).outerHeight();
	});
	if ($(window).outerWidth() < (lg)) {
		// console.log('mobile');
		$('#mainNavbarContent .acc').insertAfter('#searchToggleMobile');
		vidHeight = $('#video-list .atc').outerHeight();
		$('#video-list .list-video').height( vidHeight * 1.1 );
	} else {
		// console.log('desktop');
		$('#mainNavbar .acc').appendTo('#mainNavbarContent');
		$( ".searchbox" ).hover(
		  function() {
	  		$( this ).find(".searchbox-input").focus();
		  }, function() {
		  	if ( $(this).hasClass('suggest') ) {
		  		$( this ).find(".searchbox-input").focus();
		  	} else{
		    	$( this ).find(".searchbox-input").blur();
		    	$(this).removeClass('suggest');
		    }
		  }
		);
		$('.searchbox-input').blur(function(){
			// $(this).parents('.searchbox').removeClass('suggest');
		})
		$('.searchbox-input').keyup(function (e){
		  $(this).parent().addClass('suggest');
		})
		$('.searchbox').find('li').on('click', function(){
			$(this).parents('.searchbox').removeClass('suggest');
			$(this).parents('.searchbox').find(".searchbox-input").blur();
		});
	}

	// adjust ssf-school
	$('#mainContent').css({"min-height": $(window).height()-outerHeight });
	if ($('.sch-main').length>0) {
		if ($(window).outerWidth() > (md)) {
			$('.sch-main').css({"min-height":  $(window).height()-$('#mainNavbar').height()-$('.sch-intro').outerHeight() });
			$('.lists').parents('.sch-main').css({"height":  $(window).height()-$('#mainNavbar').height()-$('.sch-intro').outerHeight() });
			$('#places').css({"height" : $('#places').parents('.sch-result').height()-$('#places').parent().siblings('.head').innerHeight() })
		} else {
			// $('.lists #places').css({"height" : $('.place').innerHeight()*3.25 })
			$('.lists .mCustomScrollbar').mCustomScrollbar('destroy');
		}
	}
	if($('.swiper-container.experts-slider').length>0){
		expertSlider = new Swiper('.swiper-container.experts-slider', {            
	        loop: true,
	        slidesPerView: 3,
	        centeredSlides: true,
	        navigation: {
			    nextEl: '.swiper-container.experts-slider .next',
			    prevEl: '.swiper-container.experts-slider .prev',
			},
			on: {
			    touchMove	: function () {
			      $('.swiper-container.experts-slider').addClass('moving')
			    },
			    transitionStart	: function () {
			      $('.swiper-container.experts-slider').addClass('moving')
			    },
			    slideChangeTransitionEnd: function () {
			      $('.swiper-container.experts-slider').removeClass('moving')
			    },
			}
	    });
	}
}


var mainHeroSwiper = undefined;
function fmainHeroSwiper(){

  if( $('#mainHero .swiper-slide').length > 1  && mainHeroSwiper == undefined) {            
    mainHeroSwiper = new Swiper('#mainHero', {            
      loop: true,
      pagination: {
        el: '#mainHero .swiper-pagination',
        type: 'bullets',
        clickable: true
      },
      navigation: {
        nextEl: '#mainHero .swiper-next',
        prevEl: '#mainHero .swiper-prev',
      },
      autoHeight: true
    });
  } else if ($('#mainHero .swiper-slide').length == 1) {
    if (mainHeroSwiper != undefined) {
      mainHeroSwiper.destroy(true, true);
      mainHeroSwiper = undefined;
    }
  }
}

    var swiperInstances = {};
    $(".sw-default .swiper-container").each(function(index, element){
        var $this = $(this);
        if ( $this.find('.swiper-slide').length > 1 ) {

            $this.addClass("instance-" + index);
            $this.find(".swiper-button-prev").addClass("prev-" + index);
            $this.find(".swiper-button-next").addClass("next-" + index);
            $this.find(".swiper-pagination").addClass("pagination-" + index);
            swiperInstances[index] = new Swiper(".sw-default .instance-" + index, {
                navigation: {
                    nextEl: ".sw-default .btn-next-" + index,
                    prevEl: ".sw-default .btn-prev-" + index,
                },
                pagination: {
                    el: '.sw-default .pagination-' + index,
                    type: 'bullets',
                    clickable: true
                },
                autoHeight: true
            });
        }
    });

var swDefault = {};
function fswDefaultSwiper(){
    $(".sw-default .swiper-container").each(function(index, element){
        var $this = $(this);
        if ( $this.find('.swiper-slide').length > 1 ) {

            $this.addClass("instance-" + index);
            $this.find(".swiper-button-prev").addClass("prev-" + index);
            $this.find(".swiper-button-next").addClass("next-" + index);
            $this.find(".swiper-pagination").addClass("pagination-" + index);
            swiperInstances[index] = new Swiper(".sw-default .instance-" + index, {
                loop: true,
                pagination: {
                  el: '.sw-default .pagination-' + index,
                  type: 'bullets',
                  clickable: true
                },
                navigation: {
                  nextEl: '.sw-default .next-' + index,
                  prevEl: '.sw-default .prev-' + index,
                },
                autoHeight: true,
                autoplay: {
                  delay: 5000,
                },
            });
        }
    });
}

var fitparSwiper = undefined;
function ffitparSwiper(){

  if( $(window).outerWidth() >= (lg) ) {            
    if ($('.homepage .fitpar .sw .fitur').length>4) {
    	// console.log('>1');
	    fitparSwiper = new Swiper('.fitpar .swiper-container', {            
	        loop: true,
	        slidesPerView: 'auto',
	        navigation: {
				    nextEl: '.fitpar .swiper-next',
				    prevEl: '.fitpar .swiper-prev',
				  },
	    });
	    $('.homepage .fitpar .sw-c').addClass('swiper-container');
	    $('.homepage .fitpar .sw-w').addClass('swiper-wrapper');
	    $('.homepage .fitpar .sw .fitur').addClass('swiper-slide');
    } else {
    	// console.log('1');
	    $('.homepage .fitpar div').removeClass('swiper-container');
	    $('.homepage .fitpar div').removeClass('swiper-wrapper');
	    $('.homepage .fitpar div').removeClass('swiper-slide');
	    $('.homepage .fitpar .swiper-next').hide();
	    $('.homepage .fitpar .swiper-prev').hide();
    }

    if (fitparSwiper != undefined) {
	    fitparSwiper = new Swiper('.homepage .fitpar .swiper-container', {            
	        loop: true,
	        slidesPerView: 'auto',
	        navigation: {
				    nextEl: '.homepage .fitpar .swiper-next',
				    prevEl: '.homepage .fitpar .swiper-prev',
				  },
	    });
    	// console.log('!=undef')
    } else {
    	// console.log('==undef')
    }

  } else if( $(window).outerWidth() < (lg) ){
    // console.log('noswiper');
    if (fitparSwiper != undefined) {
	    fitparSwiper.destroy(true, true);
	    fitparSwiper = undefined;
    }
    $('.homepage .fitpar div').removeClass('swiper-container');
    $('.homepage .fitpar div').removeClass('swiper-wrapper');
    $('.homepage .fitpar div').removeClass('swiper-slide');
  }
}

var aBannerSwiper = undefined;
function faBannerSwiper(){
	$('.a-banner-slider').each(
	  function() {
	    var slide = ($(this).find('.swiper-slide')).length;
		  if( slide > 1  && aBannerSwiper == undefined) {            
		    aBannerSwiper = new Swiper('.a-banner-slider', {            
		        loop: true,
		        pagination: {
					    el: '.a-banner-slider .swiper-pagination',
					    type: 'bullets',
					    clickable: true
					  },
					  autoHeight: true
		    });
		  } else if ( slide == 1 ) {
		    if (aBannerSwiper != undefined) {
			    aBannerSwiper.destroy(true, true);
			    aBannerSwiper = undefined;
		    }
		  }
	  }
	);
}

var ikseSwiper = undefined;
function fikseSwiper(){

  if( $(window).outerWidth() >= (lg) ) {            
    if ($('.ikutserta .sw .a-hero').length>4) {
    	// console.log('>1');
	    ikseSwiper = new Swiper('.ikutserta .swiper-container', {            
	        loop: true,
	        slidesPerView: 'auto',
	        navigation: {
				    nextEl: '.ikutserta .swiper-next',
				    prevEl: '.ikutserta .swiper-prev',
				  }
	    });
	    $('.ikutserta .sw-c').addClass('swiper-container');
	    $('.ikutserta .sw-w').addClass('swiper-wrapper');
	    $('.ikutserta .sw .a-hero').addClass('swiper-slide');
    } else {
    	// console.log('1');
	    $('.ikutserta div').removeClass('swiper-container');
	    $('.ikutserta div').removeClass('swiper-wrapper');
	    $('.ikutserta div').removeClass('swiper-slide');
	    $('.ikutserta .swiper-next').hide();
	    $('.ikutserta .swiper-prev').hide();
    }

    if (ikseSwiper != undefined) {
	    ikseSwiper = new Swiper('.homepage .ikutserta .swiper-container', {            
	        loop: true,
	        slidesPerView: 'auto',
	        navigation: {
				    nextEl: '.ikutserta .swiper-next',
				    prevEl: '.ikutserta .swiper-prev',
				  },
	    });
    	// console.log('!=undef')
    } else {
    	// console.log('==undef')
    }

  } else if( $(window).outerWidth() < (lg) ){
    // console.log('noswiper');
    if (ikseSwiper != undefined) {
	    ikseSwiper.destroy(true, true);
	    ikseSwiper = undefined;
    }
    $('.homepage .ikutserta div').removeClass('swiper-container');
    $('.homepage .ikutserta div').removeClass('swiper-wrapper');
    $('.homepage .ikutserta div').removeClass('swiper-slide');
  }
}


function fixRatio(){
	// set ratio di semua screen
	$('.fix-ratio').each(function(){
		var ratio=$(this).attr('ratio').split(':');
		r_w=ratio[0];
		r_h=ratio[1];
		set_h=parseFloat(this.getBoundingClientRect().width)/(r_w/r_h);
		$(this).css({'height':set_h+'px'});
	});
}

function fixRatioBoth(){
	// set ratio di mobile dan desktop
	$('.fix-ratio-both').each(function(){
		var ratio_m=$(this).attr('ratio-m').split(':');
		r_w_m=ratio_m[0];
		r_h_m=ratio_m[1];
		set_h_m=parseFloat(this.getBoundingClientRect().width)/(r_w_m/r_h_m);

		var ratio=$(this).attr('ratio').split(':');
		r_w=ratio[0];
		r_h=ratio[1];
		set_h=parseFloat(this.getBoundingClientRect().width)/(r_w/r_h);

		if ($(window).width() < lg) {
			$(this).css({'height':set_h_m+'px'});
		} else {
			$(this).css({'height':set_h+'px'});
		}
	});
}

function progressBar(){
	if ($('.pb').length>0){
		var persen = 	$('.pb .progress-bar').attr('aria-valuenow');
		$('.pb .progress-bar').css("width", persen + "%");
		$('.pb .persen').text(persen + "%");
		if ( $('.pb .progress-bar').outerWidth() >= $('.pb .progress-txt').outerWidth() ){
			$('.pb .progress-txt').addClass('in');
		}
	}
}

function vaksinTabNav(){
  var c2dd = $(".vaksin-about-tab-navbar");
  if($(window).width() < (md)){
    c2dd.addClass("dropdown");
    var str = c2dd.find($( "a" )).first().text();
    c2dd.find("button").text(str);
    c2dd.find("div").addClass("dropdown-menu");
    c2dd.find("a").addClass("dropdown-item");
    if (c2dd.find('.active').length>0) {
      c2dd.find(".dropdown-toggle").html($('.vaksin-about-tab-navbar .active').text());
    }
    $('#vaksinTab a').on('click', function (e) {
      e.preventDefault()
      c2dd.find(".dropdown-toggle").html($(this).text());
    })
  } else {
    c2dd.removeClass("dropdown");
    c2dd.find("div").removeAttr("style");
    c2dd.find("div").removeClass("dropdown-menu");
    c2dd.find("a").removeClass("dropdown-item");
  }
  $("#vaksinTab a").click(function(e){
    e.preventDefault()
    $(this).tab('show');
  });
}


// tambah .js-scrollto untuk scroll to anchor
// <a class="js-scrollto" href="#top">
$(document).on("click", ".js-scrollto", function(e) {
    var id = $(this).attr("href");
    var $id = $(id);
    if ($id.length === 0) {
        return;
    }
    e.preventDefault();
    var pos = $id.offset().top - ( $('#mainNavbar').height() * 1.5 );
    $("body, html").animate({scrollTop: pos}, 2000);
});

function skhVideoPlaylist() {
  if ($(window).width() < (lg)) {
    $(".skh-vplaylist").mCustomScrollbar({
      axis:"x",
      theme:"dark"
    });
    $('.skh-video').width( $('.skh-vplay').width()*0.35);
  } else {
    $(".skh-vplaylist").mCustomScrollbar({
      axis:"y",
      theme:"dark"
    });
  }
}

$(window).on('resize', function(){
	setupWindow();
	fmainHeroSwiper();
	ffitparSwiper();
	fikseSwiper();
	faBannerSwiper();
	fixRatioBoth();
	fixRatio();
	progressBar();
  vaksinTabNav();
  fswDefaultSwiper();
  skhVideoPlaylist();
});

// $(function(){
//   var hash = window.location.hash;
//   hash && $('#tabPages a[href="' + hash + '"]').tab('show');

//   $('#tabPages a').click(function (e) {
//     $(this).tab('show');
//     var scrollmem = $('body').scrollTop();
//     window.location.hash = this.hash;
//     $('html,body').scrollTop(scrollmem);
//   });
// });

$(document).ready(function(){
	setupWindow();
	fixRatioBoth();
	fixRatio();

  vaksinTabNav();
  skhVideoPlaylist();

  // object fit
  objectFitImages(document.querySelectorAll('img'));

  // bootstrap select
  $('.bs-select').selectpicker({
	  style: 'btn-input',
	  size: 4
	});
  
  $('.bs-select-anak').selectpicker({
    style: 'btn-input',
    showSubtext: true
  });

  $('.bs-border-primary').selectpicker({
    style: 'btn-border-primary',
    dropupAuto: false
  });


  	$( "#searchInput" ).focusin(function() {
		  console.log('in');
		});
		$( "#searchInput" ).focusout(function() {
		  console.log('out');
	  })

  // navbar-nav
  var mainNav=$('#mainNav');
	$('#mainNavbarContent').on('shown.bs.collapse', function () {
  	$('body').addClass('modal-open');
	});
	$('#mainNavbarContent').on('hide.bs.collapse', function () {
  	$('body').removeClass('modal-open');
  	mainNav.find('.hasChild').removeAttr('menu-state');
  	mainNav.find('.hasChild ul').slideUp();
	});
	
  // header

	// $('.bs-search').selectpicker('show');
	// $( ".bs-search .dropdown-toggle" ).append('<i class="fa fa-search" aria-hidden="true"></i>');
	// $( ".searchbox" ).hover(
	// 	function(){
	// 		$(this).find('.dropdown-toggle').click();
	// 	}
	// );
	$(".searchbox-input").attr('autocomplete', 'off');

  $('.acc-login-link').on('click', function(e){
  	e.preventDefault();
  	$('#mainNavbarContent').collapse('hide');
  	$('#tabLoginRegister a[href="#login-pane"]').tab('show');
  })
  $('.acc-register-link').on('click', function(e){
  	e.preventDefault();
  	$('#mainNavbarContent').collapse('hide');
  	$('#tabLoginRegister a[href="#register-pane"]').tab('show');
  })

  $('#searchToggleMobile').on('click', function(){
  	$('#mainNavbarContent').on('shown.bs.collapse', function () {
	  	$('#mainNavbarContent .searchbox-input').focus();
		});
  })

  mainNav.find($('li:not(:has(a))')).addClass('sub');
	mainNav.find('li:has(> ul)').addClass('hasChild');
  if( $(window).outerWidth() < xl ){
	  mainNav.find('li:has(> ul) > a').after('<button class="dd"><i class="i arrow-2"></i></button>');
	  mainNav.find('li:has(> ul) > .dd').on('click', function(e){
	  	// e.preventDefault();
	  	// $(this).addClass('x');
	  	$(this).siblings('ul').slideToggle();
	  	if( $(this).parent().attr('menu-state') == 'open'){
	  		$(this).parent().removeAttr('menu-state');
	  	} else {
	  		$(this).parent().attr('menu-state', 'open');
	  	}

      $(this).parent().siblings().removeAttr('menu-state');
	  	$(this).parent().siblings().find('.hasChild').removeAttr('menu-state');
      $(this).parent().siblings().find('ul').slideUp();

	  });
  }

  $('.open-notif').on('click',function(e){
  	e.preventDefault();
  	$('body').addClass('modal-open');
  	$('.wyeth-notification').addClass('active');
  })

  $('.close-notif').on('click',function(e){
  	e.preventDefault();
  	$('body').removeClass('modal-open');
  	$('.wyeth-notification').removeClass('active');
  })


	//ikut serta
	fikseSwiper();



  //banner
	fmainHeroSwiper();

	// hubungi
	$('#hubungi-btn').click(function(e) {
		e.preventDefault;
    $('#hubungi').toggleClass('pop');
	});

	// article detail banner
	faBannerSwiper();


	// browser window scroll (in pixels) after which the "back to top" link is shown
	var offset = 300,
		//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		offset_opacity = 600,
		//duration of the top scrolling animation (in ms)
		scroll_top_duration = 700,
		//grab the "back to top" link
		$back_to_top = $('.cd-top');

	//hide or show the "back to top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) {
			$back_to_top.addClass('cd-fade-out');
		}
	});

	//smooth scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

	//fitur parenting
	ffitparSwiper();

	// date picker
  $('.bs-dob').datepicker({
    format: "d MM yyyy",
    weekStart: 1,
    endDate: "today",
    startView: 2,
    maxViewMode: 3,
    todayBtn: true,
    clearBtn: true,
    language: "id",
    toggleActive: true,
    autoclose: true,
  });

  $('.bs-date').datepicker({
    format: "d MM yyyy",
    weekStart: 1,
    endDate: "today",
    maxViewMode: 3,
    todayBtn: true,
    clearBtn: true,
    language: "id",
    toggleActive: true,
    autoclose: true,
  });

	// update fix ratio tiap buka modal/tab/pill bootstrap
		// update fixratio
	$('[data-toggle="pill"]').on('shown.bs.tab', function (e) {
	  fixRatio();
	});
	$('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  fixRatio();
	});
	$('[data-toggle="modal"]').on('shown.bs.modal', function (e) {
	  fixRatio();
	});


	// sample chart.js
	$('.sampleChart').each(function(){
		var ctx = $('.sampleChart');
		var data = {
	    labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
	    datasets: [
	        {
	            label: "My First dataset",
	            backgroundColor: "rgba(179,181,198,0.2)",
	            borderColor: "rgba(179,181,198,1)",
	            pointBackgroundColor: "rgba(179,181,198,1)",
	            pointBorderColor: "#fff",
	            pointHoverBackgroundColor: "#fff",
	            pointHoverBorderColor: "rgba(179,181,198,1)",
	            data: [65, 59, 90, 81, 56, 55, 40],
	        }
	    ]
		};
		var myRadarChart = new Chart(ctx, {
		    type: 'radar',
		    data: data,
		    options: {
		    	legend: {
		    		display : false
		    	}
		    }
		});
	});

	// progress bar
	progressBar();

  // sikecilhebat
  fswDefaultSwiper();

	// input ios
// $('input, textarea').css("pointer-events","none");

// $('body').on('touchstart', function(e) {
//     $('input, textarea').css("pointer-events","auto");
// });
// $('body').on('touchmove', function(e) {
//     $('input, textarea').css("pointer-events","none");
// });
// $('body').on('touchend', function(e) {
//   setTimeout(function() {
//     $('input, textarea').css("pointer-events", "none");
//   },0);
// });


});