<?php
$dateFrom = $params['start'];
$dateTo = $params['end'];
?>

@if(isset($destination->id))
<div class="flight-list-view hotel-banner">
    <p class="hotel-notice text-center"><a href="{{ $destination->getLink(mydate('Y-m-d', $dateFrom), mydate('Y-m-d', $dateTo)) }}" onclick="ga('send', 'event', 'Utgaende klick', 'Hotell', '{{ $destination->path_name }}', { transport: 'beacon'})" target="_blank" style="color:#323232;">Se de bästa erbjudanden på <strong>hotell i {{ $destination->path_name }}</strong> från {{ mydate('j F', $dateFrom) }} till {{ mydate('j F', $dateTo) }} <span style="font-weight:bold;color:#49ae47;">Från {{ $destination->min_price }} kr!</span></a></p>

    <div class="row">
        <div class="col-xs-3 col-xxs-4  clear-padding text-center row-item">
            <a href="{{ $destination->getLink(mydate('Y-m-d', $dateFrom), mydate('Y-m-d', $dateTo)) }}" onclick="ga('send', 'event', 'Utgaende klick', 'Hotell', '{{ $destination->path_name }}', { transport: 'beacon'})" target="_blank"><img src="{{ asset('assets/images/hotels/trivagopic1.jpg') }}" style="width:100%;"></a>
        </div>
        <div class="col-xs-6 col-xxs-8 text-center row-item">
            <div><a href="{{ $destination->getLink(mydate('Y-m-d', $dateFrom), mydate('Y-m-d', $dateTo)) }}" onclick="ga('send', 'event', 'Utgaende klick', 'Hotell', '{{ $destination->path_name }}', { transport: 'beacon'})" target="_blank"><img src="{{ asset('assets/images/hotels/trivago-logo.png') }}"></a></div>
            <a class="btn btn-success btn-lg" href="{{ $destination->getLink(mydate('Y-m-d', $dateFrom), mydate('Y-m-d', $dateTo)) }}" onclick="ga('send', 'event', 'Utgaende klick', 'Hotell', '{{ $destination->path_name }}', { transport: 'beacon'})" target="_blank">Ta mig till hotellen</a>
        </div>
        <div class="col-xs-3 clear-padding text-center row-item xs-hidden">
            <a href="{{ $destination->getLink(mydate('Y-m-d', $dateFrom), mydate('Y-m-d', $dateTo)) }}" onclick="ga('send', 'event', 'Utgaende klick', 'Hotell', '{{ $destination->path_name }}', { transport: 'beacon'})" target="_blank"><img src="{{ asset('assets/images/hotels/trivagopic2.jpg') }}" style="width:100%;"></a>
        </div>
    </div>
</div>
@endif