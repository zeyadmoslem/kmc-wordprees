<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gutener Medical
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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'gutener-medical' ); ?></a>

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
	}
	// Header Layouts
	if( get_theme_mod( 'header_layout', 'header_two' ) == '' || get_theme_mod( 'header_layout', 'header_two' ) == 'header_one' ){ ?>
		<header id="masthead" class="site-header header-one">
			<div class="top-header">
				<?php if( !get_theme_mod( 'disable_top_header_section', false ) ){ ?>
					<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ) || ( !get_theme_mod( 'disable_contact_detail', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ) ){ ?>
						<div class="top-header-inner">
							<div class="container">
								<div class="row align-items-center">
									<div class="col-lg-7 d-none d-lg-block">
										<?php get_template_part( 'template-parts/header', 'contact' ); ?>
									</div>
									<div class="col-lg-5 d-none d-lg-block">
										<div class="header-icons">
											<?php if( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ){
												echo '<div class="social-profile">';
													gutener_social();
												echo '</div>'; 
											} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
				<?php if( !get_theme_mod( 'disable_mobile_top_header', true ) ){ ?>
					<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ) || ( !get_theme_mod( 'disable_contact_detail', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ) || !get_theme_mod( 'disable_search_icon', false ) || is_active_sidebar( 'menu-sidebar' ) ){ ?>
						<div class="alt-menu-icon d-lg-none">
							<a class="offcanvas-menu-toggler" href="#">
								<span class="icon-bar-wrap">
									<span class="icon-bar"></span>
								</span>
								<span class="iconbar-label d-lg-none"><?php echo esc_html( get_theme_mod( 'top_bar_name', 'TOP MENU' ) ); ?></span>
							</a>
						</div>
					<?php } ?>
				<?php } ?>
			</div> 
			<div class="mid-header header-image-wrap">
				<?php if( gutener_has_header_media() ){ gutener_header_media(); } ?>
				<div class="container">
					<?php get_template_part( 'template-parts/site', 'branding' ); ?>
				</div>
				<div class="overlay"></div>
			</div>
			<div class="bottom-header fixed-header">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-10 d-none d-lg-block">
							<nav id="site-navigation" class="main-navigation d-none d-lg-flex">
								<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'gutener-medical' ); ?></button>
								<?php if ( has_nav_menu( 'menu-1' ) ) :
									wp_nav_menu( 
										array(
											'container'      => '',
											'theme_location' => 'menu-1',
											'menu_id'        => 'primary-menu',
											'menu_class'     => 'menu nav-menu',
										)
									);
								?>
								<?php else :
									wp_page_menu(
										array(
											'menu_class' => 'menu-wrap',
						                    'before'     => '<ul id="primary-menu" class="menu nav-menu">',
						                    'after'      => '</ul>',
										)
									);
								?>
								<?php endif; ?>
							</nav><!-- #site-navigation -->
						</div>
						<div class="col-lg-2 d-none d-lg-block">
							<div class="header-icons">
								<!-- Search form structure -->
								<?php if( !get_theme_mod( 'disable_search_icon', false ) ): ?>
									<div id="search-form" class="header-search-wrap ">
										<button class="search-icon">
											<span class="fas fa-search"></span>
										</button>
									</div>
								<?php endif; ?>
								<?php if( !get_theme_mod( 'disable_hamburger_menu_icon', false ) && is_active_sidebar( 'menu-sidebar' ) ){ ?>
									<div class="alt-menu-icon">
										<a class="offcanvas-menu-toggler" href="#">
											<span class="icon-bar"></span>
										</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>	
				<!-- header search form -->
				<div class="header-search">
					<div class="container">
						<?php get_search_form(); ?>
						<button class="close-button">
							<span class="fas fa-times"></span>
						</button>
					</div>
				</div>
				<!-- header search form end-->
				<div class="mobile-menu-container"></div>
			</div>
			<?php get_template_part( 'template-parts/offcanvas', 'menu' ); ?>
		</header><!-- #masthead -->

	<?php } ?>

	<?php if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_two' ){ ?>
		<header id="masthead" class="site-header header-two">
			<div class="top-header">
				<?php if( !get_theme_mod( 'disable_top_header_section', false ) ){ ?>
					<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ) || ( !get_theme_mod( 'disable_contact_detail', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ) || !get_theme_mod( 'disable_search_icon', false ) || ( !get_theme_mod( 'disable_hamburger_menu_icon', false ) && is_active_sidebar( 'menu-sidebar' ) ) ){ ?>
						<div class="top-header-inner">
							<div class="container">
								<div class="row align-items-center">
									<div class="col-lg-8 d-none d-lg-block">
										<?php get_template_part( 'template-parts/header', 'contact' ); ?>
									</div>
									<div class="col-lg-4">
										<div class="header-icons">
											<?php if( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ){
												echo '<div class="social-profile d-none d-lg-inline-block">';
													gutener_social();
												echo '</div>'; 
											} ?>
											<!-- Search form structure -->
											<?php if( !get_theme_mod( 'disable_search_icon', false ) ): ?>
												<div id="search-form" class="header-search-wrap d-none d-lg-inline-block">
													<button class="search-icon">
														<span class="fas fa-search"></span>
													</button>
												</div>
											<?php endif; ?>
											<?php if( !get_theme_mod( 'disable_hamburger_menu_icon', false ) && is_active_sidebar( 'menu-sidebar' ) ){ ?>
												<div class="alt-menu-icon d-none d-lg-inline-block">
													<a class="offcanvas-menu-toggler" href="#">
														<span class="icon-bar-wrap">
															<span class="icon-bar"></span>
														</span>
					
													</a>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<!-- header search form -->
							<div class="header-search">
								<div class="container">
									<?php get_search_form(); ?>
									<button class="close-button">
										<span class="fas fa-times"></span>
									</button>
								</div>
							</div>
							<!-- header search form end-->
						</div>
					<?php } ?>
				<?php } ?>
				<?php if( !get_theme_mod( 'disable_mobile_top_header', true ) ){ ?>
					<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ) || ( !get_theme_mod( 'disable_contact_detail', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ) || !get_theme_mod( 'disable_search_icon', false ) || ( !get_theme_mod( 'disable_header_button', false ) && get_theme_mod( 'header_button_text', '' ) ) || is_active_sidebar( 'menu-sidebar' ) ){ ?>
						<div class="alt-menu-icon d-lg-none">
							<a class="offcanvas-menu-toggler" href="#">
								<span class="icon-bar-wrap">
									<span class="icon-bar"></span>
								</span>
								<span class="iconbar-label d-lg-none"><?php echo esc_html( get_theme_mod( 'top_bar_name', 'TOP MENU' ) ); ?></span>
							</a>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<?php get_template_part( 'template-parts/offcanvas', 'menu' ); ?>
			<div class="bottom-header header-image-wrap fixed-header">
				<?php if( gutener_has_header_media() ){ gutener_header_media(); } ?>
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-3">
							<?php get_template_part( 'template-parts/site', 'branding' ); ?>
						</div>
						<div class="col-lg-9">
							<div class="main-navigation-wrap">
								<nav id="site-navigation" class="main-navigation d-none d-lg-block">
									<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'gutener-medical' ); ?></button>
									<?php if ( has_nav_menu( 'menu-1' ) ) :
										wp_nav_menu( 
											array(
												'container'      => '',
												'theme_location' => 'menu-1',
												'menu_id'        => 'primary-menu',
												'menu_class'     => 'menu nav-menu',
											)
										);
									?>
									<?php else :
										wp_page_menu(
											array(
												'menu_class' => 'menu-wrap',
							                    'before'     => '<ul id="primary-menu" class="menu nav-menu">',
							                    'after'      => '</ul>',
											)
										);
									?>
									<?php endif; ?>
								</nav><!-- #site-navigation -->
								<?php if( !get_theme_mod( 'disable_header_button', false ) &&  get_theme_mod( 'header_button_text', '' ) ){
									echo '<div class="header-btn d-none d-lg-block">';
										gutener_header_button();
									echo '</div>';	
								} ?>	
							</div>
						</div>
					</div>
				</div>
				<div class="overlay"></div>
			</div>
			<div class="mobile-menu-container"></div>
		</header><!-- #masthead -->
	<?php } ?>

	<?php if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_three' ) { ?>
		<header id="masthead" class="site-header header-three">
			<div class="overlay-header">
				<div class="top-header">
					<?php if( !get_theme_mod( 'disable_top_header_section', false ) ){ ?>
						<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ) || ( !get_theme_mod( 'disable_contact_detail', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ) || !get_theme_mod( 'disable_search_icon', false ) || ( !get_theme_mod( 'disable_hamburger_menu_icon', false ) && is_active_sidebar( 'menu-sidebar' ) ) ){ ?>
							<div class="top-header-inner">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-lg-8 d-none d-lg-block">
											<?php get_template_part( 'template-parts/header', 'contact' ); ?>
										</div>
										<div class="col-lg-4">
											<div class="header-icons">
												<?php if( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ){
													echo '<div class="social-profile d-none d-lg-inline-block">';
														gutener_social();
													echo '</div>'; 
												} ?>
												<!-- Search form structure -->
												<?php if( !get_theme_mod( 'disable_search_icon', false ) ): ?>
													<div id="search-form" class="header-search-wrap d-none d-lg-inline-block">
														<button class="search-icon">
															<span class="fas fa-search"></span>
														</button>
													</div>
												<?php endif; ?>
												<?php if( !get_theme_mod( 'disable_hamburger_menu_icon', false ) && is_active_sidebar( 'menu-sidebar' ) ){ ?>
													<div class="alt-menu-icon d-none d-lg-inline-block">
														<a class="offcanvas-menu-toggler" href="#">
															<span class="icon-bar-wrap">
																<span class="icon-bar"></span>
															</span>
														</a>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<!-- header search form -->
								<div class="header-search">
									<div class="container">
										<?php get_search_form(); ?>
										<button class="close-button">
											<span class="fas fa-times"></span>
										</button>
									</div>
								</div>
								<!-- header search form end-->
							</div>
						<?php } ?>
					<?php } ?>
					<?php if( !get_theme_mod( 'disable_mobile_top_header', true ) ){ ?>
						<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && gutener_has_social() ) || ( !get_theme_mod( 'disable_contact_detail', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ) || !get_theme_mod( 'disable_search_icon', false ) || ( !get_theme_mod( 'disable_header_button', false ) && get_theme_mod( 'header_button_text', '' ) ) || is_active_sidebar( 'menu-sidebar' ) ){ ?>
							<div class="alt-menu-icon d-lg-none">
								<a class="offcanvas-menu-toggler" href="#">
									<span class="icon-bar-wrap">
										<span class="icon-bar"></span>
									</span>
									<span class="iconbar-label d-lg-none"><?php echo esc_html( get_theme_mod( 'top_bar_name', 'TOP MENU' ) ); ?></span>
								</a>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
				<div class="bottom-header header-image-wrap fixed-header">
					<?php if( gutener_has_header_media() ){ gutener_header_media(); } ?>
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-3">
								<?php get_template_part( 'template-parts/site', 'branding' ); ?>
								<div class="mobile-menu-container"></div>
							</div>
							<div class="col-lg-9 d-none d-lg-block">
								<div class="main-navigation-wrap">
									<nav id="site-navigation" class="main-navigation">
										<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'gutener-medical' ); ?></button>
										<?php if ( has_nav_menu( 'menu-1' ) ) :
											wp_nav_menu( 
												array(
													'container'      => '',
													'theme_location' => 'menu-1',
													'menu_id'        => 'primary-menu',
													'menu_class'     => 'menu nav-menu',
												)
											);
										?>
										<?php else :
											wp_page_menu(
												array(
													'menu_class' => 'menu-wrap',
								                    'before'     => '<ul id="primary-menu" class="menu nav-menu">',
								                    'after'      => '</ul>',
												)
											);
										?>
										<?php endif; ?>
									</nav><!-- #site-navigation -->
									<?php if( !get_theme_mod( 'disable_header_button', false ) &&  get_theme_mod( 'header_button_text', '' ) ){
										echo '<div class="header-btn">';
											gutener_header_button();
										echo '</div>';	
									} ?>
								</div>
							</div>
						</div>
					</div>
					<div class="overlay"></div>
				</div>
			</div>
			<?php get_template_part( 'template-parts/offcanvas', 'menu' ); ?>
		</header><!-- #masthead -->
	<?php } ?>