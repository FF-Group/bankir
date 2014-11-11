<?php
/*
Plugin Name: Exchange Rates
Plugin URI: http://ffgroup.kharkov.com/
Description: Plugin generate post type "currency" and shortcode to layout it
Author: FFGroup
Version: 1.0
Author URI: http://ffgroup.kharkov.com/
*/

add_action( 'init', 'currency_post_type' );
add_action( 'add_meta_boxes', 'currency_meta_box' );
add_action( 'save_post', 'meta_boxes_save' );
add_action( 'wp_enqueue_scripts', 'style_enable' );

add_action( 'widgets_init', create_function( '', 'register_widget( "Google_Maps_Widget" );' ) ); //Widget registration
add_action( 'widgets_init', create_function( '', 'register_widget( "Exchange_Rates_Contacts_Widget" );' ) ); //Widget registration

add_shortcode( 'exchange_rates', 'layout_shortcode' );

function currency_post_type() {
	register_post_type( 'currency', array(
		'labels'             => array(
			'name'          => __( 'Currency' ),
			'singular_name' => __( 'Currency' )
		),
		'add_new'            => __( 'Add new' ),
		'add_new_item'       => __( 'Add new currency' ),
		'edit_item'          => __( 'Edit currency' ),
		'new_item'           => __( 'New Currency' ),
		'view_item'          => __( 'View Currency' ),
		'search_items'       => __( 'Search Currency' ),
		'not_found'          => __( 'No Currency founded' ),
		'not_found_in_trash' => __( 'No Currency found in trash' ),
		'public'             => true,
		'menu_position'      => 3,
		'supports'           => array( 'title' )
	) );
}

function currency_meta_box() {
	add_meta_box(
		'currency_box',
		__( 'Retail' ),
		'retail_box_content',
		'currency',
		'normal',
		'high'
	);

	add_meta_box(
		'wholesale',
		__( 'Indicative rate' ),
		'wholesale_box_content',
		'currency',
		'normal',
		'high'
	);

	add_meta_box(
		'order_number',
		__( 'Order rate' ),
		'order_box_content',
		'currency',
		'normal'
	);
}

function retail_box_content( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'retail_box_content_nonce' );
	$retail_purchase = get_post_meta( $post->ID, 'retail_purchase', true );
	$retail_sale     = get_post_meta( $post->ID, 'retail_sale', true );

	?>
	<p><label for="retail_purchase"><?php echo __( 'Purchase' ); ?></label></p>
	<input type="text" id="retail_purchase" name="retail_purchase"
		   value="<?php if ( $retail_purchase && !empty( $retail_purchase ) ) echo $retail_purchase; ?>" />

	<p><label for="retail_sale"><?php echo __( 'Sale' ); ?></label></p>
	<input type="text" id="retail_sale" name="retail_sale"
		   value="<?php if ( $retail_sale && !empty( $retail_sale ) ) echo $retail_sale; ?>" />
<?php
}

function wholesale_box_content( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'wholesale_box_content_nonce' );
	$wholesale_purchase = get_post_meta( $post->ID, 'wholesale_purchase', true );
	$wholesale_sale     = get_post_meta( $post->ID, 'wholesale_sale', true );
	?>
	<p><label for="wholesale_purchase"><?php echo __( 'Purchase' ); ?></label></p>
	<input type="text" id="wholesale_purchase" name="wholesale_purchase"
		   value="<?php if ( $wholesale_purchase && !empty( $wholesale_purchase ) ) echo $wholesale_purchase; ?>" />

	<p><label for="wholesale_sale"><?php echo __( 'Sale' ); ?></label></p>
	<input type="text" id="wholesale_sale" name="wholesale_sale"
		   value="<?php if ( $wholesale_sale && !empty( $wholesale_sale ) ) echo $wholesale_sale; ?>">
<?php
}

function order_box_content( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'order_box_content_nonce' );
	$args        = array(
		'post_type'   => 'currency',
		'post_status' => 'publish'
	);
	$query       = new WP_Query( $args );
	$posts_count = $query->post_count;?>
	<select class="order-rate" name="order_rate">
		<?php
		for ( $i = 1; $i <= $posts_count; $i ++ ) {
			?>
			<option value="<?php echo $i; ?>" <?php selected( $i, get_post_meta( $post->ID, 'order_rate', true ) ); ?>><?php echo $i; ?></option>
		<?php } ?>
	</select>
