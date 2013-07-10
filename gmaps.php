<?php
/*
	Plugin Name: gmaps3 Shortcode
	Description: Shortcode integration for Google Maps API v3
	Version: 0.2
	Author: MBV Media
	Author URI: http://mbv-media.com
	License: GPLv3
	Copyright 2013 mbv-media.com (email: webdev@mbv-media.com)
*/

/**
 *  Based on GMAP3 Plugin for JQuery 
 *	http://gmap3.net
 */
	Class GMap3 {
		private $gmapsjQueryString = 'map-canvas';
		private $gmapsElement = '';
		
		public function __construct() {
			$this->gmapsElement = str_replace(' ', '', ucwords(str_replace(array('_', '-', '#'), ' ', $this->gmapsjQueryString)));

			add_action('wp_enqueue_scripts', array($this, 'addJS'));
			add_shortcode('gmaps', array($this, 'shortcodeGmaps'));
			add_shortcode('groute', array($this, 'shortcodeGmapsRoute'));
		}

		public function addJS() {
			wp_enqueue_script('googleMaps', 'http://maps.google.com/maps/api/js?sensor=false');
			wp_enqueue_script('gmap3', plugins_url('gmap3.min.js', __FILE__), array('jquery', 'googleMaps'));
			wp_enqueue_script('gmap3route', plugins_url('route.js.php?gmap=gmap'.$this->gmapsElement.'&amp;route='.($this->gmapsjQueryString).'-route', __FILE__), array('gmap3'));
		}
		
		/**
		 * Generate Shortcode into HTML/Javascript and call gmap3
		 * @param array $args
		 * @return html
		 */
		public function shortcodeGmaps($args) {
			// Setting some defaults
			if (empty($args['center'])) {
				$args['center'] = '50.000000,8.000000';
			}
			if (empty($args['zoom'])) {
				$args['zoom'] = 10;
			}
			if (empty($args['marker']) || $args['marker'] == 'center') {
				$args['marker'] = $args['center'];
			}
			if (empty($args['width'])) {
				$args['width'] = '300px';
			}
			if (empty($args['height'])) {
				$args['height'] = '300px';
			}

			$destination_address = '';
			var_dump($args);
			if (!empty($args['destination'])) {
				$destination_address = do_shortcode($args['destination']);
			}

			// defaults for route
			if (isset($args['with-route'])) {
				$show_route = true;
			} else {
				$show_route = false;
			}

			// put string into array for json
			$args['center'] = explode(',', $args['center']);
			$args['marker'] = explode(',', $args['marker']);
			$args['zoom'] = intval($args['zoom']);
			
			$gmapsJSON = array(
				'map' => array(
					'options' => array(
						'center' => $args['center'],
						'zoom' => $args['zoom'],
					)
				),
				'marker' => array(
					'latLng' => $args['marker'],
				)
			);
			
			// javascript function with parameters
			$gmapsFn = "
				var gmap".($this->gmapsElement)." = null,
					route_address = '".$destination_address."';

				jQuery(function($) {
					gmap".($this->gmapsElement)." = $('#".$this->gmapsjQueryString."').gmap3(".json_encode($gmapsJSON).");
				})

				jQuery(document).on('submit', '#".$this->gmapsjQueryString."-form', calculateRoute);";

			$gmapsHTML  = '<div id="'.($this->gmapsjQueryString).'" style="height:'.$args['height'].'; width: '.$args['width'].';"></div>';
			$gmapsHTML .= '<script type="text/javascript">'.$gmapsFn.'</script>';

			if ($show_route) {
				$gmapsHTML .= $this->shortcodeGmapsRoute();
			}

			return $gmapsHTML;
		}

		/**
		 * Generate gmaps route input
		 * @return html
		 */
		public function shortcodeGmapsRoute () {
			return '
				<form method="post" action="#" id="'.($this->gmapsjQueryString).'-form">
					<div class="form_field">
						<input type="text" value="" name="start_adress" id="'.($this->gmapsjQueryString).'-address">
						<label for="start-address">'.__('Startadresse', 'gmaps').'</label>
					</div>
					<div class="send_button">
						<input type="submit" value="'.__('Route berechnen', 'gmaps').'">
					</div>
					<div class="clear"></div>
				</form>
				<div id="'.($this->gmapsjQueryString).'-route"></div>';
		}
	}

	new GMap3();
?>
