<?php
function intanjayakab_scripts() {
    wp_enqueue_style( 'intanjayakab-style', get_stylesheet_uri() );
    wp_enqueue_style( 'intanjayakab-custom-style', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0.0' );
    // Enqueue FontAwesome for icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' );
    if ( is_front_page() ) {
        wp_enqueue_script( 'intanjayakab-home', get_template_directory_uri() . '/assets/js/home.js', array(), '1.0.0', true );
    }
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

function intanjayakab_register_dokumen_publik_cpt() {
    register_post_type('dokumen_publik', array(
        'labels' => array(
            'name' => 'Dokumen Publik',
            'singular_name' => 'Dokumen Publik',
            'add_new_item' => 'Tambah Dokumen',
            'edit_item' => 'Edit Dokumen',
            'menu_name' => 'Dokumen Publik'
        ),
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'dokumen'),
        'supports' => array('title'),
        'menu_position' => 22,
        'menu_icon' => 'dashicons-media-document'
    ));
}
add_action('init','intanjayakab_register_dokumen_publik_cpt');

function intanjayakab_register_dokumen_taxonomy() {
    register_taxonomy('dokumen_kategori', 'dokumen_publik', array(
        'labels' => array(
            'name' => 'Kategori Dokumen',
            'singular_name' => 'Kategori Dokumen',
            'add_new_item' => 'Tambah Kategori Dokumen',
            'edit_item' => 'Edit Kategori Dokumen'
        ),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'kategori-dokumen')
    ));
}
add_action('init','intanjayakab_register_dokumen_taxonomy');

function intanjayakab_seed_dokumen_terms() {
    $defaults = array(
        'Perencanaan',
        'Keuangan',
        'Produk Hukum',
        'Kinerja Pemerintah',
        'Pengadaan Barang & Jasa',
        'Data & Statistik',
        'SOP & Standar Layanan',
        'Dokumen PPID'
    );
    foreach ($defaults as $name) {
        if (!term_exists($name, 'dokumen_kategori')) {
            wp_insert_term($name, 'dokumen_kategori');
        }
    }
}
add_action('init','intanjayakab_seed_dokumen_terms');

function intanjayakab_dokumen_metabox() {
    add_meta_box('dokumen_file_box','File Dokumen','intanjayakab_dokumen_fields_render','dokumen_publik','normal','default');
}
add_action('add_meta_boxes','intanjayakab_dokumen_metabox');

function intanjayakab_dokumen_fields_render($post) {
    $file = get_post_meta($post->ID,'dokumen_file',true);
    wp_nonce_field('dokumen_fields_nonce','dokumen_fields_nonce');
    wp_enqueue_media();
    echo '<p><label>File Dokumen</label><br>';
    echo '<input type="text" id="dokumen_file" name="dokumen_file" value="'.esc_attr($file).'" placeholder="https://.../dokumen.pdf" style="width:70%" /> ';
    echo '<button type="button" class="button" id="dokumen_file_btn">Pilih dari Media</button></p>';
    echo '<script type="text/javascript">jQuery(function($){var frame;$("#dokumen_file_btn").on("click",function(e){e.preventDefault();if(frame){frame.open();return;}frame=wp.media({title:"Pilih Dokumen",button:{text:"Gunakan File"},multiple:false});frame.on("select",function(){var attachment=frame.state().get("selection").first().toJSON();$("#dokumen_file").val(attachment.url);});frame.open();});});</script>';
}

function intanjayakab_dokumen_save($post_id) {
    if (!isset($_POST['dokumen_fields_nonce']) || !wp_verify_nonce($_POST['dokumen_fields_nonce'],'dokumen_fields_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && $_POST['post_type']==='dokumen_publik') {
        if (!current_user_can('edit_post',$post_id)) return;
    }
    $file = isset($_POST['dokumen_file']) ? esc_url_raw($_POST['dokumen_file']) : '';
    update_post_meta($post_id,'dokumen_file',$file);
}
add_action('save_post','intanjayakab_dokumen_save');
function intanjayakab_register_background_cpt() {
    register_post_type('site_background', array(
        'labels' => array(
            'name' => 'Background',
            'singular_name' => 'Background',
            'add_new_item' => 'Tambah Background',
            'edit_item' => 'Edit Background',
            'menu_name' => 'Background'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'supports' => array('title','thumbnail'),
        'menu_position' => 21,
        'menu_icon' => 'dashicons-format-image'
    ));
}
 
register_post_meta('dokumen_publik','dokumen_file', array(
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
    'sanitize_callback' => 'esc_url_raw',
    'auth_callback' => '__return_true'
));

function intanjayakab_rest_register_dokumen_routes() {
    register_rest_route('intanjaya/v1', '/dokumen', array(
        'methods' => 'GET',
        'callback' => 'intanjayakab_rest_get_dokumen',
        'args' => array(
            'page' => array('default' => 1),
            'per_page' => array('default' => 10),
            'kategori' => array(),
            'search' => array()
        ),
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init','intanjayakab_rest_register_dokumen_routes');

function intanjayakab_rest_get_dokumen(WP_REST_Request $req) {
    $page = max(1, intval($req->get_param('page')));
    $per = max(1, min(100, intval($req->get_param('per_page'))));
    $kategori = sanitize_text_field($req->get_param('kategori'));
    $search = sanitize_text_field($req->get_param('search'));
    $args = array(
        'post_type' => 'dokumen_publik',
        'post_status' => 'publish',
        'paged' => $page,
        'posts_per_page' => $per,
        's' => $search
    );
    if (!empty($kategori)) {
        $args['tax_query'] = array(array(
            'taxonomy' => 'dokumen_kategori',
            'field' => 'slug',
            'terms' => $kategori
        ));
    }
    $q = new WP_Query($args);
    $items = array();
    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            $id = get_the_ID();
            $file = get_post_meta($id,'dokumen_file',true);
            $terms = wp_get_post_terms($id,'dokumen_kategori');
            $cats = array();
            foreach ($terms as $t) {
                $cats[] = array('id'=>$t->term_id,'slug'=>$t->slug,'name'=>$t->name);
            }
            $items[] = array(
                'id' => $id,
                'title' => get_the_title(),
                'file_url' => $file ?: '',
                'permalink' => get_permalink($id),
                'categories' => $cats
            );
        }
        wp_reset_postdata();
    }
    $total = intval($q->found_posts);
    $total_pages = intval($q->max_num_pages);
    return new WP_REST_Response(array(
        'page' => $page,
        'per_page' => $per,
        'total' => $total,
        'total_pages' => $total_pages,
        'items' => $items
    ), 200);
}
