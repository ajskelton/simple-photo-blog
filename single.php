<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Simple Photo Blog
 */

get_header(); ?>

	<div class="wrap">
		<div class="content-area">
			<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post(); ?>

				<article <?php post_class(); ?>>
					<?php 
						if(has_post_thumbnail()){
							ajs_spb_do_post_image( $size = 'full' );
						}
					?>
					<?php
						the_title( '<h2 class="entry-title">', '</h2>' );
					?>
					<div class="entry-content">
						
						<div class="entry-description">
							<?php ajs_spb_posted_on(); ?>
						
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
							<?php
								if( has_post_format( 'image', get_the_id() ) ){
							?>
								<div class="image-meta">
									<hr>
									<h3>EXIF Information</h3>
									<?php ajs_spb_get_exif_info(); ?>
								</div><!-- .image-meta -->
							<?php
								} // End if has_post_format
							?>
						</div><!-- .entry-description -->

					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<hr>
						<?php ajs_spb_entry_footer(); ?>
					</footer><!-- .entry-footer -->
					
				</article><!-- #post-## -->
				<?php

				// the_post_navigation();
				ajs_spb_thumbnail_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

			</main><!-- #main -->
		</div><!-- .primary -->
	</div><!-- .wrap -->

<?php get_footer(); ?>