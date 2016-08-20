<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Simple Photo Blog
 */

if ( ! function_exists( 'ajs_spb_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ajs_spb_posted_on() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'simple-photo-blog' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'simple-photo-blog' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<div class="posted-on-meta"><span class="posted-on">' . $posted_on . '</span>';
	if( !is_front_page() ){
		echo '<span class="byline"> ' . $byline . '</span></div>'; // WPCS: XSS OK.
	} else {
		echo '</div>';
	}

}
endif;

if ( ! function_exists( 'ajs_spb_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ajs_spb_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'simple-photo-blog' ) );
		if ( $categories_list && ajs_spb_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'simple-photo-blog' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'simple-photo-blog' ) );
		if ( $tags_list ) {
						printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'simple-photo-blog' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'simple-photo-blog' ), esc_html__( '1 Comment', 'simple-photo-blog' ), esc_html__( '% Comments', 'simple-photo-blog' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'simple-photo-blog' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ajs_spb_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'ajs_spb_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'ajs_spb_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so ajs_spb_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so ajs_spb_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in ajs_spb_categorized_blog.
 */
function ajs_spb_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return false;
	}
	// Like, beat it. Dig?
	delete_transient( 'ajs_spb_categories' );
}
add_action( 'delete_category', 'ajs_spb_category_transient_flusher' );
add_action( 'save_post',     'ajs_spb_category_transient_flusher' );

/**
 * Return SVG markup.
 *
 * @param  array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @param string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     @param string $title Optional. SVG title, e.g. "Facebook".
 *     @param string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }
 * @return string SVG markup.
 */
function ajs_spb_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'simple-photo-blog' );
	}

	// YUNO define an icon?
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'simple-photo-blog' );
	}

	// Set defaults.
	$defaults = array(
		'icon'  => '',
		'title' => '',
		'desc'  => ''
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Begin SVG markup
	$svg = '<svg class="icon icon-' . esc_html( $args['icon'] ) . '" aria-hidden="true">';

		// If there is a title, display it.
		if ( $args['title'] ) {
			$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
		}

		// If there is a description, display it.
		if ( $args['desc'] ) {
			$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
		}

	$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';

	return $svg;
}

/**
 * Display an SVG.
 *
 * @param  array  $args  Parameters needed to display an SVG.
 */
function ajs_spb_do_svg( $args = array() ) {
	echo ajs_spb_get_svg( $args );
}

/**
 * Trim the title legnth.
 *
 * @param  array  $args  Parameters include length and more.
 * @return string        The shortened excerpt.
 */
function ajs_spb_get_the_title( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'length'  => 12,
		'more'    => '...'
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the title.
	return wp_trim_words( get_the_title( get_the_ID() ), $args['length'], $args['more'] );
}

/**
 * Limit the excerpt length.
 *
 * @param  array  $args  Parameters include length and more.
 * @return string        The shortened excerpt.
 */
function ajs_spb_get_the_excerpt( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'length' => 20,
		'more'   => '...'
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the excerpt.
	return wp_trim_words( get_the_excerpt(), absint( $args['length'] ), esc_html( $args['more'] ) );
}

/**
 * Echo an image, no matter what.
 *
 * @param string  $size  The image size you want to display.
 */
function ajs_spb_do_post_image( $size = 'thumbnail' ) {

	// If featured image is present, use that.
	if ( has_post_thumbnail() ) {
		return the_post_thumbnail( $size );
	}

	// Check for any attached image
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path.
	$media_url = get_stylesheet_directory_uri() . '/assets/images/placeholder.png';

	// If an image is present, then use it.
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	echo '<img src="' . esc_url( $media_url ) . '" class="attachment-thumbnail wp-post-image" alt="' . esc_html( get_the_title() )  . '" />';
}

/**
 * Return an image URI, no matter what.
 *
 * @param  string  $size  The image size you want to return.
 * @return string         The image URI.
 */
function ajs_spb_get_post_image_uri( $size = 'thumbnail' ) {

	// If featured image is present, use that.
	if ( has_post_thumbnail() ) {

		$featured_image_id = get_post_thumbnail_id( get_the_ID() );
		$media = wp_get_attachment_image_src( $featured_image_id, $size );

		if ( is_array( $media ) ) {
			return current( $media );
		}
	}

	// Check for any attached image.
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path.
	$media_url = get_stylesheet_directory_uri() . '/assets/images/placeholder.png';

	// If an image is present, then use it.
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	return $media_url;
}

