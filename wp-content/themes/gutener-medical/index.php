<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gutener Medical
 */

get_header();
?>
	<?php
	if( is_home() && !get_theme_mod( 'disable_main_slider', false ) ){
		if ( get_theme_mod( 'main_slider_controls', 'slider' ) == 'slider' ){
			if ( get_theme_mod( 'display_slider_on', 'blog-page-below-header' ) == 'blog-page-below-header' || get_theme_mod( 'display_slider_on', 'blog-page-below-header' ) == 'front-blog-page-below-header' ) { ?>
				<section class="section-banner">
					<?php 
						get_template_part( 'template-parts/slider/slider', '' ); 
					?>
				</section>
			<?php }
		}elseif( get_theme_mod( 'main_slider_controls', 'slider' ) == 'banner' ){
			if ( get_theme_mod( 'display_banner_on', 'blog-page-below-header' ) == 'blog-page-below-header' || get_theme_mod( 'display_banner_on', 'blog-page-below-header' ) == 'front-blog-page-below-header' ) {
					gutener_banner();
			}
		}
	} ?>
	<div id="content" class="site-content">
		<div class="container">
			<?php
			//Highlighted Posts Section
			if( get_theme_mod( 'highlight_posts_section_layouts', 'highlighted_one' ) == '' || get_theme_mod( 'highlight_posts_section_layouts', 'highlighted_one' ) == 'highlighted_one' ){

				$posts_per_page_count = get_theme_mod( 'highlight_posts_posts_number', 6 );
				$highlight_posts_id = get_theme_mod( 'highlight_posts_category', 'Uncategorized' );

				$query = new WP_Query( apply_filters( 'gutener_highlight_args', array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => $posts_per_page_count,
					'cat'                 => $highlight_posts_id,
					'offset'              => 0,
					'ignore_sticky_posts' => 1
				)));

				$posts_array = $query->get_posts();
				$show_highlight_posts = count( $posts_array ) > 0 && is_home();

				if( !get_theme_mod( 'disable_highlight_posts_section', false ) && $show_highlight_posts ){ ?>
					<section class="section-highlight-posts-area highlight-posts-layout-one">
						<?php if( ( !get_theme_mod( 'disable_highlight_posts_section_title', false ) && get_theme_mod( 'highlight_posts_section_title', '' ) ) || ( !get_theme_mod( 'disable_highlight_posts_section_description', true ) && get_theme_mod( 'highlight_posts_section_description', '' ) ) ){ ?>
							<div class="section-title-wrap <?php echo esc_attr( get_theme_mod( 'highlight_posts_section_title_desc_alignment', 'text-left' ) ); ?> ">
								<?php if( !get_theme_mod( 'disable_highlight_posts_section_title', false ) && get_theme_mod( 'highlight_posts_section_title', '' ) ) { ?>
									<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'highlight_posts_section_title', '' ) ); ?></h2>
								<?php } 
								if(  !get_theme_mod( 'disable_highlight_posts_section_description', true ) && get_theme_mod( 'highlight_posts_section_description', '' ) ){ ?>
									<p><?php echo esc_html( get_theme_mod( 'highlight_posts_section_description', '' ) ); ?></p>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="content-wrap">
							<div class="row">
							<?php

								while ( $query->have_posts() ) : $query->the_post();
								$image = get_the_post_thumbnail_url( get_the_ID(), 'gutener-420-300' );

								$columns_class = '';
								if( get_theme_mod( 'highlight_posts_columns', 'four_columns' ) == 'one_column' ){
									$columns_class = 'col-md-12';
								}elseif( get_theme_mod( 'highlight_posts_columns', 'four_columns' ) == 'two_columns' ){
									$columns_class = 'col-md-6';
								}elseif( get_theme_mod( 'highlight_posts_columns', 'four_columns' ) == 'three_columns' ){
									$columns_class = 'col-md-4';
								}elseif( get_theme_mod( 'highlight_posts_columns', 'four_columns' ) == 'four_columns' ){
									$columns_class = 'col-md-3';
								}
								?>
									<div class="<?php echo esc_attr( $columns_class ); ?>">
										<article class="post highlight-posts-content-wrap <?php echo esc_attr( get_theme_mod( 'highlight_posts_text_alignment', 'text-center' ) ); ?>">
											<div class="highlight-posts-image" style="background-image: url( <?php echo esc_url( $image ); ?> );">
												<div class="highlight-posts-content">
													<?php if( 'post' == get_post_type() ): 
														$categories_list = get_the_category_list( ' ' );
														if( $categories_list && !get_theme_mod( 'hide_highlight_posts_category', false ) ):
														printf( '<span class="cat-links">' . '%1$s' . '</span>', $categories_list );
													endif; endif; ?>
													<?php 
														if( !get_theme_mod( 'disable_highlight_posts_title', false ) ){
															?>
															<h3 class="highlight-posts-title">
																<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
															</h3>
															<?php
														}
													?>
													<div class="entry-meta">
														<?php
															if( !get_theme_mod( 'hide_highlight_posts_date', false ) ): ?>
																<span class="posted-on">
																	<a href="<?php echo esc_url( gutener_get_day_link() ); ?>" >
																		<?php echo esc_html(get_the_date('M j, Y')); ?>
																	</a>
																</span>
															<?php endif; 
															if( !get_theme_mod( 'hide_highlight_posts_author', false ) ): ?>
																<span class="byline">
																	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
																		<?php echo get_the_author(); ?>
																	</a>
																</span>
															<?php endif; 
															if( !get_theme_mod( 'hide_highlight_posts_comment', false ) ): ?>
																<span class="comments-link">
																	<a href="<?php comments_link(); ?>">
																		<?php echo absint( wp_count_comments( get_the_ID() )->approved ); ?>
																	</a>
																</span>
															<?php endif; ?>
													</div>
												</div>
											</div>
										</article>
									</div>
								<?php
								endwhile; 
								wp_reset_postdata();
							?>
							</div>
						</div>
					</section>
				<?php } } ?>

			<!-- Latest Posts Section -->
			<?php 
				$latest_posts_category = get_theme_mod( 'latest_posts_category', '' );
				$query = new WP_Query( apply_filters( 'gutener_blog_args', array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'cat'                 => $latest_posts_category,
					'paged'          	  => get_query_var( 'paged', 1 ), 
				)));
				$posts_array = $query->get_posts();
				$show_latest_posts = count( $posts_array ) > 0;
				if( !get_theme_mod( 'disable_latest_posts_section', false ) && $show_latest_posts ){
					$latest_title_desc_align = get_theme_mod( 'latest_posts_section_title_desc_alignment', 'left' );
				if ( $latest_title_desc_align == 'left' ){
					$latest_title_desc_align = 'text-left';
				}else if ( $latest_title_desc_align == 'center' ){
					$latest_title_desc_align = 'text-center';
				}else{
					$latest_title_desc_align = 'text-right';
				} ?>
				<section class="section-post-area">
					<div class="row">
						<?php
							$sidebarClass = 'col-lg-8';
							$sidebarColumnClass = 'col-lg-4';
							$masonry_class = '';

							if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
								$masonry_class = 'masonry-wrapper';
							}
							if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid' ){
								$layout_class = 'grid-post-wrap';
							}elseif( get_theme_mod( 'archive_post_layout', 'list' ) == 'single' ){
								$layout_class = 'single-post';
							}
							if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									if( !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-12";
									}	
								}else{
									if( !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-lg-8 offset-lg-2";
									}
								}
							}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									if( !is_active_sidebar( 'left-sidebar') ){
										$sidebarClass = "col-12";
									}	
								}else{
									if( !is_active_sidebar( 'left-sidebar') ){
										$sidebarClass = "col-lg-8 offset-lg-2";
									}
								}
							}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
								$sidebarClass = 'col-lg-6';
								$sidebarColumnClass = 'col-lg-3';
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									if( !is_active_sidebar( 'left-sidebar') && !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-12";
									}	
								}else{
									if(!is_active_sidebar( 'left-sidebar') && !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-lg-8 offset-lg-2";
									}
								}
							}
							if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'no-sidebar' || get_theme_mod( 'disable_sidebar_blog_page', false ) ){
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									$sidebarClass = "col-12";	
								}else{
									$sidebarClass = 'col-lg-8 offset-lg-2';
								}
							}
							if( !get_theme_mod( 'disable_sidebar_blog_page', false ) ){
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
							<?php if( is_home() && !get_theme_mod( 'disable_main_slider', false ) ){
								if ( get_theme_mod( 'main_slider_controls', 'slider' ) == 'slider' ){
									if ( get_theme_mod( 'display_slider_on', 'blog-page-below-header' ) == 'blog-page-above-latest-posts' ) { ?>
										<section class="section-banner">
											<?php 
												get_template_part( 'template-parts/slider/slider', '' ); 
											?>
										</section>
									<?php }
								}elseif( get_theme_mod( 'main_slider_controls', 'slider' ) == 'banner' ){
									if ( get_theme_mod( 'display_banner_on', 'blog-page-below-header' ) == 'blog-page-above-latest-posts' ) { 
											gutener_banner();
									}
								}
							} ?>
							<?php if( ( !get_theme_mod( 'disable_latest_posts_section_title', true ) && get_theme_mod( 'latest_posts_section_title', '' ) ) || ( !get_theme_mod( 'disable_latest_posts_section_description', true ) && get_theme_mod( 'latest_posts_section_description', '' ) ) ){ ?>
								<div class="section-title-wrap <?php echo esc_attr( $latest_title_desc_align ); ?>">
									<?php if( !get_theme_mod( 'disable_latest_posts_section_title', true ) && get_theme_mod( 'latest_posts_section_title', '' ) ){ ?>
										<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'latest_posts_section_title', '' ) ); ?></h2>
									<?php } 
									if( !get_theme_mod( 'disable_latest_posts_section_description', true ) && get_theme_mod( 'latest_posts_section_description', '' ) ){ ?>
										<p><?php echo esc_html( get_theme_mod( 'latest_posts_section_description', '' ) ); ?></p>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="row <?php echo esc_attr( $masonry_class ); ?>">
							<?php
							if ( $query->have_posts() ) :

								if ( is_home() && !is_front_page() ) :
									?>
									<header>
										<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
									</header>
									<?php
								endif;

								/* Start the Loop */
								while ( $query->have_posts() ) :
									$query->the_post();

									/*
									 * Include the Post-Type-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', get_post_type() );

								endwhile;

							elseif ( !is_sticky() && ! $query->have_posts() ):
								get_template_part( 'template-parts/content', 'none' );
							endif;
							?>
							</div><!-- #main -->
							<?php
								if( !get_theme_mod( 'disable_pagination', false ) ):
									the_posts_pagination( array(
										'total'        => $query->max_num_pages,
										'next_text' => '<span>'.esc_html__( 'Next', 'gutener-medical' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'gutener-medical' ) . '</span>',
										'prev_text' => '<span>'.esc_html__( 'Prev', 'gutener-medical' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'gutener-medical' ) . '</span>',
										'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'gutener-medical' ) . ' </span>',
									));
								endif;
								wp_reset_postdata();
							?>
						</div><!-- #primary -->
						<?php
							if( !get_theme_mod( 'disable_sidebar_blog_page', false ) ){
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
			<?php } ?>

			<?php 
			//Featured Posts Section
			if( get_theme_mod( 'feature_posts_section_layouts', 'feature_one' ) == '' || get_theme_mod( 'feature_posts_section_layouts', 'feature_one' ) == 'feature_one' ){ 
				$posts_per_page_count = get_theme_mod( 'feature_posts_posts_number', 6 );
				$feature_posts_id = get_theme_mod( 'feature_posts_category', 'Uncategorized' );

				$query = new WP_Query( apply_filters( 'gutener_feature_args', array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => $posts_per_page_count,
					'cat'                 => $feature_posts_id,
					'offset'              => 0,
					'ignore_sticky_posts' => 1
				)));

				$posts_array = $query->get_posts();
				$show_feature_posts = count( $posts_array ) > 0 && is_home();

				if( $show_feature_posts && !get_theme_mod( 'disable_feature_posts_section', false ) ){ ?>
					<section class="section-feature-post">
						<div class="section-feature-inner">
							<?php if( ( !get_theme_mod( 'disable_feature_posts_section_title', false ) && get_theme_mod( 'feature_posts_section_title', '' ) ) || ( !get_theme_mod( 'disable_feature_posts_section_description', true ) && get_theme_mod( 'feature_posts_section_description', '' ) ) ){ ?>
								<div class="section-title-wrap <?php echo esc_attr( get_theme_mod( 'feature_posts_section_title_desc_alignment', 'text-left' ) ); ?>">
									<?php if( !get_theme_mod( 'disable_feature_posts_section_title', false ) && get_theme_mod( 'feature_posts_section_title', '' ) ){ ?>
										<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'feature_posts_section_title', '' ) ); ?></h2>
									<?php }
									if( !get_theme_mod( 'disable_feature_posts_section_description', true ) && get_theme_mod( 'feature_posts_section_description', '' ) ){ ?>
										<p><?php echo esc_html( get_theme_mod( 'feature_posts_section_description', '' ) ); ?></p>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="feature-post-slider">
								<?php
									while ( $query->have_posts() ) : $query->the_post();
								?>
									<div class="slide-item">
										<?php 
										$noThumbnail='';
										if( get_theme_mod( 'hide_feature_posts_image', false ) || !has_post_thumbnail() ){
											$noThumbnail = 'has-no-thumbnail';
										}
										?>
										<div class="slide-inner">
											<article id="post-<?php the_ID(); ?>" <?php post_class( $noThumbnail ) ?>>
												<div class="post-inner">
													<?php
													if ( get_theme_mod( 'feature_posts_slides_show', 3 ) == 2 ){
										        		$image_size = 'gutener-590-310';
										        	}else {
										        		$image_size = 'gutener-420-200';
													}
													$image    = get_the_post_thumbnail_url( get_the_ID(), $image_size );
													$image_id = get_post_thumbnail_id();
													$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true);

													if ( !get_theme_mod( 'hide_feature_posts_image', false ) && has_post_thumbnail()){ ?>
														<figure class="featured-image">
															<a href="<?php the_permalink(); ?>">
																<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo $alt; ?>">
															</a>
														</figure>
													<?php } ?>
													<?php if( 'post' == get_post_type() ): 
														$categories_list = get_the_category_list( ' ' );
														if( $categories_list && !get_theme_mod( 'hide_feature_posts_category', false ) ):
													
														printf( '<span class="cat-links">' . '%1$s' . '</span>', $categories_list );
															
													endif; endif; ?>
												</div>
												<div class="post-content-wrap">
													<?php if( !get_theme_mod( 'hide_feature_posts_title', false ) ){ ?>
														<div class="entry-content">
															<h3 class="entry-title">
																<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
															</h3>
														</div>
													<?php } ?>
													<div class="entry-meta">
														<?php
															if( !get_theme_mod( 'hide_feature_posts_date', false ) ): ?>
																<span class="posted-on">
																	<a href="<?php echo esc_url( gutener_get_day_link() ); ?>" >
																		<?php echo esc_html(get_the_date('M j, Y')); ?>
																	</a>
																</span>
															<?php endif; 
															if( !get_theme_mod( 'hide_feature_posts_author', false ) ): ?>
																<span class="byline">
																	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
																		<?php echo get_the_author(); ?>
																	</a>
																</span>
															<?php endif; 
															if( !get_theme_mod( 'hide_feature_posts_comment', false ) ): ?>
																<span class="comments-link">
																	<a href="<?php comments_link(); ?>">
																		<?php echo absint( wp_count_comments( get_the_ID() )->approved ); ?>
																	</a>
																</span>
															<?php endif; ?>
														</div>
													</div>
											</article>
										</div>
									</div>
								<?php
								endwhile; 
								wp_reset_postdata();
								?>
							</div>
							<?php if( ( !get_theme_mod( 'disable_feature_posts_arrows', false ) || !get_theme_mod( 'disable_feature_posts_dots', false ) ) && !( count( $posts_array ) <= get_theme_mod( 'feature_posts_slides_show', 3 ) ) ) { ?>
								<div class="wrap-arrow">
								    <ul class="slick-control">
								        <?php if ( !get_theme_mod( 'disable_feature_posts_arrows', false ) ){ ?>
									        <li class="feature-posts-prev">
									        	<span></span>
									        </li>
								    	<?php } 
								    	if ( !get_theme_mod( 'disable_feature_posts_dots', false ) ){ ?>
							        		<div class="feature-posts-dots"></div>
							        	<?php } 
								        if ( !get_theme_mod( 'disable_feature_posts_arrows', false ) ){ ?>
									        <li class="feature-posts-next">
									        	<span></span>
									        </li>
								    	<?php } ?>
								    </ul>
								</div>
							<?php } ?>
						</div>
					</section>
				<?php }
			} ?>
		</div><!-- #container -->
	</div><!-- #content -->
<?php
get_footer();