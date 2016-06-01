<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Simple Photo Blog
 */

?>

<article <?php post_class( 'index-grid' ); ?>>

	<div class="entry-content">
		<a href="<?php echo esc_url( get_permalink() )?>" rel="bookmark"><?php ajs_spb_do_post_image( $size = 'thumbnail' ) ?></a>		
	</div><!-- .entry-content -->

</article>