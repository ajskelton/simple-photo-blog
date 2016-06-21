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

	// Add our social link options.
    $wp_customize->add_section(
        'ajs_spb_social_links_section',
        array(
            'title'       => esc_html__( 'Social Links', 'ajs_spb' ),
            'description' => esc_html__( 'These are the settings for social links. Please limit the number of social links to 5.', 'ajs_spb' ),
            'priority'    => 90,
        )
    );

    // Create an array of our social links for ease of setup.
    $social_networks = array( 'twitter', 'facebook', 'instagram' );

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
	            'label'   => sprintf( esc_html__( '%s Link', 'ajs_spb' ), ucwords( $network ) ),
	            'section' => 'ajs_spb_social_links_section',
	            'type'    => 'text',
	        )
	    );
    }

    // Add our Footer Customization section section.
    $wp_customize->add_section(
        'ajs_spb_footer_section',
        array(
            'title'    => esc_html__( 'Footer Customization', 'ajs_spb' ),
            'priority' => 90,
        )
    );

    // Add our copyright text field.
    $wp_customize->add_setting(
        'ajs_spb_copyright_text',
        array(
            'default' => ''
        )
    );
    $wp_customize->add_control(
        'ajs_spb_copyright_text',
        array(
            'label'       => esc_html__( 'Copyright Text', 'ajs_spb' ),
            'description' => esc_html__( 'The copyright text will be displayed beneath the menu in the footer.', 'ajs_spb' ),
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
        )
    );
    $wp_customize->add_control(
        'ajs_spb_credits_enable',
        array(
            'label'       => esc_html__( 'Enable Credits', 'ajs_spb' ),
            'description' => esc_html__( 'Check to enable credits to WordPress and theme in the footer', 'ajs_spb' ),
            'section'     => 'ajs_spb_footer_section',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_section(
        'ajs_spb_default_featured_image_section',
        array(
            'title'       => __( 'Default Featured Image', 'ajs_spb' ),
            'priority'    => 30,
            'description' => 'Upload an image to use for any posts without a featured image. The image is only used in post navigation and no image is shown on the post if no featured image is chosen. A square image of at least 400x400 is optimal. If no image is uploaded a default gray square is used.',
        )
    );
    $wp_customize->add_setting(
     'ajs_spb_default_featured_image'
    );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ajs_spb', array(
            'label'       => __( 'Default Featured Image', 'ajs_spb' ),
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
            'title'           => __('Front Page Settings', 'ajs_spb' ),
            'priority'        => 30,
            'description'     => __( 'Front Page settings and options', 'ajs_spb' ),
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
        )
    );
    $wp_customize->add_control(
        'ajs_spb_most_recent_post',
        array(
            'label'       => esc_html__( 'Enable Most Recent Post', 'ajs_spb' ),
            'description' => esc_html__( 'Enabling will show the most recent photo post at the top of the front page.', 'ajs_spb' ),
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
        )
    );
    $wp_customize->add_control(
        'ajs_spb_index_grid_enable',
        array(
            'label'       => esc_html__( 'Enable Index Grid', 'ajs_spb' ),
            'description' => esc_html__( 'Enabling will show a grid of recent image posts on the bottom of the front page.', 'ajs_spb'),
            'section'     => 'ajs_spb_front_page_section',
            'settings'    => 'ajs_spb_index_grid_enable',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'ajs_spb_index_grid_title',
        array(
            'default'     => '',
        )
    );
    $wp_customize->add_control(
        'ajs_spb_index_grid_title',
        array(
            'label'       => esc_html__( 'Index Grid Title', 'ajs_spb' ),
            'description' => esc_html__( 'The title will show above the index grid on the front page when enabled.', 'ajs_spb' ),
            'section'     => 'ajs_spb_front_page_section',
            'type'        => 'text',
            'sanitize'    => 'html'
        )
    );

    $wp_customize->add_setting(
        'ajs_spb_index_grid_amount',
        array(
            'default'     => 30,
        )
    );
    $wp_customize->add_control(
        'ajs_spb_index_grid_amount',
        array(
            'label'       => esc_html__( 'Index Grid Amount', 'ajs_spb' ),
            'description' => esc_html__( 'Number of images to show in the Index Grid', 'ajs_spb' ),
            'section'     => 'ajs_spb_front_page_section',
            'type'        => 'number',
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
