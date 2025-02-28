<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>./css/custom-style.css">
    <?php wp_head(); ?>
</head>

<body>
    <div class="container">
        <div class="header">
            <nav>
                <?php wp_nav_menu(array('theme_location' => 'header-menu')); ?>
                <hr>
            </nav>
        </div>
    </div>