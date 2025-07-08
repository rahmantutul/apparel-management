<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">

	<title>Neon | Dashboard</title>

	<link rel="stylesheet" href="{{ asset('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/font-icons/entypo/css/entypo.css') }}">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/neon-core.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/neon-theme.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/neon-forms.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

	<script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>

	<!--[if lt IE 9]><script src="{{ asset('assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    @stack('Styles')

</head>
<body class="page-body  page-fade" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	@include('admin.layouts.sidebar')

	<div class="main-content">
				
        @include('admin.layouts.header')
		<hr />
	
		 @yield('content')
		<br />
		
		@include('admin.layouts.footer')
	</div>
</div>



	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/js/rickshaw/rickshaw.min.css') }}">

	<!-- Bottom scripts (common) -->
	<script src="{{ asset('assets/js/gsap/TweenMax.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
	<script src="{{ asset('assets/js/joinable.js') }}"></script>
	<script src="{{ asset('assets/js/resizeable.js') }}"></script>
	<script src="{{ asset('assets/js/neon-api.js') }}"></script>
	<script src="{{ asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>


	<!-- Imported scripts on this page -->
	<script src="{{ asset('assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
	<script src="{{ asset('assets/js/rickshaw/vendor/d3.v3.js') }}"></script>
	<script src="{{ asset('assets/js/rickshaw/rickshaw.min.js') }}"></script>
	<script src="{{ asset('assets/js/raphael-min.js') }}"></script>
	<script src="{{ asset('assets/js/morris.min.js') }}"></script>
	<script src="{{ asset('assets/js/toastr.js') }}"></script>
	<script src="{{ asset('assets/js/neon-chat.js') }}"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="{{ asset('assets/js/neon-custom.js') }}"></script>


	<!-- Demo Settings -->
	<script src="{{ asset('assets/js/neon-demo.js') }}"></script>
    @stack('scripts')

</body>
</html>