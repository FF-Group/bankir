<?php
/*
Plugin Name: Responsive Full Background
Plugin URI: http://qass.im/my-plugins/
Description: Add responsive full background to your website easily, compatible with all browsers and with iPhone, iPad, and all phone and tablets.
Version: 1.0.0
Author: Qassim Hassan
Author URI: http://qass.im
License: GPLv2 or later
*/

/*  Copyright 2014  Qassim Hassan  (email : qassim.pay@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if ( is_admin() ){


	function responsive_full_background() {
		add_theme_page( 'Responsive Full Background Settings', 'Responsive Full Background', 'edit_theme_options', 'responsive_full_background', 'responsive_full_background_settings' );
	}
	add_action( 'admin_menu', 'responsive_full_background' );


	function rfb_register_setting() {
		register_setting( 'setting_rf_background_link', 'rf_background_link' );
	}
	add_action( 'admin_init', 'rfb_register_setting' );
	
		
	function responsive_full_background_settings(){
		?>
			<div class="wrap">
				<h2>Responsive Full Background Settings</h2>
				<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
					<div id="setting-error-settings_updated" class="updated settings-error"> 
						<p><strong>Settings saved.</strong></p>
					</div>
				<?php } ?>
                
            	<form method="post" action="options.php">
                	<?php settings_fields( 'setting_rf_background_link' ); ?>
                        <?php
                        	$rf_background_link_filter = wp_filter_kses( get_option('rf_background_link') );
						?>
                	<table class="form-table">
                		<tbody>
                    		<tr>
                        		<th><label for="rf_background_link">Background Link</label></th>
                            	<td>
                                    <input class="regular-text" name="rf_background_link" type="text" id="rf_background_link" placeholder="enter background link" value="<?php echo esc_attr($rf_background_link_filter); ?>">
                                        <?php if ( is_ssl() ) {echo '<p><a href="'.admin_url( 'media-new.php', 'https' ).'" target="_blank">upload media</a></p>';}else{echo '<p><a href="'.admin_url( 'media-new.php', 'http' ).'" target="_blank">upload media</a></p>';}?>
								</td>
                        	</tr>
                    	</tbody>
                    </table>
                    <p class="submit"><input id="submit" class="button button-primary" type="submit" name="submit" value="Save Changes"></p>
                </form>
			</div>
			<div class="clear"></div>
		<?php 
	}

} // if is_admin END


function responsive_full_background_css(){
	?>

		<?php if( get_option('rf_background_link') )  : ?>
    
			<style type="text/css">
				/* Responsive Full Background Plugin */
				html{
					background-image:none !important;
					background:none !important;
				}
				
				body{
					background-image:none !important;
					background:url(<?php echo esc_attr( wp_filter_kses( get_option('rf_background_link') ) ); ?>) fixed no-repeat !important;
					background-size:100% 100% !important;
					-webkit-background-size:100% 100% !important;
					-moz-background-size:100% 100% !important;
					-ms-background-size:100% 100% !important;
					-o-background-size:100% 100% !important;
				}
			</style>
		<?php endif; ?>
    
	<?php
}
add_action( 'wp_head', 'responsive_full_background_css', 999 );


?>