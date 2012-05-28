<?php
/*
Plugin Name: BNS Inline Asides
Plugin URI: http://buynowshop.com/plugins/bns-inline-asides/
Description: This plugin will allow you to style sections of post content with added emphasis by leveraging a style element from the active theme.
Version: 0.6.2
Text Domain: bns-ia
Author: Edward Caissie
Author URI: http://edwardcaissie.com/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * BNS Inline Asides
 *
 * This plugin will allow you to style sections of post content with added
 * emphasis by leveraging a style element from the active theme.
 *
 * @package     BNS_Inline_Asides
 * @link        http://buynowshop.com/plugins/bns-inline-asides/
 * @link        https://github.com/Cais/bns-inline-asides/
 * @link        http://wordpress.org/extend/plugins/bns-inline-asides/
 * @version     0.6.2
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2011-2012, Edward Caissie
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @version 0.6.2
 * @date    May 28, 2011
 *
 * @todo Add type=Nota Bene -or- NB
 */

/** Credits for jQuery assistance: Trevor Mills www.topquarkproductions.ca */

/**
 * BNS Inline Asides TextDomain
 * Make plugin text available for translation (i18n)
 *
 * @package:    BNS_Inline_Asides
 * @since:      0.6
 *
 * @internal    Note: Translation files are expected to be found in the plugin root folder / directory.
 * @internal    `bns-ia` is being used in place of `bns-inline-asides`
 *
 * @uses        load_plugin_textdomain
 */
load_plugin_textdomain( 'bns-ia' );
// End: BNS Inline Asides TextDomain

/**
 * Check installed WordPress version for compatibility
 *
 * @package     BNS_Inline_Asides
 * @since       0.1
 *
 * @internal    WordPress 3.0 required in reference to home_url()
 *
 * @uses        (global) $wp_version
 *
 * @version     0.6
 * Last revised November 21, 2011
 * Re-write to be i18n compatible
 */
global $wp_version;
$exit_ver_msg = __( 'BNS Inline Asides requires a minimum of WordPress 3.0, <a href="http://codex.wordpress.org/Upgrading_WordPress">Please Update!</a>', 'bns-ia' );
if ( version_compare( $wp_version, "3.0", "<" ) ) {
    exit ( $exit_ver_msg );
}

