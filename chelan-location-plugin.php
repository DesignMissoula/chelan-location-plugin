<?php

/*
Plugin Name:       Chelan Location Plugin
Plugin URI:        https://chelanfruit.com
Description:       Locations
Version:           2.1.1
Author:            Bradford Knowlton
GitHub Plugin URI: https://github.com/DesignMissoula/chelan-recipe-plugin
Requires WP:       3.8
Requires PHP:      5.3
*/

require_once ( plugin_dir_path( __FILE__ ) . '/inc/location-shortcode.php' );

require_once ( plugin_dir_path( __FILE__ ) . '/inc/class-location-widget.php' );



//    '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>';
/**
 * Proper way to enqueue scripts and styles
 */
function theme_name_scripts() {
	wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?v=3.exp', array( 'jquery' ), '1.0.0', false );
	// die('test');
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );


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
	add_meta_box('ctp_location_details', 'Location Details', 'ctp_location_details', 'location', 'normal', 'high');	
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
	$location_meta['address'] = $_POST['address'];
	$location_meta['city'] = $_POST['city'];	
	$location_meta['state'] = $_POST['state'];
	$location_meta['zipcode'] = $_POST['zipcode'];
	$location_meta['phonenumber'] = $_POST['phonenumber'];
		
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



if( !function_exists('format_phone_number')){
	
	function format_phone_number($number){
		$number = preg_replace('#[^0-9]#','',$number);
	
		if( ! $number || strlen($number) != 10 ){
			return 'N/A';
		}
		
		$number = preg_replace('#[^0-9]#','',$number);	
		$number = sprintf('(%d) %d-%d',substr($number,0,3),substr($number,3,3),substr($number,6,4));
		return $number;	
	}

} // end function_exists

function generate_map($atts){
	$map = '';
	
	
 /*
   [
  ['Bondi Beach', -33.890542, 151.274856, 4],
  ['Coogee Beach', -33.923036, 151.259052, 5],
  ['Cronulla Beach', -34.028249, 151.157507, 3],
  ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
  ['Maroubra Beach', -33.950198, 151.259302, 1]
]
*/

	$z = 1;
	
	global $post;
    
    $locations = array();
    
    $args = array( 'posts_per_page' => -1, 'post_type' => 'location' );
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); 
		$location = array();
		
		$location[] = get_the_title();
		
		$location[] = get_post_meta( get_the_ID(), 'latitude', true );
				
		$location[] = get_post_meta( get_the_ID(), 'longitude', true );
		
		// z index
		$location[] = ++$z;
		
		$fruits = wp_get_post_terms($post->ID, 'fruits', array("fields" => "names"));
		
		sort($fruits);
		
		$fruits = strtolower(join('', $fruits));
		
		
		$location[] = get_the_title().'<br/>'.get_post_meta( get_the_ID(), 'address', true ).'<br/>'.get_post_meta( get_the_ID(), 'city', true ).', '.get_post_meta( get_the_ID(), 'state', true ).' '.get_post_meta( get_the_ID(), 'zipcode', true ).'<br/>'.format_phone_number(get_post_meta( get_the_ID(), 'phonenumber', true )).'';
		
		
		if($fruits == 'apple' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_apple.gif";	
		}else if($fruits == 'applepear' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_pear_apple.gif";
		}else if($fruits == 'applecherry' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_cherry_apple.gif";
		}else if($fruits == 'cherry' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_cherry.gif";
		}else if($fruits == 'pear' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_pear.gif";
		}else if($fruits == 'cherrypear' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_pear_cherry.gif";
		}else if($fruits == 'applecherrypear' ){
			$location[] = "/wp-content/uploads/2015/07/Icon_cherry_apple_pear.gif";
		}

		
		$locations[] = $location;
	endforeach; 
	wp_reset_postdata();
	
	$map = '<script>
	var map;
	
	var getCen;
	
	var infowindow = null;
	
	/**
	 * Data for the markers consisting of a name, a LatLng and a zIndex for
	 * the order in which these markers should display on top of each
	 * other.
	 */
	var locations = '.json_encode($locations, JSON_PRETTY_PRINT).';


	function initialize() {
	  map = new google.maps.Map(document.getElementById("map-canvas"), {
	    zoom: 7,
	    center: {lat: 47.286835, lng: -120.212614}
	  });
	 
		getCen = map.getCenter();
		
		setMarkers(map, locations);

	}
	
	function setMarkers(map, locations) {
	// Add markers to the map

	infowindow = new google.maps.InfoWindow({
	  content: "loading..."
	});

  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  for (var i = 0; i < locations.length; i++) {
    var location = locations[i];
	var image = {
		url: location[5]
	};
	var myLatLng = new google.maps.LatLng(location[1], location[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        title: location[0],
        zIndex: location[3],
        html: location[4]
    });
    
	google.maps.event.addListener(marker, "click", function() {
		infowindow.setContent(this.html);
		infowindow.open(map,this);
	});
	

  }
}

	
	google.maps.event.addDomListener(window, "resize", function() {
		map.setCenter(getCen);
	});
	

	
	google.maps.event.addDomListener(window, "load", initialize);

    </script>
<div ><div class="flex-video widescreen vimeo" id="map-canvas"></div>
</div>';

	
	return $map;
}