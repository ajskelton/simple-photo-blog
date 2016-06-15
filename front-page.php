<?php
/**
 * The template for displaying the front page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Simple Photo Blog
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">
				<div class="most-recent-post">
				<?php
					$args = array( 
						'numberposts' => '31',
						'post_status' => 'publish',
						'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-image',
									'operator' => 'IN'
								),
						) );
						$recent_posts = wp_get_recent_posts( $args );
						$first = true;
						$index_grid = [];
						foreach( $recent_posts as $recent ){
							if($first == true) {
								$featured_image = get_the_post_thumbnail( $recent['ID'], 'full' );
								echo '<a href="'.$recent['guid'].'">';
								echo $featured_image;
								echo '</a>';
								echo '<div class="entry-content">';
								echo '<h2 class="entry-title"><a href="'.$recent['guid'].'">'.$recent['post_title'].'</a></h2>';
								ajs_spb_posted_on();
								echo '<p class="entry-description">'.$recent['post_excerpt'].'</p>';
								echo '</div> <!-- .entry-content -->';
								echo '<hr>';
							} else {
								array_push($index_grid, array(get_the_post_thumbnail( $recent['ID'], 'thumbnail' ), $recent['guid'] ) );
							}
							$first = false;
						}
				?>
				</div>

				<?php
				while ( have_posts() ) : the_post();

					if( ! is_front_page() && has_post_thumbnail() ) {
						ajs_spb_do_post_image( $size = 'full' );
					} ?>

					<div class="front-page-content">
						<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ajs_spb' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .front-page-content -->

				<?php

				endwhile; // End of the loop.
				
				?>
				<h2>Recent Photos</h2>
				<section id="other-recent-posts">
				<?php
					foreach( $index_grid as $grid_item){
						echo '<div class="index-grid">';
						echo '<a href="'.$grid_item[1].'">';
						echo $grid_item[0];
						echo '</a>';
						echo '</div>';
					}
				?>
				</section><!-- #other-recent-posts -->

			</main><!-- #main -->
		</div><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>