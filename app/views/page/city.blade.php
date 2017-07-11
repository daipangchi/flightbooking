@extends('layout.city')

@section('title')
<title>
    @if($city->destination == 1)
        Flygresor till {{ $city->name }}, hitta billigt flyg - {{ DOMAIN_NAME }}
    @else
        Kampanj på flyg från Köpenhamn - {{ DOMAIN_NAME }}
    @endif
</title>
@stop

@section('sidebar')
    @if($city->destination == 1)
        <div class="widget destination-information">
            <header class="header"><h3>{{ $city->name }}</h3></header>
            <p>{{ $city->short_description }}</p>
         </div>
    @endif

    <div class="widget social-facebook">
        <header class="header"><h3>Facebook</h3></header>
        <div style="float: left; width: 60px;" class="fb-like" data-href="http://www.facebook.com/pages/Flygresorcom/216719598470056" data-send="false" data-layout="box_count" data-width="60" data-show-faces="true"></div>
        <p>Gilla oss på Facebook så du inte missar några erbjudanden!</p>
    </div>

    @if(count($destinationFeed))
    <div class="widget destination-feed">
        <header class="header"><h3>Charterflyg</h3></header>

        <div style="border:1px solid #ddd;padding:10px;">
            @foreach($destinationFeed as $row)
                <div class="row">
                    <div class="col-xs-6 clear-padding">
                        {{ $row->departure_airport_name }}<br/>
                        &rightarrow; <a href="{{ get_affliate_booking_url($row) }}" target="_blank">{{ $row->dname }}</a>
                    </div>

                    <div class="col-xs-6 clear-padding text-right">
                        {{ mydate('Y-m-d', $row->departure_date) }}<br/>
                        <span style="color:red;">{{ $row->price }} kr</span>
                    </div>
                </div>
                <hr style="border-style:dotted;margin:5px;"/>
            @endforeach

            <div class="text-right">
                <a href="http://www.sistaminutenresor.com" target="_blank"><b>www.sistaminutenresor.com</b></a>
            </div>
        </div>
    </div>
    @endif
@stop

@section('body')
    <article class="entry" style="min-height:350px;">

        @if($city->destination == 1)
            <header class="header"><h3>FLYGRESOR till {{ $city->name }}</h3></header>
            <div class="offers-list">
                <p>Använd sökrutan ovanför för att hitta billiga flygresor till {{ $city->name }}. Vi söker bland hundratals flygbolag och ca 70 olika researrangörer, allt för att du ska hitta det bästa, snabbaste och billigaste flyget!</p>
            </div>

            <div id="information">
                <header class="header"><h3>Information om staden</h3></header>

                {{ $city->description }}
                <div style="margin: 0 auto; text-align: center; max-width: 800px;">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Flygresor responsive -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-9945143309479835"
                         data-ad-slot="9997965889"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>

        @else
            <header class="header"><h3>FLYGRESOR från {{ $city->name }}</h3></header>
            <div class="offers-list">
                <p>Tyvärr fanns det inga kampanjer från {{ $city->name }} men sök gärna flyg i sökrutan.</p>
            </div>
        @endif

    </article>

    
@stop

@section('additional-foot-blocks')
    @include('flight.search.additional')
@stop