<?php
/**
 * Handles all the Posts 2 Posts integration: registers connection types,
 * fires off `each_connected` etc
 *
 * @author          Christopher Davis <chris [AT] classicalguitar.org>
 * @copyright       Christopher Davis 2012
 * @since           1.0
 * @license         GPLv2
 */

class P2PSlides_Integration
{
    /**
     * A key to help define connections.
     *
     * @since   1.0
     */
    const POSTFIX = '_to_slides';

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
            'p2p_init',
            array(__CLASS__, 'connections')
        );

        add_action(
            'loop_start',
            array(__CLASS__, 'start')
        );
    }

    /**
     * Hooked into `p2p_init`.  Registers the connections.
     *
     * @since   1.0
     * @access  public
     * @uses    p2p_register_connection_type
     * @return  null
     */
    public static function connections()
    {
        foreach(self::get_connectable() as $type)
        {
            p2p_register_connection_type(array(
                'name'      => $type . self::POSTFIX,
                'from'      => $type,
                'to'        => P2PSlides_Post_Type::TYPE,
                'sortable'  => 'from',
                'admin_box' => array(
                    'show'      => 'from',
                    'context'   => 'normal'
                ),
                'title'     => array('from' => __('Slides', 'p2p-slides')),
                'to_labels' => array(
                    'create'    => __('Add Slides', 'p2p-slides')
                ),
            ));
        }
    }

    /**
     * Hooked into `loop_start`.  If the current post type happens to have
     * slides connected to it, this will fetch them using `each_connected
     *
     * @since   1.0
     * @access  public
     * @uses    p2p_type
     * @uses    is_admin
     * @uses    is_main_query
     * @return  null
     */
    public static function start($q)
    {
        if(is_admin() || !$q->is_main_query())
            return;

        $c = self::get_connectable();

        $type = false;
        if(is_singular($c))
        {
            $type = get_queried_object()->post_type;
        }
        elseif(is_post_type_archive($c))
        {
            $type = $q->get('post_type');
        }

        if($type)
        {
            p2p_type($type . self::POSTFIX)->each_connected($q, array(
                'nopaging'          => true,
            ), 'slides');
        }
        else
        {
            array_map(function($p) {
                $p->slides = false;
            }, $q->posts);
        }
    }

    /**
     * Get all the connectable post types for registration.
     *
     * @since   1.0
     * @access  private
     * @uses    get_them_support
     * @return  array
     */
    private static function get_connectable()
    {
        $types = get_theme_support('p2p-slides');

        // no theme support
        if(!$types)
            return array();

        // theme support without type specified, use page
        if($types === true)
            return array('page');

        // theme support with post types listed
        return $types[0];
    }
}
