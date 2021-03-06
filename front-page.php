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

get_header(); 

$front_page_images = ajs_spb_front_page_setup();
?>
	<div class="wrap">
	<?php 
		if( get_theme_mod( 'ajs_spb_most_recent_post' ) ){
			ajs_spb_front_page_most_recent_post($front_page_images);
		}
	?>
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">
				<div class="most-recent-post">
				
				</div>

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="front-page-content">
						<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'simple-photo-blog' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .front-page-content -->

				<?php endwhile; // End of the loop. ?>
				
				<?php 
					if( get_theme_mod( 'ajs_spb_index_grid_enable' ) ) {
						ajs_spb_front_page_index_grid($front_page_images);
					}
			 	?>

			</main><!-- #main -->
		</div><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>