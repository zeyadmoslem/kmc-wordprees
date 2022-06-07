<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Gutener
 */

get_header();
?>
<?php 
if( !get_theme_mod( 'disable_transparent_header_post', true ) && get_theme_mod( 'header_layout', 'header_one' ) == 'header_three' ){
	gutener_post_transparent_banner();
} ?>
<div id="content" class="site-content">
	<div class="container">
		<section class="wrap-detail-page">
			<?php if( get_theme_mod( 'disable_transparent_header_post', true ) || get_theme_mod( 'header_layout', 'header_one' ) != 'header_three' ){
				if( get_theme_mod( 'post_title_position', 'below_feature_image' ) == 'above_feature_image' ){
					gutener_single_page_title();
				}  
				if ( get_theme_mod( 'breadcrumbs_controls', 'disable_in_all_pages' ) == 'disable_in_all_pages' || get_theme_mod( 'breadcrumbs_controls', 'disable_in_all_pages' ) == 'show_in_all_page_post' ){ 
					if( function_exists( 'bcn_display' ) && !is_front_page() ){
						navxt_gutener_breadcrumb( false );
					}else{
						gutener_breadcrumb_wrap( false );
					}
				}
			} ?>
			<div class="row">
				<?php
					$sidebarClass = 'col-lg-8';
					$sidebarColumnClass = 'col-lg-4';
					if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){
						if( !is_active_sidebar( 'right-sidebar') ){
							$sidebarClass = "col-12";
						}	
					}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){
						if( !is_active_sidebar( 'left-sidebar') ){
							$sidebarClass = "col-12";
						}	
					}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
						$sidebarClass = 'col-lg-6';
						$sidebarColumnClass = 'col-lg-3';
						if( !is_active_sidebar( 'left-sidebar') && !is_active_sidebar( 'right-sidebar') ){
							$sidebarClass = "col-12";
						}
					}
					if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'no-sidebar' || get_theme_mod( 'disable_sidebar_single_post', false ) ){
						$sidebarClass = 'col-12';
					}
					if( !get_theme_mod( 'disable_sidebar_single_post', false ) ){
						if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){ 
							if( is_active_sidebar( 'left-sidebar') ){ ?>
								<div id="secondary" class="sidebar left-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
									<?php dynamic_sidebar( 'left-sidebar' ); ?>
								</div>
							<?php }
							}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
								if( is_active_sidebar( 'left-sidebar') || is_active_sidebar( 'right-sidebar') ){ ?>
									<div id="secondary" class="sidebar left-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
										<?php dynamic_sidebar( 'left-sidebar' ); ?>
									</div>
								<?php
								}
							}
					} ?>
				<div id="primary" class="content-area <?php echo esc_attr( $sidebarClass ); ?>">
					<main id="main" class="site-main">
						<?php if( get_theme_mod( 'disable_transparent_header_post', true ) || get_theme_mod( 'header_layout', 'header_one' ) != 'header_three' ){
							if( has_post_thumbnail() ){
								if( get_theme_mod( 'single_feature_image', 'show_in_all_pages' ) == 'show_in_all_pages' ){ ?>
								    <figure class="feature-image single-feature-image">
		    						    <?php gutener_image_size( 'gutener-1370-550' ); ?>
		    						</figure>
								<?php }else{
									// will disable in all pages
									echo '';
								}
							}
							if( get_theme_mod( 'post_title_position', 'below_feature_image' ) == 'below_feature_image' ){
								gutener_single_page_title();
							}
						} ?>
						<?php
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content', 'single' );
								
								the_post_navigation();

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
						?>
					</main><!-- #main -->
				</div><!-- #primary -->
				<?php
					if( !get_theme_mod( 'disable_sidebar_single_post', false ) ){
						if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){ 
							if( is_active_sidebar( 'right-sidebar') ){ ?>
								<div id="secondary" class="sidebar right-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
									<?php dynamic_sidebar( 'right-sidebar' ); ?>
								</div>
							<?php }
						}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
							if( is_active_sidebar( 'left-sidebar') || is_active_sidebar( 'right-sidebar') ){ ?>
								<div id="secondary-sidebar" class="sidebar right-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
									<?php dynamic_sidebar( 'right-sidebar' ); ?>
								</div>
							<?php
							}
						}
					}
				?>
			</div>
		</section>

		<!-- Related Posts -->
		<?php if ( !get_theme_mod( 'hide_related_posts', false ) ){ ?>
			<section class="section-ralated-post">
				<div class="section-title-wrap">
					<h2 class="section-title">
						<?php echo esc_html(get_theme_mod( 'related_posts_title', esc_html__( 'Diese könnten Ihnen auch gefallen', 'gutener' ) )); ?>
					</h2>
				</div>
				<div class="wrap-ralated-posts">
					<div class="row">
						<?php
							# Print related posts randomly.
						    get_template_part( 'template-parts/content', 'related-posts' );
						?>
					</div>
				</div>
			</section>
		<?php } ?>
	</div><!-- #container -->
</div><!-- #content -->
<?php
get_footer();
