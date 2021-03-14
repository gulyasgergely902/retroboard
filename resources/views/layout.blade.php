<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Retro Board</title>

		<!-- Styles -->
		<link rel="stylesheet" href="../../css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	</head>
	<body>
		<!-- Content -->
		@yield ('content')
		<!-- End of Content -->
		<nav class="navbar fixed-bottom navbar-light bg-light">
			<a class="nav-link" href="https://github.com/gulyasgergely902/retroboard/issues">Report bugs on GitHub</a>
		</nav>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<script src="https://kit.fontawesome.com/1eaaf45e00.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>
		<script src="../../js/script.js"></script>
		<script src="../../js/jquery.transit.min.js"></script>
    </body>
</html>