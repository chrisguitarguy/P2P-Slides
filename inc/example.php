<?php
/**
 * Template Name: Slides Template
 * Description: A Page Template that shows off slides. Note: this is probably a little rough.
 */

// Enqueue showcase script for the slider
wp_enqueue_script( 'twentyeleven-showcase', get_template_directory_uri() . '/js/showcase.js', array( 'jquery' ), '2011-04-28' );

get_header(); ?>

<div id="primary" class="showcase">
    <div id="content" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php if($post->slides): ?>
                <?php
                    if ( function_exists( 'get_custom_header' ) )
                        $header_image_width = get_theme_support( 'custom-header', 'width' );
                    else
                        $header_image_width = HEADER_IMAGE_WIDTH;
                ?>

                <div class="featured-posts">
                    <h1 class="showcase-heading"><?php _e( 'Slides', 'twentyeleven' ); ?></h1>

                    <?php
                    $counter_slider = 0;
                    foreach($post->slides as $slide):
                    $counter_slider++;
                    ?>
                        <?php
                        $feature_class = 'feature-text';

                        if ( has_post_thumbnail($slide->ID) )
                        {
                            $feature_class = 'feature-image small';

                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $slide->ID ), array( $header_image_width, $header_image_width ) );

                            if ( $image[1] >= $header_image_width )
                            {
                                // If bigger, let's add a BIGGER class. It's EXTRA classy now.
                                $feature_class = 'feature-image large';
                            }
                        }
                        $link = get_permalink($slide->ID);
                        ?>

                        <section class="featured-post <?php echo $feature_class; ?>" id="featured-post-<?php echo $counter_slider; ?>">

                            <?php
                                /**
                                 * If the thumbnail is as big as the header image
                                 * make it a large featured post, otherwise render it small
                                 */
                                if ( has_post_thumbnail($slide->ID) ) {
                                    if ( $image[1] >= $header_image_width )
                                        $thumbnail_size = 'large-feature';
                                    else
                                        $thumbnail_size = 'small-feature';

                                    echo get_the_post_thumbnail( $slide->ID, $thumbnail_size );
                                }
                            ?>
                            <article id="post-<?php echo $slide->ID ?>" class="<?php echo $feature_class; ?>">
                                <header class="entry-header">
                                    <h2 class="entry-title"><?php echo $slide->post_title; ?></h2>
                                </header><!-- .entry-header -->

                                <div class="entry-summary">
                                    <?php echo $slide->post_excerpt; ?>
                                </div><!-- .entry-content -->
                            </article><!-- #post-<?php echo $slide->ID ?> -->
                        </section>
                    <?php endforeach; ?>
                    <nav class="feature-slider">
                        <ul>
                        <?php foreach(range(1, $counter_slider) as $counter): ?>
                            <?php
                            if($counter == 1)
                                $class = 'class="active"';
                            else
                                $class = '';
                            ?>
                            <li>
                                <a href="#featured-post-<?php echo $counter; ?>" <?php echo $class; ?>></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </nav>
                </div><!-- .featured-posts -->
            <?php endif; ?>
            <?php
                /**
                 * We are using a heading by rendering the_content
                 * If we have content for this page, let's display it.
                 */
                if ( '' != get_the_content() )
                    get_template_part( 'content', 'intro' );
            ?>

        <?php endwhile; ?>

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
