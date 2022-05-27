<?php
/**
 * The template for displaying archived woocommerce products
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @package Gutener
 */
get_header(); 
?>
<div id="content" class="site-content">
	<div class="container">
		<section class="wrap-detail-page ">
				<h1 class="page-title">
					<?php if( !gutener_wooCom_is_product_page() || !get_theme_mod( 'disable_single_product_title', false ) ){
						woocommerce_page_title();
					} ?>
				</h1>
				<?php
				if( !gutener_wooCom_is_product_page() ){
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
					$getSidebarClass = gutener_get_sidebar_class();
					$sidebarClass = 'col-12';
					if( !gutener_wooCom_is_product_page() ){
						$sidebarClass = $getSidebarClass[ 'sidebarClass' ];
						gutener_woo_product_detail_left_sidebar( $getSidebarClass[ 'sidebarColumnClass' ] );
					} ?>
					
					<div id="primary" class="content-area <?php echo esc_attr( $sidebarClass ); ?>">
						<main id="main" class="site-main post-detail-content woocommerce-products" role="main">
							<?php if ( have_posts() ) :
								woocommerce_content();
							endif;
							?>
						</main><!-- #main -->
					</div><!-- #primary -->
					<?php
					if( !gutener_wooCom_is_product_page() ){
						gutener_woo_product_detail_right_sidebar( $getSidebarClass[ 'sidebarColumnClass' ] );
					} ?>
				</div>
		</section>
	</div><!-- #container -->
</div><!-- #content -->
<?php
get_footer();
