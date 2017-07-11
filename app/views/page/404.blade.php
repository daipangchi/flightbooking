@extends('layout.flight')

@section('title')
<title>Sidan kunde inte hittas - {{ DOMAIN_NAME }}</title>
@stop

@section('body')
    <div class="inner">
        <p class="large-para text-center"><span class="fa fa-chain-broken"></span>404</p>
        <div class="text-center desc">
            <h1>Page Not Found</h1>
            <p>Looks like you are lost.</p>
        </div>
    </div>
@stop

@section('additional-foot-blocks')
    @include('flight.search.additional')
@stop