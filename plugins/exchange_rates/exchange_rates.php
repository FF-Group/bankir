<?php
/*
Plugin Name: Exchange Rates
Plugin URI: http://ffgroup.kharkov.com/
Description: Plugin generate post type "currency" and shortcode to layout it
Author: FFGroup
Version: 1.0
Author URI: http://ffgroup.kharkov.com/
*/

add_action('init', 'currency_post_type');
add_action('add_meta_boxes', 'currency_meta_box');
add_action('save_post', 'meta_boxes_save');
add_action('wp_enqueue_scripts', 'style_enable');

add_action('widgets_init', create_function('', 'register_widget( "Google_Maps_Widget" );')); //Widget registration

add_shortcode('exchange_rates', 'layout_shortcode');

function currency_post_type()
{
    register_post_type('currency', array(
        'labels' => array(
            'name' => __('Currency'),
            'singular_name' => __('Currency')
        ),
        'add_new' => __('Add new'),
        'add_new_item' => __('Add new currency'),
        'edit_item' => __('Edit currency'),
        'new_item' => __('New Currency'),
        'view_item' => __('View Currency'),
        'search_items' => __('Search Currency'),
        'not_found' => __('No Currency founded'),
        'not_found_in_trash' => __('No Currency found in trash'),
        'public' => true,
        'menu_position' => 3,
        'supports' => array('title')
    ));
}

function currency_meta_box()
{
    add_meta_box(
        'currency_box',
        __('Retail'),
        'retail_box_content',
        'currency',
        'normal',
        'high'
    );

    add_meta_box(
        'wholesale',
        __('Wholesale'),
        'wholesale_box_content',
        'currency',
        'normal',
        'high'
    );
}

function retail_box_content($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'retail_box_content_nonce');
    $retail_purchase = get_post_meta($post->ID, 'retail_purchase', true);
    $retail_sale = get_post_meta($post->ID, 'retail_sale', true);

    ?>
    <p><label for="retail_purchase"><?php echo __('Retail purchase'); ?></label></p>
    <input type="text" id="retail_purchase" name="retail_purchase"
           value="<?php if ($retail_purchase && !empty($retail_purchase)) echo $retail_purchase; ?>"/>

    <p><label for="retail_sale"><?php echo __('Retail sale'); ?></label></p>
    <input type="text" id="retail_sale" name="retail_sale"
           value="<?php if ($retail_sale && !empty($retail_sale)) echo $retail_sale; ?>"/>
<?php
}

function wholesale_box_content($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'wholesale_box_content_nonce');
    $wholesale_purchase = get_post_meta($post->ID, 'wholesale_purchase', true);
    $wholesale_sale = get_post_meta($post->ID, 'wholesale_sale', true);
    ?>
    <p><label for="wholesale_purchase"><?php echo __('Wholesale purchase'); ?></label></p>
    <input type="text" id="wholesale_purchase" name="wholesale_purchase"
           value="<?php if ($wholesale_purchase && !empty($wholesale_purchase)) echo $wholesale_purchase; ?>"/>

    <p><label for="wholesale_sale"><?php echo __('Wholesale sale'); ?></label></p>
    <input type="text" id="wholesale_sale" name="wholesale_sale"
           value="<?php if ($wholesale_sale && !empty($wholesale_sale)) echo $wholesale_sale; ?>">
<?php
}

function meta_boxes_save($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!wp_verify_nonce($_POST['retail_box_content_nonce'], plugin_basename(__FILE__)))
        return;

    if ('currency' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return;
    } else {
        if (!current_user_can('edit_post', $post_id))
            return;
    }
    $retail_purchase = $_POST['retail_purchase'];
    $retail_sale = $_POST['retail_sale'];
    $wholesale_purchase = $_POST['wholesale_purchase'];
    $wholesale_sale = $_POST['wholesale_sale'];

    update_post_meta($post_id, 'retail_purchase', $retail_purchase);
    update_post_meta($post_id, 'retail_sale', $retail_sale);
    update_post_meta($post_id, 'wholesale_purchase', $wholesale_purchase);
    update_post_meta($post_id, 'wholesale_sale', $wholesale_sale);
}

