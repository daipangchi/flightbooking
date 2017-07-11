@extends('layout.flight')

@section('title')
<title>Hitta flygresor till destinationer runt hela världen - {{ DOMAIN_NAME }}</title>
@stop

@section('body')
    <div class="inner destination-box">

        <header class="header">
            <h1>Destinationer</h1>
        </header>

        @foreach($popularDestinations as $row)
            <ul class="destinations-list clearfix">
                @foreach($row as $letter => $items)
                    <li class="left letter-holder links">
                        <h5>{{ $letter }}</h5>
                        <ul>
                            @foreach($items as $item)
                                <li><a href="{{ internal_link_from_slug($item->slug) }}">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @endforeach

    </div>
@stop

@section('additional-foot-blocks')
    @include('flight.search.additional')
@stop