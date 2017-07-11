@extends('layout.flight')

@section('body')
    <div class="inner">
        @include('flight.index.slider')
        @include('flight.index.article1')
        @include('flight.index.article2')
        @include('flight.index.article3')
        @include('flight.index.article4')
        @include('flight.index.newsletter')
    </div>
@stop

@section('additional-foot-blocks')
    @include('flight.search.additional')
@stop