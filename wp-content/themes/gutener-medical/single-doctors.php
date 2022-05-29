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
                <div class="row">
                    <div class="col-sm-12 col-md-4 text-center">
                        <img class="img-fluid rounded" src="<?= wp_get_attachment_image_url(get_post_meta($post->ID)['image'][0], 'full') ?>">
                        <h3 class="pt-3 m-0"><?= $post->post_title ?></h3>
                        <p class="mb-3"><?= get_post_meta($post->ID)['description'][0] ?></p>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <p><?= get_post_meta($post->ID)['content'][0] ?></p>
                    </div>
                </div>
            </section>
        </div>

<?php endwhile;
endif;

get_footer();
