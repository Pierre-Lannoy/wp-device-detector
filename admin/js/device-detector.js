jQuery( document ).ready(
	function($) {
		function testUA() {
			  $( "#podd_test_ua_action" ).addClass( 'disabled' );
			  $( "#podd_test_ua_value" ).addClass( 'disabled' );
			  $( "#podd_test_ua_text" ).hide();
			  $( "#podd_test_ua_describer" ).hide();
			  $( "#podd_test_ua_wait" ).show();
			  root.innerHTML = '';
				$.ajax(
					{
						type : 'GET',
						url : describer.restUrl,
						data : { ua: $( "#podd_test_ua_value" ).val() },
						beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', describer.restNonce ); },
						success: function( response ) {
							if ( response ) {
								classId   = response['class'].id;
								className = response['class'].name;
								if ( 'bot' === classId ) {
									elem           = document.createElement( 'h3' );
									elem.innerHTML = response.bot.category;
									root.appendChild( elem );
									botImg = '<img style="padding-top: 1px;width:16px;float:left;padding-right:6px;" src="' + response.bot.icon + '" />';
									if ( '' !== response.bot.url ) {
										botName = '<a href="' + response.bot.url + '">' + response.bot.name + '</a>';
									}
										prodName = '';
									if ( '' !== response.bot.producer.name ) {
										if ( '' !== response.bot.producer.url ) {
											prodName = ' (<a href="' + response.bot.producer.url + '">' + response.bot.producer.name + '</a>)';
										} else {
											prodName = ' (' + response.bot.producer.name + ')';
										}
									}
										elem           = document.createElement( 'p' );
										elem.innerHTML = botImg + botName + prodName;
										root.appendChild( elem );
								} else {
									elem = document.createElement( 'h3' );
									if ( 'desktop' === classId ) {
										elem.innerHTML = className;
									} else {
										if ( 'other' !== response.device.id ) {
											elem.innerHTML = response.device.name;
										} else {
											elem.innerHTML = response.client.name;
										}
									}
									root.appendChild( elem );
									if ( 'library' !== response.client.id ) {
										brand = response.brand.name;
										if ( '' === brand ) {
											brand = describer.sGeneric;
										}
										elem           = document.createElement( 'p' );
										elem.innerHTML = '<img style="padding-top: 1px;width:16px;float:left;padding-right:6px;" src="' + response.brand.icon + '" />' + brand + ' ' + response.brand.model;
										root.appendChild( elem );
									}
									elem = document.createElement( 'p' );
									if ( 'browser' === response.client.id ) {
										elem.innerHTML = '<img style="padding-top: 1px;width:16px;float:left;padding-right:6px;" src="' + response.browser.icon + '" />' + response.browser.name + ' ' + response.browser.version;
										root.appendChild( elem );
									} else {
										if ( 'UNK' !== response[response.client.id].name ) {
											elem.innerHTML = response[response.client.id].name + ' ' + response[response.client.id].version;
											root.appendChild( elem );
										}
									}
									if ( 'UNK' !== response.os.id ) {
										elem           = document.createElement( 'p' );
										elem.innerHTML = '<img style="padding-top: 1px;width:16px;float:left;padding-right:6px;" src="' + response.os.icon + '" />' + response.os.name + ' ' + response.os.version + ' ' + response.os.platform;
										root.appendChild( elem );
									}
								}
							}
						},
						error: function( response ) {
							console.log( response );
						},
						complete:function( response ) {
							$( "#podd_test_ua_action" ).removeClass( 'disabled' );
							$( "#podd_test_ua_value" ).removeClass( 'disabled' );
							$( "#podd_test_ua_wait" ).hide();
							$( "#podd_test_ua_describer" ).show();
							$( "#podd_test_ua_text" ).show();
						}
					}
				);
		}
		$( '.podd-about-logo' ).css( {opacity: 1} );
		$( ".podd-select" ).each(
			function() {
				var chevron  = 'data:image/svg+xml;base64,PHN2ZwogIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICB3aWR0aD0iMjQiCiAgaGVpZ2h0PSIyNCIKICB2aWV3Qm94PSIwIDAgMjQgMjQiCiAgZmlsbD0ibm9uZSIKICBzdHJva2U9IiM3Mzg3OUMiCiAgc3Ryb2tlLXdpZHRoPSIyIgogIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIKICBzdHJva2UtbGluZWpvaW49InJvdW5kIgo+CiAgPHBvbHlsaW5lIHBvaW50cz0iNiA5IDEyIDE1IDE4IDkiIC8+Cjwvc3ZnPgo=';
				var classes  = $( this ).attr( "class" ),
				id           = $( this ).attr( "id" ),
				name         = $( this ).attr( "name" );
				var template = '<div class="' + classes + '">';
				template    += '<span class="podd-select-trigger">' + $( this ).attr( "placeholder" ) + '&nbsp;<img style="width:18px;vertical-align:top;" src="' + chevron + '" /></span>';
				template    += '<div class="podd-options">';
				$( this ).find( "option" ).each(
					function() {
						template += '<span class="podd-option ' + $( this ).attr( "class" ) + '" data-value="' + $( this ).attr( "value" ) + '">' + $( this ).html().replace( "~-", "<br/><span class=\"podd-option-subtext\">" ).replace( "-~", "</span>" ) + '</span>';
					}
				);
				template += '</div></div>';

				$( this ).wrap( '<div class="podd-select-wrapper"></div>' );
				$( this ).after( template );
			}
		);
		$( ".podd-option:first-of-type" ).hover(
			function() {
				$( this ).parents( ".podd-options" ).addClass( "option-hover" );
			},
			function() {
				$( this ).parents( ".podd-options" ).removeClass( "option-hover" );
			}
		);
		$( ".podd-select-trigger" ).on(
			"click",
			function() {
				$( 'html' ).one(
					'click',
					function() {
						$( ".podd-select" ).removeClass( "opened" );
					}
				);
				 $( this ).parents( ".podd-select" ).toggleClass( "opened" );
				 event.stopPropagation();
			}
		);
		$( ".podd-option" ).on(
			"click",
			function() {
				$( location ).attr( "href", $( this ).data( "value" ) );
			}
		);
		$( "#podd-chart-button-calls" ).on(
			"click",
			function() {
				$( "#podd-chart-calls" ).addClass( "active" );
				$( "#podd-chart-button-calls" ).addClass( "active" );
			}
		);
		$( "#podd_test_ua_action" ).on(
			"click",
			function() {
				testUA();
			}
		);

		const root = document.querySelector( '#podd_test_ua_describer' );

	}
);
