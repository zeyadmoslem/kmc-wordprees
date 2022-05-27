<?php
/** 
* Template for Off canvas Menu
* @since Gutener Medical 1.1.0
*/
?>
<div id="offcanvas-menu" class="offcanvas-menu-wrap">
	<div class="close-offcanvas-menu">
		<button class="fas fa-times"></button>
	</div>
	<div class="offcanvas-menu-inner">
		<div class="offcanvas-menu-content">
			<!-- header search field -->
			<?php if( !get_theme_mod( 'disable_search_icon', false ) && !get_theme_mod( 'disable_mobile_search_icon', false ) ) { ?>
				<div class="header-search-wrap d-lg-none">
			 		<?php get_search_form();  ?>
				</div>
			<?php } ?>
			<!-- header callback button -->
			<?php if( !get_theme_mod( 'disable_header_button', false ) && !get_theme_mod( 'disable_mobile_header_buttons', false ) && get_theme_mod( 'header_button_text', '' ) && get_theme_mod( 'header_layout', 'header_two' ) != 'header_one' ){
				echo '<div class="header-btn-wrap d-lg-none">';
					echo '<div class="header-btn">';
						gutener_header_button();
					echo '</div>';	
				echo '</div>';	
			} ?>
		    <!-- header contact details -->
		    <?php if ( !get_theme_mod( 'disable_contact_detail', false ) && !get_theme_mod( 'disable_mobile_contact_details', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ){ ?>
				<div class="d-lg-none">
					<?php get_template_part( 'template-parts/header', 'contact' ); ?>
				</div>
			<?php } ?>
			<!-- header social icons -->
			<?php if( !get_theme_mod( 'disable_header_social_links', false ) && !get_theme_mod( 'disable_mobile_social_icons_header', false ) && gutener_has_social() ){
				echo '<div class="social-profile d-lg-none">';
					gutener_social();
				echo '</div>'; 
			} ?>			
		</div>
		<!-- header sidebar -->
		<?php if( is_active_sidebar( 'menu-sidebar' ) ){ ?>
			<div class="header-sidebar">
				<?php dynamic_sidebar( 'menu-sidebar' ); ?>
			</div>
		<?php } ?>	
	</div>
</div>