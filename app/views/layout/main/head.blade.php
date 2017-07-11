@section('title')
<title>Flygresor - jämför och sök billiga flyg - {{ DOMAIN_NAME }}</title>
@show

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

@section('meta')
<meta name="description" content="När du besöker flygresor.com skall du alltid hitta de lägsta priserna på flyg, detta sker genom att vi söker igenom alla flygbolag och researrangörer så att du enkelt kan jämföra resor.">
@show

@section('common-styles')
<link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600' rel='stylesheet' type='text/css'>

<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<!--<link href="{{ asset('assets/css/owl.carousel.css') }}" rel="stylesheet">-->
<link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/progressBar.css') }}" rel="stylesheet">

<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

<link href="{{ asset('assets/css/style.css') }}?v=2.1" rel="stylesheet">

<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-migrate-1.2.1.min.js') }}"></script>

<script type='text/javascript'>
		var googletag = googletag || {};
		googletag.cmd = googletag.cmd || [];
		(function() {
		var gads = document.createElement('script');
		gads.async = true;
		gads.type = 'text/javascript';
		var useSSL = 'https:' == document.location.protocol;
		gads.src = (useSSL ? 'https:' : 'http:') + 
		'//www.googletagservices.com/tag/js/gpt.js';
		var node = document.getElementsByTagName('script')[0];
		node.parentNode.insertBefore(gads, node);
		})();
	</script>

	<script type="text/javascript">
		var gptAdSlots = [];

		googletag.cmd.push(function() {

			var topMapping = googletag.sizeMapping()
				.addSize([1000, 0], [[980, 250], [980, 140], [980, 240], [728, 90], [980, 120], [970, 250], [930, 180]])
				.addSize([748, 0], [[728, 90], [700, 120]])
				.addSize([0, 0], [[320, 50], [320, 100], [320, 320], [300,250], [250, 250], [250, 240], [300, 100]])
				.build();

			var leftMapping = googletag.sizeMapping()
				.addSize([1000, 0], [[250, 240], [250, 250], [250, 360], [250, 480], [250, 120], [250, 260]])
				.addSize([769, 0], [])
				.addSize([748, 0], [[728, 90], [700, 120]])
				.addSize([0, 0], [[320, 50], [320, 100], [320, 320], [300,250], [250, 250], [250, 240], [300, 100]])
				.build();

			var asideMappingOne = googletag.sizeMapping()
				.addSize([1280, 0], [[300, 250], [300, 360], [300, 400], [300, 600], [300, 1050]])
				.addSize([1000, 0], [[160, 600], [160, 300]])
				.addSize([0, 0], [])
				.build();

			var asideMappingTwo = googletag.sizeMapping()
				.addSize([1280, 0], [[300, 360], [300, 250], [300, 600], [300, 400], [300, 1050]])
				.addSize([1000, 0], [160, 300])
				.addSize([0, 0], [])
				.build();

			gptAdSlots[0] = googletag.defineSlot('/1066982/flygresorcom_top', [320, 320], 'div-gpt-ad-1453110867561-0')
				.defineSizeMapping(topMapping)
				.addService(googletag.pubads());

			gptAdSlots[1] = googletag.defineSlot('/1066982/flygresorcom_left', [250, 250], 'div-gpt-ad-1453114318632-0')
				.defineSizeMapping(leftMapping)
				.addService(googletag.pubads());

			gptAdSlots[2] = googletag.defineSlot('/1066982/flygresorcom_right_1', [300, 600], 'div-gpt-ad-1453114648577-0')
				.defineSizeMapping(asideMappingOne)
				.addService(googletag.pubads());

			gptAdSlots[2] = googletag.defineSlot('/1066982/flygresorcom_right_2', [300, 250], 'div-gpt-ad-1453114664838-0')
				.defineSizeMapping(asideMappingTwo)
				.addService(googletag.pubads());

			googletag.enableServices();
		});
	</script>

@show

@yield('custom-styles')