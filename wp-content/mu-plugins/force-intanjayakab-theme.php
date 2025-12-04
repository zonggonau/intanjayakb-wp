<?php
/**
 * Force activate the custom Intan Jaya theme if not active.
 */
add_action('init', function () {
    $target = 'intanjayakab-theme';
    if (function_exists('get_stylesheet')) {
        $current = get_stylesheet();
        $theme   = wp_get_theme($target);
        if ($current !== $target && $theme && $theme->exists()) {
            switch_theme($target);
        }
    }
});

