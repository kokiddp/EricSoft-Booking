<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.elk-lab.com
 * @since      1.0.0
 *
 * @package    Veb
 * @subpackage Veb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Veb
 * @subpackage Veb/public
 * @author     Gabriele Coquillard <gabriele@visamultimedia.com>
 */
class Veb_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $environment    The environment state of the plugin.
	 */
	private $environment;

	/**
	 * Shortcodes class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Veb_Public_Shortcodes		$shortcodes		Shortcodes class instance.
	 */
	private $shortcodes;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $environment ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->environment = $environment;

		$this::add_dependencies();

		$this->shortcodes = new Veb_Public_Shortcodes();

		$this->options = get_option( 'veb_options' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( $this->environment == 'production' ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/veb-public.min.css', array(), $this->version, 'all' );
		}
		else {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/veb-public.css', array(), time(), 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( $this->environment == 'production' ) {
			wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/veb-public.min.js', array( 'jquery' ), $this->version, false );
		}
		else {
			wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/veb-public.js', array( 'jquery' ), time(), false );
		}

		$option_array = array(
			'url' => $this->options['url'],
			'idh' => $this->options['idh'],
			'minNights' => $this->options['min_nights'],
			'maxRooms' => $this->options['max_rooms'],
			'maxPeople' => $this->options['max_people'],
			'defaultAdults' => $this->options['default_adults'],
			'minAdultsFirstRoom' => $this->options['min_adults_first_room'],
			'minAdultsOtherRooms' => $this->options['min_adults_other_rooms'],
		);
		wp_localize_script( $this->plugin_name, 'veb_options', $option_array );

		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Load the dependencies for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function add_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-veb-public-shortcodes.php';

	}

}
