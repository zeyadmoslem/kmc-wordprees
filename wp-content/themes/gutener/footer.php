<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gutener
 */

?>
	<?php if( !get_theme_mod( 'disable_instagram', true ) ){
		if( get_theme_mod( 'enable_instagram_homepage', false ) && !is_home() ){
			// this condition will disable instagram section from home page only
			echo '';
		}else {
			?>
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
						* @since Gutener 1.0.0
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
		if( get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_one'){
			$footer_layout = 'site-footer-primary';
		}elseif( get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_two'){
			$footer_layout = 'site-footer-two';
		}elseif( get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_three'){
			$footer_layout = 'site-footer-three';
		}
		
		$has_footer_bg = '';
		$footer_image = get_theme_mod( 'footer_image', '' );
		if ( $footer_image || get_theme_mod( 'top_footer_background_color', '' ) ){
			$has_footer_bg = 'has-footer-bg';
		}
	?>

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
										get_template_part( 'template-parts/footer/footer-widget', 'one' );
									}elseif( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'three_columns' ){
										get_template_part( 'template-parts/footer/footer-widget', 'two' );
									}elseif( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'two_columns' ){
										get_template_part( 'template-parts/footer/footer-widget', 'three' );
									}elseif( get_theme_mod( 'top_footer_widget_columns', 'four_columns' ) == 'one_column' ){
										get_template_part( 'template-parts/footer/footer-widget', 'four' );
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				endif;
			endif;
			?>
			<?php if( !get_theme_mod( 'disable_bottom_footer', false ) ) { ?>
				<?php if( get_theme_mod( 'footer_layout', 'footer_one' ) == '' || get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_one' ){
					get_template_part( 'template-parts/footer/footer', 'one' );
				}elseif( get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_two' ){
					get_template_part( 'template-parts/footer/footer', 'two' );
				}elseif( get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_three' ){
					get_template_part( 'template-parts/footer/footer', 'three' );
				}
			} ?>
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
