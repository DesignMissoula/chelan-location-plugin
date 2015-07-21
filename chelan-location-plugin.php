<?php

/*
Plugin Name:       Chelan Location Plugin
Plugin URI:        https://chelanfruit.com
Description:       Locations
Version:           1.0.1
Author:            Bradford Knowlton
GitHub Plugin URI: https://github.com/DesignMissoula/chelan-recipe-plugin
Requires WP:       3.8
Requires PHP:      5.3
*/

add_action( 'init', 'register_cpt_location' );

function register_cpt_location() {

    $labels = array( 
        'name' => _x( 'Locations', 'location' ),
        'singular_name' => _x( 'Location', 'location' ),
        'add_new' => _x( 'Add New', 'location' ),
        'add_new_item' => _x( 'Add New Location', 'location' ),
        'edit_item' => _x( 'Edit Location', 'location' ),
        'new_item' => _x( 'New Location', 'location' ),
        'view_item' => _x( 'View Location', 'location' ),
        'search_items' => _x( 'Search Locations', 'location' ),
        'not_found' => _x( 'No locations found', 'location' ),
        'not_found_in_trash' => _x( 'No locations found in Trash', 'location' ),
        'parent_item_colon' => _x( 'Parent Location:', 'location' ),
        'menu_name' => _x( 'Locations', 'location' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title','revisions' ), //  'excerpt', 
        'taxonomies' => array( 'fruits', 'location_categories' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        
        'menu_icon' => 'dashicons-admin-site',
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'register_meta_box_cb' => 'add_location_metaboxes'
    );

    register_post_type( 'location', $args );
    
     $labels = array( 
        'name' => _x( 'Location Categories', 'location_categories' ),
        'singular_name' => _x( 'Location Category', 'location_categories' ),
        'search_items' => _x( 'Search Location Categories', 'location_categories' ),
        'popular_items' => _x( 'Popular Location Categories', 'location_categories' ),
        'all_items' => _x( 'All Location Categories', 'location_categories' ),
        'parent_item' => _x( 'Parent Location Category', 'location_categories' ),
        'parent_item_colon' => _x( 'Parent Location Category:', 'location_categories' ),
        'edit_item' => _x( 'Edit Location Category', 'location_categories' ),
        'update_item' => _x( 'Update Location Category', 'location_categories' ),
        'add_new_item' => _x( 'Add New Location Category', 'location_categories' ),
        'new_item_name' => _x( 'New Location Category', 'location_categories' ),
        'separate_items_with_commas' => _x( 'Separate location categories with commas', 'location_categories' ),
        'add_or_remove_items' => _x( 'Add or remove Location Categories', 'location_categories' ),
        'choose_from_most_used' => _x( 'Choose from most used Location Categories', 'location_categories' ),
        'menu_name' => _x( 'Location Categories', 'location_categories' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => false,

        'rewrite' => false,
        'query_var' => true
    );

    register_taxonomy( 'location_categories', array('location'), $args );
}


// Add the Recipe Meta Boxes

function add_location_metaboxes() {
	add_meta_box('ctp_location_details', 'Location Details', 'ctp_location_details', 'location', 'normal', 'default');	
}


// The Recipe Sidebar Metabox

function ctp_location_details() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="location_meta_noncename" id="location_meta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the total time data if its already been entered
	$latitude = get_post_meta($post->ID, 'latitude', true);
	
	echo '<p>Latitude (in degrees from equator)</p>';
	// Echo out the field
	echo '<input type="text" name="latitude" value="' . $latitude  . '" class="widefat" />';
	
	// Get the total time data if its already been entered
	$longitude = get_post_meta($post->ID, 'longitude', true);
	
	echo '<p>Latitude (in degrees from Prime Meridian)</p>';
	// Echo out the field
	echo '<input type="text" name="longitude" value="' . $longitude  . '" class="widefat" />';

	// Get the total time data if its already been entered
	$address = get_post_meta($post->ID, 'address', true);
	
	echo '<p>Street Address</p>';
	// Echo out the field
	echo '<input type="text" name="address" value="' . $address  . '" class="widefat" />';

	// Get the total time data if its already been entered
	$city = get_post_meta($post->ID, 'city', true);
	
	echo '<p>City</p>';
	// Echo out the field
	echo '<input type="text" name="city" value="' . $city  . '" class="widefat" />';

	// Get the total time data if its already been entered
	$state = get_post_meta($post->ID, 'state', true);
	
	echo '<p>State</p>';
	// Echo out the field
	echo '<input type="text" name="state" value="' . $state  . '" class="widefat" />';
	
	// Get the total time data if its already been entered
	$zipcode = get_post_meta($post->ID, 'zipcode', true);
	
	echo '<p>Zipcode</p>';
	// Echo out the field
	echo '<input type="text" name="zipcode" value="' . $zipcode  . '" class="widefat" />';
	
	// Get the total time data if its already been entered
	$phonenumber = get_post_meta($post->ID, 'phonenumber', true);
	
	echo '<p>Phone Number</p>';
	// Echo out the field
	echo '<input type="text" name="phonenumber" value="' . $phonenumber  . '" class="widefat" />';
	
	
	
	
}


// Save the Metabox Data

function wpt_save_location_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !isset($_POST['location_meta_noncename']) || !wp_verify_nonce( $_POST['location_meta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$location_meta['latitude'] = $_POST['latitude'];
	$location_meta['longitude'] = $_POST['longitude'];
	$location_meta['longitude'] = $_POST['longitude'];
	$location_meta['longitude'] = $_POST['longitude'];	
	$location_meta['longitude'] = $_POST['longitude'];
	$location_meta['longitude'] = $_POST['longitude'];
	$location_meta['longitude'] = $_POST['longitude'];
		
	// Add values of $recipes_meta as custom fields
	
	foreach ($location_meta as $key => $value) { // Cycle through the $recipes_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

add_action('save_post', 'wpt_save_location_meta', 1, 2); // save the custom fields