<?php

}

function meta_boxes_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( !wp_verify_nonce( $_POST['retail_box_content_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	if ( 'currency' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
	}
	$retail_purchase    = $_POST['retail_purchase'];
	$retail_sale        = $_POST['retail_sale'];
	$wholesale_purchase = $_POST['wholesale_purchase'];
	$wholesale_sale     = $_POST['wholesale_sale'];
	$order_rate         = $_POST['order_rate'];

	update_post_meta( $post_id, 'retail_purchase', $retail_purchase );
	update_post_meta( $post_id, 'retail_sale', $retail_sale );
	update_post_meta( $post_id, 'wholesale_purchase', $wholesale_purchase );
	update_post_meta( $post_id, 'wholesale_sale', $wholesale_sale );
	update_post_meta( $post_id, 'order_rate', $order_rate );
}

function style_enable() {
	wp_register_style( 'exchange_rates_style', plugins_url( 'css/style.css', __FILE__ ) );
	wp_enqueue_style( 'exchange_rates_style' );
}


function layout_shortcode() {
	$args = array(
		'post_type'   => 'currency',
		'post_status' => 'publish',
		'orderby'     => 'meta_value',
		'meta_key'    => 'order_rate',
		'order'       => 'ASC'
	);

	$query = new WP_Query( $args );
	ob_start();
	if ( $query->have_posts() ): ?>
		<div class="retail-exchange">
			<table class="features-table">
				<tr>
					<th></th>
					<th colspan="2"><?php echo __( 'Indicative rate' ); ?></th>
				</tr>
				<tr class="second-table-head">
					<td></td>
					<td><?php echo __( 'Purchase' ); ?></td>
					<td><?php echo __( 'Sale' ); ?></td>
				</tr>
				<?php
				$output_date = 0;
				while ( $query->have_posts() ) : $query->the_post();
					$change_time        = get_the_modified_date( 'd.m.Y' );
					$post_id            = get_the_ID();
					$title              = get_the_title( $post_id );
					$wholesale_purchase = get_post_meta( $post_id, 'wholesale_purchase', true );
					$wholesale_sale     = get_post_meta( $post_id, 'wholesale_sale', true );
					if ( $output_date < $change_time ) {
						$output_date = $change_time;
					}

					?>

					<tr class="features-table-hover">
						<td><?php echo $title; ?></td>
						<td class="num_style"><?php echo $wholesale_purchase; ?></td>
						<td class="num_style"><?php echo $wholesale_sale; ?></td>
					</tr>
				<?php
				endwhile; ?>

				<b>
					<div style="padding: 0px 0px 0px 15px; font-size: larger"><?php echo __( 'Last changes: ' ) . $output_date; ?></div>
				</b>

			</table>
		</div><br>
		<div class="wholesale-exchange">
			<table class="features-table">
				<tr>
					<th></th>
					<th colspan="2"><?php echo __( 'Retail' ); ?></th>
				</tr>
				<tr class="second-table-head">
					<td></td>
					<td><?php echo __( 'Purchase' ); ?></td>
					<td><?php echo __( 'Sale' ); ?></td>
				</tr>
				<?php
				while ( $query->have_posts() ) : $query->the_post();
					$post_id         = get_the_ID();
					$title           = get_the_title( $post_id );
					$retail_purchase = get_post_meta( $post_id, 'retail_purchase', true );
					$retail_sale     = get_post_meta( $post_id, 'retail_sale', true );
					?>
					<?php if ( $retail_purchase && !empty( $retail_purchase ) && $retail_sale && !empty( $retail_sale ) ) { ?>
						<tr class="features-table-hover">
							<td><?php echo $title; ?></td>
							<td class="num_style"><?php echo $retail_purchase; ?></td>
							<td class="num_style"><?php echo $retail_sale; ?></td>
						</tr>
					<?php } ?>
				<?php

				endwhile;
				?>
			</table>
		</div><br><br>
	<?php
	endif;
	$result = ob_get_clean();
	return $result;
}


class Google_Maps_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'Exchange_Rates_GMap', //Widget identify
			__( 'Exchange Rates Google Map' ), //Widget name
			array( 'description' => __( 'Create google map' ) )
		);
	}

	public function form( $instance ) {
		$title       = isset( $instance['title'] ) ? $instance['title'] : __( 'We locate:' ); //Title of the widget
		$iframe_area = isset( $instance['iframe_area'] ) ? $instance['iframe_area'] : '';

		//Start the widget settings form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>"
				   name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'iframe_area' ) ?>"><?php _e( 'GMap Iframe' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'iframe_area' ); ?>"
					  name="<?php echo $this->get_field_name( 'iframe_area' ) ?>"><?php echo $iframe_area; ?></textarea>
		</p>

	<?php
	}

	public function update( $new_instance, $old_instance ) //Save widget settings
	{
		$instance                = array();
		$instance['title']       = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['iframe_area'] = ( !empty( $new_instance['iframe_area'] ) ) ? $new_instance['iframe_area'] : '';

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args ); //Theme arguments for widgets

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget; //Before widget tags
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title; //Output title with the before-after tags
		}
		if ( !empty( $instance['user_text'] ) && $instance['title'] != '' ) {
			echo '<div class="gmap_title"><p>' . $instance['user_text'] . '</p></div>';
		}
		//Out YouTube subscribing form
		echo $instance['iframe_area'];

		echo $after_widget; //After widget tags

	}
}


