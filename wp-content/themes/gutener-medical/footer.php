<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gutener Medical
 */

?>
	<?php if( !get_theme_mod( 'disable_instagram', true ) ){
		if( get_theme_mod( 'enable_instagram_homepage', false ) && !is_home() ){
			// this condition will disable instagram section from home page only
			echo '';
		}else{ ?>
			<section class="section-instagram-wrapper">
				<div class="container">
					<?php if( ( !get_theme_mod( 'disable_instagram_section_title', true ) && get_theme_mod( 'instagram_section_title', '' ) ) || ( !get_theme_mod( 'disable_instagram_section_description', true ) && get_theme_mod( 'instagram_section_description', '' ) ) ){
						$instagram_section_title_desc_alignment = get_theme_mod( 'instagram_section_title_desc_alignment', 'text-left' ); ?>
						<div class="section-title-wrap <?php echo esc_attr( $instagram_section_title_desc_alignment ); ?> ">
							<?php if( !get_theme_mod( 'disable_instagram_section_title', true ) && get_theme_mod( 'instagram_section_title', '' ) ) { ?>
								<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'instagram_section_title', '' ) ); ?></h2>
							<?php } 
							if( !get_theme_mod( 'disable_instagram_section_description', true ) && get_theme_mod( 'instagram_section_description', '' ) ){ ?>
								<p><?php echo esc_html( get_theme_mod( 'instagram_section_description', '' ) ); ?></p>
							<?php } ?>
						</div>
					<?php } ?>
					<?php 
						/**
						* Prints Instagram
						* 
						* @since Gutener Medical 1.0.0
						*/
						if( !get_theme_mod( 'disable_instagram', true ) ){
							echo do_shortcode( get_theme_mod( 'insta_shortcode', '' ) );
						}
					?>
				</div>
			</section>	
		<?php
		}
	} ?>
	<?php
	$footer_layout = '';
	if( get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_one'){
		$footer_layout = 'site-footer-primary';
	}elseif( get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_two'){
		$footer_layout = 'site-footer-two';
	}elseif( get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_three'){
		$footer_layout = 'site-footer-three';
	}
	
	$has_footer_bg = '';
	$footer_image = get_theme_mod( 'footer_image', '' );
	if ( $footer_image || get_theme_mod( 'top_footer_background_color', '' ) ){
		$has_footer_bg = 'has-footer-bg';
	} ?>

	<footer id="colophon" class="site-footer <?php echo esc_attr( $footer_layout . ' ' . $has_footer_bg ) ?>">
		<div class="site-footer-inner" style="background-image: url(<?php echo esc_url( $footer_image ) ?>">
			<?php if( !get_theme_mod( 'disable_footer_widget', false ) ):
				if( gutener_is_active_footer_sidebar() ): ?>
					<div class="top-footer">
						<div class="wrap-footer-sidebar">
							<div class="container">
								<div class="footer-widget-wrap">
									<div class="row">
										<?php if( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == '' || get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'four_columns' ){
											if ( is_active_sidebar( 'footer-sidebar-1' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-1' );
												echo '</div>';
											endif;
											if ( is_active_sidebar( 'footer-sidebar-2' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-2' );
												echo '</div>';
											endif;
											if ( is_active_sidebar( 'footer-sidebar-3' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-3' );
												echo '</div>';
											endif;
											if ( is_active_sidebar( 'footer-sidebar-4' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-4' );
												echo '</div>';
											endif;
										}elseif( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'three_columns' ){
											if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-4' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-4 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-1' );
													dynamic_sidebar( 'footer-sidebar-4' );
												echo '</div>';
											endif;
											if ( is_active_sidebar( 'footer-sidebar-2' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-4 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-2' );
												echo '</div>';
											endif;
											if ( is_active_sidebar( 'footer-sidebar-3' ) ) :
												echo '<div class="col-sm-6 col-12 col-lg-4 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-3' );
												echo '</div>';
											endif;
										}elseif( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'two_columns' ){
											if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-3' ) ) :
												echo '<div class="col-sm-6 col-12 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-1' );
													dynamic_sidebar( 'footer-sidebar-3' );
												echo '</div>';
											endif;
											if ( is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-4' ) ) :
												echo '<div class="col-sm-6 col-12 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-2' );
													dynamic_sidebar( 'footer-sidebar-4' );
												echo '</div>';
											endif;
										}elseif( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'one_column' ){
											if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' ) || is_active_sidebar( 'footer-sidebar-4' ) ) :
												echo '<div class="col-12 footer-widget-item">';
													dynamic_sidebar( 'footer-sidebar-1' );
													dynamic_sidebar( 'footer-sidebar-2' );
													dynamic_sidebar( 'footer-sidebar-3' );
													dynamic_sidebar( 'footer-sidebar-4' );
												echo '</div>';
											endif;
										} ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif;
			endif; ?>
			<?php if( !get_theme_mod( 'disable_bottom_footer', false ) ) { ?>
				<?php if( get_theme_mod( 'footer_layout', 'footer_two' ) == '' || get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_one' ){ ?>
					<div class="bottom-footer">
						<div class="container">
							<!-- social links area -->
							<?php if( !get_theme_mod( 'disable_footer_social_links', false ) && gutener_has_social() ){
								echo '<div class="social-profile">';
									gutener_social();
								echo '</div>'; 
							} ?> <!-- social links area -->
								<?php get_template_part( 'template-parts/site', 'info' ); ?>
								<?php if ( has_nav_menu( 'menu-2' ) && !get_theme_mod( 'disable_footer_menu', false )){ ?>
									<div class="footer-menu"><!-- Footer Menu-->
										<?php
										wp_nav_menu( array(
											'theme_location' => 'menu-2',
											'menu_id'        => 'footer-menu',
											'depth'          => 1,
										) );
										?>
									</div><!-- footer Menu-->
								<?php } ?>
								<?php gutener_footer_image(); ?>
						</div> 
					</div>
				<?php } ?>
				<?php if( get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_two' ){ ?>
					<div class="bottom-footer">
						<div class="container">
							<!-- social links area -->
							<?php if( !get_theme_mod( 'disable_footer_social_links', false ) && gutener_has_social() ){
								echo '<div class="social-profile">';
									gutener_social();
								echo '</div>'; 
							} ?> <!-- social links area -->
							<?php if ( has_nav_menu( 'menu-2' ) && !get_theme_mod( 'disable_footer_menu', false ) ){ ?>
								<div class="footer-menu"><!-- Footer Menu-->
									<?php
									wp_nav_menu( array(
										'theme_location' => 'menu-2',
										'menu_id'        => 'footer-menu',
										'depth'          => 1,
									) );
									?>
								</div><!-- footer Menu-->
							<?php }
							get_template_part( 'template-parts/site', 'info' ); ?>
						</div>
					</div>
				<?php } ?>
				<?php if( get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_three' ){ ?>
					<div class="bottom-footer">
						<div class="container">
							<div class="row align-items-center">
								<!-- social links area -->
								<?php 
								$socialEmptyClass = 'col-lg-12 text-center';
								if( !get_theme_mod( 'disable_footer_social_links', false ) && gutener_has_social() ){
									$socialEmptyClass = 'col-lg-8';
									echo '<div class="col-lg-4">';
										echo '<div class="social-profile">';
											gutener_social();
										echo '</div>'; 
									echo '</div>'; 
								} ?> <!-- social links area --> 
								<div class="<?php echo esc_attr( $socialEmptyClass ) ?>">
									<div class="footer-desc-wrap">
										<?php get_template_part( 'template-parts/site', 'info' ); ?>
										<?php if ( has_nav_menu( 'menu-2' ) && !get_theme_mod( 'disable_footer_menu', false )){ ?>
											<div class="footer-menu"><!-- Footer Menu-->
												<?php
												wp_nav_menu( array(
													'theme_location' => 'menu-2',
													'menu_id'        => 'footer-menu',
													'depth'          => 1,
												) );
												?>
											</div><!-- footer Menu-->
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } 
				}
			?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<div id="back-to-top">
    <a href="javascript:void(0)"><i class="fa fa-angle-up"></i></a>
</div>
<!-- #back-to-top -->

</body>
</html>
