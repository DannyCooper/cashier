<?php
/**
 * Template part for displaying the primary navigation menu.
 *
 * @package    cashier
 * @copyright  Copyright (c) 2018, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>

<nav id="above-header-navigation" class="menu-2 h-menu" role="navigation">
	<div class="wrapper">
		<button class="menu-toggle" aria-controls="above-header-menu" aria-expanded="false">
			<i class="fa fa-bars" aria-hidden="true"></i>
			<?php esc_html_e( 'Secondary Navigation', 'cashier' ); ?>
		</button>

		<?php
		wp_nav_menu( array(
			'theme_location' => 'menu-2',
			'menu_id'        => 'above-header-menu',
		) );
		?>
	</div><!-- .wrapper -->
</nav><!-- .menu-2 -->
