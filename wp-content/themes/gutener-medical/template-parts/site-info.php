<?php
/**
 * Template part for displaying site info
 *
 * @package Gutener Medical
 */

?>

<div class="site-info">
	<?php echo wp_kses_post( html_entity_decode( get_theme_mod( 'footer_text', '' ) ) ); ?>
	<?php
	printf( esc_html__( 'Kassler Medical Center', 'gutener-medical' ) );
	?>

</div>
<!-- .site-info -->