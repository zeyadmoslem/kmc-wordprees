<?php
$width_control = '';
if( get_theme_mod( 'slider_width_controls', 'full' ) == 'boxed' && get_theme_mod( 'display_slider_on', 'blog-page-below-header' ) == 'blog-page-above-latest-posts' ){
	$width_control = 'boxed';
}elseif( get_theme_mod( 'slider_width_controls', 'full' ) == 'boxed' ){
	$width_control = 'container boxed';
}

$slider_layout = 'slider-layout-one';
$posts_per_page_count = get_theme_mod( 'slider_posts_number', 6 );
$slider_id = get_theme_mod( 'slider_category', '' );

$query = new WP_Query( apply_filters( 'gutener_blog_args', array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $posts_per_page_count,
	'cat'                 => $slider_id,
	'offset'              => 0,
	'ignore_sticky_posts' => 1
)));

$posts_array = $query->get_posts(); ?>

<div class="main-slider-wrap <?php echo esc_attr( $slider_layout ); ?> <?php echo esc_attr( $width_control ); ?>">
	<div class="main-slider">
		<?php
			while ( $query->have_posts() ) : $query->the_post();
			$image = get_the_post_thumbnail_url( get_the_ID(), 'gutener-1370-550' );
		?>
			<div class="slide-item">
				<div class="banner-img" style="background-image: url( <?php echo esc_url( $image ); ?> );">
					<?php
					$alignmentClass = 'text-center';
					if ( get_theme_mod( 'main_slider_content_alignment' , 'center' ) == 'left' ){
						$alignmentClass = 'text-left';
					}elseif ( get_theme_mod( 'main_slider_content_alignment' , 'center' ) == 'right' ){
						$alignmentClass = 'text-right';
					}
					?>
					<div class="slide-inner">
						<div class="banner-content <?php echo esc_attr( $alignmentClass ); ?>">
						    <div class="entry-content">
						    	<header class="entry-header">
									<?php
									if( !get_theme_mod( 'hide_slider_category', false ) ){
										gutener_entry_header();
									}
									if ( is_singular() ) :
										the_title( '<h1 class="entry-title">', '</h1>' );
									else :
										if ( !get_theme_mod( 'hide_slider_title', false ) ){
											the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
										}
									endif; 
									
									?>
								</header><!-- .entry-header -->
								<div class="entry-meta">
									<?php
										if( !get_theme_mod( 'hide_slider_date', false ) ): ?>
											<span class="posted-on">
												<a href="<?php echo esc_url( gutener_get_day_link() ); ?>" >
													<?php echo esc_html(get_the_date('M j, Y')); ?>
												</a>
											</span>
										<?php endif; 
										if( !get_theme_mod( 'hide_slider_author', false ) ): ?>
											<span class="byline">
												<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
													<?php echo get_the_author(); ?>
												</a>
											</span>
										<?php endif; 
										if( !get_theme_mod( 'hide_slider_comment', false ) ):
											echo '<span class="comments-link">';
											comments_popup_link(
												sprintf(
													wp_kses(
														/* translators: %s: post title */
														__( 'Comment<span class="screen-reader-text"> on %s</span>', 'gutener' ),
														array(
															'span' => array(
																'class' => array(),
															),
														)
													),
													get_the_title()
												)
											);
											echo '</span>';
										endif;
									?>
						        </div><!-- .entry-meta -->
								
								<?php if ( !get_theme_mod( 'hide_slider_excerpt', false ) || !get_theme_mod( 'hide_slider_button', true ) ){ ?>
						        	<div class="entry-text">
										<?php if ( !get_theme_mod( 'hide_slider_excerpt', false ) ){
											$excerpt_length = get_theme_mod( 'slider_excerpt_length', 25 );
											gutener_excerpt( $excerpt_length , true );
										}

										if ( !get_theme_mod( 'hide_slider_button', true ) && get_theme_mod( 'slider_button_text', '' ) ){
											$button_type = 'button-outline';
											if ( get_theme_mod( 'slider_button_type', 'button-outline' ) == 'button-primary' ){
												$button_type = 'button-primary';
											}elseif ( get_theme_mod( 'slider_button_type', 'button-outline' ) == 'button-text' ){
												$button_type = 'button-text';
											} ?>
											<div class="button-container">
												<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( $button_type ); ?>">
													<?php
														$slider_button_text = get_theme_mod( 'slider_button_text', '' );
														echo esc_html( $slider_button_text ? $slider_button_text : "" );
													?>
												</a>
											</div>
										<?php } ?>
									</div>
								<?php } ?>
							</div><!-- .entry-content -->
						</div>
					</div>
					<div class="overlay"></div>
				</div>
			</div>
		<?php
		endwhile; 
		wp_reset_postdata();
		?>
	</div>
	<?php if( !get_theme_mod( 'disable_slider_arrows', false ) ) { ?>
		<ul class="slick-control">
	        <li class="main-slider-prev">
	        	<span></span>
	        </li>
	        <li class="main-slider-next">
	        	<span></span>
	        </li>
	    </ul>
	<?php } ?>
	<?php if ( !get_theme_mod( 'disable_slider_dots', false ) ){ ?>
		<div class="main-slider-dots"></div>
	<?php } ?>
</div>