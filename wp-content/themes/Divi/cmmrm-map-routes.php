<?php
/**
 * Template Name: Maps Routes custom template
 */


get_header();

?>
<?php the_post(); ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content"><?php echo the_content(); ?></div>

<?php

get_footer();
