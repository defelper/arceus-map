<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Welcome to Arceus Map</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/tooltipster.bundle.css'); ?>" />

	<style type="text/css">

		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		.custom-cursor {
			cursor:url(<?php echo base_url('assets/images/pin2.png') ?>), auto;
		}

	</style>
</head>
<body>
<main>
	<div class="container py-4">
		<header class="pb-3 mb-4 border-bottom">
			<a href="/" class="d-flex align-items-center text-dark text-decoration-none">
				<svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
				<span class="fs-4">Arceus Map</span>
			</a>
		</header>

		<div class="row">
			<div class="col-2">
				<div>
					<button id="add" type="button" class="btn btn-primary">Add point</button>
				</div>
				<label id="X">100</label>
				<label id="Y">200</label>
			</div>
			<div class="col">
				<div class="text-center" style="position: relative; ">
					<img id="map" src="<?php echo base_url('assets/images/Map1.jpg'); ?>" class="rounded" alt="Mapa 1" width="100%">
				</div>
			</div>
		</div>

	</div>
</main>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script type="text/javascript" src="<?php echo base_url('assets/js/tooltipster.bundle.js'); ?>"></script>


<script>
	var edit = false;

	$( document ).ready(function() {
		$('#map').on('mousemove', function(e) { console.log($('#map').outerWidth()+ ' ' + $('#map').outerHeight());
			$('#X').text(e.offsetX);
			$('#Y').text(e.offsetY);
		});

		$('#add').on('click', function() {
			edit = !edit;

			if (edit) {
				$('body').addClass('custom-cursor');console.log('entrou');
			} else {
				$('body').removeClass('custom-cursor');
			}
		});

		$('#map').on('click', function(e) {
			if (edit) {
				$('body').removeClass('custom-cursor');

				var wrapper = $(this).parent();
				var parentOffset = $(this).offset();
				var relX = e.offsetX/$(this).width()*100;
				var relY = e.offsetY/$(this).height()*100;

				console.log(relX, relY);
				criarPin(wrapper, relX, relY);

				edit = false;
			}
		});

		function criarPin(wrapper, x, y, data) {
			var pin = $('<img>');
			pin.attr('src', '<?php echo base_url('assets/images/pin2.png') ?>');
			pin.attr('id', data.id);
			pin.attr('title', data.name);
			pin.tooltipster();
			$(wrapper).append(pin.css({
				position: 'absolute',
				left: x+'%',
				top: y+'%',
				display: 'none'
			}));
			pin.fadeIn('slow');
		}

		function loadPins(idMap) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url('map/getpins'); ?>',
				data:{ map: idMap},
				success: function(data) {
					var map = $('#map');
					var wrapper = map.parent();
					console.log(data);
					$.each(data.pokemons,function(index, value){
						var relX = value.x/map.width()*100;
						var relY = value.y/map.height()*100;

						criarPin(wrapper, relX, relY, value);
					});
				}
			});
		}

		loadPins(1);

	});
</script>
</body>
</html>
