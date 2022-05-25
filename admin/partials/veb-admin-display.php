<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.elk-lab.com
 * @since      1.0.0
 *
 * @package    Veb
 * @subpackage Veb/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1><?= __('EricSoft Booking', 'visa-ericsoft-booking') ?></h1>

    <form method="post" action="options.php">
        <?php settings_fields('veb_options'); ?>
        <?php do_settings_sections('veb'); ?>
        <?php submit_button(); ?>
    </form>
</div>