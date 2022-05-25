<?php

/**
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Veb
 * @subpackage Veb/admin
 */


/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Veb
 * @subpackage Veb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Veb_Admin_Options {

	/**
	 * Helper class
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $options
	 */
	public $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->options = get_option( 'veb_options' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_add_options_page() {
		add_options_page( __('EricSoft Booking', 'visa-ericsoft-booking'), __('EricSoft Booking', 'visa-ericsoft-booking'), 'manage_options', 'veb', array( $this, 'veb_options_page' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_options_page() {
		include_once 'partials/veb-admin-display.php';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_init_options() {
		register_setting( 'veb_options', 'veb_options', array( $this, 'veb_options_validate' ) );
		
		add_settings_section( 'veb_main', __('Main Settings', 'visa-ericsoft-booking'), array( $this, 'veb_main_section_text' ), 'veb' );
		add_settings_field( 'veb_url', __('URL base', 'visa-ericsoft-booking'), array( $this, 'veb_setting_url'), 'veb', 'veb_main' );
		add_settings_field( 'veb_idh', __('IDH', 'visa-ericsoft-booking'), array( $this, 'veb_setting_idh'), 'veb', 'veb_main' );

		add_settings_section( 'veb_config', __('Configuration Settings', 'visa-ericsoft-booking'), array( $this, 'veb_config_section_text' ), 'veb' );
		add_settings_field( 'veb_min_nights', __('Minimum nights stay', 'visa-ericsoft-booking'), array( $this, 'veb_setting_min_nights'), 'veb', 'veb_config' );
		add_settings_field( 'veb_max_rooms', __('Maximum bookable rooms', 'visa-ericsoft-booking'), array( $this, 'veb_setting_max_rooms'), 'veb', 'veb_config' );
		add_settings_field( 'veb_max_people', __('Maximum people per room', 'visa-ericsoft-booking'), array( $this, 'veb_setting_max_people'), 'veb', 'veb_config' );
		add_settings_field( 'veb_default_adults', __('Default adults per room', 'visa-ericsoft-booking'), array( $this, 'veb_setting_default_adults'), 'veb', 'veb_config' );
		add_settings_field( 'veb_min_adults_first_room', __('Minimum adults in first room', 'visa-ericsoft-booking'), array( $this, 'veb_setting_min_adults_first_room'), 'veb', 'veb_config' );
		add_settings_field( 'veb_min_adults_other_rooms', __('Minimum adults in other rooms', 'visa-ericsoft-booking'), array( $this, 'veb_setting_min_adults_other_rooms'), 'veb', 'veb_config' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function veb_main_section_text() {
		echo '<p>' . __('Theese are the general settings', 'visa-ericsoft-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_url() {
		echo "<input type='text' style='width:100%' id='veb_url' name='veb_options[url]' value='{$this->options['url']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_idh() {
		echo "<input type='text' id='veb_idh' name='veb_options[idh]' value='{$this->options['idh']}' />";
	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function veb_config_section_text() {
		echo '<p>' . __('Theese are the configuration settings', 'visa-ericsoft-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_min_nights() {
		echo "<input type='number' step='1' min='1' id='veb_min_nights' name='veb_options[min_nights]' value='{$this->options['min_nights']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_max_rooms() {
		echo "<input type='number' step='1' min='1' id='veb_max_rooms' name='veb_options[max_rooms]' value='{$this->options['max_rooms']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_max_people() {
		echo "<input type='number' step='1' min='1' id='veb_max_people' name='veb_options[max_people]' value='{$this->options['max_people']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_default_adults() {
		echo "<input type='number' step='1' min='1' id='veb_default_adults' name='veb_options[default_adults]' value='{$this->options['default_adults']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_min_adults_first_room() {
		echo "<input type='number' step='1' min='1' id='veb_min_adults_first_room' name='veb_options[min_adults_first_room]' value='{$this->options['min_adults_first_room']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function veb_setting_min_adults_other_rooms() {
		echo "<input type='number' step='1' min='1' id='veb_min_adults_other_rooms' name='veb_options[min_adults_other_rooms]' value='{$this->options['min_adults_other_rooms']}' />";
	}


	/**
	 * Undocumented function
	 *
	 * @param mixed $input
	 * @return mixed
	 */
	public function veb_options_validate( $input ) {
		
		return $input;
	}
}
