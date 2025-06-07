<?php add_action( 'elementor/query/halt_loop_limit', function( $query ) {
    $query->set( 'posts_per_page', 4 );
} );

add_action( 'elementor/query/halt_blog_offset', function( $query ) {
    $offset = 4; // Skip first 4 posts
    $posts_per_page = 7;

    $paged = max( 1, $query->get( 'paged' ) );

    // Calculate offset manually per page
    $calculated_offset = $offset + ( ( $paged - 1 ) * $posts_per_page );

    $query->set( 'posts_per_page', $posts_per_page );
    $query->set( 'offset', $calculated_offset );
} );