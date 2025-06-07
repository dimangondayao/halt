<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style( 'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.1.0'
	);
	
	wp_enqueue_style( 'aos', 'https://unpkg.com/aos@2.3.1/dist/aos.css' );
    wp_enqueue_script( 'aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array( 'jquery' ) );
    
    // Only use this if Bootstrap is needed
	//wp_enqueue_style( 'bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css' );
	//wp_enqueue_script( 'bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

/*
 * This feature is not usually needed anymore, as newer builds have a contact form in
 * the footer. This affects the generic Thank You page redirect, where the redirect jumps to
 * the form in the footer, instead of showing the Thank You content on the top of the page.
 *
 * Gravity Forms: jump to the form section after submission.
 * Fixes bug for forms in the bottom of the page where submissions redirect to the top
*/
add_filter( 'gform_confirmation_anchor', '__return_true' );

// Move Yoast SEO to the bottom of the editor page.
//add_filter('wpseo_metabox_prio', function() { return 'low'; });

// Disable autosave.
add_action( 'admin_init', 'halt_disable_autosave' );
function halt_disable_autosave() {
    wp_deregister_script( 'autosave' );
}

// Disable Elementor from creating image sizes.
// Reference: https://github.com/elementor/elementor/issues/7242#issuecomment-468223243
add_action( 'elementor/element/before_section_end', function ( \Elementor\Controls_Stack $control_stack, $args ) {
    $control = $control_stack->get_controls( 'image_size' );

    // Exit early if $control_stack dont have the image_size control.
    if ( empty( $control ) || ! is_array( $control ) ) {
        return;
    }

    // remove custom
    unset( $control['options']['custom'] );

    // update the control
    $control_stack->update_control( 'image_size', $control );
}, 10, 2 );

// Manually disable Gravity Forms legacy markup,
// as the toggle in Gravity Forms is no longer available.
add_filter( 'gform_enable_legacy_markup', '__return_false' );

include( 'inc/queries.php' );