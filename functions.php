<?php

function enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );


/**
 * Edit Archive Title
 */
add_filter( 'get_the_archive_title', function ( $title ) {
    if( is_category() ) {

        $title = single_cat_title( '', false );

    } else if (strpos($title, ':') !== false) {
    	$parse = explode(':', $title);
    	if (isset($parse[1])) {
    		$title = $parse[1];
    	}
    }
    return $title;

}, 15);


# Custom Query 
function twentyseventeen_child_posts($query) {
        // Adjust Events Query
    if (
        ! is_admin()
        AND is_post_type_archive('events')
        AND $query->is_main_query()
    ) {
        $today = date('Ymd');
        $query->set('posts_per_page',10);
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'event_date');
        $query->set('order', 'asc');
        $query->set('meta_query', [
            [
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'date'
            ]
        ]);

    }
}
add_action('pre_get_posts', 'twentyseventeen_child_posts');



# loads all of the necessary files for the theme
function twentyseventeen_child_files() {
    // loads css files
    wp_enqueue_style('twentyseventeen_child_main_styles',
        get_theme_file_uri('css/style.css'),
        null,
        microtime() // disables cache during development
    );
    // loads js files
    wp_enqueue_script(
        'seventeen_child_scripts_bundled',
        get_theme_file_uri('js/scripts-bundled.js'),
        null,
        microtime(), // disables cache during development
        true
    );
    // variables used on frontend
    wp_localize_script('seventeen_child_scripts_bundled', 'seventeenData', [
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ]);

}
add_action('wp_enqueue_scripts','twentyseventeen_child_files');

# Add Custom Url To Logo
function twentyseventeen_child_header_url(){
    return esc_url(site_url());
}
add_filter('login_headerurl', 'twentyseventeen_child_header_url');

# Add CSS to Admin Login
function twentyseventeen_login_css() {
    twentyseventeen_child_files();
}
add_action('login_enqueue_scripts','twentyseventeen_login_css');

# Display Login/Logout in Menu
function add_login_logout_link($items, $args) {
        ob_start();
        wp_loginout('index.php');
        $loginoutlink = ob_get_contents();
        ob_end_clean();

        if (!is_user_logged_in()) {
            $items .= '<li><a href="'.wp_registration_url().'" >'. __('Register') .'</a></li>';
        } else {
            $items .= '<li><a href="'.site_url('my-events').'" >'. __('My Events') .'</a></li>';
            $items .= '<li><a href="'.site_url('my-vendors').'" >'. __('My Vendors') .'</a></li>';
        }

        $items .= '<li>'. $loginoutlink .'</li>';
    return $items;
}
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);

# Redirect Users to Frontend
function redirectTwentySeventeenChildUsers() {
    $currentUser = wp_get_current_user();
    if (!in_array('administrator', $currentUser->roles)) {
        wp_redirect(site_url('/')); exit;
    }
}
add_action('admin_init', 'redirectTwentySeventeenChildUsers');

#Do not show admin bar to others
function noSubsAdminBar() {
    if (count($currentUser->roles) === 1 AND $currentUser->roles[0] === 'subscriber') {
        show_admin_bar(false); 
    }
}
add_action('wp_action', 'noSubsAdminBar');

function seventeenChildCustomPagination($nextPage, $prevPage, $currentPage, $total) {
    ?>
    <nav class="navigation pagination" role="navigation" style="width:100%;border-top:none;">
       <div class="nav-links">
        <?php if ($prevPage <= $total AND $currentPage > 1) :?>
          <a class="prev page-numbers" href="<?=home_url()?>/my-events/page/<?=$prevPage?>/">
             <span class="screen-reader-text">Prev page</span>
             <svg class="icon icon-arrow-left" aria-hidden="true" role="img">
                <use href="#icon-arrow-left" xlink:href="#icon-arrow-left"></use>
             </svg>
          </a>
        <?php endif; ?>
        <?php if ($nextPage <= $total) :?>
          <a class="next page-numbers" href="<?=home_url()?>/my-events/page/<?=$nextPage?>/">
             <span class="screen-reader-text">Next page</span>
             <svg class="icon icon-arrow-right" aria-hidden="true" role="img">
                <use href="#icon-arrow-right" xlink:href="#icon-arrow-right"></use>
             </svg>
          </a>
        <?php endif; ?>
       </div>
    </nav>
    <?php

}

function get_post_type_by_name($name) {
    global $wp_post_types; 
    return isset($wp_post_types[$name]) ? $wp_post_types[$name] : [];

}