function style_enable()
{
    wp_register_style('exchange_rates_style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_style('exchange_rates_style');
}


function layout_shortcode()
{
    $args = array(
        'post_type' => 'currency',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'ASC'
    );

    $query = new WP_Query($args);
    ob_start();
    if ($query->have_posts()): ?>
        <div class="retail-exchange">
            <table>
                <tr>
                    <th></th>
                    <th colspan="2"><?php echo __('Retail'); ?></th>
                </tr>
                <tr class="second-table-head">
                    <td></td>
                    <td><?php echo __('Purchase'); ?></td>
                    <td><?php echo __('Sale'); ?></td>
                </tr>
                <?php
                $output_date = 0;
                while ($query->have_posts()) : $query->the_post();
                    $change_time = get_the_modified_date('d.m.Y');
                    $post_id = get_the_ID();
                    $title = get_the_title($post_id);
                    $retail_purchase = get_post_meta($post_id, 'retail_purchase', true);
                    $retail_sale = get_post_meta($post_id, 'retail_sale', true);
                    if($output_date < $change_time){
                        $output_date = $change_time;
                    }

                    ?>

                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $retail_purchase; ?></td>
                        <td><?php echo $retail_sale; ?></td>
                    </tr>
                <?php
                endwhile; ?>
                
                <?php echo __('Last changes: ') . $output_date;?>
                
            </table>
        </div>
        <div class="wholesale-exchange">
            <table>
                <tr>
                    <th></th>
                    <th colspan="2"><?php echo __('Wholesale'); ?></th>
                </tr>
                <tr class="second-table-head">
                    <td></td>
                    <td><?php echo __('Purchase'); ?></td>
                    <td><?php echo __('Sale'); ?></td>
                </tr>
                <?php
                while ($query->have_posts()) : $query->the_post();
                    $post_id = get_the_ID();
                    $title = get_the_title($post_id);
                    $wholesale_purchase = get_post_meta($post_id, 'wholesale_purchase', true);
                    $wholesale_sale = get_post_meta($post_id, 'wholesale_sale', true);
                    ?>
                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $wholesale_purchase; ?></td>
                        <td><?php echo $wholesale_sale; ?></td>
                    </tr>
                    <?php

                endwhile;
                ?>
            </table>
        </div>
    <?php
    endif;
    $result = ob_get_clean();
    return $result;
}


class Google_Maps_Widget extends WP_Widget{
    public function __construct()
    {
        parent::__construct(
            'Exchange_Rates_GMap', //Widget identify
            __('Exchange Rates Google Map'), //Widget name
            array('description' => __('Create google map'))
        );
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : __('We locate:'); //Title of the widget
        $iframe_area = isset($instance['iframe_area']) ? $instance['iframe_area'] : ''; //"Subscribe to my channel" text

        //Start the widget settings form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget title'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('iframe_area')?>"><?php _e('GMap Iframe'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('iframe_area'); ?>"
                      name="<?php echo $this->get_field_name('iframe_area')?>"><?php echo $iframe_area; ?></textarea>
        </p>

    <?php
    }

    public function update($new_instance, $old_instance) //Save widget settings
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['iframe_area'] = (!empty($new_instance['iframe_area'])) ? $new_instance['iframe_area'] : '';

        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args); //Theme arguments for widgets

        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget; //Before widget tags
        if (!empty($title)) {
            echo $before_title . $title . $after_title; //Output title with the before-after tags
        }
        if(!empty($instance['user_text']) && $instance['title'] != ''){ //If user enter "Subscribe to my channel" text - output it
            echo '<div class="gmap_title"><p>' . $instance['user_text'] . '</p></div>';
        }
        //Out YouTube subscribing form
            echo $instance['iframe_area'];

        echo $after_widget; //After widget tags

    }
}




























