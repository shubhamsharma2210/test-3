<?php
/* 
Template Name: Addevent


*/


get_header();
?>


<div class="form-container">
    <h2>Submit Your Details</h2>
    <div id="response"></div>
    <form id="eventForm" enctype="multipart/form-data">
        <input type="hidden" name="action" value="handle_event_submission">
        <?php wp_nonce_field('event_submission_nonce'); ?>

        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" id="image" name="thumbnail" required>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="short-desc">Short Description</label>
            <input type="text" id="excerpt" name="excerpt" required>
        </div>
        <div class="form-group">
            <label for="content">Description</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div class="form-group">
            <select name="category" id="category">
                <?php
                $categories = get_terms(['taxonomy' => 'event_category', 'hide_empty' => false]);
                foreach ($categories as $category) {
                    echo "<option value='{$category->term_id}'>{$category->name}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="submit">Send</button>
        </div>
    </form>

    

</div>


<?php get_footer(); ?>