<!DOCTYPE html>
<html class="load-full-screen">
<head>
	@include('layout.main.head')
</head>
<body class="load-full-screen">
    <div id="site-wrapper" class="site-wrapper">
        @include('layout.main.header')
        
	    @yield('body')
        
        @include('layout.main.footer')
    </div>

	<div class="ui-optin-wrapper"></div>

    @yield('additional-foot-blocks')

    @include('layout.main.foot')
    @include('layout.main.footer.google_anaytics')
    @include('layout.main.footer.facebook_pixel')
</body>
</html>