/**
 * Get an attachment ID from it's URL.
 *
 * @param  string  $attachment_url  The URL of the attachment.
 * @return int                      The attachment ID.
 */
function ajs_spb_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;

	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url ) {
		return false;
	}

	// Get the upload directory paths.
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL.
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL.
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}

/**
 * Echo the copyright text saved in the Customizer.
 */
function ajs_spb_do_copyright_text() {

	// Grab our customizer settings.
	$copyright_text = get_theme_mod( 'ajs_spb_copyright_text' );

	// Stop if there's nothing to display.
	if ( ! $copyright_text ) {
		return false;
	}

	// Echo the text.
	echo '<span class="copyright-text">' . wp_kses_post( $copyright_text ) . '</span>';
}

/*
* Echo the EXIF Info for an image post
* 
* @since 1.0.0
 */
function ajs_spb_get_exif_info() {
	if ( has_post_format( 'image' )) {
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );
		$post_thumbnail_meta = wp_get_attachment_metadata ( $post_thumbnail_id );

		if($post_thumbnail_meta['image_meta']['camera']){
	
	// Start the markup.
	?>
	<ul class="image-exif-list">
		<li class="camera">Camera: <?php echo $post_thumbnail_meta['image_meta']['camera']; ?></li>
		<li class="iso">ISO: <?php echo $post_thumbnail_meta['image_meta']['iso']; ?></li>
		<li class="aperture">Aperture: <?php echo $post_thumbnail_meta['image_meta']['aperture']; ?></li>
		<li class="shutter">Shutter: <?php echo ajs_spb_convert_decimal_to_fraction($post_thumbnail_meta); ?></li>
		<li class="focal-length">Focal Length: <?php echo $post_thumbnail_meta['image_meta']['focal_length']; ?>mm</li>
	</ul> <!-- .image-exif-list -->
	<?php } }
}

/*
* Echo post navigation using post thumbnails instead of text
*
* @since 1.0.0
 */
function ajs_spb_thumbnail_navigation() {
	$next_post = get_next_post();
    $previous_post = get_previous_post();
    $thumbnails = [];
    $thumbnails['next'] = get_the_post_thumbnail($next_post->ID,'thumbnail');
    $thumbnails['prev'] = get_the_post_thumbnail($previous_post->ID,'thumbnail');
    foreach($thumbnails as $key => $value) {
    	if(!$value) {
    		if( get_theme_mod( 'ajs_spb_default_featured_image' ) ) {
				$thumbnails[$key] = '<img width="400" height="400" src="' . esc_url( get_theme_mod( "ajs_spb_default_featured_image" ) ) .'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" class="attachment-thumbnail wp-post-image">';
    		} else {
    			$thumbnails[$key] = '<img width="400" height="400" src="' . get_stylesheet_directory_uri() . '/assets/images/placeholder.png" class="attachment-thumbnail wp-post-image" />';
    		}
    	}
    }
    the_post_navigation( array(
        'next_text' => $thumbnails['next'] . '<div class="next-text"><span class="meta-nav" aria-hidden="true">' . __( 'Next: ', 'simple-photo-blog' ) . '</span><span class="post-title">%title</span></div> ' . '<span class="screen-reader-text">' . __( 'Next post:', 'simple-photo-blog' ) . '</span> ',
        'prev_text' => $thumbnails['prev'] . '<div class="prev-text"><span class="meta-nav" aria-hidden="true">' . __( 'Previous: ', 'simple-photo-blog' ) . '</span><span class="post-title">%title</span></div> ' . '<span class="screen-reader-text">' . __( 'Previous post:', 'simple-photo-blog' ) . '</span> ',
    ) );
}

/**
 * Build social sharing icons.
 *
 * @return string
 */
