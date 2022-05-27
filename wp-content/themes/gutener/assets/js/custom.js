;(function( $ ){

/**
* Setting up functionality for slick navigation
*/
function slickNavHeight (){
  var headerHeight = $( '.site-header-primary .main-header' ).outerHeight();
  var headerHeight = $( '.site-header-three' ).outerHeight();
  $('.slicknav_nav').css( 'top', headerHeight );
}

/**
* Setting up functionality for alternative menu
*/
function wpMenuAccordion( selector ){

  var $ele = selector + ' .header-navigation .menu-item-has-children > a';
  $( $ele ).each( function(){
    var text = $( this ).text();
    text = text + '<button class="fas fa-plus"></button>';
    $( this ).html( text );
  });

  jQuery( document ).on( 'click', $ele + ' .triangle', function( e ){
    e.preventDefault();
    e.stopPropagation();

    $parentLi = $( this ).parent().parent( 'li' );
    $childLi = $parentLi.find( 'li' );

    if( $parentLi.hasClass( 'open' ) ){
      /**
      * Closing all the ul inside and 
      * removing open class for all the li's
      */
      $parentLi.removeClass( 'open' );
      $childLi.removeClass( 'open' );

      $( this ).parent( 'a' ).next().slideUp();
      $( this ).parent( 'a' ).next().find( 'ul' ).slideUp();
    }else{

      $parentLi.addClass( 'open' );
      $( this ).parent( 'a' ).next().slideDown();
    }
  });
};

/**
* Setting up functionality for fixed header
*/

$mastheadHeight = $( '#masthead.site-header' ).height();
$stickymastheadHeight = $( '#masthead .overlay-header' ).height();

function fixed_header(){
  $notificationHight = $( '.notification-bar' ).height();
  $logo_selector = document.getElementById( 'headerLogo' );
  var width = $( window ).width();

  if ( $logo_selector && GUTENER.fixed_nav && GUTENER.fixed_header_logo ) { 
    if ( $mastheadHeight < $(window).scrollTop()){
      if ( GUTENER.separate_logo == '' ){
        if ( GUTENER.the_custom_logo !== '' ){
          $logo_selector.src = GUTENER.the_custom_logo;
        }
      }else{
        $( '.site-header .site-branding img' ).css( 'display' , 'block' );
        if( !GUTENER.mobile_fixed_nav_off || width >= 782 ){
          $logo_selector.src = GUTENER.separate_logo;
        }
      }
    }else{
      if ( GUTENER.header_three_logo !== '' && ( GUTENER.is_front_page || GUTENER.overlay_post || GUTENER.overlay_page ) && GUTENER.is_header_three ){
         $logo_selector.src = GUTENER.header_three_logo;
      }else if ( GUTENER.the_custom_logo !== '' ) {
          $logo_selector.src = GUTENER.the_custom_logo;
      }else if ( GUTENER.separate_logo !== '' ){
        $( '.site-header .site-branding img' ).css( 'display' , 'none' );
      }
    }
  }
  if ( $mastheadHeight > $( window ).scrollTop() || $( window ).scrollTop() == 0 ) {
    if ( GUTENER.fixed_nav && $( '#masthead.site-header' ).hasClass( 'sticky-header' ) ){
      $( '#masthead.site-header' ).removeClass( 'sticky-header' );
      if( GUTENER.fixed_notification ){
        $( '.fixed-header' ).css( 'marginTop' , 0 );
      }
      // Fixed header in admin bar
      if( GUTENER.is_admin_bar_showing && width >= 782 ){
        $( '.fixed-header' ).css( 'marginTop', 0 );
      }
      if( GUTENER.is_admin_bar_showing && width <= 781 ){
        $( '.fixed-header' ).css( 'marginTop', 0 );
      }
    }
  }else if ( GUTENER.fixed_nav && !$( '#masthead.site-header' ).hasClass( 'sticky-header' ) ){
    if( !GUTENER.mobile_fixed_nav_off || width >= 782 ){
      $( '#masthead.site-header' ).addClass( 'sticky-header' ).fadeIn();
    }
    if( GUTENER.fixed_notification ){
      $( '.fixed-header' ).css( 'marginTop' , $notificationHight );
    }
    // Fixed header in admin bar
    if( GUTENER.is_admin_bar_showing && width >= 782 ){
      $( '.fixed-header' ).css( 'marginTop', 32 );
    }
    if( GUTENER.is_admin_bar_showing && width <= 781 ){
      $( '.fixed-header' ).css( 'marginTop', 46 );
    }
    if( GUTENER.is_admin_bar_showing && width <= 600 ){
      $( '.fixed-header' ).css( 'marginTop', 0 );
    }
    // Fixed header and fixed notification in admin bar
    if( GUTENER.fixed_notification && GUTENER.is_admin_bar_showing && width >= 782 ){
      $( '.fixed-header' ).css( 'marginTop' , $notificationHight + 32 );
    }
    if( GUTENER.fixed_notification && GUTENER.is_admin_bar_showing && width <= 781 ){
      $( '.fixed-header' ).css( 'marginTop' , $notificationHight + 46 );
    }
    if( !GUTENER.mobile_sticky_notification && width <= 781 ){
        $( '.fixed-header' ).css( 'marginTop', 0 );
    }
    if( !GUTENER.mobile_sticky_notification && GUTENER.is_admin_bar_showing && width <= 781 ){
        $( '.fixed-header' ).css( 'marginTop', 46 );
    }
    if( GUTENER.fixed_notification && GUTENER.is_admin_bar_showing && width <= 600 ){
      $( '.fixed-header' ).css( 'marginTop' , $notificationHight );
    }
    if( !GUTENER.mobile_sticky_notification && width <= 600 ){
        $( '.fixed-header' ).css( 'marginTop', 0 );
    }
    if( GUTENER.mobile_fixed_nav_off && width <= 781 ){
        $( '.fixed-header' ).css( 'marginTop', 0 );
    }
  }
}

/**
* Setting up functionality for header three - transparent header
*/
function header_three_postion() {
  $notificationHight = $( '.notification-bar' ).height();
  var width = $( window ).width();

  if ( GUTENER.is_header_three ) {
    if( GUTENER.is_admin_bar_showing && width >= 782 ){
      $( '.overlay-header' ).css( 'top' , 32 );
      $notificationHight = $notificationHight + 32;
    }
    if( GUTENER.is_admin_bar_showing && width <= 781 ){
      $( '.overlay-header' ).css( 'top' , 46 );
      $notificationHight = $notificationHight + 46;
    }
    if( GUTENER.fixed_notification && GUTENER.is_admin_bar_showing && width >= 782 ){
      $( '.notification-bar' ).css({ top : 32 });
      $( '.overlay-header' ).css( 'top' , $notificationHight );
    }else if( GUTENER.fixed_notification && width >= 782 ){
      $( '.overlay-header' ).css( 'top' , $notificationHight );
    }else if( !GUTENER.fixed_notification && GUTENER.is_admin_bar_showing && width >= 782 ){
      $( '.overlay-header' ).css( 'top' , $notificationHight );
    }else if( !GUTENER.fixed_notification && !GUTENER.is_admin_bar_showing && width >= 782 ){
      $( '.overlay-header' ).css( 'top' , $notificationHight );
    }else if( GUTENER.mobile_notification && GUTENER.is_admin_bar_showing && width <= 782 ){
      $( '.overlay-header' ).css( 'top' , $notificationHight );
    }else if( !GUTENER.mobile_notification && !GUTENER.is_admin_bar_showing && width <= 768 ){
      $( '.overlay-header' ).css( 'top' , 0 );
    }else if( GUTENER.mobile_notification && width <= 768 ){
      $( '.overlay-header' ).css( 'top' , $notificationHight );
    }
  }
}
/**
* Setting up functionality for notification bar
*/
function is_user_logged() {
  var width = $( window ).width();
  $notificationHight = $( '.notification-bar' ).outerHeight();

  if( GUTENER.is_admin_bar_showing ){
    // desktop - 32px
    if( width >= 782 ){
      if( GUTENER.fixed_notification ) {
        $( '.notification-bar' ).css( 'top', 32 );
      }
    }

    // mobile with fixed admin bar - 46px
    if( width <= 781 ){
      if( GUTENER.fixed_notification ) {
        $( '.notification-bar' ).css( 'top', 46 );
      }
      if( GUTENER.fixed_notification && !GUTENER.mobile_notification ){
        $( '.notification-bar' ).css( 'top', 0 );
      }
    }

    // mobile with absolute admin bar - 46px
    if( width <= 600 ){
      if( GUTENER.fixed_notification ) {
        $( '.notification-bar' ).css( 'top', 0 );
      }
    }
  }
}

/**
* Setting up call functions
*/
// Document ready
jQuery( document ).ready( function() {
  slickNavHeight();
  wpMenuAccordion( '#offcanvas-menu' );
  is_user_logged();
  header_three_postion();

  /**
  * Offcanvas Menu
  */
  $( document ).on( 'click', '.offcanvas-menu-toggler, .close-offcanvas-menu button, .offcanvas-overlay', function( e ){
    e.preventDefault();
    $( 'body' ).toggleClass( 'offcanvas-slide-open' );
    setTimeout(function(){
      $( '.close-offcanvas-menu button' ).focus();
    }, 40);
  });
  $( '.close-offcanvas-menu button' ).click( function(){
    setTimeout(function(){
      $( '.offcanvas-menu-toggler' ).focus();
    }, 50);
  });

  jQuery( 'body' ).append( '<div class="offcanvas-overlay"></div>' );

  /**
  * Desktop Hamburger Nav on focus out event
  */
   jQuery( '.offcanvas-menu-wrap .offcanvas-menu-inner' ).on( 'focusout', function () {
     var $elem = jQuery( this );
     // let the browser set focus on the newly clicked elem before check
     setTimeout(function () {
       if ( ! $elem.find( ':focus' ).length ) {
         jQuery( '.offcanvas-menu-toggler' ).trigger( 'click' );
         $( '.offcanvas-menu-toggler' ).focus();
       }
     }, 0);
   });

  /**
   * Header Search from
  */
  jQuery( document ).on( 'click','.search-icon, .close-button', function(){
    $( '.header-search' ).toggleClass("search-in");
    $( '.header-search input' ).focus();
  });

  // search toggle on focus out event
  jQuery( '.header-search form' ).on( 'focusout', function () {
    var $elem = jQuery(this);
      // let the browser set focus on the newly clicked elem before check
      setTimeout(function () {
          if ( ! $elem.find( ':focus' ).length ) {
            jQuery( '.search-icon' ).trigger( 'click' );
            $( '.search-icon' ).focus();
          }
      }, 0);
  });

  /**
  * Header image slider
  */
  $( '.header-image-slider' ).slick({
      dots: true,
      arrows: true,
      adaptiveHeight: false,
      fade: GUTENER.header_image_slider.fade,
      speed: parseInt( GUTENER.header_image_slider.fadeControl ),
      cssEase: 'linear',
      autoplay: GUTENER.header_image_slider.autoplay,
      autoplaySpeed: GUTENER.header_image_slider.autoplaySpeed,
      infinite: true,
      prevArrow: $( '.header-slider-prev' ),
      nextArrow: $( '.header-slider-next' ),
      rows: 0,
      appendDots: $( '.header-slider-dots' ),
    });
  $( '.header-image-slider' ).attr( 'dir', 'ltr' );

  /**
  * Slick navigation
  */
  $( '#primary-menu' ).slicknav({
      duration: 500,
      closedSymbol: '<i class="fa fa-plus"></i>',
      openedSymbol: '<i class="fa fa-minus"></i>',
      appendTo: '.mobile-menu-container',
      allowParentLinks: true,
      nestedParentLinks : false,
      label: GUTENER.responsive_header_menu_text,
      closeOnClick: true, // Close menu when a link is clicked.
  });
  
  /**
  * Slick navigation mobile on focus out event
  */
  jQuery( '.slicknav_menu .slicknav_nav' ).on( 'focusout', function () {
    var $elem = jQuery(this);
    // let the browser set focus on the newly clicked elem before check
    setTimeout(function () {
      if ( ! $elem.find( ':focus' ).length ) {
        jQuery( '.slicknav_open' ).trigger( 'click' );
      }
    }, 0);
  });

  /**
  * Header three content
  */
  if ( $( '.site-header' ).hasClass( 'header-three' ) ) {
    $( '.home .section-banner .banner-content' ).css( 'marginTop' , $stickymastheadHeight );
  }

  if ( $( '.site-header' ).hasClass( 'header-three' ) ) {
    $( '.inner-banner-wrap .page-title' ).css( 'marginTop' , $stickymastheadHeight );
  }

  /**
  * Main posts slider
  */
  $( '.main-slider' ).slick({
      dots: true,
      arrows: true,
      adaptiveHeight: false,
      fade: GUTENER.main_slider.fade,
      speed: parseInt( GUTENER.main_slider.fadeControl ),
      cssEase: 'linear',
      autoplay: GUTENER.main_slider.autoplay,
      autoplaySpeed: GUTENER.main_slider.autoplaySpeed,
      infinite: true,
      prevArrow: $( '.main-slider-prev' ),
      nextArrow: $( '.main-slider-next' ),
      rows: 0,
      appendDots: $( '.main-slider-dots' ),
    });
  $( '.main-slider' ).attr( 'dir', 'ltr' );

  /**
   * Featured posts slider
   */
  $( '.feature-post-slider' ).slick({
      arrows: true,
      dots: true,
      slidesToShow: GUTENER.home_feature_posts.slidesToShow,
      slidesToScroll: 1,
      adaptiveHeight: false,
      autoplay: GUTENER.home_feature_posts.autoplay,
      autoplaySpeed: GUTENER.home_feature_posts.autoplaySpeed,
      infinite: false,
      rows: 0,
      prevArrow: $( '.feature-posts-prev' ),
      nextArrow: $( '.feature-posts-next' ),
      appendDots: $( '.feature-posts-dots' ),
      responsive: [
        {
          breakpoint: 1023,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
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
  $( '.feature-post-slider' ).attr( 'dir', 'ltr' );

  /**
  * Sticky sidebar
  */
  if( GUTENER.sticky_sidebar ){
    $( '.content-area, .left-sidebar, .right-sidebar' ).theiaStickySidebar({
      // Settings
      additionalMarginTop: 30,
    });
  }

  /**
  * Back to top
  */
  jQuery( document ).on( 'click', '#back-to-top a', function() {
      $( 'html, body' ).animate({ scrollTop: 0 }, 800);
      return false;
  });

}); // closing document ready

// Window resize
jQuery( window ).on( 'resize', function(){
  slickNavHeight();
  is_user_logged();
  fixed_header();
  header_three_postion();
});

// Window load
jQuery( window ).on( 'load', function(){
  /**
  * Site Preloader
  */
  $( '#site-preloader' ).fadeOut( 500 );

  /**
  * Back to top
  */
  if( GUTENER.enable_scroll_top == true && $(window).scrollTop() > 200 ){
    $( '#back-to-top' ).fadeIn( 200 );
  } else{
    $( '#back-to-top' ).fadeOut( 200 );
  }

  /**
  * Masonry wrapper
  */
  if( jQuery( '.masonry-wrapper' ).length > 0 ){
    $grid = jQuery( '.masonry-wrapper' ).masonry({
      itemSelector: '.grid-post',
      // percentPosition: true,
      isAnimated: true,
    }); 
  }

  /**
  * Jetpack's infinite scroll on masonry layout
  */
  infinite_count = 0;
    $( document.body ).on( 'post-load', function () {

    infinite_count = infinite_count + 1;
    var container = '#infinite-view-' + infinite_count;
    $( container ).hide();

    $( $( container + ' .grid-post' ) ).each( function(){
      $items = $( this );
        $grid.append( $items ).masonry( 'appended', $items );
    });

    setTimeout( function(){
      $grid.masonry( 'layout' );
    },500);
    });

}); // closing window load

// Window scroll
jQuery( window ).on( 'scroll', function(){
  fixed_header();

  /**
  * Back to top
  */
  if( GUTENER.disable_scroll_top == false && $(window).scrollTop() > 200 ){
    $( '#back-to-top' ).fadeIn( 200 );
  } else{
    $( '#back-to-top' ).fadeOut( 200 );
  }
}); // closing window scroll

})( jQuery );