/** Define some constants to save some keying */
define( 'BNSIA_URL', plugin_dir_url( __FILE__ ) );
define( 'BNSIA_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Enqueue Plugin Scripts and Styles
 *
 * Adds plugin stylesheet and allows for custom stylesheet to be added by end-user.
 *
 * @package BNS_Inline_Asides
 * @since   0.4.1
 *
 * @uses    wp_enqueue_script
 * @uses    wp_enqueue_style
 * @uses    (CONSTANT) BNSIA_URL
 * @uses    (CONSTANT) BNSIA_PATH
 */
function BNSIA_Scripts_and_Styles() {
        /* Enqueue Scripts */
		wp_enqueue_script( 'jquery' );
		/**
         * @todo Move scripts into their own folder? ... and localize?
         * wp_enqueue_script( 'bnsia_script', BNSIA_PATH . 'bnsia-script.js', array( 'jquery' ) );
         * wp_localize_script( 'bnsia_script', 'BNSIA_Settings', array( 'variable_1' => "some value", 'variable_2' => "another value" ) );
         */

        /* Enqueue Style Sheets */
        wp_enqueue_style( 'BNSIA-Style', BNSIA_URL . 'bnsia-style.css', array(), '0.6', 'screen' );
        if ( is_readable( BNSIA_PATH . 'bnsia-custom-types.css' ) ) {
            wp_enqueue_style( 'BNSIA-Custom-Types', BNSIA_URL . 'bnsia-custom-types.css', array(), '0.6', 'screen' );
        }
}
add_action( 'wp_enqueue_scripts', 'BNSIA_Scripts_and_Styles' );

// Let's begin ...
/**
 * BNS Inline Asides Shortcode
 *
 * @package BNS_Inline_Asides
 * @since   0.1
 *
 * @param   $atts - shortcode attributes
 * @param   null $content - the content
 *
 * @uses    bnsia_theme_element
 * @uses    do_shortcode
 * @uses    shortcode_atts
 *
 * @return  string
 */
function bns_inline_asides_shortcode( $atts, $content = null ) {
        extract( shortcode_atts( array( 'type'   => 'Aside',
                                        'show'   => 'To see the <em>%s</em> click here.',
                                        'hide'   => 'To hide the <em>%s</em> click here.',
                                        'status' => 'open',
                                 ), $atts )
        );

        /** clean up shortcode properties */
        /** @var $status string - used as toggle switch */
        $status = esc_attr( strtolower( $status ) );
        if ( $status != "open" )
            $status = "closed";

        /**
         * @var $type_class string - leaves any end-user capitalization for aesthetics
         * @todo Find a cleaner way to modify the $text_class variable
         */
        /** @var $type string - default: Aside; or defined by end-user */
        $type_class = esc_attr( strtolower( $type ) );
        /** replace whitespace with a single space */
        $type_class = preg_replace( '/\s\s+/', ' ', $type_class );
        /** replace space with a hyphen to create nice CSS classes */
        $type_class = preg_replace( '/\\040/', '-', $type_class );

        /** no need to duplicate the default 'aside' class */
        if ( $type_class == 'aside' ) {
            $type_class = '';
        } else {
            $type_class = ' ' . $type_class;
        }

        /**
         * BNSIA Theme Element
         *
         * Plugin currently supports <blockquote> and <p> block elements, or the default <div class = bnsia>
         *
         * @package BNS_Inline_Asides
         * @since 0.6
         * @internal manual edit is required to change
         *
         * @return string
         *
         * @version 0.6.1
         * Last revised November 22, 2011
         * Corrected issue with conditional - Fatal error: Cannot redeclare bnsia_theme_element()
         *
         * @todo Add option page to choose which theme element, if any, to use
         */

        if ( ! function_exists( 'bnsia_theme_element' ) ) {
            /**
             * BNS Inline Asides Theme Element
             * CSS / HTML element to use as container
             *
             * @return string|null
             */
            function bnsia_theme_element() {
                    return '';
                    // return 'blockquote';
                    // return 'p';
            }
        }

        // The secret sauce ...
        /** @var $show string - used as boolean control */
        /** @var $hide string - used as boolean control */
        $toggle_markup = '<div class="aside-toggler ' . $status . '">'
                         . '<span class="open-aside' . $type_class . '">' . sprintf( __( $show ), esc_attr( $type ) ) . '</span>'
                         . '<span class="close-aside' . $type_class . '">' . sprintf( __( $hide ), esc_attr( $type ) ) . '</span>
                         </div>';
        if ( bnsia_theme_element() == '' ) {
            $return = $toggle_markup . '<div class="bnsia aside' . $type_class . ' ' . $status . '">' . do_shortcode( $content ) . '</div>';
        } else {
            $return = $toggle_markup . '<' . bnsia_theme_element() . ' class="aside' . $type_class . ' ' . $status . '">' . do_shortcode( $content ) . '</' . bnsia_theme_element() . '>';
        }

        static $script_output;
        if ( ! isset( $script_output ) ) {
            $return .= '<script type="text/javascript">
            /* <![CDATA[ */
            jQuery( document ).ready( function(){
                jQuery( ".aside-toggler" ).click( function(){
                    jQuery( this ).toggleClass( "open" ).toggleClass( "closed" ).next( "' . bnsia_theme_element() . '.aside" ).slideToggle( "slow", function(){
                        jQuery( this ).toggleClass( "open" ).toggleClass( "closed" );
                    });
                });
            });
            /* ]]> */
            </script>';
            $script_output = true;
        }
        return $return;
}

/**
 * We're done ... let's wrap this up into a simple shortcode!
 * @example [aside type="Aside" status="open" show="To see the <em>%s</em> click here." hide="To hide the <em>%s</em> click here."]The aside text.[/aside]
 *
 * @todo Review for potential conflict with WordPress default post-format 'aside'
 */
add_shortcode( 'aside', 'bns_inline_asides_shortcode' );