/*
Plugin Name: Conversions Popup Widget
Plugin URI: https://www.fuertedev.com/cpw
Description: This plugin adds a popup with the last conversions loaded from a Google Spreadsheet.
Version: 1.0
Author: Marco Ciambricco
Author URI: https://www.fuertedev.com
License: GPL2
*/

jQuery(document).ready(function ($) { 
							var milsecondsOfShow  = "5";
							var secondsOfDelay  = "5000" ;
							var conversions = document.querySelectorAll(".cpw-wrapper");											
							var secondsOfShow  = milsecondsOfShow * 1000;
							if (conversions.length > 0) {
								for ( var i = 0, l = conversions.length; i < l; i++ ) {
									if( i == 0 ){														
										$( conversions[ i ] ).delay( secondsOfDelay )
															.fadeIn( 'slow' )
															.delay( secondsOfShow )
															.fadeOut( 'slow' );
									}else{
										$( conversions[ i ] ).delay( ((secondsOfShow + 2000) * i) + secondsOfShow )
															.fadeIn( 'slow' )
															.delay( secondsOfShow )
															.fadeOut( 'slow' );	
									}						
								}
							}
					});