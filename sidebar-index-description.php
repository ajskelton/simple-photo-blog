<?php
/**
 * The sidebar containing the place for the index page description
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Simple Photo Blog
 */

if ( ! is_active_sidebar( 'index-description' ) ) {
	return;
}
?>

<div class="index-description widget-area">
	<?php dynamic_sidebar( 'index-description' ); ?>
</div><!-- .index-description -->

<div class="index-image widget-area">
	<?php dynamic_sidebar( 'index-image' ); ?>
</div>