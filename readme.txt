=== P2P Slides ===
Contributors: chrisguitarguy
Donate link: http://www.pwsausa.org/give.htm
Tags: slider, slides, posts to posts
Requires at least: 3.4.2
Tested up to: 3.5
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A slider that uses Posts 2 Posts to associate post types with a new, custom slide post type.

== Description ==

**Note:** This plugin requires [Posts 2 Posts](http://wordpress.org/extend/plugins/posts-to-posts/)

Allows you to associate a custom post type ("slides") with any of your other post
types (defaults to "pages").  This is useful for theme developers of those that
want to add custom sliders around your theme.

This plugin does not provide you out of the box front end functionality. If you're
looking for a drop in and play slider, this isn't it.


== Installation ==

First, install and active [Posts 2 Posts](http://wordpress.org/extend/plugins/posts-to-posts/).

Then, use the WordPress installer to install this plugin or ...

1. Click the big orrange button to download the plugin
2. Unzip the plugin files
3. Upload the `p2p-slides` folder to your `/wp-content/plugins/` directory
4. Activate the plugin in the admin area

After installing, you should see a new meta box on your edit screen for pages.

If you wish to modify what post types get associated with slides, simply hook
into `after_setup_theme` and add theme support for `p2p-slides`.

    <?php
    add_action('after_setup_theme', 'my_special_setup');
    function my_special_setup()
    {
        // this is the same as just having the plugin installed
        add_theme_support('p2p-slides');

        add_theme_support('p2p-slides', array('a-post-type', 'another-post-type'));
    }

To use the slides, you'll need to check the `slides` property of each `$post`.

    <?php
    // start the loop as normal
    while(have_posts()): the_post();
    ?>

        <?php if($post->slides): ?>
            We have slides! Loop through them.
            <?php foreach($post->slides as $slide): ?>
                Do stuff with $slide here, it's just a post object
            <?php endforeach; ?>
        <?php endif; ?>

    <?php endwhile; ?>

You can find a more complete example, in the form of a page template for `twentyeleven` in the P2P Slides' `inc` directory.

== Frequently Asked Questions ==

= Why no front end prettiness? =

Because that's a theme's job.  This plugin is only meant to provide you with
tools to extend your theme or child theme.

= Is this Posts 2 Posts legit? =

Yes. [Posts 2 Posts](http://wordpress.org/extend/plugins/posts-to-posts/)
is amazing.

== Screenshots ==

1. The meta box.

== Changelog ==

= 1.0 =

* Initial version.

== Upgrade Notice ==

= 1.0 =

* It's new. try it.
