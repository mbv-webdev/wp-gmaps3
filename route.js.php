<?php
	Class GMap3Route {
		private $gmapObject = null;
		private $routeElement = null;
		
		/**
		 * accept GET Params to generate a Javascript File
		 */
		public function __construct() {
			if (!empty($_GET['gmap'])) {
				$this->gmapObject = $_GET['gmap'];

				if (!empty($_GET['route'])) {
					$this->routeElement = $_GET['route'];
				}
				
				$this->setHeaders();
				echo $this->getJS();
			}
		}
		
		private function setHeaders() {
			header('Content-type: text/javascript');
		}
		
		private function getJS() {
			return '
				function calculateRoute(formEvent) {
					var addressElement = null;

					formEvent.stopPropagation();
					formEvent.preventDefault();

					addressElement = $(\'#start-address\');

					if (addressElement.length > 0 && addressElement.val() !== \'\') {
						displayRoute(route_address, addressElement.val(), true);
					}
				};

				function displayRoute(destination, origin, showInstructions) {
					'.$this->gmapObject.'.gmap3({
						getroute: {
							options:{
								origin:      origin,
								destination: destination,
								travelMode:  google.maps.DirectionsTravelMode.DRIVING
							},

							callback: function(results) {
								if (!results) {
									return;
								}

								'.$this->gmapObject.'.gmap3({
									directionsrenderer: {
										container: (showInstructions && $("#'.$this->routeElement.'").length > 0 ? $("#'.$this->routeElement.'").empty() : null),
										options: {
											directions: results
										}
									}
								});
							}
						}
					});
				}';
		}
	};

	new GMap3Route();
?>