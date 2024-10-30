<?php
/*
Plugin Name: Conversions Popup Widget
Plugin URI: https://www.fuertedev.com/cpw
Description: This plugin adds a popup with the last conversions loaded from a Google Spreadsheet.
Version: 1.0
Author: Marco Ciambricco
Author URI: https://www.fuertedev.com
License: GPL2
*/

// Conversions Popup Widget class
class Conversions_popup_widget extends WP_Widget {
	// Main constructor
	public function __construct() {
		parent::__construct(
			'Conversions_popup_widget',
			__( 'Conversions Popup Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
		
		// This is where we add the style and script
        add_action( 'load-widgets.php', array(&$this, 'cpw_color_picker_load') );
	}
	public  function cpw_color_picker_load() { 
		//add color picker css
		wp_enqueue_style( 'wp-color-picker' );  
		//add color picker script		
        wp_enqueue_script( 'wp-color-picker' );    
    }
	// Backend form 
	public function form( $instance ) {
		// Set widget defaults
		$defaults = array(
			'spreadsheet_link'    => 'Paste here the Spreadsheet link ',
			'load_first_row'     => '0',
			'name_column' => '1',
			'email_column' => '2',
			'call_to_action'   => '',
			'side_to_display'   => 'right',
			'hide_on_mobile'   => '1',

		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>
		

		<?php // Google Spreadsheet Link ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'spreadsheet_link' ) ); ?>"><?php _e( 'Google Spreadsheet Link:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'spreadsheet_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'spreadsheet_link' ) ); ?>" type="text" value="<?php echo esc_attr( $spreadsheet_link ); ?>" />
		</p>
		<?php // Load the first row of the document ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'load_first_row' ); ?>"><?php _e( 'Load first row ?', 'text_domain' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'load_first_row' ); ?>" id="<?php echo $this->get_field_id( 'load_first_row' ); ?>" class="widefat">
			<?php
			// options array
			$options = array(
				'0' => __( 'No', 'text_domain' ),
				'1' => __( 'Yes', 'text_domain' ),

			);
			// Loop through options and add each one to the dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $load_first_row, $key, false ) . '>'. $name . '</option>';
			} ?>
			</select>
		</p>	
		<?php // Select the column that contains the customer's name ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'name_column' ); ?>"><?php _e( 'Customer\'s Name Column', 'text_domain' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'name_column' ); ?>" id="<?php echo $this->get_field_id( 'name_column' ); ?>" class="widefat">
			<?php
			// options array
			$options = array(
				'1' => __( '1', 'text_domain' ),
				'2' => __( '2', 'text_domain' ),
				'3' => __( '3', 'text_domain' ),
				'4' => __( '4', 'text_domain' ),
				'5' => __( '5', 'text_domain' ),
				'6' => __( '6', 'text_domain' ),
				'7' => __( '7', 'text_domain' ),
				'8' => __( '8', 'text_domain' ),
				'9' => __( '9', 'text_domain' ),
				'10' => __( '10', 'text_domain' ),
				'11' => __( '11', 'text_domain' ),
				'12' => __( '12', 'text_domain' ),
				'13' => __( '13', 'text_domain' ),
				'14' => __( '14', 'text_domain' ),
				'15' => __( '15', 'text_domain' ),
			);
			// Loop through options and add each one to the dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $name_column, $key, false ) . '>'. $name . '</option>';
			} ?>
			</select>
		</p>
				<?php // Select the column that contains the customer's email address ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'email_column' ); ?>"><?php _e( 'Customer\'s Email Address Column', 'text_domain' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'email_column' ); ?>" id="<?php echo $this->get_field_id( 'email_column' ); ?>" class="widefat">
			<?php
			// options array
			$options = array(
				'1' => __( '1', 'text_domain' ),
				'2' => __( '2', 'text_domain' ),
				'3' => __( '3', 'text_domain' ),
				'4' => __( '4', 'text_domain' ),
				'5' => __( '5', 'text_domain' ),
				'6' => __( '6', 'text_domain' ),
				'7' => __( '7', 'text_domain' ),
				'8' => __( '8', 'text_domain' ),
				'9' => __( '9', 'text_domain' ),
				'10' => __( '10', 'text_domain' ),
				'11' => __( '11', 'text_domain' ),
				'12' => __( '12', 'text_domain' ),
				'13' => __( '13', 'text_domain' ),
				'14' => __( '14', 'text_domain' ),
				'15' => __( '15', 'text_domain' ),
			);
			// Loop through options and add each one to the dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $email_column, $key, false ) . '>'. $name . '</option>';
			} ?>
			</select>
		</p>
		<?php // User Action ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'call_to_action' ) ); ?>"><?php _e( 'What the customer did (e.g.: Has joined us!) :', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'call_to_action' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'call_to_action' ) ); ?>" type="text" value="<?php echo esc_attr( $call_to_action ); ?>" />
		</p>
		<?php // Select the side on which display the popup ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'side_to_display' ); ?>"><?php _e( 'Side of popup', 'text_domain' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'side_to_display' ); ?>" id="<?php echo $this->get_field_id( 'side_to_display' ); ?>" class="widefat">
			<?php
			// options array
			$options = array(
				'0' => __( 'Left', 'text_domain' ),
				'1' => __( 'Right', 'text_domain' ),

			);
			// Loop through options and add each one to the dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $side_to_display, $key, false ) . '>'. $name . '</option>';
			} ?>
			</select>
		</p>
					<?php // Hide on mobile view ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_on_mobile' ); ?>"><?php _e( 'Hide on Mobile view', 'text_domain' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'hide_on_mobile' ); ?>" id="<?php echo $this->get_field_id( 'hide_on_mobile' ); ?>" class="widefat">
			<?php
			// options array
			$options = array(
				'0' => __( 'No', 'text_domain' ),
				'1' => __( 'Yes', 'text_domain' ),

			);
			// Loop through options and add each one to the dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $hide_on_mobile, $key, false ) . '>'. $name . '</option>';
			} ?>
			</select>
		</p>
		<?php // Text Color ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'text_color' ); ?>"><?php _e( 'Popup Text color code (e.g.: #000000)', 'text_domain' ); ?></label></br>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_color' ) ); ?>" type="text" value="<?php echo esc_attr( $text_color ); ?>" />
		</p>
		<?php // Background Color ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Popup Background color code (e.g.: #FFFFFF) ', 'text_domain' ); ?></label></br>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" />
		</p>
	<?php }
	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	
		$instance['spreadsheet_link']     = isset( $new_instance['spreadsheet_link'] ) ? wp_strip_all_tags( $new_instance['spreadsheet_link'] ) : '';
		$instance['load_first_row']   = isset( $new_instance['load_first_row'] ) ? wp_strip_all_tags( $new_instance['load_first_row'] ) : '';
		$instance['name_column']   = isset( $new_instance['name_column'] ) ? wp_strip_all_tags( $new_instance['name_column'] ) : '';
		$instance['email_column']   = isset( $new_instance['email_column'] ) ? wp_strip_all_tags( $new_instance['email_column'] ) : '';
		$instance['call_to_action']     = isset( $new_instance['call_to_action'] ) ? wp_strip_all_tags( $new_instance['call_to_action'] ) : '';
		$instance['side_to_display']   = isset( $new_instance['side_to_display'] ) ? wp_strip_all_tags( $new_instance['side_to_display'] ) : '';
		$instance['background_color']     = isset( $new_instance['background_color'] ) ? wp_strip_all_tags( $new_instance['background_color'] ) : '';
		$instance['text_color']     = isset( $new_instance['text_color'] ) ? wp_strip_all_tags( $new_instance['text_color'] ) : '';
		$instance['hide_on_mobile']   = isset( $new_instance['hide_on_mobile'] ) ? wp_strip_all_tags( $new_instance['hide_on_mobile'] ) : '';
		
		return $instance;
	}
	// Display the widget
	public function widget( $args, $instance ) {
		
		
		extract( $args );
		// Check the widget options		
		$spreadsheetLink     = isset( $instance['spreadsheet_link'] ) ? $instance['spreadsheet_link'] : '';
		$loadFirstRow    = isset( $instance['load_first_row'] ) ?  $instance['load_first_row']  : '0'; //No
		$nameColumn    = isset( $instance['name_column'] ) ?  $instance['name_column']  : '1';
		$emailColumn    = isset( $instance['email_column'] ) ?  $instance['email_column']  : '1';
		$callToAction    = isset( $instance['call_to_action'] ) ?  $instance['call_to_action']  : '';
		$sideToDisplay    = isset( $instance['side_to_display'] ) ?  $instance['side_to_display']  : '1'; //right
		$backgroundColor    = isset( $instance['background_color'] ) ?  $instance['background_color']  : '#FFFFFF'; //white
		$textColor    = isset( $instance['text_color'] ) ?  $instance['text_color']  : '#000000'; //black 
		$hideOnMobile    = isset( $instance['hide_on_mobile'] ) ?  $instance['hide_on_mobile']  : '1'; //true
		
		$enquires = array();
		$enquires = $this->getSpreadsheetEnquires($instance);
		
		//add css		
		$plugin_url = plugin_dir_url( __FILE__ );	
		wp_enqueue_style( 'cpw_css', $plugin_url . 'assets/css/cpw.css' );	
		
		echo $before_widget;
		// Display the widget
		echo '<div class="wrapper-cpw'; if($hideOnMobile) echo ' wrapper-hidden-cpw'; echo'">';
		echo '<div class="fixed-smooth" id="fixed-smooth" >';
			
				$counter = 0 ;		
				foreach ( $enquires as $item ){											
																				
					$gravatar = $item['gravatar'];
					$name = $item['name'];
				?>												
					<div class="cpw-wrapper" style="display: none; color:<?php echo($textColor);?>;background-color:<?php echo($backgroundColor); ?>;"> 
						<div id="image-wrapper" class="image-wrapper" >
							<img id="image-smooth" class="image-smooth" src="<?php echo $gravatar; ?>" style="border: 1px solid <?php echo($textColor);?>;">
						</div>
						<div id="text-wrapper" class="text-wrapper" >
							<div class="first-row" id="first-row">
								<span class="span-name" id="contact-name" ><?php echo $name; ?></span>
							</div>
							<div class="action-row" id="action-row">
								<span  class="span-action" id="customer-action" ><?php echo $callToAction; ?></span>
							</div>

						</div>
					</div>
				<?php		
				$counter++;
				}
				?>
				<?php 
					if($sideToDisplay){ 
						echo '<script>
								var x = document.getElementsByClassName("cpw-wrapper");
								var i;
								for (i = 0; i < x.length; i++) {
									x[i].style.right="2%";
								}
							</script>';
					}else{
						echo '<script>
							var x = document.getElementsByClassName("cpw-wrapper");
							var i;
							for (i = 0; i < x.length; i++) {
								x[i].style.left="2%";
							}
						</script>';
					}								
				?>									
			
		<?php 	
		echo '</div>';
		echo '</div>';

		
		echo $after_widget;
	}
	
		public function getSpreadsheetEnquires( $settings ){

			$spreadsheetLink = $settings['spreadsheet_link'];			
			$linkExploded = explode("/",$spreadsheetLink);
			$spreadsheetKey = $linkExploded['5'];			
			$urlToCsv = 'https://docs.google.com/spreadsheets/d/'.$spreadsheetKey.'/export?format=csv&id='.$spreadsheetKey;
			
			$loadFirstRow = $settings['load_first_row'];
			$number_of_conversions = 5;
			$columnName = $settings['name_column'];
			$columnEmail = $settings['email_column'];

			$enquiries =  array();
			
			
			$enquires = array();
			
			if($spreadsheetKey != ''){

				$csvFile = file_get_contents($urlToCsv);
				$csv =  array();			

				if($csvFile != '')
					$csv = str_getcsv($csvFile,"\n");

				if( count($csv) != 0){

					//Loop through the result 
					//starting from the right row
					//delete first row if it contains labels
					if($loadFirstRow){
						$startingRow = 0;
					}else{
						unset($csv[0]);
						$startingRow = 1;
					}
					
					//check for the number of conversions to show
					if( $number_of_conversions >= count($csv) )
						$limit = count($csv);
					else
						$limit = $number_of_conversions;	


					for($i = $startingRow; $i <= $limit; ++$i)  
					{						
						$enquire = array();	
						$myArray = explode(',', $csv[$i]);	
						$name = $myArray[$columnName-1];
						$email = $myArray[$columnEmail-1];

						//build the gravatar url
						$avatar_hash = md5(strtolower(trim($email)));
						$avatar_size = 120;				 
						$avatar_url  = '//www.gravatar.com/avatar/'.$avatar_hash.'.jpg';
						$avatar_url .= '?s='.$avatar_size;
						

						$enquire['name'] = $name;						
						$enquire['email'] = $email;			
						$enquire['gravatar'] = $avatar_url;	
						
						$enquires[] = $enquire;	
					}		
				}
			}
			return $enquires;
		}		
}




// Register the widget
function cpw_register_widget() {
	register_widget( 'Conversions_popup_widget' );
}
function cpw_regsiter_script(){			
		// This is where we add the jQuery script		
		wp_register_script('cpw_rotation', plugin_dir_url( __FILE__ ). 'assets/js/cpw_rotation.js' , array( 'jquery' ));
		wp_enqueue_script('cpw_rotation');
}
add_action( 'widgets_init', 'cpw_register_widget' );
add_action( 'wp_enqueue_scripts', 'cpw_regsiter_script' );