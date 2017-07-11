<!DOCTYPE html>
<html class="load-full-screen">
<head>
	@include('layout.main.head')
</head>

<body class="load-full-screen">
    <div id="site-wrapper" class="site-wrapper">
        @include('layout.main.header')
        @include('flight.search.form')

        <!-- START: LISTING AREA-->
        <div class="row main-content">
            <div class="container md-clear-padding">
                <div class="row container-box">
                    <div class="col-md-9 right-content pull-right">
                        @yield('body')
                    </div>
                    <div class="col-md-3 sidebar pull-left">
                        @yield('sidebar')
                    </div>
                </div>
            </div>
        </div>
        
        @include('layout.main.footer')
    </div>

	<div class="ui-optin-wrapper"></div>

    @yield('additional-foot-blocks')
    @include('layout.main.foot')
    @include('layout.main.footer.google_anaytics')
    @include('layout.main.footer.facebook_pixel')

    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/sv_SE/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>