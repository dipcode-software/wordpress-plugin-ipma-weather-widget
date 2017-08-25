(function( $ ) {
	'use strict';
	var fetched_locations = null;
	var base_endpoint = '//api.ipma.pt/json';
	var base_icon_uri = '//www.ipma.pt/opencms/bin/images.site/otempo/prev.horaria/w_ic_d_';
	var icon_suffix = '.gif';
	var storage_district_key = 'ipma_widget_district';
	var storage_location_key = 'ipma_widget_location';

	/**
	 * Initialize the widget selects when present
	 */

	$(document).on('ready', function() {
		var widget_wrapper = $('[data-ipma-widget]');

		if( widget_wrapper.length ) {
			widget_wrapper.each( function(i) {
				var $this = $(this);
				var widget_id = $this.attr('id');
				var $district_select = null;
				var $location_select = null;

				var getSelectedDistrict = function() {
					// Returns the district to be selected
					// Defaults to Lisbon
					var district_id = 11; // Lisbon
					/* Check for localStorage Browser support */
					if ( checkLocalStorage() ) {
						var storage_district_id = localStorage.getItem( widget_id + '_' + storage_district_key );
						if ( storage_district_id != null ) {
							district_id = parseInt(storage_district_id);
						}
					}
					return district_id;
				}

				var getSelectedLocation = function() {
					// Returns the location to be selected
					// Defaults to Lisbon
					var location_id = 1110600; // Lisbon
					/* Check for localStorage Browser support */
					if ( checkLocalStorage() ) {
						var storage_location_id = localStorage.getItem( widget_id + '_' + storage_location_key );
						if ( storage_location_id != null ) {
							location_id = parseInt(storage_location_id);
						}
					}
					return location_id;
				}

				var updateForecasts = function( location_code ) {
					var data_url = base_endpoint + '/alldata/' + String(location_code) + '.json';
					var $request = $.ajax({
						url: data_url,
					}).then( function (data) {
						for (var p = 0; p < data.length; p++) {
							var forecast_data = data[p];
							/* Only process 24h forecasts */
							if (forecast_data.idPeriodo == 24) {
								var forecast_date = formatDate(forecast_data.dataPrev);
								var forecast_elem = $this.find("[data-ipma-forecast='" + forecast_date + "']");
								/* If a forecast for this date exists update the values */
								if (forecast_elem.length) {
									var forecast_code = padZero(forecast_data.idTipoTempo);
									forecast_elem.find('[data-ipma-forecast-mintemp]').html(parseInt(forecast_data.tMin));
									forecast_elem.find('[data-ipma-forecast-maxtemp]').html(parseInt(forecast_data.tMax));
									forecast_elem.find('[data-ipma-forecast-precip]').html(parseInt(forecast_data.probabilidadePrecipita));
									forecast_elem.find('[data-ipma-forecast-icon]').parent().removeClass('disabled');
									forecast_elem.find('[data-ipma-forecast-icon]').attr('src', base_icon_uri + forecast_code + icon_suffix);
									if ( typeof (ipmaWidget_i18n["forecast"+forecast_code]) !== 'undefined' ) {
										forecast_elem.find('[data-ipma-forecast-icon]').attr('title', ipmaWidget_i18n["forecast"+forecast_code]);
									}
								}
							}
						}
					});
				}

				var getLocationsByDistrict = function( district_id ) {
					/* Fetch the location list only once */
					if ( fetched_locations == null ) {
						/* Get all locations from ipma */
						var $request = $.ajax({
							url: base_endpoint + '/locations.json'
						}).then( function (data) {
							fetched_locations = data;
							$district_select.trigger('change');
						});
						return null;
					}
					else {
						var options = [];
						for (var l = 0; l < fetched_locations.length; l++) {
							var location = fetched_locations[l];
							if( location.idDistrito == district_id ) {
								var selected = false;
								if( location.globalIdLocal == getSelectedLocation() ) {
									selected = true;
								}
								var option = new Option(location.local, location.globalIdLocal, selected, selected);
								options.push(option);
							}
						}
						return options;
					}
				}

			 	var initializeSelects = function() {
			 		/* Initialize the districts select */
			 		$district_select = $this.find('[data-ipma-widget-district]').attr('disabled','disabled').select2();
			 		$district_select.data('select2').$dropdown.addClass("ipma-widget-select-dropdown");

			 		/* Initialize the locations select */
			 		$location_select = $this.find('[data-ipma-widget-location]').attr('disabled','disabled').select2();

			 		/* Add styling class to dropdown list */
			 		$location_select.data('select2').$dropdown.addClass("ipma-widget-select-dropdown");

					var $request = $.ajax({
						url: base_endpoint + '/districts.json',
					}).then(function (data) {
						/* On success get the districts from ipma to populate the select options */
						var selected_district = getSelectedDistrict();
						$district_select.empty();
						for (var d = 0; d < data.length; d++) {
							// Append it to the select
							var selected = false;
							if ( data[d].idDistrito === selected_district ) {
								selected = true;
							}
							var option = new Option(data[d].nome, data[d].idDistrito, selected, selected);
							$district_select.append(option);
						}

						// Update the selected options that are displayed
						$district_select.removeAttr('disabled');
						$district_select.trigger('change');
						$('[data-ipma-widget-forecasts]').slideDown();

					}).fail(function (jqXHR, textStatus, errorThrown ) {
						/* On fail disable the forecast panel */
						$('[data-ipma-widget-unavailabe]').slideDown();
					});
					
					/* Set the onchange listener to get the locations */
					$district_select.on('change', function(e) {
						var value = $(this).val();
						var locations = getLocationsByDistrict(value);
						if ( locations === null ) {
							return false;
						}
						else {
							locations.sort( function(a, b) {
								return a.label.localeCompare(b.label);
							});
							$location_select.empty().append(locations);
							$location_select.removeAttr('disabled');
							$location_select.trigger('change');
						}
					});

					/* Set the onchange listener to update the data */
					$location_select.on('change', function(e) {
						var value = $(this).val();
						updateForecasts(value);
						localStorage.setItem( widget_id + '_' + storage_location_key, value );
						localStorage.setItem( widget_id + '_' + storage_district_key, $district_select.val() );
					});

			 	}

			 	/* Auxiliary functions */

				var padZero = function( n ) {
					if ( n < 10) {
						n = "0" + n;
					}
					return n;
				}

				var formatDate = function( str ) {
				    var d = new Date(str);
					var month = '' + (d.getMonth() + 1);
					var day = '' + d.getDate();
					var year = d.getFullYear();

				    if (month.length < 2) month = '0' + month;
				    if (day.length < 2) day = '0' + day;

				    return [year, month, day].join('-');
				}

				var checkLocalStorage = function() {
					var test = 'test_string';
					try {
						localStorage.setItem(test, test);
						localStorage.removeItem(test);
						return true;
					} catch (e) {
						return false;
					}
				}

			 	initializeSelects();
		 	});

		}
	});

})( jQuery );
