<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <title><?php bloginfo('name'); ?></title>
</head>
<body <?php body_class(); ?>>

<div class="classic-container">
    <header class="classic-header">
        <h1 class="classic-title"><?php bloginfo('name'); ?></h1>
        <p class="classic-url"><?php bloginfo('description'); ?></p>
    </header>

    <main class="classic-grid">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php $desc = ''; if ( get_post_type() === 'dokumen_publik' ) { $desc = get_post_meta(get_the_ID(),'dokumen_deskripsi',true); } ?>
                <a href="<?php the_permalink(); ?>" class="classic-item">
                    <span><?php the_title(); ?></span>
                    <?php if ( !empty($desc) ) : ?>
                        <small class="classic-desc"><?php echo esc_html($desc); ?></small>
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Tidak ada konten.</p>
        <?php endif; ?>
    </main>

    <footer class="classic-footer">
        <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
