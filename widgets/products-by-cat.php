<?php
/**
 * Builds a widget to display products from a single category.
 *
 * @package     cashier
 * @copyright   Copyright (c) 2018, Danny Cooper
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Adds Cashier_Products_By_Cat_Widget widget.
 */
class Cashier_Products_By_Cat_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$id_base = 'cashier_products_by_cat';
		$name    = esc_html__( 'Products by Category', 'cashier' );

		$widget_options = array(
			'classname'                   => 'products-by-cat',
			'description'                 => esc_html__( 'Display products from a single category.', 'cashier' ),
			'customize_selective_refresh' => true,
		);

		parent::__construct( $id_base, $name, $widget_options );

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

			$title     = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$title     = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$count     = ( ! empty( $instance['count'] ) ) ? $instance['count'] : '4';
			$category  = ( ! empty( $instance['category'] ) ) ? $instance['category'] : '';
			$link_text = ( ! empty( $instance['link_text'] ) ) ? $instance['link_text'] : '';

			$category_link = ( ! is_wp_error( get_term_link( $category ) ) ? get_term_link( $category ) : 1 );

			echo $args['before_widget']; // WPCS: XSS ok.

			?>

				<?php if ( ! empty( $title ) ) : ?>
					<div class="section-header">
						<?php echo $args['before_title'] . $title . $args['after_title']; // WPCS: XSS ok. ?>
						<a class="section-link" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $link_text ); ?></a>
					</div>
				<?php endif; ?>

				<div class="products clear">
					<ul>
						<?php
						$query_args = array(
							'posts_per_page' => $count,
							'post_status'    => 'publish',
							'post_type'      => 'product',
							'tax_query'      => array(
								array(
									'taxonomy' => 'product_cat',
									'terms'    => $category,
								),
							),
						);

						$query = new WP_Query( $query_args );
						if ( $query->have_posts() ) :
							while ( $query->have_posts() ) :
								$query->the_post();
								wc_get_template( 'content-product.php' );
							endwhile;
						endif;
						wp_reset_postdata();
						?>
					</ul>
				</div>

			<?php

			echo $args['after_widget']; // WPCS: XSS ok.

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title     = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count     = ! empty( $instance['count'] ) ? $instance['count'] : '4';
		$category  = ! empty( $instance['category'] ) ? $instance['category'] : '';
		$link_text = ! empty( $instance['link_text'] ) ? $instance['link_text'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_text' ) ); ?>"><?php esc_html_e( 'Link Text:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_text' ) ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Products:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo absint( $count ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Product Category:', 'cashier' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" style="width:100%;">
				<?php foreach ( get_terms( 'product_cat' ) as $term ) : ?>
					<option <?php selected( $category, $term->term_id ); ?> value="<?php echo absint( $term->term_id ); ?>"><?php echo esc_attr( $term->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count']     = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : '';
		$instance['category']  = ( ! empty( $new_instance['category'] ) ) ? absint( $new_instance['category'] ) : '';
		$instance['link_text'] = ( ! empty( $new_instance['link_text'] ) ) ? sanitize_text_field( $new_instance['link_text'] ) : '';

		return $instance;
	}

}

/**
 * Register Cashier_Products_By_Cat_Widget on widgets_init.
 */
function cashier_register_products_by_cat_widget() {
	register_widget( 'Cashier_Products_By_Cat_Widget' );
}
add_action( 'widgets_init', 'cashier_register_products_by_cat_widget' );
