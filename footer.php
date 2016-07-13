<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Simple Photo Blog
 */
?>
	</div><!-- #content -->

	<footer class="site-footer">
		<div class="wrap">
		
		<?php ajs_spb_do_social_icons() ?>

			<div class="site-info">
				<?php ajs_spb_do_copyright_text(); ?>
			</div>
			<?php if( get_theme_mod( 'ajs_spb_credits_enable' ) ) { ?>
			<div class="credits">
				<span>Proudly powered by </span>
				<a href="http://www.wordpress.org">WordPress</a>
				<span> / Theme: </span>
				<a href="http://anthonyskelton.com/simplephotoblog">Simple Photo Blog</a> by Anthony Skelton
			</div>
			<?php } ?>

		</div><!-- .wrap -->
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
