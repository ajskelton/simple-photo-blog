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
								echo $featured_image;
							} else {
								array_push($index_grid, get_the_post_thumbnail( $recent['ID'], 'thumbnail' ));
							}
							$first = false;
						}
				?>
				</div>

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				
				// var_dump($index_grid);
				?>
				<h2>Recent Photos</h2>
				<section id="other-recent-posts">
				<?php
					foreach( $index_grid as $grid_item){
						echo '<div class="index-grid">';
						echo $grid_item;
						echo '</div>';
					}
				?>
				</section>

			</main><!-- #main -->
		</div><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>