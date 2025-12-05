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
        <p class="classic-url">"O Ndoma Dangge Inia Hanggia Dua Dia"</p>
    </header>

    <main class="classic-grid">
        <?php
        $q = new WP_Query(array(
            'post_type' => 'layanan',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        $items = array();
        if ($q->have_posts()):
            while ($q->have_posts()): $q->the_post();
                $items[] = array(
                    'title' => get_the_title(),
                    'icon' => get_post_meta(get_the_ID(),'layanan_icon',true),
                    'color' => get_post_meta(get_the_ID(),'layanan_color',true),
                    'link' => get_post_meta(get_the_ID(),'layanan_link',true),
                );
            endwhile; wp_reset_postdata();
        endif;

        $first = array_slice($items, 0, 8);
        foreach ($first as $it) {
            $icon = $it['icon'] ? $it['icon'] : 'fas fa-circle';
            $href = $it['link'] ? $it['link'] : '#';
            $classes = 'classic-item';
            if (!empty($it['color'])) { $classes .= ' ' . esc_attr($it['color']); }
            echo '<a href="'.esc_url($href).'" class="'.$classes.'" target="_blank" rel="noopener noreferrer"><i class="'.esc_attr($icon).'"></i><span>'.esc_html($it['title']).'</span></a>';
        }
        ?>
    </main>

    <?php if (count($items) > 8): ?>
    <section id="more-services" class="classic-grid more-services" style="display:none;">
        <?php
        $rest = array_slice($items, 8);
        foreach ($rest as $it) {
            $icon = $it['icon'] ? $it['icon'] : 'fas fa-circle';
            $href = $it['link'] ? $it['link'] : '#';
            $classes = 'classic-item';
            if (!empty($it['color'])) { $classes .= ' ' . esc_attr($it['color']); } else { $classes .= ' neutral'; }
            echo '<a href="'.esc_url($href).'" class="'.$classes.'" target="_blank" rel="noopener noreferrer"><i class="'.esc_attr($icon).'"></i><span>'.esc_html($it['title']).'</span></a>';
        }
        ?>
    </section>
    <?php endif; ?>

    <div class="classic-btn-wrap">
        <a href="#more-services" class="classic-btn" data-toggle="more-services"><i class="fas fa-expand-arrows-alt"></i> Lihat Tampilan Penuh</a>
    </div>

    <footer class="classic-footer">
        <p>© 2010 - 2025 Pemerintah Kabupaten Intan Jaya • All Rights Reserved</p>
    </footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
