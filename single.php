<?php get_header(); ?>


<div class="page-container">
    <div class="page">
        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large'); ?>
        <img class="page-image" src="<?php echo $image[0] ?>" alt="" width="100%" height="400px">
        <h4 class="page-title"><?php the_title(); ?></h1>
            <p class="date"><?php echo get_the_date(); ?></p>
            <p class="description"><?php the_content(); ?></p
                </div>
    </div>




    <?php get_footer(); ?>