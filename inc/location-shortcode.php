<?php


function location_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts );
    
    $map = generate_map($atts);

    return $map;

}

add_shortcode( 'location', 'location_shortcode' );