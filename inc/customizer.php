<?php
/**
 * Simple Photo Blog Theme Customizer.
 *
 * @package Simple Photo Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ajs_spb_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // Remove controls we're going to recreate
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->remove_control( 'background_color' );

    // Add options to the themes section
    $wp_customize->add_setting(
        'ajs_spb_display_header_text',
        array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_radio',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_display_header_text',
        array(
            'label' => __( 'Header Text Options', 'simple-photo-blog' ),
            'section' => 'title_tagline',
            'settings' => 'ajs_spb_display_header_text',
            'type' => 'radio',
            'choices' => array(
                '1' => __( 'Logo Only', 'simple-photo-blog' ),
                '2' => __( 'Site Title Only', 'simple-photo-blog' ),
                '3' => __( 'Site Title and Tagline', 'simple-photo-blog'),
                '4' => __( 'Disable', 'simple-photo-blog' ),
            ),
        )
    );

    // Add custom colors to the colors section
    $ajs_spb_custom_colors[] = array(
        'slug' => 'background_color',
        'default' => '#fff',
        'label' => esc_html__( 'Background Color', 'simple-photo-blog' ),
    );
    $ajs_spb_custom_colors[] = array(
        'slug' => 'header_background_color',
        'default' => '#666',
        'label' => esc_html__( 'Header Background Color', 'simple-photo-blog' ),
    );
    $ajs_spb_custom_colors[] = array(
        'slug' => 'header_text_color',
        'default' => '#fff',
        'label' => esc_html__( 'Header Text Color', 'simple-photo-blog' ),
    );
    $ajs_spb_custom_colors[] = array(
        'slug' => 'text_color',
        'default' => '#000',
        'label' => esc_html__( 'Text Color', 'simple-photo-blog' ),
    );
    $ajs_spb_custom_colors[] = array(
        'slug' => 'link_color',
        'default' => '#000',
        'label' => esc_html__( 'Link Color', 'simple-photo-blog' ),
    );
    foreach( $ajs_spb_custom_colors as $color ) {

        // SETTINGS
        $wp_customize->add_setting(
            'ajs_spb_custom_colors[' . $color['slug'] . ']',
            array(
                'default' => $color['default'],
                'capability' => 'edit_theme_options',
            )
        );
        // CONTROLS
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'ajs_spb_' . $color['slug'],
                array(
                    'label' => $color['label'],
                    'section' => 'colors',
                    'settings' => 'ajs_spb_custom_colors[' . $color['slug'] . ']'
                )
            )
        );
    }

	// Add our social link options.
    $wp_customize->add_section(
        'ajs_spb_social_links_section',
        array(
            'title'       => esc_html__( 'Social Links', 'simple-photo-blog' ),
            'description' => esc_html__( 'These are the settings for social links. Please limit the number of social links to 5.', 'simple-photo-blog' ),
        )
    );

    // Create an array of our social links for ease of setup.
    $social_networks = array( 'dribbble', 'facebook', 'flickr', 'google-plus', 'instagram', 'linkedin', 'pinterest', 'tumblr', 'twitter', 'vimeo', 'youtube'  );

    // Loop through our networks to setup our fields.
    foreach( $social_networks as $network ) {

	    $wp_customize->add_setting(
	        'ajs_spb_' . $network . '_link',
	        array(
	            'default' => '',
	            'sanitize_callback' => 'ajs_spb_sanitize_customizer_url'
	        )
	    );
	    $wp_customize->add_control(
	        'ajs_spb_' . $network . '_link',
	        array(
	            'label'   => sprintf( esc_html__( '%s Link', 'simple-photo-blog' ), ucwords( $network ) ),
	            'section' => 'ajs_spb_social_links_section',
	            'type'    => 'text',
	        )
	    );
    }

    // Add our Footer Customization section section.
    $wp_customize->add_section(
        'ajs_spb_footer_section',
        array(
            'title'    => esc_html__( 'Footer Customization', 'simple-photo-blog' ),
        )
    );

    // Add our copyright text field.
    $wp_customize->add_setting(
        'ajs_spb_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_text',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_copyright_text',
        array(
            'label'       => esc_html__( 'Copyright Text', 'simple-photo-blog' ),
            'description' => esc_html__( 'The copyright text will be displayed beneath the menu in the footer.', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_footer_section',
            'type'        => 'text',
            'sanitize'    => 'html'
        )
    );
    // Add footer credits option
    $wp_customize->add_setting(
        'ajs_spb_credits_enable',
        array(
            'capability' => 'edit_theme_options',
            'default'    => '1',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_checkbox',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_credits_enable',
        array(
            'label'       => esc_html__( 'Enable Credits', 'simple-photo-blog' ),
            'description' => esc_html__( 'Check to enable credits to WordPress and theme in the footer', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_footer_section',
            'type'        => 'checkbox',
        )
    );

    // Add footer social links option
    $wp_customize->add_setting(
        'ajs_spb_social_enable',
        array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_checkbox',

        )
    );
    $wp_customize->add_control(
        'ajs_spb_social_enable',
        array(
            'label'       => esc_html__( 'Enable Social Links', 'simple-photo-blog' ),
            'description' => esc_html__( 'Show any social links added to the customizer', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_footer_section',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_section(
        'ajs_spb_default_featured_image_section',
        array(
            'title'       => __( 'Default Featured Image', 'simple-photo-blog' ),
            'description' => 'Upload an image to use for any posts without a featured image. The image is only used in post navigation and no image is shown on the post if no featured image is chosen. A square image of at least 400x400 is optimal. If no image is uploaded a default gray square is used.',
        )
    );
    $wp_customize->add_setting(
        'ajs_spb_default_featured_image',
        array(
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_image',
        )

    );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'simple-photo-blog', array(
            'label'       => __( 'Default Featured Image', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_default_featured_image_section',
            'settings'    => 'ajs_spb_default_featured_image',
        )
    ) );
    /*
    * Front Page Section
    *
    * @since 1.0.0
     */
    $wp_customize->add_section(
        'ajs_spb_front_page_section',
        array(
            'title'           => __('Front Page Settings', 'simple-photo-blog' ),
            'description'     => __( 'Front Page settings and options', 'simple-photo-blog' ),
            'active_callback' => 'is_front_page',
        )
    );
    /*
    * Enable Most Recent Post on Front Page
    *
    * @since 1.0.0
     */
    $wp_customize->add_setting(
        'ajs_spb_most_recent_post',
        array(
            'capability'  => 'edit_theme_options',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_checkbox',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_most_recent_post',
        array(
            'label'       => esc_html__( 'Enable Most Recent Post', 'simple-photo-blog' ),
            'description' => esc_html__( 'Enabling will show the most recent photo post at the top of the front page.', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_front_page_section',
            'settings'    => 'ajs_spb_most_recent_post',
            'type'        => 'checkbox',
        )
    );
    /*
    * Index Grid Settings on Front Page
    *
    * @since 1.0.0
     */
    $wp_customize->add_setting(
        'ajs_spb_index_grid_enable',
        array(
            'capability'  => 'edit_theme_options',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_checkbox',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_index_grid_enable',
        array(
            'label'       => esc_html__( 'Enable Index Grid', 'simple-photo-blog' ),
            'description' => esc_html__( 'Enabling will show a grid of recent image posts on the bottom of the front page.', 'simple-photo-blog'),
            'section'     => 'ajs_spb_front_page_section',
            'settings'    => 'ajs_spb_index_grid_enable',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'ajs_spb_index_grid_title',
        array(
            'default'     => '',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_text',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_index_grid_title',
        array(
            'label'       => esc_html__( 'Index Grid Title', 'simple-photo-blog' ),
            'description' => esc_html__( 'The title will show above the index grid on the front page when enabled.', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_front_page_section',
            'type'        => 'text',
            'sanitize'    => 'html'
        )
    );

    $wp_customize->add_setting(
        'ajs_spb_index_grid_amount',
        array(
            'default'     => 10,
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_number',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_index_grid_amount',
        array(
            'label'       => esc_html__( 'Index Grid Amount', 'simple-photo-blog' ),
            'description' => esc_html__( 'Number of images to show in the Index Grid', 'simple-photo-blog' ),
            'section'     => 'ajs_spb_front_page_section',
            'type'        => 'number',
        )
    );

    // Add Custom CSS Testarea
    $wp_customize->add_section(
        'ajs_spb_custom_css_section',
        array(
            'title'           => __( 'Custom CSS Settings', 'simple-photo-blog' ),
            'description'     => __( 'Add custom styles to override theme css', 'simple-photo-blog' ),
        )
    );
    $wp_customize->add_setting(
        'ajs_spb_custom_css',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'sanitize_js_callback' => 'wp_filter_nohtml_kses',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_custom_css_control',
        array(
            'label' => __( 'Custom CSS', 'simple-photo-blog' ),
            'section' => 'ajs_spb_custom_css_section',
            'settings' => 'ajs_spb_custom_css',
            'type' => 'textarea',
        )  
    );

    /* Add EXIF Customizer Options */
    $wp_customize->add_section(
        'ajs_spb_exif_section',
        array(
            'title'             => __( 'EXIF Settings', 'simple-photo-blog' ),
            'description'       => __( 'EXIF Camera Data display options', 'simple-photo-blog' ),
        )
    );

    $wp_customize->add_setting(
        'ajs_spb_exif_display',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => '1',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_checkbox',
        )
    );

    $wp_customize->add_control(
        'ajs_spb_exif_display_control',
        array(
            'label'             => esc_html__( 'Enable EXIF Data on Single Posts', 'simple-photo-blog' ),
            'description'       => esc_html__( 'Enabling will display the camera EXIF data (Camera, ISO, Aperture, Shutter, Focal Length) on a photos single post page below the description.', 'simple-photo-blog' ),
            'section'           => 'ajs_spb_exif_section',
            'settings'          => 'ajs_spb_exif_display',
            'type'              => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'ajs_spb_exif_title',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => 'EXIF Information',
            'sanitize_callback' => 'ajs_spb_sanitize_customizer_text',
        )
    );

    $wp_customize->add_control(
        'ajs_spb_exif_title_control',
        array(
            'label'             => esc_html__( 'Title to display above EXIF information', 'simple-photo-blog' ),
            'section'           => 'ajs_spb_exif_section',
            'settings'          => 'ajs_spb_exif_title',
            'type'              => 'text',
            'sanitize'          => 'html',
        )
    );


}
add_action( 'customize_register', 'ajs_spb_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ajs_spb_customize_preview_js() {
    wp_enqueue_script( 'ajs_spb_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ajs_spb_customize_preview_js' );

/**
 * Sanitize our customizer text inputs.
 */
function ajs_spb_sanitize_customizer_text( $input ) {
    return sanitize_text_field( force_balance_tags( $input ) );
}

/**
 * Sanitize our customizer URL inputs.
 */
function ajs_spb_sanitize_customizer_url( $input ) {
    return esc_url( $input );
}

/*
* Sanitize our customizer checkbox inputs.
 */
function ajs_spb_sanitize_customizer_checkbox( $input ) {
    if( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/*
* Sanitize our customizer radio inputs.
 */
function ajs_spb_sanitize_customizer_radio( $input ) {
    $valid = array(
        '1' => __( 'Logo Only', 'simple-photo-blog' ),
        '2' => __( 'Site Title Only', 'simple-photo-blog' ),
        '3' => __( 'Site Title and Tagline', 'simple-photo-blog'),
        '4' => __( 'Disable', 'simple-photo-blog' ),
    );

    if ( array_key_exists($input , $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/*
* Sanitize our customizer image uploader
 */
function ajs_spb_sanitize_customizer_image( $input ) {
    /* default output */
    $output = '';

    /* check file type */
    $filetype = wp_check_filetype( $input );
    $mime_type = $filetype['type'];

    /* only mime type "image" allowed */
    if ( strpos( $mime_type, 'image' ) !== false ) {
        $output = $input;
    }

    return $output;
}

/*
* Sanitize our customizer number input.
 */
function ajs_spb_sanitize_customizer_number( $input ) {
    if( is_numeric($input) && $input > 0) {
        return $input;
    }
}

/*
* Get the custom CSS from Customizer
*
* @since 
 */
function ajs_spb_get_customizer_custom_css() {
    if( get_theme_mod( 'ajs_spb_custom_css') ) {
        ?>
        <style type="text/css">
            <?php echo get_theme_mod( 'ajs_spb_custom_css' ); ?>
        </style>
        <?php
    }
}

/*
* Echo the custom css and hook it into wp_head
*
* @since 
 */
function ajs_spb_do_customizer_custom_css() {
    echo ajs_spb_get_customizer_custom_css();
}
add_action( 'wp_head', 'ajs_spb_do_customizer_custom_css' );

/*
* Insert custom colors in the wp_head
*
* @since 1.0.0
 */
function ajs_spb_customizer_head_styles() {
    if( get_theme_mod( 'ajs_spb_custom_colors' ) ) {
        $ajs_spb_custom_colors = get_theme_mod( 'ajs_spb_custom_colors' );
    }
    ?>
    <style>
    <?php
    foreach ($ajs_spb_custom_colors as $key => $value) {
        switch ($key) {
            case 'background_color':
                if( $value == '#fff' || $value == '#ffffff' ) {
                    break;
                }
                ?>
                body {
                    background-color: <?php echo $value ?>;
                }
                <?php
                break;

            case 'header_background_color':
                if( $value == '#666' || $value == '#666666') {
                    break;
                }
                ?>
                .site-header,
                .site-footer {
                    background-color: <?php echo $value ?>;
                }
                @media (min-width: 40rem) {
                    .menu.dropdown ul {
                        background-color: <?php echo $value ?>;
                    }
                }
                <?php
                break;

            case 'header_text_color':
                if( $value == '#fff' || $value == '#ffffff' ) {
                    break;
                }
                ?>
                .site-header,
                .site-header a,
                .site-footer,
                .site-footer a,
                .site-title a,
                .menu-toggle .menu-toggle-text,
                .menu.dropdown ul a {
                    color: <?php echo $value ?>;
                }
                .main-navigation .menu-item-has-children>a:after {
                    border-top: 6px solid <?php echo $value ?>;
                }
                .menu-toggle .icon {
                    fill: <?php echo $value ?>;
                }

                <?php
                break;

            case 'text_color':
                if( $value == '#000' || $value == '#000000' ) {
                    break;
                }
                ?>
                body {
                    color: <?php echo $value ?>;
                } 
                <?php
                break;

            case 'link_color':
                if( $value == '#000' || $value == '#000000' ) {
                    break;
                }
                ?>
                .site-content a,
                .site-content a:active,
                .site-content a:focus,
                .site-content a:hover,
                .site-content a:visited {
                    color: <?php echo $value ?>;
                }
                .entry-title a {
                    border-color: <?php echo $value ?>;
                }

                <?php
                break;
        }
    }
}
add_action( 'wp_head', 'ajs_spb_customizer_head_styles' );