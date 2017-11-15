<?php
/**
 * Cashier WooCommerce functions and definitions
 *
 * @package    cashier
 * @copyright  Copyright (c) 2017, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! function_exists( 'cashier_cart_link' ) ) {
	/**
	 * Displayed a link to the cart including the number of items present and the cart total
	 */
	function cashier_cart_link() {
		ob_start();
		?>
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'cashier' ); ?>">
				<span class="count">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					<?php
					/* translators: %d: number of items in cart. */
					echo wp_kses_data( sprintf( __( 'Cart (%d)', 'cashier' ), WC()->cart->get_cart_contents_count() ) );
					?>
				</span>
			</a>
		<?php
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

/**
 * Add cart link to end of the primary nav menu.
 *
 * @param array  $items List of menu items.
 * @param object $args Array of nav menu arguments.
 */
function cashier_add_cart_link( $items, $args ) {
	$cart_link = cashier_cart_link();
	if ( 'menu-1' === $args->theme_location ) {
		$items .= '<li>' . $cart_link['a.cart-contents'] . '</li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'cashier_add_cart_link', 10, 2 );

// Add the cart link function to the fragmants so ajax update works.
add_filter( 'woocommerce_add_to_cart_fragments', 'cashier_cart_link' );

// Remove WooCommerce stylesheets.
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function cashier_sorting_container_start() {
	echo '<div class="cashier-sorting clear">';
}
function cashier_sorting_container_end() {
	echo '</div>';
}

add_action( 'woocommerce_before_shop_loop', 'cashier_sorting_container_start', 19 );
add_action( 'woocommerce_before_shop_loop', 'cashier_sorting_container_end', 31 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );