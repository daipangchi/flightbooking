@section('footer')
<section id="footer">
    <footer>
        <div class="main-footer row">
            <div class="container">
                <div class="col-md-4 col-sm-6 about-box widget">
                    <a href="{{ route('home.index') }}"><img src="{{ asset('assets/images/logo-yellow.png') }}"/></a>
                </div>

                <div class="col-md-3 col-sm-6 links widget">
                    <h4>NAVIGERING</h4>
                    <ul>
                        <li><a href="{{ route('home.index') }}">Hem</a></li>
                        <li><a href="/destinationer/">Populära resmål</a></li>                        
                        <li><a href="#">Flygresor</a></li>
                        <li><a href="{{ internal_link_from_url(route('page.gravid')) }}">Att flyga gravid</a></li>
                        <li><a href="{{ internal_link_from_url(route('page.flygradsla')) }}">Att övermanna sin flygrädsla</a></li>
                        <li><a href="{{ internal_link_from_url(route('page.omoss')) }}">Om oss</a></li>
                        <li><a href="http://annonswebb.qualityunlimited.com/sv-se/brands/flygresor-com-1693" target="_blank">Annonsera</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6 socials widget">
                    <h4>SOCIAL MEDIA</h4>
                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com/Flygresorcom-216719598470056/"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                </div>

                <div class="col-md-2 col-sm-6 contacts widget">
                    <h4>KONTAKT</h4>
                    <p>Westcoast Digital AB</p>
                    <p>Flygresor.com</p>
                    <p>Magasinsgatan 2</p>
                    <p>461 30 Trollhättan</p>
                    <p>0520-15000</p>
                </div>
            </div>
        </div>
    </footer>
</section>
@show