<?php
/**
 * Adds the the `p2p_slide` post type.
 *
 * @author          Christopher Davis <chris [AT] classicalguitar.org>
 * @copyright       Christopher Davis 2012
 * @since           1.0
 * @license         GPLv2
 */

class P2PSlides_Post_Type
{
    /**
     * the post type key.
     *
     * @since   1.0
     */
    const TYPE = 'p2p_slide';

    /**
     * Adds actions and such.
     *
     * @since   1.0
     * @access  public
     * @uses    add_action
     * @return  null
     */
    public static function init()
    {
        add_action(
            'init',
            array(__CLASS__, 'register')
        );

        add_action(
            'after_setup_theme',
            array(__CLASS__, 'setup'),
            100
        );
    }

    /**
     * Hooked into `init`.  Registers the post type.
     *
     * @since   1.0
     * @access  public
     * @uses    register_post_type
     * @return  null
     */
    public static function register()
    {
        $labels = array(
            'singular_name'         => __('Slide', 'p2p-slides'),
            'add_new'               => __('New Slide','p2p-slides'),
            'all_items'             => __('All Slides', 'p2p-slides'),
            'edit_item'             => __('Edit Slide', 'p2p-slides'),
            'view_item'             => __('View Slide', 'p2p-slides'),
            'search_items'          => __('Search Slides', 'p2p-slides'),
            'not_found'             => __('No Slides Found', 'p2p-slides'),
        );

        $labels['add_new_item'] = $labels['add_new'];
        $labels['new_item'] = $labels['add_new'];
        $labels['not_found_in_trash'] = $labels['not_found'];

        $args = array(
            'label'                 => __('Slides', 'p2p-slides'),
            'labels'                => $labels,
            'public'                => false,
            'show_ui'               => true,
            'show_in_admin_bar'     => false,
            'menu_position'         => 21,
            'capability_type'       => apply_filters('p2pslides_cap', 'page'),
            'supports'              => array(
                'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
            'query_var'             => false, // does this need to be here?
        );

        register_post_type(self::TYPE, $args);
    }

    /**
     * Hooked in late to `after_setup_theme`.  Checks to see if our theme
     * already supports the `p2p-slides` feature.  If it doesn't, add the
     * feature to the pages.
     *
     * @since   1.0
     * @access  public
     * @uses    current_theme_supports
     * @uses    add_theme_support
     * @return  null
     */
    public static function setup()
    {
        if(!current_theme_supports('p2p-slides'))
            add_theme_support('p2p-slides', array('page'));
    }
}
