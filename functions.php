function mysite_files() {

	wp_enqueue_script('mysite-js_search', get_stylesheet_directory_uri().'/my_functions/my_search.js', array('jquery'));

	wp_enqueue_script('mysite-js', get_stylesheet_directory_uri().'/my_functions/my_js.js', array('jquery'));
 
	wp_enqueue_style('mysite-css', get_stylesheet_directory_uri().'/my_functions/my_css.css');
	
	wp_enqueue_script('autocomplete', get_stylesheet_directory_uri().'/my_functions/jquery.auto-complete.js', array('jquery'));
 
	wp_enqueue_style('autocomplete.css', get_stylesheet_directory_uri().'/my_functions/jquery.auto-complete.css');
 
}
add_action('wp_enqueue_scripts', 'mysite_files');

function add_ajax_script() {

    wp_localize_script( 'ajax-js', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}

add_action( 'wp_enqueue_scripts', 'add_ajax_script' );

add_action('wp_ajax_nopriv_get_listing_names', 'ajax_listings');
add_action('wp_ajax_get_listing_names', 'ajax_listings');

function ajax_listings() {
    global $wpdb; //get access to the WordPress database object variable

    //get names of all businesse
    $name = $wpdb->esc_like(stripslashes($_POST['name'])).'%'; //escape for use in LIKE statement
    $sql = "select name 
    	from $wpdb->global 
    	where name like %s 
    	and post_type='portfolio' and post_status='publish'";

    $sql = $wpdb->prepare($sql, $name);
    $results = $wpdb->get_results($sql);

    //copy the business titles to a simple array
    $titles = array();
    foreach( $results as $r )
        $titles[] = addslashes($r->name );

    echo json_encode($titles); //encode into JSON format and output
    die(); //stop "0" from being output
}