class Exchange_Rates_Contacts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'Exchange_Rates_Contacts', //Widget identify
			__( 'Exchange Rates Contacts' ), //Widget name
			array( 'description' => __( 'Create google map' ) )
		);
	}

	public function form( $instance ) {
		$title   = isset( $instance['title'] ) ? $instance['title'] : ''; //Title of the widget
		$address = isset( $instance['address'] ) ? $instance['address'] : '';
		$email   = isset( $instance['email'] ) ? $instance['email'] : '';
		$tel     = isset( $instance['tel'] ) ? $instance['tel'] : '';

		//Start the widget settings form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>"
				   name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'address' ) ?>"><?php _e( 'Адрес' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'adderss' ); ?>"
					  name="<?php echo $this->get_field_name( 'address' ) ?>"><?php echo $address; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'E-mail' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'email' ); ?>"
				   name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo esc_attr( $email ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'tel' ); ?>"><?php _e( 'Телефон' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'tel' ); ?>"
				   name="<?php echo $this->get_field_name( 'tel' ); ?>" value="<?php echo esc_attr( $tel ); ?>">
		</p>

	<?php
	}

	public function update( $new_instance, $old_instance ) //Save widget settings
	{
		$instance            = array();
		$instance['title']   = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['email']   = ( !empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
		$instance['tel']     = ( !empty( $new_instance['tel'] ) ) ? strip_tags( $new_instance['tel'] ) : '';
		$instance['address'] = ( !empty( $new_instance['address'] ) ) ? $new_instance['address'] : '';

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args ); //Theme arguments for widgets

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget; //Before widget tags
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title; //Output title with the before-after tags
		}
		if ( !empty( $instance['user_text'] ) && $instance['title'] != '' ) {
			echo '<div class="contacts-title"><p>' . $instance['user_text'] . '</p></div>';
		}
		//Out YouTube subscribing form
		?>
		<div class="contact-body-wrapper">
			<div class="contact-address">
				<p><strong><?php echo __( 'Нас можно найти по адресу: ' ); ?></strong><br />
					<?php echo $instance['address']; ?></p>
			</div>
			<div class="contacts-email">
				<p>
					<strong><?php echo __( 'Вопросы и предложения отправляйте на нашу электронную почту:' ); ?></strong><br />
					<?php echo $instance['email']; ?></p>
			</div>
			<div class="contacts-telephone">
				<p><strong><?php echo __( 'Наш телефон: ' ); ?></strong><br />
					<?php echo $instance['tel']; ?></p>
			</div>
		</div>
		<?php
		echo $after_widget; //After widget tags

	}
}




























