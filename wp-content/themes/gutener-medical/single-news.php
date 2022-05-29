<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Gutener
 */

get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="singel-post">
            <section class="header">
                <div class="container">
                    <h2><?= $post->post_title ?></h2>
                </div>
            </section>
            <section class="content container py-5">
                <p><?= get_post_meta($post->ID)['content'][0] ?></p>
            </section>
        </div>

<?php endwhile;
endif;

get_footer();
