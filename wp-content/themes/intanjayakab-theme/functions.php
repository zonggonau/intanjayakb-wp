<?php
function intanjayakab_scripts() {
    wp_enqueue_style( 'intanjayakab-style', get_stylesheet_uri() );
    wp_enqueue_style( 'intanjayakab-custom-style', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0.0' );
    // Enqueue FontAwesome for icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'intanjayakab_scripts' );

function intanjayakab_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'intanjayakab_setup' );

function intanjayakab_register_layanan_cpt() {
    register_post_type('layanan', array(
        'labels' => array(
            'name' => 'Layanan',
            'singular_name' => 'Layanan',
            'add_new_item' => 'Tambah Layanan',
            'edit_item' => 'Edit Layanan',
            'menu_name' => 'Layanan'
        ),
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => false,
        'supports' => array('title','thumbnail','page-attributes'),
        'menu_position' => 20,
        'menu_icon' => 'dashicons-screenoptions'
    ));
}
add_action('init','intanjayakab_register_layanan_cpt');

function intanjayakab_layanan_metabox() {
    add_meta_box('layanan_fields','Pengaturan Layanan','intanjayakab_layanan_fields_render','layanan','normal','default');
}
add_action('add_meta_boxes','intanjayakab_layanan_metabox');

function intanjayakab_layanan_fields_render($post) {
    $icon = get_post_meta($post->ID,'layanan_icon',true);
    $color = get_post_meta($post->ID,'layanan_color',true);
    $link = get_post_meta($post->ID,'layanan_link',true);
    wp_nonce_field('layanan_fields_nonce','layanan_fields_nonce');
    echo '<p><label>Font Awesome Icon</label><br><input type="text" name="layanan_icon" value="'.esc_attr($icon).'" placeholder="fas fa-chart-bar" style="width:100%" /></p>';
    echo '<p><label>Warna Kartu (class)</label><br>';
    echo '<select name="layanan_color" style="width:100%">';
    $colors = array('bg-blue-dark','bg-cyan','bg-red','bg-blue','bg-red-bright','bg-blue-light','bg-green','bg-grey','bg-green-bright','bg-yellow','bg-brown','bg-green-light','bg-orange','bg-red-dark','bg-teal');
    foreach($colors as $c){
        $sel = $color===$c ? ' selected' : '';
        echo '<option value="'.esc_attr($c).'"'.$sel.'>'.esc_html($c).'</option>';
    }
    echo '</select></p>';
    echo '<p><label>Link</label><br><input type="url" name="layanan_link" value="'.esc_attr($link).'" placeholder="https://..." style="width:100%" /></p>';
}

function intanjayakab_layanan_save($post_id) {
    if (!isset($_POST['layanan_fields_nonce']) || !wp_verify_nonce($_POST['layanan_fields_nonce'],'layanan_fields_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && $_POST['post_type']==='layanan') {
        if (!current_user_can('edit_post',$post_id)) return;
    }
    $icon = isset($_POST['layanan_icon']) ? sanitize_text_field($_POST['layanan_icon']) : '';
    $color = isset($_POST['layanan_color']) ? sanitize_text_field($_POST['layanan_color']) : '';
    $link = isset($_POST['layanan_link']) ? esc_url_raw($_POST['layanan_link']) : '';
    update_post_meta($post_id,'layanan_icon',$icon);
    update_post_meta($post_id,'layanan_color',$color);
    update_post_meta($post_id,'layanan_link',$link);
}
add_action('save_post','intanjayakab_layanan_save');

function intanjayakab_ensure_fullview_page() {
    if ( get_page_by_path('tampilan-penuh') ) return;
    $page_id = wp_insert_post(array(
        'post_title' => 'Tampilan Penuh',
        'post_name'  => 'tampilan-penuh',
        'post_status'=> 'publish',
        'post_type'  => 'page'
    ));
    if ($page_id && !is_wp_error($page_id)) {
        update_post_meta($page_id,'_wp_page_template','template-full-view.php');
    }
}
add_action('init','intanjayakab_ensure_fullview_page');
