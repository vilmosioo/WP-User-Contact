<?php
/*
Plugin Name: WP User Contact
Plugin URI: https://github.com/vilmosioo/WP-User-Contact
Description: A simple WordPress plugin that adds additional contact details to registered users.  
Version: 0.0.1
Author: Vilmos Ioo
Author URI: http://vilmosioo.co.uk
License: GPL2

	Copyright 2014 Vilmos Ioo

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

// Define constants
define('WP_USER_CONTACT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_USER_CONTACT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_USER_CONTACT_PLUGIN_WORDPRESS_VERSION', get_bloginfo( 'version' ));

// Includes
// require_once(WP_USER_CONTACT_PLUGIN_DIR.'bower_components/wordpress-tools-.php');

class WPUserContact_Plugin {
	
	static function init(){
		return new WPUserContact_Plugin();
	}

	const ID = 'WP_USER_CONTACT';

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	private function __construct() {
		register_activation_hook(__FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook(__FILE__, array( &$this, 'deactivate' ) );
		
		// TODO write more functionality here
		add_filter('user_contactmethods', array(&$this, 'user_contactmethods'));
		// create contact shortcode
		add_shortcode('contact', array( &$this, 'print_contact_link' ));
	} 

	public function print_contact_link($atts, $content = null){
		extract(shortcode_atts(array('user_id' => '', 'type' => 'twitter', 'class' => 'icon'), $atts));
		if(!isset($user_id) || empty($user_id)) return;
		
		return "<a class='$type $class' href='".get_user_meta($user_id, $type, true)."'>".do_shortcode($content)."</a>";
	}

	public function user_contactmethods($user_contactmethods){

		$user_contactmethods['twitter'] = 'Twitter';
		$user_contactmethods['linkedin'] = 'LinkedIn';
		$user_contactmethods['github'] = 'Github';

		return $user_contactmethods;
	}


	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {

	} 

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	function deactivate( $network_wide ) {

	} 

} // end class

$GLOBALS['WPUserContact_Plugin'] = WPUserContact_Plugin::init();
?>