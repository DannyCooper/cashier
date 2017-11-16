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

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

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
	 * Enqueue the scripts and styles needed for the image uploader.
	 */
	public function enqueue() {
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'cashier-widget-uploader', get_template_directory_uri() . '/assets/js/widget-uploader.js', null, null, true );
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
			$image_url = ( ! empty( $instance['image_url'] ) ) ? $instance['image_url'] : '';
			$url = ( ! empty( $instance['url'] ) ) ? $instance['url'] : '';

			echo $args['before_widget']; // WPCS: XSS ok.

			?>

			<?php if ( ! empty( $url ) ) : ?>
				<a href="<?php echo esc_url( $url ); ?>">	<div class="container">
			<?php endif; ?>

			<?php if ( ! empty( $image_url ) ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>">
			<?php endif; ?>

				<?php if ( ! empty( $title ) ) : ?>
					<div class="section-header">
						<?php echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title']; // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>

			<?php if ( ! empty( $url ) ) : ?>
			</div></a>
			<?php endif; ?>

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
		$image_url = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php esc_html_e( 'Image:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text" value="<?php echo esc_url( $image_url ); ?>" />
			<button class="upload_image_button button button-primary"><?php esc_attr_e( 'Upload Image', 'cashier' ); ?></button>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'URL:', 'cashier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_url( $url ); ?>">
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
		$instance['image_url'] = ( ! empty( $new_instance['image_url'] ) ) ? esc_url_raw( $new_instance['image_url'] ) : '';
		$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? esc_url_raw( $new_instance['url'] ) : '';

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
