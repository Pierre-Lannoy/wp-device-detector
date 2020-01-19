jQuery(document).ready( function($) {
	$('.podd-about-logo').css({opacity:1});
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
					template += '<span class="podd-option ' + $( this ).attr( "class" ) + '" data-value="' + $( this ).attr( "value" ) + '">' + $( this ).html().replace("~-", "<br/><span class=\"podd-option-subtext\">").replace("-~", "</span>") + '</span>';
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
			$(location).attr("href", $( this ).data( "value" ));
		}
	);
	$( "#traffic-chart-button-calls" ).on(
		"click",
		function() {
			$( "#traffic-chart-calls" ).addClass( "active" );
			$( "#traffic-chart-button-calls" ).addClass( "active" );
		}
	);




} );
