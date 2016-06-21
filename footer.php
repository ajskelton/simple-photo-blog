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

			<div class="site-info">
				<?php ajs_spb_do_copyright_text(); ?>
			</div>
			<div class="credits">
				<span>Proudly powered by </span>
				<a href="http://www.wordpress.org">WordPress</a>
				<span> / Theme: </span>
				<a href="http://anthonyskelton.com/simplephotoblog">Simple Photo Blog</a> by <a href="http://anthonyskelton.com">Anthony Skelton</a>
			</div>

		</div><!-- .wrap -->
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
