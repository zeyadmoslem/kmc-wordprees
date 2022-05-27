<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Gutener Medical
 */

if ( ! function_exists( 'navxt_gutener_breadcrumb' ) ) :
	/**
	 * Adds NavXt Breadcrumb 
	 *
	 * @since Gutener Medical 1.1.0
	 * @param bool $transparent_nav True for Transparent Header. 
	 *
	 */
	
	function navxt_gutener_breadcrumb( $transparent_nav = false ) { ?>
		<div class="breadcrumb-wrap">
			<?php if( $transparent_nav ){ ?>
				<div class="container">
					<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
						<?php bcn_display(); ?>
					</div>
				</div>
			<?php } else{ ?>
		        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
					<?php bcn_display(); ?>
				</div>
			<?php } ?>
		</div>
	<?php }
endif;

if( !function_exists( 'gutener_header_button' ) ){
	/**
	* Add button to header.
	* 
	* @since Gutener Medical 1.1.0
	*/
	function gutener_header_button(){
		if( !get_theme_mod( 'disable_header_button', false ) &&  get_theme_mod( 'header_button_text', '' ) ){
			$button_type = 'button-primary';
			if ( get_theme_mod( 'header_button_type', 'button-primary' ) == 'button-outline' ){
				$button_type = 'button-outline';
			}elseif ( get_theme_mod( 'header_button_type', 'button-primary' ) == 'button-text' ){
				$button_type = 'button-text';
			}

			$link_target = '';
			if( get_theme_mod( 'header_button_target', true ) ){
				$link_target = '_blank';
			} ?>
			<a href="<?php echo esc_url( get_theme_mod( 'header_button_link', '' ) ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="header-btn-one <?php echo esc_attr( $button_type ); ?>">
				<?php echo esc_html( get_theme_mod( 'header_button_text', '' ) );?>
			</a>
		<?php }
	}
}

if( !function_exists( 'gutener_has_social' ) ){
	/**
	* Check if social media icon is empty.
	* 
	* @since Gutener Medical 1.1.0
	* @return bool
	*/
	function gutener_has_social(){
		$social_defaults = array(
			array(
				'icon' 		=> '',
				'link' 		=> '',
				'new_tab' 	=> true,
			)			
		);
		$social_icons = get_theme_mod( 'social_media_links', $social_defaults );
		$has_social = false;
		if ( is_array( $social_icons ) ){
			foreach( $social_icons as $value ){
				if( !empty( $value['icon'] ) ){
					$has_social = true;
					break;
				}
			}
		}
		return $has_social;
	}
}

if( !function_exists( 'gutener_social' ) ){
	/**
	* Add social icons.
	* 
	* @since Gutener Medical 1.1.0
	*/
	function gutener_social(){
		
	    echo '<ul class="social-group">';
		    $count = 0.2;
		    $social_defaults = array(
				array(
					'icon' 		=> '',
					'link' 		=> '',
					'new_tab' 	=> true,
				)			
			);
			$social_icons = get_theme_mod( 'social_media_links', $social_defaults );
		    foreach( $social_icons as $value ){
		        if( isset( $value['new_tab'] ) && $value['new_tab'] ){
		    		$link_target = '_blank';
		    	}else{
		    		$link_target = '';
		    	}
		        if( !empty( $value['icon'] ) ){
		            echo '<li><a href="' . esc_url( $value['link'] ) . '" target="' .esc_html( $link_target ). '"><i class=" ' . esc_attr( $value['icon'] ) . '"></i></a></li>';
		            $count = $count + 0.2;
		        }
		    }
	    echo '</ul>';
	}
}

if( !function_exists( 'gutener_has_header_media' ) ){
	/**
	* Check if header media slider item is empty.
	* 
	* @since Gutener Medical 1.1.0
	* @return bool
	*/
	function gutener_has_header_media(){
		$header_slider_defaults = array(
			array(
				'slider_item' 	=> '',
			)			
		);
		$header_image_slider = get_theme_mod( 'header_image_slider', $header_slider_defaults );
		$has_header_media = false;
		if ( is_array( $header_image_slider ) ){
			foreach( $header_image_slider as $value ){
				if( !empty( $value['slider_item'] ) ){
					$has_header_media = true;
					break;
				}
			}
		}
		return $has_header_media;
	}
}

if( !function_exists( 'gutener_header_media' ) ){
	/**
	* Add header banner/slider.
	* 
	* @since Gutener Medical 1.1.0
	*/
	function gutener_header_media(){
		$header_slider_defaults = array(
			array(
				'slider_item' 	=> '',
			)			
		);
		$header_image_slider = get_theme_mod( 'header_image_slider', $header_slider_defaults ); ?>
		<div class="header-image-slider">
		    <?php foreach( $header_image_slider as $slider_item ) :
		    	if( wp_attachment_is_image( $slider_item['slider_item'] ) ){
		    		$header_image_url = wp_get_attachment_url( $slider_item['slider_item'] );
		    	}else{
		    		$header_image_url = $slider_item['slider_item'];
		    	} ?>
		    	<div class="header-slide-item" style="background-image: url( <?php echo esc_url( $header_image_url ); ?> )">
		    		<div class="slider-inner"></div>
		      </div>
		    <?php endforeach; ?>
		</div>
		<?php if( !get_theme_mod( 'disable_header_slider_arrows', false ) ) { ?>
			<ul class="slick-control">
		        <li class="header-slider-prev">
		        	<span></span>
		        </li>
		        <li class="header-slider-next">
		        	<span></span>
		        </li>
		    </ul>
		<?php }
		if ( !get_theme_mod( 'disable_header_slider_dots', false ) ){ ?>
			<div class="header-slider-dots"></div>
		<?php }
	}
}