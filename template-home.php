<?php
/* 
Template Name: home


*/

get_header();
?>


    <h2 class="main-title">All Events</h2>
    <hr>
    <!-- <div class="news-categories">

    <?php

    $event = get_terms(['taxonomy' => 'event_category', 'hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC']);

    foreach ($event as $getNewsCatData) {
    ?>
        <div class="categories">
            <a class="categories_chips" href="<?php echo (get_category_link($getNewsCatData->term_id)); ?>"><?php echo esc_html($getNewsCatData->name); ?></a>
        </div>
    <?php } ?>
</div> -->
  
        <div class="card_container">
        <?php
    $args = array(
        'post_type'      => 'Event',
        'post_status'    => 'publish',
    );
    $wpQuery = new WP_Query($args);
    while ($wpQuery->have_posts()) {
        $wpQuery->the_post();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
    ?>
            <div class="card">
                <img src="<?php echo $image[0] ?>" alt="Card Image">
                <div class="card-content">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink() ?>">Read More</a>
                </div>
            </div>
            <?php } ?>

        </div>


 




<?php get_footer(); ?>