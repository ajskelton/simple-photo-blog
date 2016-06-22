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
		<?php if( get_theme_mod( 'ajs_spb_social_enable' ) ) { ?>
			<ul class="social-icons">
				<?php if( get_theme_mod( 'ajs_spb_dribble_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_dribble_link' ); ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'dribble') ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_facebook_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_facebook_link' ); ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'facebook-square') ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_flickr_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_flickr_link' ); ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'flickr') ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_google-plus_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_google-plus_link' ); ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'google-plus-square') ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_instagram_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_instagram_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'instagram' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_linkedin_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_linkedin_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'linkedin-square' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_pinterest_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_pinterest_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'pinterest-square' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_tumblr_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_tumblr_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'tumblr-square' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_twitter_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_twitter_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'twitter-square' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_vimeo_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_vimeo_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'vimeo-square' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if( get_theme_mod( 'ajs_spb_youtube_link' ) ) : ?>
				<li class="social-icon">
					<a href="<?php echo get_theme_mod( 'ajs_spb_youtube_link' ) ?>">
						<?php ajs_spb_do_svg( $args = array( 'icon' => 'youtube-square' ) ); ?>
					</a>
				</li>
				<?php endif; ?>
				
			</ul>
		<?php } ?>

			<div class="site-info">
				<?php ajs_spb_do_copyright_text(); ?>
			</div>
			<?php if( get_theme_mod( 'ajs_spb_credits_enable' ) ) { ?>
			<div class="credits">
				<span>Proudly powered by </span>
				<a href="http://www.wordpress.org">WordPress</a>
				<span> / Theme: </span>
				<a href="http://anthonyskelton.com/simplephotoblog">Simple Photo Blog</a> by <a href="http://anthonyskelton.com">Anthony Skelton</a>
			</div>
			<?php } ?>

		</div><!-- .wrap -->
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
