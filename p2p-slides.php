<?php
/*
Plugin Name: P2P Slides
Plugin URI: https://github.com/chrisguitarguy/P2P-Slides
Description: Asign slides to post types with Posts to Posts.  Useful for theme developers.
Version: 1.0
Text Domain: p2p-slides
Domain Path: /lang
Author: Christopher Davis
Author URI: http://christopherdavis.me
License: GPL2

    Copyright 2012 Christopher Davis

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('P2P_SLIDES_PATH', plugin_dir_path(__FILE__));

add_action('plugins_loaded', 'cd_p2pslides_load');
/**
 * Hooked into `plugins_loaded`. If Posts 2 Posts is installed, this function
 * will include the files we need.  If not, it will add an action to
 * `admin_notices` to alert the user.
 *
 * @since   1.0
 * @uses    add_action
 * @return  null
 */
function cd_p2pslides_load()
{
    if(function_exists('p2p_register_connection_type'))
    {
        require_once(P2P_SLIDES_PATH . 'inc/post-type.php');
        require_once(P2P_SLIDES_PATH . 'inc/p2p-integration.php');

        P2PSlides_Post_Type::init();
        P2PSlides_Integration::init();
    }
    else
    {
        add_action('admin_notices', 'cd_p2pslides_show_error');
    }
}

/**
 * Hooked into `admin_notices`.  Displays an error about Posts 2 Posts not
 * being installed.
 *
 * @since   1.0
 * @uses    __
 * @return  null
 */
function cd_p2pslides_show_error()
{
    ?>
    <div class="error">
        <p>
            <?php
            printf(
                __('P2P Slides requires %s. Please install it.', 'p2p-slides'),
                '<a href="http://wordpress.org/extend/plugins/posts-to-posts/">Posts to Posts</a>'
            );
            ?>
        </p>
    </div>
    <?php
}
