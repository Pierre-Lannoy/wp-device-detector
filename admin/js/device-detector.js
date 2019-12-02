jQuery(document).ready( function($) {
	$('.podd-about-logo').css({opacity:1});


	$( "#podd-chart-button-ratio" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).addClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).addClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-hit" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).addClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).addClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-memory" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).addClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).addClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-file" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).addClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).addClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-key" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).addClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).addClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-string" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).addClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).addClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-buffer" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).addClass( "active" );
			$( "#podd-chart-uptime" ).removeClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).addClass( "active" );
			$( "#podd-chart-button-uptime" ).removeClass( "active" );
		}
	);
	$( "#podd-chart-button-uptime" ).on(
		"click",
		function() {
			$( "#podd-chart-ratio" ).removeClass( "active" );
			$( "#podd-chart-hit" ).removeClass( "active" );
			$( "#podd-chart-memory" ).removeClass( "active" );
			$( "#podd-chart-file" ).removeClass( "active" );
			$( "#podd-chart-key" ).removeClass( "active" );
			$( "#podd-chart-string" ).removeClass( "active" );
			$( "#podd-chart-buffer" ).removeClass( "active" );
			$( "#podd-chart-uptime" ).addClass( "active" );
			$( "#podd-chart-button-ratio" ).removeClass( "active" );
			$( "#podd-chart-button-hit" ).removeClass( "active" );
			$( "#podd-chart-button-memory" ).removeClass( "active" );
			$( "#podd-chart-button-file" ).removeClass( "active" );
			$( "#podd-chart-button-key" ).removeClass( "active" );
			$( "#podd-chart-button-string" ).removeClass( "active" );
			$( "#podd-chart-button-buffer" ).removeClass( "active" );
			$( "#podd-chart-button-uptime" ).addClass( "active" );
		}
	);
} );