function ajs_spb_get_social_share() {

	// Build the sharing URLs.
	$twitter_url  = 'https://twitter.com/share?text=' . urlencode( html_entity_decode( get_the_title() ) ) . '&amp;url=' . rawurlencode ( get_the_permalink() );
	$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode ( get_the_permalink() );
	$linkedin_url = 'https://www.linkedin.com/shareArticle?title=' . urlencode( html_entity_decode( get_the_title() ) ) . '&amp;url=' . rawurlencode ( get_the_permalink() );

	// Start the markup.
	ob_start(); ?>
	<div class="social-share">
		<h5 class="social-share-title"><?php esc_html_e( 'Share This Post', 'simple-photo-blog' ); ?></h5>
		<ul class="social-icons menu menu-horizontal">
			<li class="social-icon">
				<a href="<?php echo esc_url( $twitter_url ); ?>" onclick="window.open(this.href, 'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, top=150, left=0, width=600, height=300' ); return false;">
					<?php ajs_spb_do_svg( array( 'icon' => 'twitter-square', 'title' => 'Twitter', 'desc' => __( 'Share on Twitter', 'simple-photo-blog' ) ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Share on Twitter', 'simple-photo-blog' ); ?></span>
				</a>
			</li>
			<li class="social-icon">
				<a href="<?php echo esc_url( $facebook_url ); ?>" onclick="window.open(this.href, 'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, top=150, left=0, width=600, height=300' ); return false;">
					<?php ajs_spb_do_svg( array( 'icon' => 'facebook-square', 'title' => 'Facebook', 'desc' => __( 'Share on Facebook', 'simple-photo-blog' ) ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Share on Facebook', 'simple-photo-blog' ); ?></span>
				</a>
			</li>
			<li class="social-icon">
				<a href="<?php echo esc_url( $linkedin_url ); ?>" onclick="window.open(this.href, 'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, top=150, left=0, width=475, height=505' ); return false;">
					<?php ajs_spb_do_svg( array( 'icon' => 'linkedin-square', 'title' => 'LinkedIn', 'desc' => __( 'Share on LinkedIn', 'simple-photo-blog' ) ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Share on LinkedIn', 'simple-photo-blog' ); ?></span>
				</a>
			</li>
		</ul>
	</div><!-- .social-share -->

	<?php
	return ob_get_clean();
 }

/**
 * Echo social sharing icons.
 */
function ajs_spb_do_social_share() {
	echo ajs_spb_get_social_share();
}


/*
* Front Page Setup
*
* Check which options are enabled on the front page and return the WP_Query
* for the entire front page.
*
* @since 1.0.0
 */
function ajs_spb_front_page_setup() {
	$index_grid_amount = get_theme_mod( 'ajs_spb_index_grid_amount' );

	if( get_theme_mod('ajs_spb_most_recent_post') && get_theme_mod( 'ajs_spb_index_grid_enable' ) ) {
		$index_grid_amount++;
		$args = array(
			'numberposts' => strval($index_grid_amount),
			'post_status' => 'publish',
			'offset' => 0,
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => 'post-format-image',
						'operator' => 'IN'
					),
		) );
		return wp_get_recent_posts( $args );
	} elseif ( get_theme_mod( 'ajs_spb_most_recent_post' ) ) {
		$args = array(
			'numberposts' => 1,
			'post_status' => 'publish',
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => 'post-format-image',
						'operator' => 'IN'
					),
		) );
		return wp_get_recent_posts( $args );
	} elseif ( get_theme_mod( 'ajs_spb_index_grid_enable') ) {
		$args = array(
			'numberposts' => strval($index_grid_amount),
			'post_status' => 'publish',
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => 'post-format-image',
						'operator' => 'IN'
					),
		) );
		return wp_get_recent_posts( $args );
	}
}

/*
* Front page most recent post
*
* Get most recent image post that has been published and display
*
* @since 1.0.0
 */
function ajs_spb_front_page_most_recent_post( $front_page_images ) {
	$featured_image = get_the_post_thumbnail( $front_page_images[0]['ID'], 'full' );
	?>
		<a href="<?php echo $front_page_images[0]['guid'] ?>">
			<?php echo $featured_image; ?>
		</a>
		<div class="entry-content">
			<h2 class="entry-title">
				<a href="<?php echo $front_page_images[0]['guid'] ?>"><?php echo $front_page_images[0]['post_title']?></a>
			</h2>
			<?php ajs_spb_posted_on(); ?>
			<p class="entry-description"><?php echo $front_page_images[0]['post_excerpt'] ?></p>
		</div> <!-- .entry-content -->
		<hr>
	<?php
}

/*
* Front page Index Grid
*
* Display a custom amount of images in a grid below the front page content.
*
* @since 1.0.0
 */
