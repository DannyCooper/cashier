<?php
/**
 * The template for displaying WooCommerce pages.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility
 *
 * @package     cashier
 * @copyright   Copyright (c) 2018, Danny Cooper
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

get_header(); ?>

	<div class="content-area clear">

		<?php woocommerce_content(); ?>

	</div><!-- .content-area -->

<?php
get_footer();
