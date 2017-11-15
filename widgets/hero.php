<?php
/**
 * Builds a widget to display products from a single category.
 *
 * @package     cashier
 * @copyright   Copyright (c) 2017, Danny Cooper
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Adds Cashier_Hero_Widget widget.
 */
class Cashier_Hero_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$id_base = 'cashier_hero';
		$name = esc_html__( 'Hero Section', 'cashier' );
		$widget_options = array(
			'classname' => 'hero-section',
			'description' => esc_html__( 'Display a hero section.', 'cashier' ),
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

			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
			$count = ( ! empty( $instance['count'] ) ) ? $instance['count'] : '4';
			$category = ( ! empty( $instance['category'] ) ) ? $instance['category'] : '';

			$category_link = get_category_link( $category );

			echo $args['before_widget']; // WPCS: XSS ok.

			?>

			<?php if ( ! empty( $title ) ) : ?>
				<div class="section-header">
					<?php echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title']; // WPCS: XSS ok. ?>
				</div>
			<?php endif; ?>

			<img src="https://static.pexels.com/photos/307008/pexels-photo-307008.jpeg">

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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count = ! empty( $instance['count'] ) ? $instance['count'] : '4';
		$category = ! empty( $instance['category'] ) ? $instance['category'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Products:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Product Category:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>">
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? $new_instance['count'] : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? $new_instance['category'] : '';

		return $instance;
	}

}

/**
 * Register Cashier_Hero_Widget on widgets_init.
 */
function cashier_register_hero_widget() {
	register_widget( 'Cashier_Hero_Widget' );
}
add_action( 'widgets_init', 'cashier_register_hero_widget' );
