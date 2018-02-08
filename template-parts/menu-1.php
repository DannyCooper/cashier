<?php
/**
 * Template part for displaying the primary navigation menu.
 *
 * @package    cashier
 * @copyright  Copyright (c) 2018, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>

<nav id="site-navigation" class="menu-1 h-menu" role="navigation">
		<button class="menu-toggle" aria-controls="site-menu" aria-expanded="false">
			<i class="fa fa-bars" aria-hidden="true"></i>
			<?php esc_html_e( 'Primary Navigation', 'cashier' ); ?>
		</button>

		<?php
		wp_nav_menu( array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'site-menu',
		) );
		?>
</nav><!-- .menu-1 -->
