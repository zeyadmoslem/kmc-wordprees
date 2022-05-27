<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gutener
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php if( !get_theme_mod( 'disable_preloader', false )): ?>
	<div id="site-preloader">
		<div class="preloader-content">
			<?php
				$src = '';
				if( get_theme_mod( 'preloader_animation', 'animation_one' ) == 'animation_one' ){
					$src = get_template_directory_uri() . '/assets/images/preloader1.gif';
				}elseif( get_theme_mod( 'preloader_animation', 'animation_one' ) == 'animation_two' ){
					$src = get_template_directory_uri() . '/assets/images/preloader2.gif';
				}elseif( get_theme_mod( 'preloader_animation', 'animation_one' ) == 'animation_three' ){
					$src = get_template_directory_uri() . '/assets/images/preloader3.gif';
				}elseif( get_theme_mod( 'preloader_animation', 'animation_one' ) == 'animation_four' ){
					$src = get_template_directory_uri() . '/assets/images/preloader4.gif';
				}elseif( get_theme_mod( 'preloader_animation', 'animation_one' ) == 'animation_five' ){
					$src = get_template_directory_uri() . '/assets/images/preloader5.gif';
				}elseif( get_theme_mod( 'preloader_animation', 'animation_one' ) == 'animation_site_logo' ){
					$src = gutener_get_custom_logo_url();
				}

				echo apply_filters( 'gutener_preloader',
				sprintf( '<img src="%s" alt="%s">',
					$src, ''
				)); 
			?>
		</div>
	</div>
<?php endif; ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'gutener' ); ?></a>

	<?php if( !get_theme_mod( 'disable_notification_bar', true ) ){
		if ( !empty( get_theme_mod( 'notification_bar_title', '' ) ) || ( !get_theme_mod( 'disable_notification_bar_button_one', false ) && !empty( get_theme_mod( 'notification_bar_button_text', '' ) ) ) ) {
			$link_target = '';
			if( get_theme_mod( 'notification_bar_button_target', true ) ){
				$link_target = '_blank';
			}else {
				$link_target = '';
			}
			if( !get_theme_mod( 'disable_sticky_notification_bar', false ) ){
				$sticky_class = 'sticky';
			}else {
				$sticky_class = '';
			}

			$button_type = 'button-primary';
			if ( get_theme_mod( 'notification_bar_button_type', 'button-primary' ) == 'button-outline' ){
				$button_type = 'button-outline';
			}elseif ( get_theme_mod( 'notification_bar_button_type', 'button-primary' ) == 'button-text' ){
				$button_type = 'button-text';
			} ?>
			<div class="notification-bar mobile-sticky <?php echo esc_html( $sticky_class ); ?>">
				<div class="container">
					<div class="notification-wrap">
						<header class="notification-content">
							<span><?php echo esc_html(get_theme_mod( 'notification_bar_title', '' ));?></span>
						</header>
						<?php if ( !get_theme_mod( 'disable_notification_bar_button_one', false ) && !empty( get_theme_mod( 'notification_bar_button_text', '' ) ) ) { ?>
							<div class="button-container">
								<a href="<?php echo esc_url( get_theme_mod( 'notification_bar_button_link', '' )); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="<?php echo esc_attr( $button_type ); ?>">
									<?php echo esc_html( get_theme_mod( 'notification_bar_button_text', '' ) );?>
								</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }
	} ?>

	<?php if( get_theme_mod( 'header_layout', 'header_one' ) == '' || get_theme_mod( 'header_layout', 'header_one' ) == 'header_one' ){
		get_template_part( 'template-parts/header/header', 'one' );
	}elseif( get_theme_mod( 'header_layout', 'header_one' ) == 'header_two' ){
		get_template_part( 'template-parts/header/header', 'two' );
	}elseif( get_theme_mod( 'header_layout', 'header_one' ) == 'header_three' ) {
		get_template_part( 'template-parts/header/header', 'three' );
	} ?>