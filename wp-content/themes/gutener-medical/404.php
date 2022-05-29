<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>
	<?php
		$error404_image = get_theme_mod( 'error404_image', '' );
		if( !$error404_image ){
			$error404_image = get_theme_file_uri( '/assets/images/gutener-360-200.jpg' );
		}
	?>
	<div id="content" class="site-content">
		<div class="container">
			<section class="error-404 not-found">
				<div class="inner-content">
					<header class="page-header">
						<h1 class="title-404" style="background-image: url( <?php echo esc_url( $error404_image ); ?> );"><?php echo esc_html__( '404', 'gutener' ); ?></h1>
						<h2 class="page-title"><?php echo esc_html__( 'Hoppla! diese Seite kann nicht gefunden werden.', 'gutener' ); ?></h2>
						<p><?php echo esc_html__( 'Anscheinend wurde an dieser Stelle nichts gefunden. Vielleicht versuchen Sie einen der Links unten oder eine Suche?', 'gutener' ); ?></p>
					</header><!-- .page-header -->
					<div class="error-404-form">
						<?php get_search_form(); ?>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div><!-- #container -->
	</div><!-- #content -->
<?php
get_footer();
