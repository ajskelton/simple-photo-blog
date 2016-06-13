<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Simple Photo Blog
 */

get_header(); ?>

	<div class="blog-wrap">
		<div class="content-area">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post(); ?>

				<article <?php post_class(); ?>>
					<a href="<?php echo the_permalink(); ?>">
						<?php 
						if(has_post_thumbnail()){
							ajs_spb_do_post_image( $size = 'blog-features' );
						}
						?>
					</a> <!-- .featured-image -->
					<div class="entry-content">
						
						<?php
							if ( is_single() ) {
								the_title( '<h1 class="entry-title">', '</h1>' );
							} else {
								the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
							}
							if ( 'post' === get_post_type() ) : ?>
							<div class="entry-description">
							<?php ajs_spb_posted_on(); ?>
							<?php endif; ?>
						<?php
							the_content( sprintf(
								/* translators: %s: Name of current post. */
								wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							) );
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
								'after'  => '</div>',
							) );
						?>
						</div> <!-- .entry-description -->
						
						<?php if( is_single() ) : ?>
							<div class="image-meta">
								<?php ajs_spb_get_exif_info(); ?>
							</div>
						<?php endif; ?>

					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<?php ajs_spb_entry_footer(); ?>
					</footer><!-- .entry-footer -->
					<hr>
				</article><!-- #post-## -->
				<?php 

				endwhile;

			endif; ?>
			</section><!-- .section -->
			<?php the_posts_navigation(); ?>
		</main><!-- #main -->
	</div><!-- .primary -->
</div><!-- .wrap -->

<?php get_footer(); ?>