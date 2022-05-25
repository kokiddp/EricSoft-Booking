<?php

/**
 * The shortcodes class for the public-facing functionality of the plugin.
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Veb
 * @subpackage Veb/public
 */

/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Veb
 * @subpackage Veb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Veb_Public_Shortcodes {

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->options = get_option( 'veb_options' );
		$this::add_shortocdes();
	}

	/**
	 * Undocumented function
	 *
	 * @since    1.0.0
	 */
	public function add_shortocdes() {

		add_shortcode( 'veb_display_form', array( $this, 'veb_display_form' ) );

	}

	/**
	 * Undocumented function
	 * 
	 * @since    1.0.0
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function veb_display_form( $atts ){
		$atts = shortcode_atts(
            array(),
			$atts,
			'veb_display_form'
		);

		ob_start();
		?>

		<div id="veb" class="clearfix" ng-app="veb" ng-controller="vebController" ng-cloak ng-strict-di>

			<form name="vebForm" novalidate>

				<div class="veb_dates clearfix">
					<div class="veb_date veb_date_arrival clearfix">
						<label><?= __( 'Arrival date', 'visa-ericsoft-booking' ) ?></label>
						<input name="arrivalDate" type="date" ng-model="form.arrivalDate" ng-min="{{internal.minArrivalDate}}" min="{{internal.minArrivalDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vebForm.arrivalDate.$invalid"><?= __( 'Invalid date!', 'visa-ericsoft-booking' ) ?></label>
					</div>
					<div class="veb_date veb_date_depart clearfix">
						<label><?= __( 'Departure date', 'visa-ericsoft-booking' ) ?></label>
						<input name="departDate" type="date" ng-model="form.departDate" ng-min="{{internal.minDepartDate}}" min="{{internal.minDepartDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vebForm.departDate.$invalid"><?= __( 'Invalid date!', 'visa-ericsoft-booking' ) ?></label>
					</div>
				</div>

				<div class="veb_rooms_controls clearfix">
					<label><?= __( 'Rooms', 'visa-ericsoft-booking' ) ?></label>
					<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( '-', 'visa-ericsoft-booking' ) ?>" />
					<input type="number" name="totalRooms" value="{{form.rooms.length}}" readonly/>
					<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= internal.maxRooms" value="<?= __( '+', 'visa-ericsoft-booking' ) ?>" />					
				</div>

				<div class="veb_rooms clearfix">
					<div ng-repeat="x in form.rooms" class="veb_room clearfix">
						<div class="people clearfix">
							<label><?= __( 'Room ', 'visa-ericsoft-booking' ) ?>{{(x.id) + 1}}</label>
							<div class="adults clearfix">
								<label><?= __( 'Adults', 'visa-ericsoft-booking' ) ?></label>
								<select ng-model="x.adulti" ng-options="n for n in [] | range:x.minAdulti:(x.maxAdulti - x.ragazzi - x.bambini - x.neonati)"></select>
							</div>
							<div class="adults clearfix">
								<label><?= __( 'Youngs', 'visa-ericsoft-booking' ) ?></label>
								<select ng-model="x.ragazzi" ng-options="n for n in [] | range:x.minRagazzi:(x.maxRagazzi - x.adulti - x.bambini - x.neonati)"></select>
							</div>
							<div class="children clearfix">
								<label><?= __( 'Children', 'visa-ericsoft-booking' ) ?></label>
								<select ng-model="x.bambini" ng-options="n for n in [] | range:x.minBambini:(x.maxBambini - x.adulti - x.ragazzi - x.neonati)"></select>
							</div>
							<div class="babies clearfix">
								<label><?= __( 'Babies', 'visa-ericsoft-booking' ) ?></label>
								<select ng-model="x.neonati" ng-options="n for n in [] | range:x.minNeonati:(x.maxNeonati - x.adulti - x.ragazzi - x.bambini)"></select>
							</div>
						</div>
					</div>
				</div>

				<div class="veb_coupon clearfix">
					<label><?= __( 'Coupon', 'visa-ericsoft-booking' ) ?></label>
					<input type="text" name="coupon" ng-model="submit.conv" />
				</div>

				<div class="veb_submit clearfix">
					<input type="submit" ng-click="submitForm()" ng-disabled="vebForm.$invalid" value="<?= __( 'Submit', 'visa-ericsoft-booking' ) ?>" />
					<label class="validation-error" ng-if="vebForm.$invalid"><?= __( 'There are one or more errors in your request. Please correct them before submitting.', 'visa-ericsoft-booking' ) ?></label>
				</div>
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}
