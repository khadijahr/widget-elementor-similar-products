<?php
/**
 * Plugin Name: Elementor Similar Products Widget
 * Description: Affiche les produits similaires de la même sous-catégorie dans Elementor. 
 * Version:           	1.0.2
 * Requires at least: 	6.2
 * Requires PHP:      	7.0
 * Author:            	Khadija HARMOUCHE
 * Author URI:        	https://github.com/khadijahr
 * License:           	GPL v2 or later
 * License URI:       	https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function register_similar_products_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/similar-products-widget.php' );
    $widgets_manager->register( new \Elementor_Similar_Products_Widget() );
}
add_action( 'elementor/widgets/register', 'register_similar_products_widget' );
