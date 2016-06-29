<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Simple Photo Blog
 */

get_header(); ?>

	<div class="wrap">
		<section class="primary content-area">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'simple-photo-blog' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
				?>

					<article <?php post_class(); ?>>
						<header class="entry-header">
							<a href="<?php echo the_permalink(); ?>">
							<?php 
								if(has_post_thumbnail()){
									ajs_spb_do_post_image( $size = 'full' );
								}
							?>
							</a>
							<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

							<?php if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
								<?php ajs_spb_posted_on(); ?>
							</div><!-- .entry-meta -->
							<?php endif; ?>
						</header><!-- .entry-header -->

						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->

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
		</section><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>