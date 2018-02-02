<?php
/**
 * Template Name: Homepage Template
 * Template Post Type: page
 *
 * @package    cashier
 * @copyright  Copyright (c) 2017, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! is_active_sidebar( 'homepage-1' ) ) {
	return;
}

get_header(); ?>

	<div class="content-area">

		<?php dynamic_sidebar( 'homepage-1' ); ?>

	</div><!-- .content-area -->

<?php
get_footer();
