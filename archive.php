<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Simple Photo Blog
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
				?>

				<article <?php post_class(); ?>>
					<a href="<?php echo the_permalink(); ?>">
						<?php 
						if(has_post_thumbnail()){
							ajs_spb_do_post_image( $size = 'full' );
						}
						?>
					</a> <!-- .featured-image -->
					<?php
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						?>
						<div class="entry-content">
							<div class="entry-description">
								<?php ajs_spb_posted_on(); ?>
							
								<?php
									the_content( sprintf(
										/* translators: %s: Name of current post. */
										wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'simple-photo-blog' ), array( 'span' => array( 'class' => array() ) ) ),
										the_title( '<span class="screen-reader-text">"', '"</span>', false )
									) );
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'simple-photo-blog' ),
										'after'  => '</div>',
									) );
								?>
							
							</div><!-- .entry-description -->

						</div><!-- .entry-content -->

						<footer class="entry-footer">
							<?php ajs_spb_entry_footer(); ?>
						</footer><!-- .entry-footer -->
						<hr>
					</article><!-- #post-## -->

				<?php

				endwhile;

				ajs_spb_do_posts_navigation();

			endif; ?>

			</main><!-- #main -->
		</div><!-- .primary -->
	</div><!-- .wrap -->

<?php get_footer(); ?>