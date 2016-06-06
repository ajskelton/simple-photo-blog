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
								echo '<h2 class="entry-title">'.$recent['post_title'].'</h2>';
								echo '<p class="entry-description">'.$recent['post_excerpt'].'</p>';
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
						echo '<a href="'.$grid_item[1].'">';
						echo $grid_item[0];
						echo '</a>';
						echo '</div>';
					}
				?>
				</section>

			</main><!-- #main -->
		</div><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>