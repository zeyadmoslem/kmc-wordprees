<?php
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
				if( get_theme_mod( 'highlight_posts_columns', 'three_columns' ) == 'one_column' ){
					$columns_class = 'col-md-12';
				}elseif( get_theme_mod( 'highlight_posts_columns', 'three_columns' ) == 'two_columns' ){
					$columns_class = 'col-md-6';
				}elseif( get_theme_mod( 'highlight_posts_columns', 'three_columns' ) == 'three_columns' ){
					$columns_class = 'col-md-4';
				}elseif( get_theme_mod( 'highlight_posts_columns', 'three_columns' ) == 'four_columns' ){
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
<?php } ?>