function ajs_spb_front_page_index_grid($grid_item) {
	$index_grid_title = get_theme_mod( 'ajs_spb_index_grid_title' );
	?>
	<h2 class="index-grid-title"><?php echo $index_grid_title ?></h2>
	<section id="index-grid">
	<?php
		for( $i = 1 ; $i < count($grid_item); $i++) { ?>
			<div class="index-grid">
				<a href="<?php echo $grid_item[$i]['guid'] ?>">
					<?php echo get_the_post_thumbnail( $grid_item[$i]['ID'], 'thumbnail' )?>
				</a>
			</div>
		<?php }
	?>
	</section><!-- #index-grid -->
	<?php
}

/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since 1.0.0
 */
function ajs_spb_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/*
* Site branding conditionals based on the customizer options.
*
* @since 1.0.0
 */
function ajs_spb_get_site_branding() {
	$site_branding_val = get_theme_mod( 'ajs_spb_display_header_text' );
	switch ($site_branding_val) {
		case '1':
			ajs_spb_the_custom_logo();
			break;

		case '2':
			if ( is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;
			break;

		case '3':
			if ( is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif;
			break;

		case '4':
			break;
		
		default:
			break;
	}
}
/*
* Echo the site branding
*
* @since 1.0.0
 */
function ajs_spb_do_site_branding() {
	echo ajs_spb_get_site_branding();
}


/*
* Setup the posts navigation
*
* @since 
 */
function ajs_spb_posts_navigation() {
	$args = array(
		'mid_size' => 3,
		'type' => 'list',
	);
	return paginate_links( $args );
}

function ajs_spb_do_posts_navigation() {
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text">Posts Navigation</h2>
		<?php echo ajs_spb_posts_navigation() ?>
	</nav>
	<?php
}

/*
* Get the list of social media icons
*
* @since 1.0.0
 */
function ajs_spb_get_social_icons() {
	if( get_theme_mod( 'ajs_spb_social_enable' ) ) : ?>
		<ul class="social-icons">
			<?php if( get_theme_mod( 'ajs_spb_dribbble_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_dribbble_link' ); ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'dribbble') ); ?>
				</a>
			</li>
			<?php endif; // end if dribble ?>
			<?php if( get_theme_mod( 'ajs_spb_facebook_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_facebook_link' ); ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'facebook-square') ); ?>
				</a>
			</li>
			<?php endif; // end if facebook ?>
			<?php if( get_theme_mod( 'ajs_spb_flickr_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_flickr_link' ); ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'flickr') ); ?>
				</a>
			</li>
			<?php endif; // end if flickr ?>
			<?php if( get_theme_mod( 'ajs_spb_google-plus_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_google-plus_link' ); ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'google-plus-square') ); ?>
				</a>
			</li>
			<?php endif; // end if google-plus ?>
			<?php if( get_theme_mod( 'ajs_spb_instagram_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_instagram_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'instagram' ) ); ?>
				</a>
			</li>
			<?php endif; // end if instagram ?>
			<?php if( get_theme_mod( 'ajs_spb_linkedin_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_linkedin_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'linkedin-square' ) ); ?>
				</a>
			</li>
			<?php endif; // end if linkedin ?>
			<?php if( get_theme_mod( 'ajs_spb_pinterest_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_pinterest_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'pinterest-square' ) ); ?>
				</a>
			</li>
			<?php endif; // end if pinterest ?>
			<?php if( get_theme_mod( 'ajs_spb_tumblr_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_tumblr_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'tumblr-square' ) ); ?>
				</a>
			</li>
			<?php endif; // end if tumblr ?>
			<?php if( get_theme_mod( 'ajs_spb_twitter_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_twitter_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'twitter-square' ) ); ?>
				</a>
			</li>
			<?php endif; // end if twitter ?>
			<?php if( get_theme_mod( 'ajs_spb_vimeo_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_vimeo_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'vimeo-square' ) ); ?>
				</a>
			</li>
			<?php endif; // end if vimeo ?>
			<?php if( get_theme_mod( 'ajs_spb_youtube_link' ) ) : ?>
			<li class="social-icon">
				<a href="<?php echo get_theme_mod( 'ajs_spb_youtube_link' ) ?>">
					<?php ajs_spb_do_svg( $args = array( 'icon' => 'youtube-square' ) ); ?>
				</a>
			</li>
			<?php endif; // end if youtube ?>
			
		</ul>
	<?php endif;  // end if get theme mod
}

/*
* Echo out the social media icons
*
* @since 1.0.0
 */
function ajs_spb_do_social_icons() {
	echo ajs_spb_get_social_icons();
}