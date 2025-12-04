<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="classic-container">

    <div class="classic-logo-box">
        <?php if ( function_exists('get_site_icon_url') && get_site_icon_url() ) : ?>
            <img src="<?php echo esc_url(get_site_icon_url()); ?>" class="classic-logo">
        <?php else : ?>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Lambang_Kabupaten_Tabanan.png/1200px-Lambang_Kabupaten_Tabanan.png" class="classic-logo">
        <?php endif; ?>
    </div>

    <header class="classic-header">
        <p class="classic-subtitle">WEBSITE RESMI PEMERINTAH</p>
        <h1 class="classic-title">KABUPATEN INTAN JAYA</h1>
        <p class="classic-url">www.intanjayakab.go.id</p>
    </header>

    <main class="classic-grid">
        <?php
        $q = new WP_Query(array(
            'post_type' => 'layanan',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        $i = 0;
        if ($q->have_posts()):
            while ($q->have_posts()):
                $q->the_post();
                $icon = get_post_meta(get_the_ID(),'layanan_icon',true);
                $color = get_post_meta(get_the_ID(),'layanan_color',true);
                $link = get_post_meta(get_the_ID(),'layanan_link',true);
                $icon = $icon ? $icon : 'fas fa-circle';
                $href = $link ? $link : '#';
                $classes = 'classic-item';
                if ($color) { $classes .= ' ' . esc_attr($color); }
                echo '<a href="'.esc_url($href).'" class="'.$classes.'"><i class="'.esc_attr($icon).'"></i><span>'.esc_html(get_the_title()).'</span></a>';
                $i++;
                if ($i === 8) { echo '<div class="row-break"></div>'; }
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </main>

    <div class="classic-btn-wrap">
        <?php $full = get_page_by_path('tampilan-penuh'); $full_url = $full ? get_permalink($full) : home_url('/tampilan-penuh'); ?>
        <a href="<?php echo esc_url($full_url); ?>" class="classic-btn"><i class="fas fa-expand-arrows-alt"></i> Lihat Tampilan Penuh</a>
    </div>

    <footer class="classic-footer">
        <p>© 2010 - 2025 Pemerintah Kabupaten Intan Jaya • All Rights Reserved</p>
    </footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
